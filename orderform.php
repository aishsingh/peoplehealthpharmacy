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
	echo "<title>Order</title>";
	echo "<h1>People Health Pharmacy Sales Reporting System</h1>";
	echo '<li><a href="index.php" target="_blank">'. $post['message']. 'Customer</a></li>';
	echo '<li><a href="order.php" target="_blank">'. $post['message']. '<b>Order</b></a></li>';
	echo '<li><a href="product.php" target="_blank">'. $post['message']. 'Product</a></li>';
	echo '<li><a href="sale.php" target="_blank">'. $post['message']. 'Sale</a></li>';

	echo "<h2>Order Form</h2>";

    echo '<style>
            table, th, td {
                padding: 5px;
            }

            table {
                border: 1px solid black;
                border-spacing: 15px;
            }
          </style>';

    echo '<script>
            function selectProduct(form) {
              var div = document.getElementById("result");

              var http = new XMLHttpRequest();
              http.open("POST", "verifyproduct.php", true);
              http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
              var params = "pid=" + form.product.value;
              http.send(params);
              http.onload = function() {
                var response = http.responseText;

                if (response.length > 0) {
                  var res = response.split(",");
                  var name = res[0]; 
                  var price = res[1]; 

                  div.innerHTML = div.innerHTML + "<tr><td>" + form.product.value + "</td><td>" + name + "</td><td>" + form.quantity.value + "</td><td>" + price + `</td><td><button onclick="deleteRow(this)">-</button></td></tr>`;
                  updateTotal();
                } else {
                  alert("Product (" + form.product.value + ") doesnt exist!");
                }
              }
              
              return false;
            }

            function deleteRow(btn) {
              var row = btn.parentNode.parentNode;
              row.parentNode.removeChild(row);

              updateTotal();
            }

            function updateTotal() {
              var div = document.getElementById("result");
              var total = Number(0);
              for(var i=1; i<div.rows.length;i++) {
                total += parseFloat(div.rows[i].cells[3].innerHTML) * parseFloat(div.rows[i].cells[2].innerHTML);
              }

              document.getElementById("total").innerHTML = "Total: $" + total.toFixed(2);
            }

            function clearList() {
              document.getElementById("result").innerHTML = "<tr><th>ID</th><th>Name</th><th>Quantity</th><th>Price</th><th>Remove</th></tr>";

              updateTotal();
            }
          </script>';

    echo '<form action="#" onsubmit="return selectProduct(this);">
            Product:<br>
            <input type="text" name="product"> <input type="number" name="quantity" value="1" min="1" max="9999999999"> <input type="submit" value="Submit"> <br>
            Customer:<br>
            <input type="text" name="customer"> <div id="discount">Discount: 0%</div><br>
          </form><br>';

    echo '<table id="result"><tr><th>ID</th><th>Name</th><th>Quantity</th><th>Price</th><th>Remove</th></tr></table><br>';

    echo '<div id="total">Total: $0</div><br>
          <div id="totaldiscount">After discount: $0</div><br>
          <button id="reset" onclick="clearList()">Reset</button> <button id="checkout">Checkout</button>';
	
	
    }
    // close the database connection
        mysqli_close($conn);
 
?>
