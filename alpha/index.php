<?php
    declare(strict_types=1);
    require 'database.php';

    $result = mysqli_query($conn, 'SELECT title, subtitle, category_id, description, servings, time, calories, ingredients, step1, step2, step3, step4, step5, step6 from cookbook_recipes');
    $recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);

    function e(string $value): string { 
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); 
    } 

    function recipes_with_category(mysqli $conn): array {
    $sql = 'SELECT cookbook_recipes.title, cookbook_categories.name AS category
            FROM cookbook_recipes
            INNER JOIN cookbook_categories ON cookbook_recipes.category_id = cookbook_categories.id
            ORDER BY cookbook_categories.name, cookbook_recipes.title';
    return mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
    }

    foreach (recipes_with_category($conn) as $row) {
        echo"<p>{$row['category']}:{$row['title']}</p>"; 
    }

    function category_count(mysqli $conn){
        $sql = 'SELECT cookbook_categories.name, COUNT(*) AS recipes_count 
        FROM cookbook_recipes
        INNER JOIN cookbook_categories ON cookbook_recipes.category_id = cookbook_categories.id
        GROUP BY cookbook_categories.name
        ORDER BY recipes_count DESC';
        return mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
    }

    foreach (category_count($conn) as $row) {
        echo"<p>{$row['name']}:{$row['recipes_count']}</p>"; 
    }

    var_dump($row);
    
    //transaction
    // function add_ingredients(mysqli $conn, int $recipe_id, array $titles {
    //     $sql = 'INSERT INTO ingredients (recipe_id, title) VALUES (?, ?)';
    //     foreach($names as $name) {
    //         mysqli_e_q($conn, $sql, [$recipe_id, $title])
    //     }
    // })

    // mysqli_begin_transaction($conn);
    //     try {
    //         $id = create_recipe($conn, 'titletest', 2);
    //         add_ingredients($conn, $id, ['testingredient', 'testingredient2']);
    //         mysqli_commit($conn);
    //         echo 'Saved recipe #{$id} with ingredients';
    //     } catch (mysqli_sql_exception $e) {
    //     mysqli_rollback($conn);
    //     throw $e;
    //     echo 'save failed';
    //     }
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UXID 241 Alpha — Cookbook Project Foundation </title>
</head>
<body>
<hr>
    <h1>Available Recipes:</h1>
    <hr>
    <?php foreach ($recipes as $recipe):?>
        <h3>Title: <?= e($recipe['title']) . '<br>'; ?></h3> 
        <h3><?= e($recipe['subtitle']) . '<br>'; ?></h3> 
        <h4>Category:<?= e($recipe['category_id']); ?></p> 
        <p><?= e($recipe['calories']);?>cal</p>
        <p><?= e($recipe['time']); ?> min</p>
        <h4>Description: <?= e($recipe['description']); ?></h4>
        <p>Ingredients: <?= e($recipe['ingredients']); ?></p> 
        <ul>
            <li>Step 1: <?= e($recipe['step1']); ?></li>
            <li>Step 2:<?= e($recipe['step2']); ?></li>
            <li>Step 3:<?= e($recipe['step3']); ?></li>
            <li>Step 4:<?= e($recipe['step4']); ?></li>
            <li>Step 5:<?= e($recipe['step5']); ?></li>
            <li>Step 6:<?= e($recipe['step6']); ?></li>
        </ul>
        <hr>
    <?php endforeach; ?>
</body>
</html>



<!-- 
- [DONE] A database schema as a checked-in SQL file (e.g., schema.sql) or migration. At minimum a recipes table with a primary key 
    and columns that fit the domain (title, and at least a few of: description, servings, prep time, category, created date). 
    A categories table with a foreign key from recipes is encouraged but not required at alpha.

- [DONE] Seed data: a handful of example recipes (in the SQL file or a separate seed file) so the list page has something to render.

- [] A working PHP page (e.g., index.php) that connects to the database with mysqli and renders a list of recipes read from the 
recipes table using a prepared statement (or mysqli_query for the no-input list — see §4). Output is escaped with htmlspecialchars.

- [DONE] A GitHub repository named uxid241-<your-drexel-id> (e.g., uxid241-ps42), with real, multi-session commit history.
- [DONE] A README.md describing the project, how to run it locally, and an AI-use section (see §8 and the appendix). 
-->