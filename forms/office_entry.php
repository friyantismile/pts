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
		    $('#tableoffice').dataTable();
		});
	</script>
</head>
<body>
	<div class="form-office-entry">
		<?php
		if($_REQUEST['form']=="entry"){
			?>
			<form action="" method="post">
				<h4>Office</h4>
				<div class="form-group form-space">
					<input type="text" class="form-control" name="code" id="code" placeholder="Office Code" maxlength="5" required="required">
		        </div>
		        <div class="form-group form-space">
					<input type="text" class="form-control" name="name" id="name" placeholder="Office Name" required="required">
		        </div>
		        <div class="form-group form-space">
		        	<button type="submit" class="btn btn-primary" value="saveoffice" name="saveoffice">Save Office</button>
		        </div>
	        </form>
			<?php
		}
		else if($_REQUEST['form']=="edit"){
			$show = mysqli_query($connection,"select * from tbl_office where office_code='$_REQUEST[code]'");
			$data = mysqli_fetch_assoc($show);

			?>
			<form action="" method="post">
				<h4>Office</h4>
				<div class="form-group form-space">
					<input type="text" class="form-control" name="code" id="code" placeholder="Office Code" value="<?php echo $data['office_code']; ?>" readonly="readonly">
		        </div>
		        <div class="form-group form-space">
					<input type="text" class="form-control" name="name" id="name" placeholder="Office Name" value="<?php echo $data['office_name']; ?>" required="required">
		        </div>
		        <div class="form-group form-space">
		        	<button type="submit" class="btn btn-primary" value="editoffice" name="editoffice">Edit Office</button>
		        </div>
	        </form>
			<?php
		}
		else{
			echo "error";
		}
		?>
		
	</div>
	<div class="table-office-entry">
		<table id="tableoffice" class="table table-striped table-hover" >  
            <thead>  
                <tr>  
                    <th>Office Code</th> 
                    <th>Office Name</th>
                    <th>Status</th>
                    <th>Action</th>                     
                </tr>  
            </thead> 
            <tbody>
            	<?php
            		$qry_show = mysqli_query($connection,"select * from tbl_office");
            		for($a=1;$a<=mysqli_num_rows($qry_show);$a++){
            			$data = mysqli_fetch_assoc($qry_show);
            			echo "<tr>";
            			echo "<td>$data[office_code]</td>";
            			echo "<td>$data[office_name]</td>";
            			if($data['status']==1){
            				echo "<td>Active</td>";
            				echo "<td>";
	            			echo "<a href='home.php?menu=officeentry&form=edit&code=$data[office_code]'><img src='../images/edit.png' class='action-btn' title='Edit'></a> ";
	            			echo "<a href='../functions/delete_functions.php?delete=office&code=$data[office_code]'><img src='../images/delete.png' class='action-btn' title='Delete'></a>";
	            			echo "</td>";
            			}
            			else{
            				echo "<td>Inactive</td>";
	            			echo "<td>";
	            			echo "<a href='home.php?menu=officeentry&form=edit&code=$data[office_code]'><img src='../images/edit.png' class='action-btn' title='Edit'></a> ";
	            			echo "<a href='../functions/functions.php?activate=office&code=$data[office_code]'><img src='../images/check.png' class='action-btn' title='Activate'></a>";
	            			echo "</td>";
            			}
            			
            			echo "</tr>";
            		}
            	?>
            </tbody>
         </tbody>
	</div>
</body>
</html>
<?php
	if(isset($_REQUEST['saveoffice'])){	
		$officenme = addslashes($_REQUEST['name']);
		mysqli_query($connection,"insert into tbl_office values('$_REQUEST[code]','$officenme','1')");
		?>
		<script type="text/javascript">
			alert("Office Saved");
			window.location = "home.php?menu=officeentry&form=entry";
		</script>
		<?php
	}

	if(isset($_REQUEST['editoffice'])){

		$officenme = addslashes($_REQUEST['name']);
		
		mysqli_query($connection,"update tbl_office set office_name='$officenme' where office_code='$_REQUEST[code]'");
		?>
		<script type="text/javascript">
			alert("Saved");
			window.location = "home.php?menu=officeentry&form=entry";
		</script>
		<?php
	}
}
?>