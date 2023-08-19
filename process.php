<?php
	session_start();

	require_once "./functions/database_functions.php";
	// print out header here
	$title = "Purchase Process";
	require "./template/header.php";
	// connect database
	$conn = db_connect();

		$firstname = trim($_POST['firstname']);
		$firstname = mysqli_real_escape_string($conn, $firstname);
		
		$lastname = trim($_POST['lastname']);
		$lastname = mysqli_real_escape_string($conn, $lastname);
	
		
		$address = trim(trim($_POST['address']));
		$address = mysqli_real_escape_string($conn, $address);
		
		$city = trim($_POST['city']);
        $city = mysqli_real_escape_string($conn, $city);
        
		$zipcode = trim($_POST['zipcode']);
		$zipcode = mysqli_real_escape_string($conn, $zipcode);

	// find customer
	$customer = getCustomerIdbyEmail($_SESSION['email']);
	$id=$customer['id'];
	$query="UPDATE customers set 
	firstname='$firstname', lastname='$lastname' , address='$address', city='$city', zipcode='$zipcode'  where id='$id'
	";
	mysqli_query($conn, $query);
	
	$date = date("Y-m-d H:i:s");
	

		$cusid=$customer['id'];

	foreach($_SESSION['cart'] as $isbn => $qty){
		$bookprice = getbookprice($isbn);
		$query = "INSERT INTO cartitems(cartid,productid,quantity) VALUES 
		('$cusid', '$isbn', '$qty')";
		$result = mysqli_query($conn, $query);
		$q = "INSERT INTO `cart`(`productid`, `quantity`, `customerid`, `odr_date`) VALUES ('$isbn','$qty','$cusid','$date')";
		$res = mysqli_query($conn, $q);
		if(1){
			$qry = "SELECT * FROM books where book_isbn = '$isbn'";
			$res = mysqli_query($conn, $qry);
			$row=mysqli_fetch_assoc($res);
			$qu=(int)$row['Stock'];
			$qu=$qu-$qty;
			$qur = "UPDATE `books` SET `Stock` = '$qu' WHERE `book_isbn` = '$isbn';";
			$res = mysqli_query($conn, $qur);
		}
		
		if(!$result){
			echo "Insert value false!" . mysqli_error($conn2);
			exit;
		}
	}


	unset($_SESSION['total_price']);
	unset($_SESSION['cart']);
	unset($_SESSION['total_items']);

?>
	<p class="lead text-success" id="p">Your order has been processed sucessfully..</p>
   <script>
   	
		window.setTimeout(function(){

		window.location.href = "email.php";

		}, 3000);
	
   </script>

<?php
	if(isset($conn)){
		mysqli_close($conn);
	}
	require_once "./template/footer.php";
?>