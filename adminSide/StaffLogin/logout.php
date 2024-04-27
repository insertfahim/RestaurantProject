<?php

session_start();


unset($_SESSION['logged_account_id']);
unset($_SESSION['logged_staff_name']);


session_destroy();


header("Location: ../../customerSide/home/home.php"); 
exit();
?>