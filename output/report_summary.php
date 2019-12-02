<?php
if(isset($_REQUEST['frommm'])&&isset($_REQUEST['tomm'])){
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
	<div class="container-report-summary">
		<table class="table-report" style="width: 1500px;">
			<tr>
				<td colspan="2" style="text-align: center;"><h4>DOCUMENT TRACKING SYSTEM REPORT</h4></td>
			</tr>
			<tr>
				<td style="width:150px;">REPORT TYPE:</td>
				<td>Summary</td>
			</tr>
			<tr>
				<td style="width:150px;">DATE RANGE:</td>
				<td><?php echo $date_from_display." to ".$date_to_display?></td>
			</tr>
		</table>
		<br>
		<table class="table-report" style="width: 1300px;" border="1">
			<tr align="center" style="font-weight: bold;">
				<td rowspan="2" style="width: 300px;">Document Type</td>
				<td colspan="4">Simple</td>
				<td colspan="4">Complex</td>
				<td colspan="4">Highly Technical</td>
			</tr>
			<tr align="center" style="font-weight: bold;">
				<td width="100px;">On-Time</td>
				<td width="100px;">On-Going</td>
				<td width="100px;">Delayed</td>
				<td width="100px;">Total</td>
				<td width="100px;">On-Time</td>
				<td width="100px;">On-Going</td>
				<td width="100px;">Delayed</td>
				<td width="100px;">Total</td>
				<td width="100px;">On-Time</td>
				<td width="100px;">On-Going</td>
				<td width="100px;">Delayed</td>
				<td width="100px;">Total</td>
			</tr>
			<?php
			$qry_doc_type = mysqli_query($connection,"select * from tbl_document_type order by document_code asc");
			for($a=1;$a<=mysqli_num_rows($qry_doc_type);$a++){
				$data = mysqli_fetch_assoc($qry_doc_type);
				echo "<tr style='text-align: right;'>";
				echo "<td style='text-align: left;'>&nbsp;<b>$data[document_type]</b></td>";

				$total_ontime_simp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='O' and transaction_type='SIMP' and status!='0' and recieve_date between '$date_from' and '$date_to' and document_type='$data[document_code]'");
				$ontime_simp = mysqli_fetch_assoc($total_ontime_simp);
				echo "<td>".number_format($ontime_simp['result'])."&nbsp;</td>";

				$total_ongoing_simp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='' and transaction_type='SIMP' and status!='0' and recieve_date between '$date_from' and '$date_to' and document_type='$data[document_code]'");
				$ongoing_simp = mysqli_fetch_assoc($total_ongoing_simp);
				echo "<td>".number_format($ongoing_simp['result'])."&nbsp;</td>";

				$total_delayed_simp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='D' and transaction_type='SIMP' and status!='0' and recieve_date between '$date_from' and '$date_to' and document_type='$data[document_code]'");
				$delayed_simp = mysqli_fetch_assoc($total_delayed_simp);
				echo "<td>".number_format($delayed_simp['result'])."&nbsp;</td>";

				$total_simp = $ontime_simp['result']+$ongoing_simp['result']+$delayed_simp['result'];
				echo "<td>".number_format($total_simp)."&nbsp;</td>";

				//------------------------------------------------------------------------

				$total_ontime_comp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='O' and transaction_type='COMP' and status!='0' and recieve_date between '$date_from' and '$date_to' and document_type='$data[document_code]'");
				$ontime_comp = mysqli_fetch_assoc($total_ontime_comp);
				echo "<td>".number_format($ontime_comp['result'])."&nbsp;</td>";

				$total_ongoing_comp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='' and transaction_type='COMP' and status!='0' and recieve_date between '$date_from' and '$date_to' and document_type='$data[document_code]'");
				$ongoing_comp = mysqli_fetch_assoc($total_ongoing_comp);
				echo "<td>".number_format($ongoing_comp['result'])."&nbsp;</td>";

				$total_delayed_comp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='D' and transaction_type='COMP' and status!='0' and recieve_date between '$date_from' and '$date_to' and document_type='$data[document_code]'");
				$delayed_comp = mysqli_fetch_assoc($total_delayed_comp);
				echo "<td>".number_format($delayed_comp['result'])."&nbsp;</td>";

				$total_comp = $ontime_comp['result']+$ongoing_comp['result']+$delayed_comp['result'];
				echo "<td>".number_format($total_comp)."&nbsp;</td>";

				//-----------------------------------------------------------------------

				$total_ontime_high = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='O' and transaction_type='HIGH' and status!='0' and recieve_date between '$date_from' and '$date_to' and document_type='$data[document_code]'");
				$ontime_high = mysqli_fetch_assoc($total_ontime_high);
				echo "<td>".number_format($ontime_high['result'])."&nbsp;</td>";

				$total_ongoing_high = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='' and transaction_type='HIGH' and status!='0' and recieve_date between '$date_from' and '$date_to' and document_type='$data[document_code]'");
				$ongoing_high = mysqli_fetch_assoc($total_ongoing_high);
				echo "<td>".number_format($ongoing_high['result'])."&nbsp;</td>";

				$total_delayed_high = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='D' and transaction_type='HIGH' and status!='0' and recieve_date between '$date_from' and '$date_to' and document_type='$data[document_code]'");
				$delayed_high = mysqli_fetch_assoc($total_delayed_high);
				echo "<td>".number_format($delayed_high['result'])."&nbsp;</td>";

				$total_high = $ontime_high['result']+$ongoing_high['result']+$delayed_high['result'];
				echo "<td>".number_format($total_high)."&nbsp;</td>";


				echo "</tr>";
			}
			?>
			<tr style="text-align: right; font-weight: bold;">
				<td>Total&nbsp;</td>
				<?php
					$total_ontime_simp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='O' and transaction_type='SIMP' and status!='0' and recieve_date between '$date_from' and '$date_to'");
					$ontime_simp = mysqli_fetch_assoc($total_ontime_simp);
					echo "<td>".number_format($ontime_simp['result'])."&nbsp;</td>";

					$total_ongoing_simp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='' and transaction_type='SIMP' and status!='0' and recieve_date between '$date_from' and '$date_to'");
					$ongoing_simp = mysqli_fetch_assoc($total_ongoing_simp);
					echo "<td>".number_format($ongoing_simp['result'])."&nbsp;</td>";

					$total_delayed_simp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='D' and transaction_type='SIMP' and status!='0' and recieve_date between '$date_from' and '$date_to'");
					$delayed_simp = mysqli_fetch_assoc($total_delayed_simp);
					echo "<td>".number_format($delayed_simp['result'])."&nbsp;</td>";

					$total_simp = $ontime_simp['result']+$ongoing_simp['result']+$delayed_simp['result'];
					echo "<td>".number_format($total_simp)."&nbsp;</td>";

					//------------------------------------------------------------------------

					$total_ontime_comp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='O' and transaction_type='COMP' and status!='0' and recieve_date between '$date_from' and '$date_to'");
					$ontime_comp = mysqli_fetch_assoc($total_ontime_comp);
					echo "<td>".number_format($ontime_comp['result'])."&nbsp;</td>";

					$total_ongoing_comp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='' and transaction_type='COMP' and status!='0' and recieve_date between '$date_from' and '$date_to'");
					$ongoing_comp = mysqli_fetch_assoc($total_ongoing_comp);
					echo "<td>".number_format($ongoing_comp['result'])."&nbsp;</td>";

					$total_delayed_comp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='D' and transaction_type='COMP' and status!='0' and recieve_date between '$date_from' and '$date_to'");
					$delayed_comp = mysqli_fetch_assoc($total_delayed_comp);
					echo "<td>".number_format($delayed_comp['result'])."&nbsp;</td>";

					$total_comp = $ontime_comp['result']+$ongoing_comp['result']+$delayed_comp['result'];
					echo "<td>".number_format($total_comp)."&nbsp;</td>";

					//-----------------------------------------------------------------------

					$total_ontime_high = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='O' and transaction_type='HIGH' and status!='0' and recieve_date between '$date_from' and '$date_to'");
					$ontime_high = mysqli_fetch_assoc($total_ontime_high);
					echo "<td>".number_format($ontime_high['result'])."&nbsp;</td>";

					$total_ongoing_high = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='' and transaction_type='HIGH' and status!='0' and recieve_date between '$date_from' and '$date_to'");
					$ongoing_high = mysqli_fetch_assoc($total_ongoing_high);
					echo "<td>".number_format($ongoing_high['result'])."&nbsp;</td>";

					$total_delayed_high = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='D' and transaction_type='HIGH' and status!='0' and recieve_date between '$date_from' and '$date_to'");
					$delayed_high = mysqli_fetch_assoc($total_delayed_high);
					echo "<td>".number_format($delayed_high['result'])."&nbsp;</td>";

					$total_high = $ontime_high['result']+$ongoing_high['result']+$delayed_high['result'];
					echo "<td>".number_format($total_high)."&nbsp;</td>";

				?>
			</tr>
		</table>
		<br>
		<table class="table-report" style="width: 550px;" border="1">
			<tr align="center" style="font-weight: bold;">
				<td rowspan="2" style="width: 260px;">Document Type</td>
				<td colspan="2">Source Type</td>
				<td rowspan="2" style="width: 100px;">Total</td>
			</tr>
			<tr align="center" style="font-weight: bold;">
				<td style="width: 100px;">Internal</td>
				<td style="width: 100px;">External</td>
				
			</tr>
			<?php
				$qry_doc_type = mysqli_query($connection,"select * from tbl_document_type order by document_code asc");
				for($a=1;$a<=mysqli_num_rows($qry_doc_type);$a++){
					$data = mysqli_fetch_assoc($qry_doc_type);
					echo "<tr style='text-align: right;'>";
					echo "<td style='text-align: left;'>&nbsp;<b>$data[document_type]</b></td>";

					$total_int = mysqli_query($connection,"select count(id)result from tbl_document where status!='0' and recieve_date between '$date_from' and '$date_to' and document_type='$data[document_code]' and source_type='INT'");
					$total_int = mysqli_fetch_assoc($total_int);
					echo "<td>".number_format($total_int['result'])."&nbsp;</td>";

					$total_ext = mysqli_query($connection,"select count(id)result from tbl_document where status!='0' and recieve_date between '$date_from' and '$date_to' and document_type='$data[document_code]' and source_type='EXT'");
					$total_ext = mysqli_fetch_assoc($total_ext);
					echo "<td>".number_format($total_ext['result'])."&nbsp;</td>";

					$total_ie = mysqli_query($connection,"select count(id)result from tbl_document where status!='0' and recieve_date between '$date_from' and '$date_to' and document_type='$data[document_code]'");
					$total_ie = mysqli_fetch_assoc($total_ie);
					echo "<td>".number_format($total_ie['result'])."&nbsp;</td>";

					echo "</tr>";
				}
			?>
			<tr style="text-align: right; font-weight: bold;">
				<td>Total&nbsp;</td>
				<?php

					$total_int = mysqli_query($connection,"select count(id)result from tbl_document where status!='0' and recieve_date between '$date_from' and '$date_to' and source_type='INT'");
					$total_int = mysqli_fetch_assoc($total_int);
					echo "<td>".number_format($total_int['result'])."&nbsp;</td>";

					$total_ext = mysqli_query($connection,"select count(id)result from tbl_document where status!='0' and recieve_date between '$date_from' and '$date_to' and source_type='EXT'");
					$total_ext = mysqli_fetch_assoc($total_ext);
					echo "<td>".number_format($total_ext['result'])."&nbsp;</td>";

					$total_ie = mysqli_query($connection,"select count(id)result from tbl_document where status!='0' and recieve_date between '$date_from' and '$date_to'");
					$total_ie = mysqli_fetch_assoc($total_ie);
					echo "<td>".number_format($total_ie['result'])."&nbsp;</td>";

				?>
			</tr>
		</table>
		<br>
		<table class="table-report" style="width: 550px;" border="1">
			<tr align="center" style="font-weight: bold;">
				<td style="width: 260px;">Document Type</td>
				<td style="width: 100px;">Simple</td>
				<td style="width: 100px;">Complex</td>
				<td style="width: 100px;">Highly Technical</td>

			</tr>
			<?php
			$qry_doc_type = mysqli_query($connection,"select * from tbl_document_type order by document_code asc");
			for($a=1;$a<=mysqli_num_rows($qry_doc_type);$a++){
				$data = mysqli_fetch_assoc($qry_doc_type);
				echo "<tr style='text-align: right;'>";
				echo "<td style='text-align: left;'>&nbsp;<b>$data[document_type]</b></td>";

				$qry_simp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date between '$date_from' and '$date_to' and transaction_status!='' and document_type='$data[document_code]' and transaction_type='SIMP'");
				$qry_simp = mysqli_fetch_assoc($qry_simp);

				echo "<td>".number_format($qry_simp['result'],2)." days&nbsp;</td>";

				$qry_comp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date between '$date_from' and '$date_to' and transaction_status!='' and document_type='$data[document_code]' and transaction_type='COMP'");
				$qry_comp = mysqli_fetch_assoc($qry_comp);

				echo "<td>".number_format($qry_comp['result'],2)." days&nbsp;</td>";

				$qry_high = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date between '$date_from' and '$date_to' and transaction_status!='' and document_type='$data[document_code]' and transaction_type='HIGH'");
				$qry_high = mysqli_fetch_assoc($qry_high);

				echo "<td>".number_format($qry_high['result'],2)." days&nbsp;</td>";
			}
			?>
		</table>

		<br>
		<table class="table-report" style="width: 300px;" border="1">
			<tr align="center" style="font-weight: bold;">
				<td>Sex</td>
				<td>Total</td>
			</tr>
			<tr>
				<td>&nbsp;<b>Male</b></td>
				<?php
					$qry_male = mysqli_query($connection,"select count(id)result from tbl_document where status!='0' and recieve_date between '$date_from' and '$date_to' and gender='Male'");
					$qry_male = mysqli_fetch_assoc($qry_male);

					echo "<td style='text-align: right;'>".number_format($qry_male['result'])."&nbsp;</td>";
				?>
				
			</tr>
			<tr>
				<td>&nbsp;<b>Female</b></td>
				<?php
					$qry_female = mysqli_query($connection,"select count(id)result from tbl_document where status!='0' and recieve_date between '$date_from' and '$date_to' and gender='Female'");
					$qry_female = mysqli_fetch_assoc($qry_female);

					echo "<td style='text-align: right;'>".number_format($qry_female['result'])."&nbsp;</td>";
				?>
			</tr>
			<tr style="font-weight: bold;">
				<td style="text-align: right;">Total&nbsp;</td>
				<?php
					$qry_sex = mysqli_query($connection,"select count(id)result from tbl_document where status!='0' and recieve_date between '$date_from' and '$date_to'");
					$qry_sex = mysqli_fetch_assoc($qry_sex);

					echo "<td style='text-align: right;'>".number_format($qry_sex['result'])."&nbsp;</td>";
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