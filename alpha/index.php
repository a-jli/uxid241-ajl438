<?php
    declare(strict_types=1);
    require 'database.php';
                                                                            //rename categories.name to category, less clunky 
    $result = mysqli_query($conn, 'SELECT cookbook_recipes.title, subtitle, cookbook_categories.name AS category, description, servings, time, calories, ingredients, step1, step2, step3, step4, step5, step6
    FROM cookbook_recipes
    INNER JOIN cookbook_categories ON cookbook_recipes.category_id = cookbook_categories.id');
    // join - query that reads matching rows from both tables together
    // inner means we only get rows where the match exists on both sides

    $recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);

    function e(string $value): string { 
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); 
    } 

    //what category what recipe
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

    //how many of each category
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
        <h3><?= e($recipe['title']) . '<br>'; ?></h3> 
        <h3><?= e($recipe['subtitle']) . '<br>'; ?></h3> 
        <p><?= e($recipe['category']); ?></p> 
        <p><?= e($recipe['calories']);?>cal</p>
        <p><?= e($recipe['time']); ?> min</p>
        <h4>Description: <?= e($recipe['description']); ?></h4>
        <p>Ingredients: <?= e($recipe['ingredients']); ?></p> 
        <ul>
            <li>Step 1: <?= e($recipe['step1']); ?></li>
            <li>Step 2: <?= e($recipe['step2']); ?></li>
            <li>Step 3: <?= e($recipe['step3']); ?></li>
            <li>Step 4: <?= e($recipe['step4']); ?></li>
            <li>Step 5: <?= e($recipe['step5']); ?></li>
            <li>Step 6: <?= e($recipe['step6']); ?></li>
        </ul>
        <hr>
    <?php endforeach; ?>
</body>
</html>