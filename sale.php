<?php 
	//sale
    require_once ("settings.php");
 
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
        echo "<p>Connected to the database <b>$sql_db</b></p>";

	echo"<title>Sale</title>";
	echo"<h1>People Health Pharmacy Sales Reporting System</h1>";
	echo '<li><a href="index.php" target="_blank">'. $post['message']. 'Customer</a></li>';
	echo '<li><a href="order.php" target="_blank">'. $post['message']. 'Order</a></li>';
	echo '<li><a href="product.php" target="_blank">'. $post['message']. 'Product</a></li>';
	echo '<li><a href="sale.php" target="_blank">'. $post['message']. '<b>Sale</b></a></li>';
 
	echo"<h2>Sale Database</h2>";
	
	$sql = 'SELECT sid, oid, cid, sdiscount, sdate FROM SALE';
	
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0)
	{
  		
    	while($row = mysqli_fetch_assoc($result)) 
    	{
    	
    		
   		echo "Sale ID :{$row["sid"]}  <br> ".
         	"Order ID: {$row["oid"]} <br> ".
			"Customer ID: {$row["cid"]} <br> ".
			"Sale Discount ID: {$row["sdiscount"]} <br> ".
         	"Sale Date: {$row["sdate"]} <br> ".
         	"------------------<br>";
    	
	}
	
	}
	
    }
    // close the database connection
        mysqli_close($conn);
 
?>