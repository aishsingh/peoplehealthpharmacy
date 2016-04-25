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
        $sql = 'SELECT * FROM `PRODUCT` WHERE pid = ' . $_POST["pid"];
        
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_assoc($result)) 
            {
                echo $row["pname"] . ",".
                     $row["pdesc"] . ",".
                     $row["pwholesale"] . ",".
                     $row["pselling"] . ",".
                     $row["pstock"];
            }
        }
    }
	
    // close the database connection
        mysqli_close($conn);
?>
