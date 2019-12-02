<?php
//Modification
ini_set('session.name','s');
session_start();
include("../database/database_connection.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Document Tracking System</title>
	<!-- other css -->
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
	<script>
		$(document).ready(function(){
		    $('.too-long').popover();
		});
	</script>
	<link rel="icon" href="../images/dts.png" type="image/gif" sizes="16x16">
</head>
<body>
	<?php
		if(isset($_REQUEST['barcode'])){

			$barcode = mysqli_real_escape_string($connection,$_REQUEST['barcode']);

			$qry_show = mysqli_query($connection,"select *,date_format(recieve_date,'%M %d, %Y at %h:%i:%s %p')rdate,date_format(end_date,'%M %d, %Y')edate from tbl_document where barcode='$barcode'");
			$doc = mysqli_fetch_assoc($qry_show);

			if($doc['access_code']==$_REQUEST['acode']){
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

				<div class="view-document-container-two">
					<h3>DTS - City Government of Zamboanga</h3>
					<div class="view-document-details">
						<h4>Document Details</h4>
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
							

						</table>
					</div>
					<?php 	 
		$qry_user = mysqli_query($connection,"select * from tbl_users where username='$_SESSION[valid_dts_user]' and status='1'");
		$user = mysqli_fetch_assoc($qry_user);

		$qry_search_release = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$doc[barcode]' and (office_code='$user[office_code]' or route_office_code='$user[office_code]')");
		$rel = mysqli_fetch_assoc($qry_search_release);
							
		if($user['access_level']=="R" || mysqli_num_rows($qry_search_release)>0 || !$_SESSION['valid_dts_user']) { ?>
					
					<div class="view-document-details2">
						<table>
							<tr>
								<td width="50px"><b>Source:</b></td>
								<td width="345px"><?php echo $doc['source_name']." - ".$doc['gender'];?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><?php echo $ocode;?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><?php echo $doc['contact_no']; $doc['email_address']?></td>
							</tr>
							<tr>
								<td colspan="2" width="460px"><b>Subject Matter:</b></td>
							</tr>
							<tr>
								<td colspan="2" class="table-subject-prere">
								<?php 
								$len = strlen($doc['subject_matter']);
								if($len>=100){
		            				echo substr($doc['subject_matter'],0,100)."...";
									echo " <a href='#' class='too-long' title='Communication Summary' data-content='".substr($doc['subject_matter'],100,500)."' data-placement='bottom'><br>Read More</a>";  
		            			}
		            			else{
		            				echo $doc['subject_matter'];

		            			}
								//echo $doc['subject_matter'];?>
									
								</td>
							</tr>
						</table>
					</div>
					<div class="view-document-details3">
						<table>
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
									?>

									<td colspan='2'> - <a href="javascript:void(0)" onclick="location.href='<?php echo $attch['attachement_location']; ?>'; this.target='_blank';"><?php echo $attch['document_name'];
echo "(".$attch['date_uploaded'].")";
echo $attch['description'] != "" ? "<br><small>".$attch["description"]."</small>":"";
									?></a></td>
									<?php
									echo "</tr>";
								}
							}
							?>
						</table>
					</div>
						<?php } ?>
					<?php
					include("../functions/time_functions.php");
					?>
					<div class="view-document-tracking-2">
						<table border="1" width="1200px">
							<tr align="center" style="background-color: #295F8D; color: #fff; border: 1px solid  #fff; height: 30px;">
								<td colspan="4">RECEIVED</td>
								<td colspan="4">RELEASED</td>
								<td rowspan="2" width="80px">OFFICE<br>DURATION</td>
								<td rowspan="2" width="80px">TRANSIT<br>DURATION</td>
								<td rowspan="2" width="150px">REMARKS</td>
							</tr>
							<tr align="center"  style="background-color: #295F8D; color: #fff; border: 1px solid  #fff; font-size: 12px; height: 30px;">
								<td width="60px">Office</td>
								<td width="140px">By</td>
								<td width="100px">Date/Time</td>
								<td width="145px">Action</td>
								
								<td width="140px">By</td>
								<td width="100px">Date/Time</td>
								<td width="145px">Action</td>
								<td width="60px">Released To</td>

							</tr>
							<?php
							//yants
							//bug in sorting
							//$qry_transaction = mysqli_query($connection,"select *,date_format(recieve_date_time,'%b. %d, %Y')rdate,date_format(recieve_date_time,'%H:%i')rdate2,date_format(release_date_time,'%b. %d, %Y')rldate,date_format(release_date_time,'%H:%i')rldate2 from tbl_document_transaction where barcode='$doc[barcode]' order by sequence desc");

								$qry_transaction = mysqli_query($connection,"select *,date_format(recieve_date_time,'%b. %d, %Y')rdate,date_format(recieve_date_time,'%H:%i')rdate2,date_format(release_date_time,'%b. %d, %Y')rldate,date_format(release_date_time,'%H:%i')rldate2 from tbl_document_transaction where barcode='$doc[barcode]' order by recieve_date_time desc");
								$b = 0;
								for($a=1;$a<=mysqli_num_rows($qry_transaction);$a++){
									$track = mysqli_fetch_assoc($qry_transaction);
									$class_row = "row".($b++ & 1);
									echo "<tr class='$class_row' style='font-size:12px'>";
									echo "<td align='center'>$track[office_code]</td>";
									echo "<td align='center'>".ucwords($track['person'])."</td>";
									echo "<td align='center'>$track[rdate]<br>$track[rdate2]</td>";
									echo "<td>$track[recieve_action]</td>";
									
									
									echo "<td align='center'>".ucwords($track['rel_person'])."</td>";
									echo "<td align='center'>$track[rldate]<br>$track[rldate2]</td>";
									if($track['current_action']=="END"){
										echo "<td>End Transaction</td>";
									}
									else{
										echo "<td>$track[release_action]</td>";	
									}
									echo "<td align='center'>$track[route_office_code]</td>";
									echo "<td align='right'>".convert_time($track['office_time'])."&nbsp;</td>";
									echo "<td align='right'>".convert_time($track['transit_time'])."&nbsp;</td>";
									echo "<td>$track[remarks]</td>";
									echo "</tr>";
								}

								//create a function in time_functions.php for convertion of time
							?>
						</table>
					</div>
				</div>
			<?php
			}
			else{
				?>
				
				<script type="text/javascript">
					alert("Invalid Barcode and Access Code.");
					window.location = "external_tracking.php";
				</script> 
			
				<?php
			}
		}
		else{

		}
	?>
</body>
</html>