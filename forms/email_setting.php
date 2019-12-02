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
	<?php
		$qry = mysqli_query($connection,"select * from tbl_email");
		$data = mysqli_fetch_assoc($qry);
	?>
	<div class="email-setting-container">
		<form action="" method="post">
			<h4>E-Mail Setting</h4>
			<div class="form-group">
				<input type="text" class="form-control" name="host" id="host" placeholder="Host" value="<?php echo $data['host']; ?>" required="required">
	        </div>
	        <div class="form-group">
				<input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $data['username']; ?>" required="required">
	        </div>
	        <div class="form-group">
				<input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php  echo $data['password']; ?>" required="required">
	        </div>
	        <div class="form-group">
				<input type="text" class="form-control" name="port" id="port" placeholder="Port" value="<?php  echo $data['port']; ?>" required="required">
	        </div>
	        <button type="submit" class="btn btn-primary" value="save" name="save">Save</button>
        </form>
	</div>
</body>
</html>
<?php
	if(isset($_REQUEST['save'])){

		mysqli_query($connection,"update tbl_email set host='$_REQUEST[host]', username='$_REQUEST[username]', password='$_REQUEST[password]', port='$_REQUEST[port]'");

		?>
			<script type="text/javascript">
				alert("Saved");
				window.location = "home.php?menu=emailsetting&form=entry";
			</script>
		<?php
	}
}
?>