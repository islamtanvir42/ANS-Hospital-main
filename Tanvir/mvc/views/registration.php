<?php
session_start();
require_once '../model/helpers.php';
$errors = flash_get('reg_errors') ?? [];
$old = flash_get('reg_old') ?? [];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Doctor Registration</title>
    <style>
        body{
            background-image: url("res.jpg");
        }
    </style>
    <script type="text/javascript" src="js/registration.js"></script>
</head>

<body>
    <center><h3 style="color: aliceblue;">ANS Hospital Management System</h3></center>
    <center>
        <table>
            <tr>
                <td>
                    <fieldset>
                        <legend style="color: aliceblue;"><i><b>Doctor Registration :</b></i></legend>

                        <form method="POST" novalidate onsubmit="return Regvalidate();">
                            <center>
                                <?php if ($errors): ?>
                                    <div style="color: yellow;">
                                        <?php foreach ($errors as $message): ?>
                                            <span><?php echo e($message); ?></span><br>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <table>
                                    <tr>
                                        <td><b><label style="color: orangered;" for="fullename">Fullname</label></b></td>
                                        <td>: <input id="fullename" name="fullename" type="text" value="<?php echo e($old['fullename'] ?? ''); ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><b><label style="color: orangered;" for="email">Email</label></b></td>
                                        <td>: <input id="email" name="email" type="text" value="<?php echo e($old['email'] ?? ''); ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><b><label style="color: orangered;" for="phoneno">Mobile No</label></b></td>
                                        <td>: <input id="phoneno" name="phoneno" type="text" value="<?php echo e($old['phoneno'] ?? ''); ?>"></td>
                                    </tr>
                                    <tr><td><br></td></tr>
                                    <tr>
                                        <td><b><label style="color: orangered;" for="password">Password</label></b></td>
                                        <td>: <input id="password" name="password" type="password" autocomplete="new-password"></td>
                                    </tr>
                                    <tr><td><br></td></tr>
                                    <tr>
                                        <td><b><label style="color: orangered;" for="confirmpassword">Confirm Password</label></b></td>
                                        <td>: <input id="confirmpassword" name="confirmpassword" type="password" autocomplete="new-password"></td>
                                    </tr>
                                    <tr>
                                        <td><br><b><label style="color: orangered;">Gender</label></b></td>
                                        <td>
                                            <br>:
                                            <input type="radio" name="gender" value="male" id="male" <?php echo ($old['gender'] ?? '') === 'male' ? 'checked' : ''; ?>>
                                            <label style="color: red;" for="male">Male</label>
                                            <input type="radio" name="gender" value="female" id="female" <?php echo ($old['gender'] ?? '') === 'female' ? 'checked' : ''; ?>>
                                            <label style="color: red;" for="female">Female</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><br><button class="button button2" type="submit" name="register" value="Register" formaction="../controllers/registration action.php">Register</button></td>
                                    </tr>
                                </table>

                                <table>
                                    <tr>
                                        <td><label style="color: rgb(253 224 71);">Do you have an account?</label></td>
                                        <td><a style="color: red;" href="../views/login.php">Login</a></td>
                                    </tr>
                                </table>
                            </center>
                        </form>
                    </fieldset>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>
