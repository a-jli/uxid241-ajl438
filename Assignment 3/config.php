<?php
declare(strict_types=1);

    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'idm232_db';
    $conn = '';

    try{
        $conn = mysqli_connect(
            $host, 
            $user, 
            $pass, 
            $db
        );
    } catch (mysqli_sql_exception $e) {
        http_response_code(500);
        exit('Connection failed: ' . $e->getMessage());
    } //e hold exception object

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    mysqli_set_charset($conn, 'utf8mb4');

if($conn){
    echo"You are connected!<br />";
}

?>