<?php
    declare(strict_types=1);
    require 'inc/database.php';
    require 'inc/functions.php';

    function value_trim(string $key): string {
        return trim($_GET[$key] ?? '');
    }
    $food_searched = value_trim('q'); // set query variable to trimmed string 
    $food_results = []; // empty array for results to fill
    
    if ($food_searched !== '') { //if it isn't empty?
        foreach($recipes as $recipe) { // v set everything to lowercase for search 
            if (str_contains(strtolower(e($recipe['title'])), strtolower($food_searched))) {
                $food_results[] = $recipe; //add recipes to results
            }
        }
    }    
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
    <main>

        <div class="search-filter-wrapper">
            <div>
            <h2>Filter By:</h2>
            <select class="dropdown" name="Protein">
                <option value>Vegetarian</option>
                <option value>Fish</option>
                <option value>Poultry</option>
                <option value>Pork</option>
                <option value>Beef</option>
            </select>
            </div>
            <div>
            <h2>Search Recipes:</h2>
            <form action="index.php" method = "GET"> 
                <!-- <label for="q"> Search Recipes </label> -->
                <input type= "search" id="q" name="q" value="<?= e($food_searched) ?>">
                <button type="submit">Search</button>
            </form>                
            </div>
        </div>

        <div class="recipes-grid">
            <?php foreach ($recipes as $recipe):?>
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
                    <!--steps -->
                    <h2>Ingredients:</h2>
                    <?php 
                    //explode not working, i checked and the line break should be 
                    //\r\n to my understanding + that is how it displays in the schema
                        $ingredients = explode ("\r\n", $recipe['ingredients']);?>
                        <?php foreach ($ingredients as $ingredient):?>
                        <li><?=e($ingredient)?></li>
                    <?php endforeach; ?>
                    <h2>Steps:</h2>
                    <div class="steps-wrapper">
                        <?php 
                            $steps = explode ('*', $recipe['steps']);?>
                            <ul>
                                <?php foreach ($steps as $step):?>
                                <li><?=e($step) ?></li>
                                <?php endforeach ?>
                            </ul>
                        <!-- images -->
                        <?php 
                            $images = explode ('*', $recipe['images']);?>
                            <?php foreach ($images as $image):?>
                            <img src="assets/images/<?=e($image)?>">
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>    
        </div>  
        </div>   
    </main>

</body>
</html>