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
            <div class="recipe-wrapper">
                <h1>Case Study</h1>
                <img class="hero-image" src="assets/images/placeholder.png" loading="lazy" alt="placeholder">
                <h2>Overview</h2>
                <p>
                    A one- or two-paragraph summary: the problem, the solution, and the key result. Write this section last.
                </p>
                <h2>Context and challenge</h2>
                <div class="sideline">
                    <h3>Background</h3>
                    <p>what the cookbook is, who it is for, and the timeline (one term, solo project).</p>
                    <br>
                    <h3>Problem</h3>
                    <p> why the project exists and what it needs to solve for a visitor and for an admin.</p>
                    <br>
                    <h3>Goals</h3>
                    <p>the concrete, checkable outcomes that define success (for example, "a visitor can find a recipe by ingredient in under three clicks").</p>
                </div>
                <h2>Process </h2>
                <p>
                    Show the finished app with detailed screenshots and a link to the live site if it is deployed. Explain its defining features, such as navigation, search and filtering, the admin flow, and mobile layout, and the reasoning behind each.
                </p>
                <h2>Solution</h2>
                <p>
                    A short wrap-up. Did you meet the goals from Context and Challenge? Answer goal by goal. Then give the lessons learned and what you would change about your process next time.
                </p>
                <h2>Results</h2>

            </div>
        </div>
    </main>
</body>
</html>