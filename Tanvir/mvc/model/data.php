<?php
require_once __DIR__ . '/database_connection.php';
require_once __DIR__ . '/helpers.php';

/*
 * Passwords
 * ---------
 * New passwords are stored with password_hash(). Accounts created before that
 * change still hold plain text; they keep working, and are upgraded to a hash
 * the next time the doctor signs in. The doctor.password column must be able to
 * hold a hash (VARCHAR(255)) - see database/migrate_password_column.sql.
 */

/** True when the doctor.password column is wide enough to hold a password hash. */
function password_column_fits_hash(): bool
{
    static $fits = null;
    if ($fits === null) {
        global $data;
        $sql = "SELECT CHARACTER_MAXIMUM_LENGTH FROM information_schema.COLUMNS
                WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'doctor' AND COLUMN_NAME = 'password'";
        $result = $data->query($sql);
        $row = $result ? $result->fetch_row() : null;
        $fits = $row !== null && ($row[0] === null || (int) $row[0] >= 60);
    }
    return $fits;
}

/** Hash for storage, or null when the column is too short to hold it. */
function hash_for_storage(string $password): ?string
{
    return password_column_fits_hash() ? password_hash($password, PASSWORD_DEFAULT) : null;
}

/** Check a password against what is stored: a hash, or legacy plain text. */
function stored_password_matches(string $stored, string $password): bool
{
    if (password_get_info($stored)['algo'] !== null) {
        return password_verify($password, $stored);
    }
    return hash_equals($stored, $password);
}

/** The doctor row (id and stored password) for a mobile number, or null. */
function find_doctor_credentials(string $mobile): ?array
{
    global $data;
    $stmt = $data->prepare('SELECT doctorID, password FROM `doctor` WHERE `mobile` = ?');
    if (!$stmt) {
        return null;
    }
    $stmt->bind_param('s', $mobile);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $row ?: null;
}

function login($phone, $password): bool
{
    global $data;
    $row = find_doctor_credentials((string) $phone);
    if ($row === null || !stored_password_matches($row['password'], (string) $password)) {
        return false;
    }

    // Upgrade a legacy plain-text password to a hash now that we know it is right.
    $isHash = password_get_info($row['password'])['algo'] !== null;
    if (!$isHash || password_needs_rehash($row['password'], PASSWORD_DEFAULT)) {
        $hash = hash_for_storage((string) $password);
        if ($hash !== null) {
            $stmt = $data->prepare('UPDATE `doctor` SET `password` = ? WHERE `doctorID` = ?');
            if ($stmt) {
                $stmt->bind_param('si', $hash, $row['doctorID']);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
    return true;
}

/**
 * Change a doctor's password. The current password is required.
 * Returns 'ok', 'wrong_password', 'needs_migration' or 'error'.
 */
function change_password($mobile, $currentPassword, $newPassword): string
{
    global $data;
    $row = find_doctor_credentials((string) $mobile);
    if ($row === null || !stored_password_matches($row['password'], (string) $currentPassword)) {
        return 'wrong_password';
    }
    $hash = hash_for_storage((string) $newPassword);
    if ($hash === null) {
        return 'needs_migration';
    }
    $stmt = $data->prepare('UPDATE `doctor` SET `password` = ? WHERE `doctorID` = ?');
    if (!$stmt) {
        return 'error';
    }
    $stmt->bind_param('si', $hash, $row['doctorID']);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok ? 'ok' : 'error';
}

/** A doctor's profile by mobile number, or null. The password is never returned. */
function profile($mobile): ?array
{
    global $data;
    $stmt = $data->prepare('SELECT doctorID, fullname, email, mobile, gender FROM `doctor` WHERE `mobile` = ?');
    if (!$stmt) {
        return null;
    }
    $mobile = (string) $mobile;
    $stmt->bind_param('s', $mobile);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $row ?: null;
}

/** Update a doctor's own details. Returns 'ok', 'duplicate' (mobile taken) or 'error'. */
function update_profile($currentMobile, $fullname, $email, $newMobile, $gender): string
{
    global $data;
    if ((string) $newMobile !== (string) $currentMobile && find_doctor_credentials((string) $newMobile) !== null) {
        return 'duplicate';
    }
    $stmt = $data->prepare('UPDATE `doctor` SET `fullname` = ?, `email` = ?, `mobile` = ?, `gender` = ? WHERE `mobile` = ?');
    if (!$stmt) {
        return 'error';
    }
    $currentMobile = (string) $currentMobile;
    $stmt->bind_param('sssss', $fullname, $email, $newMobile, $gender, $currentMobile);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok ? 'ok' : 'error';
}

/* ---- Read-only lists ------------------------------------------------------ */

function fetch_rows(string $sql): array
{
    global $data;
    $result = $data->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

function patientlist(): array
{
    return fetch_rows('SELECT * FROM `patient`');
}

/** The salary and balance rows for one doctor only. */
function salary_for_doctor($doctorID): array
{
    global $data;
    $stmt = $data->prepare('SELECT * FROM `salary` WHERE `doctorID` = ?');
    if (!$stmt) {
        return [];
    }
    $doctorID = (int) $doctorID;
    $stmt->bind_param('i', $doctorID);
    $stmt->execute();
    $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $rows;
}

/** Fee and follow-up rows, optionally narrowed by follow-up ID and/or doctor ID. */
function fees_followup($followupID = '', $doctorID = ''): array
{
    global $data;
    $conditions = [];
    $values = [];
    foreach (['followupID' => $followupID, 'doctorID' => $doctorID] as $column => $value) {
        $value = trim((string) $value);
        if ($value === '') {
            continue;
        }
        if (!ctype_digit($value)) {
            return []; // an ID that is not a number can match nothing
        }
        $conditions[] = "`$column` = ?";
        $values[] = (int) $value;
    }

    $sql = 'SELECT * FROM `fee_followup`' . ($conditions ? ' WHERE ' . implode(' AND ', $conditions) : '');
    $stmt = $data->prepare($sql);
    if (!$stmt) {
        return [];
    }
    if ($values) {
        $stmt->bind_param(str_repeat('i', count($values)), ...$values);
    }
    $stmt->execute();
    $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $rows;
}

function spatient_record(): array
{
    return fetch_rows('SELECT * FROM `patient_record`');
}
