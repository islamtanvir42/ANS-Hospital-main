<?php
session_start();
require '../model/data.php';
require_login();

$message = flash_get('pw_message'); // [kind, text]
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change password - ANS Hospital</title>
    <script type="text/javascript" src="js/chnagepassword.js"></script>
</head>

<body style="background-color: rgb(13 148 136);">
    <form action="../controllers/changepasswordaction.php" method="POST" novalidate onsubmit="return changevalidate();">
        <br><br><br><br><br><br>
        <div>
            <center>
                <br><br>
                <table>
                    <tr>
                        <td>
                            <fieldset>
                                <center>
                                    <table>
                                        <tr>
                                            <td>
                                                <label style="color: rgb(251 146 60)" for="currentpassword">Current Password:</label><br>
                                                <input type="password" id="currentpassword" name="currentpassword" autocomplete="current-password"><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label style="color: rgb(251 146 60)" for="newpassword">New Password:</label><br>
                                                <input type="password" id="newpassword" name="newpassword" autocomplete="new-password"><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <button style="background-color: rgb(131 24 67); color: whitesmoke" type="submit">submit</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 style="color: blue;">
                                                    <?php if ($message): ?><span><?php echo e($message[1]); ?></span><br><?php endif; ?>
                                                </h4>
                                                <a href="../views/dashbord.php">Back to dashboard</a>
                                            </td>
                                        </tr>
                                    </table>
                                </center>
                            </fieldset>
                        </td>
                    </tr>
                </table>
            </center>
        </div>
    </form>
</body>
</html>
