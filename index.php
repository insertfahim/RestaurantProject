<?php

if (file_exists('setup_completed.flag')) {
    echo "Setup has already been completed. ";
} else {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');

    
    $link = new mysqli(DB_HOST, DB_USER, DB_PASS);

    
    if ($link->connect_error) {
        die('Connection Failed: ' . $link->connect_error);
    }

    
    $sqlCreateDB = "CREATE DATABASE IF NOT EXISTS restaurantdb";
    if ($link->query($sqlCreateDB) === TRUE) {
        echo "Database 'restaurantdb' created successfully.<br>";
    } else {
        echo "Error creating database: " . $link->error . "<br>";
    }

    
    $link->select_db('restaurantdb');

    
    function executeSQLFromFile($filename, $link) {
        $sql = file_get_contents($filename);

        
        if ($link->multi_query($sql) === TRUE) {
            echo "SQL statements executed successfully.";
            
            file_put_contents('setup_completed.flag', 'Setup completed successfully.');
        } else {
            echo "Error executing SQL statements: " . $link->error;
        }
    }

    
    executeSQLFromFile('restaurantdb.txt', $link);

    
    $link->close();
}
?>

<a href="customerSide/home/home.php">Home</a>
