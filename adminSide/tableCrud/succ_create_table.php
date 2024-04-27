<?php

require_once "../config.php";
$conn = $link;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $table_id = $_POST["table_id"];
    $capacity = $_POST["capacity"];
    
    

    
    $check_query = "SELECT table_id FROM Restaurant_Tables  WHERE table_id = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $table_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    
    if ($check_result->num_rows > 0) {
        $message = "The table_id is already in use.<br>Please try again to choose a different table_id.";
        $iconClass = "fa-times-circle";
        $cardClass = "alert-danger";
        $bgColor = "#FFA7A7"; 
    } else {
        
        


$insert_query = "INSERT INTO Restaurant_Tables (table_id, capacity, is_available) 
                VALUES (?, ?, ?)";
$stmt = $conn->prepare($insert_query);


$is_available = 1;


$stmt->bind_param("ssd", $table_id, $capacity, $is_available);




        
        if ($stmt->execute()) {
            $message = "Table created successfully.";
            $iconClass = "fa-check-circle";
            $cardClass = "alert-success";
            $bgColor = "#D4F4DD"; 
        } else {
            $message = "Error: " . $insert_query . "<br>" . $conn->error;
            $iconClass = "fa-times-circle";
            $cardClass = "alert-danger";
            $bgColor = "#FFA7A7"; 
        }

        
        $stmt->close();
    }

    
    $check_stmt->close();
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
                    window.location.href = "createTable.php";
                }
            }, 1000); 
        }

        
        window.onload = showPopup;

        
        function hidePopup() {
            var messageCard = document.querySelector(".card");
            messageCard.style.display = "none";
            
            setTimeout(function () {
                window.location.href = "createTable.php"; 
            }, 3000); 
        }

        
        setTimeout(hidePopup, 3000);
    </script>
</body>
</html>
