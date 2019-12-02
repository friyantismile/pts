<?php
//Modification
//Modified by : Yants
//Modified date : 04/04/2019
//Description : arrange logic of logout
//New code - 1
	include_once('../functions/login_functions.php');
	session_destroy();
	unset($_SESSION);
	verify_valid_system_user();
//New code - 1

	//old code 04/04/19
	// include_once('../functions/login_functions.php');
	// verify_valid_system_user();
	
	// include("../database/database_connection.php");

	// session_destroy();
	// unset($_SESSION);
	
?>
<script language="javascript">
	window.location = "login.php";
</script>