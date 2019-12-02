<?php
	include("../database/database_connection.php");
  	include_once('../functions/login_functions.php');
 	verify_valid_system_user();

 	$system_user = $_SESSION['valid_dts_user'];
	$qry_access = mysqli_query($connection,"select * from tbl_users where username='$system_user'");
	$access = mysqli_fetch_assoc($qry_access);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Document Tracking System</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<script src="../bootstrap/js/jquery.min.js"></script>
	<script src="../bootstrap/js/bootstrap.min.js"></script>
	<!-- other css -->
	<link rel="stylesheet" href="../bootstrap/css/designs.min.css">

	<!-- For Tables -->
	<link rel="stylesheet" href="../bootstrap/css/dataTables.min.css">
	<script type="text/javascript" src="../bootstrap/js/dataTables.min.js"></script>
	<link rel="icon" href="../images/dts.png" type="image/gif" sizes="16x16">
</head>
<body>
	
	<div class="container-report-delin">
		<table class="table-report">
			<tr>
				<td colspan="2" style="text-align: center;"><h4>DOCUMENT TRACKING SYSTEM REPORT</h4></td>
			</tr>
			<tr>
				<td style="width:150px;">REPORT TYPE:</td>
				<td>Unended Transaction</td>
			</tr>
			<tr>
				<td style="width:150px;">Department:</td>
				<td><?php echo $_REQUEST['office'];?></td>
			</tr>
		</table>
		<br>
		<table class="table-report" border="1">
			<tr align="center" style="font-weight: bold;">
				<td width="50px;">#</td>
				<td width="100px;">Barcode</td>
				<td width="80px;">Date</td>
				<td width="100px;">Doc. Type</td>
				<td width="250px;">Source</td>
				<td>Subject Matter</td>
				<!-- <td width="200px;">Routed To</td> -->
				<!-- <a href='../forms/tracking_result.php?barcode=$rows[barcode]&acode=$rows[access_code]' target='_blank'></a> -->
			</tr>
			<?php
				$datenow = date("Y-m-d H:i:s");
				$current = date("Y-m");

				$qry = mysqli_query($connection,"select distinct(a.barcode)barcode,DATE_FORMAT(a.recieve_date,'%m %d, %Y')dte,a.document_type,a.source_name,a.access_code,a.subject_matter from tbl_document a, tbl_document_transaction b where a.transaction_status='' and a.barcode=b.barcode and a.status!=0 and b.route_office_code='$_REQUEST[office]' and b.status='1'  order by id desc ");

				for($a=1;$a<=mysqli_num_rows($qry);$a++){
					$rows = mysqli_fetch_assoc($qry);
					echo "<tr>";
					echo "<td align='left'>&nbsp; $a</td>";
					echo "<td align='center'>$rows[barcode]</td>"; 
					echo "<td align='center'>$rows[dte]</td>";
					echo "<td align='center'>$rows[document_type]</td>";
					echo "<td>&nbsp;".ucwords($rows['source_name'])."</td>";
					echo "<td style='padding:2px;'>$rows[subject_matter]</td>";

					//echo "<td align='center'>";

					// $qry_current = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$rows[barcode]' and status='1' ");
					// for($b=1;$b<=mysqli_num_rows($qry_current);$b++){
					// 	$data = mysqli_fetch_assoc($qry_current);	
					// 	if($data['route_office_code']==""){
					// 		echo $data['office_code']."<br>";
					// 	}
					// 	else{
					// 		echo $data['route_office_code']."<br>";
					// 	}
						
					// }

					//echo "</td>";
					echo "</tr>";
				}

			?>
		</table>
		
		

	</div>
</body>
</html>