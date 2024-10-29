<?php 
    session_start();
    if (!isset($_SESSION["loggedin"]) || $_SESSION['loggedin'] === false) {
        header("location: login.php");
    }
    require_once './config.php';

    $search = $_POST['search'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty(trim($search))) {
        $searchSql = "SELECT posts.id, posts.image, posts.title, user_id, categories.* FROM`posts`
    JOIN `categories` ON posts.category_id = categories.id WHERE title LIKE '%$search%'";

        $result = $link->query($searchSql);
    } else {
        header('location: welcome.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="./style/indexStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="./welcome.php" class="logo search-logo"><i class="fa-solid fa-paw"></i></a>
            <div class="search-container">
                <form class="search-form" action="./search.php" method="POST">
                    <input type="text" name="search" id="search" value="">
                    <button class="buttons" type="submit">Search</button>
                </form>
            </div>
            <div class="actions">
                <a class="buttons" href="./createPost.php">Create Post</a>
                <a class="buttons" href="./logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
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
                                <?php if ($_SESSION['id'] == $row['user_id']) {?>
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
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else {?>
                <div class="empty-search">There is no match.</div>
            <?php } ?>
        </div>
    </main>
</body>
</html>