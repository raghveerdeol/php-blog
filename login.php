<?php 

    session_start();
    
    // check if user is already logged in 
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header("location: welcome.php");
        exit;
    }

    require_once "./config.php";

    $username = '';
    $password = '';

    $username_err = '';
    $password_err = '';

    // processiong form 
    if($_SERVER["REQUEST_METHOD"] == "POST"){ 
        // check user name 
        if (empty(trim($_POST["username"]))) {
            $username_err = "Please enter username.";
        } else {
            $username = trim($_POST["username"]);
        }

        // check password 
        if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter password.";
        } else {
            $password = trim($_POST["password"]);
        }
        
        // validate credentials
        if (empty($username_err) && empty($password_err)) {
            // prepare a select statement 
            $sql = "SELECT id, username, password FROM users WHERE username = ?";

            if ($stmt = mysqli_prepare($link, $sql)) {
                // bind variables 
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                $param_username = $username;
                // attempt to execute 
                if (mysqli_stmt_execute($stmt)) {
                    // store result 
                    mysqli_stmt_store_result($stmt);

                    // check username 
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

                        if (mysqli_stmt_fetch($stmt)) {
                            if (password_verify($password, $hashed_password)) {
                                // password is correct 
                                session_start();

                                // store data in session 
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;
                                // redirect 
                                header("location: welcome.php");
                            } else {
                                // error 
                                $login_err = "Invalid Username o Password.";
                            }
                        }
                    } else {
                        // username doesn't exist 
                        $login_err = "Invalid Username o Password.";
                    }
                } else {
                    echo "Something went wrong. Try Again.";
                }
                mysqli_stmt_close($stmt);
            }
        }
        mysqli_close($link);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
    </head>
    <body>
        <header>
            <nav class="navbar">
                <div>ICON</div>
                <div class="actions">
                    <a href="./register.php" class="buttons">Sign up</a>
                    <link rel="stylesheet" href="./style/login.css">
                </div>
            </nav>
        </header>
        <Main>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="<?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" >
                <span class="<?php echo (!empty($username_err)) ? 'errorInput' : ''; ?>"><?php echo $username_err ?></span>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="<?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="<?php echo (!empty($username_err)) ? 'errorInput' : ''; ?>" ><?php echo $password_err ?></span>
            </div>
            <div class="buttons-container">
                <button type="submit" value="Login" class="buttons form-buttons">Submit</button>
            </div>
        </form>
        <p>Don't have an account? <a href="./register.php">Sign up now</a>.</p>
        </Main>
    </body>
</html>