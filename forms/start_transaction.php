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
</head>
<body>
	<?php
		$docid = $_REQUEST['docid'];
		$qry_show = mysqli_query($connection,"select * from tbl_document where id='$docid'");
		$doc = mysqli_fetch_assoc($qry_show);
		
	?>
	<div class="start-transaction-container" style="width:100%">
		<div class="document-detail" style="width:100%">
			<h4>Document Barcode : <?php echo  $doc['barcode'];?></h4>
		</div>
		<div class="document-list-office" style="width:50%">
			<h4>Office List</h4>
			<table class="table-office-list">
				<tr>
					<td width='150px' height="30px"></td>
					<td width='400px'>Route to all offices</td>
					<td width='20px'><a href="home.php?menu=starttransaction&docid=<?php echo $docid;?>&addall"><img src="../images/route.png" class="action-btn" title="Route to all."></a></td>
				</tr>
				<?php
					
					$all_offices = mysqli_query($connection,"select * from tbl_office where status='1' and office_code!='REC' order by office_name asc");
					for($b=1;$b<=mysqli_num_rows($all_offices);$b++){
						$office = mysqli_fetch_assoc($all_offices);

						$added_office = mysqli_query($connection,"select a.office_code from tbl_office a,tbl_document_transaction b where a.office_code=b.route_office_code and a.status='1' and b.barcode='$doc[barcode]' and b.sequence='1' and a.office_code='$office[office_code]'");
						
						if(mysqli_num_rows($added_office)>=1){
							
						}	
						else{
							echo "<tr>";
							echo "<td height='30px'><b>$office[office_code]</b></td>";
							echo "<td> $office[office_name]</td>";
							echo "<td><a href='home.php?menu=starttransaction&docid=$docid&addtrans&officecode=$office[office_code]'><img src='../images/play.png' class='action-btn' title='Add to Route'></a></td>";
							echo "</tr>";	
						}	
					}		
				?>
			</table>
		</div>
		<div class="document-route-to" style="width:49.5%">
			<h4>Route To</h4>
			<table class="table-office-added" style="width:100%;">
				<tr>
					<td width='150px' height="30px;"></td>
					<td width='400px'>Remove all offices</td>
					<td width='20px'><a href="home.php?menu=starttransaction&docid=<?php echo $docid;?>&deleteall"><img src="../images/back-all.png" class="action-btn" title="Remove all."></a></td>
				</tr>
				<?php
					$qry_office_added = mysqli_query($connection,"select * from tbl_office a,tbl_document_transaction b where a.office_code=b.route_office_code and a.status='1' and b.barcode='$doc[barcode]' and b.sequence='1' order by a.office_name asc");
					for($a=1;$a<=mysqli_num_rows($qry_office_added);$a++){
						$added = mysqli_fetch_assoc($qry_office_added);
						echo "<tr>";
						echo "<td height='30px'><b>$added[route_office_code]</b></td>";
						echo "<td> $added[office_name]</td>";
						echo "<td><a href='home.php?menu=starttransaction&docid=$docid&deletetrans&transacid=$added[trans_id]&barcode=$doc[barcode]&office=$added[route_office_code]'><img src='../images/back.png' class='action-btn' title='Remove'></a></td>";
						echo "</tr>";
					}
				?>
				
			</table>
			<div style="text-align: right; margin-top: 10px;">
				<a href="home.php?menu=newdocument&form=entry&table=default&searchby">
					<button type="button" class="btn btn-primary" value="done" name="done">Done</button>
				</a>
			</div>
		</div>
	</div>
</body>
</html>

<?php
	include("../functions/time_functions.php");
	$wh = working_hours();

	if(isset($_REQUEST['addtrans'])){
		//check 
		$qry_check = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$doc[barcode]' and sequence='1' and route_office_code='$_REQUEST[officecode]'");
		if(mysqli_num_rows($qry_check)>0){
			?>
			<script>
				alert("<?php echo $_REQUEST['officecode']; ?> Previously added.");
				window.location = "home.php?menu=starttransaction&docid=<?php echo $_REQUEST['docid'];?>";
			</script>
			<?php
		}
		else{
			$new_transid = $transaction_id.'0';

			$office_time = compute_minutes("$doc[recieve_date]","$wh"); //$current_datetime

			$office_code = '';

			mysqli_query($connection,"insert into tbl_document_transaction values('$new_transid','$doc[barcode]','1',NULL,'SMO','$access[full_name]','$doc[recieve_date]','New Document Trail','$_REQUEST[officecode]','$access[full_name]','$wh','-','-','REL','$office_time','0','1')");

			//get total_office and total_transit time
			$add_office_time = get_total_office_time($doc['barcode'])+$office_time;	

			mysqli_query($connection,"update tbl_document set total_office_time='$add_office_time' where barcode='$doc[barcode]'");

			logs($access['username'],"DOCUMENT $doc[barcode] ROUTE TO $_REQUEST[officecode].");
			?>
			<script>
				window.location = "home.php?menu=starttransaction&docid=<?php echo $_REQUEST['docid'];?>";
			</script>
			<?php
		}	
	}

	if(isset($_REQUEST['deletetrans'])){
	
		$qry_office_time = mysqli_query($connection,"select * from tbl_document_transaction where trans_id='$_REQUEST[transacid]'");
		$office_time = mysqli_fetch_assoc($qry_office_time);

		$sub_office_time = get_total_office_time($_REQUEST['barcode'])-$office_time['office_time'];

		mysqli_query($connection,"update tbl_document set total_office_time='$sub_office_time' where barcode='$_REQUEST[barcode]'");

		mysqli_query($connection,"delete from tbl_document_transaction where trans_id='$_REQUEST[transacid]'");

		logs($access['username'],"DOCUMENT $doc[barcode] DELETE ROUTE $_REQUEST[office].");
		?>
		<script>
			window.location = "home.php?menu=starttransaction&docid=<?php echo $_REQUEST['docid'];?>";
		</script>
		<?php
	}

	if(isset($_REQUEST['addall'])){
		//
		$office_time = compute_minutes("$doc[recieve_date]","$wh");//$current_datetime

		$qry_all = mysqli_query($connection,"select * from tbl_office where status='1' and office_code!='REC'");
		for($a=1;$a<=mysqli_num_rows($qry_all);$a++){
			$office = mysqli_fetch_assoc($qry_all);
			$new_transid = $transaction_id.$a;

			$check = mysqli_query($connection,"select * from tbl_document_transaction where barcode='$doc[barcode]' and sequence='1' and route_office_code='$office[office_code]'");
			if(mysqli_num_rows($check)>0){

			}
			else{
				$add_office_time = get_total_office_time($doc['barcode'])+$office_time;	
				mysqli_query($connection,"update tbl_document set total_office_time='$add_office_time' where barcode='$doc[barcode]'");

				mysqli_query($connection,"insert into tbl_document_transaction values('$new_transid','$doc[barcode]','1',NULL,'SMO','$access[full_name]','$doc[recieve_date]','New Document Trail','$office[office_code]','','$current_datetime','-','-','REL','$office_time','0','1')");

				logs($access['username'],"DOCUMENT $doc[barcode] ROUTE TO ALL OFFICES.");
				?>
				<script>
					window.location = "home.php?menu=starttransaction&docid=<?php echo $_REQUEST['docid'];?>";
				</script>
				<?php
			}
		}
	}

	if(isset($_REQUEST['deleteall'])){
		$barcode_qry = mysqli_query($connection,"select barcode from tbl_document where id='$_REQUEST[docid]'");
		$barcode = mysqli_fetch_assoc($barcode_qry);
		//
		mysqli_query($connection,"update tbl_document set total_office_time='0' where barcode='$barcode[barcode]'");

		mysqli_query($connection,"delete from tbl_document_transaction where barcode='$barcode[barcode]'");

		logs($access['username'],"DOCUMENT $barcode[barcode] DELETE ROUTE TO ALL OFFICES.");
		?>
		<script>
			window.location = "home.php?menu=starttransaction&docid=<?php echo $_REQUEST['docid'];?>";
		</script>
		<?php
	}
}
?>