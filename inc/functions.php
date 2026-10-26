<?php
declare(strict_types=1);

echo('functions loaded');

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

function get_all_recipes (mysqli $conn):array {
    $sql = 'SELECT id, title, FROM recipes 
    ORDER BY id ASC';
    return mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
}

// function get_recipe (mysqli $conn, int $id):?array {
//     $result = mysqli_execute_query ($conn, $sql) 
//     'SELECT * FROM recipes WHERE $id=1';
// }


                                                                          //rename categories.name to category, less clunky 
  $result = mysqli_query($conn, 'SELECT cookbook_recipes.title, subtitle, cookbook_categories.name AS category, description, servings, time, calories, ingredients, steps, images, step3, step4, step5, step6
  FROM cookbook_recipes
  INNER JOIN cookbook_categories ON cookbook_recipes.category_id = cookbook_categories.id');
  // join - query that reads matching rows from both tables together, inner means we only get rows where the match exists on both sides

  $recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);

  //how many of each category
  function category_count(mysqli $conn){
      $sql = 'SELECT cookbook_categories.name, COUNT(*) AS recipes_count 
      FROM cookbook_recipes
      INNER JOIN cookbook_categories ON cookbook_recipes.category_id = cookbook_categories.id
      GROUP BY cookbook_categories.name
      ORDER BY recipes_count DESC';
      return mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
  }
  
  foreach (category_count($conn) as $row) {
      echo"<p>{$row['name']}:{$row['recipes_count']}</p>"; 
  }


?>