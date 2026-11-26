<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Fallback for servers running PHP older than 8.2 (such as the school's digm
// server), where mysqli_execute_query() doesn't exist yet. It does the same
// job with older mysqli functions: prepare the SQL, bind each value to its ?,
// then run it. On PHP 8.2 and newer the real function exists, so this block
// is skipped.
if (!function_exists('mysqli_execute_query')) {
function mysqli_execute_query(mysqli $mysql, string $query, ?array $params = null): mysqli_result|bool {
// Keep the latest statement alive until the next query, so
// mysqli_affected_rows() and mysqli_insert_id() still report its result
// (closing it would reset them).
static $last_statement = null;
 
$statement = mysqli_prepare($mysql, $query);
$last_statement = $statement;
 
if ($params !== null && $params !== []) {
$types = '';
foreach ($params as $value) {
$types .= is_int($value) ? 'i' : (is_float($value) ? 'd' : 's');
}
$values = array_values($params);
mysqli_stmt_bind_param($statement, $types, ...$values);
}

mysqli_stmt_execute($statement);
 
// INSERT, UPDATE and DELETE return no rows: report success with true,
// like the real function, without asking for a result.
if (mysqli_stmt_result_metadata($statement) === false) {
return true;
}
 
return mysqli_stmt_get_result($statement);
}
}

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

function get_recipe (mysqli $conn, int $id):?array {
    $sql = 'SELECT cookbook_recipes.id, 
    cookbook_recipes.title, 
    subtitle, 
    cookbook_categories.name 
    AS category, description, servings, time, calories, ingredients, steps, images 
    FROM cookbook_recipes 
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

$recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);

//SEARCH FUNCTION???? ========================================================

$food_searched = value_trim('q'); 
$food_filtered = value_trim('protein');

$food_results = []; 
$filter_results = []; 

echo 'filtered category $food_filtered is ' . $food_filtered;

function find_recipes(mysqli $conn, string $q, int $category_id): array {
  $sql = 'SELECT cookbook_recipes.id, cookbook_recipes.title, subtitle,
      cookbook_categories.name AS category, calorie, time, images
    FROM cookbook_recipes
    INNER JOIN cookbook_categories
      ON cookbook_recipes.category_id = cookbook_categories.id
    WHERE 1 = 1'; //always true so every condition starts w/ and
  $parameters = [];

  if (q !== '') { //searching by title, sub, or desc
    $sql .= 'AND (cookbook_recipes.title LIKE ? OR cookbook_recipes.subtitle LIKE ? OR cookbook_recipes.description LIKE ?)';
    $like = '%' . $q . '%';
    $parameters[] =  $like;
    $parameters[] =  $like;
    $parameters[] =  $like;
  }
  if ($category_id > 0) {
    $sql .= 'AND cookbook_recpes.category_id = ?';
    $parameters[] = $category_id;
  }

  $sql .= ' ORDER BY cookbook_recipes.id ASC';
  return mysqli_fetch_all(mysqli_execute_query($conn, $sql, $parameters), MYSQLI_ASSOC);
}

function search_recipe (mysqli $conn, string $q):array {
    $like = '%' . $q . '%';
    $result = mysqli_execute_query(
        $conn,
        'SELECT cookbook_recipes.id, cookbook_recipes.title, subtitle,
                cookbook_categories.name AS category, description, servings, time,
                calories, ingredients, steps, images
        FROM cookbook_recipes
        INNER JOIN cookbook_categories
        ON cookbook_recipes.category_id = cookbook_categories.id
        WHERE cookbook_recipes.title LIKE ? OR cookbook_recipes.description LIKE ?
        ORDER BY cookbook_recipes.id ASC',
        [$like, $like]
    );
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function filter_recipe (mysqli $conn, string $protein):array {
    $like = '%' . $protein . '%';
    echo 'protein is ' . $protein . '! ';
    $filter_results =  mysqli_execute_query(
      $conn,
        'SELECT cookbook_recipes.id, cookbook_recipes.title, subtitle,
                cookbook_categories.name AS category, description, servings, time,
                calories, ingredients, steps, images
        FROM cookbook_recipes
        INNER JOIN cookbook_categories
        ON cookbook_recipes.category_id = cookbook_categories.id
      WHERE cookbook_recipes.category_id = ?
      ORDER BY cookbook_recipes.id ASC',
      [$like]
    );
    return mysqli_fetch_all($filter_results, MYSQLI_ASSOC);
}


//ADMIN FEATURES ========================================================
function create_recipe(mysqli $conn, 
    string $title, 
    string $subtitle, 
    string $description, 
    string $ingredients,
    int $category_id, 
    int $servings, 
    int $time, 
    int $calories
   ): int {
  $sql = 'INSERT INTO cookbook_recipes (
    title, 
    subtitle, 
    description,
    ingredients,
    category_id,
    servings, 
    time, 
    calories 
) 
  VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
  mysqli_execute_query($conn, $sql, [$title, $subtitle, $description, $ingredients, $category_id, $servings, $time, $calories]);
  return (int) mysqli_insert_id($conn);
}

// mysqli_execute_query(
//     $conn,
//     'INSERT INTO cookbook_recipes (title, subtitle, description, category_id) VALUES (?, ?, ?, ?)',
//     [$addedTitle, $addedSubtitle, $addedDescription, $addedCategory]
// );

function update_recipe(
  mysqli $conn, $id,
    string $title, 
    string $subtitle, 
    string $description, 
    string $ingredients,
    int $category_id, 
    int $servings, 
    int $time, 
    int $calories,
): void {
  $sql = 'UPDATE cookbook_recipes 
  SET 
  title = ?, 
  subtitle = ?, 
  description = ?,
  ingredients = ?,
  category_id = ?,
  servings = ?,
  time = ?,
  calories = ?
    WHERE id = ?';
  // Uncaught mysqli_sql_exception: Cannot add or update a child row: a foreign key constraint fails 
  // (`idm232_db`.`cookbook_recipes`, CONSTRAINT `category` FOREIGN KEY (`category_id`) REFERENCES `cookbook_categories` (`id`))
  mysqli_execute_query($conn, $sql, [$title, $subtitle, $description, $ingredients, $category_id, $servings, $time, $calories, $id]);
}

// function update_recipe(mysqli $conn, 
// int $id, string $title, string $subtitle, string $description): void {
//   $sql = 'UPDATE cookbook_recipes 
//   SET title = ?, subtitle = ?, description = ?\
//   WHERE id = ?';
//   mysqli_execute_query($conn, $sql, [$title, $subtitle, $description, $id]);
// }

function delete_recipe(mysqli $conn, int $id): void {
  mysqli_execute_query($conn, 'DELETE FROM cookbook_recipes WHERE id = ?', [$id]);
}

function add_steps (mysqli $conn, int $id, string $steps): void {
    $sql = 'UPDATE cookbook_recipes SET steps = ? WHERE id = ?';
    mysqli_execute_query($conn, $sql, [$steps, $id]);
} 

function add_images (mysqli $conn, int $id, string $images): void {
  $sql = 'UPDATE cookbook_recipes SET images = ? WHERE id = ?';
  mysqli_execute_query($conn, $sql, [$images, $id]);
}





// image upload
function save_upload (
  string $tmp_name,
  string $original_name,
  int $size,
  int $error,
  string $folder
): string {
  if ($error !== UPLOAD_ERR_OK) {
    throw new RuntimeException ('Upload failed.');
  }
  $max_bytes = 2*1024*1024;
  if ($size > $max_bytes) {
    throw new RuntimeException ('File too large.');
  }
  $finfo = new finfo(FILEINFO_MIME_TYPE);
  $mime = $finfo -> file($tmp_name);
  $ext_map = array(
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp'
  );

  if (!isset($ext_map[$mime])) {
    throw new RuntimeException('Type not allowed.');
  } 

  $ext = $ext_map[$mime];

  $safe_name  = make_safe_name($original_name, $ext, $folder);
  if (!move_uploaded_file($tmp_name, $folder . '/' . $safe_name)) {
      throw new RuntimeException('Could not save file.');
  }

  return $safe_name;
}

function make_safe_name(
    string $original_name,
    string $ext,
    string $folder
  ):string {
  $base = pathinfo($original_name, PATHINFO_FILENAME);
  $base = strtolower($base);
  $base = preg_replace('/[^a-z0-9]+/','-', $base);
  $base = trim($base, '-');
  $base = substr($base, 0, 60);
  if ($base === '') {
    $base = 'upload';
  }
  
  $safe_name = $base . '.' . $ext;
  $counter = 1;

  while (file_exists($folder . '/' . $safe_name)) {
    $safe_name = $base . '-' . $counter . '.' . $ext;
    $counter++;
  }
  return $safe_name;
}

