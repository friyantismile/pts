<!DOCTYPE html>
<html>
<head>
	<title>Document Tracking System</title>
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
	<link rel="icon" href="../images/dts.png" type="image/gif" sizes="16x16">
</head>
<body>
	<form action="../output/office_transactions.php" method="post" target="_blank">
		<div class="report-container-office-trans">
			<h4>Office Transactions Summary</h4>
			<div class="form-group form-space-label form-space">
				<div class="form-label" style="width:600px;">Office:</div>
			</div>
			<div class="form-group" style="width: 530px;">
				<select class="form-control" name="office" id="office" required="required">
	            	<?php
	            		if($access['access_level']=='A' || $access['access_level']=='R'){
			            	$qry_office = mysqli_query($connection,"select * from tbl_office where status!='0' order by office_name asc");
			            	echo "<option value=''>Select Office</option>";
			            	for($a=1;$a<=mysqli_num_rows($qry_office);$a++){
			            		$data = mysqli_fetch_assoc($qry_office);
			            		echo "<option value='$data[office_code]'>$data[office_name]</option>";
			            	}
			            }
			            else{
			            	$qry_office = mysqli_query($connection,"select distinct(b.office_code), b.office_name from tbl_users a, tbl_office b where a.office_code=b.office_code and b.office_code='$access[office_code]'");
			            	
		            		$data = mysqli_fetch_assoc($qry_office);
		            		echo "<option value='$data[office_code]'>$data[office_name]</option>";
			            }
	            	?>
	            </select>
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
	        
			<div class="form-group form-space form-inline" style="margin-left: 455px;">
				<button type="submit" class="btn btn-primary" value="generate" name="generate">Generate</button>
			</div>
		</div>
	</form>

</body>
</html>