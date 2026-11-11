<?php
    declare(strict_types=1);
    require '../inc/database.php';
    require '../inc/functions.php'; 
    require '../inc/guard.php'; 

    $id = (int) get_value('id');
    $recipe = get_recipe($conn, $id);
?>


<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UXID 241 Cookbook - Edit</title>
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
    <main>
        <div class="text-wrapper">
            <br>
            <h1>Edit Recipe:</h1>
        </div>
        <div class="recipe-focus">
            <?php if ($recipe === null): ?>
                <p>Recipe not found.</p>
            <?php else: ?>
                <form class="edit-recipe-form" method = "post"> 
                <h3>Title</h3>
                <input type= "text" id="title" name="title" value="<?= e($recipe['title']) ?>">
                <h3>Subtitle</h3>
                <input type= "text" id="subtitle" name="subtitle" value="<?= e($recipe['subtitle']) ?>">
                <h3>Description</h3>
                <textarea type= "text" id="desc" name="desc">
                    <?= e($recipe['description']) ?>
                </textarea>
                <h3>Steps</h3>
                <fieldset id = "steps-fieldset">
                    <?php $steps = explode ('*', $recipe['steps']);?>
                    <?php foreach ($steps as $i => $step): ?>
                        <div class="steps-wrapper vertical">
                            <h3 class="step-number smaller" >Step <?=$i + 1?></h3>
                            <textarea type= "text" id="step" name="step">
                                <?= e($step) ?>
                            </textarea>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
                <div class="form-buttons">
                    <button class="submit-btn" type="submit">Submit Changes</button>
                    <br>
                </div>
            </form>
            <hr>
                <div class="recipe-wrapper"> 
                    <div class="recipe-header">
                        <div class="horizontal">
                            <div class="vertical">
                                <h3 class="title"><?= e($recipe['title']) . '<br>'; ?></h3> 
                                <h4 class="subtitle"><?= e($recipe['subtitle']) . '<br>'; ?></h4>
                                <div class="recipe-wrapper-pill">
                                <p class="category"><?= e($recipe['category']); ?></p> 
                                <p class="calories"><?= (string) $recipe['calories'];?>cal</p> 
                                <p class="time"><?= (string) $recipe['time']; ?> min</p>
                            </div>
                            </div>
                            
                            <?php if ($recipe['images'] === ''): ?>
                            <?php else: ?>
                                <?php $images = explode ('*', $recipe['images']);?>
                                <img class="hero-image" src="../assets/images/<?= e(end($images)) ?>" alt="">
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="overview-ingredients">
                        <div>
                            <h2>Overview:</h2>
                            <p><?= e($recipe['description'])?></p>
                        </div>
                        <div>
                            <h2>Ingredients:</h2>
                            <ul>
                                <?php 
                                    $ingredients = explode ("*", $recipe['ingredients']);?>
                                <?php foreach ($ingredients as $ingredient):?>
                                    <li><?=e($ingredient)?></li>
                                <?php endforeach; ?>
                            </ul>                          
                        </div>
                    </div>
                    <hr>
                    <?php $steps = explode ('*', $recipe['steps']);?>
                    <?php $images = explode ('*', $recipe['images']);?>
                        <?php foreach ($steps as $i => $step): ?>
                            <div class="steps-wrapper">
                                <?php if ($recipe['images'] === ''): ?>
                                <?php else: ?>
                                    <img src="../assets/images/<?= e($images[$i + 1]) ?>" alt="">
                                <?php endif ?>
                                <h3 class="step-number" >Step <?=$i + 1?></h3>
                                <p><?= e($step) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
        </div>   
    </main>
</body>
</html>
