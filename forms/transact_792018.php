<?php
include("../database/database_connection.php");
include_once('../functions/login_functions.php');
verify_valid_system_user();

//if($access['access_level']=="U"){
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<script type="text/javascript">

	function selectall(){
		
		all = document.getElementById("selectalloffices");

		if(all.checked){	
			for(var i=1; i<=70; i++){
				box = document.getElementById("routeoffice"+[i]).checked = true;
			}
		}
		else{
			for(var x=1; x<=70; x++){
				box = document.getElementById("routeoffice"+[x]).checked = false;
			}	
		}

	}

</script>
<body>
	<div class="transact-container">
		<!--
		<div class="transact-search">
			<form action="" method="post">
				<h4>Transaction</h4>
				<div class="form-group form-inline">
					<input type="text" class="form-control" style="width: 443px;" name="barcode" id="barcode" placeholder="Enter Barcode" required="required">
					<button type="submit" class="btn btn-primary" value="search" name="search">Search</button>
			    </div>
		    </form>
		</div>
		-->
		<div class="transact-result">
			<form action="" method="post" autocomplete="off">
				<h4>Transaction</h4>
				<div class="form-group form-inline">
					<input type="text" class="form-control" style="width: 440px;" name="barcode" id="barcode" placeholder="Enter Barcode" required="required">
					<button type="submit" class="btn btn-primary" value="search" name="search">Search</button>
			    </div>
		    </form>
			<?php
			if(isset($_REQUEST['search'])){
				$qry_search_recieve = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$_REQUEST[barcode]' and route_office_code='$access[office_code]' and current_action='REL' and status='1'");
				$recieve = mysqli_fetch_assoc($qry_search_recieve);

				$show_doc = mysqli_query($connection,"select * from tbl_document where barcode='$_REQUEST[barcode]'");
				$rec_doc = mysqli_fetch_assoc($show_doc);

				if($rec_doc['transaction_type']=='SIMP'){
					$ttype = "Simple";
				}
				else{
					$ttype = "Complex";
				}

				if($rec_doc['source_type']=='INT'){
					$stype = "Internal";
				}
				else{
					$stype = "External";
				}

				$qry_doc_type = mysqli_query($connection,"select * from tbl_document_type where document_code='$rec_doc[document_type]'");
				$doc_type = mysqli_fetch_assoc($qry_doc_type);	

				if(mysqli_num_rows($qry_search_recieve)<1){
					$qry_search_release = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$_REQUEST[barcode]' and office_code='$access[office_code]' and current_action='REC' and status='1'");
					$rel = mysqli_fetch_assoc($qry_search_release);
					if(mysqli_num_rows($qry_search_release)<1){
						?>
						<script type="text/javascript">
							alert("No record found or document is not routed to this office.");
						</script>
						<?php
					}
					else{
						
						if($access['access_level']=="R" || $access['access_level']=="A"){
							?>
							<form action="" method="post" autocomplete="off">
								<table>
									<tr>
										<td style="width:500px;"><h4>Release Document</h4></td>
										<td><a href="home.php?menu=endtransaction&barcode=<?php echo $_REQUEST['barcode'];?>" title="End Document Transaction"><img src="../images/end-location.png" class="action-btn"></a></td>
									</tr>
								</table>
								<div class="form-group form-inline form-space-label form-space">
									<div class="form-label" style="width:174px;">Barcode</div>
									<div class="form-label" style="width:175px;">Transaction Type</div>
									<div class="form-label" style="width:160px;">Document Type</div>
								</div>
								<div class="form-group form-inline release-form" style="clear: both">
									<input type="hidden"  value="<?php echo $rel['recieve_date_time'];?>" name="recievedatetime" id="recievedatetime">
									<input type="text" style="width:173px;" class="form-control" value="<?php echo $_REQUEST['barcode'];?>" name="releasebarcode" id="recievebarcode" placeholder="Barcode" readonly="readonly">
									<input type="text" style="width:170px;" class="form-control" value="<?php echo $ttype; ?>" name="" id="" placeholder="Transaction Type" readonly="readonly">
									<input type="text" style="width:160px;" class="form-control" value="<?php echo $doc_type['document_type']?>" name="" id="" placeholder="Document Type" readonly="readonly">
								</div>
								<div class="form-group form-inline form-space-label form-space">
									<div class="form-label" style="width:173px;">Source Type</div>
									<div class="form-label" style="width:174px;">Source Name</div>
									<div class="form-label" style="width:160px;">Office</div>
								</div>
								<div class="form-group form-inline form-space">
									<input type="text" style="width:173px;" class="form-control" value="<?php echo $stype;?>" name="" id="" placeholder="Source Type" readonly="readonly">
									<input type="text" style="width:170px;" class="form-control" value="<?php echo $rec_doc['source_name'];?>" name="" id="" placeholder="Source Name" readonly="readonly">
									<input type="text" style="width:160px;" class="form-control" value="<?php echo $rec_doc['office_code'];?>" name="" id="" placeholder="Office" readonly="readonly">
								</div>
								<div class="form-group form-inline form-space-label form-space">
									<div class="form-label" style="width:173px;">Subject Matter</div>
								</div>
								<div class="form-group form-space">
									<textarea class="form-control" readonly="readonly" placeholder="Subject Matter"><?php echo $rec_doc['subject_matter'];?></textarea>
								</div>
								
								<div class="form-group form-inline form-space-label form-space">
									<div class="form-label" style="width:200px;">Route to Office/s</div>
								</div>
								<div class="form-group">
									<div class="form-label" style="height: 200px; overflow-y: scroll; padding-bottom: 10px; padding-left: 10px;">
									<table>
										<tr>
											<td>
												<input type='checkbox' name='selectalloffices' id='selectalloffices' value='1' onclick="selectall()">
											</td>
											<td>Select All Offices</td>
										</tr>
									<?php
										$qry_office = mysqli_query($connection,"select * from tbl_office where status='1' and office_code!='REC'  order by office_code asc");
										for($a=1;$a<=mysqli_num_rows($qry_office);$a++){
											$data = mysqli_fetch_assoc($qry_office);
											echo "<tr>";
											?>
											<td width="25px;">
												<input type="checkbox" name="routeoffice<?php echo $a;?>" id="routeoffice<?php echo $a;?>" value="<?php echo $data['office_code'];?>">
											</td>
											<?php
											echo "<td> $data[office_code] - $data[office_name]</td>";
											echo "</tr>";
										}
									?>
									</table>
									</div>
								</div>
								<div class="form-group form-inline form-space-label form-space">
									<div class="form-label" style="width:173px;">Release Action</div>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" name="releaseaction" id="releaseaction" placeholder="Release Action" required="required">
								</div>
								<div class="form-group form-inline form-space-label form-space">
									<div class="form-label" style="width:173px;">Remarks</div>
								</div>
								<div class="form-group form-space">
									<input type="text" class="form-control" name="releaseremarks" id="releaseremarks" placeholder="Remarks">
								</div>
								<div class="form-group form-space form-inline">
						        	<!--<button type="button" class="btn btn-warning" value="releasedocument" name="releasedocument">End Transaction</button>-->
						        	<button type="submit" class="btn btn-primary" value="releasedocumentrec" name="releasedocumentrec">Release</button>
						        </div>
					        </form>
					        </div>
							<?php
						}
						else{
						?>
							<form action="" method="post" autocomplete="off">
								<table>
									<tr>
										<td style="width:500px;"><h4>Release Document</h4></td>
										<td><a href="home.php?menu=endtransaction&barcode=<?php echo $_REQUEST['barcode'];?>" title="End Document Transaction"><img src="../images/end-location.png" class="action-btn"></a></td>
									</tr>
								</table>
								<div class="form-group form-inline form-space-label form-space">
									<div class="form-label" style="width:174px;">Barcode</div>
									<div class="form-label" style="width:175px;">Transaction Type</div>
									<div class="form-label" style="width:160px;">Document Type</div>
								</div>
								<div class="form-group form-inline release-form" style="clear: both">
									<input type="hidden"  value="<?php echo $rel['recieve_date_time'];?>" name="recievedatetime" id="recievedatetime">
									<input type="text" style="width:173px;" class="form-control" value="<?php echo $_REQUEST['barcode'];?>" name="releasebarcode" id="recievebarcode" placeholder="Barcode" readonly="readonly">
									<input type="text" style="width:170px;" class="form-control" value="<?php echo $ttype; ?>" name="" id="" placeholder="Transaction Type" readonly="readonly">
									<input type="text" style="width:160px;" class="form-control" value="<?php echo $doc_type['document_type']?>" name="" id="" placeholder="Document Type" readonly="readonly">
								</div>
								<div class="form-group form-inline form-space-label form-space">
									<div class="form-label" style="width:173px;">Source Type</div>
									<div class="form-label" style="width:174px;">Source Name</div>
									<div class="form-label" style="width:160px;">Office</div>
								</div>
								<div class="form-group form-inline form-space">
									<input type="text" style="width:173px;" class="form-control" value="<?php echo $stype;?>" name="" id="" placeholder="Source Type" readonly="readonly">
									<input type="text" style="width:170px;" class="form-control" value="<?php echo $rec_doc['source_name'];?>" name="" id="" placeholder="Source Name" readonly="readonly">
									<input type="text" style="width:160px;" class="form-control" value="<?php echo $rec_doc['office_code'];?>" name="" id="" placeholder="Office" readonly="readonly">
								</div>
								<div class="form-group form-inline form-space-label form-space">
									<div class="form-label" style="width:173px;">Subject Matter</div>
								</div>
								<div class="form-group form-space">
									<textarea class="form-control" readonly="readonly" placeholder="Subject Matter"><?php echo $rec_doc['subject_matter'];?></textarea>
								</div>
								<div class="form-group form-inline form-space-label form-space">
									<div class="form-label" style="width:173px;">Release Action</div>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" name="releaseaction" id="releaseaction" placeholder="Release Action" required="required">
								</div>
								<div class="form-group form-inline form-space-label form-space">
									<div class="form-label" style="width:173px;">Route to Office</div>
								</div>
								<div class="form-group form-space">
									<select class="form-control" name="routeoffice" id="routeoffice" required="required">
										<option value="">Select Office</option>
										<?php
										$qry_office = mysqli_query($connection,"select * from tbl_office where status='1'  order by office_code asc"); //and office_code!='REC'
										for($a=1;$a<=mysqli_num_rows($qry_office);$a++){
											$data = mysqli_fetch_assoc($qry_office);

											if($access['office_code']==$data['office_code']){
												//none
											}
											else{
												echo "<option value='$data[office_code]'>$data[office_code] - $data[office_name]</option>";
											}
											
										}
										?>
									</select>
								</div>
								<div class="form-group form-inline form-space-label form-space">
									<div class="form-label" style="width:173px;">Remarks</div>
								</div>
								<div class="form-group form-space">
									<input type="text" class="form-control" name="releaseremarks" id="releaseremarks" placeholder="Remarks">
								</div>
								<div class="form-group form-space form-inline">
						        	<!--<button type="button" class="btn btn-warning" value="releasedocument" name="releasedocument">End Transaction</button>-->
						        	<button type="submit" class="btn btn-primary" value="releasedocument" name="releasedocument">Release</button>
						        </div>
					        </form>
					        </div>
							<?php
						}
					}
					
				}
				else{
				?>
					<form action="" method="post">
					<h4>Receive Document</h4>
					<div class="form-group form-inline form-space-label form-space">
						<div class="form-label" style="width:174px;">Barcode</div>
						<div class="form-label" style="width:175px;">Transaction Type</div>
						<div class="form-label" style="width:160px;">Document Type</div>
					</div>
					<div class="form-group form-inline">
						<input type="hidden" value="<?php echo $recieve['release_date_time']; ?>" name="releasedatetime" id="releasedatetime">
						<input type="text" style="width:173px;" class="form-control" value="<?php echo $_REQUEST['barcode'];?>" name="recievebarcode" id="recievebarcode" placeholder="Barcode" readonly="readonly">
						<input type="text" style="width:170px;" class="form-control" value="<?php echo $ttype; ?>" name="" id="" placeholder="Transaction Type" readonly="readonly">
						<input type="text" style="width:160px;" class="form-control" value="<?php echo $doc_type['document_type']?>" name="" id="" placeholder="Document Type" readonly="readonly">
					</div>
					<div class="form-group form-inline form-space-label form-space">
						<div class="form-label" style="width:174px;">Source Type</div>
						<div class="form-label" style="width:175px;">Source Name</div>
						<div class="form-label" style="width:160px;">Office</div>
					</div>
					<div class="form-group form-inline form-space">
						<input type="text" style="width:173px;" class="form-control" value="<?php echo $stype;?>" name="" id="" placeholder="Source Type" readonly="readonly">
						<input type="text" style="width:170px;" class="form-control" value="<?php echo $rec_doc['source_name'];?>" name="" id="" placeholder="Source Name" readonly="readonly">
						<input type="text" style="width:160px;" class="form-control" value="<?php echo $rec_doc['office_code'];?>" name="" id="" placeholder="Office" readonly="readonly">
					</div>
					<div class="form-group form-inline form-space-label form-space">
						<div class="form-label" style="width:173px;">Subject Matter</div>
					</div>
					<div class="form-group form-space">
						<textarea class="form-control" readonly="readonly" placeholder="Subject Matter"><?php echo $rec_doc['subject_matter'];?></textarea>
					</div>
					<div class="form-group form-inline form-space-label form-space">
						<div class="form-label" style="width:173px;">Receive Action</div>
					</div>
					<div class="form-group form-space">
						<input type="text" class="form-control" name="recieveaction" id="recieveaction" placeholder="Receive Action" value="Receive Document" required="required">
					</div>
					<div class="form-group form-space">
			        	<button type="submit" class="btn btn-primary" value="recievedocument" name="recievedocument">Receive</button>
			        </div>
			        </form>
				<?php
				}
			}
			else{
			?>		
				
				<div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:174px;">Barcode</div>
					<div class="form-label" style="width:175px;">Transaction Type</div>
					<div class="form-label" style="width:160px;">Document Type</div>
				</div>
				<div class="form-group form-inline">
					<input type="text" style="width: 173px;" class="form-control" name="" id="" placeholder="Barcode" readonly="readonly">
					<input type="text" style="width: 170px;" class="form-control" name="" id="" placeholder="Transaction Type" readonly="readonly">
					<input type="text" style="width: 160px;" class="form-control" name="" id="" placeholder="Document Type" readonly="readonly">
				</div>
				<div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:174px;">Source Type</div>
					<div class="form-label" style="width:175px;">Source Name</div>
					<div class="form-label" style="width:160px;">Office</div>
				</div>
				<div class="form-group form-inline form-space">
					<input type="text" style="width: 173px;" class="form-control" name="" id="" placeholder="Source Type" readonly="readonly">
					<input type="text" style="width: 170px;" class="form-control" name="" id="" placeholder="Source Name" readonly="readonly">
					<input type="text" style="width: 160px;" class="form-control" name="" id="" placeholder="Office" readonly="readonly">
				</div>
				<div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:173px;">Subject Matter</div>
				</div>
				<div class="form-group form-space">
					<textarea class="form-control" name="" id="" readonly="readonly" placeholder="Subject Matter"></textarea>
				</div>
				<div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:173px;">Route to Office</div>
				</div>
				<div class="form-group form-space">
					<input type="text" class="form-control" name="" id="" placeholder="Route to Office" readonly="readonly">
				</div>
				<div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:173px;">Action</div>
				</div>
				<div class="form-group form-space">
					<input type="text" class="form-control" name="" id="" placeholder="Action" readonly="readonly">
				</div>
				<div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:173px;">Remarks</div>
				</div>
				<div class="form-group form-space">
					<input type="text" class="form-control" name="" id="" placeholder="Remarks" readonly="readonly">
				</div>
				<div class="form-group form-space">
		        	<button type="submit" class="btn btn-primary" value="recievedocument" name="recievedocument">Button</button>
		        </div>
			<?php
			}
			?>
		</div>
	</div>
</body>
</html>
<?php
//}
include("../functions/time_functions.php");
if(isset($_REQUEST['recievedocument'])){
	$barcode = strtoupper($_REQUEST['recievebarcode']);

	$wh = working_hours();

	$transit_time = compute_minutes($_REQUEST['releasedatetime'],$wh);


	//update
	mysqli_query($connection,"update tbl_document_transaction set transit_date_time='$wh', transit_time='$transit_time', current_action='', status='0' where barcode='$barcode' and route_office_code='$access[office_code]'");
	
	$qry_sequence = mysqli_query($connection,"select max(sequence)sq from tbl_document_transaction where barcode='$barcode'");
	$sequence = mysqli_fetch_assoc($qry_sequence);
	
	$qry_transit_time = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$barcode' and route_office_code='$access[office_code]' and current_action='' and status='0'");
	$transits_time = mysqli_fetch_assoc($qry_transit_time);
	$add_transit_time = get_total_transit_time($barcode)+$transits_time['transit_time'];
	

	//update doc transit time
	mysqli_query($connection,"update tbl_document set total_transit_time='$add_transit_time' where barcode='$barcode'");

	
	$sq = $sequence['sq']+1;

	$rcr = addslashes($_REQUEST['recieveaction']);

	$insert = mysqli_query($connection,"insert into tbl_document_transaction values('$transaction_id','$barcode','$sq',NULL,'$access[office_code]','$access[full_name]','$wh','$rcr','','',NULL,'','','REC','0','0','1')");
	
	logs($access['username'],"$access[office_code] RECEIVED DOCUMENT $barcode.");
	?>
		<script type="text/javascript">
			alert("Document Received.");
			window.location = "home.php?menu=transact";
		</script>
	<?php
	
}

if(isset($_REQUEST['releasedocument'])){
	
	$wh = working_hours();

	$office_time = compute_minutes($_REQUEST['recievedatetime'],$wh);

	$ra = addslashes($_REQUEST['releaseaction']);
	$rr = addslashes($_REQUEST['releaseremarks']);
	//update document
	$add_office_time = get_total_office_time($_REQUEST['releasebarcode'])+$office_time;
	mysqli_query($connection,"update tbl_document set total_office_time='$add_office_time' where barcode='$_REQUEST[releasebarcode]'");

	//update 
	mysqli_query($connection,"update tbl_document_transaction set route_office_code='$_REQUEST[routeoffice]', release_date_time='$wh', release_action='$ra', remarks='$rr', rel_person='$access[full_name]', current_action='REL', office_time='$office_time' where barcode='$_REQUEST[releasebarcode]' and office_code='$access[office_code]' and current_action='REC' and status='1'");

	logs($access['username'],"$access[office_code] RELEASED DOCUMENT $_REQUEST[releasebarcode] TO $_REQUEST[routeoffice].");

	?>	
		<script type="text/javascript">
			alert("Document Released.");
			window.location = "home.php?menu=transact";
		</script> 
	<?php
}

if(isset($_REQUEST['releasedocumentrec'])){
	$wh = working_hours();

	$office_time = compute_minutes($_REQUEST['recievedatetime'],$wh);

	$ra = addslashes($_REQUEST['releaseaction']);
	$rr = addslashes($_REQUEST['releaseremarks']);

	//update document
	$add_office_time = get_total_office_time($_REQUEST['releasebarcode'])+$office_time;
	mysqli_query($connection,"update tbl_document set total_office_time='$add_office_time' where barcode='$_REQUEST[releasebarcode]'");


	$qry_office = mysqli_query($connection,"select * from tbl_office where status='1' and office_code!='REC'  order by office_code asc");

	$current_sequence = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$_REQUEST[releasebarcode]' and current_action='REC' order by sequence desc");
	$cur = mysqli_fetch_assoc($current_sequence);
	$cur_sq = $cur['sequence'];


	for($a=1;$a<=mysqli_num_rows($qry_office);$a++){

		if(isset($_REQUEST['routeoffice'.$a])){
			//insert transactions

			$office_code = $_REQUEST['routeoffice'.$a];

			$new_transid = $transaction_id.$a;
			
			mysqli_query($connection,"insert into tbl_document_transaction values('$new_transid','$_REQUEST[releasebarcode]','$cur_sq',NULL,'REC','$access[full_name]','$cur[recieve_date_time]','$cur[recieve_action]','$office_code','$access[full_name]','$wh','$ra','$rr','REL','$office_time','0','1')");

			logs($access['username'],"$access[office_code] RELEASED DOCUMENT $_REQUEST[releasebarcode] TO $office_code.");

		}
		else{
			//none
		}
		
	}

	//delete 1 existing rec
	mysqli_query($connection,"delete from tbl_document_transaction where barcode='$_REQUEST[releasebarcode]' and office_code='REC' and route_office_code='' and release_action='' and remarks='' and transit_time='0'");

	?>	
		<script type="text/javascript">
			alert("Document Released.");
			window.location = "home.php?menu=transact";
		</script>
	<?php
}


?>