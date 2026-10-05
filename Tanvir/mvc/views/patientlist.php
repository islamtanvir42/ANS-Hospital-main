<?php
session_start();
require '../model/data.php';
require_login();
$patients = patientlist();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient List</title>
</head>

<body style="background-color: yellow;">
    <br><br><br><br><br>
    <center><h4 style="color: crimson;">Patient List</h4></center>
    <center>
        <table border="1">
            <thead>
                <tr>
                    <th style="color: rgb(14 165 233);">Patient ID</th>
                    <th style="color: rgb(14 165 233);">Patient name</th>
                    <th style="color: rgb(14 165 233);">Gender</th>
                    <th style="color: rgb(14 165 233);">Age</th>
                    <th style="color: rgb(14 165 233);">Phone no</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?php echo e($patient['patient_ID']); ?></td>
                        <td><?php echo e($patient['patient_name']); ?></td>
                        <td><?php echo e($patient['gender']); ?></td>
                        <td><?php echo e($patient['patient_age']); ?></td>
                        <td><?php echo e($patient['mobile_no']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br><br><br>
    </center>
</body>
</html>
