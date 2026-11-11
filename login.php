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
        <h1>Login</h1>
       <form method = "post">
            <input type="email" name="email" placeholder="email" required>
            <input type="password" name="password" placeholder="password" required>
            <button type="submit">Submit</button>
        </form>
        <a href="register.php">No Account? Register Here!</a>
        <?php if (!empty($error)): ?>
            <p><?= e($error)?> </p>
        <?php endif?>
    </main>
</body>
</html>
