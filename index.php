<?php 
    require_once ("settings.php");
    $conn = @mysqli_connect($mysql_host,
    $user,
    $pwd,
    $sql_db);

    // Checks if connection is successful
    if (!$conn) {
        // Displays an error message
        echo "<p>Database connection failure</p>";
    } 
    else {
        echo "<p>Connected to the database <b>$sql_db</b></p>";

        // close the database connection
        mysqli_close($conn);
    }
?>
