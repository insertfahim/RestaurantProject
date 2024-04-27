<?php
session_start(); 
?>
<?php include '../inc/dashHeader.php'; ?>
<?php

require_once "../config.php";



$input_staff_id = $staff_id_err = $staff_id = "";
$input_account_id = $account_iderr = $account_id = "";
$input_email = $email_err = $email = "";
$input_register_date = $register_date_err = $register_date = "";
$input_phone_number = $phone_number_err = $phone_number = "";
$input_password = $password_err = $password = "";


if (isset($_POST['submit'])) {
    if (empty($_POST['staff_id'])) {
        $staff_idErr = 'ID is required';
    } else {
        $staff_id = filter_input(
            INPUT_POST,
            'staff_id',
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
    }
}


function getNextAvailableAccountID($conn) {
    $sql = "SELECT MAX(account_id) as max_account_id FROM Accounts";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $next_account_id = $row['max_account_id'] + 1;
    return $next_account_id;
}


function getNextAvailableStaffID($conn) {
    $sql = "SELECT MAX(staff_id) as max_staff_id FROM Staffs";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $next_staff_id = $row['max_staff_id'] + 1;
    return $next_staff_id;
}


$next_staff_id = getNextAvailableStaffID($link);


$next_account_id = getNextAvailableAccountID($link);
?>
<head>
    <meta charset="UTF-8">
    <title>Create New Staff</title>
    <style>
       .wrapper{ width: 1300px; padding-left: 200px ; padding-top: 80px; }
      
        #account_id {
            width: 100%;
           
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
        }

       
        #account_id option {
            color: #333;
        }

       
        #account_id option:checked {
            background-color: #007bff;
            color: #fff;
        }

       
        #account_id:required:invalid {
            color: #999;
            border-color: #f00;
        }

       
        #account_id:required:valid {
            border-color: #28a745;
            color: #333;
        }
    </style>
</head>

<div class="wrapper">
    <h3>Create New Staff</h3>
    <p>Please fill in the Staff Information</p>

    <form method="POST" action="succ_create_staff.php" class="ht-600 w-50">

        <div class="form-group">
            <label for="staff_id" class="form-label">Staff ID:</label>
            <input min="1" type="number" name="staff_id" placeholder="1" class="form-control <?php echo $staff_id_err ? 'is-invalid' : ''; ?>" id="staff_id" required value="<?php echo $next_account_id; ?>" readonly><br>
            <div class="invalid-feedback">
                Please provide a valid staff_id.
            </div>
        </div>

        <div class="form-group">
            <label for="staff_name">Staff Name:</label>
            <input type="text" name="staff_name" placeholder="Fahim Hatsoff" id="staff_name" required class="form-control <?php echo (!empty($staff_name_err)) ? 'is-invalid' : ''; ?>"><br>
            <span class="invalid-feedback"></span>
        </div>

        <div class="form-group">
            <label for="role">Role:</label>
            <input type="text" name="role" id="role" placeholder="Waiter" required class="form-control <?php echo (!empty($role_err)) ? 'is-invalid' : ''; ?>"><br>
            <span class="invalid-feedback"></span>
        </div>
        
        <div class="form-group">
            <label for="account_id" class="form-label">Account ID:</label>
            <input min="1" type="number" name="account_id" placeholder="99" class="form-control <?php echo !$account_idErr ?: 'is-invalid'; ?>" id="account_id" required value="<?php echo $next_account_id; ?>" readonly><br>
            <div id="validationServerFeedback" class="invalid-feedback">
                Please provide a valid account_id.
            </div>
        </div>
        
        <div class="form-group">
            <label for="email" class="form-label">Email :</label>
            <input type="text" name="email" placeholder="Fahim12@dining.bar.com" class="form-control <?php echo !$emailErr ?: 'is-invalid'; ?>" id="email" required value="<?php echo $email; ?>"><br>
            <div id="validationServerFeedback" class="invalid-feedback">
                Please provide a valid email.
            </div>
        </div>

        <div class="form-group">
            <label for="register_date">Register Date :</label>
            <input type="date" name="register_date" id="register_date" required class="form-control <?php echo !$register_date_err ?: 'is-invalid';?>" value="<?php echo $register_date; ?>"><br>
            <div id="validationServerFeedback" class="invalid-feedback">
                Please provide a valid register date.
            </div>
        </div>

        <div class="form-group">
            <label for="phone_number" class="form-label">Phone Number:</label>
            <input type="text" name="phone_number" placeholder="+60101231234" class="form-control <?php echo !$phone_numberErr ?: 'is-invalid'; ?>" id="phone_number" required value="<?php echo $phone_number; ?>"><br>
            <div id="validationServerFeedback" class="invalid-feedback">
                Please provide a valid phone number.
            </div>
        </div>

        <div class="form-group">
            <label for="password">Password :</label>
            <input type="password" name="password" placeholder="Fahim1234@" id="password" required class="form-control <?php echo !$password_err ?: 'is-invalid' ; ?>" value="<?php echo $password; ?>"><br>
            <div id="validationServerFeedback" class="invalid-feedback">
                Please provide a valid password.
            </div>
        </div>
        
        <div class="form-group mb-5">
            <input type="submit" class="btn btn-dark" value="Create Staff">
        </div>

    </form>
</div>

<?php include '../inc/dashFooter.php'; ?>
