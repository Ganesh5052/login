<?php
if(!isset($_SESSION) || session_id() == "" || session_status() === PHP_SESSION_NONE){
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Registration and Login in PHP</title>
</head>
<body>
    <div class="topmenu">
        <div class="menubar">
        <a href="index.php">Home</a>
            <?php
            if(isset($_SESSION['name'])){ ?>
                <div class="user"><span>Welcome <?= $_SESSION['name'] ?></span><a href="logout.php">Logout</a></div>
            <?php }
            else{ ?>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
            <?php } ?>
        </div>
    </div>
