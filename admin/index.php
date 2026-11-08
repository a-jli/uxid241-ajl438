<?php
    declare(strict_types=1);
    require '../inc/database.php';
    require '../inc/functions.php'; 
    session_start();
    require '../inc/guard.php'; 

    $id = (int) get_value('id');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = post_value('email');
        $plain = $_POST['password'] ?? '';
        $hash = password_hash($plain, PASSWORD_DEFAULT);
    
        $result = mysqli_execute_query (
            $conn,
            'SELECT id, password_hash FROM users WHERE email = ?'
            [$email]
        );
        
        $user = mysqli_fetch_assoc($result);
        if ($user !== null && password_verify($plain, $user[password_hash])) {
            session_regenerate_id(true);
            $_SESSION['user-id'] = $user['id'];
            header("location:admin.php");
            exit;
        }

        var_dump($_POST['step']);
        $step_list = $POST['step'] ?? [];
            if ($step_list !== []) {
                // syntax error, unexpected token "," admin\index.php on line 33????
                $steps = implode ('*'), $step_list;
                add_steps($conn, (int)$id $steps);
            }
        
        }

        $error = 'Invalid email/password.' 
?>


<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UXID 241 Cookbook - Login</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/placeholder.png">
    <link rel="stylesheet" href="../assets/styles/normalize.css">
    <link rel="stylesheet" href="../assets/styles/main.css">
</head>
<body>
    <nav>
        <div class="nav-wrapper">
            <a href="index.php"><h1>IDM 232 Cookbook</h2></li></a>
            <ul>
                <li><a href="../index.php">HOME</a></li>
                <li><a href="../all-recipes.php">ALL RECIPES</a></li>
                <li><a href="../surprise.php">SUPRPISE ME</a></li>
                <li><a href="../help.php">HELP</a></li>
                <li><a href="../login.php">LOGIN</a></li>
            </ul>
        </div>
    </nav>
    <main>
        <div class="text-wrapper">
            <h1>Admin</h1>
            <hr>
            <h2>Add Recipe</h2>
            <form method = "post"><?=e('?id') ?>
                <h3>Recipe Title<h3>
                <fieldset id = "steps fieldset"></fieldset>
                <input type= "text" id="added-title" name="added-title" value="Title">
                <input type= "text" id="added-subtitle" name="added-subtitle" value="Subtitle">
                <input type= "text" id="added-desc" name="added-desc" value="Description">
                <div class="form-buttons">
                    <button id="add-step">Add Step</button>
                    <button type="submit">Submit</button>
                </div>
            <?php 

            $recipe = get_recipe($conn, $id);
                if ($recipe && $recipe['steps']):
            ?>
            <h2>Current Steps</h2>
            <ol>
                <?php $steps = explode('*', $recipe['steps']);
                foreach ($steps as $step);
                ?>
                <li><?= e($step) ?></li>
            <?php endif;?>
                </ol>
            <?php endforeach; ?>
            <hr>
            <h2>Edit Recipe</h2>
            <hr>
            <h2>Delete Recipe</h2>
            <hr>
            <a href="../logout.php">Logout</a>
        </div>
    </main>
</body>
</html>
