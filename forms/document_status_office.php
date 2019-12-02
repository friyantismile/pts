
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
<body>
	
	<div class="container-report-delin">
		<table class="table-report">
			<tr>
				<td colspan="2" style="text-align: center;"><h4>DOCUMENT TRACKING SYSTEM REPORT</h4></td>
			</tr>
			<tr>
				<td style="width:150px;">REPORT TYPE:</td>
				<td>Office Performance</td>
			</tr>
			<tr>
				<td style="width:150px;">Date:</td>
				<td><?php echo date("M d, Y"); ?></td>
			</tr>
		</table>
		<br>
		<table class="table-report" border="1">
			<tr align="center" style="font-weight: bold;">
				<td rowspan="2">Office Name</td>
				<td colspan="3">Transactions</td>
			</tr>
			<tr align="center" style="font-weight: bold;">
				<td width="100px;">Todo</td>
				<td width="100px;">Received</td>
				<td width="100px;">Completed</td>
			</tr>
			<?php
			$qry_office = mysqli_query($connection,"select * from tbl_office order by office_name asc");
			for($a=1;$a<=mysqli_num_rows($qry_office);$a++){
				$rows = mysqli_fetch_assoc($qry_office);
				echo "<tr>";
				echo "<td>&nbsp;&nbsp;$rows[office_code] - $rows[office_name]</td>";

				
				$qry_completed = mysqli_query($connection,"select count(a.barcode) as no_of_doc from tbl_document_transaction a, tbl_document b where (a.current_action='END' || a.current_action='') and a.barcode=b.barcode and a.office_code='$rows[office_code]'");
				$completed = mysqli_fetch_assoc($qry_completed);

				$qry_todo = mysqli_query($connection,"select count(a.barcode) as no_of_doc from tbl_document_transaction a, tbl_document b where (a.current_action='REL') and a.barcode=b.barcode and a.route_office_code='$rows[office_code]'");
				$todoo = mysqli_fetch_assoc($qry_todo);

				$qry_receiver = mysqli_query($connection,"select count(a.barcode) as no_of_doc from tbl_document_transaction a, tbl_document b where (a.current_action='REC') and a.barcode=b.barcode and a.office_code='$rows[office_code]'");
				$receive = mysqli_fetch_assoc($qry_receiver);
				 

				echo "<td align='center'>".$todoo['no_of_doc']."</td>";
				echo "<td align='center'>".$receive['no_of_doc']."</td>";
				echo "<td align='center'>".$completed['no_of_doc']."</td>";
				echo "</tr>";
			}

			?>
		</table>
		 
		<br>
		Date: <?php echo date("M d, Y");?>

	</div>
</body>
</html>
 