<?php
//Modification
//Modified by : Yants
//Modified date : 04/04/2019
//Description : added to check if the user already login, if login redirect to dashboard
//New code - 1
include_once('../functions/login_functions.php');
if(isset($_SESSION['valid_dts_user'])){ ?>
     <script language="javascript">
    window.location = "home.php?menu=dashboard&report=thismonth";
    </script> 
<?php
}
//End new code - 1

if(isset($_POST['login']))
{
    define( 'LOGGING_IN', true );
    // include the 'session functions' file
    include_once('../functions/login_functions.php');
    process_login();   
}
else
{   
    
	if(isset($_GET['warning'])){
		?>
		<script>
       //     alert("The system could not log you on. Make sure you username and password are correct.");
        </script>
        <?php
	}

    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document Tracking System</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Other CSS -->
    <link rel="stylesheet" href="../bootstrap/css/designs.min.css">
    <!-- jQuery library -->
    <script src="../ajax/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>

    <link rel="icon" href="../images/dts.png" type="image/gif" sizes="16x16">
</head>

<body>
	<form name="login" id="requiredForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="off">
        <div class="login_container">
            <div class="login_signin_container"> 
                <br />
                <h4>Document Tracking System</h4>
                <h6>Zamboanga City</h6>
                <div class="form-group form-space">
                    <input class="form-control" type="text" placeholder="username" name="username">
                </div>
                <div class="form-group form-space">
                    <input class="form-control" type="password" placeholder="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary" value="Login" name="login">Sign in</button>
            </div>
            <!--
                Modification
                Modified by: Yants
                Date:4/5/2019
                old code
            <div class="login_bottom">
                <div class="login_city"><a href="javascript:void(0)" onclick="location.href='external_tracking.php'">CLICK HERE TO TRACK DOCUMENT</a></div>
            </div>
        -->
            <div class="login_bottom">
                <div class="login_city"><a href="javascript:void(0)" onclick="location.href='../documents/dts_manual_users.pdf'">HOW TO?</a></div>
            </div>
            <div class="copyright">
                © 2019 City Government of Zamboanga
            </div>
            
        </div>
    </form>
</body>
</html>
<?php
}
?>