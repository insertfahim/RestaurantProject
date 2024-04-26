<?php

require_once '../config.php';
session_start();


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    
    header("Location: ../home/home.php");
    exit;
}


setcookie('cookie_name', '', time() - 3600, '/');


$_SESSION = array();
session_destroy();


header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https:
    
    <!-- Custom CSS styles for the alert box -->
    <style>
        .alert-box {
            max-width: 300px;
            margin: 0 auto;
        }

        .alert-icon {
            padding-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php
    header("location: ../home/home.php"); 
    exit;
?>
</body>
</html>
