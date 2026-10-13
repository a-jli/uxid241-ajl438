<?php
declare(strict_types=1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try{
          $conn = mysqli_connect(
            $config['db_host'], 
            $config['db_user'], 
            $config['db_pass'], 
            $config['db_name'],
            (int) $config['db_port']
        );
    } catch (mysqli_sql_exception $e) {
        http_response_code(500);
        exit('Connection failed: ' . $e->getMessage());
    } //e hold exception object
   
    mysqli_set_charset($conn, 'utf8mb4');
    
    if($conn){
        echo"You are connected!<br />";
    }

?>