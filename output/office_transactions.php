<?php
if(isset($_REQUEST['office'])&&isset($_REQUEST['tomm'])){
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
	<?php
	/*------------date-------------------*/
	$date_from_display = $_REQUEST['frommm']."/".$_REQUEST['fromdd']."/".$_REQUEST['fromyyyy'];
	$date_to_display = $_REQUEST['tomm']."/".$_REQUEST['todd']."/".$_REQUEST['toyyyy'];

	$date = $_REQUEST['toyyyy']."-".$_REQUEST['tomm']."-".$_REQUEST['todd'];
	$date1 = str_replace('-', '/', $date);
	$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));

	$tomorrow;
	
	$date_from = $_REQUEST['fromyyyy']."-".$_REQUEST['frommm']."-".$_REQUEST['fromdd'];
	$date_to = $tomorrow;
	?>
	<div class="container-report-indi">
		<table width="800px;">
			<tr>
				<td colspan="2" style="text-align: center;"><h4>DOCUMENT TRACKING SYSTEM REPORT</h4></td>
			</tr>
			<tr>
				<td style="width:150px;">REPORT TYPE:</td>
				<td>Department Transaction Summary</td>
			</tr>
			<tr>
				<td style="width:150px;">DATE RANGE:</td>
				<td><?php echo $date_from_display." to ".$date_to_display?></td>
			</tr>
		</table>
		<br>
		<?php
			$qry = mysqli_query($connection,"select * from tbl_users where office_code='$_REQUEST[office]' and status='1'");
			for($a=1;$a<=mysqli_num_rows($qry);$a++){
				$user = mysqli_fetch_assoc($qry);

				echo "Name : ".$user['full_name'];
				?>
					<table border="1">
						<tr align="center" style="font-weight: bold;">
							<td width="280px;">Document Type</td>
							<td width="130px;">Received </td>
							<td width="130px;">Released </td>	
							<td width="130px;">Total Transactions </td>							
						</tr>
						<?php
						$qry_doc = mysqli_query($connection,"select * from tbl_document_type where status='1' order by document_code asc");
						for($b=1;$b<=mysqli_num_rows($qry_doc);$b++){
							$doc = mysqli_fetch_assoc($qry_doc);
							echo "<tr>";
							echo "<td>&nbsp;$doc[document_code] - $doc[document_type]</td>";

							//received
							$rec = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b where a.barcode=b.barcode and a.document_type='$doc[document_code]' and a.status!='0'  and b.status!='0' and b.person='$user[full_name]' and b.office_code='$_REQUEST[office]' and b.recieve_date_time between '$date_from 00:00:00' and '$date_to 23:59:59'");
							
							echo "<td align='right'>".mysqli_num_rows($rec)."&nbsp;</td>";

							//release
							$rel = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b where a.barcode=b.barcode and a.document_type='$doc[document_code]' and a.status!='0'  and b.status!='0' and b.rel_person='$user[full_name]' and b.office_code='$_REQUEST[office]' and b.release_date_time between '$date_from 00:00:00' and '$date_to 23:59:59'");
							
							echo "<td align='right'>".mysqli_num_rows($rel)."&nbsp;</td>";

							$total = mysqli_num_rows($rec)+mysqli_num_rows($rel);
							echo "<td align='right'>$total&nbsp;</td>";
							echo "</tr>";
						}

						?>
						<tr align="center" style="font-weight: bold;">
							<td align="right">Total&nbsp;&nbsp;</td>
							<?php
								//total received
								$trec = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b where a.barcode=b.barcode and b.person='$user[full_name]' and a.status!='0'  and b.status!='0' and b.office_code='$_REQUEST[office]' and b.recieve_date_time between '$date_from 00:00:00' and '$date_to 23:59:59'");
								
								echo "<td align='right'>".mysqli_num_rows($trec)."&nbsp;</td>";

								//total release
								$trel = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b where a.barcode=b.barcode and b.rel_person='$user[full_name]' and a.status!='0'  and b.status!='0' and b.office_code='$_REQUEST[office]' and b.release_date_time between '$date_from 00:00:00' and '$date_to 23:59:59'");
								
								echo "<td align='right'>".mysqli_num_rows($trel)."&nbsp;</td>";

								$total_total = mysqli_num_rows($trec)+mysqli_num_rows($trel);
								echo "<td align='right'>$total_total&nbsp;</td>";
								echo "</tr>";

							?>
						</tr>
					</table>
				<?php
				echo "<br>";
			}
		?>
		Total for <?php echo $_REQUEST['office'];?>
		<table border="1">
			<tr align="center" style="font-weight: bold;">
				<td width="280px;">Document Type</td>
				<td width="130px;">Received </td>
				<td width="130px;">Released </td>	
				<td width="130px;">Total Transactions </td>							
			</tr>
			<?php
			//total per dept
			$qry_doc = mysqli_query($connection,"select * from tbl_document_type where status='1' order by document_code asc");
			for($b=1;$b<=mysqli_num_rows($qry_doc);$b++){
				$doc = mysqli_fetch_assoc($qry_doc);
				echo "<tr>";
				echo "<td>&nbsp;$doc[document_code] - $doc[document_type]</td>";

				//received
				$rec = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b where a.barcode=b.barcode and a.status!='0' and a.document_type='$doc[document_code]' and b.status!='0' and b.office_code='$_REQUEST[office]' and b.recieve_date_time between '$date_from 00:00:00' and '$date_to 23:59:59'");
				
				echo "<td align='right'>".mysqli_num_rows($rec)."&nbsp;</td>";

				//release
				$rel = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b where a.barcode=b.barcode and a.status!='0' and b.rel_person!='' and a.document_type='$doc[document_code]' and b.status!='0' and b.office_code='$_REQUEST[office]' and b.release_date_time between '$date_from 00:00:00' and '$date_to 23:59:59'");
				
				echo "<td align='right'>".mysqli_num_rows($rel)."&nbsp;</td>";

				$total = mysqli_num_rows($rec)+mysqli_num_rows($rel);
				echo "<td align='right'>$total&nbsp;</td>";
				echo "</tr>";
			}
			?>
			<tr align="center" style="font-weight: bold;">
				<td align="right">Total&nbsp;&nbsp;</td>
				<?php
					//total received
					$ttrec = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b where a.barcode=b.barcode and a.status!='0'  and b.status!='0' and b.office_code='$_REQUEST[office]' and b.recieve_date_time between '$date_from 00:00:00' and '$date_to 23:59:59'");
					
					echo "<td align='right'>".mysqli_num_rows($ttrec)."&nbsp;</td>";

					//total release
					$ttrel = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b where a.barcode=b.barcode and a.status!='0' and b.rel_person!='' and b.status!='0' and b.office_code='$_REQUEST[office]' and b.release_date_time between '$date_from 00:00:00' and '$date_to 23:59:59'");
					
					echo "<td align='right'>".mysqli_num_rows($ttrel)."&nbsp;</td>";

					$total_total = mysqli_num_rows($ttrec)+mysqli_num_rows($ttrel);
					echo "<td align='right'>$total_total&nbsp;</td>";
					echo "</tr>";

				?>
			</tr>
		</table>

		<br>
		Generated By: <?php echo $_REQUEST['user']; ?>
		<br>
		Date: <?php echo date("M d, Y");?>

	</div>
</body>
</html>
<?php
}
else{
	?>
	<script type="text/javascript">
		window.close();
	</script>
	<?php
}
?>