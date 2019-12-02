<?php
	include("../database/database_connection.php");
  	include_once('../functions/login_functions.php');
 	verify_valid_system_user();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script>
		$(document).ready(function(){
		    $('.too-long').popover();
		});
	</script>
</head>
<body>

	<?php

$qrydoc = mysqli_query($connection,"select * from tbl_document where barcode='$_REQUEST[barcode]'");
if(mysqli_num_rows($qrydoc) <= 0) {
	echo "<h1 style='text-align:center;color:red;'>No Record Found!</h1>";
	exit;
	//check el document
}
	
		logs($access['username'],"VIEW DOCUMENT $_REQUEST[barcode] DETAILS AND TRAIL.");

		$qry_show = mysqli_query($connection,"select *,date_format(recieve_date,'%M %d, %Y at %h:%i:%s %p')rdate,date_format(end_date,'%M %d, %Y')edate from tbl_document where barcode='$_REQUEST[barcode]'");
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
	<div class="view-document-container">
		<div class="view-document-details"  style="height:230px;">
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
				<tr>
					<td><b>Classification:</b></td>
					<td><?php echo $doc['is_permanent'] == 0 ? 'N/A':'Permanent';?></td>
				</tr>

			</table>
		</div>

		<?php 	 
		$qry_user = mysqli_query($connection,"select * from tbl_users where username='$_SESSION[valid_dts_user]' and status='1'");
		$user = mysqli_fetch_assoc($qry_user);

		$qry_search_release = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$doc[barcode]' and (office_code='$user[office_code]' or route_office_code='$user[office_code]')");
		$rel = mysqli_fetch_assoc($qry_search_release);
						
		if($user['access_level']=="R" || $user['access_level']=="A" || mysqli_num_rows($qry_search_release)>0 || !$_SESSION['valid_dts_user']) { ?>

		<div class="view-document-details2" style="padding-top:10px;height:230px;">
			<table>
				<tr>
					<td style="width:150px;"><b>Transmitted to:</b></td>
					<td width="345px">
					<?php 
						if($doc['to_ocm']=='0') {
							echo "City Administrator";
							echo $doc['is_approved'] ? '(Approved)':'';
						} else if($doc['to_ocm']=='1') {
							echo "City Mayor";
							echo $doc['is_approved'] ? '(Approved)':'';
						} else {
							echo "N/A";
						}
					?>
					</td>
				</tr>

			
					<td width="50px"><b>Source:</b></td>
					<td width="345px"><?php echo ucwords($doc['source_name'])." - ".$doc['gender'];?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><?php echo $doc['contact_no']." - ".$doc['email_address'];?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><?php echo $ocode;?></td>
				</tr>
<!--
Modification
Modified by : Yants
Modified date : 04/30/2019
Description :subject matter changed to Communication summary
New code - 1
-->
				<tr>
			 
					<td colspan="2" width="460px"><b>Subject Matter:</b></td>
				</tr>
				<tr>
					<td colspan="2" class="table-subject-prere">
						<?php
						$documentsubjectmatters = mysqli_query($connection,"select * from tbl_document_subject_matter as dsm left join tbl_subject_matter as sm on sm.id=dsm.subject_matter_id where dsm.document_id='$doc[id]'");
						?>
						<ul>
						<?php 
						for($a=1;$a<=mysqli_num_rows($documentsubjectmatters);$a++){
								$trans = mysqli_fetch_assoc($documentsubjectmatters);
								echo "<li>$trans[code] - $trans[subject_matter]</li>";
						}
						?>
						</ul>
					</td>

				</tr>
				<!--end new code - 1 -->
				<tr>
					<td colspan="2" width="460px"><b>Communication Summary:</b></td>
				</tr>
				<tr>
					<td colspan="2" class="table-subject-prere">
						<?php
							$len = strlen($doc['subject_matter']);
	            			if($len>=100){
	            				echo substr($doc['subject_matter'],0,100)."...";
								echo " <a href='#' class='too-long' title='Subject Matter' data-content='".substr($doc['subject_matter'],100,1000)."' data-placement='bottom'><br>Read More</a>";  
	            			}
	            			else{
	            				echo $doc['subject_matter'];

	            			}
						?>
					</td>

				</tr>
				
			</table>
		</div>

		<div class="view-document-details">
			<div style="width: 370px; height: 40px; padding: 15px; text-align: right;">
				<a href="../output/tracking_report.php?barcode=<?php echo $doc['barcode'];?>"><img src="../images/print.png"></a>
			</div>
			<table>
				<tr>
					<td><b>Parent Document/s Linked:</b></td>
				</tr>
				<tr>
					<td colspan="2" class="table-subject-prere">
						<?php
						$qry_prereq_parent = mysqli_query($connection,"select * from tbl_document where prerequisite like '%$doc[barcode]%' and status=1");
						if(mysqli_num_rows($qry_prereq_parent ) > 0) {	
							while ($pp = mysqli_fetch_assoc($qry_prereq_parent)){
								    echo "<a href='home.php?menu=viewdocument&barcode=$pp[barcode]' target='_blank'>".$pp['barcode']."</a>&nbsp;&nbsp;";

								}
							} else {

								echo "N/A";
							}
						?>
					</td>
				</tr>
				<tr>
					<td><b>Child Document/s Linked:</b></td>
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
								    echo "<a href='home.php?menu=viewdocument&barcode=$key' target='_blank'>".$key."</a>&nbsp;&nbsp;";

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
						//echo "<td colspan='2'> - <a href='$attch[attachement_location]' target='_blank'>$attch[barcode]</a></td>";
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
		<div class="view-document-tracking">
			<table border="1" width="1200px">
				<tr align="center" style="background-color: #295F8D; color: #fff; border: 1px solid  #fff; height: 30px;">
					<td colspan="4">RECEIVED</td>
					<td colspan="4">RELEASED</td>
					<td colspan="2">DURATION</td>
					<td rowspan="2" width="150px">REMARKS</td>
					<?php
					if($access['office_code']=='REC' || $access['access_level']=='A'){
						echo "<td width='30px' rowspan='2'></td>";	
					}
					?>
				</tr>
				<tr align="center" style="background-color:	#295F8D; color: #fff; border: 1px solid  #fff; font-size: 12px; height: 30px;">
					<td width="60px">Office</td>
					<td width="140px">By</td>
					<td width="100px">Date/Time</td>
					<td width="145px">Action</td>
					
					<td width="140px">By</td>
					<td width="100px">Date/Time</td>
					<td width="145px">Action</td>
					<td width="60px">Released To</td>
					<td width="80px">Office</td>
					<td width="80px">Transit</td>	
				</tr>
			
				<?php
						//yants
						//bug in sorting
				//$qry_transaction = mysqli_query($connection,"select *,date_format(recieve_date_time,'%b. %d, %Y')rdate,date_format(recieve_date_time,'%I:%i %p')rdate2,date_format(release_date_time,'%b. %d, %Y')rldate,date_format(release_date_time,'%I:%i %p')rldate2 from tbl_document_transaction where barcode='$doc[barcode]' order by sequence desc");

					$qry_transaction = mysqli_query($connection,"select *,date_format(recieve_date_time,'%b. %d, %Y')rdate,date_format(recieve_date_time,'%I:%i %p')rdate2,date_format(release_date_time,'%b. %d, %Y')rldate,date_format(release_date_time,'%I:%i %p')rldate2 from tbl_document_transaction where barcode='$doc[barcode]' order by trans_id desc");
					$b = 0;
					for($a=1;$a<=mysqli_num_rows($qry_transaction);$a++){
						$track = mysqli_fetch_assoc($qry_transaction);
						$class_row = "row".($b++ & 1);
						echo "<tr class='$class_row' style='font-size:12px; height:30px;'>";
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
						
						if($access['office_code']=='REC' || $access['access_level']=='A'){
							echo "<td align='center'><a href='home.php?menu=edittransaction&transid=$track[trans_id]'><img src='../images/edit.png' class='action-btn-tiny' title='Edit Action and Remarks'></a></td>";
						}

						echo "</tr>";
					}

					//create a function in time_functions.php for convertion of time
				?>
			</table>
		</div>
	</div>
	<br>
</body>
</html>