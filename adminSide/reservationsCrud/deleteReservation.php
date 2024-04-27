<?php

require_once "../config.php";


if (isset($_GET['id'])) {
    
    $reservation_id = intval($_GET['id']);

    
    
    $deleteBillItemsSQL = "DELETE FROM bill_items WHERE bill_id IN (SELECT bill_id FROM bills WHERE reservation_id = ?)";
    if ($stmt = mysqli_prepare($link, $deleteBillItemsSQL)) {
        mysqli_stmt_bind_param($stmt, "i", $reservation_id);
        if (mysqli_stmt_execute($stmt)) {
            
            $deleteBillsSQL = "DELETE FROM bills WHERE reservation_id = ?";
            if ($stmt = mysqli_prepare($link, $deleteBillsSQL)) {
                mysqli_stmt_bind_param($stmt, "i", $reservation_id);
                if (mysqli_stmt_execute($stmt)) {
                    
                    $deleteReservationSQL = "DELETE FROM Reservations WHERE reservation_id = ?";
                    if ($stmt = mysqli_prepare($link, $deleteReservationSQL)) {
                        mysqli_stmt_bind_param($stmt, "i", $reservation_id);
                        if (mysqli_stmt_execute($stmt)) {
                            
                            header("location: ../panel/reservation-panel.php");
                            exit();
                        } else {
                            
                            echo "Error: " . mysqli_stmt_error($stmt);
                        }
                    }
                } else {
                    
                    echo "Error: " . mysqli_stmt_error($stmt);
                }
            }
        } else {
            
            echo "Error: " . mysqli_stmt_error($stmt);
        }

        
        mysqli_stmt_close($stmt);
    } else {
        
        echo "Error: " . mysqli_error($link);
    }

    
    mysqli_close($link);
}
?>
