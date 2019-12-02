<?php
include("../database/database_connection.php");
include_once('../functions/login_functions.php');
verify_valid_system_user();

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="changepass-container">
		<form action="" method="post">
			<h4>Change Password</h4>
			<div class="form-group form-inline form-space">
				<input type="password" class="form-control" name="currentpassword" id="currentpassword" placeholder="Current Password" required="required" style="width: 165px;">
				<input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="New Password" required="required" style="width: 165px;">
				<input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" required="required" style="width: 165px;">
				<button type="submit" class="btn btn-primary" value="confirm" name="confirm">Confirm Change</button>
	        </div>
	    </form>
	</div>
</body>
</html>
<?php
	if(isset($_REQUEST['confirm'])){
		//condition

		if($access['password']<>md5($_REQUEST['currentpassword'])){
			?>
			<script type="text/javascript">
				alert("Current password does not match on the database.");
			</script>
			<?php
		}
		else{
			if($_REQUEST['newpassword']<>$_REQUEST['confirmpassword']){

				logs($access['username'],"CHANGE PASSWORD ERROR.");
				?>
				<script type="text/javascript">
					alert("New Password does not match the confirm password.");
				</script>
				<?php
			}
			else{
				$qry_update = mysqli_query($connection,"update tbl_users set password=md5('$_REQUEST[confirmpassword]') where username='$access[username]'");

				logs($access['username'],"PASSWORD CHANGED.");
				?>
				<script type="text/javascript">
					alert("Password Updated. Prepare to logout.");
					window.location = "../forms/logout.php";
				</script>
				<?php
			}
		}
	}

?>