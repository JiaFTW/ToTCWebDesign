<?php
    // Get the records from the SQL database
    function getDB() {
        $dsn = 'mysql:host=toc-dev.chaqko2e2i9g.us-east-1.rds.amazonaws.com;dbname=totc';
        $username = 'toc_dev';
        $password = 'toc2024!';
        
        // Checks if it works otherwise prints out an error message
        try {
            $db = new PDO($dsn, $username, $password);
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            error_log("Database connection error: " . $error_message); // Log the error
            include('database_error.php');
            exit();
        }
        return $db;
    }
?>