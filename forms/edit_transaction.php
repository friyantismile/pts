<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="transact-container">
		<div class="transact-result">
			<form action="" method="post">
				<?php
				$qry = mysqli_query($connection,"select * from tbl_document_transaction where trans_id='$_REQUEST[transid]'");
				$show = mysqli_fetch_assoc($qry);
				?>
				<h4>Edit Transaction</h4>
				<div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:173px;">Recieve Action</div>
				</div>
				<div class="form-group">
					<input type="hidden" value="<?php echo $show['barcode'];?>" id="barcode" name="barcode">
					<input type="text" class="form-control" name="recieveaction" id="recieveaction" placeholder="Recieve Action" value="<?php echo $show['recieve_action'];?>">
				</div>
				<div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:173px;">Release Action</div>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="releaseaction" id="releaseaction" placeholder="Release Action" value="<?php echo $show['release_action'];?>">
				</div>
				<div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:173px;">Remarks</div>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="remarks" id="remarks" placeholder="Remarks" value="<?php echo $show['remarks'];?>">
				</div>
				<div class="form-group form-space form-inline">
		        	<button type="submit" class="btn btn-primary" value="releasedocument" name="releasedocument" id="releasedocument">Update</button>
		        </div>
			</form>
		</div>
	</div>
</body>
</html>
<?php
	if(isset($_REQUEST['releasedocument'])){
		$qry = mysqli_query($connection,"update tbl_document_transaction set recieve_action='$_REQUEST[recieveaction]', release_action='$_REQUEST[releaseaction]', remarks='$_REQUEST[remarks]' where trans_id='$_REQUEST[transid]'");

		?>	
			<script type="text/javascript">
				alert("Edited.");
				window.location = "home.php?menu=viewdocument&barcode=<?php echo $_REQUEST['barcode'];?>";
			</script> 
		<?php

	}
?>