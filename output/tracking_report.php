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
	<title>&nbsp</title>
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
<body onload="window.print()">
	<?php
		include("../functions/time_functions.php");
		include('../functions/log_functions.php');
		logs($access['username'],"PRINT DOCUMENT $_REQUEST[barcode] DETAILS AND TRAIL.");

		$barcode = mysqli_real_escape_string($connection, $_REQUEST['barcode']);


		$qry_show = mysqli_query($connection,"select *,date_format(recieve_date,'%M %d, %Y')rdate,date_format(end_date,'%M %d, %Y')edate from tbl_document where barcode='$barcode'");
		$doc = mysqli_fetch_assoc($qry_show);

		if($doc['transaction_type']=='SIMP'){
			$ttype = "Simple";
		}
		else{
			$ttype = "Complex";
		}

		$qry_doc_type = mysqli_query($connection,"select * from tbl_document_type where document_code='$doc[document_type]'");
		$doc_type = mysqli_fetch_assoc($qry_doc_type);

		$qry_del_method = mysqli_query($connection,"select * from tbl_delivery_method where id='$doc[delivery_method]'");
		$del_method = mysqli_fetch_assoc($qry_del_method);

		if($doc['source_type']=='EXT'){
			$stype = "External";
		}
		else{
			$stype = "Internal";
		}

		if($doc['office_code']=="N/A"){
			$ocode = "N/A";
		}
		else{
			$qry_office = mysqli_query($connection,"select * from tbl_office where office_code='$doc[office_code]'");
			$qry = mysqli_fetch_assoc($qry_office);
			$ocode = $qry['office_name'];	
		}
	?>
	<div class="container-report-delin" style="border: 0px;">
		<table class="table-report">
			<tr>
				<td colspan="2" style="text-align: center;"><h4>DOCUMENT TRACKING SYSTEM REPORT</h4></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center;"><h4><?php echo $_REQUEST['barcode']; ?> Document Transaction Details</h4></td>
			</tr>
		</table>
		<div class="view-document-container">
			<div class="view-document-details" style="height: 260px;">
				<br>
				<table>
					<tr>
						<td width="150px"><b>Barcode:</b></td>
						<td width="245px"><?php echo $doc['barcode'];?></td>
					</tr>
					<tr>
						<td><b>Access Code:</b></td>
						<td><?php echo $doc['access_code'];?></td>
					</tr>
					<tr>
						<td><b>Date Start:</b></td>
						<td><?php echo $doc['rdate'];?></td>
					</tr>
					<tr>
						<td><b>Date End:</b></td>
						<td><?php echo $doc['edate'];?></td>
					</tr>
					<tr>
						<td><b>Transaction Type:</b></td>
						<td><?php echo $ttype; ?></td>
					</tr>
					<tr>
						<td><b>Document Type:</b></td>
						<td><?php echo $doc_type['document_type'];?></td>
					</tr>
					<tr>
						<td><b>Delivery Method:</b></td>
						<td><?php echo $del_method['method']?></td>
					</tr>
					<tr>
						<td><b>Source Type:</b></td>
						<td><?php echo $stype?></td>
					</tr>
					<tr>
						<td><b>Source:</b></td>
						<td><?php echo ucwords($doc['source_name'])." - ".$doc['gender'];?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><?php echo $doc['contact_no']." - ".$doc['email_address'];?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><?php echo $ocode;?></td>
					</tr>
				</table>
			</div>
			<div class="view-document-details" style="height: 260px;">
				<br>
				<table>	
					<tr>
						<td colspan="2" width="460px"><b>Subject Matter:</b></td>
					</tr>
					<tr>
						<td colspan="2" class="table-subject-prere">
							<?php
		            			echo $doc['subject_matter'];
							?>
						</td>
					</tr>
				</table>
			</div>
			<div class="view-document-details" style="width: 200px; height: 260px;">
				<br>
				<table>
					<tr>
						<td><b>Document/s Linked:</b></td>
					</tr>
					<tr>
						<td colspan="2" class="table-subject-prere">
							<?php
								if($doc['prerequisite']==""){
									echo "&nbsp;&nbsp;N/A";
								}
								else{
									//prerequisites
									$explode = explode(" ",$doc['prerequisite']);

									foreach($explode as $i =>$key) {
										$i>0;
									    //echo "<a href='home.php?menu=viewdocument&barcode=$key' target='_blank'>".$key."</a>&nbsp;&nbsp;";
									    echo $key."&nbsp;&nbsp;";

									}
								}
							?>
						</td>
					</tr>
					<tr>
						<td><b>Attachments:</b></td>
					</tr>
					<?php
					$show_attachement = mysqli_query($connection,"select * from tbl_document_attachments where barcode='$_REQUEST[barcode]' and status='1'");
					if(mysqli_num_rows($show_attachement)<=0){
						echo "<tr>";
						echo "<td>&nbsp;&nbsp;N/A</td>";
						echo "</tr>";
					}
					else{
						for($a=1;$a<=mysqli_num_rows($show_attachement);$a++){
							$attch = mysqli_fetch_assoc($show_attachement);
							echo "<tr>";
							//echo "<td colspan='2'> - <a href='$attch[attachement_location]' target='_blank'>$attch[document_name]</a></td>";
							echo "<td colspan='2'> - $attch[document_name]</td>";
							echo "</tr>";
						}
					}
					?>
				</table>
			</div>
		</div>
		
		
		<table border="1" width="1000px" style="padding-top: 10px;">
			<tr align="center" style="height: 30px;">
				<td colspan="4"><b>RECEIVE</b></td>
				<td colspan="4"><b>RELEASE</b></td>
				<td colspan="2"><b>DURATION</b></td>
				<td rowspan="2" width="150px"><b>REMARKS</b></td>
			</tr>
			<tr align="center" style="font-size: 12px; height: 30px;">
				<td width="60px"><b>Office</b></td>
				<td width="140px"><b>By</b></td>
				<td width="100px"><b>Date/Time</b></td>
				<td width="140px"><b>Action</b></td>
				<td width="60px"><b>Route To</b></td>
				<td width="140px"><b>By</b></td>
				<td width="100px"><b>Date/Time</b></td>
				<td width="140px"><b>Action</b></td>
				<td width="80px"><b>Office</b></td>
				<td width="80px"><b>Transit</b></td>

				
			</tr>
		
			<?php
				$qry_transaction = mysqli_query($connection,"select *,date_format(recieve_date_time,'%b. %d, %Y')rdate,date_format(recieve_date_time,'%I:%i %p')rdate2,date_format(release_date_time,'%b. %d, %Y')rldate,date_format(release_date_time,'%I:%i %p')rldate2 from tbl_document_transaction where barcode='$doc[barcode]' order by sequence desc");
				
				for($a=1;$a<=mysqli_num_rows($qry_transaction);$a++){
					$track = mysqli_fetch_assoc($qry_transaction);
					
					echo "<tr style='font-size:12px; height:30px;'>";
					echo "<td align='center'>$track[office_code]</td>";
					echo "<td align='center'>".ucwords($track['person'])."</td>";
					echo "<td align='center'>$track[rdate]<br>$track[rdate2]</td>";
					echo "<td align='center'>$track[recieve_action]</td>";
					echo "<td align='center'>$track[route_office_code]</td>";
					echo "<td align='center'>".ucwords($track['rel_person'])."</td>";
					echo "<td align='center'>$track[rldate]<br>$track[rldate2]</td>";
					if($track['current_action']=="END"){
						echo "<td align='center'>End Transaction</td>";
					}
					else{
						echo "<td align='center'>$track[release_action]</td>";	
					}
					
					echo "<td align='right'>".convert_time($track['office_time'])."&nbsp;</td>";
					echo "<td align='right'>".convert_time($track['transit_time'])."&nbsp;</td>";
					echo "<td> &nbsp;$track[remarks]</td>";
					
					
					echo "</tr>";
				}

				//create a function in time_functions.php for convertion of time
			?>
			
		</table>
		<table style="width: 1000px;">
			<tr align="center">
				<td>xxxxxxxxxxxxxxxxxxxxxxxxxxxx END OF FILE xxxxxxxxxxxxxxxxxxxxxxxxxxxx</td>
			</tr>
		</table>


		<br>
		Generated By: <?php echo $access['username']; ?>
		<br>
		Date: <?php echo date("M d, Y");?>

	</div>
</body>
</html>