<?php
declare(strict_types=1);

$config = require_once 'config.php';

//throw an exception if something goes wrong
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);



try{
    $conn = mysqli_connect( //mysqli_connect takes host, un, pw, db name
    $config['db_host'], 
    $config['db_user'], 
    $config['db_pass'], 
    $config['db_name'],
    (int) $config['db_port']
    );
mysqli_set_charset($conn, 'utf8mb4'); //so connection handles all characters including emoji.
} catch (mysqli_sql_exception $e) { //$e holds exception object
    http_response_code(500);
    exit('Connection failed: ' . $e->getMessage());
} 
?>