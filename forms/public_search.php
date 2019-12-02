<?php
	include("../database/database_connection.php");
  	include_once('../functions/login_functions.php');
 	verify_valid_system_user();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Document Tracking System</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<script src="../bootstrap/js/jquery.min.js"></script>
	<script src="../bootstrap/js/bootstrap.min.js"></script>

	<!-- other css -->
	<link rel="stylesheet" href="../bootstrap/css/designs.min.css">

	<!-- For Tables -->
	<link rel="stylesheet" href="../bootstrap/css/dataTables.min.css">
	<script type="text/javascript" src="../bootstrap/js/dataTables.min.js"></script>

	<link rel="icon" href="../images/dts.png" type="image/gif" sizes="16x16">
 
</head>
<script type="text/javascript">
		function sourcelocation(){
			st = document.getElementById("sourcetype").value;
			if(st=="INT"){
				document.getElementById("sourceoffice").style.display = "inline";
				document.getElementById("sourceoffice").disabled = false;
				document.getElementById("so").style.display = "none";
				document.getElementById("sourcecontact").value = "-";
				document.getElementById("sourcecontact").readOnly = true;
			}
			else{
				document.getElementById("sourceoffice").style.display = "none";
				document.getElementById("sourceoffice").disabled = true;
				document.getElementById("so").style.display = "inline";
				document.getElementById("sourcecontact").value = "";
				document.getElementById("sourcecontact").readOnly = false;
			}
		}
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
		function confirmclick(){
			return confirm("Are you sure you want to delete the selected document?");
		}
	</script>
<body class="body_color">
<div>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
			<div class="navbar-header" style="margin-left:-14px; height: 55px; width: 230px;">
				<a href="public_search.php?table=default">
				<div class="banner_title">
		            <div class="bpls_title">
		                DOCUMENT TRACKING SYSTEM
		            </div>
		            <div class="bpls_subtitle">
		                VERSION 3
		            </div>
		        </div>
		   		</a>
			</div>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="logout.php">Logout</a></li>
			 
			</ul>
			</div>
		</nav>
	</div>
 
<div class="col-md-12 " style="height:630px;">
		<div class="form-group form-inline">
			<form action="public_search.php?table=text" method="post">
				Search By:
				<select class="form-control" id="searchby" name="searchby" onchange="search()" required="required">
					<option value="1">Communication Summary</option>
					<option value="2">Source Name</option>
					<option value="3" selected>Barcode</option>
					<option value="4">Date Range</option>
				</select>
				<input type="text" class="form-control" name="searchtext" id="searchtext" placeholder="Enter Keyword" required="required">
				<button type="submit" class="btn btn-primary" name="btnsearchtext" id="btnsearchtext">Search</button>
			</form>
		</div>
		<div class="form-group form-inline" id="searchbydate" style="display: none;">
			<form action="home.php?menu=newdocument&form=entry&table=date" method="post">
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
	            <button type="submit" class="btn btn-primary" name="btnsearchdate" id="btnsearchdate">Search</button>
            </form>
		</div>
		<br>
        <div class="panel">
		<table id="tabledocument" class="table table-striped table-hover" >  
            <thead>  
                <tr>  
                	<th class="no-sort">#</th> 
                    <th>Barcode</th> 
                    <th>Communication Summary</th>
                    <th>Source Name</th> 
                                      
                </tr>  
            </thead> 
            <tbody>
            	<?php
            		if($_REQUEST['table']=="default"){
            			$show = mysqli_query($connection,"select * from tbl_document where status='1' order by id desc limit 300");
            			
            		}
            		else if($_REQUEST['table']=="text"){
            			if($_REQUEST['searchby']==1){
            				$search = "subject_matter like '%$_REQUEST[searchtext]%' ";
            			}
            			else if($_REQUEST['searchby']==2){
            				$search = "source_name like '%$_REQUEST[searchtext]%' ";
            			}
            			else if($_REQUEST['searchby']==3){
            				$search = "barcode = '$_REQUEST[searchtext]' ";	
            			}
            			else{
            				$search = "";
            			}
            			$show = mysqli_query($connection,"select * from tbl_document where status='1' and $search");
            		}
            		else{
            			$show = mysqli_query($connection,"select * from tbl_document where status='1' and recieve_date between '$_REQUEST[fromyyyy]-$_REQUEST[frommm]-$_REQUEST[fromdd] 01:00:00' and '$_REQUEST[toyyyy]-$_REQUEST[tomm]-$_REQUEST[todd] 23:59:59'");
					}
					
					
					 
            		for($a=1;$a<=mysqli_num_rows($show);$a++){
						$data = mysqli_fetch_assoc($show);
						
						//Modification
						//Modified by : Yants
						//Modified date : 04/30/2019
						//Description : check number of routed offices
			 
						$routed_offices = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$data[barcode]' and (sequence = 1 and (office_code!='SMO' || route_office_code!=''))");
						$num_routed_offices = mysqli_num_rows($routed_offices);
						//end code
            			echo "<tr>";
            			echo "<td >$data[id]</td>";
            			echo "<td><a href='view_track.php?barcode=$data[barcode]' target='_blank'>$data[barcode]</a></td>";
            			echo "<td>";
            			$len = strlen($data['subject_matter']);
            			if($len>=100){
            				echo substr($data['subject_matter'],0,100)." ";
            				echo "<div style='display:none'>".$data['subject_matter']."</div>";
            				echo "<br>";
            				echo "<a href='' data-toggle='modal' data-target='#subjectMatterModal' data-description='".str_replace("'","&#39;",$data['subject_matter'])."' style='font-size:11px;'>Read More</a>";
            			}
            			else{
            				echo $data['subject_matter'];
            			}
            			echo "</td>";
            			//echo "<td>$data[subject_matter]</td>";
            			echo "<td>".ucwords($data['source_name'])."</td>";
            			
            			echo "</tr>";
            		}
            	?>
            </tbody>
         </table>
	
    
    </div></div>
</body>
</html>
<script>
		$(document).ready(function(){
		    $('#tabledocument').dataTable({
		    	"aaSorting": [[0, 'desc']] //sort in descending order
		    }
		    );
		   
		});
	</script>