<?php   
echo '<script>

function getMaxID() {
    var max_pid = Number(0);
    var http = new XMLHttpRequest();
    http.open("POST", "/actions/getmaxid.php", false);
    http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    http.send();

    var response = http.responseText;

    if (response.length > 0) {
      var res = response.split(",");
      max_pid = Number(res[2]);
    } 

    return max_pid;

}

function createProduct(){
	var pid = getMaxID() +1;
	var pname = document.getElementsByName("prodname")[0].value;
	var pdesc = document.getElementsByName("description")[0].value;
	var pwholesale = document.getElementsByName("wholesale")[0].value;
	var pselling = document.getElementsByName("selling")[0].value;
	var pstock = document.getElementsByName("quantity")[0].value;

	var http = new XMLHttpRequest();
	http.open("POST", "/actions/createproduct.php", false);
	http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	var params = "pid=" + pid + "&pname=" + pname +"&pdesc=" + pdesc + "&pwholesale=" + pwholesale + "&pselling=" + pselling + "&pstock=" + pstock;
	http.send(params);
	
	var response = http.responseText;
	if (response == "done") {
		alert("Successfully added " + pname);
	} 
	else {
		alert("Failed to create product (" + pid + ")! [" + response + "]");
	}
}

</script>';

echo '<br>Name <input type="text" name="prodname" size="20"><br>
         <br>Description <input type="text" name="description" size="10"><br>
		 <br>Wholesale ($) <input type="number" name="wholesale" min="0" max="100" value="0"><br>
		 <br>Selling ($) <input type="number" name="selling" min="0" max="100" value="0"><br>
		 <br>Quantity <input type="number" name="quantity" min="0" max="100" value="0"><br>';

echo '<button id="reset" onclick="clearList()">Reset</button> <button id="add" onclick="createProduct()">Add</button>';
		  
?>
