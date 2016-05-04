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
	
	// Scripts needed to export to csv
	echo '<script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.1.min.js" > </script> 
		<script type="text/javascript" src="http://www.kunalbabre.com/projects/table2CSV.js" > </script>';

	echo"<title>Reports</title>";
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
 
 	echo"<h1>Reports</h1>";
	echo"<h2>Product low stock warnings (<10):</h2>";
	
	$sql = 'SELECT pid, pname, pdesc, pwholesale, pselling, pstock FROM PRODUCT ORDER BY pstock';
	
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0)
	{
  		echo '<table id="lowstock" border="1">
			<thead>
				<tr>
					<th>Product ID</th>
					<th>Name</th>
					<th>Wholesale ($)</th>
					<th>Stock</th>
				</tr>
			</thead>
			<tbody>';
		if($_GET['sort'] == 'id')	
		{
			$sql .=" ORDER BY pid";
			$result = mysqli_query($conn, $sql);
		}
		if($_GET['sort'] == 'name')	
		{
			$sql .=" ORDER BY pname";
			$result = mysqli_query($conn, $sql);
		}
		if($_GET['sort'] == 'wholesale')	
		{
			$sql .=" ORDER BY pwholesale";
			$result = mysqli_query($conn, $sql);
		}
		if($_GET['sort'] == 'stock')	
		{
			$sql .=" ORDER BY pstock";
			$result = mysqli_query($conn, $sql);
		}
		
    	while($row = mysqli_fetch_assoc($result)) 
    	{
    		if ($row["pstock"] < 10) {
    			if ($row["pstock"] == 0) {
    				print "<tr style='background-color: red; color: white;'> <td>";
    			}
    			else {
    				print "<tr> <td>";
    			}
			echo  $row["pid"];
			print "</td> <td>";
			echo  $row["pname"];
			print "</td> <td>";
			echo $row["pwholesale"];
			print "</td> <td>";
			echo $row["pstock"];
			print "</td> </tr>";
		}    	
	}
	echo '</tbody> </table><br>';
	echo '<input value="Export CSV" type="button" onclick="$(`#lowstock`).table2CSV({header:[`ID`, Name`,`Wholesale`, `Stock`]})">';
	}
	else
	{
		echo"database connected but failed to display";
	}
	
    }
    // close the database connection
        mysqli_close($conn);
 
?>