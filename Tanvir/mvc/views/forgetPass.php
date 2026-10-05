<?php
session_start();
require_once '../model/helpers.php';
$message = flash_get('forgot_message'); // [kind, text]
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>forget password</title>
    <style>
        /* Optional styling */
        .input-field {
            margin-bottom: 20px;
        }
        .input-field input {
            width: 100px; /* Adjust width as needed */
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <form novalidate method="POST" action="../controllers/forgetPassAction.php">
        <div class="input-field">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email">
        </div>
        <?php if ($message): ?><p><?php echo e($message[1]); ?></p><?php endif; ?>
        <button type="submit">Submit</button>
        <a href="login.php">Back to login</a>
    </form>
</body>
</html>
