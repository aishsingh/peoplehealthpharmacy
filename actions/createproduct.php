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
        $sql = 'INSERT INTO `PRODUCT`(`pid`, `pname`, `pdesc`, `pwholesale`, `pselling`, `pstock`) VALUES (' . $_POST["pid"] . ',"' . $_POST["pname"] . '","' . $_POST["pdesc"] . '",' . $_POST["pwholesale"] . ',' . $_POST["pselling"] . ',' . $_POST["pstock"] . ')';
        
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo 'done';
        }
        else {
            echo die(mysqli_error($conn));
        }
    }
	
    // close the database connection
        mysqli_close($conn);
?>
