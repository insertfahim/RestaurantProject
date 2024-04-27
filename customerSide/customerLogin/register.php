<?php

require_once '../config.php';
session_start();


$email = $member_name = $password = $phone_number = "";
$email_err = $member_name_err = $password_err = $phone_number_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    
    if (empty(trim($_POST["member_name"]))) {
        $member_name_err = "Please enter your member name.";
    } else {
        $member_name = trim($_POST["member_name"]);
    }

    
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    
    if (empty(trim($_POST["phone_number"]))) {
        $phone_number_err = "Please enter your phone number.";
    } else {
        $phone_number = trim($_POST["phone_number"]);
    }

    
    if (empty($email_err) && empty($member_name_err) && empty($password_err) && empty($phone_number_err)) {
        
        mysqli_begin_transaction($link);

        
      
$sql_accounts = "INSERT INTO Accounts (email, password, phone_number, register_date) VALUES (?, ?, ?, NOW())";
if ($stmt_accounts = mysqli_prepare($link, $sql_accounts)) {
    
    mysqli_stmt_bind_param($stmt_accounts, "sss", $param_email, $param_password, $param_phone_number);

    
    $param_email = $email;
    
    $param_password = $password;
    $param_phone_number = $phone_number;

    
}

            
            if (mysqli_stmt_execute($stmt_accounts)) {
                
                $last_account_id = mysqli_insert_id($link);

                
                $sql_memberships = "INSERT INTO Memberships (member_name, points, account_id) VALUES (?, ?, ?)";
                if ($stmt_memberships = mysqli_prepare($link, $sql_memberships)) {
                    
                    mysqli_stmt_bind_param($stmt_memberships, "sii", $param_member_name, $param_points, $last_account_id);

                    
                    $param_member_name = $member_name;
                    $param_points = 0; 

                    
                    if (mysqli_stmt_execute($stmt_memberships)) {
                        
                        mysqli_commit($link);

                        
                        header("location: register_process.php");
                        exit;
                    } else {
                        
                        mysqli_rollback($link);
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    
                    mysqli_stmt_close($stmt_memberships);
                }
            } else {
                
                mysqli_rollback($link);
                echo "Oops! Something went wrong. Please try again later.";
            }

            
            mysqli_stmt_close($stmt_accounts);
        }
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color:black;
             background-image: url('../image/loginBackground.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: white;
            }


        

.register-container {
  padding: 50px;
  border-radius: 10px;
  margin: 100px auto;
  max-width: 500px;
}
        .register_wrapper {
            width: 400px;
            padding: 20px;
        }

        h2 {
            text-align: center;
            font-family: 'Montserrat', serif;
        }

        p {
            font-family: 'Montserrat', serif;
        }

        .form-group {
            margin-bottom: 15px;
        }

        ::placeholder {
            font-size: 12px;
        }

       
        .fa-flip {
            animation: fa-flip 3s infinite;
        }

       
        @keyframes fa-flip {
            0% {
                transform: scale(1) rotateY(0);
            }
            50% {
                transform: scale(1.2) rotateY(180deg);
            }
            100% {
                transform: scale(1) rotateY(360deg);
            }
        }
        
    </style>
</head>
<body>
    <div class="register-container">
    <div class="register_wrapper"> 
        <a class="nav-link" href="../home/home.php#hero"> <h1 class="text-center" style="font-family:Copperplate; color:white;"> FAHIM'S</h1><span class="sr-only"></span></a><br>
       
        <form action="register.php" method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                                <span class="text-danger"><?php echo $email_err; ?></span>
            </div>

            <div class="form-group">
                <label>Member Name</label>
                <input type="text" name="member_name" class="form-control" placeholder="Enter Member Name" required>
                                <span class="text-danger"><?php echo $member_name_err; ?></span>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                                <span class="text-danger"><?php echo $password_err; ?></span>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone_number" class="form-control" placeholder="Enter Phone Number" required>
                                <span class="text-danger"><?php echo $phone_number_err; ?></span>
            </div>

            <button style="background-color:black;" class="btn btn-dark" type="submit" name="register" value="Register">Register</button>
           
        </form>

        <p style="margin-top:1em; color:white;">Already have an account? <a href="../customerLogin/login.php" >Proceed to Login</a></p>
    </div>
    </div>
</body>
</html>



