<?php 
    session_start();
    if (!isset($_SESSION["loggedin"]) || $_SESSION['loggedin'] === false) {
        header("location: login.php");
    }
    require_once "./config.php";
    $postsQuery =
    "SELECT posts.id, posts.image, posts.title, posts.user_id,categories.* FROM`posts`
    JOIN `categories` ON posts.category_id = categories.id ORDER BY posts.id desc";

    $userId = $_SESSION['id'];
    $userImage = "SELECT users.image FROM `users` WHERE id = '$userId'";

    $postsResult = $link->query($postsQuery);
    $imageResult = $link->query($userImage);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>welcome</title>
    <link rel="stylesheet" href="./style/indexStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo"><i class="fa-solid fa-paw"></i></div>
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
        <section class="welcome">
            <?php while($row = mysqli_fetch_assoc($imageResult)) {?>
                <?php if($row['image']) {?>
                    <div class="avatar-container">
                        <img src="<?php echo $row['image'] ?>" alt="<?php echo $_SESSION['username'] ?>.foto"  id="avatar">
                    </div>
                    <?php } else {?>
                        <div class="avatar-container" id="opacity">
                            <img src="./uploads/avatar.jpg" alt="no-foto"  id="avatar" class="add-foto">
                        </div>
                    <?php } ?>
                <?php } ?>
            <form action="./photoUpload.php" method="POST" class="hidden" enctype="multipart/form-data" id="form-upload">
                <input type="file" name="fileToUpload" id="fileToUpload" class="hidden" >
                <button id="upload" class="hidden">Upload</button>
            </form>
            <span id="image_validation"></span>
            <div class="user-info">
                <h1>Welcome<div class="user-name"><?php echo $_SESSION['username'] ?></div></h1>
            </div>
        </section>

        <div class="cards-container">
            <?php if(mysqli_num_rows($postsResult) > 0) {?>
                <?php while($row = mysqli_fetch_assoc($postsResult)) {?>
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
                                        <button class="delete-button" id="delete">Delete</button>
                                <?php } ?>
                            </div>
                        </div>
                        <div id="delete-confirm" class="hidden"> 
                            <p>Are you sure?</p>
                            <form action="./delete.php" method="POST">
                                <input type="text" value="<?php echo $row["title"]?>" name="postTitle" hidden>
                                <button type="submit" class="delete-button" id="yes-delete">Delete</button>
                            </form>
                            <button id="cancel">Cancel</button>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </main>

    <script src="./scripts/welcome.js"></script>
</body>
</html>