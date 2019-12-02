<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="continue-ended">
		<form action="" method="post">
			<h4>Reactivate Ended Document Transaction</h4>
			<div class="form-group form-inline">
				<input type="text" class="form-control" name="barcode" id="barcode" placeholder="Barcode" required="required">
				<input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" required="required">
				<button type="submit" class="btn btn-primary" value="confirm" name="confirm">Confirm</button>
		    </div>
	    </form>
	</div>
	<link rel="icon" href="../images/dts.png" type="image/gif" sizes="16x16">
</body>
</html>
<?php
	if(isset($_REQUEST['confirm'])){

		$pss = md5($_REQUEST['confirmpassword']);

		$qry_check = mysqli_query($connection,"select * from tbl_users where username='$access[username]' and password='$pss' and office_code='$access[office_code]'");

		if(mysqli_num_rows($qry_check)>=1){

			$qry_check_doc = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$_REQUEST[barcode]' and current_action='END' and status='0'");

			if(mysqli_num_rows($qry_check_doc)>=1){
				mysqli_query($connection,"update tbl_document_transaction set current_action='REC', remarks='', office_time='0', release_date_time=NULL, status='1' where barcode='$_REQUEST[barcode]' and current_action='END' and status='0'");

				mysqli_query($connection,"update tbl_document set transaction_end_date=NULL, transaction_status='' where barcode='$_REQUEST[barcode]'");
				?>	
					<script type="text/javascript">
						alert("Done.");
						window.location = "home.php?menu=endedtransactions&form=entry";
					</script> 
				<?php
			}
			else{
				?>	
					<script type="text/javascript">
						alert("No document found.");
						window.location = "home.php?menu=endedtransactions&form=entry";
					</script> 
				<?php	
			}
		}
		else{
			?>	
				<script type="text/javascript">
					alert("User Authetication Error.");
					window.location = "home.php?menu=endedtransactions&form=entry";
				</script> 
			<?php
		}
	}
?>