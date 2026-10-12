<?php
session_start();
require '../model/data.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error_login'] = 'Invalid Request';
    header('Location: ../views/login.php');
    exit();
}

// The phone number is trimmed. The password is used exactly as typed: running
// it through htmlspecialchars() would change what the doctor actually entered.
$phone = trim($_POST['phoneno'] ?? '');
$password = $_POST['password'] ?? '';

if ($phone === '' || $password === '') {
    $_SESSION['error_login'] = 'Please fill up all fields';
    header('Location: ../views/login.php');
    exit();
}

if (login($phone, $password)) {
    session_regenerate_id(true); // a new session id on sign-in blocks session fixation
    $_SESSION['logged'] = true;
    $_SESSION['user'] = $phone;
    unset($_SESSION['error_login']);
    header('Location: ../views/dashbord.php');
    exit();
}

$_SESSION['error_login'] = 'Username or password incorrect';
header('Location: ../views/login.php');
exit();
