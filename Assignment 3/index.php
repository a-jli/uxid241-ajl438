<?php
    declare(strict_types=1);

    require 'database.php';

    //select reads data back   
    $result = mysqli_query($conn, 'SELECT title, description, ingredients, step1, step2, step3, step4, step5, step6 from assignment_3');
    $recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //mysqli_fetch_all returns as one array of rows. MYSQLI_ASSOC makes each row associative array keyed by column name.

   function e(string $value): string { 
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); 
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UXID 241 Cookbook Assignment 3</title>
</head>
<body>
    <h2>Available Recipes:</h2>
    <?php foreach ($recipes as $recipe):?>
        <h3>Title: <?= e($recipe['title']) . '<br>'; ?></h3> 
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
    <?php endforeach; ?>
</body>
</html>

