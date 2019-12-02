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
	
	<script>
		$(document).ready(function(){
		    $('#tablemethod').dataTable();
		});
	</script>
	<script type="text/javascript">
		$(":file").filestyle();
	</script>
	
</head>
<body>
	<?php
		include("../functions/random_function.php");
	?>
	<div class="form-attach">
		<form action="" method="POST" enctype="multipart/form-data">
			<h4>Add Attachments</h4>
			<div class="form-group form-space">
				<input type="text" class="form-control" name="barcode" id="barcode" placeholder="Barcode" value="<?php echo $_REQUEST['barcode']?>" readonly="readonly">
				<input type="hidden" name="docid" id="docid" value="<?php echo $_REQUEST['docid'];?>">
	        </div>
	        <div class="form-group form-space">
	        	<input type="file" name="file" id="file" class="file-upload" required="required">
	        </div>
			<div class="form-group form-space">
				<textarea name="description" class="form-control" placeholder="Description"></textarea>
	        </div>
	        <div class="form-group form-space">
	        	<button type="submit" class="btn btn-primary" value="upload" name="upload" id="upload">Upload File</button>
	        </div>
        </form>
	</div>
	<div class="table-attach">
		
		<table id="tablemethod" class="table table-striped table-hover" >  
            <thead>  
                <tr>  
                    <th>Document Name</th> 
					<th>Description</th>
					<th>Date Uploaded</th>  
                    <th>Action</th>                     
                </tr>  
            </thead> 
            <tbody>
            	<?php
            		$qry = mysqli_query($connection,"select *, date_format(date_uploaded,'%M %d, %Y at %h:%i:%s %p') duploaded from tbl_document_attachments where barcode='$_REQUEST[barcode]' and status='1' order by id");
            		for($a=1;$a<=mysqli_num_rows($qry);$a++){
            			$show = mysqli_fetch_assoc($qry);
            			echo "<tr>";
            			?>
            			<td><a href="javascript:void(0)" onclick="location.href='<?php echo $show['attachement_location']; ?>'"><?php echo 'File No. '.$a.' '.$show['document_name']; ?></td>
            			<?php
						echo "<td>";
            			echo $show['description'];
						echo "</td>";

						echo "<td>";
            			echo $show['duploaded'];
						echo "</td>";
						
            			echo "<td>";
            			echo "<a href='../functions/delete_functions.php?delete=attachments&id=$show[id]&docid=$_REQUEST[docid]&barcode=$_REQUEST[barcode]&user=$access[username]'><img src='../images/delete.png' class='action-btn' title='Delete'></a>";
            			echo "</td>";
            			echo "</tr>";
            		}
            	?>
            </tbody>
         </table>
	</div>
</body>
</html>
<?php
	if(isset($_REQUEST['upload'])){
		
		$length = (rand(10,50));
		$randomString = randomString($length);


		//$name = $randomString.".pdf";
		$name = $_FILES['file']['name'];
		$size = $_FILES['file']['size'];
		$type = $_FILES['file']['type'];
		$tmp_name = $_FILES['file']['tmp_name'];
		$error = $_FILES['file']['error'];

		if($type!="application/pdf"){
		?>
			<script type="text/javascript">
				alert("File must be PDF. Thank you.");
			</script>
	    <?php
		}
		else{
		$datetime = date('Y-m-d H:i:s');
			if($size<999999999999999999999){// kilobytes
				if(isset($name)) {
					if(!empty($name)) {
					$location = '../documents/';
						if(move_uploaded_file($tmp_name, $location.$name)){
							
							mysqli_query($connection,"insert into tbl_document_attachments value(NULL,'$_REQUEST[barcode]','$name','../documents/$name','1', '$datetime','$_REQUEST[description]')");

							logs($access['username'],"UPLOAD ATTACHMENT TO DOCUMENT $_REQUEST[barcode].");
							?>
							<script type="text/javascript">
	                            alert("Saved");
	                            window.location = "home.php?menu=addattachments&docid=<?php echo $_REQUEST['docid'];?>&barcode=<?php echo $_REQUEST['barcode']?>";
	                        </script>
	                        <?php 
						}
					}
					else{
						echo 'please choose a file';
					}
				}
			}
			else{
				logs($access['username'],"ERROR UPLOAD ATTACHMENT DOCUMENT $_REQUEST[barcode].");
				?>
				<script type="text/javascript">
	                alert("File to big to upload.");
	            </script>
	            <?php
			}
		}

	}
}
?>