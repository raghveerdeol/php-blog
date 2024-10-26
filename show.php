<?php 
session_start();
require_once "./config.php";

$postTitle = '';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $postTitle = $_POST['postTitle'];

    $stmt = $link->prepare("SELECT posts.id, posts.image, posts.content, posts.title, categories.* FROM`posts` JOIN `categories` ON posts.category_id = categories.id WHERE posts.title = ?");
    $stmt->bind_param("s", $postTitle);
    $stmt->execute();
    $postResult = $stmt->get_result();

}
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
    <header>
        <nav class="navbar">
            <div>ICON</div>
            <div class="actions">
                <?php if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {?>
                    <a href="./login.php">Login</a>
                    <a href="./register.php">Sign up</a>
                    <?php } else {?>
                        <a href="./welcome.php">Home</a>
                        <a href="./logout.php">Logout</a>
                <?php } ?>
            </div>
        </nav>
    </header>
    <main>
        <div class="cards-container">
                <?php while($row = mysqli_fetch_assoc($postResult)) {?>
                    <div class="card">
                        <img src="<?php echo $row["image"] ?>" alt="<?php echo $row["title"] ?> name">
                        <h2><?php echo $row["title"] ?></h2>
                        <p><?php echo $row["name"] ?></p>
                        <p><?php echo $row["content"] ?></p>
                    </div>
                <?php } ?>
        </div>
    </main>
</body>
</html>