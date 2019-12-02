<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="correct-release">
		<form action="" method="post">
			<h4>Correct Released Route</h4> 
			*This feature is not for document/s with multiple routing.
			<div class="form-group form-inline">
				<input type="text" class="form-control" name="barcode" style="width: 395px;" id="barcode" placeholder="Barcode" required="required">
				<!-- <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" required="required"> -->
				<button type="submit" class="btn btn-primary" value="confirm" name="confirm">Search</button>
		    </div>
	    </form>
	    <?php
	    if(isset($_REQUEST['confirm'])){
	    	$qry = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$_REQUEST[barcode]' and current_action='REL' and status!='0'");
	    	$routed = mysqli_fetch_assoc($qry);

	    	if(mysqli_num_rows($qry)==0){
	    		//error message
	    		?>
				<script type="text/javascript">
					alert("Document is on Received state. This transaction cannot be done.");
				</script>
				<?php
	    	}
	    	else{
		    	?>
		    	<form action="" method="post">
			    	<div class="form-group form-inline">
			    		Document <b><?php echo $routed['barcode']; ?></b> currently routed to <b><?php echo $routed['route_office_code']; ?></b>.
			    		<input type="hidden" name="barcodeulet" id="barcodeulet" value="<?php echo $routed['barcode'];?>">
			    		<input type="hidden" name="routedoffice" id="routedoffice" value="<?php echo $routed['route_office_code'];?>">
					</div>
					<div class="form-group form-inline">
						Change Route to:
						<br>
						<select class="form-control" name="routeto" id="routeto" style="width: 395px;" required="required">
							<option value="">Select Office</option>
							<?php
							$qry_office = mysqli_query($connection,"select * from tbl_office where status='1'  order by office_code asc"); //and office_code!='REC'
							for($a=1;$a<=mysqli_num_rows($qry_office);$a++){
								$data = mysqli_fetch_assoc($qry_office);

								echo "<option value='$data[office_code]'>$data[office_code] - $data[office_name]</option>";
								
							}
							?>
						</select>
						<button type="submit" class="btn btn-primary" value="correct" name="correct">Route</button>
					</div>
				</form>				
		    	<?php
		    }
	    }
	    else{
	    	//none
	    }
	    ?>

	</div>
	<link rel="icon" href="../images/dts.png" type="image/gif" sizes="16x16">
</body>
</html>
<?php
	if(isset($_REQUEST['correct'])){
		mysqli_query($connection,"update tbl_document_transaction set route_office_code='$_REQUEST[routeto]' where barcode='$_REQUEST[barcodeulet]' and current_action='REL' and route_office_code='$_REQUEST[routedoffice]' and status!='0'");
		?>
		<script type="text/javascript">
			alert("Document is now routed to <?php echo $_REQUEST['routeto'];?>.");
		</script>
		<?php
	}
	
?>