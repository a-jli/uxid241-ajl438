<?php
    declare(strict_types=1);

    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
 
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
           
            <form action="index.php" method = "GET">
                <div> 
                <h3>Search:</h3>
                <input type= "search" id="q" name="q" value="<?= e($food_searched) ?>">
                </div>
                <div>
                <h3>Filter:</h3>
                <select class="dropdown" name="protein" id = "protein">
                    <!-- TODO save dropdown input -->
                    <option value="">All</option>
                    <option value="1">Vegetarian</option>
                    <option value="2">Fish</option>
                    <option value="3">Poultry</option>
                    <option value="4">Pork</option>
                    <option value="5">Beef</option>
                </select>
                </div>
                <button type="submit">Find Recipe</button>
            </form>                
            
        </div>
        <?php if ($food_searched !== '' && $food_filtered === '') : ?>
            <p>searching only!</p>
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
                                    <p class="servings"><?= ($food_result['servings']);?>cal</p>
                                    <p class="calories"><?= ($food_result['calories']);?>cal</p>
                                    <p class="time"><?= ($food_result['time']); ?> min</p>
                                </div>
                            </div>
                        </div>  
                        <a class="view-recipe-btn" href="recipe.php?id=<?= $food_result['id']?>">View Recipe</a>
                    </div>
                <?php endforeach; ?>    
            </div>
        <?php elseif ($food_searched === '' && $food_filtered !== ''):?>
            <p>filtering only!</p>
            <div class="recipes-grid">
            <?php $food_results = filter_recipe($conn, $food_filtered);?>
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
                                    <p class="servings"><?= ($food_result['servings']);?> Servings</p>
                                    <p class="calories"><?= ($food_result['calories']);?>cal</p>
                                    <p class="time"><?= ($food_result['time']); ?> min</p>
                                </div>
                            </div>
                        </div>  
                        <a class="view-recipe-btn" href="recipe.php?id=<?= $food_result['id']?>">View Recipe</a>
                    </div>
                <?php endforeach; ?>    
            </div>
        <?php elseif ($food_searched !== '' && $food_filtered !== ''):?>
            <p>filtering and searching!</p>
        <?php else: ?>
            <p>All recipes!</p>
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
                                    <p class="servings">Serves <?= e($recipe['servings']);?></p>
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
TODO:
- [] filter feature
- [DONE] full edit 
- [DONE] submit recipe
- [] upload all images
- [] delete confirm
-->