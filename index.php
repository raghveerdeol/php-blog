<?php 
session_start();
require_once "./config.php";

$postsQuery = "SELECT * FROM `posts`";
$result = $link->query($postsQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
</head>
<body>
    <header></header>
    <main>
        <ul>
            <?php if(mysqli_num_rows($result) > 0) {?>
                <?php while($row = mysqli_fetch_assoc($result)) {?>
                    <div class="card">
                        <img src="<?php echo $row["image"] ?>" alt="<?php echo $row["title"] ?> name">
                        <li><?php echo $row["title"] ?></li>
                    </div>
                <?php } ?>
            <?php } ?>
        </ul>
    </main>
</body>
</html>