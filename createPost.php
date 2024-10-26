<?php 
    session_start();
    if ($_SESSION["loggedin"] === false) {
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
        <form method="POST" class="post-form">
            <!-- title input  -->
            <div>
                <label for="title">Title</label>
                <input type="text" id="title" name="title" placeholder="Title" value="<?php echo $title ?>">
            </div>
            <!-- content input  -->
            <div>
                <label for="content">Content</label>
                <textarea type="text" id="content" name="content" placeholder="Content" value="<?php echo $content ?>"></textarea>
            </div>
            <!-- image value  -->
            <div>
                <label for="image">Image</label>
                <input type="text" id="image" name="image" placeholder="Image link" value="<?php echo $image ?>">
            </div>
            <div>
                <a type="submit" class="buttons" id="submit">Submit</a>
            </div>
        </form>
    </main>
</body>
</html>