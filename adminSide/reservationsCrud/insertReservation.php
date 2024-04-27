<?php

require_once '../config.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $customer_name = $_POST["customer_name"];
    $table_id = intval($_POST["table_id"]);
    $reservation_time = $_POST["reservation_time"];
    $reservation_date = $_POST["reservation_date"];
    $special_request = $_POST["special_request"];
    
    $select_query_capacity = "SELECT capacity FROM restaurant_tables WHERE table_id='$table_id';";
    $results_capacity = mysqli_query($link, $select_query_capacity);

    if ($results_capacity) {
        $row = mysqli_fetch_assoc($results_capacity);
        $head_count = $row['capacity'];
        $reservation_id = intval($reservation_time)  . intval($reservation_date)  . intval($table_id);
        
        $insert_query1 = "INSERT INTO Reservations (reservation_id, customer_name, table_id, reservation_time, reservation_date, head_count, special_request) 
                        VALUES ('$reservation_id', '$customer_name', '$table_id', '$reservation_time', '$reservation_date', '$head_count', '$special_request');";
        $insert_query2 = "INSERT INTO Table_Availability (availability_id, table_id, reservation_date, reservation_time, status) 
                        VALUES ('$reservation_id', '$table_id', '$reservation_date', '$reservation_time',  'no');";
        mysqli_query($link, $insert_query1);
        mysqli_query($link, $insert_query2);

        $_SESSION['customer_name'] = $customer_name;
        
    } else {
        
        echo "Error fetching table capacity: " . mysqli_error($link);
    }
}
?>

<?php

$iconClass = 'fa-check-circle'; 
$cardClass = 'alert-success';   
$bgColor = "#D4F4DD";


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
        <p>Reservation Created Successfully!</p>
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
                    window.location.href = "../panel/reservation-panel.php";
                }
            }, 1000); 
        }

        
        window.onload = showPopup;

        
        function hidePopup() {
            var messageCard = document.querySelector(".card");
            messageCard.style.display = "none";
            
            setTimeout(function () {
                window.location.href = "../panel/reservation-panel.php"; 
            }, 3000); 
        }

        
        setTimeout(hidePopup, 3000);
    </script>
</body>
</html>