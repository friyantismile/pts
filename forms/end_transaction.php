<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
		$show_doc = mysqli_query($connection,"select * from tbl_document where barcode='$_REQUEST[barcode]'");
		$doc= mysqli_fetch_assoc($show_doc);

		if($doc['transaction_type']=='SIMP'){
			$ttype = "Simple";
		}
		else{
			$ttype = "Complex";
		}

		if($doc['source_type']=='INT'){
			$stype = "Internal";
		}
		else{
			$stype = "External";
		}

		$qry_doc_type = mysqli_query($connection,"select * from tbl_document_type where document_code='$doc[document_type]'");
		$doc_type = mysqli_fetch_assoc($qry_doc_type);	

		$show_other_details = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$_REQUEST[barcode]' and current_action='REC' and status='1'");
		$doc_details = mysqli_fetch_assoc($show_other_details);
	?>
	
		<div class="transact-end">
			<form action="" method="post">
				<div class="release-lable">
					<h4>End Document Transaction</h4>
				</div>
				<div class="form-group form-inline form-space-label form-space" style="clear: both">
					<div class="form-label" style="width:164px;">Barcode</div>
					<div class="form-label" style="width:175px;">Transaction Type</div>
					<div class="form-label" style="width:160px;">Document Type</div>
				</div>
				<div class="form-group form-inline release-form">
					<input type="hidden" value="<?php echo $doc_details['recieve_date_time'];?>" name="recievedatetime" id="recievedatetime">
					<input type="text" style="width: 160px;" class="form-control" value="<?php echo $doc['barcode'];?>" name="barcode" id="barcode" placeholder="Barcode" readonly="readonly">
					<input type="text" style="width: 170px;" class="form-control" value="<?php echo $ttype;?>" name="" id="" placeholder="Transaction Type" readonly="readonly">
					<input type="text" style="width: 170px;" class="form-control" value="<?php echo $doc_type['document_type']?>" name="" id="" placeholder="Document Type" readonly="readonly">
				</div>
				<div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:164px;">Source Type</div>
					<div class="form-label" style="width:175px;">Source Name</div>
					<div class="form-label" style="width:160px;">Office</div>
				</div>
				<div class="form-group form-inline form-space">
					<input type="text" style="width: 160px;" class="form-control" value="<?php echo $stype;?>" name="" id="" placeholder="Source Type" readonly="readonly">
					<input type="text" style="width: 170px;" class="form-control" value="<?php echo $doc['source_name']?>" name="" id="" placeholder="Source Name" readonly="readonly">
					<input type="text" style="width: 170px;" class="form-control" value="<?php echo $doc['office_code'];?>" name="" id="" placeholder="Office" readonly="readonly">
				</div>
				<div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:174px;">Communication Summary</div>
				</div>
				<div class="form-group form-space">
					<textarea class="form-control" readonly="readonly" placeholder="Communication Summary"><?php echo $doc['subject_matter'];?></textarea>
				</div>
				<div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:174px;">Final Remarks</div>
				</div>
				<div class="form-group form-space">
					<input type="text" class="form-control" name="finalremarks" id="finalremarks" placeholder="Final Remarks" required="required">
				</div>
				<div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:174px;">Password</div>
				</div>
				<div class="form-group form-space">
					<input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Password to Confirm Action" required="required">
				</div>
				<div class="form-group form-space form-inline">
						<?php 
						//Modification
						//Modified by : Yants
						//Modified date : 05/1/2019
						//Description : approved button display only if office code ADM and CMO
							if(!$doc['is_approved'] && ($doc['to_ocm'] == 1 || $doc['to_ocm'] == 0) &&  ($access['office_code']== 'ADM' || $access['office_code']=='CMO')) { 
								$show_doc_trans = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$_REQUEST[barcode]' and 	sequence=0");
				
								$show_doc_tr = mysqli_fetch_assoc($show_doc_trans);
								if($show_doc_tr['route_office_code']==$access['office_code']){
									?>
				        	<button type="submit" class="btn btn-primary" value="approve" name="approve" id="end">Approve Transaction</button>
								
							<?php } else { ?>
								<button type="submit" class="btn btn-primary" value="end" name="end" id="end" style="">End Transaction</button>
					
							<?php }
						} else { ?>
									<button type="submit" class="btn btn-primary" value="end" name="end" id="end" style="">End Transaction</button>
					
							<?php } ?>


							
		        	 
		        </div>
		    </form>
		</div>
	
</body>
</html>
<?php
	include("../functions/time_functions.php");

	if(isset($_REQUEST['end'])){
		//check password

		$pss = md5($_REQUEST['confirmpassword']);

		$qry_check = mysqli_query($connection,"select * from tbl_users where username='$access[username]' and password='$pss' and office_code='$access[office_code]'");

		if(mysqli_num_rows($qry_check)>=1){
			$fr = addslashes($_REQUEST['finalremarks']);
			//note: if the user wants to activate transaction for processing change current_action='REC' and remarks='' and status='1' 
			$wh = working_hours();
			$office_time = compute_minutes($_REQUEST['recievedatetime'],$wh);

			mysqli_query($connection,"update tbl_document_transaction set release_date_time='$wh', rel_person='$access[full_name]',current_action='END', remarks='$fr', office_time='$office_time', status='0' where barcode='$_REQUEST[barcode]' and office_code='$access[office_code]' and current_action='REC' and status='1'");

			$qry_count_sq = mysqli_query($connection,"select count(trans_id)nos from tbl_document_transaction where barcode='$_REQUEST[barcode]' and sequence='1'");
			$seq = mysqli_fetch_assoc($qry_count_sq);

			$qry_count_end = mysqli_query($connection,"select count(trans_id)nos from tbl_document_transaction where barcode='$_REQUEST[barcode]' and current_action='END'");
			$end = mysqli_fetch_assoc($qry_count_end);

			$document_qry = mysqli_query($connection,"select * from tbl_document where barcode='$_REQUEST[barcode]' and status='1' and transaction_status=''");
			$document = mysqli_fetch_assoc($document_qry);

			if($seq['nos']==$end['nos']){
				$now = date("Y-m-d H:i:s");
				//get transaction type

				$get_total_fix = mysqli_query($connection,"select timestampdiff(minute,recieve_date,'$now')total_office_time  from tbl_document where barcode='$_REQUEST[barcode]'");
				$fix = mysqli_fetch_assoc($get_total_fix);

				$get_time = mysqli_query($connection,"select sum(office_time)ot,sum(transit_time)tt from tbl_document_transaction where barcode='$_REQUEST[barcode]'");
				$gtime = mysqli_fetch_assoc($get_time);				

				$get_tt = mysqli_query($connection,"select transaction_type,total_office_time from tbl_document where barcode='$_REQUEST[barcode]'");
				$tt = mysqli_fetch_assoc($get_tt);

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
					//high
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
				mysqli_query($connection,"update tbl_document set total_office_time='$gtime[ot]', total_transit_time='$gtime[tt]', transaction_end_date='$now', transaction_status='$transaction_status' where barcode='$_REQUEST[barcode]'");
			}

			$explode = explode(" ",$document['prerequisite']);
			$x=1;
			foreach($explode as $i =>$key) {
				$checkstatusdocs = mysqli_query($connection,"select * from tbl_document where barcode='$key' and status=1");
				if(mysqli_num_rows($checkstatusdocs) > 0) {
					$statusdoc=mysqli_fetch_assoc($checkstatusdocs);
	
					$checkstatustrans = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$key' and office_code='$access[office_code]' and status='1' and current_action='REC'");
					$statusdoctrans=mysqli_fetch_assoc($checkstatustrans);
					if(mysqli_num_rows($checkstatustrans) > 0 ) { 
						
						$transreceivedateqry = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$key' and status='1' and current_action='REC'");
						$transreceivedate=mysqli_fetch_assoc($transreceivedateqry);
						$office_time = compute_minutes($transreceivedate['recieve_date_time'],$wh);

					 	$fr = "Ended by receiving <a href=home.php?menu=viewdocument&barcode=";
						$fr = $fr.$document['barcode']." target=_blank>".$document['barcode']."</a>";
						mysqli_query($connection,"update tbl_document_transaction set release_date_time='$wh', current_action='END', remarks='$fr', office_time='$office_time', status='0' where barcode='$key' and office_code='$access[office_code]' and current_action='REC' and status='1'");

						$qry_count_sq = mysqli_query($connection,"select count(trans_id)nos from tbl_document_transaction where barcode='$key' and sequence='1'");
						$seq = mysqli_fetch_assoc($qry_count_sq);

						$qry_count_end = mysqli_query($connection,"select count(trans_id)nos from tbl_document_transaction where barcode='$key' and current_action='END'");
						$end = mysqli_fetch_assoc($qry_count_end);

						//echo "---------------".$seq['nos'].'----------------------------'.$end['nos'].'========================';
						if($seq['nos']==$end['nos']){
						 
							$now = date("Y-m-d H:i:s");
							//get transaction type

							$get_total_fix = mysqli_query($connection,"select timestampdiff(minute,recieve_date,'$now')total_office_time  from tbl_document where barcode='$key'");
							$fix = mysqli_fetch_assoc($get_total_fix);

							$get_time = mysqli_query($connection,"select sum(office_time)ot,sum(transit_time)tt from tbl_document_transaction where barcode='$key'");
							$gtime = mysqli_fetch_assoc($get_time);				

							$get_tt = mysqli_query($connection,"select transaction_type,total_office_time from tbl_document where barcode='$key'");
							$tt = mysqli_fetch_assoc($get_tt);

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
								//high
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


	if(isset($_REQUEST['approve'])){
		//check password

		$pss = md5($_REQUEST['confirmpassword']);

		$qry_check = mysqli_query($connection,"select * from tbl_users where username='$access[username]' and password='$pss' and office_code='$access[office_code]'");

		if(mysqli_num_rows($qry_check)>=1){
			$barcode = mysqli_real_escape_string($connection, $_REQUEST['barcode']);
	
			$qry_search_release = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$barcode' and office_code='$access[office_code]' and current_action='REC' and status='1'");
			$rel = mysqli_fetch_assoc($qry_search_release);

			
			$wh = working_hours();
		
			$office_time = compute_minutes($rel['recieve_date_time'],$wh);
		
			$ra = "Has been approved";
			$rr = addslashes($_REQUEST['finalremarks']);
			//update document
			$add_office_time = get_total_office_time($_REQUEST['barcode'])+$office_time;
		
			mysqli_query($connection,"update tbl_document set is_approved=1, total_office_time='$add_office_time' where barcode='$barcode'");
		
			//update 
			mysqli_query($connection,"update tbl_document_transaction set sequence=0, route_office_code='SMO', release_date_time='$wh', release_action='$ra', remarks='$rr', rel_person='$access[full_name]', current_action='REL', office_time='$office_time' where barcode='$barcode' and office_code='$access[office_code]' and current_action='REC' and status='1'");
		

			$document_qry = mysqli_query($connection,"select * from tbl_document where barcode='$barcode' and status='1'");
			$document = mysqli_fetch_assoc($document_qry);
		
			$explode = explode(" ",$document['prerequisite']);
			foreach($explode as $i =>$key) {
				$checkstatusdocs = mysqli_query($connection,"select * from tbl_document where barcode='$key' and status=1 and is_approved=0 and to_ocm=$document[to_ocm]");
				if(mysqli_num_rows($checkstatusdocs) > 0) {

					$qry_search_release = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$key' and office_code='$access[office_code]' and current_action='REC' and status='1'");
					$rel = mysqli_fetch_assoc($qry_search_release);
					$office_time = compute_minutes($rel['recieve_date_time'],$wh);

					$add_office_time = get_total_office_time($key)+$office_time;
					mysqli_query($connection,"update tbl_document set is_approved=1, total_office_time='$add_office_time' where barcode='$key'");
		
					mysqli_query($connection,"update tbl_document_transaction set sequence=0, route_office_code='SMO', release_date_time='$wh', release_action='$ra', remarks='$rr', rel_person='$access[full_name]', current_action='REL', office_time='$office_time' where barcode='$key' and office_code='$access[office_code]' and current_action='REC' and status='1'");
	
				}
			}
		


			logs($access['username'],"$access[office_code] RELEASED DOCUMENT $_REQUEST[barcode] TO SMO.");
		
			?>	
				<script type="text/javascript">
					alert("Has been approved");
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