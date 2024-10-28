<?php 
    session_start();
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
        header('location: login.php');
    }
    
    require_once './config.php';
    $categorieQuery = "SELECT * FROM`categories`";
    $categoriesResult = $link->query($categorieQuery);

    $title = '';
    $content = '';
    $image = '';
    $user_id = $_SESSION['id'];
    $category_id = '';

    $title_err = '';
    $content_err = '';
    $image_err = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // title vlidation 
        if (empty(trim($_POST['title']))) {
            $title_err = 'Please enter a title.';
        } else {
            $title = trim($_POST['title']);
        }

        // content validation 
        if (empty(trim($_POST["content"]))) {
            $content_err = 'Please enter content.';
        } else {
            $content = trim($_POST['content']);
        }

        // image content 
        if (empty(trim($_POST['image']))) {
            $image_err = 'Please enter an image.';
        } else {
            $image = trim($_POST['image']);
        }
        $category_id = $_POST['category_id'];
        if (empty($title_err) && empty($content_err) && empty($image_err)) {
            # code...
            $sql = "INSERT INTO posts (title, content, image, user_id, category_id)
                VALUES (?, ?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "sssii", $title, $content, $image, $user_id, $category_id);
                if (mysqli_stmt_execute($stmt)) {
                    // redirect 
                    header('location: welcome.php');
                    exit;
                } else {
                    echo "Something went wrong. Try again.";
                }
            }
        }
    }
    mysqli_close($link);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="./style/postForm.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="./welcome.php"><i class="fa-solid fa-paw"></i></a>
            <div class="actions">
                <a href="./welcome.php" class="buttons">Home</a>
                <a href="./logout.php" class="buttons"><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </nav>
    </header>
    <main>
        <form method="POST" class="post-form" action="./createPost.php" enctype="multipart/form-data">
            <!-- title input  -->
            <div>
                <label for="title">Title</label>
                <input type="text" id="title" name="title" placeholder="Title" value="<?php echo $title ?>">
                <span class="<?php echo (!empty($title_err)) ? 'errorInput' : '' ?>"><?php echo $title_err ?></span>
                <span id="title_validation"></span>
            </div>
            <!-- content input  -->
            <div>
                <label for="content">Content</label>
                <textarea type="text" id="content" name="content" placeholder="Content"><?php echo $content ?></textarea>
                <span class="<?php echo (!empty($content_err)) ? 'errorInput' : '' ?>"><?php echo $content_err ?></span>
                <span id="content_validation"></span>
            </div>
            <!-- image value  -->
            <div>
                <label for="image">Image</label>
                <input type="text" id="image" name="image" placeholder="Image link" value="<?php echo $image ?>">
                <span class="<?php echo (!empty($image_err)) ? 'errorInput' : '' ?>"><?php echo $image_err ?></span>
                <span id="image_validation"></span>
            </div>
            <div class="select-container">
                <select name="category_id" id="category_id">
                    <?php if (mysqli_num_rows($categoriesResult) > 0) { ?>
                        <?php while($row = mysqli_fetch_assoc($categoriesResult)) {?>
                            <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <div>
                <button class="buttons" id="submit-button">Submit</button>
            </div>
        </form>
    </main>
    <script src="./scripts/postForm.js"></script>
</body>
</html>