<?php
    declare(strict_types=1);
    require '../inc/database.php';
    require '../inc/functions.php'; 
    require '../inc/guard.php'; 

    $id = (int) get_value('id');


    $step_list = $_POST['step'] ?? [];
        if ($step_list !== []) {
            $steps = implode ('*', $step_list);
            add_steps($conn, $id, $steps);
        }
 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        switch ($_POST['form']) {
            case "A":
                $addedTitle = post_value('added-title');
                $addedSubtitle = post_value('added-subtitle');
                $addedDescription = post_value('added-desc');
                $addedCategory = post_value('added-category');
                echo "add recipe form submitted";
            try {
                mysqli_execute_query(
                    $conn,
                    'INSERT INTO cookbook_recipes (title, subtitle, description, category_id) VALUES (?, ?, ?, ?)',
                    [$addedTitle, $addedSubtitle, $addedDescription, $addedCategory]
                );
                $error = 'Recipe submitted!';
            } catch (mysqli_sql_exception $e) {
                $error = 'There was a problem with your submission.';
                $e->getMessage(); 
            }
                break;

            case "B":
                $deleteId = post_value('delete-id');
                echo "delete recipe form submitted";
                echo ($deleteId);
                try {
                    mysqli_execute_query(
                        $conn, 
                        'DELETE FROM cookbook_recipes WHERE id = ?', [$deleteId]);
                        //only deletes the last id, and needs 2 clicks??
                } catch (mysqli_sql_exception $e) {
                    $deleteError = 'There was a problem with your deletion.';
                    $e->getMessage(); 
                }
                break;

            default:
                echo "something broke?";
        }

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
                    <?php if (!empty($deleteError)): ?>
                <p><?= e($deleteError)?></p>
            <?php endif?> 
        <div class="text-wrapper">
            <br>
            <h1>Admin</h1>
            <hr>
            <h2>Add Recipe</h2>
            <br>
            <br>
            <form method = "post"> 
                <h3>Title</h3>
                <input type= "text" id="added-title" name="added-title" value="">
                <h3>Subtitle</h3>
                <input type= "text" id="added-subtitle" name="added-subtitle" value="">
                <h3>Description</h3>
                <input type= "text" id="added-desc" name="added-desc" value="">
                <h3>Category (1 veg 2 fish 3 poultry 4 pork 5 beef)</h3>
                <input type= "text" id="added-category" name="added-category" value="">
                <h3>Steps</h3>
                <fieldset id = "steps-fieldset">
                </fieldset>
                <input type="hidden" name="form" id="form" value="A">
                <div class="form-buttons">
                    <button type="button" id="add-step">Add Step</button>
                    <!-- this button doesnt do anything -->
                    <button type="submit">Submit</button>
                    <br>
                </div>
            </form>
            <?php if (!empty($error)): ?>
                <p><?= e($error)?> </p>
            <?php endif?>
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
                <br>
            <hr>
            <h2>Edit Recipe</h2>
            <!-- list each recipe -> form with each associated input filled with what 
             it has (???) -> submit as post -> sql update? -->
            
            <div class="recipes-grid">
                <?php foreach ($recipes as $recipe):?>
                    <?php $images = explode ('*', $recipe['images']);?>
                    <div class="recipe-wrapper"> 
                        <div class="recipe-header">
                            <div class="non-img horizontal">
                                <h3 class="title serious"><?= e($recipe['title']) . '<br>'; ?></h3> 
                                <p class="id serious">id: <?= e($recipe['id']) . '<br>'; ?></p> 
                            </div>
                        </div>  
                        <div class="horizontal button-wrapper">
                            <a class="view-recipe-btn" href="edit.php?id=<?= $recipe['id']?>">Edit</a>
                            <form class="delete-form" method = "post"> 
                                <input type="hidden" id="form" name="form" value="B">
                                <input type="hidden" id="delete-id" name="delete-id" value="<?= $recipe['id']?>">
                                <button onclick="confirmDelete()" class="delete-btn">Delete</button>
                                <script>
                                //move this
                                function confirmDelete() {
                                    confirm("Are you sure you want to delete <?= e($recipe['title'])?>, id: <?= e($recipe['id'])?>?");
                                    // this only asks for the last id?
                                }
                                </script>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>      
            </div>
            <?php if (!empty($deleteError)): ?>
                <p><?= e($deleteError)?></p>
            <?php endif?>            
            <a class="view-recipe-btn" href="../logout.php">Logout</a>
            <br>
        </div>
    </main>
    <script src="../assets/script.js"></script>
</body>
</html>
