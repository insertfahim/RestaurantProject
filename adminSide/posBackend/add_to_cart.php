<?php
require_once '../config.php';

$bill_id = $_POST['bill_id'];
$item_id = $_POST['item_id'];


$existingItemQuery = "SELECT * FROM Bill_Items WHERE bill_id = $bill_id AND item_id = '$item_id'";
$existingItemResult = mysqli_query($link, $existingItemQuery);

if (mysqli_num_rows($existingItemResult) > 0) {
    
    $updateQuantityQuery = "UPDATE Bill_Items SET quantity = quantity + 1 WHERE bill_id = $bill_id AND item_id = '$item_id'";
    mysqli_query($link, $updateQuantityQuery);
} else {
    
    $insertItemQuery = "INSERT INTO Bill_Items (bill_id, item_id, quantity) VALUES ($bill_id, '$item_id', 1)";
    mysqli_query($link, $insertItemQuery);
}


mysqli_close($link);
?>
