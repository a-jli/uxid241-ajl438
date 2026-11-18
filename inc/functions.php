<?php
declare(strict_types=1);

// var_dump($_GET);
// var_dump($_POST);

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
$food_results = []; 

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

//ADMIN FEATURES ========================================================

function create_recipe(mysqli $conn, string $title, string $subtitle, string $description, int $category_id): int {
  $sql = 'INSERT INTO cookbook_recipes (title, subtitle, description, category_id) VALUES (?, ?, ?, ?)';
  mysqli_execute_query($conn, $sql, [$title, $subtitle, $description, $category_id]);
  return (int) mysqli_insert_id($conn);
}

function update_recipe(mysqli $conn, int $id, string $title, string $subtitle, string $description): void {
  $sql = 'UPDATE cookbook_recipes 
  SET title = ?, subtitle = ?, description = ? WHERE id = ?';
  mysqli_execute_query($conn, $sql, [$title, $subtitle, $description, $id]);
}

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

