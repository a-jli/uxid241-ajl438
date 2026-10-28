

<?php
//dumping ground for various stuff

    declare(strict_types=1);

    transaction
    function add_ingredients(mysqli $conn, int $recipe_id, array $titles {
        $sql = 'INSERT INTO ingredients (recipe_id, title) VALUES (?, ?)';
        foreach($names as $name) {
            mysqli_e_q($conn, $sql, [$recipe_id, $title])
        }
    })

    mysqli_begin_transaction($conn);
        try {
            $id = create_recipe($conn, 'titletest', 2);
            add_ingredients($conn, $id, ['testingredient', 'testingredient2']);
            mysqli_commit($conn);
            echo 'Saved recipe #{$id} with ingredients';
        } catch (mysqli_sql_exception $e) {
        mysqli_rollback($conn);
        throw $e;
        echo 'save failed';
        }



        
    //what category what recipe
    function recipes_with_category(mysqli $conn): array {
    $sql = 'SELECT cookbook_recipes.title, cookbook_categories.name AS category
            FROM cookbook_recipes
            INNER JOIN cookbook_categories ON cookbook_recipes.category_id = cookbook_categories.id
            ORDER BY cookbook_categories.name, cookbook_recipes.title';
    return mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
    }
    foreach (recipes_with_category($conn) as $row) {
        echo"<p>{$row['category']}:{$row['title']}</p>"; 
    }

//   how many of each category
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

