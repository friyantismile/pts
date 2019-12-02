<?php
	$db_host = "127.0.0.1";
	$db_username = "root";
	$db_password = "";
	$db_name = "db_dts";
	
	$connection = mysqli_connect($db_host,$db_username,$db_password,$db_name);
	//$database = mysqli_select_db($db_name,$connection);


	$db_name2 = "old_dts";
	
	$connection2 = mysqli_connect($db_host,$db_username,$db_password,$db_name2);
	//$database = mysqli_select_db($db_name,$connection);



	$qry = mysqli_query($connection,"select *,(a.office_code)res_office from tbl_document_transaction a, tbl_document b where a.barcode=b.barcode and a.status!=0 and a.office_time!=0 and b.status!=0");

	for($a=1;$a<=mysqli_num_rows($qry);$a++){
		$rows = mysqli_fetch_assoc($qry);

		//get performance
		$qry_performance = mysqli_query($connection,"select * from tbl_office_performance where office_code='$rows[res_office]' and document_code='$rows[document_type]'");
		$performance = mysqli_fetch_assoc($qry_performance);

		//check performance
		if($rows['office_time']>$performance['office_time']){

			$delayed_time = $rows['office_time']-$performance['office_code'];

			$in_days = number_format($delayed_time/$performance['office_time'],2);

			echo "Document $rows[barcode] delayed for $in_days days  at $rows[res_office].";
			echo "<br>";
		}
		else{
			//echo "No delayed document";
		}

	}


?>