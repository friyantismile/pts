<!DOCTYPE html>
<html>
<head>
	<title>Document Tracking System</title>
	<script type="text/javascript">
		function disable_month(){
			
			df = document.getElementById("datefilter").value;
			
			if(df=="1"){
				document.getElementById("month").disabled = false;
			}
			else{
				document.getElementById("month").disabled = true;
			}
			
		}
	</script>
	<link rel="icon" href="../images/dts.png" type="image/gif" sizes="16x16">
</head>
<body>
	<form action="../output/graph.php" method="post" target="_blank">
		<div class="reportgraph-container">
			<h4>Generate Graphical Representation</h4>
			<div class="form-group form-inline">
				<b>Report Title:</b>&nbsp;&nbsp;<input class="form-control" style="width: 432px;" placeholder="Report Title" type="text" name="reporttitle" id="reporttitle" required="required">
			</div>
			<div class="form-group form-inline">
				<b>Date Filter :</b>&nbsp;&nbsp;
	            <select class="form-control" name="datefilter" id="datefilter" required="required" onchange="disable_month()" style="width: 200px" required="required">
	            	<option value="">Select One</option>
	            	<option value="1">Per Month</option>
	            	<option value="2">Annual</option>
	            	<option value="3">1st Quarter</option>
	            	<option value="4">2nd Quarter</option>
	            	<option value="5">3rd Quarter</option>
	            	<option value="6">4th Quarter</option>
	            </select>
	            <select id="month" class="form-control" id="month" name="month" style="width: 160px;" disabled="disabled" required="required">
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
	            <input class="form-control" style="width: 65px;" placeholder="YYYY" value="<?php echo date('Y'); ?>" maxlength="4" type="text" name="yyyy" id="yyyy" required="required">
	            
	        </div>
	        <div class="form-group form-space form-inline">
	        	<b>Data Filter :</b> &nbsp;
	        	<select class="form-control" name="datafilter" id="datafilter" onchange="disable_filter()" required="required" style="width: 200px">
	        		<option value="">Report Type</option>
	        		<option value="1">Total Documents</option>
	        		<option value="2">In Progress Documents</option>
	        		<option value="3">Finished Documents</option>
	        		<option value="4">On-Time Documents</option>
	        		<option value="5">Delayed Documents</option>
	        		<option value="6">Delayed Office Transactions</option>
	        	</select>
	        	<select class="form-control" name="dataset" id="dataset" style="width: 230px;" required="required">
					<option value="">Data Set</option>
					<option value="1">Gender and Development</option>
					<option value="2">Document Source</option>	
					<option value="3">Document Type</option>	
					<option value="4">Transaction Type</option>	
					<option value="5">Delivery Method</option>	
				</select>
				<input type="hidden" name="accessname" id="accessname" value="<?php echo $access['full_name'];?>"
			</div>
			<div class="form-group form-space form-inline" style="text-align: right; margin-right: 30px;">
				<button type="submit" class="btn btn-primary" value="generate" name="generate">Generate</button>
			</div>
		</div>
	</form>
	
</body>
</html>