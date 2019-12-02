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
		$qry_show = mysqli_query($connection2,"select * from documents where reference_number='$_REQUEST[referenceno]'");
		$doc = mysqli_fetch_assoc($qry_show);

		$qry_attachment = mysqli_query($connection2,"select * from attachment where reference_number='$_REQUEST[referenceno]'");
		$ref = mysqli_fetch_assoc($qry_attachment);

		$qry_upload = mysqli_query($connection2,"select * from upload where reference_number='$_REQUEST[referenceno]'");
		$upload = mysqli_fetch_assoc($qry_upload);
		
	?>
	<div class="view-document-container">
		<div class="view-document-details-old">
			<h4>Document Transaction Details of <?php echo $_REQUEST['referenceno']?></h4>
			<table>
				<tr class="border_bottom">
					<td width="150px"><b>Transaction Type:</b></td>
					<td width="320px"><?php echo $doc['transaction_type']." - ".$doc['days']."days | ".$doc['end_date'];?></td>
				</tr>
				<tr class="border_bottom">
					<td><b>Document Type:</b></td>
					<td><?php echo $doc['document_type'];?></td>
				</tr>
				<tr class="border_bottom">
					<td><b>Source Type:</b></td>
					<td><?php echo $doc['source_type'];?></td>
				</tr>
				<tr class="border_bottom">
					<td><b>Source:</b></td>
					<td><?php echo $doc['source_name'];?></td>
				</tr>
				<tr class="border_bottom">
					<td><b>Subject Matter:</b></td>
					<td>
					<?php 
						$len = strlen($doc['subject_matter']);
            			if($len>=100){
            				echo substr($doc['subject_matter'],0,100).'...';
							echo " <a href='#' class='too-long' title='Subject Matter' data-content='$doc[subject_matter]' data-placement='bottom'><br>Read More</a>";  
            			}
            			else{
            				echo $doc['subject_matter'];
            			}
					?>
					</td>
				</tr>
				<tr class="border_bottom">
					<td><b>Admin Code:</b></td>
					<td><?php echo $doc['code'];?></td>
				</tr>
				<tr class="border_bottom">
					<td><b>Status:</b></td>
					<td><?php echo $doc['status'];?></td>
				</tr>
				<tr>
					<td><b>Prerequisite/s:</b></td>
					<td><?php echo $ref['linked_document'];?></td>
				</tr>
			</table>
		</div>
		<div class="view-document-details3-old">
			<h4>Attachment(s)</h4>
			<table>
				<tr>
					<td width="245px"><a href="<?php echo "../dts_uploads/".$upload['filename']; ?>" target="_blank"><?php echo $upload['filename'];?></a></td>
				</tr>
				
			</table>
		</div>
		
		<!-- select * from document_details where reference_number='V00041859' and status='1' order by details_id desc  -->
		<div class="view-document-tracking-old" style="margin-top: 10px;">
			<table border="1" width="1200px">
				<tr align="center" style="font-weight: bold; height: 30px; background-color: #fff;">
					<td>Recieving Person</td>
					<td>Location</td>
					<td>Action</td>
					<td>Route</td>
					<td>Remarks</td>
					<td>Date & Time</td>
					<td>Duration</td>
				</tr>
				<?php
				$qry_show_details = mysqli_query($connection2,"select * from document_details where reference_number='$_REQUEST[referenceno]' and status='1' order by details_id desc");
				for($a=1;$a<=mysqli_num_rows($qry_show_details);$a++){
					$result = mysqli_fetch_assoc($qry_show_details);
					echo "<tr align='center' style='background-color: #fff;'>";
					echo "<td>$result[receiving_person]</td>";
					echo "<td>$result[location]</td>";
					echo "<td>$result[action]</td>";
					echo "<td>$result[route_to]</td>";
					echo "<td>$result[remarks]</td>";
					echo "<td>$result[datetime]</td>";
					echo "<td>$result[duration]</td>";
					echo "</tr>";
				}
				?>
			</table>
		</div>
	</div>
	<br>
</body>
</html>