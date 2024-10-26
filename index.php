<?php 
session_start();
require_once "./config.php";

$postsQuery = "SELECT posts.*, categories.name FROM `posts` INNER JOIN `categories`";
$postsResult = $link->query($postsQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="./style/indexStyle.css">
</head>
<body>
    <header></header>
    <main>
        <div class="cards-container">
            <?php if(mysqli_num_rows($postsResult) > 0) {?>
                <?php while($row = mysqli_fetch_assoc($postsResult)) {?>
                    <div class="card">
                    <img src="<?php echo $row["image"] ?>" alt="<?php echo $row["title"] ?> name">
                    <h2><?php echo $row["title"] ?></h2>
                    <p><?php echo $row["name"] ?></p>
                </div>
            <?php } ?>
            <?php } ?>
        </div>
    </main>
</body>
</html>