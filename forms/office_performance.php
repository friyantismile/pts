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
	<form action="../output/office_performance_transactions.php" method="post" target="_blank">
		<div class="report-container-delin">
			<h4>Office Performance</h4>
			<div class="form-group form-inline">
				<input type="hidden" value="<?php echo $access['full_name'];?>" name="user" id="user">
	            <select class="form-control" style="width: 360px;" name="frommm" required="required">
	            	<option value="">Select Month</option>
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
	            <input class="form-control" style="width: 65px;" placeholder="YYYY" value="<?php echo date('Y'); ?>" maxlength="4" type="text" name="fromyyyy" required="required">
	            <button type="submit" class="btn btn-primary" value="generate" name="generate">Generate</button>
	        </div>
		</div>
	</form>

</body>
</html>