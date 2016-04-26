<?php 
	// order
    require_once ("../settings.php");
 
    $conn = @mysqli_connect($mysql_host,
    $user,
    $pwd,
    $sql_db);

    // Checks if connection is successful
    if (!$conn) 
    {
        // Displays an error message
        echo "<p>Database connection failure</p>";
    } 
    else 
    {
        $sql = 'SELECT MAX(oid) FROM `ORDER`';
        
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo mysqli_fetch_row($result)[0];
        }

        $sql = 'SELECT MAX(sid) FROM `SALE`';
        
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo ',' . mysqli_fetch_row($result)[0];
        }
    }
	
    // close the database connection
        mysqli_close($conn);
?>
