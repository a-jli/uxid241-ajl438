<?php
    declare(strict_types=1);
    require '../inc/database.php';
    require '../inc/functions.php'; 
    require '../inc/guard.php'; 

    $id = (int) get_value('id');
    $recipe = get_recipe($conn, $id);

    if ($recipe['category'] === 'Vegetarian') {
        $categoryNumber = 1;
    } elseif ($recipe['category'] === 'Fish') {
        $categoryNumber = 2;
    } elseif ($recipe['category'] === 'Poultry') {
         $categoryNumber = 3;
    } elseif ($recipe['category'] === 'Pork') {
         $categoryNumber = 4;
    } elseif ($recipe['category'] === 'Beef') {
         $categoryNumber = 5;
    } else {
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $addedIngredients = post_value('ingredients');
        $lines = preg_split('/\R/', $addedIngredients);
        $lines = array_filter(array_map('trim', $lines));
        $ingredients = implode('*', $lines);

        update_recipe($conn, $id,
            post_value('title'), 
            post_value('subtitle'), 
            post_value('desc'),
            $ingredients,
            (int) post_value('category'),
            (int) post_value('servings'),
            (int) post_value('time'),
            (int) post_value('calories')
        );
        $step_list = $_POST['step'] ?? [];
            if ($step_list !== []) {
                $steps = implode ('*', $step_list);
                add_steps($conn, mysqli_insert_id($conn), $steps);
            }            
    
            $step_list = $_POST['step'] ?? [];
                if ($step_list !== []) {
                    $steps = implode ('*', $step_list);
                        add_steps($conn, $id, $steps);
                }


        header('Location: index.php');
        exit;
        }

$root = '../';
require '../inc/header.php';
    
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
                <textarea type= "text" id="desc" name="desc"><?= e($recipe['description']) ?></textarea>
                <h3>Category <span class="red">*</span></h3>
                <select name="category" id="category">
                    <option value="<?=$categoryNumber?>"><?=$recipe['category']?></option>
                    <hr>
                    <option value="1">Vegetarian</option>
                    <option value="2">Fish</option>
                    <option value="3">Poultry</option>
                    <option value="4">Pork</option>
                    <option value="5">Beef</option>
                </select>

                <div class="horizontal">
                    <div>
                        <h3>Servings <span class="red">*</span></h3>
                        <input type= "number" min="1" max="12" id="servings" name="servings" value="<?= $recipe['servings'] ?>">
                    </div>
                    <div>
                        <h3>Time<span class="red">*</span></h3>
                        <input type= "number" min="1" max="240" id="time" name="time" value="<?= $recipe['time'] ?>">
                    </div>
                    <div>
                        <h3>Calories <span class="red">*</span></h3>
                        <input type= "number" min="100" max="2000" id="calories" name="calories" value="<?= $recipe['calories'] ?>">
                    </div>
                </div>
                <h3>Ingredients <span class="red">*</span></h3>
                    <p class="red"><i>One ingredient per line.</i></p>
                    <?php $ingredients_text = implode("\n", explode("*", $recipe['ingredients'])); ?>
                    <textarea required id="ingredients" name="ingredients"><?= e($ingredients_text) ?></textarea>
                <h3>Steps</h3>
                <fieldset id = "steps-fieldset">
                    <?php $steps = explode ('*', $recipe['steps']);?>
                    <?php foreach ($steps as $i => $step): ?>
                        <div class="steps-wrapper edit-page">
                            <label class="step-number smaller" >Step <?=$i + 1?></label>
                            <textarea type= "text" id="step-<?= $i + 1?>" name="step[]"><?= e($step) ?></textarea>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
                <div class="form-buttons">
                    <button type="button" id="add-step">Add Step</button>
                    <button class="submit-btn" type="submit">Submit</button>
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
                                <p class="servings">Serves <?= ($recipe['servings']);?></p>
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
                                    <img src="../assets/images/<?= e($images[$i]) ?>" alt="">
                                <?php endif ?>
                                <div class="step-text">
                                    <h3 class="step-number" >Step <?=$i + 1?></h3>
                                    <p><?= e($step) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
        </div>   
    </main>
    <script src="../assets/script.js"></script>
</body>
</html>
