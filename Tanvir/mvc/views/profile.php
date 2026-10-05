<?php
session_start();
require '../model/data.php';
require_login();

$userData = profile($_SESSION['user']);
$notice = flash_get('profile_notice');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Doctor Profile</title>
</head>

<body style="background-color: aquamarine;">
    <center>
        <h3>Profile</h3>
        <?php if ($notice): ?><p><?php echo e($notice); ?></p><?php endif; ?>
        <table>
            <tr>
                <td>
                    <fieldset>
                        <legend>Profile :</legend>
                        <form novalidate method="GET">
                            <table>
                                <tr>
                                    <td><b><label for="doctor_ID">Doctor ID </label></b></td>
                                    <td>: <input readonly id="doctor_ID" type="text" value="<?php echo e($userData['doctorID'] ?? ''); ?>"></td>
                                </tr>
                                <tr><td><br></td></tr>
                                <tr>
                                    <td><b><label for="fullname">Full Name </label></b></td>
                                    <td>: <input readonly id="fullname" type="text" value="<?php echo e($userData['fullname'] ?? ''); ?>"></td>
                                </tr>
                                <tr><td><br></td></tr>
                                <tr>
                                    <td><b><label for="email">Email</label></b></td>
                                    <td>: <input readonly id="email" type="text" value="<?php echo e($userData['email'] ?? ''); ?>"></td>
                                </tr>
                                <tr><td><br></td></tr>
                                <tr>
                                    <td><b><label for="gender">Gender </label></b></td>
                                    <td>: <input readonly id="gender" type="text" value="<?php echo e($userData['gender'] ?? ''); ?>"></td>
                                </tr>
                                <tr><td><br></td></tr>
                                <tr>
                                    <td><b><label for="mobile">Phone no</label></b></td>
                                    <td>: <input readonly id="mobile" type="text" value="<?php echo e($userData['mobile'] ?? ''); ?>"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><button formaction="../views/updateprofile.php" name="update">Update</button></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><a href="../views/dashbord.php">Back to dashboard</a></td>
                                </tr>
                            </table>
                        </form>
                    </fieldset>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>
