<?php 
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
    echo '<script src="/scripts/picoModal.js"></script>';
	echo '<link href="styles/style.css" rel="stylesheet" type="text/css"/>';
	echo "<title>Order</title>";
	echo "<h1>People Health Pharmacy Sales Reporting System</h1>";

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

	echo "<h2>Order Form</h2>";

    echo '<style>
            table, th, td {
                padding: 5px;
            }

            #result {
                border: 1px solid black;
                border-spacing: 15px;
            }

            #receipt {
                width: 350px;
            }
          </style>';

    echo '<script>
            window.onload = function() {
              getMaxID();  // so it doesnt start off at zero
            };

            function addProduct() {
              var result = document.getElementById("result");
              var product = document.getElementsByName("product")[0].value;
              var quantity = document.getElementsByName("quantity")[0].value;

              if (product != "") {
                var http = new XMLHttpRequest();
                http.open("POST", "/actions/getproduct.php", true);
                http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                var params = "pid=" + product;
                http.send(params);
                http.onload = function() {
                  var response = http.responseText;

                  if (response.length > 0) {
                    var res = response.split(",");
                    var name = res[0]; 
                    var price = res[3]; 
                    var available = Number(res[4]);

                    if (available >= quantity) {
                      result.innerHTML = result.innerHTML + "<tr><td>" + product + "</td><td>" + name + "</td><td>" + quantity + "</td><td>" + price + `</td><td><button onclick="deleteRow(this)">-</button></td></tr>`;
                      updateTotal();
                    }
                    else {
                      alert("Only " + available + " " + name + " currently in stock");
                    }
                  } 
                  else {
                    alert("Product (" + product + ") doesnt exist!");
                  }
                }
              }
              else {
                alert("Product id connot be empty!");
              }
            }

            var cname = "";
            function updateCustomer() {
              var customer = document.getElementsByName("customer")[0].value;

              var http = new XMLHttpRequest();
              http.open("POST", "/actions/getcustomer.php", true);
              http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
              var params = "cid=" + customer;
              http.send(params);
              http.onload = function() {
                var response = http.responseText;

                if (response.length > 0) {
                  var res = response.split(",");
                  cname = res[0]; 
                  var discount = Number(res[4]); 

                  document.getElementById("discount").value = (discount * 100);
                  updateDiscount();
                } 
                else {
                  alert("Customer (" + customer + ") doesnt exist!");
                  document.getElementById("discount").value = 0;
                }
              }
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

              // Update total
              for(var i=1; i<result.rows.length;i++) {
                total += parseFloat(result.rows[i].cells[3].innerHTML) * parseFloat(result.rows[i].cells[2].innerHTML);
              }
              document.getElementById("total").innerHTML = "Total: $" + total.toFixed(2);
              updateDiscount();

              // Hide/Show checkout button
              if(result.rows.length > 1)
                document.getElementById("checkout").disabled = false;
              else
                document.getElementById("checkout").disabled = true;
            }

            var discount = Number(0);
            var sumprice = Number(0);
            function updateDiscount() {
              discount = Number(document.getElementById("discount").value) / 100;
              sumprice = Number(total - (total * discount)).toFixed(2);
              document.getElementById("totaldiscount").innerHTML = "After discount: $" + sumprice;
            }

            function clearList() {
              document.getElementById("result").innerHTML = "<tr><th>ID</th><th>Name</th><th>Quantity</th><th>Price</th><th>Remove</th></tr>";

              updateTotal();
              getMaxID();
            }

            var receiptModal;
            function genReceipt() {
              getMaxID();

              var result = document.getElementById("result");
              var sid = max_sid + 1;
              var cid = document.getElementsByName("customer")[0].value;
              var time = new Date();
              

              var list = "";
              for(var i=1; i<result.rows.length;i++) {
                list += `<tr><td><small>` + parseFloat(result.rows[i].cells[2].innerHTML) + `</small></td><td><small>x</small></td><td><small>` + result.rows[i].cells[1].innerHTML + `</small></td><td><small>$` + parseFloat(result.rows[i].cells[3].innerHTML).toFixed(2) + `</small></td></tr>`;
              }

              var div = `<div id="receipt">
                           <div style="text-align: center;">
                             <h3>Sale</h3><br>
                             People Health Pharmacy<br>
                             John Street<br>
                             Hawthorn VIC 3122<br>
                           </div>
                           <br>

                           Sale ID: ` + sid + `<br>
                           Customer ID: ` + cid + `<br>
                           Customer Name: ` + cname + `<br>
                           <br>

                           ` + time.toLocaleDateString() + " " + time.toLocaleTimeString() + `<hr>
                           <br>

                           <table style="width: 100%">` + list + 
                            `<tr><td colspan="4"></td></tr>
                             <tr><td colspan="4"></td></tr>
                             <tr><td colspan="3"><small>Subtotal</small></td><td><small>$` + total.toFixed(2) + `</small></td></tr>
                             <tr><td colspan="3"><small>Discount</small></td><td><small>&nbsp;` + (discount*100) + `%</small></td></tr>
                             <tr><td colspan="3"><b>Total</b></td><td><b>$` + sumprice + `</b></td></tr>
                           </table>
                           <br>

                           <hr>
                           <div style="text-align: right;"><button onclick="receiptModal.close();">Cancel</button> <button onclick="createSaleOrders()">Confirm</button></div>
                        </div>`;

              receiptModal = picoModal({
                  content: div,
                  closeButton: false,
                  overlayStyles: {
                      backgroundColor: "#AAA",
                      opacity: 0.75
                  },
                  overlayClose: false
              }).show();
            }

            var max_oid = Number(0);
            var max_sid = Number(0);
            function getMaxID() {
              var http = new XMLHttpRequest();
              http.open("POST", "/actions/getmaxid.php", true);
              http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
              http.send();
              http.onload = function() {
                var response = http.responseText;

                if (response.length > 0) {
                  var res = response.split(",");
                  max_oid = Number(res[0]);
                  max_sid = Number(res[1]);
                } 
              }

            }

            var salecomplete = false;
            function createSale(oids) {
              var sid = max_sid + 1;
              var cid = document.getElementsByName("customer")[0].value;

              var http = new XMLHttpRequest();
              http.open("POST", "/actions/createsale.php", true);
              http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
              var params = "sid=" + sid + "&oid=" + oids.join(" ") + "&cid=" + cid + "&sdiscount=" + discount;
              http.send(params);
              http.onload = function() {
                if (!salecomplete) {
                  var response = http.responseText;

                  if (response == "done") {
                    salecomplete = true;
                    alert("Sale (" + sid + ") successfully created!");
                    window.location.reload();
                  } 
                  else {
                    alert("Failed to create sale (" + sid + ")! [" + response + "]");
                  }
                }
              }
            }

            var created_oid = [];
            function createSaleOrders() {
              var result = document.getElementById("result");

              // Create Orders first
              for(var i=1; i<result.rows.length;i++) {
                var oid = max_oid + Number(i);
                var pid = Number(result.rows[i].cells[0].innerHTML);
                var oquantity = parseFloat(result.rows[i].cells[2].innerHTML).toFixed(2);

                var http = new XMLHttpRequest();
                http.open("POST", "/actions/createorder.php", false);
                http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                var params = "oid=" + oid + "&pid=" + pid + "&oquantity=" + oquantity;
                http.send(params);

                var response = http.responseText;
                if (response == "done") {
                  created_oid.push(oid);
                } 
                else {
                  alert("Failed to create order (" + oid + ")! [" + response + "]");
                }
              }

              if (created_oid.length == (result.rows.length - 1)) {
                createSale(created_oid);
              }
            }
          </script>';

    echo 'Product:<br>
          <input type="text" name="product" size="10"> x <input type="number" name="quantity" value="1" min="1" max="999"> <button onclick="addProduct()">+</button> <br>
          Customer:<br>
          <input type="text" name="customer" size="10" oninput="updateCustomer()"> Discount: <input id="discount" type="number" min="0" max="100" value="0" oninput="updateDiscount()">%<br>
          <br>';

    echo '<table id="result"><tr><th>ID</th><th>Name</th><th>Quantity</th><th>Price</th><th>Remove</th></tr></table><br>';

    echo '<div id="total">Total: $0</div><br>
          <div id="totaldiscount">After discount: $0</div><br>
          <button id="reset" onclick="clearList()">Reset</button> <button id="checkout" onclick="genReceipt()" disabled>Checkout</button>';

    }
    // close the database connection
        mysqli_close($conn);
 
?>
