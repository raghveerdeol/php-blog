<?php 
// include config file 
require_once "./db/config.php";

$username = "";
$password = "";
$confirm_password = "";

$username_err = "";
$password_err = "";
$confirm_password_err = "";

// precessing form data 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // validate username 
    if(empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // prepare a select statement 
        $sql = "SELECT id FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // set parameters 
            $param_username = trim($_POST["username"]);

            // attempt to execute 
            if (mysqli_stmt_execute($stmt)) {
                // store result 
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = 'This username is already taken.';
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Something went wrong.";
            }
            // close statement 
            mysqli_stmt_close($stmt);
        }
    }

    // validate password 
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST ["password"]);
    }

    // validate confirm password 
    if(empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password din not match";
        }
    }

    // check input errors before inssserting in database 
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        // prepare an insert statement 
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // bind variables to the prepared statement as parameters 
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            // execute the statement 
            if (mysqli_stmt_execute($stmt)) {
                // redirect login page 
                header("location: login.php");
            } else {
                echo "Something wen wrong. Try again.";
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
        <title>Sign Up</title>
    </head>
    <body>
        <header></header>
        <main>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="signUp">
                
                <div>
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="<?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="usernameError"><?php echo $username_err; ?></span>
                </div>

                <div>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="<?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                    <span class="passwordError"><?php echo $password_err; ?></span>
                </div>

                <div>
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="<?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                    <span class="confirmPasswordError"><?php echo $confirm_password_err; ?></span>
                </div>
                    
                <div>
                    <button type="submit" value="submit">Sign up</button>
                    <button type="reset" value="reset">Reset</button>
                </div>
            </form>

            <p>Already have an account? <a href="./login.php">Login here</a></p>
        </main>
    </body>
</html>