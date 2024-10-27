<?php 
    session_start();
    if (!isset($_SESSION["loggedin"]) || $_SESSION['loggedin'] === false) {
        header("location: login.php");
    }

    require_once './config.php';
    $postTitle = '';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $postTitle = $_POST['postTitle'];

        $stmt = $link->prepare("DELETE FROM posts WHERE title = ?");
        $stmt->bind_param("s", $postTitle);
        $stmt->execute();
        $postResult = $stmt->get_result();
        header('location: welcome.php');
        exit;
    }
    mysqli_close($link);

?>