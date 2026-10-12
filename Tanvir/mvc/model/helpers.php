<?php
// Small helpers shared by the views and controllers.

/** Escape a value for safe output inside HTML. Use on everything read from the database or the user. */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/** One-shot messages that survive a redirect and are shown once. Needs session_start(). */
function flash_set(string $key, $value): void
{
    $_SESSION['flash'][$key] = $value;
}

function flash_get(string $key)
{
    $value = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $value;
}

/** Send visitors without a session back to the sign-in page. Works from both views/ and controllers/. */
function require_login(): void
{
    if (empty($_SESSION['logged'])) {
        header('Location: ../views/login.php');
        exit();
    }
}

/** Rules for a new password. Returns a list of problems; empty means it is acceptable. */
function password_problems(string $password): array
{
    $problems = [];
    if ($password === '') {
        return ['Please enter a password.'];
    }
    if (strlen($password) < 4) {
        $problems[] = 'Password must be at least 4 characters long.';
    }
    if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $problems[] = 'Password must be a combination of letters and numbers.';
    }
    return $problems;
}
