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
	echo '<link href="styles/style.css" rel="stylesheet" type="text/css"/>';
	echo"<title>Product</title>";
	echo"<h1>People Health Pharmacy Sales Reporting System</h1>";
	echo '<nav>
			<ul>
				<li><a href="index.php" >Customer</a> |
					<ul>
						<li><a href="addcustomer.php" >Add</a></li>
						<li><a href="removecustomer.php" >Remove</a></li>
					</ul>
				</li>
				<li><a href="order.php" >Order</a> |</li>
				<li><a href="product.php" >Product</a> |
					<ul>
						<li><a href="addproduct.php" >Add</a></li>
						<li><a href="removeproduct.php" >Remove</a></li>
					</ul>
				</li>
				<li><a href="sale.php" >Sales</a> |</li>
				<li><a href="orderform.php" >Checkout</a> |</li>
				<li><a href="report.php" >Report</a></li>
			</ul>
		  </nav>
	
	';
 
	echo"<h2>Product Inventory</h2>";
	
	$sql = 'SELECT pid, pname, pdesc, pwholesale, pselling, pstock FROM PRODUCT';
	
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0)
	{
  		echo '<table border="1">
			<thead>
				<tr>
					<th>Product ID</th>
					<th>Name</th>
					<th>Description</th>
					<th>Wholesale ($)</th>
					<th>Selling ($)</th>
					<th>Stock</th>
				</tr>
			</thead>
			<tbody>';
    	while($row = mysqli_fetch_assoc($result)) 
    	{
    		print "<tr> <td>";
			echo  $row["pid"];
			print "</td> <td>";
			echo  $row["pname"];
			print "</td> <td>";
			echo $row["pdesc"];
			print "</td> <td>";
			echo $row["pwholesale"];
			print "</td> <td>";
			echo $row["pselling"];
			print "</td> <td>";
			echo $row["pstock"];
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