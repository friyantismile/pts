<?php
	include("../database/database_connection.php");
  	include_once('../functions/login_functions.php');
 	verify_valid_system_user();

 	if($access['access_level']=="R" || $access['access_level']=="A"){

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
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
	<script>
		$(document).ready(function(){
		    $('#tabledocument').dataTable({
		    	"aaSorting": [[0, 'desc']] //sort in descending order
		    }
		    );
		    $('.too-long').popover();


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
		function confirmclick(){
			return confirm("Are you sure you want to delete the selected document?");
		}
	</script>
</head>
<body>
	<?php
		include("../functions/random_function.php");
	?>
	<div class="form-new-document" style="height: 630px;">
		<?php
		if($_REQUEST['form']=="entry"){
		?>
			<form action="home.php?menu=newdocument&form=entry&table=default&searchby" method="post" autocomplete="off">
				<h4>New Document</h4>
				<div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:175px;">Barcode</div>
					<div class="form-label" style="width:155px;">Transaction Type</div>
					<div class="form-label" style="width:175px;">Document Type</div>
				</div>
				<div class="form-group form-inline form-space">
					 
<input type="text" class="form-control" list="communication" style="width: 170px;" name="barcode" id="barcode" placeholder="Barcode (Max 20)" maxlength="20" required="required" >

<datalist id="communication">
  <option value="COI1900000000">
  <option value="COO1900000000">
</datalist>

					<select class="form-control" style="width:150px;" name="transactiontype" id="transactiontype" required="required">
						<option value="">Select One</option>
						<?php
							$qry_transaction_type = mysqli_query($connection,"select * from tbl_transaction_type where status='1' order by days asc");
							for($a=1;$a<=mysqli_num_rows($qry_transaction_type);$a++){
								$trans = mysqli_fetch_assoc($qry_transaction_type);
								echo "<option value='$trans[id]'>$trans[transaction]</option>";
							}
						?>
					</select>
					<select class="form-control" style="width:180px;" name="documenttype" id="documenttype" required="required">
						<option value="">Select One</option>
						<?php
							$qry_doc_type = mysqli_query($connection,"select * from tbl_document_type where status='1' order by document_type asc");
							for($a=1;$a<=mysqli_num_rows($qry_doc_type);$a++){
								$trans = mysqli_fetch_assoc($qry_doc_type);
								echo "<option value='$trans[document_code]'>$trans[document_type]</option>";
							}
						?>
					</select>
		        </div>
		        <div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:175px;">Source Type</div>
					<div class="form-label" style="width:175px;">Source Location</div>
				</div>
		        <div class="form-group form-inline form-space">
		       		<select class="form-control" style="width:171px;" name="sourcetype" id="sourcetype" onchange="sourcelocation()" required="required">
						<option value="">Select One</option>
						<?php
							$qry_source = mysqli_query($connection,"select * from tbl_source where status='1' order by source asc");
							for($a=1;$a<=mysqli_num_rows($qry_source);$a++){
								$trans = mysqli_fetch_assoc($qry_source);
								echo "<option value='$trans[id]'>$trans[source]</option>";
							}
						?>
					</select>
					<select class="form-control" style="width:333px;" name="sourceoffice" id="sourceoffice" required="required" disabled="disabled">
						<option value="">Select One</option>
						<?php
							$qry_source = mysqli_query($connection,"select * from tbl_office where status='1' order by office_name DESC");
							for($a=1;$a<=mysqli_num_rows($qry_source);$a++){
								$trans = mysqli_fetch_assoc($qry_source);
								echo "<option value='$trans[office_code]'>$trans[office_code] - $trans[office_name]</option>";
							}
						?>
					</select>
					<input type="text" class="form-control" style="width:333px; display: none;" name="so" id="so" value="N/A" readonly="readonly">
		        </div>
		        <div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:175px;">Delivery Method</div>
					<div class="form-label" style="width:175px;">Source Name</div>
				</div>
		        <div class="form-group form-inline form-space">
		        	<!-- START OF OLD CODE
		        		FROM REQUIRED TO NON-REQUIRED
		        		WAHID 4/29/2019
		        	<select class="form-control" style="width:171px;" name="deliverymethod" id="deliverymethod" required="required"
					END OF OLD CODE
					FROM REQUIRED TO NON-REQUIRED
		        	WAHID 4/29/2019
		        	-->
		        	<!-- START OF NEW CODE
		        		 FROM REQUIRED TO NON-REQUIRED
		        		 WAHID 4/29/2019 -->
		        	<select class="form-control" style="width:171px;" name="deliverymethod" id="deliverymethod" required="required">
		        	<!-- END OF NEW CODE
		        		 FROM REQUIRED TO NON-REQUIRED
		        		 WAHID 4/29/2019 -->
						<option value="">Delivery Method</option>
						<?php
							$qry_method = mysqli_query($connection,"select * from tbl_delivery_method where status='1' order by method asc");
							for($a=1;$a<=mysqli_num_rows($qry_method);$a++){
								$trans = mysqli_fetch_assoc($qry_method);
								echo "<option value='$trans[id]'>$trans[method]</option>";
							}
						?>
					</select>
					<input type="text" class="form-control" style="width:333px" name="sourcename" id="sourcename" placeholder="Name/Company/Agency/Office" required="">
		        </div>
		        <div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:175px;">Gender</div>
					<div class="form-label" style="width:155px;">Contact No.</div>
					<div class="form-label">Email Address</div>
				</div>
		        <div class="form-group form-inline form-space">
		        	<select class="form-control" style="width:171px;" name="gender" id="gender">
						<option value="">Select One</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
					<input type="text" class="form-control" style="width:150px" name="contactno" id="contactno" placeholder="(072) 607 1234">
					<input type="text" class="form-control" style="width:179px" name="emailaddress" id="emailaddress" placeholder="juan@domain.com">
		        </div>

		        <div class="form-group form-inline form-space-label form-space">	 
					<div class="form-label" style="width:175px;">Communication Summary</div>
				</div>
	 			<div class="form-group form-space">	 
					<textarea class="form-control" name="subjectmatter" id="subjectmatter" placeholder="Communication Summary"></textarea>
		        </div>     

		        <div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:175px;">Linked Document/s</div>
				</div>
		        <div class="form-group form-space">
					<input type="text" class="form-control" name="prerequisites" id="prerequisites" placeholder="Enter Barcode/s (Note: separated by spaces)">
		        </div>
		        <div class="form-group form-inline form-space">
		        	<?php
		        		$ac =  generateRandomString();
		        	?>
					Access Code : <b><?php echo $ac;?></b>
					<input type="hidden" name="accesscode" value="<?php echo $ac;?>">
					
					 
		        </div>
		        
		        <div class="form-group form-space">
		        	<button type="submit" class="btn btn-primary" value="save" name="save">Save Document</button>
		        </div>
	        </form>
        <?php
   		}
   		else if($_REQUEST['form']=="edit") {
			$qry_show = mysqli_query($connection,"select *, a.id as doc_id from tbl_document a, tbl_transaction_type b, tbl_document_type c, tbl_source d, tbl_delivery_method e where a.transaction_type=b.id and a.document_type=c.document_code and a.source_type=d.id and a.delivery_method=e.id and a.id='$_REQUEST[id]'");

			$show = mysqli_fetch_assoc($qry_show);

   			$rec_date = explode(" ",$show['recieve_date'])

   			?>
   			<form action="" method="post">
				<h4>Edit Document</h4>
				<div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:175px;">Barcode</div>
					<div class="form-label" style="width:155px;">Transaction Type</div>
					<div class="form-label" style="width:175px;">Document Type</div>
				</div>
				<div class="form-group form-inline form-space">
					<input type="hidden" name="docid" value="<?php echo $_REQUEST['id'];?>">
					<input type="hidden" name="recdate" value="<?php echo $rec_date[0];?>">
					<input type="hidden" name="rectime" value="<?php echo $rec_date[1];?>">
					<input type="text" class="form-control" name="barcode" id="barcode" placeholder="Barcode" value="<?php echo $show['barcode'] ?>" required="required" style="width: 170px;" readonly='readonly'>
					<select class="form-control" style="width:150px;" name="transactiontype" id="transactiontype" required="required">
						<?php
							echo "<option value='$show[transaction_type]'>$show[transaction]</option>";
							$qry_transaction_type = mysqli_query($connection,"select * from tbl_transaction_type where id!='$show[transaction_type]' and status='1' order by days asc");
							for($a=1;$a<=mysqli_num_rows($qry_transaction_type);$a++){
								$trans = mysqli_fetch_assoc($qry_transaction_type);
								echo "<option value='$trans[id]'>$trans[transaction]</option>";
							}
						?>
					</select>
					<select class="form-control" style="width:180px;" name="documenttype" id="documenttype" required="required">
						<?php
							echo "<option value='$show[document_code]'>$show[document_type]</option>";
							$qry_doc_type = mysqli_query($connection,"select * from tbl_document_type where document_code!='$show[document_code]' and status='1' order by document_type asc");
							for($a=1;$a<=mysqli_num_rows($qry_doc_type);$a++){
								$trans = mysqli_fetch_assoc($qry_doc_type);
								echo "<option value='$trans[document_code]'>$trans[document_type]</option>";
							}
						?>
					</select>
		        </div>
		        <div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:175px;">Source Type</div>
					<div class="form-label" style="width:175px;">Source Location</div>
				</div>
		        <div class="form-group form-inline form-space">
		       		<select class="form-control" style="width:171px;" name="sourcetype" id="sourcetype" onload="sourcelocation()" onchange="sourcelocation()" required="required">
						<?php
							echo "<option value='$show[source_type]'>$show[source]</option>";
							$qry_source = mysqli_query($connection,"select * from tbl_source where status='1' and id!='$show[source_type]' order by source asc");
							for($a=1;$a<=mysqli_num_rows($qry_source);$a++){
								$trans = mysqli_fetch_assoc($qry_source);
								echo "<option value='$trans[id]'>$trans[source]</option>";
							}
						?>
					</select>
					<?php
						if($show['source_type']=="INT"){
							?>
							<select class="form-control" style="width:333px;" name="sourceoffice" id="sourceoffice" required="required">
								<?php
									$qry_office = mysqli_query($connection,"select * from tbl_office where office_code='$show[office_code]'");
									$offce = mysqli_fetch_assoc($qry_office);

									echo "<option value='$offce[office_code]'>$offce[office_name]</option>";
									$qry_source = mysqli_query($connection,"select * from tbl_office where status='1' and office_code!='$show[office_code]' order by office_name asc");
									for($a=1;$a<=mysqli_num_rows($qry_source);$a++){
										$trans = mysqli_fetch_assoc($qry_source);
										echo "<option value='$trans[office_code]'>$trans[office_name]</option>";
									}
								?>
							</select>
							<input type="text" class="form-control" style="width:333px; display: none;" name="so" id="so" value="N/A" readonly="readonly">
							<?php
						}
						else{
							?>
							<input type="text" class="form-control" style="width:333px;" name="so" id="so" value="N/A" readonly="readonly">
							<select class="form-control" style="width:333px; display: none;" name="sourceoffice" id="sourceoffice">
								<option value="">Source Location</option>
								<?php
									$qry_source = mysqli_query($connection,"select * from tbl_office where status='1' and office_code!='$show[office_code]' order by office_name asc");
									for($a=1;$a<=mysqli_num_rows($qry_source);$a++){
										$trans = mysqli_fetch_assoc($qry_source);
										echo "<option value='$trans[office_code]'>$trans[office_name]</option>";
									}
								?>
							</select>
							<?php
						}
					?>
					
		        </div>
		        <div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:175px;">Delivery Method</div>
					<div class="form-label" style="width:175px;">Source Name</div>
				</div>
		        <div class="form-group form-inline form-space">
		        	<select class="form-control" style="width:171px;" name="deliverymethod" id="deliverymethod" required="required">
						<?php
							echo "<option value='$show[delivery_method]'>$show[method]</option>";
							$qry_method = mysqli_query($connection,"select * from tbl_delivery_method where status='1' and id!='$show[delivery_method]' order by method asc");
							for($a=1;$a<=mysqli_num_rows($qry_method);$a++){
								$trans = mysqli_fetch_assoc($qry_method);
								echo "<option value='$trans[id]'>$trans[method]</option>";
							}
						?>
					</select>
					<input type="text" class="form-control" style="width:333px" name="sourcename" id="sourcename" placeholder="Source: Name/Company/Agency/Office" value="<?php echo $show['source_name'];?>" required="">
		        </div>
		        <div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:175px;">Gender</div>
					<div class="form-label" style="width:155px;">Contact No.</div>
					<div class="form-label">Email Address</div>
				</div>
		        <div class="form-group form-inline form-space">
		        	<select class="form-control" style="width:171px;" name="gender" id="gender" required="required">
						<option value=''>Select One</option>
						<option <?php echo $show['gender']=="Male" ? 'selected':'';?> value="Male">Male</option>
						<option <?php echo $show['gender']=="Female" ? 'selected':'';?> value="Female">Female</option>
					</select>
					<input type="text" class="form-control" style="width:150px" name="contactno" id="contactno" placeholder="Contact No." value="<?php echo $show['contact_no'];?>">
					<input type="text" class="form-control" style="width:179px" name="emailaddress" id="emailaddress" placeholder="Email Address" value="<?php echo $show['email_address'];?>" >
		        </div>

			

		        <div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:175px;">Communication Summary</div>
				</div>
	 			<div class="form-group form-space">
					<textarea class="form-control" name="subjectmatter" id="subjectmatter" placeholder="Communication Summer" required="required"><?php echo $show['subject_matter'];?></textarea>
		        </div>

		        <div class="form-group form-inline form-space-label form-space">
					<div class="form-label" style="width:175px;">Linked Document/s</div>
				</div>
		        <div class="form-group form-space">
					<input type="text" class="form-control" name="prerequisites" id="prerequisites" value="<?php echo $show['prerequisite']?>" placeholder="Prerequisite/s">
		        </div>
		        <div class="form-group form-inline form-space">
					Access Code : <b><?php echo $show['access_code'];?></b>
					<input type="hidden" name="accesscode" id="accesscode" value="<?php echo $show['access_code'];?>">
		        </div>
		        <div class="form-group form-space">
		        	<button type="submit" class="btn btn-primary" value="update" name="update">Update Document</button>
		        </div>
	        </form>
   			<?php
   		}
   		else{
   			echo "Error";
   		}
        ?>
	</div>
	<div class="table-new-document" style="height:630px;">
		<div class="form-group form-inline">
			<form action="home.php?menu=newdocument&form=entry&table=text" method="post">
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
		<table id="tabledocument" class="table table-striped table-hover" >  
            <thead>  
                <tr>  
                	<th class="no-sort">#</th> 
                    <th>Barcode</th> 
                    <th>Communication Summary</th>
                    <th>Source Name</th> 
                    <th style="width:100px;">Action</th>
					<th>Routed?</th>                    
                </tr>  
            </thead> 
            <tbody>
            	<?php
            		if($_REQUEST['table']=="default"){
            			if($access['office_code']=='SMO' || $access['access_level']=='A'){
            				$show = mysqli_query($connection,"select * from tbl_document where status='1' order by id desc limit 300");
            			}
            			else{
            				$show = mysqli_query($connection,"select * from tbl_document where status='1' and rec_office='$access[office_code]' order by id desc limit 300");
            			}
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
            			echo "<td><a href='home.php?menu=viewdocument&barcode=$data[barcode]' target='_blank'>$data[barcode]</a></td>";
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
            			echo "<td style='width:100px;'>";
            			
            			echo "<a href='home.php?menu=addattachments&docid=$data[id]&barcode=$data[barcode]&searchby'><img src='../images/attachment.png' class='action-btn' title='Add Attachment'></a> ";

						if($data['transaction_status'] == ""){
							echo "<a href='home.php?menu=starttransaction&docid=$data[id]&searchby'><img src='../images/route.png' class='action-btn' title='Start Transact'></a> ";
            				echo "<a href='home.php?menu=newdocument&form=edit&id=$data[id]&table=default&searchby'><img src='../images/edit.png' class='action-btn' title='Edit'></a> ";
						}

						if($access['access_level']=="A" || $access['access_level']=="R"){
            				echo "<a onclick='return confirmclick();' href='../functions/delete_functions.php?delete=newdocument&id=$data[id]&barcode=$data[barcode]&user=$access[username]'><img src='../images/delete.png' class='action-btn' title='Delete'></a> ";
            			}

            			
						echo "</td>";
						echo "<td >";
						echo ($num_routed_offices > 0 &&  ($data['is_approved']=='1' || $data['to_ocm']==2)) || $data['transaction_status'] !='' ? "<span style='color:green;'>Yes</span>" : "<span style='color:red;'>Not yet</span>";
						echo "</td>";
            			echo "</tr>";
            		}
            	?>
            </tbody>
         </table>
	</div>
	<!-- modalCommunicationSummer -->
	<div class="modal fade" id="subjectMatterModal" tabindex="-1" role="dialog" aria-labelledby="descriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4>Communication Summary</h4>
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
</body>
</html>
<?php
	}
	else{
		
	}

	include("../functions/time_functions.php");
	if(isset($_REQUEST['save'])){
		if($_REQUEST["prerequisites"] != '' || $_REQUEST["prerequisites"]!= null) {		
			$preq= $_REQUEST["prerequisites"];
			$explode = explode(" ",$preq);
			$x=1;
			foreach($explode as $i =>$key) {
				$qrydoc = mysqli_query($connection,"select * from tbl_document where barcode='$key'");
				if(mysqli_num_rows($qrydoc) <= 0) {
					?>
					<script type="text/javascript">
						alert("<?php echo $key;?> Document not found for the document link!");
					</script>
					<?php
					exit;
				}
			}
		}
		
		$bc = trim($_REQUEST['barcode']);

		if(isset($_REQUEST['sourceoffice'])){
			$office_code = $_REQUEST['sourceoffice'];
		}
		else{
			$office_code = "N/A";
		}
		
		$sm = addslashes($_REQUEST['subjectmatter']);
		$cn = addslashes($_REQUEST['sourcename']);

		//check barcode
		$checkbc = mysqli_query($connection,"select * from tbl_document where barcode='$_REQUEST[barcode]'");
		if(mysqli_num_rows($checkbc)>0){
			//error
			?>
			<script type="text/javascript">
				alert("Barcode already used. Document cannot be saved.");
				window.location = "home.php?menu=newdocument&form=entry&table=default&searchby";
			</script>
			<?php
		}
		else{
			//save
			$wh = working_hours();
			//e
			$exp_date = explode(" ",$wh);
			$time = $exp_date[1];
			$qry_trans = mysqli_query($connection,"select (days-1)days from tbl_transaction_type where id='$_REQUEST[transactiontype]'");
			$days = mysqli_fetch_assoc($qry_trans);
			$ed_date = end_date($current_date,$days['days']);
			$end_date =  $ed_date." ".$time;

			mysqli_query($connection,"insert into tbl_document values(NULL,'$wh','$end_date','$bc','$_REQUEST[transactiontype]','$_REQUEST[documenttype]','$_REQUEST[sourcetype]','$office_code','$_REQUEST[deliverymethod]','$cn','$_REQUEST[gender]','$_REQUEST[contactno]','$_REQUEST[emailaddress]','$sm','$_REQUEST[prerequisites]','$_REQUEST[accesscode]','0','0','0000-00-00','','0','$access[username]','2','$access[office_code]','1', '1')");
			 
			if($_REQUEST['sourcetype']=="EXT"){
				if($_REQUEST['emailaddress']!=""){
					//require '../phpmailer/PHPMailerAutoload.php';
					require_once('../PHPMailer/PHPMailerAutoload.php');
					$qry_email = mysqli_query($connection,"SELECT * from tbl_email where username='dts.zamboanga@gmail.com'");
					$email = mysqli_fetch_assoc($qry_email);

					$client_name = $cn;
					$client_email = $_REQUEST['emailaddress'];
					$barcode = $_REQUEST['barcode'];
					$accesscode = $_REQUEST['accesscode'];


					$mail = new PHPMailer();
					$mail->isSMTP();/*Set mailer to use SMTP*/
					$mail->Host = $email['host'];/*Specify main and backup SMTP servers*/
					$mail->Port = $email['port'];
					$mail->SMTPAuth = true;/*Enable SMTP authentication*/
					$mail->Username = $email['username'];/*SMTP username*/
					$mail->Password = $email['password'];/*SMTP password*/
					/*$mail->SMTPSecure = 'tls';*//*Enable encryption, 'ssl' also accepted*/
					$mail->From = 'noreply@domain.gov.ph';
					$mail->FromName = 'Zamboanga City';
					$mail->addAddress($client_email, $client_name);/*Add a recipient*/
					//$mail->addReplyTo('noreply@sanfernandocity.gov.ph', 'BPLS');
					/*$mail->addCC('cc@example.com');*/
					/*$mail->addBCC('bcc@example.com');*/
					$mail->WordWrap = 70;/*DEFAULT = Set word wrap to 50 characters*/
					//$mail->addAttachment('../tmp/' . $varfile, $varfile);/*Add attachments*/
					/*$mail->addAttachment('/tmp/image.jpg', 'new.jpg');*/
					/*$mail->addAttachment('/tmp/image.jpg', 'new.jpg');*/
					$mail->isHTML(true);/*Set email format to HTML (default = true)*/
					$mail->Subject = 'Document Tracking System';
					$mail->Body = "Dear ".ucwords($client_name).",<br><br>To keep track of the status of your document, Kindly click the link below. <br> <a href='http://dts.sanfernandocity.gov.ph' target='_blank'>http://dts.sanfernandocity.gov.ph</a><br><br>Barcode: <b>$barcode</b> <br>Access Code: <b>$accesscode</b> <br><br>Thank you for the opportunity to serve you.<br><br>City Government of Zamboanga";

					$mail->AltBody = 'message';
					$mail->SMTPOptions = array(
					    	'ssl' => array(
					        'verify_peer' => false,
					        'verify_peer_name' => false,
					        'allow_self_signed' => true
					    )
					);


					if(!$mail->send()){
						echo 'Message could not be sent.';
					    echo 'Mailer Error: ' . $mail->ErrorInfo;
					    
					    logs($access['username'],"ENTERED NEW DOCUMENT $_REQUEST[barcode]. ERROR IN SENDING EMAIL.");
					    ?>
						<script type="text/javascript">
							alert("Message could not be sent. Document Saved.");
							window.location = "home.php?menu=newdocument&form=entry&table=default&searchby";
						</script>
						<?php
					}
					else{
					    logs($access['username'],"ENTERED NEW DOCUMENT $_REQUEST[barcode]. EMAIL SENT SUCCESSFULLY.");
					    ?>
						<script type="text/javascript">
							alert("Email Sent. Document Saved.");
							window.location = "home.php?menu=newdocument&form=entry&table=default&searchby";
						</script>
						<?php
					}
					
				}
				else{
					logs($access['username'],"ENTERED NEW DOCUMENT $_REQUEST[barcode].");
					?>
					<script type="text/javascript">
						alert("Document Saved");
						window.location = "home.php?menu=newdocument&form=entry&table=default&searchby";
					</script>
					<?php
				}	
			}
			else{
				logs($access['username'],"ENTERED NEW DOCUMENT $_REQUEST[barcode].");
				?>
				<script type="text/javascript">
					alert("Document Saved");
					window.location = "home.php?menu=newdocument&form=entry&table=default&searchby";
				</script>
				<?php
			}
		}
	}

	if(isset($_REQUEST['update'])){
		if($_REQUEST["prerequisites"] != '' || $_REQUEST["prerequisites"]!= null) {		
			$preq= $_REQUEST["prerequisites"];
			$explode = explode(" ",$preq);
			$x=1;
			foreach($explode as $i =>$key) {
				$qrydoc = mysqli_query($connection,"select * from tbl_document where barcode='$key'");
				if(mysqli_num_rows($qrydoc) <= 0) {
					?>
					<script type="text/javascript">
						alert("<?php echo $key;?> Document not found for the document link!");
					</script>
					<?php
					exit;
				}
			}
		}

		if(isset($_REQUEST['sourceoffice'])){
			$office_code = $_REQUEST['sourceoffice'];
		}
		else{
			$office_code = "N/A";
		}
		
		 
		$sm = addslashes($_REQUEST['subjectmatter']);
		$cn = addslashes($_REQUEST['sourcename']);

		//edit here
		$rec_date = $_REQUEST['recdate'];
		$rec_time = $_REQUEST['rectime'];

		$qry_trans = mysqli_query($connection,"select (days-1)days from tbl_transaction_type where id='$_REQUEST[transactiontype]'");
		$days = mysqli_fetch_assoc($qry_trans);
		$ed_date = end_date($rec_date,$days['days']); 
		$new_end_date =  $ed_date." ".$rec_time;

		$document_qry = mysqli_query($connection,"select * from tbl_document where id='$_REQUEST[docid]' and status='1'");
		$document = mysqli_fetch_assoc($document_qry);
		$is_approved = 1;
		 
		$wh = working_hours();
		$xxx=0;
		$new_transid = $transaction_id.$xxx;
		$office_time = compute_minutes("$document[recieve_date]","$wh"); //$current_datetime
	
		mysqli_query($connection,"update tbl_document set end_date='$new_end_date', transaction_type='$_REQUEST[transactiontype]', document_type='$_REQUEST[documenttype]', source_type='$_REQUEST[sourcetype]', office_code='$office_code', delivery_method='$_REQUEST[deliverymethod]', source_name='$cn', gender='$_REQUEST[gender]', contact_no='$_REQUEST[contactno]', email_address='$_REQUEST[emailaddress]', subject_matter='$sm', prerequisite='$_REQUEST[prerequisites]' where id='$_REQUEST[docid]'");

		if($_REQUEST['sourcetype']=="EXT"){
			 
			if($_REQUEST['emailaddress']!=""){
				require_once('../PHPMailer/PHPMailerAutoload.php');
				$qry_email = mysqli_query($connection,"SELECT * from tbl_email where username='dts.zamboanga@gmail.com'");
				$email = mysqli_fetch_assoc($qry_email);

				$client_name = $cn;
				$client_email = $_REQUEST['emailaddress'];
				$barcode = $_REQUEST['barcode'];
				$accesscode = $_REQUEST['accesscode'];


				$mail = new PHPMailer();
				$mail->isSMTP();/*Set mailer to use SMTP*/
				$mail->Host = $email['host'];/*Specify main and backup SMTP servers*/
				$mail->Port = $email['port'];
				$mail->SMTPAuth = true;/*Enable SMTP authentication*/
				$mail->Username = $email['username'];/*SMTP username*/
				$mail->Password = $email['password'];/*SMTP password*/
				/*$mail->SMTPSecure = 'tls';*//*Enable encryption, 'ssl' also accepted*/
				$mail->From = 'noreply@domain.gov.ph';
				$mail->FromName = 'Zamboanga City';
				$mail->addAddress($client_email, $client_name);/*Add a recipient*/
				//$mail->addReplyTo('noreply@sanfernandocity.gov.ph', 'BPLS');
				/*$mail->addCC('cc@example.com');*/
				/*$mail->addBCC('bcc@example.com');*/
				$mail->WordWrap = 70;/*DEFAULT = Set word wrap to 50 characters*/
				//$mail->addAttachment('../tmp/' . $varfile, $varfile);/*Add attachments*/
				/*$mail->addAttachment('/tmp/image.jpg', 'new.jpg');*/
				/*$mail->addAttachment('/tmp/image.jpg', 'new.jpg');*/
				$mail->isHTML(true);/*Set email format to HTML (default = true)*/
				$mail->Subject = 'Document Tracking System';
				$mail->Body = "Dear ".ucwords($client_name).",<br><br>To keep track of the status of your document, Kindly click the link below. <br> <a href='http://dts.zamboanga.gov.ph' target='_blank'>http://dts.zamboanga.gov.ph</a><br><br>Barcode: <b>$barcode</b> <br>Access Code: <b>$accesscode</b> <br><br>Thank you for the opportunity to serve you.<br><br>City Government of Zamboanga";

				$mail->AltBody = 'message';
				$mail->SMTPOptions = array(
				    	'ssl' => array(
				        'verify_peer' => false,
				        'verify_peer_name' => false,
				        'allow_self_signed' => true
				    )
				);


				if(!$mail->send()){
					echo 'Message could not be sent.';
				    echo 'Mailer Error: ' . $mail->ErrorInfo;
				    ?>
					<script type="text/javascript">
						alert("Message could not be sent. Document Edited.");
					window.location = "home.php?menu=newdocument&form=edit&table=default&searchby&id=<?php echo $_REQUEST['docid'];?>";
					</script>
					<?php
				}
				else{
				    ?>
					<script type="text/javascript">
						alert("Email Sent. Document Edited.");
						window.location = "home.php?menu=newdocument&form=edit&table=default&searchby&id=<?php echo $_REQUEST['docid'];?>";
					</script>
					<?php
				}
			}
			?>
			<script type="text/javascript">
				alert("Document Edited.");
				window.location = "home.php?menu=newdocument&form=edit&table=default&searchby&id=<?php echo $_REQUEST['docid'];?>";
			</script>
			<?php
		}
		else{
			 
			logs($access['username'],"EDIT DOCUMENT $_REQUEST[barcode] DETAILS.");
			?>
			<script type="text/javascript">
				alert("Document Edited.");
				window.location = "home.php?menu=newdocument&form=edit&table=default&searchby&id=<?php echo $_REQUEST['docid'];?>";
			</script>
			<?php
		}
	}
?>