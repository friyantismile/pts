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
<body class="body_color">
	<?php
		date_default_timezone_set("Asia/Manila");
		$t = microtime(true);
		$micro = sprintf("%06d",($t - floor($t)) * 1000000); //1000000
		$d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
		$transaction_id = $d->format("YmdHisu");
		$current_datetime = date("Y-m-d H:i:s");
		$current_date = date("Y-m-d");
		$current_month = date("Y-m");
		$system_user = $_SESSION['valid_dts_user'];
		$qry_access = mysqli_query($connection,"select * from tbl_users where username='$system_user'");
		$access = mysqli_fetch_assoc($qry_access);
	 
		if($access['access_level']=="P") {
			header('location:../forms/public_search.php?table=default');
		}
		include('../functions/log_functions.php');
	?>
	<div>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
			<div class="navbar-header" style="margin-left:-14px; height: 55px; width: 230px;">
				<a href="home.php?menu=dashboard&report=thismonth">
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
			<ul class="nav navbar-nav">
				<!--<li class="active"><a href="#">Home</a></li>-->
				<?php
					if($access['access_level']=="A" || $access['access_level']=="R"){
						echo "<li><a href='home.php?menu=newdocument&form=entry&table=default&searchby'>New Document</a></li>";
					}
					/*if($access['access_level']=="U"){
						echo "<li><a href='home.php?menu=transact'>Transaction</a></li>";
					}
					*/
				?>
				<li><a href="home.php?menu=transact">Transaction</a></li>
				<li><a href="home.php?menu=archive&form=entry&table=default">Archive</a></li>
				
			
				
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Report<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="home.php?menu=report&form=entry">Report List</a></li>
						<li><a href="home.php?menu=officeperformance&form=entry">Office Performance</a></li>
						<li><a href="home.php?menu=reportsummary&form">Summary</a></li>
						<li><a href="home.php?menu=officetransactions&form">Office Transactions Summary</a></li>
						<li><a href="home.php?menu=unendedtransactions&form">Unended Transactions</a></li>
						<li><a href="home.php?menu=officetransactionstatus">Monitor Office Transactions Status</a></li>
						<!--
						<li><a href="home.php?menu=graph&form=entry">Graphical Representation</a></li>	
						-->
					</ul>
				</li>
				
				<?php
				if($access['access_level']=="A"){
				?>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Settings<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="home.php?menu=emailsetting&form=entry">Email Setting</a></li>
						<li><a href="home.php?menu=officeentry&form=entry">Office Entry</a></li>
						<li><a href="home.php?menu=subjectmatter&form=entry">Subject matter</a></li>
						<li><a href="home.php?menu=officeperformancestandards&form=entry">Office Performance Standards</a></li>
						<li><a href="home.php?menu=workinghours&form=entry">Working Hours</a></li>
						<li><a href="home.php?menu=documenttype&form=entry">Document Type</a></li>
						<li><a href="home.php?menu=deliverymethod&form=entry">Delivery Method</a></li>
						<li><a href="home.php?menu=transactiontype&form=entry">Transaction Type</a></li>
						<li><a href="home.php?menu=endedtransactions&form=entry">Reactivate Ended Transactions</a></li>
						<li><a href="home.php?menu=correctreleasetransaction&form=entry">Correct Release Route</a></li>
					</ul>
				</li>
				<?php
				}
				else if($access['access_level']=="R"){
					?>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Settings<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="home.php?menu=endedtransactions&form=entry">Reactivate Ended Transactions</a></li>
							<li><a href="home.php?menu=correctreleasetransaction&form=entry">Correct Release Route</a></li>
						</ul>
					</li>
					<?php
				}
				?>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">User Management<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<?php
						if($access['access_level']=="A"){
							?>
							<li><a href="home.php?menu=createusers">Create Users</a></li>
							<?php
						}
						?>
						<li><a href="home.php?menu=changepassword">Change Password</a></li>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="">Welcome <?php echo ucwords($access['full_name']);?>!</a></li>
				<li><a href="logout.php" title="Logout"><img src="../images/out.png" class="logout-btn"></a></li>
			</ul>
			</div>
		</nav>
	</div>
	
	<div class="form-container">
		<?php
			if($_REQUEST['menu']=="createusers"){
				include("create_users.php");
			}
			if($_REQUEST['menu']=="changepassword"){
				include("change_password.php");
			}
			if($_REQUEST['menu']=="officeentry"){
				include("office_entry.php");
			}
			if($_REQUEST['menu']=="subjectmatter"){
				include("subject_matter.php");
			}
			if($_REQUEST['menu']=="documenttype"){
				include("document_type.php");
			}
			if($_REQUEST['menu']=="deliverymethod"){
				include("delivery_method.php");
			}
			if($_REQUEST['menu']=="newdocument"){
				include("new_document.php");
			}
			if($_REQUEST['menu']=="addattachments"){
				include("add_attachments.php");
			}
			if($_REQUEST['menu']=="starttransaction"){
				include("start_transaction.php");
			}
			if($_REQUEST['menu']=="transact"){
				include("transact.php");
			}
			if($_REQUEST['menu']=="workinghours"){
				include("working_hours.php");
			}
			if($_REQUEST['menu']=="endtransaction"){
				include("end_transaction.php");
			}
			if($_REQUEST['menu']=="endedtransactions"){
				include("ended_transactions.php");
			}
			if($_REQUEST['menu']=="archive"){
				include("archive.php");
			}
			if($_REQUEST['menu']=="viewdocument"){
				include("view_document.php");
			}
			if($_REQUEST['menu']=="transactiontype"){
				include("transaction_type.php");
			}
			if($_REQUEST['menu']=="dashboard"){
				include("dashboard.php");	
			}
			if($_REQUEST['menu']=="report"){
				include("report.php");
			}
			//DTS V2.0
			if($_REQUEST['menu']=="searcholdarchive"){
				include("search_old_archive.php");
			}
			if($_REQUEST['menu']=="viewolddocument"){
				include("view_old_document.php");
			}
			//DTS V1.0
			if($_REQUEST['menu']=="searcholdoldarchive"){
				include("search_old_old_archive.php");
			}
			if($_REQUEST['menu']=="viewoldolddocument"){
				include("view_old_old_document.php");
			}
			if($_REQUEST['menu']=="officeperformancestandards"){
				include("office_performance_standards.php");
			}
			if($_REQUEST['menu']=="graph"){
				include("graph.php");
			}	
			if($_REQUEST['menu']=="officeperformance"){
				include("office_performance.php");
			}
			if($_REQUEST['menu']=="edittransaction"){
				include("edit_transaction.php");
			}
			if($_REQUEST['menu']=="emailsetting"){
				include("email_setting.php");
			}
			if($_REQUEST['menu']=="correctreleasetransaction"){
				include("correct_release_transaction.php");
			}
			if($_REQUEST['menu']=="reportsummary"){
				include("report_summary.php");
			}
			if($_REQUEST['menu']=="officetransactions"){
				include("office_transactions.php");
			}
			if($_REQUEST['menu']=="unendedtransactions"){
				include("unended_transactions.php");
			}
			if($_REQUEST['menu']=="officetransactionstatus"){
				include('../output/office_list_of_document_routed.php');
			 
			}
			
		?>
	</div>

</body>
</html>
