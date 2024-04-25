<?php

require_once "../config.php";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $account_id = $_POST["account_id"];
    $email = $_POST["email"];
    $register_date = $_POST["register_date"];
    $phone_number = $_POST["phone_number"];
    $password = $_POST["password"];
    
    
    $check_account_query = "SELECT account_id FROM Accounts WHERE account_id = ?";
    $check_account_stmt = $conn->prepare($check_account_query);
    $check_account_stmt->bind_param("i", $account_id);
    $check_account_stmt->execute();
    $check_account_result = $check_account_stmt->get_result();
    
    
    $check_email_query = "SELECT email FROM Accounts WHERE email = ?";
    $check_email_stmt = $conn->prepare($check_email_query);
    $check_email_stmt->bind_param("s", $email);
    $check_email_stmt->execute();
    $check_email_result = $check_email_stmt->get_result();

    
    if ($check_account_result->num_rows > 0) {
        $message = "Account ID already exists. Please choose another Account ID.";
        $iconClass = "fa-times-circle";
        $cardClass = "alert-danger";
        $bgColor = "#FFA7A7"; 
    } elseif ($check_email_result->num_rows > 0) {
        $message = "Email already exist for another an account. Please choose another email.";
        $iconClass = "fa-times-circle";
        $cardClass = "alert-danger";
        $bgColor = "#FFA7A7"; 
    } else {
        $insert_query = "INSERT INTO Accounts (account_id, email, register_date, phone_number, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);

        $stmt->bind_param("issss", $account_id, $email, $register_date, $phone_number, $password);

        
        if ($stmt->execute()) {
            $message = "Account created successfully.";
            $iconClass = "fa-check-circle";
            $cardClass = "alert-success";
            $bgColor = "#D4F4DD"; 
        } else {
            $message = "Error: " . $stmt->error . " (Error code: " . $stmt->errno . ")";
            $iconClass = "fa-times-circle";
            $cardClass = "alert-danger";
            $bgColor = "#FFA7A7"; 
        }

        
        $stmt->close();
    }

    
    $check_account_stmt->close();
    $conn->close();
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
                    window.location.href = "createStaffAccount.php";
                }
            }, 1000); 
        }

        
        window.onload = showPopup;

        
        function hidePopup() {
            var messageCard = document.querySelector(".card");
            messageCard.style.display = "none";
            
            setTimeout(function () {
                window.location.href = "createStaffAccount.php"; 
            }, 3000); 
        }

        
        setTimeout(hidePopup, 3000);
    </script>
</body>
</html>
