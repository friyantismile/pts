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
		$qry_show = mysqli_query($connection2,"select * from tbl_doc where doc_ref='$_REQUEST[referenceno]'");
		$doc = mysqli_fetch_assoc($qry_show);

		//$qry_attachment = mysqli_query($connection2,"select * from attachment where reference_number='$_REQUEST[referenceno]'");
		//$ref = mysqli_fetch_assoc($qry_attachment);

		//$qry_upload = mysqli_query($connection2,"select * from upload where reference_number='$_REQUEST[referenceno]'");
		//$upload = mysqli_fetch_assoc($qry_upload);
		
	?>
	<div class="view-document-container">
		<div class="view-document-details-old-old">
			<h4>Document Information of <?php echo $_REQUEST['referenceno'];?></h4>
			<table>
				<tr class="border_bottom">
					<td width="150px"><b>Entered By :</b></td>
					<td width="320px"><?php echo $doc['enter_doc'];?></td>
				</tr>
				<tr class="border_bottom">
					<td><b>Source :</b></td>
					<td><?php echo $doc['source_doc'];?></td>
				</tr>
				<tr class="border_bottom">
					<td><b>Subject Matter :</b></td>
					<td>
						<?php 
							$len = strlen($doc['subject_doc']);
	            			if($len>=100){
	            				echo substr($doc['subject_doc'],0,100).'...';
								echo " <a href='#' class='too-long' title='Subject Matter' data-content='$doc[subject_doc]' data-placement='bottom'><br>Read More</a>";  
	            			}
	            			else{
	            				echo $doc['subject_doc'];
	            			}
						?>
					</td>

				</tr>
				<tr class="border_bottom">
					<td><b>Document Type :</b></td>
					<td><?php echo $doc['type_doc'];?></td>
				</tr>
				<tr class="border_bottom">
					<td><b>Delivery Method :</b></td>
					<td><?php echo $doc['method_doc'];?></td>
				</tr>
				<tr>
					<td><b>Attachment :</b></td>
					<td>
					<?php 
						if($doc['file']==" " || $doc['file']=="."){
							echo "No Attachement/s";
						}
						else{
							echo "<a href='../dts_uploads/old/$doc[file]' target='_blank'>$doc[file]</a>";
						}

					?>
						
					</td>
				</tr>
			</table>
		</div>
		
		<div class="view-document-details3-old-old">
			<!--<h4>Attachement(s)</h4>-->
			<table>
				<tr>
					<td width="245px"><a href="" target="_blank"><?php //echo $upload['filename'];?></a></td>
				</tr>
				
			</table>
		</div>
		
		<!-- select * from document_details where reference_number='V00041859' and status='1' order by details_id desc  -->
		<div class="view-document-tracking-old" style="margin-top: 10px;">
			<table border="1" width="1200px">
				<tr align="center" style="font-weight: bold; height: 30px; background-color: #fff;">
					<td>Date</td>
					<td>Time</td>
					<td>Receiving Person</td>
					<td>Action</td>
					<td>Location</td>
					<td>Route</td>
					<td>Remarks/Notation</td>
				</tr>
				<?php
				
				$qry_show_details = mysqli_query($connection2,"select * from tbl_trans where trans_ref='$doc[id_doc]' order by id_trans desc");
				for($a=1;$a<=mysqli_num_rows($qry_show_details);$a++){
					$result = mysqli_fetch_assoc($qry_show_details);
					echo "<tr align='center' style='background-color: #fff;'>";
					echo "<td>$result[date_trans]</td>";
					echo "<td>$result[time_trans]</td>";
					echo "<td>$result[receive_trans]</td>";
					echo "<td>$result[action_trans]</td>";
					echo "<td>$result[location_trans]</td>";
					echo "<td>$result[route_trans]</td>";
					echo "<td>$result[remark_trans]</td>";
					echo "</tr>";
				}
				
				?>
			</table>
		</div>
	</div>
	<br>
</body>
</html>