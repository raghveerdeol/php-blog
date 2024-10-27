<?php 
    session_start();
    if (!isset($_SESSION["loggedin"]) || $_SESSION['loggedin'] === false) {
        header("location: login.php");
    }
    require_once './config.php';

    $search = $_POST['search'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $searchSql = "SELECT posts.id, posts.image, posts.title, categories.* FROM`posts`
    JOIN `categories` ON posts.category_id = categories.id WHERE title LIKE '%$search%'";

        $result = $link->query($searchSql);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="./style/indexStyle.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="./welcome.php">ICON</a>
            <div class="search-container">
                <form class="search-form" action="./search.php" method="POST">
                    <input type="text" name="search" id="search" value="">
                    <button class="buttons" type="submit">Search</button>
                </form>
            </div>
            <div class="actions">
                <a class="buttons" href="./createPost.php">Create Post</a>
                <a class="buttons" href="./logout.php">Logout</a>
            </div>
        </nav>
    </header>

    <main>
        <div class="cards-container">
            <?php if(mysqli_num_rows($result) > 0) {?>
                <?php while ($row = mysqli_fetch_assoc($result)) {?>
                    <div class="card">
                        <img src="<?php echo $row["image"] ?>" alt="<?php echo $row["title"] ?> name">
                        <div class="info">
                            <h2><?php echo $row["title"] ?></h2>
                            <p><?php echo $row["name"] ?></p>
                            <div>
                                <!-- show button  -->
                                <form action="./show.php" method="POST">
                                    <input type="text" value="<?php echo $row["title"]?>" name="postTitle" hidden>
                                    <button type="submit" class="show-button">Show</button>
                                </form>
                                <!-- edit button  -->
                                <form action="./edit.php" method="GET">
                                    <input type="text" value="<?php echo $row["title"]?>" name="postTitle" hidden>
                                    <button type="submit" class="update-button">Edit</button>
                                </form>
                                <!-- delete button  -->
                                <form action="./delete.php" method="POST">
                                    <input type="text" value="<?php echo $row["title"]?>" name="postTitle" hidden>
                                    <button type="submit" class="delete-button">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </main>
</body>
</html>