<!DOCTYPE html>
<html>
<head>
	<title>Document Tracking System</title>
	<script src="../js/charts.js"></script>
	<script>
	    var myChart = new Chart(ctx, {...});
	</script>
	<link rel="icon" href="../images/dts.png" type="image/gif" sizes="16x16">
</head>
<body>
	<canvas id="myChart"></canvas>
	<?php
		include("../database/database_connection.php");
		$year = $_REQUEST['yyyy'];

		if(isset($_REQUEST['month'])){
			$month = $_REQUEST['month'];
		}
		else{
			$month = '';
		}
	?>



	<script>
	var ctx = document.getElementById("myChart");
	var myChart = new Chart(ctx, {
	    type: 'line', //line, bar
	    data: {
	    	<?php 
	    		if($_REQUEST['datafilter']!=6){

		    		//date filter
		    		if($_REQUEST['datefilter']=='1'){ //per month
		    			echo "labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],";
		    			$date_filter = '1';
		    		}
		    		else if($_REQUEST['datefilter']=='2'){ // annual
		    			echo "labels: ['January', 'February', 'March', 'April', 'May', 'June','July','August','September','October','November','December'],";
		    			$date_filter = '2';
		    		}
		    		else if($_REQUEST['datefilter']=='3'){ //1Q
		    			echo "labels: ['January', 'February', 'March'],";
		    			$date_filter = '3';
		    		}
		    		else if($_REQUEST['datefilter']=='4'){ //2Q
		    			echo "labels: ['April', 'May', 'June'],";
		    			$date_filter = '4';
		    		}
		    		else if($_REQUEST['datefilter']=='5'){ //3Q
		    			echo "labels: ['July', 'August', 'September'],";
		    			$date_filter = '5';
		    		}
		    		else if($_REQUEST['datefilter']=='6'){ //3Q
		    			echo "labels: ['October', 'November', 'December'],";
		    			$date_filter = '6';
		    		}

		    		//data filter //conditions
		    		if($_REQUEST['datafilter']=='1'){ //total documents
		    			$condition = "status!=0";
		    		}
		    		else if($_REQUEST['datafilter']=='2'){ //in-progress
						$condition = "transaction_end_date='0000-00-00' and status!=0";
		    		}
		    		else if($_REQUEST['datafilter']=='3'){ //finished documents
		    			$condition = "transaction_end_date!='0000-00-00' and status!=0";
		    		}
		    		else if($_REQUEST['datafilter']=='4'){ //on-time
		    			$condition = "transaction_status='O' and status!=0";
		    		}
		    		else if($_REQUEST['datafilter']=='5'){ //delayed documents
		    			$condition = "transaction_status='D' and status!=0";
		    		}
		    		else if($_REQUEST['datafilter']=='6'){ //office delayed
		    			$condition = "";
		    			//ibang condition
		    		}

		    		//data set
		    		if($_REQUEST['dataset']=='1'){ //GAD
		    			$males = "";
						$females = "";
		    			if($date_filter=='1'){
		    				
							for($a=1;$a<=31;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_male = mysqli_query($connection,"select * from tbl_document where gender='Male' and $condition and recieve_date like '$year-$month-$a %'");
								$males .= mysqli_num_rows($qry_male).",";

								$qry_female = mysqli_query($connection,"select * from tbl_document where gender='Female' and $condition and recieve_date like '$year-$month-$a %'");
								$females .= mysqli_num_rows($qry_female).",";
							}
		    			}
		    			else if($date_filter=='2'){
							for($a=1;$a<=12;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_male = mysqli_query($connection,"select * from tbl_document where gender='Male' and $condition and recieve_date like '$year-$a-%'");
								$males .= mysqli_num_rows($qry_male).",";

								$qry_female = mysqli_query($connection,"select * from tbl_document where gender='Female' and $condition and recieve_date like '$year-$a-%'");
								$females .= mysqli_num_rows($qry_female).",";
							}
		    			}
		    			else if($date_filter=='3'){
							for($a=1;$a<=3;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_male = mysqli_query($connection,"select * from tbl_document where gender='Male' and $condition and recieve_date like '$year-$a-%'");
								$males .= mysqli_num_rows($qry_male).",";

								$qry_female = mysqli_query($connection,"select * from tbl_document where gender='Female' and $condition and recieve_date like '$year-$a-%'");
								$females .= mysqli_num_rows($qry_female).",";
							}
		    			}
		    			else if($date_filter=='4'){
							for($a=4;$a<=6;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_male = mysqli_query($connection,"select * from tbl_document where gender='Male' and $condition and recieve_date like '$year-$a-%'");
								$males .= mysqli_num_rows($qry_male).",";

								$qry_female = mysqli_query($connection,"select * from tbl_document where gender='Female' and $condition and recieve_date like '$year-$a-%'");
								$females .= mysqli_num_rows($qry_female).",";
							}
		    			}
		    			else if($date_filter=='5'){
							for($a=7;$a<=9;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_male = mysqli_query($connection,"select * from tbl_document where gender='Male' and $condition and recieve_date like '$year-$a-%'");
								$males .= mysqli_num_rows($qry_male).",";

								$qry_female = mysqli_query($connection,"select * from tbl_document where gender='Female' and $condition and recieve_date like '$year-$a-%'");
								$females .= mysqli_num_rows($qry_female).",";
							}
		    			}
		    			else if($date_filter=='6'){
							for($a=10;$a<=12;$a++){
								$qry_male = mysqli_query($connection,"select * from tbl_document where gender='Male' and $condition and recieve_date like '$year-$a-%'");
								$males .= mysqli_num_rows($qry_male).",";

								$qry_female = mysqli_query($connection,"select * from tbl_document where gender='Female' and $condition and recieve_date like '$year-$a-%'");
								$females .= mysqli_num_rows($qry_female).",";
							}
		    			}


		    			$male = "data: [$males]";
		    			$female = "data: [$females]";

		    			echo "datasets: [{label: 'Male',$male,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(255,99,132,1)',],borderWidth: 2},{label: 'Female',$female,backgroundColor: ['rgba(54, 162, 235, 0)',],borderColor: ['rgba(54, 162, 235, 1)',],borderWidth: 2}]";

		    		}
		    		if($_REQUEST['dataset']=='2'){ //Document Source
		    			$int = "";
						$ext = "";
		    			if($date_filter=='1'){
							for($a=1;$a<=31;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_int = mysqli_query($connection,"select * from tbl_document where source_type='INT' and $condition and recieve_date like '$year-$month-$a %'");
								$int .= mysqli_num_rows($qry_int).",";

								$qry_ext = mysqli_query($connection,"select * from tbl_document where source_type='EXT' and $condition and recieve_date like '$year-$month-$a %'");
								$ext .= mysqli_num_rows($qry_ext).",";
							}
		    			}
		    			else if($date_filter=='2'){
							for($a=1;$a<=12;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_int = mysqli_query($connection,"select * from tbl_document where source_type='INT' and $condition and recieve_date like '$year-$a-%'");
								$int .= mysqli_num_rows($qry_int).",";

								$qry_ext = mysqli_query($connection,"select * from tbl_document where source_type='EXT' and $condition and recieve_date like '$year-$a-%'");
								$ext .= mysqli_num_rows($qry_ext).",";
							}
		    			}
		    			else if($date_filter=='3'){
							for($a=1;$a<=3;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_int = mysqli_query($connection,"select * from tbl_document where source_type='INT' and $condition and recieve_date like '$year-$a-%'");
								$int .= mysqli_num_rows($qry_int).",";

								$qry_ext = mysqli_query($connection,"select * from tbl_document where source_type='EXT' and $condition and recieve_date like '$year-$a-%'");
								$ext .= mysqli_num_rows($qry_ext).",";
							}
		    			}
		    			else if($date_filter=='4'){
							for($a=4;$a<=6;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_int = mysqli_query($connection,"select * from tbl_document where source_type='INT' and $condition and recieve_date like '$year-$a-%'");
								$int .= mysqli_num_rows($qry_int).",";

								$qry_ext = mysqli_query($connection,"select * from tbl_document where source_type='EXT' and $condition and recieve_date like '$year-$a-%'");
								$ext .= mysqli_num_rows($qry_ext).",";
							}
		    			}
		    			else if($date_filter=='5'){
							for($a=7;$a<=9;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_int = mysqli_query($connection,"select * from tbl_document where source_type='INT' and $condition and recieve_date like '$year-$a-%'");
								$int .= mysqli_num_rows($qry_int).",";

								$qry_ext = mysqli_query($connection,"select * from tbl_document where source_type='EXT' and $condition and recieve_date like '$year-$a-%'");
								$ext .= mysqli_num_rows($qry_ext).",";
							}
		    			}
		    			else if($date_filter=='6'){
							for($a=10;$a<=12;$a++){
								$qry_int = mysqli_query($connection,"select * from tbl_document where source_type='INT' and $condition and recieve_date like '$year-$a-%'");
								$int .= mysqli_num_rows($qry_int).",";

								$qry_ext = mysqli_query($connection,"select * from tbl_document where source_type='EXT'and $condition and recieve_date like '$year-$a-%'");
								$ext .= mysqli_num_rows($qry_ext).",";
							}
		    			}

		    			$internal = "data: [$int]";
		    			$external = "data: [$ext]";

		    			echo "datasets: [{label: 'Internal',$internal,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(255,99,132,1)',],borderWidth: 2},{label: 'External',$external,backgroundColor: ['rgba(54, 162, 235, 0)',],borderColor: ['rgba(54, 162, 235, 1)',],borderWidth: 2}]";
		    		} 
		    		if($_REQUEST['dataset']=='3'){ //document type
		    			$moc = "";
		    			$op = "";
		    			$rp = "";
		    			$yp = "";
		    			$cv = "";
		    			if($date_filter=='1'){
							for($a=1;$a<=31;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_moc = mysqli_query($connection,"select * from tbl_document where document_type='COM' and $condition and recieve_date like '$year-$month-$a %'");
								$moc .= mysqli_num_rows($qry_moc).",";

								$qry_op = mysqli_query($connection,"select * from tbl_document where document_type='PO' and $condition and recieve_date like '$year-$month-$a %'");
								$op .= mysqli_num_rows($qry_op).",";

								$qry_rp = mysqli_query($connection,"select * from tbl_document where document_type='PR' and $condition and recieve_date like '$year-$month-$a %'");
								$rp .= mysqli_num_rows($qry_rp).",";

								$qry_yp = mysqli_query($connection,"select * from tbl_document where document_type='PY' and $condition and recieve_date like '$year-$month-$a %'");
								$yp .= mysqli_num_rows($qry_yp).",";

								$qry_cv = mysqli_query($connection,"select * from tbl_document where document_type='VC' and $condition and recieve_date like '$year-$month-$a %'");
								$cv .= mysqli_num_rows($qry_cv).",";
							}
		    			}

		    			else if($date_filter=='2'){
							for($a=1;$a<=12;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_moc = mysqli_query($connection,"select * from tbl_document where document_type='COM' and $condition and recieve_date like '$year-$a-%'");
								$moc .= mysqli_num_rows($qry_moc).",";

								$qry_op = mysqli_query($connection,"select * from tbl_document where document_type='PO' and $condition and recieve_date like '$year-$a-%'");
								$op .= mysqli_num_rows($qry_op).",";

								$qry_rp = mysqli_query($connection,"select * from tbl_document where document_type='PR' and $condition and recieve_date like '$year-$a-%'");
								$rp .= mysqli_num_rows($qry_rp).",";

								$qry_yp = mysqli_query($connection,"select * from tbl_document where document_type='PY' and $condition and recieve_date like '$year-$a-%'");
								$yp .= mysqli_num_rows($qry_yp).",";

								$qry_cv = mysqli_query($connection,"select * from tbl_document where document_type='VC' and $condition and recieve_date like '$year-$a-%'");
								$cv .= mysqli_num_rows($qry_cv).",";
							}
		    			}

		    			else if($date_filter=='3'){
							for($a=1;$a<=3;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_moc = mysqli_query($connection,"select * from tbl_document where document_type='COM' and $condition and recieve_date like '$year-$a-%'");
								$moc .= mysqli_num_rows($qry_moc).",";

								$qry_op = mysqli_query($connection,"select * from tbl_document where document_type='PO' and $condition and recieve_date like '$year-$a-%'");
								$op .= mysqli_num_rows($qry_op).",";

								$qry_rp = mysqli_query($connection,"select * from tbl_document where document_type='PR' and $condition and recieve_date like '$year-$a-%'");
								$rp .= mysqli_num_rows($qry_rp).",";

								$qry_yp = mysqli_query($connection,"select * from tbl_document where document_type='PY' and $condition and recieve_date like '$year-$a-%'");
								$yp .= mysqli_num_rows($qry_yp).",";

								$qry_cv = mysqli_query($connection,"select * from tbl_document where document_type='VC' and $condition and recieve_date like '$year-$a-%'");
								$cv .= mysqli_num_rows($qry_cv).",";
							}
		    			}
		    			else if($date_filter=='4'){
							for($a=4;$a<=6;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_moc = mysqli_query($connection,"select * from tbl_document where document_type='COM' and $condition and recieve_date like '$year-$a-%'");
								$moc .= mysqli_num_rows($qry_moc).",";

								$qry_op = mysqli_query($connection,"select * from tbl_document where document_type='PO' and $condition and recieve_date like '$year-$a-%'");
								$op .= mysqli_num_rows($qry_op).",";

								$qry_rp = mysqli_query($connection,"select * from tbl_document where document_type='PR' and $condition and recieve_date like '$year-$a-%'");
								$rp .= mysqli_num_rows($qry_rp).",";

								$qry_yp = mysqli_query($connection,"select * from tbl_document where document_type='PY' and $condition and recieve_date like '$year-$a-%'");
								$yp .= mysqli_num_rows($qry_yp).",";

								$qry_cv = mysqli_query($connection,"select * from tbl_document where document_type='VC' and $condition and recieve_date like '$year-$a-%'");
								$cv .= mysqli_num_rows($qry_cv).",";
							}
		    			}
		    			else if($date_filter=='5'){
							for($a=7;$a<=9;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_moc = mysqli_query($connection,"select * from tbl_document where document_type='COM' and $condition and recieve_date like '$year-$a-%'");
								$moc .= mysqli_num_rows($qry_moc).",";

								$qry_op = mysqli_query($connection,"select * from tbl_document where document_type='PO' and $condition and recieve_date like '$year-$a-%'");
								$op .= mysqli_num_rows($qry_op).",";

								$qry_rp = mysqli_query($connection,"select * from tbl_document where document_type='PR' and $condition and recieve_date like '$year-$a-%'");
								$rp .= mysqli_num_rows($qry_rp).",";

								$qry_yp = mysqli_query($connection,"select * from tbl_document where document_type='PY' and $condition and recieve_date like '$year-$a-%'");
								$yp .= mysqli_num_rows($qry_yp).",";

								$qry_cv = mysqli_query($connection,"select * from tbl_document where document_type='VC' and $condition and recieve_date like '$year-$a-%'");
								$cv .= mysqli_num_rows($qry_cv).",";
							}
		    			}
		    			else if($date_filter=='6'){
							for($a=10;$a<=12;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_moc = mysqli_query($connection,"select * from tbl_document where document_type='COM' and $condition and recieve_date like '$year-$a-%'");
								$moc .= mysqli_num_rows($qry_moc).",";

								$qry_op = mysqli_query($connection,"select * from tbl_document where document_type='PO' and $condition and recieve_date like '$year-$a-%'");
								$op .= mysqli_num_rows($qry_op).",";

								$qry_rp = mysqli_query($connection,"select * from tbl_document where document_type='PR' and $condition and recieve_date like '$year-$a-%'");
								$rp .= mysqli_num_rows($qry_rp).",";

								$qry_yp = mysqli_query($connection,"select * from tbl_document where document_type='PY' and $condition and recieve_date like '$year-$a-%'");
								$yp .= mysqli_num_rows($qry_yp).",";

								$qry_cv = mysqli_query($connection,"select * from tbl_document where document_type='VC' and $condition and recieve_date like '$year-$a-%'");
								$cv .= mysqli_num_rows($qry_cv).",";
							}
		    			}

		    			$com = "data: [$moc]";
		    			$po = "data: [$op]";
		    			$pr = "data: [$rp]";
		    			$py = "data: [$yp]";
		    			$vc = "data: [$cv]";

		    			echo "datasets: [{label: 'COM',$com,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(255,99,132,1)',],borderWidth: 2},{label: 'PO',$po,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(54, 162, 235, 1)',],borderWidth: 2},{label: 'PR',$pr,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(255, 206, 86, 1)',],borderWidth: 2},{label: 'PY',$py,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(75, 192, 192, 1)',],borderWidth: 2},{label: 'VC',$vc,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(153, 102, 255, 1)',],borderWidth: 2}]";
		    		}
		    		if($_REQUEST['dataset']=='4'){ //transaction type
		    			$sim = "";
		    			$com = "";

		    			if($date_filter=='1'){
							for($a=1;$a<=31;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_sim = mysqli_query($connection,"select * from tbl_document where transaction_type='SIMP' and $condition and recieve_date like '$year-$month-$a %'");
								$sim .= mysqli_num_rows($qry_sim).",";

								$qry_com = mysqli_query($connection,"select * from tbl_document where transaction_type='COMP' and $condition and recieve_date like '$year-$month-$a %'");
								$com .= mysqli_num_rows($qry_com).",";
							}
		    			}
		    			if($date_filter=='2'){
							for($a=1;$a<=12;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_sim = mysqli_query($connection,"select * from tbl_document where transaction_type='SIMP' and $condition and recieve_date like '$year-$a-%'");
								$sim .= mysqli_num_rows($qry_sim).",";

								$qry_com = mysqli_query($connection,"select * from tbl_document where transaction_type='COMP' and $condition and recieve_date like '$year-$a-%'");
								$com .= mysqli_num_rows($qry_com).",";
							}
		    			}
		    			if($date_filter=='3'){
							for($a=1;$a<=3;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_sim = mysqli_query($connection,"select * from tbl_document where transaction_type='SIMP' and $condition and recieve_date like '$year-$a-%'");
								$sim .= mysqli_num_rows($qry_sim).",";

								$qry_com = mysqli_query($connection,"select * from tbl_document where transaction_type='COMP' and $condition and recieve_date like '$year-$a-%'");
								$com .= mysqli_num_rows($qry_com).",";
							}
		    			}

		    			if($date_filter=='4'){
							for($a=4;$a<=6;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_sim = mysqli_query($connection,"select * from tbl_document where transaction_type='SIMP' and $condition and recieve_date like '$year-$a-%'");
								$sim .= mysqli_num_rows($qry_sim).",";

								$qry_com = mysqli_query($connection,"select * from tbl_document where transaction_type='COMP' and $condition and recieve_date like '$year-$a-%'");
								$com .= mysqli_num_rows($qry_com).",";
							}
		    			}

		    			if($date_filter=='5'){
							for($a=7;$a<=9;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_sim = mysqli_query($connection,"select * from tbl_document where transaction_type='SIMP' and $condition and recieve_date like '$year-$a-%'");
								$sim .= mysqli_num_rows($qry_sim).",";

								$qry_com = mysqli_query($connection,"select * from tbl_document where transaction_type='COMP' and $condition and recieve_date like '$year-$a-%'");
								$com .= mysqli_num_rows($qry_com).",";
							}
		    			}
		    			if($date_filter=='6'){
							for($a=10;$a<=12;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_sim = mysqli_query($connection,"select * from tbl_document where transaction_type='SIMP' and $condition and recieve_date like '$year-$a-%'");
								$sim .= mysqli_num_rows($qry_sim).",";

								$qry_com = mysqli_query($connection,"select * from tbl_document where transaction_type='COMP' and $condition and recieve_date like '$year-$a-%'");
								$com .= mysqli_num_rows($qry_com).",";
							}
		    			}

		    			$simple = "data: [$sim]";
		    			$complex = "data: [$com]";

		    			echo "datasets: [{label: 'Simple',$simple,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(255,99,132,1)',],borderWidth: 2},{label: 'Complex',$complex,backgroundColor: ['rgba(54, 162, 235, 0)',],borderColor: ['rgba(54, 162, 235, 1)',],borderWidth: 2}]";
		    		} 

		    		if($_REQUEST['dataset']=='5'){ //delivery method
		    			$em = "";
		    			$fx = "";
		    			$hc = "";
		    			$pm = "";
		    			
		    			if($date_filter=='1'){
							for($a=1;$a<=31;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}
								//email
								$qry_em = mysqli_query($connection,"select * from tbl_document where delivery_method='1' and $condition and recieve_date like '$year-$month-$a %'");
								$em .= mysqli_num_rows($qry_em).",";
								//fax
								$qry_fx = mysqli_query($connection,"select * from tbl_document where delivery_method='2' and $condition and recieve_date like '$year-$month-$a %'");
								$fx .= mysqli_num_rows($qry_fx).",";
								//hand carry
								$qry_hc = mysqli_query($connection,"select * from tbl_document where delivery_method='3' and $condition and recieve_date like '$year-$month-$a %'");
								$hc .= mysqli_num_rows($qry_hc).",";
								//post mail
								$qry_pm = mysqli_query($connection,"select * from tbl_document where delivery_method='3' and $condition and recieve_date like '$year-$month-$a %'");
								$pm .= mysqli_num_rows($qry_pm).",";
							}
		    			}

		    			if($date_filter=='2'){
							for($a=1;$a<=12;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}
								//email
								$qry_em = mysqli_query($connection,"select * from tbl_document where delivery_method='1' and $condition and recieve_date like '$year-$a%'");
								$em .= mysqli_num_rows($qry_em).",";
								//fax
								$qry_fx = mysqli_query($connection,"select * from tbl_document where delivery_method='2' and $condition and recieve_date like '$year-$a%'");
								$fx .= mysqli_num_rows($qry_fx).",";
								//hand carry
								$qry_hc = mysqli_query($connection,"select * from tbl_document where delivery_method='3' and $condition and recieve_date like '$year-$a%'");
								$hc .= mysqli_num_rows($qry_hc).",";
								//post mail
								$qry_pm = mysqli_query($connection,"select * from tbl_document where delivery_method='4' and $condition and recieve_date like '$year-$a%'");
								$pm .= mysqli_num_rows($qry_pm).",";
							}
		    			}

		    			if($date_filter=='3'){
							for($a=1;$a<=3;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}
								//email
								$qry_em = mysqli_query($connection,"select * from tbl_document where delivery_method='1' and $condition and recieve_date like '$year-$a%'");
								$em .= mysqli_num_rows($qry_em).",";
								//fax
								$qry_fx = mysqli_query($connection,"select * from tbl_document where delivery_method='2' and $condition and recieve_date like '$year-$a%'");
								$fx .= mysqli_num_rows($qry_fx).",";
								//hand carry
								$qry_hc = mysqli_query($connection,"select * from tbl_document where delivery_method='3' and $condition and recieve_date like '$year-$a%'");
								$hc .= mysqli_num_rows($qry_hc).",";
								//post mail
								$qry_pm = mysqli_query($connection,"select * from tbl_document where delivery_method='4' and $condition and recieve_date like '$year-$a%'");
								$pm .= mysqli_num_rows($qry_pm).",";
							}
		    			}

		    			if($date_filter=='4'){
							for($a=4;$a<=6;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}
								//email
								$qry_em = mysqli_query($connection,"select * from tbl_document where delivery_method='1' and $condition and recieve_date like '$year-$a%'");
								$em .= mysqli_num_rows($qry_em).",";
								//fax
								$qry_fx = mysqli_query($connection,"select * from tbl_document where delivery_method='2' and $condition and recieve_date like '$year-$a%'");
								$fx .= mysqli_num_rows($qry_fx).",";
								//hand carry
								$qry_hc = mysqli_query($connection,"select * from tbl_document where delivery_method='3' and $condition and recieve_date like '$year-$a%'");
								$hc .= mysqli_num_rows($qry_hc).",";
								//post mail
								$qry_pm = mysqli_query($connection,"select * from tbl_document where delivery_method='4' and $condition and recieve_date like '$year-$a%'");
								$pm .= mysqli_num_rows($qry_pm).",";
							}
		    			}

		    			if($date_filter=='5'){
							for($a=7;$a<=9;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}
								//email
								$qry_em = mysqli_query($connection,"select * from tbl_document where delivery_method='1' and $condition and recieve_date like '$year-$a%'");
								$em .= mysqli_num_rows($qry_em).",";
								//fax
								$qry_fx = mysqli_query($connection,"select * from tbl_document where delivery_method='2' and $condition and recieve_date like '$year-$a%'");
								$fx .= mysqli_num_rows($qry_fx).",";
								//hand carry
								$qry_hc = mysqli_query($connection,"select * from tbl_document where delivery_method='3' and $condition and recieve_date like '$year-$a%'");
								$hc .= mysqli_num_rows($qry_hc).",";
								//post mail
								$qry_pm = mysqli_query($connection,"select * from tbl_document where delivery_method='4' and $condition and recieve_date like '$year-$a%'");
								$pm .= mysqli_num_rows($qry_pm).",";
							}
		    			}

		    			if($date_filter=='6'){
							for($a=10;$a<=12;$a++){
								//email
								$qry_em = mysqli_query($connection,"select * from tbl_document where delivery_method='1' and $condition and recieve_date like '$year-$a%'");
								$em .= mysqli_num_rows($qry_em).",";
								//fax
								$qry_fx = mysqli_query($connection,"select * from tbl_document where delivery_method='2' and $condition and recieve_date like '$year-$a%'");
								$fx .= mysqli_num_rows($qry_fx).",";
								//hand carry
								$qry_hc = mysqli_query($connection,"select * from tbl_document where delivery_method='3' and $condition and recieve_date like '$year-$a%'");
								$hc .= mysqli_num_rows($qry_hc).",";
								//post mail
								$qry_pm = mysqli_query($connection,"select * from tbl_document where delivery_method='4' and $condition and recieve_date like '$year-$a%'");
								$pm .= mysqli_num_rows($qry_pm).",";
							}
		    			}

		    			$email = "data: [$em]";
		    			$fax = "data: [$fx]";
		    			$handcarry = "data: [$hc]";
		    			$postmail = "data: [$pm]";

		    			echo "datasets: [{label: 'Email',$email,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(255,99,132,1)',],borderWidth: 2},{label: 'Fax',$fax,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(54, 162, 235, 1)',],borderWidth: 2},{label: 'Hand Carry',$handcarry,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(255, 206, 86, 1)',],borderWidth: 2},{label: 'Post Mail',$postmail,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(75, 192, 192, 1)',],borderWidth: 2}]";
		    		}
				}
				
				else{

					//date filter
		    		if($_REQUEST['datefilter']=='1'){ //per month
		    			echo "labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],";
		    			$date_filter = '1';
		    		}
		    		else if($_REQUEST['datefilter']=='2'){ // annual
		    			echo "labels: ['January', 'February', 'March', 'April', 'May', 'June','July','August','September','October','November','December'],";
		    			$date_filter = '2';
		    		}
		    		else if($_REQUEST['datefilter']=='3'){ //1Q
		    			echo "labels: ['January', 'February', 'March'],";
		    			$date_filter = '3';
		    		}
		    		else if($_REQUEST['datefilter']=='4'){ //2Q
		    			echo "labels: ['April', 'May', 'June'],";
		    			$date_filter = '4';
		    		}
		    		else if($_REQUEST['datefilter']=='5'){ //3Q
		    			echo "labels: ['July', 'August', 'September'],";
		    			$date_filter = '5';
		    		}
		    		else if($_REQUEST['datefilter']=='6'){ //3Q
		    			echo "labels: ['October', 'November', 'December'],";
		    			$date_filter = '6';
		    		} 

		 

		    		//data sets
		    		if($_REQUEST['dataset']=='1'){ //GAD
		    			$males = "";
						$females = "";

		    			if($date_filter=='1'){
							for($a=1;$a<=31;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_male = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$month-$a %' and a.gender='Male'");
								$males .= mysqli_num_rows($qry_male).",";

								$qry_female = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$month-$a %' and a.gender='Female'");
								$females .= mysqli_num_rows($qry_female).",";
							}
						}

						if($date_filter=='2'){
							for($a=1;$a<=12;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_male = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.gender='Male'");
								$males .= mysqli_num_rows($qry_male).",";

								$qry_female = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.gender='Female'");
								$females .= mysqli_num_rows($qry_female).",";
							}
						}

						if($date_filter=='3'){
							for($a=1;$a<=3;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_male = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.gender='Male'");
								$males .= mysqli_num_rows($qry_male).",";

								$qry_female = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.gender='Female'");
								$females .= mysqli_num_rows($qry_female).",";
							}
						}

						if($date_filter=='4'){
							for($a=4;$a<=6;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_male = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.gender='Male'");
								$males .= mysqli_num_rows($qry_male).",";

								$qry_female = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.gender='Female'");
								$females .= mysqli_num_rows($qry_female).",";
							}
						}

						if($date_filter=='5'){
							for($a=7;$a<=9;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_male = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.gender='Male'");
								$males .= mysqli_num_rows($qry_male).",";

								$qry_female = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.gender='Female'");
								$females .= mysqli_num_rows($qry_female).",";
							}
						}
						if($date_filter=='6'){
							for($a=10;$a<=12;$a++){
							
								$qry_male = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.gender='Male'");
								$males .= mysqli_num_rows($qry_male).",";

								$qry_female = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.gender='Female'");
								$females .= mysqli_num_rows($qry_female).",";
							}
						}

						$male = "data: [$males]";
		    			$female = "data: [$females]";

		    			echo "datasets: [{label: 'Male',$male,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(255,99,132,1)',],borderWidth: 2},{label: 'Female',$female,backgroundColor: ['rgba(54, 162, 235, 0)',],borderColor: ['rgba(54, 162, 235, 1)',],borderWidth: 2}]";
		    		}

		    		//
		    		if($_REQUEST['dataset']=='2'){ //document source
		    			$int = "";
						$ext = "";
		    			if($date_filter=='1'){
							for($a=1;$a<=31;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_int = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$month-$a %' and a.source_type='INT'");
								$int .= mysqli_num_rows($qry_int).",";

								$qry_ext = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$month-$a %' and a.source_type='EXT'");
								$ext .= mysqli_num_rows($qry_ext).",";
							}
		    			}
		    			else if($date_filter=='2'){
							for($a=1;$a<=12;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_int = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.source_type='INT'");
								$int .= mysqli_num_rows($qry_int).",";

								$qry_ext = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.source_type='EXT'");
								$ext .= mysqli_num_rows($qry_ext).",";
							}
		    			}
		    			else if($date_filter=='3'){
							for($a=1;$a<=3;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_int = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.source_type='INT'");
								$int .= mysqli_num_rows($qry_int).",";

								$qry_ext = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.source_type='EXT'");
								$ext .= mysqli_num_rows($qry_ext).",";
							}
		    			}
		    			else if($date_filter=='4'){
							for($a=4;$a<=6;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_int = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.source_type='INT'");
								$int .= mysqli_num_rows($qry_int).",";

								$qry_ext = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.source_type='EXT'");
								$ext .= mysqli_num_rows($qry_ext).",";
							}
		    			}
		    			else if($date_filter=='5'){
							for($a=7;$a<=9;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_int = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.source_type='INT'");
								$int .= mysqli_num_rows($qry_int).",";

								$qry_ext = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.source_type='EXT'");
								$ext .= mysqli_num_rows($qry_ext).",";
							}
		    			}
		    			else if($date_filter=='6'){
							for($a=10;$a<=12;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_int = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.source_type='INT'");
								$int .= mysqli_num_rows($qry_int).",";

								$qry_ext = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.source_type='EXT'");
								$ext .= mysqli_num_rows($qry_ext).",";
							}
		    			}


		    			$internal = "data: [$int]";
		    			$external = "data: [$ext]";

		    			echo "datasets: [{label: 'Internal',$internal,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(255,99,132,1)',],borderWidth: 2},{label: 'External',$external,backgroundColor: ['rgba(54, 162, 235, 0)',],borderColor: ['rgba(54, 162, 235, 1)',],borderWidth: 2}]";
		    		}

		    		if($_REQUEST['dataset']=='3'){ //document type
		    			$moc = "";
		    			$op = "";
		    			$rp = "";
		    			$yp = "";
		    			$cv = "";

		    			if($date_filter=='1'){
							for($a=1;$a<=31;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_moc = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$month-$a %' and a.document_type='COM'");
								$moc .= mysqli_num_rows($qry_moc).",";

								$qry_op = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$month-$a %' and a.document_type='PO'");
								$op .= mysqli_num_rows($qry_op).",";

								$qry_rp = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$month-$a %' and a.document_type='PR'");
								$rp .= mysqli_num_rows($qry_rp).",";

								$qry_yp = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$month-$a %' and a.document_type='PY'");
								$yp .= mysqli_num_rows($qry_yp).",";

								$qry_cv = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='VC'");
								$cv .= mysqli_num_rows($qry_cv).",";
							}
		    			}

		    			else if($date_filter=='2'){
							for($a=1;$a<=12;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_moc = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='COM'");
								$moc .= mysqli_num_rows($qry_moc).",";

								$qry_op = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='PO'");
								$op .= mysqli_num_rows($qry_op).",";

								$qry_rp = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='PR'");
								$rp .= mysqli_num_rows($qry_rp).",";

								$qry_yp = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='PY'");
								$yp .= mysqli_num_rows($qry_yp).",";

								$qry_cv = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='VC'");
								$cv .= mysqli_num_rows($qry_cv).",";
							}
		    			}

		    			else if($date_filter=='3'){
							for($a=1;$a<=3;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_moc = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='COM'");
								$moc .= mysqli_num_rows($qry_moc).",";

								$qry_op = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='PO'");
								$op .= mysqli_num_rows($qry_op).",";

								$qry_rp = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='PR'");
								$rp .= mysqli_num_rows($qry_rp).",";

								$qry_yp = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='PY'");
								$yp .= mysqli_num_rows($qry_yp).",";

								$qry_cv = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='VC'");
								$cv .= mysqli_num_rows($qry_cv).",";
							}
		    			}

		    			else if($date_filter=='4'){
							for($a=4;$a<=6;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_moc = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='COM'");
								$moc .= mysqli_num_rows($qry_moc).",";

								$qry_op = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='PO'");
								$op .= mysqli_num_rows($qry_op).",";

								$qry_rp = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='PR'");
								$rp .= mysqli_num_rows($qry_rp).",";

								$qry_yp = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='PY'");
								$yp .= mysqli_num_rows($qry_yp).",";

								$qry_cv = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='VC'");
								$cv .= mysqli_num_rows($qry_cv).",";
							}
		    			}

		    			else if($date_filter=='5'){
							for($a=7;$a<=9;$a++){
								
								$qry_moc = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='COM'");
								$moc .= mysqli_num_rows($qry_moc).",";

								$qry_op = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='PO'");
								$op .= mysqli_num_rows($qry_op).",";

								$qry_rp = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='PR'");
								$rp .= mysqli_num_rows($qry_rp).",";

								$qry_yp = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='PY'");
								$yp .= mysqli_num_rows($qry_yp).",";

								$qry_cv = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='VC'");
								$cv .= mysqli_num_rows($qry_cv).",";
							}
		    			}
		    			else if($date_filter=='6'){
							for($a=10;$a<=12;$a++){
								
								$qry_moc = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='COM'");
								$moc .= mysqli_num_rows($qry_moc).",";

								$qry_op = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='PO'");
								$op .= mysqli_num_rows($qry_op).",";

								$qry_rp = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='PR'");
								$rp .= mysqli_num_rows($qry_rp).",";

								$qry_yp = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='PY'");
								$yp .= mysqli_num_rows($qry_yp).",";

								$qry_cv = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.document_type='VC'");
								$cv .= mysqli_num_rows($qry_cv).",";
							}
		    			}



		    			$com = "data: [$moc]";
		    			$po = "data: [$op]";
		    			$pr = "data: [$rp]";
		    			$py = "data: [$yp]";
		    			$vc = "data: [$cv]";

		    			echo "datasets: [{label: 'COM',$com,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(255,99,132,1)',],borderWidth: 2},{label: 'PO',$po,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(54, 162, 235, 1)',],borderWidth: 2},{label: 'PR',$pr,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(255, 206, 86, 1)',],borderWidth: 2},{label: 'PY',$py,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(75, 192, 192, 1)',],borderWidth: 2},{label: 'VC',$vc,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(153, 102, 255, 1)',],borderWidth: 2}]";

		    		}
		    		if($_REQUEST['dataset']=='4'){ //transaction type
		    			$sim = "";
		    			$com = "";

		    			if($date_filter=='1'){
							for($a=1;$a<=31;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_sim = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$month-$a %' and a.transaction_type='SIMP'");
								$sim .= mysqli_num_rows($qry_sim).",";

								$qry_com = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$month-$a %' and a.transaction_type='COMP'");
								$com .= mysqli_num_rows($qry_com).",";
							}
		    			}

		    			else if($date_filter=='2'){
							for($a=1;$a<=12;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_sim = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.transaction_type='SIMP'");
								$sim .= mysqli_num_rows($qry_sim).",";

								$qry_com = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.transaction_type='COMP'");
								$com .= mysqli_num_rows($qry_com).",";
							}
		    			}

		    			else if($date_filter=='3'){
							for($a=1;$a<=3;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_sim = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.transaction_type='SIMP'");
								$sim .= mysqli_num_rows($qry_sim).",";

								$qry_com = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.transaction_type='COMP'");
								$com .= mysqli_num_rows($qry_com).",";
							}
		    			}

		    			else if($date_filter=='4'){
							for($a=4;$a<=6;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_sim = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.transaction_type='SIMP'");
								$sim .= mysqli_num_rows($qry_sim).",";

								$qry_com = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.transaction_type='COMP'");
								$com .= mysqli_num_rows($qry_com).",";
							}
		    			}

		    			else if($date_filter=='5'){
							for($a=7;$a<=9;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_sim = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.transaction_type='SIMP'");
								$sim .= mysqli_num_rows($qry_sim).",";

								$qry_com = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.transaction_type='COMP'");
								$com .= mysqli_num_rows($qry_com).",";
							}
		    			}

		    			else if($date_filter=='6'){
							for($a=10;$a<=12;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}

								$qry_sim = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.transaction_type='SIMP'");
								$sim .= mysqli_num_rows($qry_sim).",";

								$qry_com = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.transaction_type='COMP'");
								$com .= mysqli_num_rows($qry_com).",";
							}
		    			}

		    			$simple = "data: [$sim]";
		    			$complex = "data: [$com]";

		    			echo "datasets: [{label: 'Simple',$simple,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(255,99,132,1)',],borderWidth: 2},{label: 'Complex',$complex,backgroundColor: ['rgba(54, 162, 235, 0)',],borderColor: ['rgba(54, 162, 235, 1)',],borderWidth: 2}]";
		    		}

		    		if($_REQUEST['dataset']=='5'){ //delivery method
		    			$em = "";
		    			$fx = "";
		    			$hc = "";
		    			$pm = "";

		    			if($date_filter=='1'){
							for($a=1;$a<=31;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}
								//email
								$qry_em = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$month-$a %' and a.delivery_method='1'");
								$em .= mysqli_num_rows($qry_em).",";
								//fax
								$qry_fx = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$month-$a % ' and a.delivery_method='2'");
								$fx .= mysqli_num_rows($qry_fx).",";
								//hand carry
								$qry_hc = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$month-$a %' and a.delivery_method='3'");
								$hc .= mysqli_num_rows($qry_hc).",";
								//post mail
								$qry_pm = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$month-$a %' and a.delivery_method='4'");
								$pm .= mysqli_num_rows($qry_pm).",";
							}
		    			}

		    			if($date_filter=='2'){
							for($a=1;$a<=12;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}
								//email
								$qry_em = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='1'");
								$em .= mysqli_num_rows($qry_em).",";
								//fax
								$qry_fx = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='2'");
								$fx .= mysqli_num_rows($qry_fx).",";
								//hand carry
								$qry_hc = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='3'");
								$hc .= mysqli_num_rows($qry_hc).",";
								//post mail
								$qry_pm = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='4'");
								$pm .= mysqli_num_rows($qry_pm).",";
							}
		    			}

		    			if($date_filter=='3'){
							for($a=1;$a<=3;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}
								//email
								$qry_em = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='1'");
								$em .= mysqli_num_rows($qry_em).",";
								//fax
								$qry_fx = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='2'");
								$fx .= mysqli_num_rows($qry_fx).",";
								//hand carry
								$qry_hc = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='3'");
								$hc .= mysqli_num_rows($qry_hc).",";
								//post mail
								$qry_pm = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='4'");
								$pm .= mysqli_num_rows($qry_pm).",";
							}
		    			}

		    			if($date_filter=='4'){
							for($a=4;$a<=6;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}
								//email
								$qry_em = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='1'");
								$em .= mysqli_num_rows($qry_em).",";
								//fax
								$qry_fx = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='2'");
								$fx .= mysqli_num_rows($qry_fx).",";
								//hand carry
								$qry_hc = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='3'");
								$hc .= mysqli_num_rows($qry_hc).",";
								//post mail
								$qry_pm = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='4'");
								$pm .= mysqli_num_rows($qry_pm).",";
							}
		    			}

		    			if($date_filter=='5'){
							for($a=7;$a<=9;$a++){
								if(strlen($a)==1){
									$a = '0'.$a;
								}
								else{
									$a;
								}
								//email
								$qry_em = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='1'");
								$em .= mysqli_num_rows($qry_em).",";
								//fax
								$qry_fx = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='2'");
								$fx .= mysqli_num_rows($qry_fx).",";
								//hand carry
								$qry_hc = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='3'");
								$hc .= mysqli_num_rows($qry_hc).",";
								//post mail
								$qry_pm = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='4'");
								$pm .= mysqli_num_rows($qry_pm).",";
							}
		    			}
		    			if($date_filter=='6'){
							for($a=10;$a<=12;$a++){
								
								//email
								$qry_em = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='1'");
								$em .= mysqli_num_rows($qry_em).",";
								//fax
								$qry_fx = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='2'");
								$fx .= mysqli_num_rows($qry_fx).",";
								//hand carry
								$qry_hc = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='3'");
								$hc .= mysqli_num_rows($qry_hc).",";
								//post mail
								$qry_pm = mysqli_query($connection,"select * from tbl_document a, tbl_document_transaction b, tbl_office_performance c where a.barcode=b.barcode and a.document_type=c.document_code and b.office_code=c.office_code and b.status!=0 and a.status!=0 and (b.office_time>c.office_time) and a.recieve_date like '$year-$a%' and a.delivery_method='4'");
								$pm .= mysqli_num_rows($qry_pm).",";
							}
		    			}

		    			$email = "data: [$em]";
		    			$fax = "data: [$fx]";
		    			$handcarry = "data: [$hc]";
		    			$postmail = "data: [$pm]";

		    			echo "datasets: [{label: 'Email',$email,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(255,99,132,1)',],borderWidth: 2},{label: 'Fax',$fax,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(54, 162, 235, 1)',],borderWidth: 2},{label: 'Hand Carry',$handcarry,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(255, 206, 86, 1)',],borderWidth: 2},{label: 'Post Mail',$postmail,backgroundColor: ['rgba(255, 255, 255, 0)',],borderColor: ['rgba(75, 192, 192, 1)',],borderWidth: 2}]";
		    		}
		    			


				}
	   
	    	?>


	        /*
	        datasets: [
	        {
	            label: 'Male',
	            data: [5, 19, 3, 5, 2, 3,],
	            backgroundColor: ['rgba(255, 255, 255, 0)',],
	            borderColor: ['rgba(255,99,132,1)',],
	            borderWidth: 2
	        }
	        ,
	        {
	        	label: 'Female',
	            data: [10, 11, 13, 25, 20, 13],
	            backgroundColor: ['rgba(54, 162, 235, 0)',],
	            borderColor: ['rgba(54, 162, 235, 1)',],
	            borderWidth: 2
	        }
	        ]
			*/


	    },
	    options: 
	    {
            responsive: true,
            title:{
                display:true,
                text:'<?php echo $_REQUEST['reporttitle'];?>'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true,
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: '<?php echo $year;?>'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Value'
                    }
                }]
            }
        }
	});
	</script>
	<table class="table-report" style="font-size: 10px; font-family:arial;">
		<tr>
			<td><i>System Generated: Document Tracking System</i></td>
		</tr>
		<tr>
			<td><i>Printed By: <?php echo "$_REQUEST[accessname] ".date("m-d-Y");?></i></td>
		</tr>
	</table>
</body>
</html>