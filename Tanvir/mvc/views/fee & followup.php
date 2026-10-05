<?php
session_start();
require '../model/data.php';
require_login();

// The filter is a GET form, so a filtered list can be bookmarked or refreshed.
$followupID = trim($_GET['followupID'] ?? '');
$doctorID = trim($_GET['doctorID'] ?? '');
$fees = fees_followup($followupID, $doctorID);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee and Followup</title>
</head>

<body style="background-color: rgb(192 132 252);">
    <form method="get" novalidate>
        <br><br><br><br><br>
        <center>
            <h4>Filter Fee and Followup List</h4>
            <input type="text" name="followupID" placeholder="Enter Followup ID" value="<?php echo e($followupID); ?>">
            <input type="text" name="doctorID" placeholder="Enter Doctor ID" value="<?php echo e($doctorID); ?>">
            <button type="submit">Filter</button>
            <?php if ($followupID !== '' || $doctorID !== ''): ?>
                <a href="fee &amp; followup.php">Clear</a>
            <?php endif; ?>
        </center>
    </form>
    <center>
        <table border="1">
            <thead>
                <tr>
                    <th>FeeID</th>
                    <th>Doctor ID</th>
                    <th>fee</th>
                    <th>FollowUp Fee</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fees as $fee_followup): ?>
                    <tr>
                        <td><?php echo e($fee_followup['followupID']); ?></td>
                        <td><?php echo e($fee_followup['doctorID']); ?></td>
                        <td><?php echo e($fee_followup['fee']); ?></td>
                        <td><?php echo e($fee_followup['followup_fee']); ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$fees): ?>
                    <tr><td colspan="4">No matching rows.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br><br><br>
    </center>
</body>
</html>
