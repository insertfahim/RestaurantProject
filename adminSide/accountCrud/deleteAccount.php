<?php

require_once "../config.php";

if (isset($_GET['id'])) {
    
    $account_id = intval($_GET['id']);

    
    $disableForeignKeySQL = "SET FOREIGN_KEY_CHECKS=0;";
    mysqli_query($link, $disableForeignKeySQL);

    
    $deleteSQL = "DELETE FROM Accounts WHERE account_id = ?";

    
    if ($stmt = mysqli_prepare($link, $deleteSQL)) {
        
        mysqli_stmt_bind_param($stmt, "i", $account_id);

        
        if (mysqli_stmt_execute($stmt)) {
            
            header("location: ../panel/account-panel.php");
            exit();
        } else {
            
            echo "Error: " . mysqli_error($link);
        }

        
        mysqli_stmt_close($stmt);
    } else {
        
        echo "Error: " . mysqli_error($link);
    }

    
    $enableForeignKeySQL = "SET FOREIGN_KEY_CHECKS=1;";
    mysqli_query($link, $enableForeignKeySQL);

    
    mysqli_close($link);
}
?>
