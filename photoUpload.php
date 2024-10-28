<?php 
    session_start();
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
        header('location: login.php');
    }

    require_once './config.php';
    
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $upload_err = '';
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $userId = $_SESSION['id'];

    // check if image file is actual image or fake image 
    if (isset($_POST['submit'])) {
        $check = getimagesize($_FILES['filetoUpload']['tmp_name']);
        if ($check !== false ) {
            $uploadOk = 1;
        } else{
            $upload_err = "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $upload_err = "Sorry, file already exists.";
        $uploadOk = 0;
    } 

    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $upload_err = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    $upload_err = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $_SESSION['upload_err'] = $upload_err;
        header('location: welcome.php');
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
            // Query per inserire il percorso nel database
            $sql = "UPDATE users SET image = '$target_file' WHERE id = ?"; // Usa un ID specifico

            // Usa prepared statement per maggiore sicurezza
            $stmt = $link->prepare($sql);
            $stmt->bind_param("i", $userId); // Assicurati che $user_id sia definito
            
            if ($stmt->execute()) {
                $_SESSION['upload_err'] = "Image path saved to database successfully.";
                header('location: welcome.php');
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $_SESSION['upload_err'] = "Sorry, there was an error uploading your file.";
            header('location: welcome.php');
        }
    }

    $conn->close();

?>