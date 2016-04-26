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
        $sql = 'INSERT INTO `SALE`(`sid`, `oid`, `cid`, `sdiscount`, `sdate`) VALUES (' . $_POST["sid"] . ',"' . $_POST["oid"] . '",' . $_POST["cid"] . ',' . $_POST["sdiscount"] . ',"' . date("Y-m-d") . '")';
        
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo 'done';
        }
        else {
            echo mysqli_error($conn);
        }
    }
	
    // close the database connection
        mysqli_close($conn);
?>
