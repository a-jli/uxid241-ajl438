<?php
    declare(strict_types=1);
    require 'inc/database.php';
    //^ 
    //$conn =  require 'inc/database.php'; gave this error:
    //Fatal error: Uncaught TypeError: mysqli_query(): Argument #1 ($mysql) must be of 
    // type mysqli, int given in C:\xampp\htdocs\uxid241-ajl438\inc\functions.php:43 
    // Stack trace: #0 C:\xampp\htdocs\uxid241-ajl438\inc\functions.php(43): 
    // mysqli_query(1, 'SELECT cookbook...') #1 
    // C:\xampp\htdocs\uxid241-ajl438\register.php(5): 
    // require('C:\\xampp\\htdocs...') #2 {main} thrown in 
    // C:\xampp\htdocs\uxid241-ajl438\inc\functions.php on line 43
    require 'inc/functions.php'; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = post_value('email');
        $plain = $_POST['password'] ?? 
        $hash = password_hash($plain, PASSWORD_DEFAULT);

        mysqli_execute_query(
            $conn,
            'INSERT INTO cookbook_users (email, password_hash) VALUES (?, ?)',
            [$email, $hash]
        );
        
        header("location:login.php");
        exit;
        }
    
    try {
    mysqli_execute_query(
        $conn,
        'INSERT INTO users (email, password_hash) VALUES (?, ?)',
        [$email, $hash]
        // Warning: Undefined variable $email in C:\xampp\htdocs\uxid241-ajl438\register.php on line 33
        // Warning: Undefined variable $hash in C:\xampp\htdocs\uxid241-ajl438\register.php on line 33
    );
    } catch (mysqli_sql_exception $e) {
    $error = 'That email is already registered.';
    }
?>



<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UXID 241 Cookbook - Register</title>
    <link rel="icon" type="image/x-icon" href="assets/images/placeholder.png">
    <link rel="stylesheet" href="assets/styles/normalize.css">
    <link rel="stylesheet" href="assets/styles/main.css">
</head>
<body>
    <nav>
        <div class="nav-wrapper">
            <a href="index.php"><h1>IDM 232 Cookbook</h2></li></a>
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="all-recipes.php">ALL RECIPES</a></li>
                <li><a href="surprise.php">SUPRPISE ME</a></li>
                <li><a href="help.php">HELP</a></li>
                <li><a href="login.php">LOGIN</a></li>
            </ul>
        </div>
    </nav>
    <main>
        <h1>Register</h1>
       <form method = "post">
            <input type="email" name="email" placeholder="email" require>
            <input type="password" name="password" placeholder="pw" require>
            <button type="submit">Submit</button>

    </main>
</body>
</html>
