<?php
require_once __DIR__ . '/data.php';

/**
 * Create a doctor account. The password is stored as a hash.
 * Returns 'ok', 'duplicate' (mobile or email already registered),
 * 'needs_migration' (password column too short for a hash) or 'error'.
 */
function insert_doctor($fullname, $email, $phoneno, $password, $gender): string
{
    global $data;

    $check = $data->prepare('SELECT 1 FROM `doctor` WHERE `mobile` = ? OR `email` = ? LIMIT 1');
    if ($check) {
        $check->bind_param('ss', $phoneno, $email);
        $check->execute();
        $exists = $check->get_result()->num_rows > 0;
        $check->close();
        if ($exists) {
            return 'duplicate';
        }
    }

    $hash = hash_for_storage((string) $password);
    if ($hash === null) {
        return 'needs_migration';
    }

    $stmt = $data->prepare('INSERT INTO `doctor` (`fullname`, `email`, `mobile`, `password`, `gender`) VALUES (?, ?, ?, ?, ?)');
    if (!$stmt) {
        return 'error';
    }
    $stmt->bind_param('sssss', $fullname, $email, $phoneno, $hash, $gender);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok ? 'ok' : 'error';
}
