<?php
	$db_host = "127.0.0.1";
	$db_username = "root";
	$db_password = "";
	$db_name = "old_dts";
	
	$connection = mysqli_connect($db_host,$db_username,$db_password,$db_name);

	$qry = mysqli_query($connection,"select * from tbl_doc where date_doc like '%/2013'");
	for($a=1;$a<=mysqli_num_rows($qry);$a++){
		$data = mysqli_fetch_assoc($qry);

		$exp_date = explode("/",$data['date_doc']);

		$new_date = $exp_date[2]."-".$exp_date[0]."-".$exp_date[1];

		mysqli_query($connection,"update tbl_doc set new_date='$new_date' where id_doc='$data[id_doc]'");
	}
	echo "done! alright!";
?> 