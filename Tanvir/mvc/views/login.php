<?php
session_start();
require_once '../model/helpers.php';
$error = $_SESSION['error_login'] ?? null;
unset($_SESSION['error_login']);
$notice = flash_get('login_notice');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login form</title>
    <style>
        body{
            background-image: url('login.jpg');
        }
    </style>
    <script type="text/javascript" src="js/login.js"></script>
</head>

<body style=" background-color: rgb(6 182 212);">
    <div>
        <center>
            <br><br>
            <table>
                <tr>
                    <td>
                        <fieldset>
                            <center>
                                <form action="../controllers/login acton.php" method="post" novalidate onsubmit="return validate();">
                                    <label style="color: orange;" for="phoneno">Phone No.:</label><br>
                                    <input type="text" id="phoneno" name="phoneno" autocomplete="username"><br>

                                    <label style="color: orange;" for="password">Password:</label><br>
                                    <input type="password" id="password" name="password" autocomplete="current-password"><br>

                                    <h4 style="color: aqua;">
                                        <?php if ($notice): ?><span><?php echo e($notice); ?></span><br><?php endif; ?>
                                        <?php if ($error): ?><span><?php echo e($error); ?></span><br><?php endif; ?>
                                    </h4>

                                    <input style="background-color: coral; color: white;" type="submit" value="Login">

                                    <p style="color:red;">Do You Have Any Account</p>
                                    <a style="color: bisque;" href="../views/registration.php">Registration</a> <br>
                                    <a style="color: bisque;" href="../views/forgetPass.php">Forget password</a><br>
                                </form>
                            </center>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </center>
    </div>
</body>
</html>
