<?php
	include("../database/database_connection.php");
	
	if(isset($_REQUEST['activate'])){
		if($_REQUEST['activate']=="user"){
			mysqli_query($connection,"update tbl_users set status='1' where username='$_REQUEST[username]'");
			?>
			<script>
				alert("User Activated.");
				window.location = "../forms/home.php?menu=createusers";
			</script>
			<?php
		}
		if($_REQUEST['activate']=="office"){
			mysqli_query($connection,"update tbl_office set status='1' where office_code='$_REQUEST[code]'");
			?>
			<script>
				alert("Office Activated.");
				window.location = "../forms/home.php?menu=officeentry&form=entry";
			</script>
			<?php
		}
		if($_REQUEST['activate']=="document"){
			mysqli_query($connection,"update tbl_document set status='1' where document_code='$_REQUEST[code]'");
			?>
			<script>
				alert("Document Activated.");
				window.location = "../forms/home.php?menu=documenttype&form=entry";
			</script>
			<?php
		}
		if($_REQUEST['activate']=="method"){
			mysqli_query($connection,"update tbl_delivery_method set status='1' where id='$_REQUEST[id]'");
			?>
			<script>
				alert("Method Activated.");
				window.location = "../forms/home.php?menu=deliverymethod&form=entry";
			</script>
			<?php
		}
	}
	else{
		echo "Error";
	}

	
?>