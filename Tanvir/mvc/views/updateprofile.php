<?php
session_start();
require '../model/data.php';
require_login();

$userData = profile($_SESSION['user']);
$errors = flash_get('profile_errors') ?? [];
$gender = strtolower($userData['gender'] ?? '');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>update profile </title>
    <script type="text/javascript" src="js/updateprofile.js"></script>
</head>

<body>
    <center>
        <h3>Profile</h3>
        <?php foreach ($errors as $message): ?>
            <p style="color: crimson;"><?php echo e($message); ?></p>
        <?php endforeach; ?>
        <table>
            <tr>
                <td>
                    <fieldset>
                        <legend>Profile :</legend>
                        <form novalidate method="POST" action="../controllers/updateprofileaction.php" onsubmit="return upvalidate();">
                            <table>
                                <tr>
                                    <td><b><label for="doctor_ID">Doctor ID </label></b></td>
                                    <td>: <input readonly id="doctor_ID" type="text" value="<?php echo e($userData['doctorID'] ?? ''); ?>"></td>
                                </tr>
                                <tr><td><br></td></tr>
                                <tr>
                                    <td><b><label for="fullname">Full Name </label></b></td>
                                    <td>: <input id="fullname" name="fullname" type="text" value="<?php echo e($userData['fullname'] ?? ''); ?>"></td>
                                </tr>
                                <tr><td><br></td></tr>
                                <tr>
                                    <td><b><label for="email">Email</label></b></td>
                                    <td>: <input id="email" name="email" type="text" value="<?php echo e($userData['email'] ?? ''); ?>"></td>
                                </tr>
                                <tr><td><br></td></tr>
                                <tr>
                                    <td><b><label for="gender">Gender </label></b></td>
                                    <td>:
                                        <select id="gender" name="gender">
                                            <option value="male" <?php echo $gender === 'male' ? 'selected' : ''; ?>>Male</option>
                                            <option value="female" <?php echo $gender === 'female' ? 'selected' : ''; ?>>Female</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr><td><br></td></tr>
                                <tr>
                                    <td><b><label for="mobile">Phone no</label></b></td>
                                    <td>: <input id="mobile" name="mobile" type="text" value="<?php echo e($userData['mobile'] ?? ''); ?>"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><button type="submit" name="update">Save</button></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><a href="../views/profile.php">Cancel</a> &middot; <a href="../views/changepassword.php">Change password</a></td>
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
