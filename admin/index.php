<?php
    declare(strict_types=1);
    require '../inc/database.php';
    require '../inc/functions.php'; 
    require '../inc/guard.php'; 

    $id = (int) get_value('id');
   
    $errors = [];
 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        switch ($_POST['form']) {
            case "add":
                $addedTitle = post_value('added-title');
                $addedSubtitle = post_value('added-subtitle');
                $addedDescription = post_value('added-desc');
                $addedCategory = post_value('added-category');
                // $addedSteps = post_value('step');
                //$addedImages = post_value('image??');
                // fix this later
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
                // if($addedSteps === '') {
                //     $errors[] = 'At least one step is required.'; 
                // }  
                //the addedsteps requirement wasn't working?
                try {
                    mysqli_execute_query(
                        $conn,
                        'INSERT INTO cookbook_recipes (title, subtitle, description, category_id) VALUES (?, ?, ?, ?)',
                        [$addedTitle, $addedSubtitle, $addedDescription, $addedCategory]
                    );
                    $step_list = $_POST['step'] ?? [];
                        if ($step_list !== []) {
                            $steps = implode ('*', $step_list);
                            add_steps($conn, mysqli_insert_id($conn), $steps);
                        }
                    $images_list = $_POST['images'] ?? [];
                        if ($image_list !== []) {
                            $images = implode ('*', $images_list);
                            add_images($conn, mysqli_insert_id($conn), $images);                           
                        }
                    $error = 'Recipe submitted!';
                    header('Location: index.php');
                    exit;
                } catch (mysqli_sql_exception $e) {
                    $error = 'There was a problem with your submission';
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

        //image upload stuff
        $upload_folder = 'assets/images';
        $results = [];
        if (isset($_FILES['photos']['name']) && (is_array($_FILES['photos']['name']))){
            $files = $_FILES['photos'];
            foreach ($files['name'] as $i => $original_name) {
                if ($files['error'][$i] = UPLOAD_ERR_NO_FILE) {
                    continue;
                }
                try {
                    $save = save_upload(
                        $files['tmp_name'][$i],
                        $files['original_name'][$i],
                        $files['size'][$i],
                        $files['error'][$i],
                        $upload_folder
                    );
                    $results[] = [
                        'name' => $original_name, 
                        'saved'=>$saved,
                        'message'=> 'Save as' . $saved
                    ];
                }
                catch (RuntimeException $e) {
                    $results[] = [
                        'name' => $original_name, 
                        'saved'=>null,
                        $e => getMessage
                    ];
                }
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
    <?php
    echo '<pre>';
    print_r($_FILES);
    echo '</pre>';
    ?>
    <main>
        <div class="text-wrapper">
            <br>
            <h1>Admin</h1>
            <hr>
            <h2>Add Recipe</h2>
            <br>
            <form method = "post" enctype = "multipart/form-data"> 
                <h3>Title <span class="red">*</span></h3>
                <input type= "text" id="added-title" name="added-title" value="">
                <h3>Subtitle <span class="red">*</span></h3>
                <input type= "text" id="added-subtitle" name="added-subtitle" value="">
                <h3>Description <span class="red">*</span></h3>
                <input type= "text" id="added-desc" name="added-desc" value="">
                <h3>Category <span class="red">*</span></h3>
                <input type= "text" id="added-category" name="added-category" value="">
                <!-- <select name="category" id="added-category" name="added-category" value="">
                    <option value="1">Vegetarian</option>
                    <option value="2">Fish</option>
                    <option value="3">Poultry</option>
                    <option value="4">Pork</option>
                    <option value="5">Beef</option>
                </select> -->
                <!--can i get the value of a select the same way i can an input? 
                i think for category a select makes sense more than a text input 
                tried but didnt seem to be accepted?-->
                <h3>Images</h3>
                <input type="file" name="photos[]" multiple>
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
            </form>
            <hr>
            <?php foreach ($results as $result): ?>
                <p>
                    <?= e($result['name'])?>;
                    <?= e($result['message'])?>
            </p>
            <?php endforeach ?>

            <?php if (!empty($error)): ?>
                <p><?= e($error)?> </p>
            <?php endif?>
            <?php foreach ($errors as $error) : ?>
                <p><?= ($error);?></p>
            <?php endforeach; ?>
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
                            <a class="view-recipe-btn" href="edit.php?id=<?= e($recipe['id'])?>">Edit</a>
                            <form class="delete-form" method = "post" > 
                                <input class="none" type="text" id="form" name="form" value="delete" 
                                    onsubmit="return confirm('Delete recipe <?= e($recipe['title']) ?> (<?= e($recipe['id']) ?>?');)">
                                    <!-- doesnt confirm, its no longer a hidden input? -->
                                    <input type="hidden" id="delete-id" name="delete-id" value="<?= e($recipe['id'])?>">
                                <button type="submit" class="delete-btn">Delete</button>
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
