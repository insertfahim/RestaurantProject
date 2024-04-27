<?php

require_once "../config.php";


if (isset($_GET['id'])) {
    
    $staff_id = intval($_GET['id']);

    
    $disableForeignKeySQL = "SET FOREIGN_KEY_CHECKS=0;";
    mysqli_query($link, $disableForeignKeySQL);

    
    $deleteSQL = "DELETE FROM Staffs WHERE staff_id = ?";

    
    $stmt = $link->prepare($deleteSQL);
    
    
    $stmt->bind_param("i", $staff_id);

    
    if ($stmt->execute()) {
        
        header("location: ../panel/staff-panel.php");
        exit();
    } else {
        
        echo "Error: " . $stmt->error;
    }

    
    $enableForeignKeySQL = "SET FOREIGN_KEY_CHECKS=1;";
    mysqli_query($link, $enableForeignKeySQL);

    
    $stmt->close();

    
    mysqli_close($link);
}
?>
