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

	function activateEnd(){
		
	    var rvbutton = document.getElementById("recievedocument");
	    var finallable = document.getElementById("finalremarklabel");
	    var finalremarks = document.getElementById("finalremarks");
	    var passlabel = document.getElementById("passwordlabel");
	    var confpass = document.getElementById("confirmpassword");
	    var endd = document.getElementById("end");

	    if (finallable.style.display === "none") {
			rvbutton.style.display = "none";	 
			rvbutton.disabled = true;      

	        finallable.style.display = "inline";
	        finallable.disabled = false; 

	        finalremarks.style.display = "inline";
	        finalremarks.disabled = false; 

	        passlabel.style.display = "inline";
	        passlabel.disabled = false; 

			confpass.style.display = "inline";
			confpass.disabled = false; 
			
			endd.style.display = "inline";
			endd.disabled = false; 

	    } else {
	       	rvbutton.style.display = "inline";
	       	rvbutton.disabled = false; 

			finallable.style.display = "none";
			finallable.disabled = true;

	        finalremarks.style.display = "none";
	        finalremarks.disabled = true;

	        passlabel.style.display = "none";
	        passlabel.disabled = true;

			confpass.style.display = "none";
			confpass.disabled = true;

			endd.style.display = "none";
			endd.disabled = true; 	        
	    }
	
	}

</script>


<body onload="activateEnd()">
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
				$barcode = mysqli_real_escape_string($connection, $_REQUEST['barcode']);

				$qry_search_recieve = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$barcode' and route_office_code='$access[office_code]' and current_action='REL' and status='1'");
				$recieve = mysqli_fetch_assoc($qry_search_recieve);

				$show_doc = mysqli_query($connection,"select * from tbl_document where barcode='$barcode'");
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
					//no route value on table - yants / 04-30-19
					$qry_search_release = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$barcode' and office_code='$access[office_code]' and current_action='REC' and status='1'");
					$rel = mysqli_fetch_assoc($qry_search_release);
					if(mysqli_num_rows($qry_search_release)<1){
						?>
						<script type="text/javascript">
							alert("No record found or document is not routed to this office.");
						</script>
						<?php
					}
					else{
						if(!$rec_doc['is_approved'] && ($rec_doc['to_ocm'] == 1 || $rec_doc['to_ocm'] == 0) && ($access['office_code']=='ADM' ||  $access['office_code']=='CMO')) {
							$show_doc_trans = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$barcode' and sequence=0");
						
							$show_doc_tr = mysqli_fetch_assoc($show_doc_trans);
							if(mysqli_num_rows($show_doc_trans) < 2) {
								if($show_doc_tr['route_office_code']==$access['office_code']){
								?>	
								<script type="text/javascript">
									window.location = "home.php?menu=endtransaction&barcode=<?php echo $_REQUEST['barcode'];?>";
								</script> 
								<?php
								}
							 }
						}
						
						if($access['access_level']=="R" ){ //|| $access['access_level']=="A" 
							//access level is equal to Record user level can route to many offices
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
									<div class="form-label" style="width:173px;">Communication Summary</div>
								</div>
								<div class="form-group form-space">
									<textarea class="form-control" readonly="readonly" placeholder="Communication Summary"><?php echo $rec_doc['subject_matter'];?></textarea>
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
											$qry_office = mysqli_query($connection,"select * from tbl_office where status='1' order by office_code asc"); //and office_code!='SMO'
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
									<div class="form-label" style="width:173px;">Communication Summary</div>
								</div>
								<div class="form-group form-space">
									<textarea class="form-control" readonly="readonly" placeholder="Communication Summary"><?php echo $rec_doc['subject_matter'];?></textarea>
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
										$qry_office = mysqli_query($connection,"select * from tbl_office where status=1  order by office_code asc"); //and office_code!='SMO'
										for($a=1;$a<=mysqli_num_rows($qry_office);$a++){
											$data = mysqli_fetch_assoc($qry_office);

											// if($access['office_code']==$data['office_code']){
											// 	//none
											// }
											// else{
												echo "<option value='$data[office_code]'>$data[office_code] - $data[office_name]</option>";
											//}
											
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
						<div class="clearfix"></div>
						<?php
						if($rec_doc['prerequisite']!=""){
							
							//prerequisites
							$explode = explode(" ",$rec_doc['prerequisite']);
							$x=0;
							foreach($explode as $i =>$key) {
								$checkstatusdocs = mysqli_query($connection,"select * from tbl_document where barcode='$key' and status=1 and transaction_status='' and to_ocm=$rec_doc[to_ocm]");
								if(mysqli_num_rows($checkstatusdocs) > 0) {
									$statusdoc=mysqli_fetch_assoc($checkstatusdocs);
									$checkstatustrans = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$key' and route_office_code='$access[office_code]' order by trans_id desc");

											if(mysqli_num_rows($checkstatustrans) <= 2) {
												$statusdoctrans=mysqli_fetch_assoc($checkstatustrans);
					 							if($statusdoctrans['current_action'] != '') {
													if($x==0){
														$x=1;
														echo "The document is linked to the ff.: <br>";
													}
													echo "<a href='home.php?menu=viewdocument&barcode=$key' target='_blank'>".$key."</a>&nbsp;&nbsp;";
												}
											}
								}
							}
							if($x==1){
								echo "<br><br>";
							}
						}
						?>
						<div class="clearfix"></div>
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
							<div class="form-label" style="width:173px;">Communication Summary</div>
						</div>
						<div class="form-group form-space">
							<textarea class="form-control" readonly="readonly" placeholder="Communication Summary"><?php echo $rec_doc['subject_matter'];?></textarea>
						</div>
						<div class="form-group form-inline form-space-label form-space">
							<div class="form-label" style="width:520px; text-align: right;">
							<?php 
								if(!$rec_doc['is_approved'] && ($rec_doc['to_ocm'] == 1 || $rec_doc['to_ocm'] == 0)  && ($access['office_code']== 'ADM' || $access['office_code']=='CMO')) { 
									$show_doc_trans = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$barcode' and 	sequence=0");
					
									$show_doc_tr = mysqli_fetch_assoc($show_doc_trans);
								 
									if($show_doc_tr['route_office_code']==$access['office_code']){
										?>
								<?php } else { ?>
							?>
								<img src="../images/end-location.png" class="action-btn" onclick="activateEnd()" title="End Transaction">
								<?php } 
							
							}  else { ?>
	<img src="../images/end-location.png" class="action-btn" onclick="activateEnd()" title="End Transaction">
								
<?php } ?>
							</div>
							
						</div>
						<div class="form-group form-inline form-space-label form-space" id="recieve-action-label">
							<div class="form-label" style="width:173px;">Receive Action</div>
						</div>

						<div class="form-group form-space">
							<input type="text" class="form-control" name="recieveaction" id="recieveaction" placeholder="Receive Action" value="Received Document" required="required">
						</div>
						<div class="form-group form-space">
				        	<button type="submit" class="btn btn-primary" value="recievedocument" name="recievedocument" id="recievedocument">Receive</button>
				        </div>

			      
							<?php 
						//Modification
						//Modified by : Yants
						//Modified date : 05/1/2019
							if(!$rec_doc['is_approved'] && ($rec_doc['to_ocm'] == 1 || $rec_doc['to_ocm'] == 0)  && ($access['office_code']== 'ADM' || $access['office_code']=='CMO')) { 
								$show_doc_trans = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$barcode' and 	sequence=0");
				
								$show_doc_tr = mysqli_fetch_assoc($show_doc_trans);
							 
								if($show_doc_tr['route_office_code']==$access['office_code']){
									?>
								 
							<?php } else { ?>
								<div class="form-group form-inline form-space-label form-space" >
							<div class="form-label" style="width:174px;" id="finalremarklabel" style="display: none;">Final Remarks</div>
						</div>
						<div class="form-group form-space">
							<input type="text" class="form-control" name="finalremarks" id="finalremarks" placeholder="Final Remarks" required="required" style="display: none">
						</div>
						<div class="form-group form-inline form-space-label form-space">
							<div class="form-label" style="width:174px;" id="passwordlabel" style="display: none;">Password</div>
						</div>
						<div class="form-group form-space">
							<input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Password to Confirm Action" required="required" style="display: none;">
						</div>
						
							<div class="form-group form-space">
										<button type="submit" class="btn btn-primary" value="end" name="end" id="end" style="display: none;">End Transaction</button>
								</div>
								<?php }
							} else { ?>
							<div class="form-group form-inline form-space-label form-space" >
							<div class="form-label" style="width:174px;" id="finalremarklabel" style="display: none;">Final Remarks</div>
						</div>
						<div class="form-group form-space">
							<input type="text" class="form-control" name="finalremarks" id="finalremarks" placeholder="Final Remarks" required="required" style="display: none">
						</div>
						<div class="form-group form-inline form-space-label form-space">
							<div class="form-label" style="width:174px;" id="passwordlabel" style="display: none;">Password</div>
						</div>
						<div class="form-group form-space">
							<input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Password to Confirm Action" required="required" style="display: none;">
						</div>
						
							<div class="form-group form-space">
										<button type="submit" class="btn btn-primary" value="end" name="end" id="end" style="display: none;">End Transaction</button>
								</div>
								<?php } ?>
							  
				        &nbsp;
			        </form>
				<?php
				}
			}
			else{
				//result where there's no search performed yet - yants / 04-30-19
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
					<div class="form-label" style="width:173px;">Communication Summary</div>
				</div>
				<div class="form-group form-space">
					<textarea class="form-control" name="" id="" readonly="readonly" placeholder="Communication Summary"></textarea>
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
		        	<button type="submit" class="btn btn-primary" value="recievedocument" name="recievedocument">----</button>
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
	$barcode = mysqli_real_escape_string($connection, $barcode);
	$wh = working_hours();

	$transit_time = compute_minutes($_REQUEST['releasedatetime'],$wh);

	//update
	mysqli_query($connection,"update tbl_document_transaction set transit_date_time='$wh', transit_time='$transit_time', current_action='', status='0' where barcode='$barcode' and route_office_code='$access[office_code]' and status='1' and current_action='REL'");
	
	$qry_sequence = mysqli_query($connection,"select max(sequence)sq from tbl_document_transaction where barcode='$barcode'");
	$sequence = mysqli_fetch_assoc($qry_sequence);
	
	$qry_transit_time = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$barcode' and route_office_code='$access[office_code]' and current_action='' and status='0'");
	$transits_time1 = mysqli_fetch_assoc($qry_transit_time);
	$add_transit_time = get_total_transit_time($barcode)+$transits_time1['transit_time'];
	
	//update doc transit time
	mysqli_query($connection,"update tbl_document set total_transit_time='$add_transit_time' where barcode='$barcode'");

	$sq = $sequence['sq']+1;
	
	$rcr = addslashes($_REQUEST['recieveaction']);
	$newtrans = $transaction_id."0";
	$insert = mysqli_query($connection,"insert into tbl_document_transaction values('$newtrans','$barcode','$sq',NULL,'$access[office_code]','$access[full_name]','$wh','$rcr','','',NULL,'','','REC','0','0','1')");
	
	$qry_doc_trans = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$barcode' and route_office_code='$access[office_code]' and current_action='REC' and status='1'");
	$doc_trans = mysqli_fetch_assoc($qry_doc_trans);

	logs($access['username'],"$access[office_code] RECEIVED DOCUMENT $barcode.");

	$document_qry = mysqli_query($connection,"select * from tbl_document where barcode='$barcode' and status='1'");
	$document = mysqli_fetch_assoc($document_qry);
	$explode = explode(" ",$document['prerequisite']);
	$x=1;
 
	foreach($explode as $i =>$key) {
		$checkstatusdocs = mysqli_query($connection,"select * from tbl_document where barcode='$key' and status=1");
		if(mysqli_num_rows($checkstatusdocs) > 0) {
	 
			$statusdoc=mysqli_fetch_assoc($checkstatusdocs);
			$checkstatustrans = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$key' and route_office_code='$access[office_code]' and status='1' and current_action='REL'");
			$statusdoctrans=mysqli_fetch_assoc($checkstatustrans);
					if(mysqli_num_rows($checkstatustrans) <= 1 ) {
				 
						if($statusdoc['is_approved']=='1' && $statusdoctrans['sequence']=='0') {
							if($statusdoctrans['current_action'] != '') {
							 
								// $last5string = substr($transaction_id, -5);
								// $firststring= substr($transaction_id, 0, -5);
								// $last5string = (int)$last5string + $x;

								$newtrans = $transaction_id.$x;
								mysqli_query($connection,"update tbl_document_transaction set transit_date_time='$wh', transit_time='$transit_time', current_action='', status='0' where barcode='$key' and route_office_code='$access[office_code]' and status='1' and current_action='REL'");
							
								mysqli_query($connection,"insert into tbl_document_transaction values('$newtrans','$key','$sq',NULL,'$access[office_code]','$access[full_name]','$wh','$rcr','','',NULL,'','','REC','0','0','1')");
								logs($access['username'],"$access[office_code] RECEIVED DOCUMENT $key.");
								$x++;
							}
						} else {
						 
							mysqli_query($connection,"update tbl_document_transaction set transit_date_time='$wh', transit_time='$transit_time', current_action='', status='0' where barcode='$key' and route_office_code='$access[office_code]' and status='1'"); //herehre
			
							$qry_sequence = mysqli_query($connection,"select max(sequence)sq from tbl_document_transaction where barcode='$key'");
							$sequence = mysqli_fetch_assoc($qry_sequence);
							
							$qry_transit_time = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$key' and route_office_code='$access[office_code]' and current_action='' and status='0'");
							$transits_time = mysqli_fetch_assoc($qry_transit_time);
							if($statusdoctrans['current_action'] == 'REL') {
								$add_transit_time = get_total_transit_time($key)+$transits_time['transit_time'];
							
					
								//update doc transit time
								mysqli_query($connection,"update tbl_document set total_transit_time='$add_transit_time' where barcode='$key'");
						
								
								$sq = $sequence['sq']+1;
						 
	
								// $last5string = substr($transaction_id, -5);
								// $firststring= substr($transaction_id, 0, -5);
								// $last5string = (int)$last5string + $x;
	
								$newtrans = $transaction_id.$x;

								logs($access['username'],"$access[office_code] RECEIVED DOCUMENT $key.");
								//receive end
						
								$show_other_details = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$key' and office_code='$access[office_code]' and current_action='REC' and status='1'");
								$doc_details = mysqli_fetch_assoc($show_other_details);
								
								if(mysqli_num_rows($show_other_details) <= 0) {
									$insert = mysqli_query($connection,"insert into tbl_document_transaction values('$newtrans','$key','$sq',NULL,'$access[office_code]','$access[full_name]','$wh','$rcr','','',NULL,'','','REC','0','0','1')");
									$x++;
								}
								
								if($statusdoctrans['sequence']!='0' && $doc_trans['sequence']!='0' && $statusdoctrans['status']=='1') {
									$office_time = compute_minutes($doc_details['recieve_date_time'],$wh);
									$remarks = "Ended by receiving <a href=home.php?menu=viewdocument&barcode=";
									$remarks = $remarks.$barcode." target=_blank>".$barcode."</a>";
									

									$boomqy = mysqli_query($connection,"select * from tbl_document_transaction  where barcode='$key' and route_office_code='$access[office_code]' and current_action='REL' and status=1");
									$boom = mysqli_fetch_assoc($boomqy);
							
									mysqli_query($connection,"update tbl_document_transaction set release_date_time='$wh', current_action='END',rel_person='$access[full_name]', release_action='-',remarks='$remarks', office_time='0', status='0' where barcode='$key' and office_code='$access[office_code]' and current_action='REC' and status='1'");
								 
									$qry_count_sq = mysqli_query($connection,"select count(trans_id)nos from tbl_document_transaction where barcode='$key' and sequence='1'");
									$seq = mysqli_fetch_assoc($qry_count_sq);
							
									$qry_count_end = mysqli_query($connection,"select count(trans_id)nos from tbl_document_transaction where barcode='$key' and current_action='END'");
									$end = mysqli_fetch_assoc($qry_count_end);

									if($seq['nos']==$end['nos'] && $statusdoc['transaction_status']==''){
										$now = date("Y-m-d H:i:s");
		
										$get_tt = mysqli_query($connection,"select transaction_type,total_office_time from tbl_document where barcode='$key'");
										$tt = mysqli_fetch_assoc($get_tt);
		
										$get_total_fix = mysqli_query($connection,"select timestampdiff(minute,recieve_date,'$now')total_office_time  from tbl_document where barcode='$key'");
										$fix = mysqli_fetch_assoc($get_total_fix);
		
										$get_time = mysqli_query($connection,"select sum(office_time)ot,sum(transit_time)tt from tbl_document_transaction where barcode='$key'");
										$gtime = mysqli_fetch_assoc($get_time);		
		
		
										$get_total = mysqli_query($connection,"select sum(office_time+transit_time)total_office_time,sum(office_time)tot,sum(transit_time)ttt  from tbl_document_transaction where barcode='$key'");
										$tt2 = mysqli_fetch_assoc($get_total);
		
		
										if($tt['transaction_type']=="SIMP"){
											//simple
											$qry_simp = mysqli_query($connection,"select days from tbl_transaction_type where id='SIMP'");
											$simp = mysqli_fetch_assoc($qry_simp);
		
											$calc = $simp['days']*1440;
		
											if($fix['total_office_time']>$calc){
												$transaction_status = "D";
											}
											else{
												$transaction_status = "O";
											}
		
										}else if($tt['transaction_type']=="COMP"){
											//complex
											$qry_comp = mysqli_query($connection,"select days from tbl_transaction_type where id='COMP'");
											$comp = mysqli_fetch_assoc($qry_comp);
		
											$calc = $comp['days']*1440;
		
											if($fix['total_office_time']>$calc){
												$transaction_status = "D";
											}
											else{
												$transaction_status = "O";
											}
		
										}
										else{
											//highly technical
											$qry_high = mysqli_query($connection,"select days from tbl_transaction_type where id='HIGH'");
											$high = mysqli_fetch_assoc($qry_high);
		
											$calc = $high['days']*1440;	
		
											if($fix['total_office_time']>$calc){
												$transaction_status = "D";
											}
											else{
												$transaction_status = "O";
											}
										}
										//include highly technical
										mysqli_query($connection,"update tbl_document set total_office_time='$gtime[ot]', total_transit_time='$gtime[tt]', transaction_end_date='$now', transaction_status='$transaction_status' where barcode='$key'");
								}
							}
						}
					}
				} 
		}
	}

					
	?>
		<script type="text/javascript">
			alert("Document Received.");
			window.location = "home.php?menu=transact";
		</script>
	<?php
	
}

if(isset($_REQUEST['releasedocument'])){

	$barcode = mysqli_real_escape_string($connection, $_REQUEST['releasebarcode']);
	
	$wh = working_hours();

	$office_time = compute_minutes($_REQUEST['recievedatetime'],$wh);

	$ra = addslashes($_REQUEST['releaseaction']);
	$rr = addslashes($_REQUEST['releaseremarks']);
	//update document
	$add_office_time = get_total_office_time($_REQUEST['releasebarcode'])+$office_time;

	mysqli_query($connection,"update tbl_document set total_office_time='$add_office_time' where barcode='$barcode'");

	//update 
	mysqli_query($connection,"update tbl_document_transaction set route_office_code='$_REQUEST[routeoffice]', release_date_time='$wh', release_action='$ra', remarks='$rr', rel_person='$access[full_name]', current_action='REL', office_time='$office_time' where barcode='$barcode' and office_code='$access[office_code]' and current_action='REC' and status='1'");

	logs($access['username'],"$access[office_code] RELEASED DOCUMENT $_REQUEST[releasebarcode] TO $_REQUEST[routeoffice].");

	?>	
		<script type="text/javascript">
			alert("Document Released.");
			window.location = "home.php?menu=transact";
		</script> 
	<?php
}

if(isset($_REQUEST['releasedocumentrec'])){

	$barcode = mysqli_real_escape_string($connection, $_REQUEST['releasebarcode']);
	
	$wh = working_hours();

	$office_time = compute_minutes($_REQUEST['recievedatetime'],$wh);

	$ra = addslashes($_REQUEST['releaseaction']);
	$rr = addslashes($_REQUEST['releaseremarks']);

	//update document
	$add_office_time = get_total_office_time($_REQUEST['releasebarcode'])+$office_time;
	mysqli_query($connection,"update tbl_document set total_office_time='$add_office_time' where barcode='$barcode'");

 
	$qry_office = mysqli_query($connection,"select * from tbl_office where status='1' and office_code!='SMO'  order by office_code asc");

	$current_sequence = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$barcode' and current_action='REC' order by sequence desc");


	$cur1 = mysqli_fetch_assoc($current_sequence);
	$cur_sq = $cur1['sequence'];


	for($a=1;$a<=mysqli_num_rows($qry_office);$a++){

		if(isset($_REQUEST['routeoffice'.$a])){
			//insert transactions

			$office_code = $_REQUEST['routeoffice'.$a];

			$new_transid = $transaction_id.$a;
			
			mysqli_query($connection,"insert into tbl_document_transaction values('$new_transid','$barcode','$cur_sq',NULL,'SMO','$cur1[person]','$cur1[recieve_date_time]','$cur1[recieve_action]','$office_code','$access[full_name]','$wh','$ra','$rr','REL','$office_time','0','1')");

			logs($access['username'],"$access[office_code] RELEASED DOCUMENT $_REQUEST[releasebarcode] TO $office_code.");
		}
		else{
			//none
		}
		
	}

	//delete 1 existing rec
	mysqli_query($connection,"delete from tbl_document_transaction where barcode='$barcode' and office_code='SMO' and route_office_code='' and release_action='' and remarks='' and transit_time='0'");

	$document_qry = mysqli_query($connection,"select * from tbl_document where barcode='$barcode' and status='1'");
	$document = mysqli_fetch_assoc($document_qry);
	
	$explode = explode(" ",$document['prerequisite']);
	$x=1;
	foreach($explode as $i =>$key) {
		$checkstatusdocs = mysqli_query($connection,"select * from tbl_document where barcode='$key' and status=1 and transaction_status='' ");
		if(mysqli_num_rows($checkstatusdocs) > 0) {
				$statusdoc=mysqli_fetch_assoc($checkstatusdocs);

				$add_office_time = get_total_office_time($key)+$office_time;
				mysqli_query($connection,"update tbl_document set total_office_time='$add_office_time' where barcode='$key'");
			
			
				$qry_office = mysqli_query($connection,"select * from tbl_office where status='1' and office_code!='SMO'  order by office_code asc");
			
				$current_sequence = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$key' and current_action='REC' order by sequence desc");
			
			
				$cur = mysqli_fetch_assoc($current_sequence);
				$cur_sq = 1;
				if($cur['sequence'] != null || $cur['sequence'] != 0) {
					$cur_sq = $cur['sequence'];
				}
				
			
				for($a=1;$a<=mysqli_num_rows($qry_office);$a++){
					if(isset($_REQUEST['routeoffice'.$a])){
						//insert transactions
						$offcode=$_REQUEST['routeoffice'.$a];
						$checkstatustrans = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$key' and route_office_code='$offcode' and sequence!='0'");
		 
						if(mysqli_num_rows($checkstatustrans) <= 0 ) {
							$office_code = $_REQUEST['routeoffice'.$a];
							
							$last5string = substr($transaction_id, -5);
							$firststring= substr($transaction_id, 0, -5);
							$last5string = (int)$last5string + $x;

							$new_transid = $firststring.$last5string;
							$new_transid = $new_transid.$a;
							$x++;
							mysqli_query($connection,"insert into tbl_document_transaction values('$new_transid','$key','$cur_sq',NULL,'SMO','$access[full_name]','$cur1[recieve_date_time]','$cur1[recieve_action]','$office_code','$access[full_name]','$wh','$ra','$rr','REL','$office_time','0','1')");
				
							logs($access['username'],"$access[office_code] RELEASED DOCUMENT $_REQUEST[releasebarcode] TO $office_code.");
						}
					}
				}
				
				mysqli_query($connection,"delete from tbl_document_transaction where barcode='$key' and office_code='SMO' and route_office_code='' and release_action='' and remarks='' and transit_time='0'");
		}
	}

	
	?>	
		<script type="text/javascript">
			alert("Document Released.");
			window.location = "home.php?menu=transact";
		</script>
	<?php
}

if(isset($_REQUEST['end'])){
	//check password

	$pss = md5($_REQUEST['confirmpassword']);

	$qry_check = mysqli_query($connection,"select * from tbl_users where username='$access[username]' and password='$pss' and office_code='$access[office_code]'");

	if(mysqli_num_rows($qry_check)>=1){
		//receive start
		$barcode = strtoupper($_REQUEST['recievebarcode']);

		$wh = working_hours();

		$transit_time = compute_minutes($_REQUEST['releasedatetime'],$wh);

		//update
		mysqli_query($connection,"update tbl_document_transaction set transit_date_time='$wh', transit_time='$transit_time', current_action='', status='0' where barcode='$barcode' and route_office_code='$access[office_code]' and status='1'"); //herehre
		
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
		//receive end

		$show_other_details = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$barcode' and current_action='REC' and status='1'");
		$doc_details = mysqli_fetch_assoc($show_other_details);

		$office_time = compute_minutes($doc_details['recieve_date_time'],$wh);

		$fr = addslashes($_REQUEST['finalremarks']);
		//note: if the user wants to activate transaction for processing change current_action='SMO' and remarks='' and status='1' 
		$wh = working_hours();
		//$office_time = compute_minutes($_REQUEST['recievedatetime'],$wh);

		mysqli_query($connection,"update tbl_document_transaction set release_date_time='$wh', current_action='END', remarks='$fr', rel_person='$access[full_name]', office_time='0', status='0' where barcode='$barcode' and office_code='$access[office_code]' and current_action='REC' and status='1'");

		$qry_count_sq = mysqli_query($connection,"select count(trans_id)nos from tbl_document_transaction where barcode='$barcode' and sequence='1'");
		$seq = mysqli_fetch_assoc($qry_count_sq);

		$qry_count_end = mysqli_query($connection,"select count(trans_id)nos from tbl_document_transaction where barcode='$barcode' and current_action='END'");
		$end = mysqli_fetch_assoc($qry_count_end);

		
		if($seq['nos']==$end['nos']){
			$now = date("Y-m-d H:i:s");
			
			//get transaction type

			$get_tt = mysqli_query($connection,"select transaction_type,total_office_time from tbl_document where barcode='$barcode'");
			$tt = mysqli_fetch_assoc($get_tt);

			$get_total_fix = mysqli_query($connection,"select timestampdiff(minute,recieve_date,'$now')total_office_time  from tbl_document where barcode='$barcode'");
			$fix = mysqli_fetch_assoc($get_total_fix);

			$get_time = mysqli_query($connection,"select sum(office_time)ot,sum(transit_time)tt from tbl_document_transaction where barcode='$barcode'");
			$gtime = mysqli_fetch_assoc($get_time);		


			$get_total = mysqli_query($connection,"select sum(office_time+transit_time)total_office_time,sum(office_time)tot,sum(transit_time)ttt  from tbl_document_transaction where barcode='$barcode'");
			$tt2 = mysqli_fetch_assoc($get_total);


			if($tt['transaction_type']=="SIMP"){
				//simple
				$qry_simp = mysqli_query($connection,"select days from tbl_transaction_type where id='SIMP'");
				$simp = mysqli_fetch_assoc($qry_simp);

				$calc = $simp['days']*1440;

				if($fix['total_office_time']>$calc){
					$transaction_status = "D";
				}
				else{
					$transaction_status = "O";
				}

			}
			else if($tt['transaction_type']=="COMP"){
				//complex
				$qry_comp = mysqli_query($connection,"select days from tbl_transaction_type where id='COMP'");
				$comp = mysqli_fetch_assoc($qry_comp);

				$calc = $comp['days']*1440;

				if($fix['total_office_time']>$calc){
					$transaction_status = "D";
				}
				else{
					$transaction_status = "O";
				}

			}
			else{
				//highly technical
				$qry_high = mysqli_query($connection,"select days from tbl_transaction_type where id='HIGH'");
				$high = mysqli_fetch_assoc($qry_high);

				$calc = $high['days']*1440;	

				if($fix['total_office_time']>$calc){
					$transaction_status = "D";
				}
				else{
					$transaction_status = "O";
				}
			}
			mysqli_query($connection,"update tbl_document set total_office_time='$gtime[ot]', total_transit_time='$gtime[tt]', transaction_end_date='$now', transaction_status='$transaction_status' where barcode='$barcode'");
			
		}


		$document_qry = mysqli_query($connection,"select * from tbl_document where barcode='$barcode' and status='1'");
		$document = mysqli_fetch_assoc($document_qry);
	
		$explode = explode(" ",$document['prerequisite']);
		$x=1;
		
		foreach($explode as $i =>$key) {
			$checkstatusdocs = mysqli_query($connection,"select * from tbl_document where barcode='$key' and status=1");
			if(mysqli_num_rows($checkstatusdocs) > 0) {
				$statusdoc=mysqli_fetch_assoc($checkstatusdocs);
				 
				$checkstatustrans = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$key' and route_office_code='$access[office_code]' and status='1' and current_action='REL'");
				$statusdoctrans=mysqli_fetch_assoc($checkstatustrans);
				if(mysqli_num_rows($checkstatustrans) > 0 ) { 
				 
					$transit_time = compute_minutes($statusdoctrans['release_date_time'],$wh);

					//update
					mysqli_query($connection,"update tbl_document_transaction set transit_date_time='$wh', transit_time='$transit_time', current_action='', status='0', rel_person='$access[full_name]' where barcode='$key' and route_office_code='$access[office_code]' and status='1'"); //herehre
					
					$qry_sequence = mysqli_query($connection,"select max(sequence)sq from tbl_document_transaction where barcode='$key'");
					$sequence = mysqli_fetch_assoc($qry_sequence);
						
					$qry_transit_time = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$key' and route_office_code='$access[office_code]' and current_action='' and status='0'");
					$transits_time = mysqli_fetch_assoc($qry_transit_time);
					$add_transit_time = get_total_transit_time($key)+$transits_time['transit_time'];
					
			
					//update doc transit time
					mysqli_query($connection,"update tbl_document set total_transit_time='$add_transit_time' where barcode='$key'");
			
					
					$sq = $sequence['sq']+1;
			
					$rcr = addslashes($_REQUEST['recieveaction']);
					$transaction_id = $transaction_id.$x;
					$insert = mysqli_query($connection,"insert into tbl_document_transaction values('$transaction_id','$key','$sq',NULL,'$access[office_code]','$access[full_name]','$wh','$rcr','','',NULL,'','','REC','0','0','1')");
					$x++;

					logs($access['username'],"$access[office_code] RECEIVED DOCUMENT $key.");
					//receive end
			
					$show_other_details = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$key' and current_action='REC' and status='1'");
					$doc_details = mysqli_fetch_assoc($show_other_details);
			
					$office_time = compute_minutes($doc_details['recieve_date_time'],$wh);
			
					$fr = addslashes($_REQUEST['finalremarks']);
					//note: if the user wants to activate transaction for processing change current_action='SMO' and remarks='' and status='1' 
					$wh = working_hours();
					//$office_time = compute_minutes($_REQUEST['recievedatetime'],$wh);
			
					mysqli_query($connection,"update tbl_document_transaction set release_date_time='$wh', current_action='END', remarks='$fr', rel_person='$access[full_name]', office_time='0', status='0' where barcode='$key' and office_code='$access[office_code]' and current_action='REC' and status='1'");
			
					$qry_count_sq = mysqli_query($connection,"select count(trans_id)nos from tbl_document_transaction where barcode='$key' and sequence='1'");
					$seq = mysqli_fetch_assoc($qry_count_sq);
			
					$qry_count_end = mysqli_query($connection,"select count(trans_id)nos from tbl_document_transaction where barcode='$key' and current_action='END'"); 	
					$end = mysqli_fetch_assoc($qry_count_end);
			
					
					if($seq['nos']==$end['nos']){
						$now = date("Y-m-d H:i:s");
						
						//get transaction type
			
						$get_tt = mysqli_query($connection,"select transaction_type,total_office_time from tbl_document where barcode='$key'");
						$tt = mysqli_fetch_assoc($get_tt);
			
						$get_total_fix = mysqli_query($connection,"select timestampdiff(minute,recieve_date,'$now')total_office_time  from tbl_document where barcode='$key'");
						$fix = mysqli_fetch_assoc($get_total_fix);
			
						$get_time = mysqli_query($connection,"select sum(office_time)ot,sum(transit_time)tt from tbl_document_transaction where barcode='$key'");
						$gtime = mysqli_fetch_assoc($get_time);		
			
			
						$get_total = mysqli_query($connection,"select sum(office_time+transit_time)total_office_time,sum(office_time)tot,sum(transit_time)ttt  from tbl_document_transaction where barcode='$key'");
						$tt2 = mysqli_fetch_assoc($get_total);
			
			
						if($tt['transaction_type']=="SIMP"){
							//simple
							$qry_simp = mysqli_query($connection,"select days from tbl_transaction_type where id='SIMP'");
							$simp = mysqli_fetch_assoc($qry_simp);
			
							$calc = $simp['days']*1440;
			
							if($fix['total_office_time']>$calc){
								$transaction_status = "D";
							}
							else{
								$transaction_status = "O";
							}
			
						}
						else if($tt['transaction_type']=="COMP"){
							//complex
							$qry_comp = mysqli_query($connection,"select days from tbl_transaction_type where id='COMP'");
							$comp = mysqli_fetch_assoc($qry_comp);
			
							$calc = $comp['days']*1440;
			
							if($fix['total_office_time']>$calc){
								$transaction_status = "D";
							}
							else{
								$transaction_status = "O";
							}
			
						}
						else{
							//highly technical
							$qry_high = mysqli_query($connection,"select days from tbl_transaction_type where id='HIGH'");
							$high = mysqli_fetch_assoc($qry_high);
			
							$calc = $high['days']*1440;	
			
							if($fix['total_office_time']>$calc){
								$transaction_status = "D";
							}
							else{
								$transaction_status = "O";
							}
						}
			
						//include highly technical
						
						mysqli_query($connection,"update tbl_document set total_office_time='$gtime[ot]', total_transit_time='$gtime[tt]', transaction_end_date='$now', transaction_status='$transaction_status' where barcode='$key'");
					
					}
			}	
		}
	}


		?>	
			<script type="text/javascript">
				alert("Transaction Ended.");
				window.location = "home.php?menu=transact";
			</script> 
		<?php
	}
	else{
		?>	
			<script type="text/javascript">
				alert("User Authetication Error.");
				window.location = "home.php?menu=transact";
			</script> 
		<?php
	}
}


?>