<?php 
	// product
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

	echo"<title>Product</title>";
	echo"<h1>People Health Pharmacy Sales Reporting System</h1>";
	echo '<li><a href="index.php" target="_blank">'. $post['message']. 'Customer</a></li>';
	echo '<li><a href="order.php" target="_blank">'. $post['message']. 'Order</a></li>';
	echo '<li><a href="product.php" target="_blank">'. $post['message']. '<b>Product</b></a></li>';
	echo '<li><a href="sale.php" target="_blank">'. $post['message']. 'Sale</a></li>';
 
	echo"<h2>Product Database</h2>";
	
	$sql = 'SELECT pid, pname, pdesc, pwholesale, pselling, pstock FROM PRODUCT';
	
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0)
	{
  		
    	while($row = mysqli_fetch_assoc($result)) 
    	{
    	
    		
   		echo "Product ID :{$row["pid"]}  <br> ".
         	"Product Name: {$row["pname"]} <br> ".
         	"Product Description: {$row["pdesc"]} <br> ".
	        "Product Wholesale Price: {$row["pwholesale"]} <br> ".
         	"Product Selling Price: {$row["pselling"]} <br> ".
		"Product Stock: {$row["pstock"]} <br> ".
         	"------------------<br>";
    	
	}
	
	}
	else
	{
		echo"database connected but failed to display";
	}
	
    }
    // close the database connection
        mysqli_close($conn);
 
?>