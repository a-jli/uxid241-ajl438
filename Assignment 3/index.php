<?php
    declare(strict_types=1);
    var_dump($_GET);
    var_dump($_POST);

    require 'config.php';
    
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    function getRowNumber(mysqli $conn): void {
        $result = mysqli_query($conn, 'SELECT COUNT(*) AS total FROM assignment_3');
        $row = mysqli_fetch_assoc($result);
        echo "Rows: " . $row['total'];   // should print 40
    }

    $result = mysqli_query($conn, 'SELECT title, description from assignment_3');
    $recipes = mysqli_fetch_all($result);

   function e(string $value): string { 
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); 
    } 
?>
W
<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UXID 241 Cookbook Assignment 3</title>
</head>
<body>
    <h2>Row Number:</h2>
    <?php getRowNumber($conn); ?>
    <ul>
        <?php 
            foreach ($recipes as $recipe):?> <br>
            <li><?php e($recipe('title')); ?></li> 
        <?php endforeach; ?>
    </ul>
</body>
</html>

