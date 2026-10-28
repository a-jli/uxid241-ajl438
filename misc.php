

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


<?php             
            foreach ($recipes as $recipe) 
            $recipe_id = $recipe['id'];
            echo ('$recipe[id] is '. ($recipe['id'].', ' .'"'.$recipe_id).'"'.'<br>');
            echo ('$current id is '. $current_id);
            if ($recipe_id == $current_id):?>
                <div class="recipe-wrapper"> 
                    <div class="recipe-header">
                        <div class="horizontal">
                            <div class="vertical">
                                <h3 class="title"><?= e($recipe['title']) . '<br>'; ?></h3> 
                                <h4 class="subtitle"><?= e($recipe['subtitle']) . '<br>'; ?></h4>
                            <div class="recipe-wrapper-pill">
                                <p class="category"><?= e($recipe['category']); ?></p> 
                                <p class="calories"><?= e($recipe['calories']);?>cal</p>
                                <p class="time"><?= e($recipe['time']); ?> min</p>
                            </div>
                            </div>
                            <?php $images = explode ('*', $recipe['images']);?>
                            <img class="hero-image" src="assets/images/<?= e(end($images)) ?>" alt="">
                        </div>
                    </div>
                    <div class="overview-ingredients">
                        <div>
                            <h2>Overview:</h2>
                            <p><?= e($recipe['description'])?></p>
                        </div>
                        <div>
                            <h2>Ingredients:</h2>
                            <ul>
                                <?php 
                                    $ingredients = explode ("*", $recipe['ingredients']);?>
                                <?php foreach ($ingredients as $ingredient):?>
                                    <li><?=e($ingredient)?></li>
                                <?php endforeach; ?>
                            </ul>                          
                        </div>
                    </div>
                    <hr>
                    <?php $steps = explode ('*', $recipe['steps']);?>
                    <?php $images = explode ('*', $recipe['images']);?>
                        <?php foreach ($steps as $i => $step): ?>
                            <div class="steps-wrapper">
                                <img src="assets/images/<?= e($images[$i]) ?>" alt="">
                                <p><?= e($step) ?></p>
                            </div>
                        <?php endforeach; ?>
                        <a class="view-recipe-btn" href="recipe.php?id=<?= $recipe['id']?>">View Recipe</a>
                    </div>
            <?php endif; ?>    
        </div>  
        <div class="recipe-grid">
            <?php             
            foreach ($recipes as $recipe) :?>
                <div class="recipe-wrapper"> 
                    <div class="recipe-header">
                        <div class="horizontal">
                            <div class="vertical">
                                <h3 class="title"><?= e($recipe['title']) . '<br>'; ?></h3> 
                                <h4 class="subtitle"><?= e($recipe['subtitle']) . '<br>'; ?></h4>
                            <div class="recipe-wrapper-pill">
                                <p class="category"><?= e($recipe['category']); ?></p> 
                                <p class="calories"><?= e($recipe['calories']);?>cal</p>
                                <p class="time"><?= e($recipe['time']); ?> min</p>
                            </div>
                            </div>
                            <?php $images = explode ('*', $recipe['images']);?>
                            <img class="hero-image" src="assets/images/<?= e(end($images)) ?>" alt="">
                        </div>
                    </div>
                    <div class="overview-ingredients">
                        <div>
                            <h2>Overview:</h2>
                            <p><?= e($recipe['description'])?></p>
                        </div>
                        <div>
                            <h2>Ingredients:</h2>
                            <ul>
                                <?php 
                                    $ingredients = explode ("*", $recipe['ingredients']);?>
                                <?php foreach ($ingredients as $ingredient):?>
                                    <li><?=e($ingredient)?></li>
                                <?php endforeach; ?>
                            </ul>                          
                        </div>
                    </div>
                    <hr>
                    <?php $steps = explode ('*', $recipe['steps']);?>
                    <?php $images = explode ('*', $recipe['images']);?>
                        <?php foreach ($steps as $i => $step): ?>
                            <div class="steps-wrapper">
                                <img src="assets/images/<?= e($images[$i + 1]) ?>" alt="">
                                <p><?= e($step) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
            <?php endforeach; ?>    

