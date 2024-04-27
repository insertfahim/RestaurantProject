<?php
require_once "../config.php";

$iconClass = 'fa-check-circle'; 
$cardClass = 'alert-success';   
$bgColor = "#D4F4DD";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $account_id = $_POST['account_id'];
    $staff_id = $_POST['staff_id'];

    
    $account_id = intval($account_id);
    $staff_id = intval($staff_id);

    $checkAccountQuery = "SELECT * FROM Accounts WHERE account_id = ?";
    $checkStaffQuery = "SELECT * FROM staffs WHERE staff_id = ?";

    
    $accountStmt = $conn->prepare($checkAccountQuery);
    $accountStmt->bind_param("i", $account_id);
    $accountStmt->execute();
    $accountResult = $accountStmt->get_result();

    $staffStmt = $conn->prepare($checkStaffQuery);
    $staffStmt->bind_param("i", $staff_id);
    $staffStmt->execute();
    $staffResult = $staffStmt->get_result();

    if ($accountResult->num_rows === 0) {
        echo "Invalid account ID. No matching account found.";
    } elseif ($staffResult->num_rows === 0) {
        echo "Invalid staff ID. No matching staff found.";
    } else {
        
        $existingStaffQuery = "SELECT staff_id FROM Accounts WHERE account_id = ?";
        $existingStaffStmt = $conn->prepare($existingStaffQuery);
        $existingStaffStmt->bind_param("i", $account_id);
        $existingStaffStmt->execute();
        $existingStaffResult = $existingStaffStmt->get_result();
        $row = $existingStaffResult->fetch_assoc();
        $existingStaffId = $row['staff_id'];

        if ($existingStaffId !== null) {
            echo "Account already has a staff assigned.";
        } else {
            $updateQuery = "UPDATE Accounts SET staff_id = ? WHERE account_id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ii", $staff_id, $account_id);

            if ($updateStmt->execute()) {
                $message = "Account assigned to staff successfully.";
            } else {
                $message = "Error updating staff.";
            }
        }
    }

    
    $accountStmt->close();
    $staffStmt->close();
    $existingStaffStmt->close();
    $updateStmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <style>
       
        body {
            text-align: center;
            padding: 40px 0;
            background: #EBF0F5;
        }
        h1 {
            color: #88B04B;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-weight: 900;
            font-size: 40px;
            margin-bottom: 10px;
        }
        p {
            color: #404F5E;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-size: 20px;
            margin: 0;
        }
        i.checkmark {
            color: #9ABC66;
            font-size: 100px;
            line-height: 200px;
            margin-left: -15px;
        }
        .card {
            background: white;
            padding: 60px;
            border-radius: 4px;
            box-shadow: 0 2px 3px #C8D0D8;
            display: inline-block;
            margin: 0 auto;
        }
       
        .alert-success {
           
            background-color: <?php echo $bgColor; ?>;
        }
        .alert-success i {
            color: #5DBE6F;
        }
        .alert-danger {
           
            background-color: #FFA7A7;
        }
        .alert-danger i {
            color: #F25454;
        }
        .custom-x {
            color: #F25454;
            font-size: 100px;
            line-height: 200px;
        }
    </style>
</head>
<body>
    <div class="card <?php echo $cardClass; ?>" style="display: none;">
        <div style="border-radius: 200px; height: 200px; width: 200px; background: #F8FAF5; margin: 0 auto;">
            <?php if ($iconClass === 'fa-check-circle'): ?>
                <i class="checkmark">✓</i>
            <?php else: ?>
                <i class="custom-x" style="font-size: 100px; line-height: 200px;">✘</i>
            <?php endif; ?>
        </div>
        <h1><?php echo ($cardClass === 'alert-success') ? 'Success' : 'Error'; ?></h1>
        <p><?php echo $message; ?></p>
    </div>

    <div style="text-align: center; margin-top: 20px;">Redirecting back in <span id="countdown">3</span></div>

    <script>
        
        function showPopup() {
            var messageCard = document.querySelector(".card");
            messageCard.style.display = "block";

            var i = 3;
            var countdownElement = document.getElementById("countdown");
            var countdownInterval = setInterval(function() {
                i--;
                countdownElement.textContent = i;
                if (i <= 0) {
                    clearInterval(countdownInterval);
                    window.location.href = "../panel/staff-panel.php";
                }
            }, 1000); 
        }

        
        window.onload = showPopup;

        
        function hidePopup() {
            var messageCard = document.querySelector(".card");
            messageCard.style.display = "none";
            
            setTimeout(function () {
                window.location.href = "../panel/staff-panel.php"; 
            }, 3000); 
        }

        
        setTimeout(hidePopup, 3000);
    </script>
</body>
</html>