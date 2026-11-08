<?php
    declare(strict_types=1);
    require 'inc/database.php';
    require 'inc/functions.php';

    // $recipes = get_all_recipes($conn);
    // this doesnt do anything? the recipe stuff theyre getting is from
    //$recipes = mysqli_fetch_all($result, MYSQLI_ASSOC); and not get all recipes...
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UXID 241 Cookbook</title>
    <link rel="icon" type="image/x-icon" href="assets/images/placeholder.png">
    <link rel="stylesheet" href="assets/styles/normalize.css">
    <link rel="stylesheet" href="assets/styles/main.css">
</head>
<body>
    <nav>
        <div class="nav-wrapper">
            <a href="index.php"><h1>IDM 232 Cookbook</h1></a>
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
        <p>:O!</p>    

    </main>
</body>
</html>