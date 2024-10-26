<?php 
    session_start();
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
        header('location: login.php');
    }
    
    require_once './config.php';

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
                } else {
                    echo "Something went wrong. Try again.";
                }
            }
        }
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="./style/postForm.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div>ICON</div>
            <div class="actions">
                <a href="./logout.php" class="buttons">Logout</a>
            </div>
        </nav>
    </header>
    <main>
        <form method="POST" class="post-form" action="./createPost.php">
            <!-- title input  -->
            <div>
                <label for="title">Title</label>
                <input type="text" id="title" name="title" placeholder="Title" value="<?php echo $title ?>">
                <span class="error"><?php echo $title_err ?></span>
            </div>
            <!-- content input  -->
            <div>
                <label for="content">Content</label>
                <textarea type="text" id="content" name="content" placeholder="Content"><?php echo $content ?></textarea>
                <span class="error"><?php echo $content_err ?></span>
            </div>
            <!-- image value  -->
            <div>
                <label for="image">Image</label>
                <input type="text" id="image" name="image" placeholder="Image link" value="<?php echo $image ?>">
                <span class="error"><?php echo $image_err ?></span>
            </div>
            <div>
                <select name="category_id" id="category_id">
                    <option value="Select Category">Select Category</option>
                    <option value="1">1</option>
                </select>
            </div>
            <div>
                <button type="submit" class="buttons" value="submit" id="submit">Submit</button>
            </div>
        </form>
    </main>
</body>
</html>