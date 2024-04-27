<?php

require_once '../config.php';
session_start();


$email = $password = "";
$email_err = $password_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    
    if (empty($email_err) && empty($password_err)) {
        
        $sql = "SELECT * FROM Accounts WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            
            $param_email = $email;

            
            if (mysqli_stmt_execute($stmt)) {
                
                $result = mysqli_stmt_get_result($stmt);

                
                if (mysqli_num_rows($result) == 1) {
                    
                    $row = mysqli_fetch_assoc($result);

                    
                   
                    if ($password === $row["password"]) {
                        
                        $_SESSION["loggedin"] = true;
                        $_SESSION["email"] = $email;

                        
                        $sql_member = "SELECT * FROM Memberships WHERE account_id = " . $row['account_id'];
                        $result_member = mysqli_query($link, $sql_member);

                        if ($result_member) {
                            $membership_row = mysqli_fetch_assoc($result_member);

                            if ($membership_row) {
                                $_SESSION["account_id"] = $membership_row["account_id"];
                                header("location: ../home/home.php"); 
                                exit;
                            } else {
                                
                                $password_err = "No membership details found for this account.";
                            }
                        } else {
                            
                            $password_err = "Error fetching membership details: " . mysqli_error($link);
                        }
                    } else {
                        
                        $password_err = "Invalid password. Please try again.";
                    }


                } else {
                    
                    $email_err = "No account found with this email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            
            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https:
     <link rel="stylesheet" href="https:
    <style>
        



.login-container {
  padding: 50px;
  border-radius: 10px;
  margin: 100px auto;
  max-width: 500px;
}



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

        .login_wrapper {
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
        
        .text-danger{
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="login-container">
    <div class="login_wrapper">
        <a class="nav-link" href="../home/home.php#hero"> <h1 class="text-center" style="font-family:Copperplate; color:white;"> FAHIM'S</h1><span class="sr-only"></span></a>
    
        <div class="wrapper">
           
        <form action="login.php" method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter User Email" required>
                <span class="text-danger"><?php echo $email_err; ?></span>
            </div>

           <div class="form-group">
    <label>Password</label>
    <input type="password" name="password" class="form-control" placeholder="Enter User Password" required>
    <span class="text-danger"><?php echo $password_err; ?></span>
</div>
            <button class="btn btn-dark" style="background-color:black;" type="submit" name="submit" value="Login">Login</button>
            
        </form>

            <p style="margin-top:1em; color:white;">Don't have an account? <a href="register.php" style="">Proceed to Register</a></p>
        </div>
    </div>
    </div>
</body>
</html>
