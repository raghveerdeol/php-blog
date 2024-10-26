<?php 
    session_start();
    if (!isset($_SESSION["loggedin"]) || $_SESSION['loggedin'] === false) {
        header("location: login.php");
    }
    require_once "./config.php";
    $postsQuery =
    "SELECT posts.id, posts.image, posts.title, categories.* FROM`posts`
    JOIN `categories` ON posts.category_id = categories.id ORDER BY posts.id desc";

    $postsResult = $link->query($postsQuery);
    mysqli_close($link);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>welcome</title>
    <link rel="stylesheet" href="./style/indexStyle.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div>ICON</div>
            <div class="actions">
                <a href="./createPost.php">Create Post</a>
                <a href="./logout.php">Logout</a>
            </div>
        </nav>
    </header>
    <main>
        <div class="cards-container">
            <?php if(mysqli_num_rows($postsResult) > 0) {?>
                <?php while($row = mysqli_fetch_assoc($postsResult)) {?>
                    <div class="card">
                        <img src="<?php echo $row["image"] ?>" alt="<?php echo $row["title"] ?> name">
                        <h2><?php echo $row["title"] ?></h2>
                        <p><?php echo $row["name"] ?></p>
                        <form action="./show.php" method="POST">
                            <input type="text" value="<?php echo $row["title"]?>" name="postTitle" hidden>
                            <button type="submit" class="show-button">Show</button>
                        </form>
                        <form action="./delete.php" method="POST">
                            <input type="text" value="<?php echo $row["title"]?>" name="postTitle" hidden>
                            <button type="submit" class="show-button">Delete</button>
                        </form>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </main>
</body>
</html>