<?php
declare(strict_types=1);

var_dump($_GET);
var_dump($_POST);

function e(string $value): string { 
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); 
} 

function post_value(string $key): string {
  return trim($_POST[$key] ?? '');
}

function get_value(string $key): string {
  return trim($_GET[$key] ?? '');
}

function value_trim(string $key): string {
    return trim($_GET[$key] ?? '');
}

function get_all_recipes (mysqli $conn):array {
    $sql = 'SELECT id, title FROM cookbook_recipes 
    ORDER BY id ASC';
    return mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
}

// The function takes the mysqli connection and an int id, 
// and returns either an associative array or null. 
// mysqli_fetch_assoc() returns null when nothing matches, 
function get_recipe (mysqli $conn, int $id):?array {
  $sql = 'SELECT * FROM cookbook_recipes WHERE id = ?';
  $result = mysqli_execute_query($conn, $sql, [$id]);
  return mysqli_fetch_assoc($result);
}

                                                                          //rename categories.name to category, less clunky 
$result = mysqli_query($conn, 'SELECT cookbook_recipes.id, cookbook_recipes.title, subtitle, cookbook_categories.name AS category, description, servings, time, calories, ingredients, steps, images
FROM cookbook_recipes
INNER JOIN cookbook_categories ON cookbook_recipes.category_id = cookbook_categories.id');
// join - query that reads matching rows from both tables together, inner means we only get rows where the match exists on both sides

$recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);


$food_searched = value_trim('q'); // set query variable to trimmed string 
$food_results = []; // empty array for results to fill

if ($food_searched !== '') { //if it isn't empty?
    foreach($recipes as $recipe) { // v set everything to lowercase for search 
        if (str_contains(strtolower(e($recipe['title'])), strtolower($food_searched))) {
            $food_results[] = $recipe; //add recipes to results
        }
    }
}


?>