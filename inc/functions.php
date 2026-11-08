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

// function get_all_recipes (mysqli $conn):array {
//     $sql = 'SELECT id, title FROM cookbook_recipes 
//     ORDER BY id ASC';
//     //change order here
//     return mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
// }

function get_recipe (mysqli $conn, int $id):?array {
    $sql = 'SELECT cookbook_recipes.id, 
    cookbook_recipes.title, 
    subtitle, 
    cookbook_categories.name 
    AS category, description, servings, time, calories, ingredients, steps, images 
    FROM cookbook_recipes 
    -- not sure why its stil giving undefined array key category
    INNER JOIN cookbook_categories ON cookbook_recipes.category_id = cookbook_categories.id
    WHERE cookbook_recipes.id = ?';
    $result = mysqli_execute_query($conn, $sql, [$id]);
    return mysqli_fetch_assoc($result);
}
                                                         
$result = mysqli_query($conn, 'SELECT cookbook_recipes.id, 
    cookbook_recipes.title, 
    subtitle, 
    cookbook_categories.name 
    AS category, description, servings, time, calories, ingredients, steps, images
    FROM cookbook_recipes
    INNER JOIN cookbook_categories ON cookbook_recipes.category_id = cookbook_categories.id
    ORDER BY id ASC');
// join - query that reads matching rows from both tables together, inner means
// only get rows where the match exists on both sides

$recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);

//SEARCH FUNCTION???? ========================================================

$food_searched = value_trim('q'); //trim query
$food_results = []; // empty array

//not a prepared statement for beta
if ($food_searched !== '') { //if it isn't empty?
    foreach($recipes as $recipe) { // v set everything to lowercase for search 
        if (str_contains(strtolower(e($recipe['title'])), strtolower($food_searched))) {
            $food_results[] = $recipe; //add recipes to results
        }
    }
}


function search_recipe (mysqli $conn):array {
    $sql = 'SELECT * FROM cookbook_recipes
            WHERE title LIKE ? OR description LIKE ?';
    $like = '%' . $q . '%';
    $search_result = mysqli_execute_query($conn, $sql, [$like, $like]);
}

//ADMIN FEATURES ========================================================
// A session-protected admin area: 
// the create / edit / delete pages are gated by a session guard 
// anonymous visitor is redirected to login. 
// Reading recipes can stay public.

function create_recipe(mysqli $conn, string $title, int $category_id): int {
  $sql = 'INSERT INTO recipes (title, category_id) VALUES (?, ?)';
  mysqli_execute_query($conn, $sql, [$title, $category_id]);
  return (int) mysqli_insert_id($conn);
}

function update_title(mysqli $conn, int $id, string $title): void {
  $sql = 'UPDATE recipes SET title = ? WHERE id = ?';
  mysqli_execute_query($conn, $sql, [$title, $id]);
}

function delete_recipe(mysqli $conn, int $id): void {
  mysqli_execute_query($conn, 'DELETE FROM recipes WHERE id = ?', [$id]);
}

function add_steps (mysqli $conn, int $id, string $steps): void {
    $sql = 'UPDATE recipes SET steps = ?';
    mysqli_execute_query($conn, $sql, [$steps]);
} 