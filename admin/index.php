<?php
    declare(strict_types=1);
    require '../inc/database.php';
    require '../inc/functions.php'; 
    session_start();
    require '../inc/guard.php'; 

    $id = (int) get_value('id');
    
    var_dump($_POST['step']);
    // Undefined array key "step" on line 10 NULL ?

    $step_list = $_POST['step'] ?? [];
        if ($step_list !== []) {
            $steps = implode ('*', $step_list);
            add_steps($conn, $id, $steps);
        }
?>


<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UXID 241 Cookbook - Admin</title>
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
        <div class="text-wrapper">
            <br>
            <h1>Admin</h1>
            <hr>
            <h2>Add Recipe</h2>
            <br>
            <form method = "post"> 
                <h3>Title</h3>
                <input type= "text" id="added-title" name="added-title" value="Title">
                <h3>Subtitle</h3>
                <input type= "text" id="added-subtitle" name="added-subtitle" value="Subtitle">
                <h3>Description</h3>
                <input type= "text" id="added-desc" name="added-desc" value="Description">
                <h3>Steps</h3>
                <fieldset id = "steps-fieldset">
                </fieldset>
                <div class="form-buttons">
                    <button type="button" id="add-step">Add Step</button>
                    <!-- this button doesnt do anything -->
                    <button type="submit">Submit</button>
                </div>
            </form>
            <?php 

            $recipe = get_recipe($conn, $id);
                if ($recipe && $recipe['steps']):
            ?>
            <h2>Current Steps</h2>
            <ol>
                <?php $steps = explode('*', $recipe['steps']);
                foreach ($steps as $step);
                ?>
                <li><?= e($step) ?></li>
            <?php endif;?>
                </ol>
            
            <hr>
            <h2>Edit Recipe</h2>
            <!-- list each recipe -> form with each associated input filled with what 
             it has (???) -> submit as post -> sql update? -->
            
            <div class="recipes-grid">
                <!-- display everything if nothing searched -->
                <?php foreach ($recipes as $recipe):?>
                    <?php $images = explode ('*', $recipe['images']);?>
                    <div class="recipe-wrapper"> 
                        <div class="recipe-header">
                            <div class="non-img">
                                <h3 class="title serious"><?= e($recipe['title']) . '<br>'; ?></h3> 
                            </div>
                        </div>  
                        <a class="view-recipe-btn" href="edit.php?id=<?= $recipe['id']?>">Edit Recipe</a>
                    </div>
                <?php endforeach; ?>      
            </div>            
            
             <hr>
            <h2>Delete Recipe</h2>
            <p>add a delete button (form with hidden id) to the recipe wrappers</p>
            <!-- submit the id of what you want to delete, confirm, then delete where id? -->

            <a class="view-recipe-btn" href="../logout.php">Logout</a>
            <br>
        </div>
    </main>
</body>
</html>
