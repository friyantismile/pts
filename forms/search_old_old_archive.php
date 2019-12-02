<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script>
		$(document).ready(function(){
		    $('#tablearchive').dataTable({
		    	"aaSorting": [[0, 'desc']] //sort in descending order
		    }
		    );
		});
	</script>
	<script type="text/javascript">
		function search(){
			sb = document.getElementById("searchby").value;
			if(sb=="4"){
				document.getElementById("searchtext").disabled = true;
				document.getElementById("searchtext").value = "";
				document.getElementById("searchtext").style.display = "none";
				document.getElementById("searchbydate").style.display = "inline";
				document.getElementById("btnsearchtext").style.display = "none";

				document.getElementById("frommm").disabled = true;
				document.getElementById("fromdd").disabled = true;
				document.getElementById("fromyyyy").disabled = true;
				document.getElementById("tommm").disabled = true;
				document.getElementById("todd").disabled = true;
				document.getElementById("toyyyy").disabled = true;
				
			}
			else{ //5
				document.getElementById("searchtext").disabled = false;
				document.getElementById("searchtext").value = "";
				document.getElementById("searchtext").focus();
				document.getElementById("searchtext").style.display = "inline";

				document.getElementById("searchbydate").style.display = "none";
				document.getElementById("btnsearchtext").style.display = "inline";


			}
		}
	</script>
</head>
<body>
	<div class="archive-container">
		<div class="">
			<div class="form-group form-inline">
			<form action="home.php?menu=searcholdoldarchive&form=entry&table=text" method="post">
				Search By:
				<select class="form-control" id="searchby" name="searchby" onchange="search()" required="required">
					<option value="">Select One</option>
					<option value="1">Reference No.</option>
					<option value="2">Source</option>
					<option value="3">Subject Matter</option>
					<option value="4">Date Range</option>
				</select>
				<input type="text" class="form-control" name="searchtext" id="searchtext" placeholder="Enter Keyword" required="required">
				<button type="submit" class="btn btn-primary" name="btnsearchtext" id="btnsearchtext">Search</button>
			</form>
		</div>
		<div class="form-group form-inline" id="searchbydate" style="display: none;">
			<form action="home.php?menu=searcholdoldarchive&form=entry&table=date" method="post">
				From 
	            <select class="form-control" name="frommm" required="required" style="width: 85px;">
	            	<option value="">Month</option>
	            	<option value="01">Jan</option>
	            	<option value="02">Feb</option>
	            	<option value="03">Mar</option>
	            	<option value="04">Apr</option>
	            	<option value="05">May</option>
	            	<option value="06">Jun</option>
	            	<option value="07">Jul</option> 
	            	<option value="08">Aug</option>
	            	<option value="09">Sep</option>
	            	<option value="10">Oct</option>
	            	<option value="11">Nov</option>
	            	<option value="12">Dec</option>
	            </select>
	            <select class="form-control" style="width: 70px;" name="fromdd" required="required">
	            	<option value="">DD</option>
	            	<?php
	            	for($a=1;$a<=30;$a++){
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
	            To
	            <select class="form-control" name="tomm" style="width: 85px;" required="required">
	            	<option value="">Month</option>
	            	<option value="01">Jan</option>
	            	<option value="02">Feb</option>
	            	<option value="03">Mar</option>
	            	<option value="04">Apr</option>
	            	<option value="05">May</option>
	            	<option value="06">Jun</option>
	            	<option value="07">Jul</option>
	            	<option value="08">Aug</option>
	            	<option value="09">Sep</option>
	            	<option value="10">Oct</option>
	            	<option value="11">Nov</option>
	            	<option value="12">Dec</option>
	            </select>
	            <select class="form-control" style="width: 70px" name="todd" required="required">
	            	<option value="">DD</option>
	            	<?php
	            	for($a=1;$a<=30;$a++){
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
	            <button type="submit" class="btn btn-primary" name="btnsearchdate" id="btnsearchdate">Search</button>
            </form>
		</div>
		<br>
		<?php
		if(isset($_REQUEST['btnsearchtext'])||isset($_REQUEST['btnsearchdate']))
		{
		?>
			<div class="archive-table">
				<table id="tablearchive" class="table table-striped table-hover" >  
		            <thead>  
		                <tr>  
		                	<th class="no-sort">Reference No.</th> 
		                    <th>Source</th> 
		                    <th>Subject Matter</th>
		                    <th>Entered By</th>
		                    <th>Date</th>
		                    <th width="50px">View</th>                    
		                </tr>  
		            </thead> 
		            <tbody>
		            	<?php
		            	if($_REQUEST['table']=="text"){

		            		if($_REQUEST['searchby']==1){
		            			$condition = "doc_ref like '%$_REQUEST[searchtext]%'";
		            			$conditionlog = "REFERENCE NO $_REQUEST[searchtext]";
		            		}
		            		else if($_REQUEST['searchby']==2){
		            			$condition = "source_doc like '%$_REQUEST[searchtext]%'";
		            			$conditionlog = "SOURCE $_REQUEST[searchtext]";
		            		} 
		            		else if($_REQUEST['searchby']==3){
		            			$condition = "subject_doc like '%$_REQUEST[searchtext]%'";
		            			$conditionlog = "SUBJECT $_REQUEST[searchtext]";
		            		}
		            		
	            			$show = mysqli_query($connection2,"select * from tbl_doc where $condition");
	            			logs($access['username'],"SEARCH DOCUMENT ON DTS V1. SEARCH BY: $conditionlog.");
	            		}
	            		else{
	            			$show = mysqli_query($connection2,"select * from tbl_doc where new_date between '$_REQUEST[fromyyyy]-$_REQUEST[frommm]-$_REQUEST[fromdd]' and '$_REQUEST[toyyyy]-$_REQUEST[tomm]-$_REQUEST[todd]'");

	            			//logs($access['username'],"SEARCH DOCUMENT ON DTS V1. SEARCH DATE: $_REQUEST[fromyyyy]-$_REQUEST[frommm]-$_REQUEST[fromdd] TO $_REQUEST[toyyyy]-$_REQUEST[tomm]-$_REQUEST[todd]");
	            		}
	            		
	            		for($a=1;$a<=mysqli_num_rows($show);$a++){
	            			$data = mysqli_fetch_assoc($show);
	            			echo "<tr class=''>";
	            			echo "<td>$data[doc_ref]</td>";
	            			echo "<td>$data[source_doc]</td>";
	            			echo "<td>$data[subject_doc]</td>";
	            			echo "<td>$data[enter_doc]</td>";
	            			echo "<td>$data[date_doc]</td>";
	            			echo "<td>";
	            			echo "<a href='home.php?menu=viewoldolddocument&referenceno=$data[doc_ref]' target='_blank'><img src='../images/view.png' title='View Document' class='action-btn'></a>";
	            			echo "</td>";
	            			echo "</tr>";
	            		}
		            	?>
		            </tbody>
		        </tbody>
			</div>
		<?php  
		}
		else{

		}
		?>
	</div>

</body>
</html>