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
		    $('#tablemethod').dataTable();
		});
	</script>
</head>
<body>
	<div class="form-method">
		<?php
		if($_REQUEST['form']=="entry"){
			?>
			<form action="" method="post">
				<h4>Delivery Method</h4>
				<div class="form-group form-space">
					<input type="text" class="form-control" name="method" id="method" placeholder="Method" required="required">
		        </div>
		        <div class="form-group form-space">
		        	<button type="submit" class="btn btn-primary" value="save" name="save">Save Method</button>
		        </div>
	        </form>
			<?php
		}
		else if($_REQUEST['form']=="edit"){
			$show = mysqli_query($connection,"select * from tbl_delivery_method where id='$_REQUEST[id]'");
			$data = mysqli_fetch_assoc($show);

			?>
			<form action="" method="post">
				<h4>Delivery Method</h4>
				<div class="form-group form-space">
					<input type="text" class="form-control" name="method" id="method" placeholder="Method" value="<?php echo $data['method']; ?>">
		        </div>
		        <div class="form-group form-space">
		        	<button type="submit" class="btn btn-primary" value="edit" name="edit">Edit Method</button>
		        </div>
	        </form>
			<?php
		}
		else{
			echo "error";
		}
		?>
		
	</div>
	<div class="table-method">
		<table id="tablemethod" class="table table-striped table-hover" >  
            <thead>  
                <tr>  
                    <th>Method</th> 
                    <th>Status</th>
                    <th>Action</th>                     
                </tr>  
            </thead> 
            <tbody>
            	<?php
            		$qry_show = mysqli_query($connection,"select * from tbl_delivery_method");
            		for($a=1;$a<=mysqli_num_rows($qry_show);$a++){
            			$data = mysqli_fetch_assoc($qry_show);
            			echo "<tr>";
            			echo "<td>$data[method]</td>";
            			if($data['status']==1){
            				echo "<td>Active</td>";
            				echo "<td>";
	            			echo "<a href='home.php?menu=deliverymethod&form=edit&id=$data[id]'><img src='../images/edit.png' class='action-btn' title='Edit'></a> ";
	            			echo "<a href='../functions/delete_functions.php?delete=method&id=$data[id]'><img src='../images/delete.png' class='action-btn' title='Delete'></a>";
	            			echo "</td>";
            			}
            			else{
            				echo "<td>Inactive</td>";
	            			echo "<td>";
	            			echo "<a href='home.php?menu=deliverymethod&form=edit&id=$data[id]'><img src='../images/edit.png' class='action-btn' title='Edit'></a> ";
	            			echo "<a href='../functions/functions.php?activate=method&id=$data[id]'><img src='../images/check.png' class='action-btn' title='Activate'></a>";
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
	if(isset($_REQUEST['save'])){	
		mysqli_query($connection,"insert into tbl_delivery_method values(NULL,'$_REQUEST[method]','1')");
		?>
		<script type="text/javascript">
			alert("Document Type Saved.");
			window.location = "home.php?menu=deliverymethod&form=entry";
		</script>
		<?php
	}

	if(isset($_REQUEST['edit'])){
		mysqli_query($connection,"update tbl_delivery_method set method='$_REQUEST[method]' where id='$_REQUEST[id]'");
		?>
		<script type="text/javascript">
			alert("Saved");
			window.location = "home.php?menu=deliverymethod&form=entry";
		</script>
		<?php
	}
}
?>