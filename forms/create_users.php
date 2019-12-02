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
		    $('#tableusers').dataTable();
		});
	</script>
</head>
<body>
	<div class="form-create-user">
		<?php
		if(isset($_REQUEST['edit'])){

			$qry = mysqli_query($connection,"select * from tbl_users where username='$_REQUEST[un]'");
			$dataUser = mysqli_fetch_assoc($qry);

			$selected_office = mysqli_query($connection,"select * from tbl_office where office_code='$dataUser[office_code]'");
	        $so = mysqli_fetch_assoc($selected_office);


	        if($dataUser['access_level']=="A"){

	        }
	        else if($dataUser['access_level']=="R"){

	        }
	        else{ //U

	        }

		?>
		<form action="" method="post">
			<h4>Edit User Account</h4>
			<div class="form-group form-inline form-space">
				<input type="text" class="form-control" name="fullname" id="fullname" value="<?php echo $dataUser['full_name'];?>" placeholder="Full Name" required="required" style="width: 180px;">
				<input type="text" class="form-control" name="username" id="username" value="<?php echo $dataUser['username'];?>" placeholder="Username" required="required" style="width: 180px;" readonly="readonly">
	        </div>
	        <!-- <div class="form-group form-inline form-space">
				<input type="password" class="form-control" name="password" id="password" placeholder="Password" required="required" style="width: 180px;">
				<input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" required="required" style="width: 180px;">
	        </div> -->
			<div class="form-group form-space">
	            <select class="form-control" id="officeid" name="officeid" required="required">
	                              
	                <option value="<?php echo $so['office_code'];?>"><?php echo strtoupper($so['office_name']);?></option>
	                <?php

	                	$show_office = mysqli_query($connection,"select * from tbl_office order by office_name asc");
	                	for($a=1;$a<=mysqli_num_rows($show_office);$a++){
	                		$office = mysqli_fetch_assoc($show_office);
	                		echo "<option value='$office[office_code]'>".strtoupper($office['office_name'])."</option>";
	                	}
	                ?>
	            </select>
	        </div>
	        <div class="form-group form-space">

	            <select class="form-control" id="accesslevel" name="accesslevel" required="required">
	                <?php
	                if($dataUser['access_level']=="A"){
	        			?>
	        			<option value="A">SYSTEM ADMINISTRATOR</option>
		                <option value="R">RECORDS MANAGER</option>
		                <option value="U">USER</option>
			        	<?php
			        }
			        else if($dataUser['access_level']=="R"){
			        	?>
		                <option value="R">RECORDS MANAGER</option>
		                <option value="U">USER</option>
		                <option value="A">SYSTEM ADMINISTRATOR</option>
			        	<?php
			        }
			        else{ //U
			        	?>
			        	<option value="U">USER</option>
		                <option value="R">RECORDS MANAGER</option>
		                <option value="A">SYSTEM ADMINISTRATOR</option>
			        	<?php
			        }
	                ?>
	            </select>
	        </div>
	        <div class="form-group form-space">
	        	<button type="submit" class="btn btn-primary" value="updateuser" name="updateuser">Update User</button>
	        </div>
        </form>
        <?php
    	}
    	else{
		?>
		<form action="" method="post">
			<h4>Create User Account</h4>
			<div class="form-group form-inline form-space">
				<input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name" required="required" style="width: 180px;">
				<input type="text" class="form-control" name="username" id="username" placeholder="Username" required="required" style="width: 180px;">
	        </div>
	        <div class="form-group form-inline form-space">
				<input type="password" class="form-control" name="password" id="password" placeholder="Password" required="required" style="width: 180px;">
				<input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" required="required" style="width: 180px;">
	        </div>
			<div class="form-group form-space">
	            <select class="form-control" id="officeid" name="officeid" required="required">
	                <option value="">Select Office</option>
	                <?php
	                	$show_office = mysqli_query($connection,"select * from tbl_office order by office_name asc");
	                	for($a=1;$a<=mysqli_num_rows($show_office);$a++){
	                		$office = mysqli_fetch_assoc($show_office);
	                		echo "<option value='$office[office_code]'>".strtoupper($office['office_name'])."</option>";
	                	}
	                ?>
	            </select>
	        </div>
	        <div class="form-group form-space">
	            <select class="form-control" id="accesslevel" name="accesslevel" required="required">
	                <option value="">Select Access Level</option>
	                <option value="U">USER</option>
	                <option value="R">RECORDS MANAGER</option>
	                <option value="A">SYSTEM ADMINISTRATOR</option>
	            </select>
	        </div>
	        <div class="form-group form-space">
	        	<button type="submit" class="btn btn-primary" value="saveuser" name="saveuser">Save User</button>
	        </div>
        </form>
        <?php
  		}
        ?>
        
	</div>
	<div class="table-create-user">
		<table id="tableusers" class="table table-striped table-hover" >  
            <thead>  
                <tr>  
                    <th>Username</th> 
                    <th>Full Name</th>
                    <th>Office</th>
                    <th>Access Level</th>
                    <th>Status</th>
                    <th>Action</th>                     
                </tr>  
            </thead> 
            <tbody>
            	<?php
            		$qry_show = mysqli_query($connection,"select *,(a.status)stat from tbl_users a, tbl_office b where a.office_code=b.office_code");
            		for($a=1;$a<=mysqli_num_rows($qry_show);$a++){
            			$data = mysqli_fetch_assoc($qry_show);
            			echo "<tr>";
            			echo "<td>$data[username]</td>";
            			echo "<td>".ucwords($data['full_name'])."</td>";
            			echo "<td>$data[office_code]</td>";
            			
            			if($data['access_level']=='A'){
            				$al = "ADMINISTRATOR";	
            			}
            			else{
            				$al = "USER";
            			}
            			echo "<td>$al</td>";

            			if($data['stat']=='1'){
            				echo "<td>Active</td>";
            			}
            			else{
            				echo "<td>Inactive</td>";
            			}

            			echo "<td>";
            			if($access['username']==$data['username']){
            				echo "-";
            			}
            			else{
            				echo "<a href='home.php?menu=createusers&edit&un=$data[username]'><img src='../images/edit.png' class='action-btn' title='Activate'></a> ";

            				if($data['stat']=='1'){
            					echo "<a href='../functions/delete_functions.php?delete=user&username=$data[username]'><img src='../images/delete.png' class='action-btn' title='Delete'></a> ";
            				}
            				else{
            					echo "<a href='../functions/functions.php?activate=user&username=$data[username]'><img src='../images/activate.png' class='action-btn' title='Activate'></a> ";
            				}
            				
            			}
            			echo "</td>";
            			echo "</tr>";
            		}
            	?>
            	
            </tbody>
         </tbody>
	</div>
</body>
</html>
<?php
	if(isset($_REQUEST['saveuser'])){
		if($_REQUEST['password']==$_REQUEST['confirmpassword']){
			$qryusers = mysqli_query($connection,"select * from tbl_users where username='$_REQUEST[username]'");
			if(mysqli_num_rows($qryusers) > 0) {
				?>
				<script type="text/javascript">
					alert("Username already exist!");
					window.location = "home.php?menu=createusers";
				</script>
				<?php
				exit;
			}
			mysqli_query($connection,"insert into tbl_users values('$_REQUEST[username]','$_REQUEST[fullname]',md5('$_REQUEST[password]'),'$_REQUEST[officeid]','$_REQUEST[accesslevel]','1')");
			?>
			<script type="text/javascript">
				alert("User Saved");
				window.location = "home.php?menu=createusers";
			</script>
			<?php
		}
		else{
			?>
			<script type="text/javascript">
				alert("Password Error. User cannot be saved.");
				window.location = "home.php?menu=createusers";
			</script>
			<?php
		}
	}

	if(isset($_REQUEST['updateuser'])){
		
		mysqli_query($connection,"update tbl_users set full_name='$_REQUEST[fullname]', office_code='$_REQUEST[officeid]', access_level='$_REQUEST[accesslevel]' where username='$_REQUEST[username]'");
		?>
		<script type="text/javascript">
			alert("User Updated");
			window.location = "home.php?menu=createusers";
		</script>
		<?php
		
	}

}
?>