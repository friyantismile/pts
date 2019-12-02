<?php
//Modification
//Modified by : Yants
//Modified date : 04/04/2019
//Description : Subject matter settings added
/*
Database
Added table tbl_subject_matter (id, code, name, status {1-active, 0-inactive})
*/
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
		    $('#subjectmatter').dataTable();
		});
	</script>
</head>
<body>
	<div class="form-office-entry">
		<?php
		if($_REQUEST['form']=="entry"){
		 
			?>
			<form action="" method="post">
				<h4>Subject Matter</h4>
				<div class="form-group form-space">
					<input type="text" class="form-control" name="code" id="code" placeholder="Subject Matter Code" maxlength="10" required="required">
		        </div>
		        <div class="form-group form-space">
					<input type="text" class="form-control" name="name" id="name" placeholder="Subject Matter Name" required="required">
		        </div>
		        <div class="form-group form-space">
		        	<button type="submit" class="btn btn-primary" value="savesubjectmatter" name="savesubjectmatter">Save Subject Matter</button>
		        </div>
	        </form>
			<?php
		}
		else if($_REQUEST['form']=="edit"){
			$show = mysqli_query($connection,"select * from tbl_subject_matter where code='$_REQUEST[code]'");
			$data = mysqli_fetch_assoc($show);

			?>
			<form action="" method="post">
				<h4>Subject Matter</h4>
				<div class="form-group form-space">
					<input type="text" class="form-control" name="code" id="code" placeholder="Subject Matter Code" value="<?php echo $data['office_code']; ?>" readonly="readonly">
		        </div>
		        <div class="form-group form-space">
					<input type="text" class="form-control" name="name" id="name" placeholder="Subject Matter Name" value="<?php echo $data['office_name']; ?>" required="required">
		        </div>
		        <div class="form-group form-space">
		        	<button type="submit" class="btn btn-primary" value="editsubjectmatter" name="editoffice">Edit Subject Matter</button>
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
		<table id="subjectmatter" class="table table-striped table-hover" >  
            <thead>  
                <tr>  
                    <th>Subject Matter Code</th> 
                    <th>Subject Matter Name</th>
                    <th>Status</th>
                    <th>Action</th>                     
                </tr>  
            </thead> 
            <tbody>
            	<?php
            		$qry_show = mysqli_query($connection,"select * from tbl_subject_matter");
            		for($a=1;$a<=mysqli_num_rows($qry_show);$a++){
            			$data = mysqli_fetch_assoc($qry_show);
            			echo "<tr>";
            			echo "<td>$data[code]</td>";
            			echo "<td>$data[subject_matter]</td>";
            			if($data['status']==1){
            				echo "<td>Active</td>";
            				echo "<td>";
	            			echo "<a href='home.php?menu=subjectmatter&form=edit&code=$data[id]'><img src='../images/edit.png' class='action-btn' title='Edit'></a> ";
	            			echo "<a href='../functions/delete_functions.php?delete=subjectmatter&code=$data[id]'><img src='../images/delete.png' class='action-btn' title='Delete'></a>";
	            			echo "</td>";
            			}
            			else{
            				echo "<td>Inactive</td>";
	            			echo "<td>";
	            			echo "<a href='home.php?menu=subjectmatter&form=edit&code=$data[id]'><img src='../images/edit.png' class='action-btn' title='Edit'></a> ";
	            			echo "<a href='../functions/functions.php?activate=subjectmatter&code=$data[id]'><img src='../images/check.png' class='action-btn' title='Activate'></a>";
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
	if(isset($_REQUEST['savesubjectmatter'])){
		 
		$subjectmatter = addslashes($_REQUEST['name']);
		mysqli_query($connection,"insert into tbl_subject_matter values('','$_REQUEST[code]','$subjectmatter','1')");
		 
		?>
		<script type="text/javascript">
			alert("Subject matter saved");
			window.location = "home.php?menu=subjectmatter&form=entry";
		</script>
		<?
		echo "========================================================";
	}

	if(isset($_REQUEST['editsubjectmatter'])){

		$subjectmatter = addslashes($_REQUEST['name']);
		
		mysqli_query($connection,"update tbl_subject_matter set subject_matter='$subjectmatter' where id='$_REQUEST[code]'");
		?>
		<script type="text/javascript">
			alert("Saved");
			window.location = "home.php?menu=subjectmatter&form=entry";
		</script>
		<?php
	}
}
?>