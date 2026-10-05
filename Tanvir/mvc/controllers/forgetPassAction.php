<?php
session_start();
require '../model/data.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/forgetPass.php');
    exit();
}

// A password must never be shown on a page. Passwords are now stored as hashes
// and cannot be read back at all. Without an email service, recovery is a
// request to an administrator, and the answer is the same whether or not the
// email is registered so the form cannot be used to find out who has an account.
$email = trim($_POST['email'] ?? '');

if ($email === '') {
    flash_set('forgot_message', ['error', 'Please enter your email.']);
} else {
    flash_set('forgot_message', ['ok', 'If that email is registered, contact the administrator to have the password reset.']);
}

header('Location: ../views/forgetPass.php');
exit();
