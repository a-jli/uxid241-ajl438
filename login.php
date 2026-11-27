<?php
    declare(strict_types=1);
    require 'inc/database.php';
    require 'inc/functions.php'; 
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = post_value('email');
        $plain = $_POST['password'] ?? '';
        $hash = password_hash($plain, PASSWORD_DEFAULT);
    
        $result = mysqli_execute_query (
            $conn,
            'SELECT id, password_hash FROM cookbook_users WHERE email = ?',
            [$email]
        );
        
        $user = mysqli_fetch_assoc($result);

        if ($user !== null && password_verify($plain, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];

            header("Location: admin/index.php");
            exit;
        } else {
            $error = 'Invalid email or password.';  
        }}
        
$root = '';
require 'inc/header.php';
         
?>


<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UXID 241 Cookbook - Login</title>
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
            <h1>Login</h1>
            <br>
            <form class="no-gap register-login" method = "post">
                <input type="email" name="email" placeholder="email" required>
                <input class="flip" type="password" name="password" placeholder="password" required>
                <button class="left-flat" type="submit">Submit</button>
            </form>
            <br>
            <a href="register.php">No Account? Register Here!</a>
            <?php if (!empty($error)): ?>
                <p><?= e($error)?> </p>
            <?php endif?>
        </div>
        </div>

    </main>
</body>
</html>
