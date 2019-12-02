<?php
include("../database/database_connection.php");
include_once('../functions/login_functions.php');
verify_valid_system_user();

if($access['access_level']=="A"){
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script>
		$(document).ready(function(){
		    $('#tabledocument').dataTable();
		});
	</script>
</head>
<body>
	<div class="form-document-entry">
		<?php
		if($_REQUEST['form']=="entry"){
			?>
			<form action="" method="post">
				<h4>Document</h4>
				<div class="form-group form-space">
					<input type="text" class="form-control" name="code" id="code" placeholder="Document Code" required="required">
		        </div>
		        <div class="form-group form-space">
					<input type="text" class="form-control" name="type" id="type" placeholder="Document Type" required="required">
		        </div>
		        <div class="form-group form-space">
		        	<button type="submit" class="btn btn-primary" value="savedocument" name="savedocument">Save Doc. Type</button>
		        </div>
	        </form>
			<?php
		}
		else if($_REQUEST['form']=="edit"){
			$show = mysqli_query($connection,"select * from tbl_document_type where document_code='$_REQUEST[code]'");
			$data = mysqli_fetch_assoc($show);

			?>
			<form action="" method="post">
				<h4>Document</h4>
				<div class="form-group form-space">
					<input type="text" class="form-control" name="code" id="code" placeholder="Document Code" value="<?php echo $data['document_code']; ?>" readonly="readonly">
		        </div>
		        <div class="form-group form-space">
					<input type="text" class="form-control" name="type" id="type" placeholder="Document Type" value="<?php echo $data['document_type']; ?>" required="required">
		        </div>
		        <div class="form-group form-space">
		        	<button type="submit" class="btn btn-primary" value="editdocument" name="editdocument">Edit Office</button>
		        </div>
	        </form>
			<?php
		}
		else{
			echo "error";
		}
		?>
		
	</div>
	<div class="table-document-entry">
		<table id="tabledocument" class="table table-striped table-hover" >  
            <thead>  
                <tr>  
                    <th>Doc. Code</th> 
                    <th>Doc. Type</th>
                    <th>Status</th>
                    <th>Action</th>                     
                </tr>  
            </thead> 
            <tbody>
            	<?php
            		$qry_show = mysqli_query($connection,"select * from tbl_document_type");
            		for($a=1;$a<=mysqli_num_rows($qry_show);$a++){
            			$data = mysqli_fetch_assoc($qry_show);
            			echo "<tr>";
            			echo "<td>$data[document_code]</td>";
            			echo "<td>$data[document_type]</td>";
            			if($data['status']==1){
            				echo "<td>Active</td>";
            				echo "<td>";
	            			echo "<a href='home.php?menu=documenttype&form=edit&code=$data[document_code]'><img src='../images/edit.png' class='action-btn' title='Edit'></a> ";
	            			echo "<a href='../functions/delete_functions.php?delete=document&code=$data[document_code]'><img src='../images/delete.png' class='action-btn' title='Delete'></a>";
	            			echo "</td>";
            			}
            			else{
            				echo "<td>Inactive</td>";
	            			echo "<td>";
	            			echo "<a href='home.php?menu=documenttype&form=edit&code=$data[document_code]'><img src='../images/edit.png' class='action-btn' title='Edit'></a> ";
	            			echo "<a href='../functions/functions.php?activate=document&code=$data[document_code]'><img src='../images/check.png' class='action-btn' title='Activate'></a>";
	            			echo "</td>";
            			}
            			
            			echo "</tr>";
            		}
            	?>
            </tbody>
         </table>
	</div>
</body>
</html>
<?php
	if(isset($_REQUEST['savedocument'])){	
		mysqli_query($connection,"insert into tbl_document_type values('$_REQUEST[code]','$_REQUEST[type]','1')");
		?>
		<script type="text/javascript">
			alert("Document Type Saved.");
			window.location = "home.php?menu=documenttype&form=entry";
		</script>
		<?php
	}

	if(isset($_REQUEST['editdocument'])){
		mysqli_query($connection,"update tbl_document_type set document_type='$_REQUEST[type]' where document_code='$_REQUEST[code]'");
		?>
		<script type="text/javascript">
			alert("Saved");
			window.location = "home.php?menu=documenttype&form=entry";
		</script>
		<?php
	}
}
?>