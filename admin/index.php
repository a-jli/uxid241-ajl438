<?php
    declare(strict_types=1);
    require '../inc/database.php';
    require '../inc/functions.php'; 
    require '../inc/guard.php'; 
    ini_set('display_errors', '1'); error_reporting(E_ALL);
    $id = (int) get_value('id');
    $errors = [];
    $results = [];



    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        switch ($_POST['form']) {
            case "add":
                $addedTitle = post_value('added-title');
                $addedSubtitle = post_value('added-subtitle');
                $addedDescription = post_value('added-desc');
                $addedCategory = post_value('added-category');
                $addedServings = post_value('added-servings');
                $addedTime = post_value('added-time');
                $addedCalories = post_value('added-calories');
                $addedIngredients = post_value('added-ingredients');
                    $lines = preg_split('/\R/', $addedIngredients);
                    $lines = array_filter(array_map('trim', $lines));
                    $ingredients = implode('*', $lines);

                if($addedTitle === '') {
                    $errors[] = 'Recipe title is required.';
                }
                if( $addedSubtitle === '') {
                    $errors[] = 'Recipe subtitle is required.';
                } 
                if($addedDescription === '') {
                    $errors[] = 'Recipe description is required.';
                } 
                if($addedCategory === '') {
                    $errors[] = 'Recipe category is required.';
                } 
                if($addedTime === '') {
                    $errors[] = 'Recipe time is required.';
                }  
                if($addedServings === '') {
                    $errors[] = 'Serving information is required.';
                } 
                if($addedCalories === '') {
                    $errors[] = 'Calorie information is required.';
                } 
                if($addedIngredients === '') {
                    $errors[] = 'Recipe ingredients are required.';
                } 
                $step_list = array_filter(array_map('trim', $_POST['step'] ?? []));
                if ($step_list === []) {
                    $errors[] = 'At least one step is required.';
                }

                try {
                $saved_names = [];
                $folder = '../assets/images';
                if (isset($_FILES['photos']['name']) && (is_array($_FILES['photos']['name']))){
                    $files = $_FILES['photos'];
                    foreach ($files['name'] as $i => $original_name) {
                        if ($files['error'][$i] === UPLOAD_ERR_NO_FILE) {
                            continue;
                        }
                        try {
                            $saved = save_upload(
                                $files['tmp_name'][$i],
                                $original_name,
                                $files['size'][$i],
                                $files['error'][$i],
                                $folder
                            );
                            $saved_names[] = $saved;
                            $results[] = [
                                'name' => $original_name, 
                                'saved'=> $saved,
                                'message'=> 'saved as ' . $saved
                            ];
                        }
                        catch (RuntimeException $e) {
                            $results[] = [
                                'name' => $original_name, 
                                'saved'=>null,
                                'message' => $e->getMessage()
                            ];
                        }
                    }   
                }

                if ($errors === []) { 
                    $new_id = create_recipe($conn, 
                        $addedTitle, 
                        $addedSubtitle, 
                        $addedDescription, 
                        $ingredients,
                        (int) $addedCategory, 
                        (int) $addedServings, 
                        (int) $addedTime, 
                        (int) $addedCalories 
                        ); 

                    // image upload
                    if ($saved_names !== []) {
                        $images = implode ('*', $saved_names);
                        add_images($conn, $new_id, $images);                           
                    }

                    //steps upload
                    $step_list = $_POST['step'] ?? [];
                    if ($step_list !== []) {
                        $steps = implode ('*', $step_list);
                            add_steps($conn, $new_id, $steps);
                    } 


                        
                    header('Location: index.php');
                    exit;
                 } else {
                    $error = 'There was a problem with your submission.';
                 }
                } catch (mysqli_sql_exception $e) {
                    $error = 'There was a problem with your submission.';
                    $e->getMessage(); 
                }
                    break;
            case "delete":
                $deleteId = post_value('delete-id');
                try {
                    mysqli_execute_query(
                        $conn, 
                        'DELETE FROM cookbook_recipes WHERE id = ?', [$deleteId]);
                        header('Location: index.php');
                        exit;
                } catch (mysqli_sql_exception $e) {
                    $deleteError = 'There was a problem with your deletion.';
                    $e->getMessage(); 
                }
                break;
            default:
        }
        }
$root = '../';
require '../inc/header.php';

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
    <main>
        <div class="text-wrapper">
            <br>
            <h1>Admin</h1>
            <hr>
            <h2>Add Recipe</h2>
            <br>
            <form class="add-recipe-form" method = "post" enctype = "multipart/form-data"> 
                <h3>Title <span class="red">*</span></h3>
                <input required type= "text" id="added-title" name="added-title" value="">
                <h3>Subtitle <span class="red">*</span></h3>
                <input required type= "text" id="added-subtitle" name="added-subtitle" value="">
                <h3>Description <span class="red">*</span></h3>
                <input required type= "text" id="added-desc" name="added-desc" value="">
                <h3>Category <span class="red">*</span></h3>
                <select required name="added-category" id="added-category" value="">
                    <option value="1">Vegetarian</option>
                    <option value="2">Fish</option>
                    <option value="3">Poultry</option>
                    <option value="4">Pork</option>
                    <option value="5">Beef</option>
                </select>
                <div class="horizontal">
                    <div>
                        <h3>Servings <span class="red">*</span></h3>
                        <input required type= "number" min="1" max="12" id="added-servings" name="added-servings" value="">
                    </div>
                    <div>
                        <h3>Time<span class="red">*</span></h3>
                            <input required type= "number" min="1" max="240" id="added-time" name="added-time" value="">
                    </div>
                    <div>
                        <h3>Calories <span class="red">*</span></h3>
                        <input required type= "number" min="100" max="2000" id="added-calories" name="added-calories" value="">
                    </div>
                </div>
                <h3>Images</h3>
                    <p class="red smallgap"><i>Please upload one image per step, with the last image being the completed meal.</i></p>
                    <input class="smallgap" type="file" name="photos[]" multiple>
                <h3>Ingredients <span class="red">*</span></h3>
                    <p class="red smallgap"><i>One ingredient per line.</i></p>
                    <textarea class="smallgap" required id="added-ingredients" name="added-ingredients" value=""></textarea>
                <h3>Steps <span class="red">*</span></h3>
                <fieldset id = "steps-fieldset">
                    <div>
                        <label for="Step ${stepCount}">Step 1</label>
                        <textarea required="" id="step-0" name="step[]"></textarea>
                    </div>
                </fieldset>
                <input type="hidden" name="form" id="form" value="add">
                <div class="form-buttons">
                    <button type="button" id="add-step">Add Step</button>
                    <button type="submit">Submit</button>
                    <br>
                </div>
                <div class="smallgap">
                    <?php if ($results !== null) : ?>
                        <?php foreach ($results as $result): ?>
                            <p class="centered">
                                <?= e($result['name'])?>
                                <?= e($result['message'])?>
                            </p>
                        <?php endforeach ?>
                    <?php endif?>
                    <?php if (!empty($error)): ?>
                        <p class="red"><strong><?= e($error)?></strong> </p>
                    <?php endif?>
                    <?php foreach ($errors as $error) : ?>
                        <p class="red"><?= ($error);?></p>
                    <?php endforeach; ?>
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
                <br>
            <hr>
            <h2>Edit Recipe</h2>
            <div class="recipes-grid fullwide">
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
                            <a class="view-recipe-btn semiwide" href="edit.php?id=<?= e($recipe['id'])?>">Edit</a>
                            <form class="delete-form" method="post" onsubmit="return confirm('Delete this recipe?');">
                                <input class="none" type="text" id="form" name="form" value="delete">
                                    <input type="hidden" id="delete-id" name="delete-id" value="<?= e($recipe['id'])?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>      
            </div>
            <?php if (!empty($deleteError)): ?>
                <p class="centered"><?= e($deleteError)?></p>
            <?php endif?>            
            <a class="view-recipe-btn lesswide" href="../logout.php">Logout</a>
            <br>
        </div>
    </main>
    <script src="../assets/script.js"></script>
</body>
</html>
