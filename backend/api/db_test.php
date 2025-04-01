<?php
    require_once 'database.php'; // Include your database connection file

    try {
        $db = getDB(); // Attempt to connect

        // Run a simple query
        $query = $db->query("SHOW TABLES;");
        $tables = $query->fetchAll();

        echo "<h3>Database Connection Successful!</h3>";
        echo "<h4>Tables in the database:</h4>";
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>" . $table[0] . "</li>";
        }
        echo "</ul>";

    } catch (Exception $e) {
        echo "<h3>Database Connection Failed:</h3>";
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
?>