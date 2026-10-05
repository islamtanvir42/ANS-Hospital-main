<?php
// Connection settings. The defaults suit a local XAMPP install; set the ANS_DB_*
// environment variables to point at a different server without editing this file.
$server       = getenv('ANS_DB_HOST') ?: 'localhost';
$dbUser       = getenv('ANS_DB_USER') ?: 'root';
$dbPassword   = getenv('ANS_DB_PASS') ?: '';
$databaseName = getenv('ANS_DB_NAME') ?: 'mydata';

// Report failures through return values, not exceptions, so the pages can show
// a clean message instead of a stack trace.
mysqli_report(MYSQLI_REPORT_OFF);

$data = new mysqli($server, $dbUser, $dbPassword, $databaseName);

if ($data->connect_error) {
    error_log('ANS Hospital: database connection failed: ' . $data->connect_error);
    http_response_code(500);
    die('Could not connect to the database. Check the settings in model/database_connection.php.');
}

$data->set_charset('utf8mb4');
