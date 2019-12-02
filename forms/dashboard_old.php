<!DOCTYPE html>
<html>
<head>
	<title></title>

	<script type="text/javascript">
		function showDiv(){
			var selectBox = document.getElementById("type");

			if(selectBox.value == "simple"){
		    	document.getElementById('simple').style.display = "block";
		    	document.getElementById('complex').style.display = "none";
		    	document.getElementById('high').style.display = "none";
			}
			else if(selectBox.value == "complex"){
				document.getElementById('simple').style.display = "none";
		    	document.getElementById('complex').style.display = "block";
		    	document.getElementById('high').style.display = "none";
			}
			else{
				document.getElementById('simple').style.display = "none";
		    	document.getElementById('complex').style.display = "none";
		    	document.getElementById('high').style.display = "block";
			}
		}
	</script>
</head>
<body>
	
	<?php
		include("../functions/time_functions.php");
		
		$qry_wh = mysqli_query($connection,"select timestampdiff(minute,time_start,time_end)as working_minutes from tbl_working_hours");
		$wh = mysqli_fetch_assoc($qry_wh);

		//working hours in a day
		$qry_day = mysqli_query($connection,"select timestampdiff(minute,time_start,time_end)min from tbl_working_hours");
		$day = mysqli_fetch_assoc($qry_day);

		$qry_comp = mysqli_query($connection,"select days from tbl_transaction_type where id='COMP'");
		$complex = mysqli_fetch_assoc($qry_comp);

		$qry_simp = mysqli_query($connection,"select days from tbl_transaction_type where id='SIMP'");
		$simple = mysqli_fetch_assoc($qry_simp);

		$qry_high = mysqli_query($connection,"select days from tbl_transaction_type where id='HIGH'");
		$high = mysqli_fetch_assoc($qry_high);

		$complex_minutes = $wh['working_minutes']*$complex['days'];
		$simple_minutes = $wh['working_minutes']*$simple['days'];
		$high_minutes = $wh['working_minutes']*$high['days'];
	?>
	<div class="container-notifications" > <!-- Remove style=display:none if calibration is activated -->
		<?php
			
			//--------------------------------------------------------------
			$now = date("Y-m-d H:i:s");
			$currentMonth = date("Y-m");

			if($access['access_level']=="A" || $access['access_level']=="R"){
				$officeLimit = '';
			}
			else{
				$officeLimit = "and office_code='$access[office_code]'";
			}


			$dnow = date("Y-m-d");

			//--------------simple--------------
			$qryForPop = mysqli_query($connection,"select *,timestampdiff(minute,end_date,'$now')indicator from tbl_document where transaction_end_date='0000-00-00' and recieve_date like '$current_month%' and status!='0' and timestampdiff(minute,end_date,'$now')>=1"); 

			for($a=1;$a<=mysqli_num_rows($qryForPop);$a++){
				$rows = mysqli_fetch_assoc($qryForPop);

				// $qryDetailsPop = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$rows[barcode]' and current_action='REC' order by sequence desc limit 1");
				$qryDetailsPop = mysqli_query($connection,"select *,TIMESTAMPDIFF(day,recieve_date_time,'$now')time_day,TIMESTAMPDIFF(hour,recieve_date_time,'$now')time_hour,TIMESTAMPDIFF(minute,recieve_date_time,'$now')time_min from tbl_document_transaction where barcode='$rows[barcode]' and current_action='REC' $officeLimit order by sequence desc limit 1");

				$details = mysqli_fetch_assoc($qryDetailsPop);
				if($details['time_day']==0){

					if($details['time_hour']==0){
						if($details['time_min']>1){
							$duration = $details['time_min'].' minutes ';	
						}
						else{
							$duration = $details['time_min'].' minute';		
						}
						
					}
					else{
						if($details['time_hour']>1){
							$duration = $details['time_hour'].' hours';		
						}
						else{
							$duration = $details['time_hour'].' hour';		
						}
					}

					
				}
				else{
					if($details['time_day']>1){
						$duration = $details['time_day'].' days';
					}
					else{
						$duration = $details['time_day'].' day';	
					}
				}

				if(mysqli_num_rows($qryDetailsPop)==0){
					//no display
				}
				else{
					echo "<div class='notifications' id='notifications$a'>";
					//echo "<a href='home.php?menu=viewdocument&barcode=$rows[barcode]' style='color:#ffffff;' target='_blank'>&nbsp;Document $rows[barcode] currently at $details[office_code] for $duration</a>";
					echo "<a href='home.php?menu=viewdocument&barcode=$rows[barcode]' style='color:#ffffff;' target='_blank'>&nbsp;Document $rows[barcode] is beyond the prescribed time.</a>";
					?>	
			 			<span class="close" onclick="closefunc('notifications<?php echo $a;?>','close<?php echo $a;?>')">&times</span>
			 		<?php
			 		echo "</div>";
				}	

			}

			

		?>
	</div>
	<script>
		function closefunc(nt,cl){
			var notify = document.getElementById(nt);
			var span = document.getElementsByName(cl);
			
			notify.style.display = "none";
		}
	</script>

	<div class="container-date-selector" style="">
		<form method="post" action="home.php?menu=dashboard&report=othermonth">
			<div class="form-group form-inline">
				Dashboard Report : 
				<select class="form-control" style="width:130px;" name="month">
					<?php
					if($_REQUEST['report']=='othermonth'){
						$qry = mysqli_query($connection,"select * from tbl_months where value='$_REQUEST[month]'");
						$mnth = mysqli_fetch_assoc($qry);

						echo "<option value='$mnth[value]'>$mnth[month]</option>";

						$qry_months = mysqli_query($connection,"select * from tbl_months where value!='$_REQUEST[month]'");
						for($a=1;$a<=mysqli_num_rows($qry_months);$a++){
							$mnths = mysqli_fetch_assoc($qry_months);
							echo "<option value='$mnths[value]'>$mnths[month]</option>";

						}
					}
					else{
						
						?>
						<option value="<?php echo date("m");?>"><?php echo date("F");?></option>							
					 	<?php
					 	$qry_mon = mysqli_query($connection,"select * from tbl_months");
						for($a=1;$a<=mysqli_num_rows($qry_mon);$a++){
							$mon = mysqli_fetch_assoc($qry_mon);
							if(date("m")==$a){

							}
							else{
								echo "<option value='$mon[value]'>$mon[month]</option>";
							}
						}
					}
					?>
					
					
			 	</select>
				<input class="form-control" type="text" style="width:60px;" name="year" maxlength="4" value="<?php echo date("Y");?>">
				<button type="submit" class="btn btn-primary" value="Login" name="login">Generate</button>
			</div>
		</form>
	</div> 
	<?php
	// function delinquent($dte){
	// 	include("../database/database_connection.php");
	// 	$current_month = date($dte);

	// 	$qry_del = mysqli_query($connection,"select *,count(a.office_code)as no_of_del from tbl_document_transaction a, tbl_document b, tbl_office c, tbl_office_performance d where a.barcode=b.barcode and a.office_code=c.office_code and a.office_code=d.office_code and d.document_code=b.document_type and a.office_time>d.office_time and a.recieve_date_time like '$current_month-%' group by a.office_code  having count(a.office_code)>1 order by count(a.office_code)desc");
	// 	$total = 0;
	// 	for($a=1;$a<=mysqli_num_rows($qry_del);$a++){
	// 		$rows = mysqli_fetch_assoc($qry_del);
	// 		$total += $rows['no_of_del'];
	// 	}
	// 	echo $total;
	// }

	function count_gender($gender,$date){
		include("../database/database_connection.php");
		$qry = mysqli_query($connection,"select * from tbl_document where gender='$gender' and status='1'  and recieve_date like '$date%'");
		echo mysqli_num_rows($qry);

	}

	if($_REQUEST['report']=="thismonth"){

		$dtefrm = date("Y-m-")."1";
		$cur_ym = date("Y-m-");

		$monthnow = date("m");
		if($monthnow=='02'){
			$maxtodd = 29;
		}
		else if($monthnow=='01'||$monthnow=='03'||$monthnow=='05'||$monthnow=='07'||$monthnow=='08'||$monthnow=='10'||$monthnow=='12'){
			$maxtodd = 31;
		}
		else{
			$maxtodd = 30;
		}

		$dteto = date("Y-m-").$maxtodd;

		//total number of documents
		$qry_total_doc = mysqli_query($connection,"select count(id)result from tbl_document where status!='0' and recieve_date like '$cur_ym%'");
		$total_doc = mysqli_fetch_assoc($qry_total_doc); //verified

		$qry_total_ontime_simp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='O' and transaction_type='SIMP' and status!='0' and recieve_date like '$cur_ym%'");
		$total_ontime_simp = mysqli_fetch_assoc($qry_total_ontime_simp);

		$qry_total_ontime_comp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='O' and transaction_type='COMP' and status!='0' and recieve_date like '$cur_ym%'");
		$total_ontime_comp = mysqli_fetch_assoc($qry_total_ontime_comp);

		$qry_total_ontime_high = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='O' and transaction_type='HIGH' and status!='0' and recieve_date like '$cur_ym%'");
		$total_ontime_high = mysqli_fetch_assoc($qry_total_ontime_high);


		$qry_total_ongoing_simp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='' and transaction_type='SIMP' and status!='0' and recieve_date like '$cur_ym%'");
		$total_ongoing_simp = mysqli_fetch_assoc($qry_total_ongoing_simp);

		$qry_total_ongoing_comp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='' and transaction_type='COMP' and status!='0' and recieve_date like '$cur_ym%'");
		$total_ongoing_comp = mysqli_fetch_assoc($qry_total_ongoing_comp);

		$qry_total_ongoing_high = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='' and transaction_type='HIGH' and status!='0' and recieve_date like '$cur_ym%'");
		$total_ongoing_high = mysqli_fetch_assoc($qry_total_ongoing_high);


		$qry_total_delayed_simp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='D' and transaction_type='SIMP' and status!='0' and recieve_date like '$cur_ym%'");
		$total_delayed_simp = mysqli_fetch_assoc($qry_total_delayed_simp);

		$qry_total_delayed_comp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='D' and transaction_type='COMP' and status!='0' and recieve_date like '$cur_ym%'");
		$total_delayed_comp = mysqli_fetch_assoc($qry_total_delayed_comp);

		$qry_total_delayed_high = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='D' and transaction_type='HIGH' and status!='0' and recieve_date like '$cur_ym%'");
		$total_delayed_high = mysqli_fetch_assoc($qry_total_delayed_high);




		// simple
		$qry_po_simp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$cur_ym%' and transaction_status!='' and document_type='PO' and transaction_type='SIMP'");
		$qry_po_simp = mysqli_fetch_assoc($qry_po_simp);

		$qry_pr_simp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$cur_ym%' and transaction_status!='' and document_type='PR' and transaction_type='SIMP'");
		$qry_pr_simp = mysqli_fetch_assoc($qry_pr_simp);

		$qry_vc_simp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$cur_ym%' and transaction_status!='' and document_type='VC' and transaction_type='SIMP'");
		$qry_vc_simp = mysqli_fetch_assoc($qry_vc_simp);

		$qry_py_simp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$cur_ym%' and transaction_status!='' and document_type='PY' and transaction_type='SIMP'");
		$qry_py_simp = mysqli_fetch_assoc($qry_py_simp);

		$qry_com_simp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$cur_ym%' and transaction_status!='' and document_type='COM' and transaction_type='SIMP'");
		$qry_com_simp = mysqli_fetch_assoc($qry_com_simp);

		$qry_aoc_simp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$cur_ym%' and transaction_status!='' and document_type='AOC' and transaction_type='SIMP'");
		$qry_aoc_simp = mysqli_fetch_assoc($qry_aoc_simp);


		// complex
		$qry_po_comp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$cur_ym%' and transaction_status!='' and document_type='PO' and transaction_type='COMP'");
		$qry_po_comp = mysqli_fetch_assoc($qry_po_comp);

		$qry_pr_comp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$cur_ym%' and transaction_status!='' and document_type='PR' and transaction_type='COMP'");
		$qry_pr_comp = mysqli_fetch_assoc($qry_pr_comp);

		$qry_vc_comp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$cur_ym%' and transaction_status!='' and document_type='VC' and transaction_type='COMP'");
		$qry_vc_comp = mysqli_fetch_assoc($qry_vc_comp);

		$qry_py_comp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$cur_ym%' and transaction_status!='' and document_type='PY' and transaction_type='COMP'");
		$qry_py_comp = mysqli_fetch_assoc($qry_py_comp);

		$qry_com_comp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$cur_ym%' and transaction_status!='' and document_type='COM' and transaction_type='COMP'");
		$qry_com_comp = mysqli_fetch_assoc($qry_com_comp);

		$qry_aoc_comp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$cur_ym%' and transaction_status!='' and document_type='AOC' and transaction_type='COMP'");
		$qry_aoc_comp = mysqli_fetch_assoc($qry_aoc_comp);



		// highly technical
		$qry_po_high = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$cur_ym%' and transaction_status!='' and document_type='PO' and transaction_type='HIGH'");
		$qry_po_high = mysqli_fetch_assoc($qry_po_high);

		$qry_pr_high = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$cur_ym%' and transaction_status!='' and document_type='PR' and transaction_type='HIGH'");
		$qry_pr_high = mysqli_fetch_assoc($qry_pr_high);

		$qry_vc_high = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$cur_ym%' and transaction_status!='' and document_type='VC' and transaction_type='HIGH'");
		$qry_vc_high = mysqli_fetch_assoc($qry_vc_high);

		$qry_py_high = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$cur_ym%' and transaction_status!='' and document_type='PY' and transaction_type='HIGH'");
		$qry_py_high = mysqli_fetch_assoc($qry_py_high);

		$qry_com_high = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$cur_ym%' and transaction_status!='' and document_type='COM' and transaction_type='HIGH'");
		$qry_com_high = mysqli_fetch_assoc($qry_com_high);

		$qry_aoc_high = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$cur_ym%' and transaction_status!='' and document_type='AOC' and transaction_type='HIGH'");
		$qry_aoc_high = mysqli_fetch_assoc($qry_aoc_high);


		//external_clients
		$qry_external_client = mysqli_query($connection,"select count(id)ext from tbl_document where source_type='EXT' and status!=0 and recieve_date like '$cur_ym%'");
		$external_client = mysqli_fetch_assoc($qry_external_client);

		//internal
		$qry_internal_client = mysqli_query($connection,"select count(id)ints from tbl_document where source_type='INT' and status!=0 and recieve_date like '$cur_ym%'");
		$internal_client = mysqli_fetch_assoc($qry_internal_client);

		//ave transit time
		$qry_transit_time = mysqli_query($connection,"select avg(transit_time) from tbl_document_transaction where transit_date_time like 'cur_ym%'");
		$ave_transit_time = mysqli_fetch_assoc($qry_transit_time);

		//plus 1 
		// $plus = (date('d')+1);
		// if($plus<=31){
		// 	$todate = $plus;
		// }
		// else{
		// 	$todate = 31;	
		// }

		
	?>
	<br>
	<div class="new-container-dashboard">
		<div style="float: left; padding-right: 10px; width: 200px;">
			<div class="head-dash-blue">ON-TIME</div>
			<div class="sub-head-dash-blue">DOCUMENTS</div>
			<div class="title-dash">SIMPLE</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo date('Y');?>&frommm=<?php echo date('m');?>&fromdd=01&toyyyy=<?php echo date('Y');?>&tomm=<?php echo date('m');?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&totalontime&transactiontype=SIMP" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php 
						echo number_format($total_ontime_simp['result']);
					?>
				</div>
			</a>
			<div class="title-dash">COMPLEX</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo date('Y');?>&frommm=<?php echo date('m');?>&fromdd=01&toyyyy=<?php echo date('Y');?>&tomm=<?php echo date('m');?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&totalontime&transactiontype=COMP" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php 
						echo number_format($total_ontime_comp['result']);
					?>
				</div>
			</a>
			<div class="title-dash">HIGHLY TECHNICAL</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo date('Y');?>&frommm=<?php echo date('m');?>&fromdd=01&toyyyy=<?php echo date('Y');?>&tomm=<?php echo date('m');?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&totalontime&transactiontype=HIGH" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php 
						echo number_format($total_ontime_high['result']);
					?>
				</div>
			</a>
		</div>

		<div style="float: left; padding-right: 10px; width: 200px;">
			<div class="head-dash-blue">ON-GOING</div>
			<div class="sub-head-dash-blue">DOCUMENTS</div>
			<div class="title-dash">SIMPLE</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo date('Y');?>&frommm=<?php echo date('m');?>&fromdd=01&toyyyy=<?php echo date('Y');?>&tomm=<?php echo date('m');?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&totalongoing&transactiontype=SIMP" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php 
						echo number_format($total_ongoing_simp['result']); //verified sourcetype
					?>
				</div>
			</a>
			<div class="title-dash">COMPLEX</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo date('Y');?>&frommm=<?php echo date('m');?>&fromdd=01&toyyyy=<?php echo date('Y');?>&tomm=<?php echo date('m');?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&totalongoing&transactiontype=COMP" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php 
						echo number_format($total_ongoing_comp['result']); //verified sourcetype
					?>
				</div>
			</a>
			<div class="title-dash">HIGHLY TECHNICAL</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo date('Y');?>&frommm=<?php echo date('m');?>&fromdd=01&toyyyy=<?php echo date('Y');?>&tomm=<?php echo date('m');?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&totalongoing&transactiontype=HIGH" target="_blank" style="text-decoration: none;">
				
				<div class="figure-dash">
					<?php 
						echo number_format($total_ongoing_high['result']); //verified sourcetype
					?>
				</div>
			</a>
		</div>

		<div style="float: left; padding-right: 10px; width: 200px;">
			<div class="head-dash-blue">DELAYED</div>
			<div class="sub-head-dash-blue">DOCUMENTS</div>
			<div class="title-dash">SIMPLE</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo date('Y');?>&frommm=<?php echo date('m');?>&fromdd=01&toyyyy=<?php echo date('Y');?>&tomm=<?php echo date('m');?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&transactiontype=SIMP&totaldelayed" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php
						echo number_format($total_delayed_simp['result']);  //verified
					?>
				</div>
			</a>
			<div class="title-dash">COMPLEX</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo date('Y');?>&frommm=<?php echo date('m');?>&fromdd=01&toyyyy=<?php echo date('Y');?>&tomm=<?php echo date('m');?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&transactiontype=COMP&totaldelayed" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php
						echo number_format($total_delayed_comp['result']);  //verified
					?>
				</div>
			</a>
			<div class="title-dash">HIGHLY TECHNICAL</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo date('Y');?>&frommm=<?php echo date('m');?>&fromdd=01&toyyyy=<?php echo date('Y');?>&tomm=<?php echo date('m');?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&transactiontype=HIGH&totaldelayed" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php
						echo number_format($total_delayed_high['result']);  //verified
					?>
				</div>
			</a>
		</div>

		<div style="float: left; padding-right: 10px; width: 200px;">
			<div class="head-dash-orange">FOR DUE</div>
			<div class="sub-head-dash-orange">TOMORROW</div>
			<div class="title-dash">NO. OF DOCUMENTS</div>
			<a href="../output/for_due.php?user=<?php echo $access['full_name'];?>" target="_blank" style="text-decoration: none;"> 
				<div class="figure-dash">
					<?php
						$datenow = date("Y-m-d");
						$date1 = str_replace('-', '/', $datenow);
						$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));

						$current = date("Y-m");
						$qry_for_due = mysqli_query($connection,"select count(id) as for_due from tbl_document where end_date like '$tomorrow%' and status!=0 and transaction_end_date='0000-00-00'");
						$nos = mysqli_fetch_assoc($qry_for_due);
						echo $nos['for_due'];
					?>
				</div>
			</a>
			<br>

			<div class="head-dash-red">DELINQUENT</div>
			<div class="sub-head-dash-red">TRANSACTIONS</div>
			<div class="title-dash">NO. OF TRANSACTIONS</div>
			<a href="../output/show_delinquencies.php?fromyyyy=<?php echo date('Y');?>&frommm=<?php echo date('m');?>&fromdd=01&toyyyy=<?php echo date('Y');?>&tomm=<?php echo date('m');?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>" target="_blank" style="text-decoration: none;"> 
				<div class="figure-dash">
					<?php
						$current = date("Y-m");

						$qry_office = mysqli_query($connection,"select *,count(a.office_code)as no_of_del from tbl_document_transaction a, tbl_document b, tbl_office c, tbl_office_performance d where a.barcode=b.barcode and a.office_code=c.office_code and a.office_code=d.office_code and d.document_code=b.document_type and a.office_time>d.office_time and a.recieve_date_time like '$current-%' group by a.office_code  having count(a.office_code)>=1 order by count(a.office_code)desc");
		
						$total = 0;

						for($a=1;$a<=mysqli_num_rows($qry_office);$a++){
							$rows = mysqli_fetch_assoc($qry_office);
				
							$total += $rows['no_of_del'];
						}

						echo $total;
					?>
				</div>
			</a>


		</div>

		<div style="float: left; padding-right: 10px; width: 200px;">
			<div class="head-dash-green">DOCUMENTS</div>
			<div class="sub-head-dash-green">MONTHLY</div>
			<div class="title-dash">NO. OF DOCUMENTS</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo date('Y');?>&frommm=<?php echo date('m');?>&fromdd=01&toyyyy=<?php echo date('Y');?>&tomm=<?php echo date('m');?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php
						echo number_format($total_doc['result']);  //verified 
					?>
				</div>
			</a>

			<br>

			<div class="head-dash-lgreen">TO-DO</div>
			<div class="sub-head-dash-lgreen">LIST</div>
			<div class="title-dash">NO. OF DOCUMENTS</div>
			<a href="../output/routed_to_office.php?office_code=<?php echo $access['office_code'];?>&user=<?php echo $access['full_name'];?>" target="_blank" style="text-decoration: none;"> 
				<div class="figure-dash">
					<?php
						$current = date("Y-m");

						$qry_office = mysqli_query($connection,"select count(a.barcode) as no_of_doc from tbl_document_transaction a, tbl_document b where a.route_office_code='$access[office_code]' and a.current_action='REL' and a.barcode=b.barcode");
		
						$total = 0;

						for($a=1;$a<=mysqli_num_rows($qry_office);$a++){
							$rows = mysqli_fetch_assoc($qry_office);
				
							$total += $rows['no_of_doc'];
						}

						echo $total;
					?>
				</div>
			</a>
		</div>

		<div style="float: left; padding-right: 10px; width: 200px;">
			<div class="head-dash-green">CLIENTS</div>
			<div class="sub-head-dash-green">SERVED</div>
			<div class="title-dash">EXTERNAL CLIENTS</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo date('Y');?>&frommm=<?php echo date('m');?>&fromdd=01&toyyyy=<?php echo date('Y');?>&tomm=<?php echo date('m');?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&sourcetype=EXT" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php
						echo $external_client['ext'];
					?>	
				</div>
			</a>
			<div class="title-dash">INTERNAL CLIENTS</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo date('Y');?>&frommm=<?php echo date('m');?>&fromdd=01&toyyyy=<?php echo date('Y');?>&tomm=<?php echo date('m');?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&sourcetype=INT" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php
						echo $internal_client['ints'];
					?>
				</div>
			</a>
		</div>

		
	</div>	
	<div class="dash-palaman" style="margin-bottom: -8px;">
		<select class="form-control" style="width: 200px; margin-left: -10px;" name="type" id="type" onchange="showDiv()">
			<option value="simple">Simple</option>
			<option value="complex">Complex</option>
			<option value="highly">Highly Technical</option>
		</select>
	</div>
	<div style="display: inline;" id="simple">
		<div class="new-container-dashboard">
			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">PURCHASE ORDER</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_po_simp['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">VOUCHER</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_vc_simp['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">PAYROLL</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_py_simp['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">COMMUNICATION</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_com_simp['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">PURCHASE REQUEST</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_pr_simp['result'],2).' days';
					?>
				</div>
			</div>
			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">ABSTRACT OF CANVASS</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_aoc_simp['result'],2).' days';
					?>
				</div>
			</div>
		</div>
	</div>
	<div style="display: none" id="complex">
		<div class="new-container-dashboard">
			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">PURCHASE ORDER</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_po_comp['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">VOUCHER</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_vc_comp['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">PAYROLL</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_py_comp['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">COMMUNICATION</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_com_comp['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">PURCHASE REQUEST</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_pr_comp['result'],2).' days';
					?>
				</div>
			</div>
			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">ABSTRACT OF CANVASS</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_aoc_comp['result'],2).' days';
					?>
				</div>
			</div>
		</div>
	</div>
	<div style="display: none;" id="high">
		<div class="new-container-dashboard">
			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">PURCHASE ORDER</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_po_high['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">VOUCHER</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_vc_high['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">PAYROLL</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_py_high['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">COMMUNICATION</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_com_high['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">PURCHASE REQUEST</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_pr_high['result'],2).' days';
					?>
				</div>
			</div>
			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">ABSTRACT OF CANVASS</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_aoc_high['result'],2).' days';
					?>
				</div>
			</div>
		</div>
	</div>
	<?php

	}
	else{
		$year = $_REQUEST['year'];
		$month = $_REQUEST['month'];

		$dtefrm = $year."-".$month."-1";

		$date_like = $year."-".$month."-%";

		$monthnow = $month;
		if($monthnow=='02'){
			$maxtodd = 29;
		}
		else if($monthnow=='01'||$monthnow=='03'||$monthnow=='05'||$monthnow=='07'||$monthnow=='08'||$monthnow=='10'||$monthnow=='12'){
			$maxtodd = 31;
		}
		else{
			$maxtodd = 30;
		}

		$dteto = $year."-".$month."-".$maxtodd;


		//total number of documents
		$qry_total_doc = mysqli_query($connection,"select count(id)result from tbl_document where status!='0' and recieve_date like '$date_like%'");
		$total_doc = mysqli_fetch_assoc($qry_total_doc); //verified

		$qry_total_ontime_simp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='O' and transaction_type='SIMP' and status!='0' and recieve_date like '$date_like%'");
		$total_ontime_simp = mysqli_fetch_assoc($qry_total_ontime_simp);

		$qry_total_ontime_comp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='O' and transaction_type='COMP' and status!='0' and recieve_date like '$date_like%'");
		$total_ontime_comp = mysqli_fetch_assoc($qry_total_ontime_comp);

		$qry_total_ontime_high = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='O' and transaction_type='HIGH' and status!='0' and recieve_date like '$date_like%'");
		$total_ontime_high = mysqli_fetch_assoc($qry_total_ontime_high);


		$qry_total_ongoing_simp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='' and transaction_type='SIMP' and status!='0' and recieve_date like '$date_like%'");
		$total_ongoing_simp = mysqli_fetch_assoc($qry_total_ongoing_simp);

		$qry_total_ongoing_comp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='' and transaction_type='COMP' and status!='0' and recieve_date like '$date_like%'");
		$total_ongoing_comp = mysqli_fetch_assoc($qry_total_ongoing_comp);

		$qry_total_ongoing_high = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='' and transaction_type='HIGH' and status!='0' and recieve_date like '$date_like%'");
		$total_ongoing_high = mysqli_fetch_assoc($qry_total_ongoing_high);


		$qry_total_delayed_simp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='D' and transaction_type='SIMP' and status!='0' and recieve_date like '$date_like%'");
		$total_delayed_simp = mysqli_fetch_assoc($qry_total_delayed_simp);

		$qry_total_delayed_comp = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='D' and transaction_type='COMP' and status!='0' and recieve_date like '$date_like%'");
		$total_delayed_comp = mysqli_fetch_assoc($qry_total_delayed_comp);

		$qry_total_delayed_high = mysqli_query($connection,"select count(id)result from tbl_document where transaction_status='D' and transaction_type='HIGH' and status!='0' and recieve_date like '$date_like%'");
		$total_delayed_high = mysqli_fetch_assoc($qry_total_delayed_high);




		// simple
		$qry_po_simp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$date_like%' and transaction_status!='' and document_type='PO' and transaction_type='SIMP'");
		$qry_po_simp = mysqli_fetch_assoc($qry_po_simp);

		$qry_pr_simp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$date_like%' and transaction_status!='' and document_type='PR' and transaction_type='SIMP'");
		$qry_pr_simp = mysqli_fetch_assoc($qry_pr_simp);

		$qry_vc_simp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$date_like%' and transaction_status!='' and document_type='VC' and transaction_type='SIMP'");
		$qry_vc_simp = mysqli_fetch_assoc($qry_vc_simp);

		$qry_py_simp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$date_like%' and transaction_status!='' and document_type='PY' and transaction_type='SIMP'");
		$qry_py_simp = mysqli_fetch_assoc($qry_py_simp);

		$qry_com_simp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$date_like%' and transaction_status!='' and document_type='COM' and transaction_type='SIMP'");
		$qry_com_simp = mysqli_fetch_assoc($qry_com_simp);

		$qry_aoc_simp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$date_like%' and transaction_status!='' and document_type='AOC' and transaction_type='SIMP'");
		$qry_aoc_simp = mysqli_fetch_assoc($qry_aoc_simp);


		// complex
		$qry_po_comp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$date_like%' and transaction_status!='' and document_type='PO' and transaction_type='COMP'");
		$qry_po_comp = mysqli_fetch_assoc($qry_po_comp);

		$qry_pr_comp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$date_like%' and transaction_status!='' and document_type='PR' and transaction_type='COMP'");
		$qry_pr_comp = mysqli_fetch_assoc($qry_pr_comp);

		$qry_vc_comp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$date_like%' and transaction_status!='' and document_type='VC' and transaction_type='COMP'");
		$qry_vc_comp = mysqli_fetch_assoc($qry_vc_comp);

		$qry_py_comp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$date_like%' and transaction_status!='' and document_type='PY' and transaction_type='COMP'");
		$qry_py_comp = mysqli_fetch_assoc($qry_py_comp);

		$qry_com_comp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$date_like%' and transaction_status!='' and document_type='COM' and transaction_type='COMP'");
		$qry_com_comp = mysqli_fetch_assoc($qry_com_comp);

		$qry_aoc_comp = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$date_like%' and transaction_status!='' and document_type='AOC' and transaction_type='COMP'");
		$qry_aoc_comp = mysqli_fetch_assoc($qry_aoc_comp);


		// highly technical
		$qry_po_high = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$date_like%' and transaction_status!='' and document_type='PO' and transaction_type='HIGH'");
		$qry_po_high = mysqli_fetch_assoc($qry_po_high);

		$qry_pr_high = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$date_like%' and transaction_status!='' and document_type='PR' and transaction_type='HIGH'");
		$qry_pr_high = mysqli_fetch_assoc($qry_pr_high);

		$qry_vc_high = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$date_like%' and transaction_status!='' and document_type='VC' and transaction_type='HIGH'");
		$qry_vc_high = mysqli_fetch_assoc($qry_vc_high);

		$qry_py_high = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$date_like%' and transaction_status!='' and document_type='PY' and transaction_type='HIGH'");
		$qry_py_high = mysqli_fetch_assoc($qry_py_high);

		$qry_com_high = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$date_like%' and transaction_status!='' and document_type='COM' and transaction_type='HIGH'");
		$qry_com_high = mysqli_fetch_assoc($qry_com_high);

		$qry_aoc_high = mysqli_query($connection,"select avg(timestampdiff(day,recieve_date,transaction_end_date))result from tbl_document where status!='0' and recieve_date like '$date_like%' and transaction_status!='' and document_type='AOC' and transaction_type='HIGH'");
		$qry_aoc_high = mysqli_fetch_assoc($qry_aoc_high);


		//external_clients
		$qry_external_client = mysqli_query($connection,"select count(id)ext from tbl_document where source_type='EXT' and status!=0 and recieve_date like '$date_like%'");
		$external_client = mysqli_fetch_assoc($qry_external_client);

		//internal
		$qry_internal_client = mysqli_query($connection,"select count(id)ints from tbl_document where source_type='INT' and status!=0 and recieve_date like '$date_like%'");
		$internal_client = mysqli_fetch_assoc($qry_internal_client);

		//ave transit time
		$qry_transit_time = mysqli_query($connection,"select avg(transit_time) from tbl_document_transaction where transit_date_time like 'date_like%'");
		$ave_transit_time = mysqli_fetch_assoc($qry_transit_time);


		//months
		if($month=='02'){
			$maxtodd = 29;
		}
		else if($month=='01'||$month=='03'||$month=='05'||$month=='07'||$month=='08'||$month=='10'||$month=='12'){
			$maxtodd = 31;
		}
		else{
			$maxtodd = 30;
		}
	?>

	<div class="new-container-dashboard">
		<div style="float: left; padding-right: 10px; width: 200px;">
			<div class="head-dash-blue">ON-TIME</div>
			<div class="sub-head-dash-blue">DOCUMENTS</div>
			<div class="title-dash">SIMPLE</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo $year;?>&frommm=<?php echo $month;?>&fromdd=01&toyyyy=<?php echo $year;?>&tomm=<?php echo $month;?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&totalontime&transactiontype=SIMP" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php 
						echo number_format($total_ontime_simp['result']);
					?>
				</div>
			</a>
			<div class="title-dash">COMPLEX</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo $year;?>&frommm=<?php echo $month;?>&fromdd=01&toyyyy=<?php echo $year;?>&tomm=<?php echo $month;?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&totalontime&transactiontype=COMP" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php 
						echo number_format($total_ontime_comp['result']);
					?>
				</div>
			</a>
			<div class="title-dash">HIGHLY TECHNICAL</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo $year;?>&frommm=<?php echo $month;?>&fromdd=01&toyyyy=<?php echo $year;?>&tomm=<?php echo $month;?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&totalontime&transactiontype=HIGH" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php 
						echo number_format($total_ontime_high['result']);
					?>
				</div>
			</a>
		</div>

		<div style="float: left; padding-right: 10px; width: 200px;">
			<div class="head-dash-blue">ON-GOING</div>
			<div class="sub-head-dash-blue">DOCUMENTS</div>
			<div class="title-dash">SIMPLE</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo $year;?>&frommm=<?php echo $month;?>&fromdd=01&toyyyy=<?php echo $year;?>&tomm=<?php echo $month;?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&totalongoing&transactiontype=SIMP" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php 
						echo number_format($total_ongoing_simp['result']); //verified sourcetype
					?>
				</div>
			</a>
			<div class="title-dash">COMPLEX</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo $year;?>&frommm=<?php echo $month;?>&fromdd=01&toyyyy=<?php echo $year;?>&tomm=<?php echo $month;?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&totalongoing&transactiontype=COMP" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php 
						echo number_format($total_ongoing_comp['result']); //verified sourcetype
					?>
				</div>
			</a>
			<div class="title-dash">HIGHLY TECHNICAL</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo $year;?>&frommm=<?php echo $month;?>&fromdd=01&toyyyy=<?php echo $year;?>&tomm=<?php echo $month;?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&totalongoing&transactiontype=HIGH" target="_blank" style="text-decoration: none;">
				
				<div class="figure-dash">
					<?php 
						echo number_format($total_ongoing_high['result']); //verified sourcetype
					?>
				</div>
			</a>
		</div>

		<div style="float: left; padding-right: 10px; width: 200px;">
			<div class="head-dash-blue">DELAYED</div>
			<div class="sub-head-dash-blue">DOCUMENTS</div>
			<div class="title-dash">SIMPLE</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo $year;?>&frommm=<?php echo $month;?>&fromdd=01&toyyyy=<?php echo $year;?>&tomm=<?php echo $month;?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&transactiontype=SIMP&totaldelayed" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php
						echo number_format($total_delayed_simp['result']);  //verified
					?>
				</div>
			</a>
			<div class="title-dash">COMPLEX</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo $year;?>&frommm=<?php echo $month;?>&fromdd=01&toyyyy=<?php echo $year;?>&tomm=<?php echo $month;?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&transactiontype=COMP&totaldelayed" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php
						echo number_format($total_delayed_comp['result']);  //verified
					?>
				</div>
			</a>
			<div class="title-dash">HIGHLY TECHNICAL</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo $year;?>&frommm=<?php echo $month;?>&fromdd=01&toyyyy=<?php echo $year;?>&tomm=<?php echo $month;?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&transactiontype=HIGH&totaldelayed" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php
						echo number_format($total_delayed_high['result']);  //verified
					?>
				</div>
			</a>
		</div>

		<div style="float: left; padding-right: 10px; width: 200px;">
			<!-- <div class="head-dash-orange">FOR DUE</div>
			<div class="sub-head-dash-orange">TODAY</div>
			<div class="title-dash">NO. OF DOCUMENTS</div>
			<a href="../output/for_due.php?user=<?php echo $access['full_name'];?>" target="_blank" style="text-decoration: none;"> 
				<div class="figure-dash">
					<?php
						// $datenow = date("Y-m-d");
						// $current = date("Y-m");
						// $qry_for_due = mysqli_query($connection,"select count(id) as for_due from tbl_document where end_date like '$datenow%' and status!=0 and transaction_end_date='0000-00-00'");
						// $nos = mysqli_fetch_assoc($qry_for_due);
						// echo $nos['for_due'];
					?>
				</div>
			</a>
			<br> -->

			<div class="head-dash-red">DELINQUENT</div>
			<div class="sub-head-dash-red">TRANSACTIONS</div>
			<div class="title-dash">NO. OF TRANSACTIONS</div>
			<a href="../output/show_delinquencies.php?fromyyyy=<?php echo $year;?>&frommm=<?php echo $month;?>&fromdd=01&toyyyy=<?php echo date('Y');?>&tomm=<?php echo $month;?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>" target="_blank" style="text-decoration: none;"> 
				<div class="figure-dash">
					<?php
						$current = date("Y-m");

						$qry_office = mysqli_query($connection,"select *,count(a.office_code)as no_of_del from tbl_document_transaction a, tbl_document b, tbl_office c, tbl_office_performance d where a.barcode=b.barcode and a.office_code=c.office_code and a.office_code=d.office_code and d.document_code=b.document_type and a.office_time>d.office_time and a.recieve_date_time like '$year-$month-%' group by a.office_code  having count(a.office_code)>=1 order by count(a.office_code)desc");
		
						$total = 0;

						for($a=1;$a<=mysqli_num_rows($qry_office);$a++){
							$rows = mysqli_fetch_assoc($qry_office);
				
							$total += $rows['no_of_del'];
						}

						echo $total;
					?>
				</div>
			</a>
		</div>

		

		<div style="float: left; padding-right: 10px; width: 200px;">
			<div class="head-dash-green">DOCUMENTS</div>
			<div class="sub-head-dash-green">MONTHLY</div>
			<div class="title-dash">NO. OF DOCUMENTS</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo $year;?>&frommm=<?php echo $month;?>&fromdd=01&toyyyy=<?php echo $year;?>&tomm=<?php echo $month;?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php
						echo number_format($total_doc['result']);  //verified 
					?>
				</div>
			</a>
		</div>

		<div style="float: left; padding-right: 10px; width: 200px;">
			<div class="head-dash-green">CLIENTS</div>
			<div class="sub-head-dash-green">SERVED</div>
			<div class="title-dash">EXTERNAL CLIENTS</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo $year;?>&frommm=<?php echo $month;?>&fromdd=01&toyyyy=<?php echo $year;?>&tomm=<?php echo $month;?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&sourcetype=EXT" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php
						echo $external_client['ext'];
					?>	
				</div>
			</a>
			<div class="title-dash">INTERNAL CLIENTS</div>
			<a href="../output/show_report.php?dashboard&reporttitle=Number of Documents&fromyyyy=<?php echo $year;?>&frommm=<?php echo $month;?>&fromdd=01&toyyyy=<?php echo $year;?>&tomm=<?php echo $month;?>&todd=<?php echo $maxtodd;?>&user=<?php echo $access['full_name'];?>&sourcetype=INT" target="_blank" style="text-decoration: none;">
				<div class="figure-dash">
					<?php
						echo $internal_client['ints'];
					?>
				</div>
			</a>
		</div>

	</div>	
	<div class="dash-palaman" style="margin-bottom: -8px;">
		<select class="form-control" style="width: 200px; margin-left: -10px;" name="type" id="type" onchange="showDiv()">
			<option value="simple">Simple</option>
			<option value="complex">Complex</option>
			<option value="highly">Highly Technical</option>
		</select>
	</div>
	<div style="display: inline;" id="simple">
		<div class="new-container-dashboard">
			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">PURCHASE ORDER</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_po_simp['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">VOUCHER</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_vc_simp['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">PAYROLL</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_py_simp['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">COMMUNICATION</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_com_simp['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">PURCHASE REQUEST</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_pr_simp['result'],2).' days';
					?>
				</div>
			</div>
			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">ABSTRACT OF CANVASS</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_aoc_simp['result'],2).' days';
					?>
				</div>
			</div>
		</div>
	</div>
	<div style="display: none" id="complex">
		<div class="new-container-dashboard">
			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">PURCHASE ORDER</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_po_comp['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">VOUCHER</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_vc_comp['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">PAYROLL</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_py_comp['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">COMMUNICATION</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_com_comp['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">PURCHASE REQUEST</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_pr_comp['result'],2).' days';
					?>
				</div>
			</div>
			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">ABSTRACT OF CANVASS</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_aoc_comp['result'],2).' days';
					?>
				</div>
			</div>
		</div>
	</div>
	<div style="display: none;" id="high">
		<div class="new-container-dashboard">
			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">PURCHASE ORDER</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_po_high['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">VOUCHER</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_vc_high['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">PAYROLL</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_py_high['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">COMMUNICATION</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_com_high['result'],2).' days';
					?>
				</div>
			</div>

			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">PURCHASE REQUEST</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_pr_high['result'],2).' days';
					?>
				</div>
			</div>
			<div style="float: left; padding-right: 10px; width: 200px;">
				<div class="title-dash">ABSTRACT OF CANVASS</div>
				<div class="figure-dash">
					<?php
						echo number_format($qry_aoc_high['result'],2).' days';
					?>
				</div>
			</div>
		</div>
	</div>

	<?php
	}
	?>
	
</body>
</html>