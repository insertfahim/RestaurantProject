<?php
require_once "../config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $account_id = $_POST["account_id"];
    $email = $_POST["email"];
    $register_date = $_POST["register_date"];
    $phone_number = $_POST["phone_number"];
    $password = $_POST["password"];
    $staff_name = $_POST["staff_name"];
    $role = $_POST["role"];
    $conn = $link;
    
    $conn->begin_transaction();
    

    try {
        
        $insert_account_query = "INSERT INTO Accounts (account_id, email, register_date, phone_number, password) VALUES (?, ?, ?, ?, ?)";
        $stmt_account = $conn->prepare($insert_account_query);
        $stmt_account->bind_param("issss", $account_id, $email, $register_date, $phone_number, $password);

        
        if (!$stmt_account->execute()) {
            throw new Exception("Error creating account: " . $stmt_account->error);
        }

        
        $insert_staff_query = "INSERT INTO Staffs (staff_id, staff_name, role, account_id) VALUES (?, ?, ?, ?)";
        $stmt_staff = $conn->prepare($insert_staff_query);
        $stmt_staff->bind_param("issi", $account_id, $staff_name, $role, $account_id);

        
        if (!$stmt_staff->execute()) {
            throw new Exception("Error creating staff: " . $stmt_staff->error);
        }

        
        $conn->commit();

        $message = "Account and Staff created successfully.";
        $iconClass = "fa-check-circle";
        $cardClass = "alert-success";
        $bgColor = "#D4F4DD"; 
    } catch (Exception $e) {
        
        $conn->rollback();

        $message = "Error: " . $e->getMessage();
        $iconClass = "fa-times-circle";
        $cardClass = "alert-danger";
        $bgColor = "#FFA7A7"; 
    } finally {
        
        $stmt_account->close();
        $stmt_staff->close();

        
        $conn->close();
    }
}
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
            .alert-box {
            max-width: 300px;
            margin: 0 auto;
        }

        .alert-icon {
            padding-bottom: 20px;
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