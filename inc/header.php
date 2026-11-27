<?php
    declare(strict_types=1);

    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

    $id = (int) get_value('id');
    $recipe = get_recipe($conn, $id);

    $getRandomId = mysqli_query($conn, 
    'SELECT cookbook_recipes.id 
    FROM cookbook_recipes 
    ORDER BY RAND() LIMIT 1');

    $randomId = mysqli_fetch_assoc($getRandomId);
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDM 232 Cookbook</title>
    <link rel="icon" type="image/x-icon" href="<?= $root; ?>assets/images/icon.png">
    <link rel="stylesheet" href="<?= $root; ?>assets/styles/normalize.css">
    <link rel="stylesheet" href="<?= $root; ?>assets/styles/main.css">
</head>
<body>
    <nav>
        <div class="nav-wrapper">
            <a href="index.php"><h1>IDM 232 Cookbook</h1></a>
            <hr class="hidden-hr">
            <ul>
                <li><a href="<?= $root; ?>index.php">HOME</a></li>
                <li><a href="<?= $root; ?>recipe.php?id=<?=$randomId['id']?>">SUPRPISE ME</a></li>
                <li><a href="<?= $root; ?>help.php">HELP</a></li>
                <li><a href="<?= $root; ?>login.php">LOGIN</a></li>
            </ul>
        </div>
    </nav>
</body>
</html>
