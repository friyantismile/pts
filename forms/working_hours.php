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
		$qry = mysqli_query($connection,"select * from tbl_working_hours");
		$data = mysqli_fetch_assoc($qry);
	?>
	<div class="working-hours-container">
		<form action="" method="post">
			<h4>Working Hours</h4>
			<div class="form-group form-inline">
				<input type="text" class="form-control" value="<?php echo $data['time_start']; ?>" name="timestart" id="timestart" placeholder="Time Start" required="required"> to 
				<input type="text" class="form-control" value="<?php echo $data['time_end']; ?>" name="timeend" id="timeend" placeholder="Time End" required="required">
	        	<button type="submit" class="btn btn-primary" value="save" name="save">Save</button>
	        </div>
        </form>
	</div>
</body>
</html>
<?php
	if(isset($_REQUEST['save'])){

		$time_start = $_REQUEST['timestart'];
		$time_end = $_REQUEST['timeend'];

		mysqli_query($connection,"update tbl_working_hours set time_start='$time_start', time_end='$time_end'");

		?>
			<script type="text/javascript">
				alert("Working Hours Saved");
				window.location = "home.php?menu=workinghours&form=entry";
			</script>
		<?php
	}
}
?>