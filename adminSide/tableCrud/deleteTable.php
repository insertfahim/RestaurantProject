<?php

require_once "../config.php";


if (isset($_GET['id'])) {
    
    $table_id = intval($_GET['id']);

    
    $disableForeignKeySQL = "SET FOREIGN_KEY_CHECKS = 0";
    mysqli_query($link, $disableForeignKeySQL);


    
    $deleteSQL = "DELETE FROM Restaurant_Tables WHERE table_id = ?";

    
    if ($stmt = mysqli_prepare($link, $deleteSQL)) {
        mysqli_stmt_bind_param($stmt, "i", $table_id);
        if (mysqli_stmt_execute($stmt)) {
            
            header("location: ../panel/table-panel.php");
            exit();
        } else {
            
            echo "Error: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        
        echo "Error: " . mysqli_error($link);
    }

    
    $enableForeignKeySQL = "SET FOREIGN_KEY_CHECKS = 1";
    mysqli_query($link, $enableForeignKeySQL);

    
    mysqli_close($link);
}
?>
