<?php
	include("../database/database_connection.php");
  	include_once('../functions/login_functions.php');
 	verify_valid_system_user();
?>
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
		    $('.too-long').popover();
		});
	</script>
	<script type="text/javascript">
		function search(){
			sb = document.getElementById("searchby").value;
			
			if(sb=="4"){ //transaction type
				document.getElementById("searchtext").value = "";
				document.getElementById("searchtext").style.display = "none";
				
				document.getElementById("btnsearchtext").style.display = "inline";


				document.getElementById("documenttype").style.display = "none";
				document.getElementById("sourcetype").style.display = "none";
				document.getElementById("sourceoffice").style.display = "none";
				document.getElementById("deliverymethod").style.display = "none";
				document.getElementById("gender").style.display = "none";

				document.getElementById("transactiontype").style.display = "inline";
				document.getElementById("transactiontype").required = true;

				document.getElementById("searchbydate").style.display = "none";		
				document.getElementById("frommm").disabled = true;
				document.getElementById("fromdd").disabled = true;
				document.getElementById("fromyyyy").disabled = true;
				document.getElementById("tommm").disabled = true;
				document.getElementById("todd").disabled = true;
				document.getElementById("toyyyy").disabled = true;

			}

			else if(sb=="5"){ //document type
				document.getElementById("searchtext").value = "";
				document.getElementById("searchtext").style.display = "none";
				document.getElementById("btnsearchtext").style.display = "inline";

				document.getElementById("transactiontype").style.display = "none";
				document.getElementById("sourcetype").style.display = "none";
				document.getElementById("sourceoffice").style.display = "none";
				document.getElementById("deliverymethod").style.display = "none";
				document.getElementById("gender").style.display = "none";

				document.getElementById("documenttype").style.display = "inline";
				document.getElementById("documenttype").required = true;

				document.getElementById("searchbydate").style.display = "none";		
				document.getElementById("frommm").disabled = true;
				document.getElementById("fromdd").disabled = true;
				document.getElementById("fromyyyy").disabled = true;
				document.getElementById("tommm").disabled = true;
				document.getElementById("todd").disabled = true;
				document.getElementById("toyyyy").disabled = true;

			}

			else if(sb=="6"){ //source type
				document.getElementById("searchtext").value = "";
				document.getElementById("searchtext").style.display = "none";
				document.getElementById("btnsearchtext").style.display = "inline";



				document.getElementById("transactiontype").style.display = "none";
				document.getElementById("documenttype").style.display = "none";
				document.getElementById("sourceoffice").style.display = "none";
				document.getElementById("deliverymethod").style.display = "none";
				document.getElementById("gender").style.display = "none";

				document.getElementById("sourcetype").style.display = "inline";
				document.getElementById("sourcetype").required = true;

				document.getElementById("searchbydate").style.display = "none";		
				document.getElementById("frommm").disabled = true;
				document.getElementById("fromdd").disabled = true;
				document.getElementById("fromyyyy").disabled = true;
				document.getElementById("tommm").disabled = true;
				document.getElementById("todd").disabled = true;
				document.getElementById("toyyyy").disabled = true;

			}

			else if(sb=="7"){ //office source
				document.getElementById("searchtext").value = "";
				document.getElementById("searchtext").style.display = "none";
				document.getElementById("btnsearchtext").style.display = "inline";



				document.getElementById("transactiontype").style.display = "none";
				document.getElementById("documenttype").style.display = "none";
				document.getElementById("sourcetype").style.display = "none";
				document.getElementById("deliverymethod").style.display = "none";
				document.getElementById("gender").style.display = "none";

				document.getElementById("sourceoffice").style.display = "inline";
				document.getElementById("sourceoffice").required = true;

				document.getElementById("searchbydate").style.display = "none";		
				document.getElementById("frommm").disabled = true;
				document.getElementById("fromdd").disabled = true;
				document.getElementById("fromyyyy").disabled = true;
				document.getElementById("tommm").disabled = true;
				document.getElementById("todd").disabled = true;
				document.getElementById("toyyyy").disabled = true;

			}

			else if(sb=="8"){ //delivery
				document.getElementById("searchtext").value = "";
				document.getElementById("searchtext").style.display = "none";
				document.getElementById("btnsearchtext").style.display = "inline";



				document.getElementById("transactiontype").style.display = "none";
				document.getElementById("documenttype").style.display = "none";
				document.getElementById("sourcetype").style.display = "none";
				document.getElementById("sourceoffice").style.display = "none";
				document.getElementById("gender").style.display = "none";

				document.getElementById("deliverymethod").style.display = "inline";
				document.getElementById("deliverymethod").required = true;

				document.getElementById("searchbydate").style.display = "none";		
				document.getElementById("frommm").disabled = true;
				document.getElementById("fromdd").disabled = true;
				document.getElementById("fromyyyy").disabled = true;
				document.getElementById("tommm").disabled = true;
				document.getElementById("todd").disabled = true;
				document.getElementById("toyyyy").disabled = true;

			}

			else if(sb=="9"){ //gender
				document.getElementById("searchtext").value = "";
				document.getElementById("searchtext").style.display = "none";
				document.getElementById("btnsearchtext").style.display = "inline";

				document.getElementById("transactiontype").style.display = "none";
				document.getElementById("documenttype").style.display = "none";
				document.getElementById("sourcetype").style.display = "none";
				document.getElementById("sourceoffice").style.display = "none";
				document.getElementById("deliverymethod").style.display = "none";

				document.getElementById("gender").style.display = "inline";
				document.getElementById("gender").required = true;

				
				document.getElementById("searchbydate").style.display = "none";		
				document.getElementById("frommm").disabled = true;
				document.getElementById("fromdd").disabled = true;
				document.getElementById("fromyyyy").disabled = true;
				document.getElementById("tommm").disabled = true;
				document.getElementById("todd").disabled = true;
				document.getElementById("toyyyy").disabled = true;

			}

			else if(sb=="10"){ // date range
				document.getElementById("searchtext").disabled = true;
				document.getElementById("searchtext").value = "";
				document.getElementById("searchtext").style.display = "none";
				document.getElementById("searchbydate").style.display = "inline";
				document.getElementById("btnsearchtext").style.display = "none";


				document.getElementById("transactiontype").style.display = "none";
				document.getElementById("documenttype").style.display = "none";
				document.getElementById("sourcetype").style.display = "none";
				document.getElementById("sourceoffice").style.display = "none";
				document.getElementById("deliverymethod").style.display = "none";
				document.getElementById("gender").style.display = "none";
				

			}

			else{  //1,2, 3
				document.getElementById("searchtext").disabled = false;
				document.getElementById("searchtext").value = "";
				document.getElementById("searchtext").focus();
				document.getElementById("searchtext").style.display = "inline";
				document.getElementById("searchtext").required = true;
				document.getElementById("btnsearchtext").style.display = "inline";



				document.getElementById("transactiontype").style.display = "none";
				document.getElementById("documenttype").style.display = "none";
				document.getElementById("sourcetype").style.display = "none";
				document.getElementById("sourceoffice").style.display = "none";
				document.getElementById("deliverymethod").style.display = "none";
				document.getElementById("gender").style.display = "none";

				document.getElementById("searchbydate").style.display = "none";
				document.getElementById("btnsearchtext").style.display = "inline";


			}
		}
	</script>
</head>
<body>
	<div class="archive-container">
		<!--
		<div class="archive-search">
			<div class="form-group form-inline form-space">
				<input type="text" class="form-control" name="" id="" placeholder="Advance Search" required="required">
	        </div>
		</div>
		-->
		<div class="">
			<div class="form-group form-inline">
			<form action="home.php?menu=archive&form=entry&table=text" method="post">
				Search By:
				<select class="form-control" id="searchby" name="searchby" onchange="search()" required="required">
					<option value="">Select One</option>
					<option value="1">Subject Matter</option>
					<option value="2">Source Name</option>
					<option value="3">Barcode</option>
					<option value="4">Transaction Type</option>
					<option value="5">Document Type</option>
					<option value="6">Source Type</option>
					<option value="7">Office Source</option>
					<option value="8">Delivery Method</option>
					<option value="9">Gender</option>
					<option value="10">Date Range</option>
				</select>
				<input type="text" class="form-control" name="searchtext" id="searchtext" placeholder="Enter Keyword">

				<select class="form-control" id="transactiontype" name="transactiontype" style="display: none">
					<option value="">Select One</option>
					<option value="SIMP">Simple</option>
					<option value="COMP">Complex</option>
				</select>

				<select class="form-control" id="documenttype" name="documenttype" style="display: none">
					<option value="">Select One</option>
					<?php
						$qry_doc_type = mysqli_query($connection,"select * from tbl_document_type where status='1' order by document_type asc");
						for($a=1;$a<=mysqli_num_rows($qry_doc_type);$a++){
							$trans = mysqli_fetch_assoc($qry_doc_type);
							echo "<option value='$trans[document_code]'>$trans[document_type]</option>";
						}

					?>
				</select>

				<select class="form-control" id="sourcetype" name="sourcetype" style="display: none">
					<option value="">Select One</option>
					<option value="INT">Internal</option>
					<option value="EXT">External</option>
				</select>

				<select class="form-control" name="sourceoffice" id="sourceoffice" style="display: none">
					<option value="">Select One</option>
					<?php
						$qry_source = mysqli_query($connection,"select * from tbl_office where status='1' order by office_code asc");
						for($a=1;$a<=mysqli_num_rows($qry_source);$a++){
							$trans = mysqli_fetch_assoc($qry_source);
							echo "<option value='$trans[office_code]'>$trans[office_code] - $trans[office_name]</option>";
						}
					?>
				</select>

				<select class="form-control" name="deliverymethod" id="deliverymethod" style="display: none">
					<option value="">Select One</option>
					<?php
						$qry_method = mysqli_query($connection,"select * from tbl_delivery_method where status='1' order by method asc");
						for($a=1;$a<=mysqli_num_rows($qry_method);$a++){
							$trans = mysqli_fetch_assoc($qry_method);
							echo "<option value='$trans[id]'>$trans[method]</option>";
						}
					?>
				</select>

				<select class="form-control" name="gender" id="gender" style="display: none">
					<option value="">Select One</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
					
				</select>

				<button type="submit" class="btn btn-primary" name="btnsearchtext" id="btnsearchtext">Search</button>
			</form>
		</div>
		<div class="form-group form-inline" id="searchbydate" style="display: none;">
			<form action="home.php?menu=archive&form=entry&table=date" method="post">
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
		if(isset($_REQUEST['btnsearchtext'])||isset($_REQUEST['btnsearchdate'])){
		?>
		<div class="archive-table">
			<table id="tablearchive" class="table table-striped table-hover" >  
	            <thead>  
	                <tr>  
	                	<th width="50px" class="no-sort">#</th> 
	                    <th width="100px">Barcode</th> 
	                    <th width="100px">Date</th> 
	                    <th width="100px" class="no-sort">Doc. Type</th> 
	                    <th width="250px">Source</th>
	                    <th>Subject Matter</th>
	                    <th width="50px">View</th>                    
	                </tr>  
	            </thead> 
	            <tbody>
	            	<?php
	               		if($_REQUEST['table']=="default"){
	            			$show = mysqli_query($connection,"select *,date_format(recieve_date,'%b. %d, %Y')datef from tbl_document where status='1' order by id desc limit 300");
	            		}
	            		else if($_REQUEST['table']=="text"){
	            			if($_REQUEST['searchby']==1){
	            				$search = "subject_matter like '%$_REQUEST[searchtext]%' ";
	            			}
	            			else if($_REQUEST['searchby']==2){
	            				$search = "source_name like '%$_REQUEST[searchtext]%' ";
	            			}
	            			else if($_REQUEST['searchby']==3){
	            				$search = "barcode like '%$_REQUEST[searchtext]%' ";	
	            			}
	            			else if($_REQUEST['searchby']==4){
	            				$search = "transaction_type = '$_REQUEST[transactiontype]' ";	
	            			}
	            			else if($_REQUEST['searchby']==5){
	            				$search = "document_type = '$_REQUEST[documenttype]' ";	
	            			}
	            			else if($_REQUEST['searchby']==6){
	            				$search = "source_type = '$_REQUEST[sourcetype]' ";	
	            			}
	            			else if($_REQUEST['searchby']==7){
	            				$search = "office_code = '$_REQUEST[sourceoffice]' ";	
	            			}
	            			else if($_REQUEST['searchby']==8){
	            				$search = "delivery_method = '$_REQUEST[deliverymethod]' ";	
	            			}
	            			else if($_REQUEST['searchby']==9){
	            				$search = "gender = '$_REQUEST[gender]' ";	
	            			}

	            			$show = mysqli_query($connection,"select *,date_format(recieve_date,'%b. %d, %Y')datef from tbl_document where status='1' and $search");
	            		}
	            		else{
	            			$show = mysqli_query($connection,"select *,date_format(recieve_date,'%b. %d, %Y')datef from tbl_document where status='1' and recieve_date between '$_REQUEST[fromyyyy]-$_REQUEST[frommm]-$_REQUEST[fromdd] 01:00:00' and '$_REQUEST[toyyyy]-$_REQUEST[tomm]-$_REQUEST[todd] 23:59:59'");
	            		}

	            		for($a=1;$a<=mysqli_num_rows($show);$a++){
	            			$data = mysqli_fetch_assoc($show);
	            			echo "<tr class=''>";
	            			echo "<td>$data[id]</td>";
	            			echo "<td>$data[barcode]</td>";
	            			echo "<td>$data[datef]</td>";
	            			echo "<td>$data[document_type]</td>";
	            			if($data['source_type']=="INT"){
	            				$source = "Internal (".$data['office_code'].") - ".$data['source_name'];
	            			}
	            			else{
	            				$source = "External - ".$data['source_name'];
	            			}
	            			//echo "<td>$data[source_type] - ".ucwords($data['source_name'])."</td>";
	            			echo "<td>".$source."</td>";

	            			echo "<td>";
	            			$len = strlen($data['subject_matter']);
	            			if($len>=100){
	            				echo substr($data['subject_matter'],0,100)." ";
								echo "<div style='display:none'>".$data['subject_matter']."</div>";
            					echo "<a href='' data-toggle='modal' data-target='#subjectMatterModal' data-description='$data[subject_matter]' style='font-size:11px;'>Read More</a>";
	            			}
	            			else{
	            				echo $data['subject_matter'];

	            			}
	            			echo "</td>";
	            			//echo "<td>$data[source_type] - $data[source_name] ($data[office_code])</td>";
	            			//echo "<td>$data[access_code]</td>";
	            			echo "<td>";
	            			echo "<a href='home.php?menu=viewdocument&barcode=$data[barcode]' target='_blank'><img src='../images/view.png' title='View Document' class='action-btn'></a>";
	            			echo "</td>";
	            			echo "</tr>";
	            		}
	            	?>
	            </tbody>
	         </table>
		</div>
		<!-- modalSubjectMatter -->
		<div class="modal fade" id="subjectMatterModal" tabindex="-1" role="dialog" aria-labelledby="descriptionModalLabel" aria-hidden="true">
	        <div class="modal-dialog modal-md">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                    <h4>Subject Matter</h4>
	                </div>
	                <div class="modal-body" style="margin-top:-5px;">
	                	<!-- <input type="text" style="width:250px;" class="form-control" id="" name="" placeholder="">  -->
	                	<textarea class="form-control" rows="20" readonly="readonly">
	                	</textarea>   
	                </div>
	            </div>
	        </div>
	    </div>
		<script type="text/javascript">
			$('#subjectMatterModal').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var recipient = button.data('description') // Extract info from data-* attributes
				// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
				// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
				var modal = $(this)
				modal.find('.modal-body textarea').val(recipient)
			})
	    </script>
	    <!-- modalSubjectMatter -->
	<?php
	}
	else{
		//none
	}
	?>
	</div>
</body>
</html>