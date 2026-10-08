<?php
    declare(strict_types=1);
    var_dump($_GET);
    var_dump($_POST);

    //function trim string and return a string.
    function value_trim(string $key): string {
        return trim($_GET[$key] ?? '');
    }

    //function escape helper
    function e(string $value): string { // v escape both single and double quotes
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); // < the character's encoding.
    } //            ^ converts characters to entitys so browser does not run it

    // FOOD SEARCH 
    $food_searched = value_trim('q'); // set query variable to trimmed string 
    $food_results = []; // empty array for results to fill
    $recipes = [ // array to search
        'Fish',
        'Fish 2',
        'Fish 3',
        'Vegetable',
        'Vegetable and Chicken',
        'Chicken',
        'Rice and Chicken',
        'Rice and Fish'
    ];


    if ($food_searched !== '') { //if it isn't empty?
        foreach($recipes as $recipe) { // v set everything to lowercase for search 
            if (str_contains(strtolower($recipe), strtolower($food_searched))) {
                $food_results[] = $recipe; //add recipes to results
            }
        }
    }

    // RECIPE SUBMIT
    function post_value_trim(string $key): string {
    return trim($_POST[$key] ?? '');
    }

    //variables for stuff
    $recipe_name = '';
    $email = '';
    $errors = [];
    $success = false;

    //set variables
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipe_name = post_value_trim('name');
    $email = post_value_trim('email');

    //create error messages for empty recipe and email
    if ($recipe_name === '') {
        $errors[] = 'Recipe name is required.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if (empty($errors)) {
        $success = true;
    }
    }
    

?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UXID 241 Cookbook</title>
</head>

<body>

<!-- FOOD SEARCH -->
<hr />
    <h3>Food Search</h3> 
    <form action="index.php" method = "GET"> 
        <label for="q"> Recipe name has: </label>
        <input type= "search" id="q" name="q" value="<?= e($food_searched) ?>" required>
        <button type="submit">Search</button>
    </form>

    <?php if ($food_searched !== '') : ?> 
    <p> <?=count($food_results); ?> result(s) for "<?= e($food_searched); ?>"</p>
    <ul>
        <?php foreach ($food_results as $recipe) : ?>
            <li><?= e($recipe); ?></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

<!-- if query isn't empty, # of food results, (escaped)whatever searched
 make li for each result with the (escaped)recipe inside -->
 <hr />

 <!-- RECIPE SUBMISSION -->

    <h3>Recipe Submission</h3>
    <form action="index.php" method="POST">
        <label for="name">Recipe Name: </label>
        <input text="text" id="name" name="name" value="<?= e($recipe_name) ?>" required>
        <label for="email">Your Email: </label>
        <input text="email" id="email" name="email" value="<?= e($email) ?>" required>
        <button type="submit">Submit</button>
    </form>

    <?php if ($success === true) : ?>
    <p>Recipe "<?=e($recipe_name); ?>" submitted by <?=e($email); ?>.</p>
    <?php else :
        foreach ($errors as $error) : ?>
        <p><?= ($error);?></p>
    <?php endforeach; ?>
    <?php endif; ?>


</body>
</html>

