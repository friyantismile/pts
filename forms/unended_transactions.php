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
	<form action="../output/not_closed.php" method="post" target="_blank">
		<div class="report-container-office-trans">
			<h4>Unended Transactions</h4>
			<div class="form-group form-space-label form-space">
				<div class="form-label" style="width:600px;">Office:</div>
			</div>
			<div class="form-group form-inline">
				<select class="form-control" name="office" id="office" required="required">
	            	<?php
	            		//if($access['access_level']=='A' || $access['access_level']=='R'){
			            	$qry_office = mysqli_query($connection,"select * from tbl_office where status!='0' order by office_name asc");
			            	echo "<option value=''>Select Office</option>";
			            	for($a=1;$a<=mysqli_num_rows($qry_office);$a++){
			            		$data = mysqli_fetch_assoc($qry_office);
			            		echo "<option value='$data[office_code]'>$data[office_name]</option>";
			            	}
			            //}
			            // else{
			            // 	$qry_office = mysqli_query($connection,"select distinct(b.office_code), b.office_name from tbl_users a, tbl_office b where a.office_code=b.office_code and b.office_code='$access[office_code]'");
			            	
		            	// 	$data = mysqli_fetch_assoc($qry_office);
		            	// 	echo "<option value='$data[office_code]'>$data[office_name]</option>";
			            // }
	            	?>
	            </select>
			
				<button type="submit" class="btn btn-primary" value="generate" name="generate">Generate</button>
			</div>
		</div>
	</form>

</body>
</html>