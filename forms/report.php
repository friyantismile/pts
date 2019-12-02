<!DOCTYPE html>
<html>
<head>
	<title>Document Tracking System</title>
	<!--
	<script type="text/javascript">
		function disable_filter(){
			/*
			rt = document.getElementById("reporttype").value;
			
			if(rt=="6"){
				document.getElementById("transactiontype").disabled = true;
				document.getElementById("sourcetype").disabled = true;
				document.getElementById("documenttype").disabled = true;
				document.getElementById("gender").disabled = true;
				document.getElementById("recuser").disabled = true;
				
				//alert("hello");
			}
			else{
				//alert("hi");
				document.getElementById("transactiontype").disabled = false;
				document.getElementById("sourcetype").disabled = false;
				document.getElementById("documenttype").disabled = false;
				document.getElementById("gender").disabled = false;
				document.getElementById("recuser").disabled = false;
			}
			*/
		}
	</script>
	<td><input type="checkbox" name="recievedate" id="recievedate"> Recieve Date&nbsp;</td>
		<td><input type="checkbox" name="barcde" id="barcde"> Barcode&nbsp;</td>
		<td><input type="checkbox" name="doctype" id="doctype"> Document Type&nbsp;</td>
		<td><input type="checkbox" name="sortype" id="sortype"> Source Type&nbsp;</td>
		<td><input type="checkbox" name="offsource" id="offsource"> Office Source&nbsp;</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="offsource" id="gen"> Gender&nbsp;</td>
		<td><input type="checkbox" name="contno" id="contno"> Contact No.&nbsp;</td>
		<td><input type="checkbox" name="eadd" id="eadd"> Email Address&nbsp;</td>
		<td><input type="checkbox" name="submatter" id="submatter"> Subject Matter&nbsp;</td>
		<td><input type="checkbox" name="totaltime" id="totaltime"> Total Time&nbsp;</td>
	-->
	<script type="text/javascript">
		function selectallcolumns(){
			all = document.getElementById("selectall");
        
	        if(all.checked){    
	            document.getElementById("recievedate").checked = true;
	            document.getElementById("barcde").checked = true;
	            document.getElementById("doctype").checked = true;
	            document.getElementById("sortype").checked = true;
	            document.getElementById("offsource").checked = true;
	            document.getElementById("gen").checked = true;
	            document.getElementById("contno").checked = true;
	            document.getElementById("eadd").checked = true;
	            document.getElementById("submatter").checked = true;
	            document.getElementById("totaltime").checked = true;

	        }
	        else{
	            document.getElementById("recievedate").checked = false;
	            document.getElementById("barcde").checked = false;
	            document.getElementById("doctype").checked = false;
	            document.getElementById("sortype").checked = false;
	            document.getElementById("offsource").checked = false;
	            document.getElementById("gen").checked = false;
	            document.getElementById("contno").checked = false;
	            document.getElementById("eadd").checked = false;
	            document.getElementById("submatter").checked = false;
	            document.getElementById("totaltime").checked = false;
	            
	        }

		}
	</script>
	<link rel="icon" href="../images/dts.png" type="image/gif" sizes="16x16">
</head>
<body>
	<form action="../output/show_report.php?report" method="post" target="_blank">
		<div class="report-container">
			<h4>Report List</h4>
			<div class="form-group">
				<input type="textbox" class="form-control" style="width:540px;" name="reporttitle" id="reporttitle" placeholder="Report Title">
			</div>
			<div class="form-group form-space-label form-space">
				<div class="form-label" style="width:600px;">Date Range:</div>
			</div>
			<div class="form-group form-inline">
				<input type="hidden" value="<?php echo $access['full_name'];?>" name="user" id="user">
	            <select class="form-control" name="frommm" required="required">
	            	<option value="">Month</option>
	            	<option value="01">January</option>
	            	<option value="02">February</option>
	            	<option value="03">March</option>
	            	<option value="04">April</option>
	            	<option value="05">May</option>
	            	<option value="06">June</option>
	            	<option value="07">July</option>
	            	<option value="08">August</option>
	            	<option value="09">September</option>
	            	<option value="10">October</option>
	            	<option value="11">November</option>
	            	<option value="12">December</option>
	            </select>
	            <select class="form-control" style="width: 70px" name="fromdd" required="required">
	            	<option value="">DD</option>
	            	<?php
	            	for($a=1;$a<=31;$a++){
	            		if(strlen($a)==1){
	            			echo "<option value='0$a'>0$a</option>";
	            		}
	            		else{
	            			echo "<option value='$a'>$a</option>";
	            		}
	            	}
	            	?>
	            </select>
	            <input class="form-control" style="width: 65px;" placeholder="YYYY" value="<?php echo date('Y'); ?>" maxlength="4" type="text" name="fromyyyy" required="required">
	            -
	            <select class="form-control" name="tomm" required="required">
	            	<option value="">Month</option>
	            	<option value="01">January</option>
	            	<option value="02">February</option>
	            	<option value="03">March</option>
	            	<option value="04">April</option>
	            	<option value="05">May</option>
	            	<option value="06">June</option>
	            	<option value="07">July</option>
	            	<option value="08">August</option>
	            	<option value="09">September</option>
	            	<option value="10">October</option>
	            	<option value="11">November</option>
	            	<option value="12">December</option>
	            </select>
	            <select class="form-control" style="width: 70px" name="todd" required="required">
	            	<option value="">DD</option>
	            	<?php
	            	for($a=1;$a<=31;$a++){
	            		if(strlen($a)==1){
	            			echo "<option value='0$a'>0$a</option>";
	            		}
	            		else{
	            			echo "<option value='$a'>$a</option>";
	            		}
	            	}
	            	?>
	            </select>
	            <input class="form-control" style="width: 65px;" placeholder="YYYY" value="<?php echo date('Y'); ?>" maxlength="4" type="text" name="toyyyy" required="required">
	        </div>
	        <div class="form-group form-space-label form-space">
				<div class="form-label" style="width:600px;">Table Column:</div>
			</div>
			<div class="form-group ">
				<input type="checkbox" name="selectall" id="selectall" onclick="selectallcolumns()" value="1"> Select All Columns
			</div>
			<div class="form-group form-space-label form-space">
				<table style="margin-bottom: 10px;">
					<tr>
						<td><input type="checkbox" name="recievedate" id="recievedate"> Recieve Date&nbsp;</td>
						<td><input type="checkbox" name="barcde" id="barcde"> Barcode&nbsp;</td>
						<td><input type="checkbox" name="doctype" id="doctype"> Document Type&nbsp;</td>
						<td><input type="checkbox" name="sortype" id="sortype"> Source Type&nbsp;</td>
						<td><input type="checkbox" name="offsource" id="offsource"> Office Source&nbsp;</td>
					</tr>
					<tr>
						<td><input type="checkbox" name="gen" id="gen"> Gender&nbsp;</td>
						<td><input type="checkbox" name="contno" id="contno"> Contact No.&nbsp;</td>
						<td><input type="checkbox" name="eadd" id="eadd"> Email Address&nbsp;</td>
						<td><input type="checkbox" name="submatter" id="submatter"> Subject Matter&nbsp;</td>
						<td><input type="checkbox" name="totaltime" id="totaltime"> Total Time&nbsp;</td>
					</tr>

				</table>
			</div>
	        <div class="form-group form-space-label form-space">
				<div class="form-label" style="width:600px;">Conditions:</div>
			</div>
	        <div class="form-group form-space form-inline">
	       		<select class="form-control" name="transactiontype" id="transactiontype" style="width:182px;">
					<option value="">Transaction Type</option>
					<?php
						$qry_transaction_type = mysqli_query($connection,"select * from tbl_transaction_type where status='1' order by transaction asc");
						for($a=1;$a<=mysqli_num_rows($qry_transaction_type);$a++){
							$trans = mysqli_fetch_assoc($qry_transaction_type);
							echo "<option value='$trans[id]'>$trans[transaction]</option>";
						}
					?>
				</select>	
				<select class="form-control" name="documenttype" id="documenttype" style="width: 152px;">
					<option value="">Document Type</option>
					<?php
						$qry_doc_type = mysqli_query($connection,"select * from tbl_document_type where status='1' order by document_type asc");
						for($a=1;$a<=mysqli_num_rows($qry_doc_type);$a++){
							$trans = mysqli_fetch_assoc($qry_doc_type);
							echo "<option value='$trans[document_code]'>$trans[document_code]</option>";
						}
					?>
				</select>
				<select class="form-control" name="sourcetype" id="sourcetype" onchange="sourcelocation()" style="width: 200px;">
					<option value="">Source Type</option>
						<?php
							
							$qry_source = mysqli_query($connection,"select * from tbl_source where status='1' order by source asc");
							for($a=1;$a<=mysqli_num_rows($qry_source);$a++){
								$trans = mysqli_fetch_assoc($qry_source);
								echo "<option value='$trans[id]'>$trans[source]</option>";
							}
						?>
				</select>
	        	
			</div>
			<div class="form-group form-space form-inline">
				<select class="form-control" name="deliverymethod" id="deliverymethod" style="width:182px;">
					<option value="">Delivery Method</option>
					<?php
						$qry_delivery_method = mysqli_query($connection,"select * from tbl_delivery_method where status='1' order by id asc");
						for($a=1;$a<=mysqli_num_rows($qry_delivery_method);$a++){
							$meth = mysqli_fetch_assoc($qry_delivery_method);
							echo "<option value='$meth[id]'>$meth[method]</option>";
						}
					?>
				</select>	
	        	<select class="form-control" name="gender" id="gender" style="width: 152px;">
					<option value="">Select Gender</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>	
				</select>
				<select class="form-control" name="docustatus" id="docustatus" style="width: 200px;">
					<option value="">Document Status</option>
					<option value="O">On-Time Documents</option>
					<option value="D">Delayed Documents</option>	
					<option value="On">On-going Documents</option>
				</select>
			</div>
			<div class="form-group form-space-label form-space">
				<div class="form-label" style="width:600px;">Other Conditions:</div>
			</div>
			<div class="form-group form-space form-inline">
				<select class="form-control" name="directto" id="directto" style="width: 182px;">
					<option value="">Direct To</option>
					<option value="1">CMO</option>
					<option value="0">ADM</option>	
				</select>
				<select class="form-control" name="recuser" id="recuser" style="width:182px">
					<!--option value=""> // START OLD CODE, WAHID, 5-9-2019
					REC Office Users
					</option-- END OLD CODE, WAHID, 5-9-2019-->
					<!-- START OF NEW CODE
						 WAHID
						 5-9-2019 -->
					<option value="">SMO Office Users</option>
					<!-- END OF NEW CODE
						 WAHID
						 5-9-2019 -->
					<?php
						/** START OF OLD CODE
						 	WAHID
						 	5-9-2019 **/
						/**$qry_rec_users = mysqli_query($connection,"select * from tbl_users where office_code='REC' and status='1' order by username asc");**/
						/** END OF OLD CODE
						 	WAHID
						 	5-9-2019 **/

						/** START OF NEW CODE
						 	WAHID
						 	5-9-2019 **/
						$qry_smo_users = mysqli_query($connection,"select * from tbl_users where office_code='SMO' and status='1' order by username asc");
						/** END OF NEW CODE
						 	WAHID
						 	5-9-2019 **/

						for($a=1;$a<=mysqli_num_rows($qry_smo_users);$a++){
							$users = mysqli_fetch_assoc($qry_smo_users);
							echo "<option value='$users[username]'>".ucwords($users['full_name'])."</option>";
						}
					?>
				</select>
			   	<button type="submit" class="btn btn-primary" value="generate" name="generate">Generate</button>
			</div>
		</div>
	</form>

</body>
</html>