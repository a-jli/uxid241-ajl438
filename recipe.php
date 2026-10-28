<?php
    declare(strict_types=1);
    require 'inc/database.php';
    require 'inc/functions.php';

    $id = (int) get_value('id');
    get_recipe($conn, $id);
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UXID 241 Cookbook - Recipe Template </title>
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
                <li><a href="index.php">ALL RECIPES</a></li>
                <li><a href="index.php">SUPRPISE ME</a></li>
                <li><a href="index.php">HELP</a></li>
                <li><a href="index.php">LOGIN</a></li>
                <li><a href="recipe.php">Recipe Template!</a></li>
            </ul>
        </div>
    </nav>
        <?php 
            
        ?>
            <div class="recipe-wrapper"> 
                <div class="recipe-header">
                    <h3 class="title"><?= e($recipe['title']) . '<br>'; ?></h3> 
                    <h4 class="subtitle"><?= e($recipe['subtitle']) . '<br>'; ?></h4> 
                    <div class="recipe-wrapper-pill">
                        <p class="category"><?= e($recipe['category']); ?></p> 
                        <p class="calories"><?= e($recipe['calories']);?>cal</p>
                        <p class="time"><?= e($recipe['time']); ?> min</p>
                    </div>
                </div>
                <h2>Overview:</h2>
                <p><?= e($recipe['description'])?></p>
                <h2>Ingredients:</h2>
                <img src="assets/images/<?= e($images[0]) ?>" alt="">
                <ul>
                <?php 
                    $ingredients = explode ("*", $recipe['ingredients']);?>
                    <?php foreach ($ingredients as $ingredient):?>
                    <li><?=e($ingredient)?></li>
                <?php endforeach; ?>
                </ul>
                <!-- steps redo-->
                <?php $steps = explode ('*', $recipe['steps']);?>
                <?php $images = explode ('*', $recipe['images']);?>
                    <?php foreach ($steps as $i => $step): ?>
                    <div class="steps-wrapper">
                        <img src="assets/images/<?= e($images[$i + 1]) ?>" alt="">
                        <p><?= e($step) ?></p>
                    </div>
                    <?php endforeach; ?>
                <!--steps -->
                    <a class="view-recipe-btn" href="recipe.php?id=<?= $recipe['id']?>">View Recipe</a>
            </div>
</body>
</html>