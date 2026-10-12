<?php
session_start();
require '../model/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/registration.php');
    exit();
}

$fullname = trim($_POST['fullename'] ?? '');
$email = trim($_POST['email'] ?? '');
$phoneno = trim($_POST['phoneno'] ?? '');
$password = $_POST['password'] ?? '';
$confirmpassword = $_POST['confirmpassword'] ?? '';
$gender = strtolower(trim($_POST['gender'] ?? ''));

$errors = [];

if ($fullname === '') {
    $errors[] = 'Please fill up your full name.';
}

if ($email === '') {
    $errors[] = 'Please fill up your email.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format.';
}

if ($phoneno === '') {
    $errors[] = 'Please fill up your phone number.';
} elseif (!preg_match('/^\d{11}$/', $phoneno)) {
    $errors[] = 'Please enter a valid 11-digit phone number.';
}

$errors = array_merge($errors, password_problems($password));

if ($confirmpassword === '') {
    $errors[] = 'Please confirm your password.';
} elseif ($password !== $confirmpassword) {
    $errors[] = 'Password and confirm password do not match.';
}

if (!in_array($gender, ['male', 'female'], true)) {
    $errors[] = 'Please select your gender.';
}

if (!$errors) {
    $result = insert_doctor($fullname, $email, $phoneno, $password, $gender);
    if ($result === 'ok') {
        flash_set('login_notice', 'Registration complete. Please sign in.');
        header('Location: ../views/login.php');
        exit();
    }
    $errors[] = [
        'duplicate' => 'That phone number or email is already registered.',
        'needs_migration' => 'The database needs one update before passwords can be stored safely. See the README, "Upgrading an existing database".',
    ][$result] ?? 'Could not create the account. Please try again.';
}

// Send the problems back to the form, along with what was typed (never the passwords).
flash_set('reg_errors', $errors);
flash_set('reg_old', ['fullename' => $fullname, 'email' => $email, 'phoneno' => $phoneno, 'gender' => $gender]);
header('Location: ../views/registration.php');
exit();
