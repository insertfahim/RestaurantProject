<?php

require_once "../config.php";


if (isset($_GET['id'])) {
    
    $item_id = intval($_GET['id']);

    
    $disableForeignKeySQL = "SET FOREIGN_KEY_CHECKS=0;";
    mysqli_query($link, $disableForeignKeySQL);

    
    $deleteSQL = "DELETE FROM Menu WHERE item_id = '" . $_GET['id'] . "';";

    
    if (mysqli_query($link, $deleteSQL)) {
        
        header("location: ../panel/menu-panel.php");
        echo 'deleted';
        exit();
    } else {
        
        echo "Error: " . mysqli_error($link);
    }

    
    $enableForeignKeySQL = "SET FOREIGN_KEY_CHECKS=1;";
    mysqli_query($link, $enableForeignKeySQL);

    
    mysqli_close($link);
}
?>
