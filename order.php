<?php 
	// order
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
	echo '<link href="styles/style.css" rel="stylesheet" type="text/css"/>';
	echo"<title>Order</title>";
	echo"<h1>People Health Pharmacy Sales Reporting System</h1>";
	echo '<nav>
			<ul>
				<li><a href="index.php">Customer</a> |
					<ul>
						<li><a href="addcustomer.php">Add</a></li>
						<li><a href="removecustomer.php">Remove</a></li>
					</ul>
				</li>
				<li><a href="order.php">Order</a> |</li>
				<li><a href="product.php">Product</a> |
					<ul>
						<li><a href="addproduct.php">Add</a></li>
						<li><a href="removeproduct.php">Remove</a></li>
					</ul>
				</li>
				<li><a href="sale.php">Sales</a> |</li>
				<li><a href="orderform.php">Checkout</a> |</li>
				<li><a href="report.php">Report</a></li>
			</ul>
		  </nav>
	
	';
 
	echo"<h2>Order Database</h2>";
	
	
	
	$sql= "SELECT oid, pid, oquantity FROM `ORDER`";
	
	$result = $conn->query($sql);

  	
  	if ($result->num_rows > 0) 
  	{
		echo '<table border="1">
			<thead>
				<tr>
					<th>Order ID</th>
					<th>Product ID</th>
					<th>Order Quantity</th>
				</tr>
			</thead>
			<tbody>';
    	while($row = $result->fetch_assoc()) 
    	{
			print "<tr> <td>";
			echo  $row["oid"];
			print "</td> <td>";
			echo  $row["pid"];
			print "</td> <td>";
			echo $row["oquantity"];
			print "</td> </tr>";
 
    	}
    	echo '</tbody> </table>';	
   	}
	else
	{
		echo"database connected but failed to display";
	}
	
    }

 // close the database connection
        mysqli_close($conn);
?>
