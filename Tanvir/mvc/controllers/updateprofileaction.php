<?php
session_start();
require '../model/data.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/updateprofile.php');
    exit();
}

$fullname = trim($_POST['fullname'] ?? '');
$email = trim($_POST['email'] ?? '');
$mobile = trim($_POST['mobile'] ?? '');
$gender = strtolower(trim($_POST['gender'] ?? ''));

$errors = [];

if ($fullname === '') {
    $errors[] = 'Please enter your full name.';
}

if ($email === '') {
    $errors[] = 'Please fill up your email.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format.';
}

if ($mobile === '') {
    $errors[] = 'Please fill up your phone number.';
} elseif (!preg_match('/^\d{11}$/', $mobile)) {
    $errors[] = 'Please enter a valid 11-digit phone number.';
}

if (!in_array($gender, ['male', 'female'], true)) {
    $errors[] = 'Please select your gender.';
}

if (!$errors) {
    $result = update_profile($_SESSION['user'], $fullname, $email, $mobile, $gender);
    if ($result === 'ok') {
        $_SESSION['user'] = $mobile; // the phone number is the sign-in name
        flash_set('profile_notice', 'Profile updated.');
        header('Location: ../views/profile.php');
        exit();
    }
    $errors[] = $result === 'duplicate'
        ? 'That phone number is already registered to another doctor.'
        : 'Could not update the profile. Please try again.';
}

flash_set('profile_errors', $errors);
header('Location: ../views/updateprofile.php');
exit();
