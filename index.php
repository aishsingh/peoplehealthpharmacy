<?php 
	//customer
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

	echo"<title>Customer</title>";
	echo"<h1>People Health Pharmacy Sales Reporting System</h1>";
	echo '<li><a href="index.php" target="_blank">'. $post['message']. '<b>Customer</b></a></li>';
	echo '<li><a href="order.php" target="_blank">'. $post['message']. 'Order</a></li>';
	echo '<li><a href="product.php" target="_blank">'. $post['message']. 'Product</a></li>';
	echo '<li><a href="sale.php" target="_blank">'. $post['message']. 'Sale</a></li>';
 
	echo"<h2>Customer Database</h2>";
	
	$sql = 'SELECT cid, cname, cgender, cage, cphone FROM CUSTOMER';
	
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0)
	{
  		
    	while($row = mysqli_fetch_assoc($result)) 
    	{
    	
    		
   		echo "Customer ID :{$row["cid"]}  <br> ".
         	"Customer Name: {$row["cname"]} <br> ".
         	"Customer Gender: {$row["cgender"]} <br> ".
	        "Customer Age: {$row["cage"]} <br> ".
         	"Customer Phone: {$row["cphone"]} <br> ".
         	"------------------<br>";
    	
	}
	
	}
	
    }
    // close the database connection
        mysqli_close($conn);
 
?>