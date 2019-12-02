<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
		$qry_simp = mysqli_query($connection,"select * from tbl_transaction_type where id='SIMP'");
		$simp = mysqli_fetch_assoc($qry_simp);

		$qry_comp = mysqli_query($connection,"select * from tbl_transaction_type where id='COMP'");
		$comp = mysqli_fetch_assoc($qry_comp);

		$qry_high = mysqli_query($connection,"select * from tbl_transaction_type where id='HIGH'");
		$high = mysqli_fetch_assoc($qry_high);
	?>
	<div class="transaction-type-container">
		<h4>Transaction in days</h4>
		<form method="post">
			<div class="form-group form-inline">
				Simple Transaction &nbsp;&nbsp;&nbsp;<input class="form-control" style="width:50px" value="<?php echo $simp['days'];?>" name="simple">
			</div>
			<div class="form-group form-inline form-space">
				Complex Transaction <input class="form-control" style="width:50px" value="<?php echo $comp['days'];?>" name="complex">
			</div>
			<div class="form-group form-inline form-space">
				Highly Technical Transaction <input class="form-control" style="width:50px" value="<?php echo $comp['days'];?>" name="highly">
				<button type="submit" class="btn btn-primary" value="update" name="update">Update</button>
			</div>
		</form>
	</div>
</body>
</html>
<?php
	if(isset($_REQUEST['update'])){
		mysqli_query($connection,"update tbl_transaction_type set days='$_REQUEST[complex]' where id='COMP'");
		mysqli_query($connection,"update tbl_transaction_type set days='$_REQUEST[simple]' where id='SIMP'");
		mysqli_query($connection,"update tbl_transaction_type set days='$_REQUEST[highly]' where id='HIGH'");
		?>	
			<script type="text/javascript">
				alert("Saved.");
				window.location = "home.php?menu=transactiontype&form=entry";
			</script> 
		<?php
	}
?>