<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DTS</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<!-- Other CSS -->
<link rel="stylesheet" href="../bootstrap/css/designs.min.css">
<!-- jQuery library -->
<script src="../ajax/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="../bootstrap/js/bootstrap.min.js"></script>

</head>

<body>
	<form name="login" id="requiredForm" action="tracking_result.php" method="post" autocomplete="off">
        <div class="login_container">
            <div class="login_signin_container">        
                <br />
                <h4>Document Tracking System</h4>
                <h6>To track your document enter the following:</h6>
                <div class="form-group form-space">
                    <input class="form-control" type="text" placeholder="Barcode" name="barcode">
                </div>
                <div class="form-group form-space">
                    <input class="form-control" type="text" placeholder="Access Code" name="acode">
                </div>
                <button type="submit" class="btn btn-primary" value="track" name="track">Track Document</button>
            </div>
            <div class="login_bottom">
                <div class="login_city"><a href="javascript:void(0)" onclick="location.href='login.php'">CLICK HERE TO LOGIN</a></div>
            </div>
            </div>
        </div>
    </form>
</body>
</html>
