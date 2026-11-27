<?php
    declare(strict_types=1);

require 'inc/database.php';
require 'inc/functions.php';
$root = '';
require 'inc/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UXID 241 Cookbook - Help</title>
    <link rel="icon" type="image/x-icon" href="assets/images/placeholder.png">
    <link rel="stylesheet" href="assets/styles/normalize.css">
    <link rel="stylesheet" href="assets/styles/main.css">
</head>
<body>
    <main>
        <br><br> 
        <div class="text-wrapper">
            <div class="recipe-wrapper smallgap">
                <br><br>
                <h2>This cookbook allows you to browse, search, and filter 
                    recipes. You can also generate a random recipe if you're 
                    looking for a surprise!</h2>
                <hr>
                
                <h3>Browse Recipes</h3>
                <p>The home page shows a selection of recipes and a search and filter bar.</p>
                <p>To look at recipe details, click on the "View Recipe" button.</p>    
                <br>            
                <h3>Search Recipes</h3>
                <p>The search bar can be used to look up recipes by title and description.</p>
                <br>
                <h3>Filter Recipes</h3>
                <p>The filter dropdown can be used to filter the recipes by protein type. The options are:</p>
                <ul>
                    <li>Vegetarian</li>
                    <li>Poultry</li>
                    <li>Fish</li>
                    <li>Pork</li>
                    <li>Beef</li>
                </ul>
                <br>
                <h3>Surprise Recipe</h3>
                <p>The Surprise Me link send the user to a random recipe.</p>
                <br><br><br><br>
                <a class="view-recipe-btn lesswide" href="case-study.php">Case Study</a>

            </div>
        </div>

    </main>
</body>
</html>