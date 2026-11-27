<?php
    declare(strict_types=1);
    require 'inc/database.php';
    require 'inc/functions.php'; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = post_value('email');
        $plain = $_POST['password'] ?? '';
        $hash = password_hash($plain, PASSWORD_DEFAULT);

        try {
            mysqli_execute_query(
                $conn,
                'INSERT INTO cookbook_users (email, password_hash) VALUES (?, ?)',
                [$email, $hash]
            );
            header('Location: login.php');
            exit;
        } catch (mysqli_sql_exception $e) {
            $error = 'That email is already registered.';
        }
        }

$root = '';
require 'inc/header.php';
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

    <main>
        <br><br>
        <div class="text-wrapper">        
            <div class="recipe-wrapper smallgap">
        <br>
        <h1>Register</h1>
        <br>
        <form class="no-gap register-login" method = "post">
            <input type="email" name="email" placeholder="email" required>
            <input class="flip" type="password" name="password" placeholder="password" required>
            <button class="left-flat" type="submit">Submit</button>
        </form> 
        <br>  
        <?php if (!empty($error)): ?>
            <p class="red centered"><?= e($error) ?></p>
        <?php endif; ?>
        </div>
        </div>


    </main>
</body>
</html>
