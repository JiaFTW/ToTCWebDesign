<!-- Make sure to create a new database with the name "cs491" to make this work in your machine -->
<?php
    // Get the records from the SQL database
    function getDB() {
        $dsn = 'mysql:host=localhost;dbname=cs491';
        $username = 'root';
        $password = '';
        
        // Checks if it works otherwise prints out an error message
        try {
            $db = new PDO($dsn, $username, $password);
        } catch (PDOException $exception) {
            $error_message = $exception->getMessage();
            error_log("Database connection error: " . $error_message);
            include('database_error2.php');
            exit();
        }
        return $db;
    }
?>