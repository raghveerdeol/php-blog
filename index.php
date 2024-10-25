<?php 
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <header></header>
    <main>
        <form action="./index.php" method="POST" class="login">

            <label for="user">User</label>
            <input type="text" name="user" id="user" for="name">

            <label for="password">Password</label>
            <input type="password" name="password" id="password">

            <button type="submit">Login</button>
        </form>
    </main>
</body>
</html>