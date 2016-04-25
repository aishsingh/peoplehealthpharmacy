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

              // Product setup
              var phttp = new XMLHttpRequest();
              phttp.open("POST", "getproduct.php", true);
              phttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
              var pparams = "pid=" + form.product.value;
              phttp.send(pparams);
              phttp.onload = function() {
                var response = phttp.responseText;

                if (response.length > 0) {
                  var res = response.split(",");
                  var name = res[0]; 
                  var price = res[3]; 
                  var available = Number(res[4]);

                  if (available >= form.quantity.value) {
                    div.innerHTML = div.innerHTML + "<tr><td>" + form.product.value + "</td><td>" + name + "</td><td>" + form.quantity.value + "</td><td>" + price + `</td><td><button onclick="deleteRow(this)">-</button></td></tr>`;
                    updateTotal();
                  }
                  else {
                    alert("Only " + available + " " + name + " currently in stock");
                    result;
                  }
                } 
                else {
                  alert("Product (" + form.product.value + ") doesnt exist!");
                  result;
                }
              }

              // Customer setup
              var chttp = new XMLHttpRequest();
              chttp.open("POST", "getcustomer.php", true);
              chttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
              cparams = "cid=" + form.customer.value;
              chttp.send(cparams);
              chttp.onload = function() {
                var response = chttp.responseText;

                if (response.length > 0) {
                  var res = response.split(",");
                  var name = res[0]; 
                  var discount = Number(res[4]); 

                  if (discount > 0) {
                    document.getElementById("discount").value = (discount * 100);
                    updateDiscount();
                  }
                } 
                else {
                  alert("Product (" + form.customer.value + ") doesnt exist!");
                }
              }
              
              return false;
            }

            function deleteRow(btn) {
              var row = btn.parentNode.parentNode;
              row.parentNode.removeChild(row);

              updateTotal();
            }

            var total = Number(0);
            function updateTotal() {
              var result = document.getElementById("result");
              total = Number(0);

              for(var i=1; i<result.rows.length;i++) {
                total += parseFloat(result.rows[i].cells[3].innerHTML) * parseFloat(result.rows[i].cells[2].innerHTML);
              }

              document.getElementById("total").innerHTML = "Total: $" + total.toFixed(2);
              updateDiscount();
            }

            function updateDiscount() {
              var discount = Number(document.getElementById("discount").value) / 100;
              document.getElementById("totaldiscount").innerHTML = "After discount: $" + (total - Number(total * discount).toFixed(2));
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
            <input type="text" name="customer"> Discount: <input id="discount" type="number" min="0" max="100" value="0" oninput="updateDiscount()">%<br>
          </form><br>';

    echo '<table id="result"><tr><th>ID</th><th>Name</th><th>Quantity</th><th>Price</th><th>Remove</th></tr></table><br>';

    echo '<div id="total">Total: $0</div><br>
          <div id="totaldiscount">After discount: $0</div><br>
          <button id="reset" onclick="clearList()">Reset</button> <button id="checkout">Checkout</button>';
	
	
    }
    // close the database connection
        mysqli_close($conn);
 
?>
