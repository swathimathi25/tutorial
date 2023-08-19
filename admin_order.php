<?php
	session_start();
	if((!isset($_SESSION['manager'])  && !isset($_SESSION['expert']))){
		header("Location:index.php");
	}
	$title = "List category";
	require_once "./template/header.php";
	require_once "./functions/database_functions.php";
	$conn = db_connect();
	$result = getAllCategories($conn);
?>	
	<div>
	<a href="admin_signout.php" class="btn btn-danger"><span class="glyphicon glyphicon-off"></span>&nbsp;Logout</a>
	<a href="admin_book.php" class="btn btn-primary"><span class="glyphicon glyphicon-book"></span>&nbsp;Books</a>
	<a href="admin_publishers.php" class="btn btn-primary"><span class="glyphicon glyphicon-paperclip"></span>&nbsp;Publishers</a>
	<a href="admin_order.php" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;View Order</a>
	<?php
	if (isset($_SESSION['manager']) && $_SESSION['manager']==true){
		echo '<a class="btn btn-primary" href="admin_add.php"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add Book</a>';
	}
	?>
	</div>
	<?php
	$query="SELECT * FROM cart";
	 $result=mysqli_query($conn,$query);
	 if(mysqli_num_rows($result)!=0){
	 echo '	<br><br><br><h4>Your Purchase History</h4><table class="table">
	 <tr>
		 <th>Item</th>
		 <th>Name</th>
		 <th>Quantity</th>
		<th>Date</th>
	 </tr>';
			while($query_row = mysqli_fetch_assoc($result)){
				$book=$query_row['productid'];
				$que="SELECT * FROM books Where book_isbn='$book'";
	 			$res=mysqli_query($conn,$que);
	 			$q = mysqli_fetch_assoc($res);
	 			
	 			$cus=$query_row['customerid'];
				$qur="SELECT * FROM customers Where id='$cus'";
	 			$res1=mysqli_query($conn,$qur);
	 			$q1 = mysqli_fetch_assoc($res1);

				echo '<tr>
				<td>
				<a href="book.php?bookisbn=';
				echo $q['book_isbn'];
				echo '">';
				echo '<img style="height:100px;width:80px"class="img-responsive img-thumbnail" src="./bootstrap/img/';
				echo $q['book_image'];
				echo '">';
				echo ' </a>
				</td>
				<td>';
				echo $q1['firstname'];
				echo'
				</td>
				<td>';
				echo $query_row['quantity'];
				echo '
				</td>
				<td>';
				echo $query_row['odr_date'];
				echo'
				</td>
				</tr>';
			}
		
		echo '</table>';
	}
	
    if (isset($_SESSION['manager']) && $_SESSION['manager']==true){
		echo '<a class="btn btn-primary" href="admin_addcategory.php"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Add Category</a>';
	}        
    ?>
<?php
	if(isset($conn)) {mysqli_close($conn);}
	require_once "./template/footer.php";
?>