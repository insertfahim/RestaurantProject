<?php
require_once '../../config.php';


$selectQuery = "SELECT kitchen_id FROM Kitchen WHERE time_ended IS NOT NULL ORDER BY time_ended DESC LIMIT 1";
$result = $link->query($selectQuery);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $kitchen_id = $row['kitchen_id'];

   
    $updateQuery = "UPDATE Kitchen SET time_ended = NULL WHERE kitchen_id = $kitchen_id";
    if ($link->query($updateQuery) === TRUE) {
        
        header("Location: ../../panel/kitchen-panel.php"); 
        exit();
    } else {
        
        echo "Error undoing time_ended: " . $link->error;
    }
} else {
    
    echo "No records available to undo.";
    echo '<a class="btn btn-danger" href="javascript:window.history.back();">Back</a>';
}
?>
