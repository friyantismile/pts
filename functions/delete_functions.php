<?php
	include("../database/database_connection.php");

	include('../functions/log_functions.php');
	
	if(isset($_REQUEST['delete'])){
		if($_REQUEST['delete']=="user"){
			mysqli_query($connection,"update tbl_users set status='0' where username='$_REQUEST[username]'");
			?>
			<script>
				alert("User Deactivated.");
				window.location = "../forms/home.php?menu=createusers";
			</script>
			<?php
		}
		if($_REQUEST['delete']=="office"){
			mysqli_query($connection,"update tbl_office set status='0' where office_code='$_REQUEST[code]'");
			?>
			<script>
				alert("Office Deactivated.");
				window.location = "../forms/home.php?menu=officeentry&form=entry";
			</script>
			<?php
		}
		if($_REQUEST['delete']=="subjectmatter"){
			mysqli_query($connection,"update tbl_subject_matter set status='0' where id='$_REQUEST[code]'");
			?>
			<script>
				alert("Subject matter Deactivated.");
				window.location = "../forms/home.php?menu=subjectmatter&form=entry";
			</script>
			<?php
		}
		if($_REQUEST['delete']=="document"){
			mysqli_query($connection,"update tbl_document set status='0' where document_code='$_REQUEST[code]'");
			?>
			<script>
				alert("Document Type Deactivated.");
				window.location = "../forms/home.php?menu=documenttype&form=entry";
			</script>
			<?php
		}
		if($_REQUEST['delete']=="method"){
			mysqli_query($connection,"update tbl_delivery_method set status='0' where id='$_REQUEST[id]'");
			?>
			<script>
				alert("Method Deactivated.");
				window.location = "../forms/home.php?menu=deliverymethod&form=entry";
			</script>
			<?php
		}

		if($_REQUEST['delete']=="newdocument"){
			mysqli_query($connection,"update tbl_document set status='0' where id='$_REQUEST[id]'");


			logs($_REQUEST['user'],"DELETE DOCUMENT $_REQUEST[barcode].");
			?>
			<script>
				alert("Deleted");
				window.location = "../forms/home.php?menu=newdocument&form=entry&table=default";
			</script>
			<?php
		}

		if($_REQUEST['delete']=="attachments"){
			mysqli_query($connection,"update tbl_document_attachments set status='0' where id='$_REQUEST[id]'");

			logs($_REQUEST['user'],"DELETE ATTACHMENT DOCUMENT $_REQUEST[barcode].");
			?>
			<script>
				alert("Deleted.");
				window.location = "../forms/home.php?menu=addattachments&docid=<?php echo $_REQUEST['docid'];?>&barcode=<?php echo $_REQUEST['barcode'];?>";
			</script>
			<?php
		}
	}
	else{
		echo "Error";
	}
	
?>