<?php
	function logs($username,$action){
		include("../database/database_connection.php");
		$current_datetime = date("Y-m-d H:i:s");
		mysqli_query($connection,"insert into tbl_logs values('','$current_datetime','$username','$action')");
	}
?>