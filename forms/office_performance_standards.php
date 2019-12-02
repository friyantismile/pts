<?php
	include("../database/database_connection.php");
  	include_once('../functions/login_functions.php');
 	verify_valid_system_user();

 	if($access['office_code']=="REC" || $access['access_level']=="A"){
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
		//for tbl_office_performance
		$qry_save = mysqli_query($connection,"select a.office_code,b.document_code from tbl_office a, tbl_document_type b");
		for($a=1;$a<=mysqli_num_rows($qry_save);$a++){
			$data = mysqli_fetch_assoc($qry_save);

			//check
			$qry_check = mysqli_query($connection,"select * from tbl_office_performance where office_code='$data[office_code]' and document_code='$data[document_code]'");
			if(mysqli_num_rows($qry_check)>0){
				//no insert
			}
			else{
				//insert
				mysqli_query($connection,"insert into tbl_office_performance values('$data[office_code]','$data[document_code]','540')"); //540 default time
			}

		}


		/*
		$qry = mysqli_query($connection,"select a.office_code, b.document_code from tbl_office a, tbl_document_type b order by a.office_code, b.document_code asc");
		for($a=1;$a<=mysqli_num_rows($qry);$a++){
			$data = mysqli_fetch_assoc($qry);
			mysqli_query($connection,"insert into tbl_office_performance values('$data[office_code]','$data[document_code]',0.00);");
		}
		*/

	?>
	
	<div class="office-performance">
		<h4>Office Performance Standards Settings</h4>
		<form method="post">
			<table id="tabledocument" class="table table-striped tablselect a.office_code, b.document_code from tbl_office a, tbl_document_type b order by a.office_code, b.document_code asce-;hover" >  
	            <thead>  
	                <tr>  
	                	<th width="350px" class="no-sor">DEPARTMENT / OFFICE</th> 
	 	              	<?php
	 	              		
	                		$qry = mysqli_query($connection,"select * from tbl_document_type ORDER BY document_code asc");
	                		for($a=1;$a<=mysqli_num_rows($qry);$a++){
	                			$type = mysqli_fetch_assoc($qry);
	                			echo "<th width='80px'  style='text-align: center;'>$type[document_code]</th> ";
	                		}
	                	?>
	                </tr>  
	            </thead> 
	            <?php
	            	$qry_office = mysqli_query($connection,"select * from tbl_office ORDER BY office_code asc");
	            	for($a=1;$a<=mysqli_num_rows($qry_office);$a++){
	            		$office = mysqli_fetch_assoc($qry_office);
	            		echo "<tr>";
	            		echo "<td>$office[office_code] - $office[office_name]</td>";

	            		$qry_docs = mysqli_query($connection,"select * from tbl_document_type ORDER BY document_code asc");
	            		for($b=1;$b<=mysqli_num_rows($qry_docs);$b++){
	                		$docs = mysqli_fetch_assoc($qry_docs);

	                		$qry_val = mysqli_query($connection,"select office_time from tbl_office_performance where office_code='$office[office_code]' and document_code='$docs[document_code]'");
	                		$val = mysqli_fetch_assoc($qry_val);

	                		echo "<td><input type='text' class='form-control' name='$office[office_code]$docs[document_code]' id='$office[office_code]$docs[document_code]' value='$val[office_time]'></td>";
	                	}

	            		echo "</tr>";
	            	}
	            ?>   
			</table>
			<div class="office-performance-save-button">
				<button type="submit" class="btn btn-primary" name="save" id="save">Save Office Performance</button>
			</div>
		</form>
	</div>
	<br>
	<br>

</body>
</html>
<?php
	}

	if(isset($_REQUEST['save'])){
		$qry_textname = mysqli_query($connection,"select a.office_code,b.document_code,CONCAT(a.office_code,b.document_code)textname from tbl_office a, tbl_document_type b order by a.office_code, b.document_code asc");
		for($a=1;$a<=mysqli_num_rows($qry_textname);$a++){
			$textbox = mysqli_fetch_assoc($qry_textname);
			$txtbox = $textbox['textname'];

			mysqli_query($connection,"update tbl_office_performance set office_time='$_REQUEST[$txtbox]' where office_code='$textbox[office_code]' and document_code='$textbox[document_code]'");
		}
		?>
		<script type="text/javascript">
			alert("Saved");
			window.location = "home.php?menu=officeperformancestandards&form=entry";
		</script>
		<?php
	}

?>