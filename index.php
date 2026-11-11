<?php
    declare(strict_types=1);
    require 'inc/database.php';
    require 'inc/functions.php';

    $id = (int) get_value('id');
    $recipe = get_recipe($conn, $id);
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

        <div class="search-filter-wrapper">

            <!-- <div>
            <h2>Filter By:</h2>
            <select class="dropdown" name="Protein">
                <option value>Vegetarian</option>
                <option value>Fish</option>
                <option value>Poultry</option>
                <option value>Pork</option>
                <option value>Beef</option>
            </select>
            </div> -->
            
            <div>
            <h2>Search Recipes:</h2>
            <form action="index.php" method = "GET"> 
                <input type= "search" id="q" name="q" value="<?= e($food_searched) ?>">
                <button type="submit">Search</button>
            </form>                
            </div>
        </div>
        <?php if ($food_searched !== '') : ?>
            <div class="recipes-grid">
            <?php $food_results = search_recipe($conn, $food_searched);?>
            <?php foreach ($food_results as $food_result):?>
                    <?php $images = explode ('*', $food_result['images']);?>
                    <div class="recipe-wrapper"> 
                        <div class="recipe-header">
                            <div class="recipe-header-img">
                                <img src="assets/images/<?= e(end($images)) ?>" alt="">
                            </div>
                            <div class="non-img">
                                <h3 class="title"><?= e($food_result['title']) . '<br>'; ?></h3> 
                                <h4 class="subtitle"><?= e($food_result['subtitle']) . '<br>'; ?></h4> 
                                <div class="recipe-wrapper-pill">
                                    <p class="category"><?= e($food_result['category']); ?></p> 
                                    <p class="calories"><?= ($food_result['calories']);?>cal</p>
                                    <p class="time"><?= ($food_result['time']); ?> min</p>
                                </div>
                            </div>
                        </div>  
                        <a class="view-recipe-btn" href="recipe.php?id=<?= $food_result['id']?>">View Recipe</a>
                    </div>
                <?php endforeach; ?>    
            </div>
        <?php elseif ($food_searched !== '' && $food_results === []):?>
            <p>nothing</p>
        <!-- ok make this actually work-->
        <?php else: ?>
            <div class="recipes-grid">
                <?php foreach ($recipes as $recipe):?>
                    <?php $images = explode ('*', $recipe['images']);?>
                    <div class="recipe-wrapper"> 
                        <div class="recipe-header">
                            <div class="recipe-header-img">
                                <img src="assets/images/<?= e(end($images)) ?>" alt="">
                            </div>
                            <div class="non-img">
                                <h3 class="title"><?= e($recipe['title']) . '<br>'; ?></h3> 
                                <h4 class="subtitle"><?= e($recipe['subtitle']) . '<br>'; ?></h4> 
                                <div class="recipe-wrapper-pill">
                                    <p class="category"><?= e($recipe['category']); ?></p> 
                                    <p class="calories"><?= e($recipe['calories']);?>cal</p>
                                    <p class="time"><?= e($recipe['time']); ?> min</p>
                                </div>
                            </div>
                        </div>  
                        <a class="view-recipe-btn" href="recipe.php?id=<?= $recipe['id']?>">View Recipe</a>
                    </div>
                <?php endforeach; ?>      
            </div>
        
        <?php endif; ?>
    </main>
    <script src="../assets/script.js"></script>
</body>
</html>

<!-- 
TODO
- [DONE] make images not needed on recipe page
- [] admin input
- [] admin edit
- [] admin delete
- [DONE] search w/ prepared statement
-->