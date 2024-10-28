<?php 
session_start();
require_once "./config.php";

$postTitle = '';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $postTitle = $_POST['postTitle'];

    $stmt = $link->prepare("SELECT posts.id, posts.image, posts.user_id, posts.content, posts.title, categories.* FROM`posts` JOIN `categories` ON posts.category_id = categories.id WHERE posts.title = ?");
    $stmt->bind_param("s", $postTitle);
    $stmt->execute();
    $postResult = $stmt->get_result();
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="./style/show.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <nav class="navbar">
            <?php if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {?>
                <a href="./index.php"><i class="fa-solid fa-paw"></i></a>
            <?php } else {?>
                <a href="./welcome.php"><i class="fa-solid fa-paw"></i></a>
            <?php } ?>
            <div class="actions">
                <?php if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {?>
                    <a href="./login.php">Login</a>
                    <a href="./register.php">Sign up</a>
                    <?php } else {?>
                        <a href="./welcome.php">Home</a>
                        <a href="./logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
                <?php } ?>
            </div>
        </nav>
    </header>
    <main>
        <div class="cards-container">
            <?php while($row = mysqli_fetch_assoc($postResult)) {?>
                <div class="card">
                    <img src="<?php echo $row["image"] ?>" alt="<?php echo $row["title"] ?> name">
                    <div class="info">
                        <h2><?php echo $row["title"] ?></h2>
                        <p><em><?php echo $row["name"] ?></em></p>
                        <p><?php echo $row["content"] ?></p>
                        <div>
                            <?php if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {?>
                            <?php } else { ?>
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
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
</body>
</html>