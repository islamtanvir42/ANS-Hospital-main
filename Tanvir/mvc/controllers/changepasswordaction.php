<?php
session_start();
require '../model/data.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/changepassword.php');
    exit();
}

// The password is changed for the doctor who is signed in - never for a number
// typed into a form - and only after they prove they know the current one.
$current = $_POST['currentpassword'] ?? '';
$new = $_POST['newpassword'] ?? '';

if ($current === '' || $new === '') {
    flash_set('pw_message', ['error', 'All the fields must be filled up.']);
} elseif ($problems = password_problems($new)) {
    flash_set('pw_message', ['error', implode(' ', $problems)]);
} else {
    $result = change_password($_SESSION['user'], $current, $new);
    $messages = [
        'ok' => ['ok', 'Password changed successfully.'],
        'wrong_password' => ['error', 'The current password is not correct.'],
        'needs_migration' => ['error', 'The database needs one update before passwords can be stored safely. See the README.'],
    ];
    flash_set('pw_message', $messages[$result] ?? ['error', 'Password change failed.']);
}

header('Location: ../views/changepassword.php');
exit();
