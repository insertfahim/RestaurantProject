<?php
require_once '../config.php';

if (isset($_GET['bill_item_id'])) {
    $bill_item_id = $_GET['bill_item_id'];
    $table_id = $_GET['table_id'];
    $item_id = $_GET['item_id'];


    
    $delete_query = "DELETE FROM bill_items WHERE bill_item_id = '$bill_item_id'";
    
    if (mysqli_query($link, $delete_query)) {
        
        $update_kitchen_sql = "DELETE FROM Kitchen WHERE table_id = '$table_id' AND item_id = '$item_id'";
        if (mysqli_query($link, $update_kitchen_sql)) {
            echo "Record deleted successfully from Kitchen table.";
        } else {
            echo "Error deleting record: " . mysqli_error($link);
        }

        
        header("Location: orderItem.php?bill_id={$_GET['bill_id']}&delete_success=1&table_id={$table_id}");
        exit();
    } else {
        
        echo "Error deleting item: " . mysqli_error($link); 
        header("Location: orderItem.php?bill_id={$_GET['bill_id']}&delete_error=1&table_id={$table_id}");
        exit();
    }
} else {
    
    echo "bill_item_id not provided."; 
    header("Location: orderItem.php?bill_id={$_GET['bill_id']}&table_id={$table_id}");
    exit();
}
?>
