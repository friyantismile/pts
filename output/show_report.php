<?php
if(isset($_REQUEST['reporttitle'])&&isset($_REQUEST['frommm'])){

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
	$tomorrow = date('Y-m-d',strtotime($date1 . "+1 day"));

	$tomorrow;


	$date_from = $_REQUEST['fromyyyy']."-".$_REQUEST['frommm']."-".$_REQUEST['fromdd'];
	//$date_to = $_REQUEST['toyyyy']."-".$_REQUEST['tomm']."-".($_REQUEST['todd']);
	$date_to = $tomorrow;

	//other settings
	$qry_wh = mysqli_query($connection,"select timestampdiff(minute,time_start,time_end)as working_minutes from tbl_working_hours");
	$wh = mysqli_fetch_assoc($qry_wh);

	//working hours in a day
	$qry_day = mysqli_query($connection,"select timestampdiff(minute,time_start,time_end)min from tbl_working_hours");
	$day = mysqli_fetch_assoc($qry_day);

	$qry_comp = mysqli_query($connection,"select days from tbl_transaction_type where id='COMP'");
	$complex = mysqli_fetch_assoc($qry_comp);

	$qry_simp = mysqli_query($connection,"select days from tbl_transaction_type where id='SIMP'");
	$simple = mysqli_fetch_assoc($qry_simp);

	$complex_minutes = $wh['working_minutes']*$complex['days'];
	$simple_minutes = $wh['working_minutes']*$simple['days'];

	//conditions
	if(isset($_REQUEST['transactiontype'])){
		if($_REQUEST['transactiontype']=="COMP"){
			$transtype = " and a.transaction_type='COMP' ";
		}
		else if($_REQUEST['transactiontype']=="SIMP"){
			$transtype = " and a.transaction_type='SIMP' ";
		}
		else if($_REQUEST['transactiontype']=="HIGH"){
			$transtype = " and a.transaction_type='HIGH' ";
		}

		else{
			$transtype = " ";
		}
	}
	else{
		$transtype = " ";
	}
	

	if(isset($_REQUEST['documenttype'])){
		if($_REQUEST['documenttype']=='COM'){
			$documenttype = " and a.document_type='COM' ";
		}
		else if($_REQUEST['documenttype']=='PR'){
			$documenttype = " and a.document_type='PR' ";
		}
		else if($_REQUEST['documenttype']=='PY'){
			$documenttype = " and a.document_type='PY' ";
		}
		else if($_REQUEST['documenttype']=='VC'){
			$documenttype = " and a.document_type='VC' ";
		}
		else if($_REQUEST['documenttype']=='PO'){
			$documenttype = " and a.document_type='PO' ";
		}
		else{
			$documenttype = " ";	
		}
	}
	else{
		$documenttype = " ";
	}

	if(isset($_REQUEST['sourcetype'])){
		if($_REQUEST['sourcetype']=="EXT"){
			$sourcetype = " and a.source_type='EXT' ";
		}
		else if($_REQUEST['sourcetype']=="INT"){
			$sourcetype = " and a.source_type='INT' ";
		}
		else{
			$sourcetype = " ";
		}
	}
	else{
		$sourcetype = " ";
	}

	if(isset($_REQUEST['deliverymethod'])){
		if($_REQUEST['deliverymethod']=="1"){
			$deliverymethod = " and a.delivery_method='1' ";
		}
		else if($_REQUEST['deliverymethod']=="2"){
			$deliverymethod = " and a.delivery_method='2' ";
		}
		else if($_REQUEST['deliverymethod']=="3"){
			$deliverymethod = " and a.delivery_method='3' ";
		}
		else if($_REQUEST['deliverymethod']=="4"){
			$deliverymethod = " and a.delivery_method='4' ";
		}
		else{
			$deliverymethod = " ";
		}
	}
	else{
		$deliverymethod = " ";
	}

	if(isset($_REQUEST['gender'])){
		if($_REQUEST['gender']=="Male"){
			$gender = " and a.gender='Male' ";
		}
		else if($_REQUEST['gender']=="Female"){
			$gender = " and a.gender='Female' ";
		}
		else{
			$gender = " ";
		}
	}
	else{
		$gender = " ";
	}

	if(isset($_REQUEST['docustatus'])){
		if($_REQUEST['docustatus']=="O"){
			$transtatus = " and a.transaction_status='O' ";
		}
		else if($_REQUEST['docustatus']=="D"){
			$transtatus = " and a.transaction_status='D' ";
		}
		else if($_REQUEST['docustatus']==""){
			$transtatus = " and a.transaction_status=''  ";
		}
		else{
			$transtatus = " ";
		}	
	}
	else{
		$transtatus = " ";
	}


	if(isset($_REQUEST['directto'])){
		if($_REQUEST['directto']=="1"){
			$directto = " and a.to_ocm='1' ";
		}
		else if($_REQUEST['gender']=="0"){
			$directto = " and a.to_ocm='0' ";
		}
		else{
			$directto = " ";
		}
	}
	else{
		$directto = " ";
	}

	if(isset($_REQUEST['recuser'])){
		if($_REQUEST['recuser']==""){
			$record_user = " ";
		}
		else{
			$record_user = " and a.username='$_REQUEST[recuser]' ";
		}
	}
	else{
		$record_user = " ";
	}
	//conditions
	//more conditions
	

	if(isset($_REQUEST['totalontime'])){
		$totalontime = " and transaction_status='O' ";
	}
	else{
		$totalontime = " ";
		
	}

	if(isset($_REQUEST['totalongoing'])){
		$totalongoing = " and transaction_status='' ";
	}
	else{
		$totalongoing = " ";
	}

	if(isset($_REQUEST['totaldelayed'])){
		$totaldelayed = " and transaction_status='D' ";
	}
	else{
		$totaldelayed = " ";
	}
	//more conditions

	?>
	<div class="container-report">
		<table class="table-report">
			<tr>
				<td colspan="2" style="text-align: center;"><h4>DOCUMENT TRACKING SYSTEM REPORT</h4></td>
			</tr>
			<tr>
				<td style="width:150px;">REPORT TYPE:</td>
				<td><?php echo $_REQUEST['reporttitle'];?></td>
			</tr>
			<tr>
				<td style="width:150px;">DATE RANGE:</td>
				<td><?php echo $date_from_display." to ".$date_to_display?></td>
			</tr>
			<tr>
				<td>NO. OF RESULTS:</td>
				<?php
				
				$qry_results = mysqli_query($connection,"select * from tbl_document a, tbl_transaction_type b where a.status!='0' $transtype $documenttype $sourcetype $deliverymethod $gender $transtatus $directto $record_user $totalontime $totalongoing $totaldelayed and a.transaction_type=b.id and a.recieve_date between '$date_from' and '$date_to'");

				?>
				<td><?php echo mysqli_num_rows($qry_results);?></td>
			</tr>
		</table>
		<br>
		<table class="table-report" border="1">
			<tr align="center" style="font-weight: bold;">
				<?php
				if(isset($_REQUEST['recievedate'])){
					echo "<td width='75px'>DATE</td>";
				}
				if(isset($_REQUEST['barcde'])){
					echo "<td width='75px'>BARCODE</td>";
				}
				if(isset($_REQUEST['doctype'])){
					echo "<td width='50px'>DOCUMENT TYPE</td>";
				}
				if(isset($_REQUEST['sortype'])){
					echo "<td width='50px'>SOURCE TYPE</td>";
				}
				if(isset($_REQUEST['offsource'])){
					echo "<td width='100px'>SOURCE</td>";
				}
				if(isset($_REQUEST['gen'])){
					echo "<td width='50px'>GENDER</td>";
				}
				if(isset($_REQUEST['contno'])){
					echo "<td width='75px'>CONTACT NUMBER</td>";
				}
				if(isset($_REQUEST['eadd'])){
					echo "<td width='75px'>EMAIL ADDRESS</td>";
				}
				if(isset($_REQUEST['submatter'])){
					echo "<td width='100px'>SUBJECT MATTER</td>";
				}
				if(isset($_REQUEST['totaltime'])){	
					echo "<td width='75px'>TOTAL TIME</td>";
				}
				if(isset($_REQUEST['dashboard'])){
					echo "<td width='75px'>DATE</td>";
					echo "<td width='75px'>BARCODE</td>";
					echo "<td width='50px'>DOCUMENT TYPE</td>";
					echo "<td width='50px'>SOURCE TYPE</td>";
					echo "<td width='100px'>SOURCE</td>";
					echo "<td width='50px'>GENDER</td>";
					echo "<td width='75px'>CONTACT NUMBER</td>";
					echo "<td width='75px'>EMAIL ADDRESS</td>";
					echo "<td width='100px'>SUBJECT MATTER</td>";
					echo "<td width='75px'>TOTAL TIME</td>";
				}
				?>
			</tr>
		<?php
	
		
		$qry = mysqli_query($connection,"select *,date_format(recieve_date,'%b. %d, %Y')rdate,(((total_office_time+total_transit_time)/60)/9)tdaysold,timestampdiff(day,recieve_date,transaction_end_date)tdays from tbl_document a, tbl_transaction_type b where a.status!='0' $transtype $documenttype $sourcetype $deliverymethod $gender $transtatus $directto $record_user $totalontime $totalongoing $totaldelayed and a.transaction_type=b.id and recieve_date between '$date_from' and '$date_to' ");

		for($a=1;$a<=mysqli_num_rows($qry);$a++){
			$rows = mysqli_fetch_assoc($qry);
			echo "<tr style='font-size:10px;'>";
			if(isset($_REQUEST['recievedate'])){
				echo "<td align='center'>$rows[rdate]</td>";
			}
			if(isset($_REQUEST['barcde'])){
				echo "<td align='center'><a href='../forms/tracking_result.php?barcode=$rows[barcode]&acode=$rows[access_code]' target='_blank'>$rows[barcode]</a></td>";
			}
			if(isset($_REQUEST['doctype'])){
				echo "<td align='center'>$rows[document_type]</td>";
			}
			if(isset($_REQUEST['sortype'])){
				echo "<td align='center'>$rows[source_type]</td>";
			}
			if(isset($_REQUEST['offsource'])){
				if($rows['source_type']=="INT"){
					echo "<td align='center'>$rows[office_code]</td>";
				}
				else{
					echo "<td>&nbsp;".ucwords($rows['source_name'])."</td>";
				}
			}
			if(isset($_REQUEST['gen'])){
				echo "<td align='center'>$rows[gender]</td>";
			}
			if(isset($_REQUEST['contno'])){
				echo "<td>&nbsp;$rows[contact_no]</td>";
			}
			if(isset($_REQUEST['eadd'])){
				echo "<td>&nbsp;$rows[email_address]</td>";
			}
			if(isset($_REQUEST['submatter'])){
				echo "<td style='padding:5px;'>$rows[subject_matter]</td>";
			}
			if(isset($_REQUEST['totaltime'])){	
				echo "<td align='right'>".number_format($rows['tdays'],2)." days &nbsp;</td>";
			}


			if(isset($_REQUEST['dashboard'])){
				echo "<td align='center'>$rows[rdate]</td>";
				echo "<td align='center'><a href='../forms/tracking_result.php?barcode=$rows[barcode]&acode=$rows[access_code]' target='_blank'>$rows[barcode]</a></td>";
				echo "<td align='center'>$rows[document_type]</td>";
				echo "<td align='center'>$rows[source_type]</td>";
				if($rows['source_type']=="INT"){
					echo "<td align='center'>$rows[office_code]</td>";
				}
				else{
					echo "<td>&nbsp;".ucwords($rows['source_name'])."</td>";
				}
				echo "<td align='center'>$rows[gender]</td>";
				echo "<td>&nbsp;$rows[contact_no]</td>";
				echo "<td>&nbsp;$rows[email_address]</td>";
				echo "<td style='padding:5px;'>$rows[subject_matter]</td>";

				$qry_days = mysqli_query($connection,"select (sum(office_time+transit_time)*0.000694)days from tbl_document_transaction where barcode='$rows[barcode]'");
				$data_days = mysqli_fetch_assoc($qry_days);
				echo "<td align='right'>".number_format($data_days['days'],2)." days &nbsp;</td>";
			}
			echo "</tr>";
		}
		?>
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