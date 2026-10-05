<?php
session_start();
require '../model/data.php';
require_login();

// A doctor sees their own account only, not everyone else's salary and balance.
$doctor = profile($_SESSION['user']);
$salarys = $doctor ? salary_for_doctor($doctor['doctorID']) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Account</title>
</head>

<body style="background-color: rgb(192 132 252);">
    <br><br><br><br><br>
    <center><h4>Account</h4></center>
    <center>
        <table border="1">
            <thead>
                <tr>
                    <th>Doctor ID</th>
                    <th>View Salary</th>
                    <th>Current Balance</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($salarys as $salary): ?>
                    <tr>
                        <td><?php echo e($salary['doctorID']); ?></td>
                        <td><?php echo e($salary['view_salary']); ?></td>
                        <td><?php echo e($salary['current_balance']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br><br><br>
    </center>
</body>
</html>
