<?php
ini_set('session.name','s');
session_start();
include("../database/database_connection.php");
define('Login_Page','../forms/login.php');
define('Login_Page2','../forms/login.php?warning=1');
define('Home_Page','../forms/home.php?menu=dashboard&report=thismonth');//?value=home
define('Logout_Page','../forms/logout.php');
define('publicsearch','../forms/public_search.php?table=default');
//verify valid user
function verify_valid_system_user()
{
	if(!isset($_SESSION['valid_dts_user']) )
	{
		header('location:'.Login_Page);
	}  
}
//verify verify if username and password is correct
function verify_username_password($user,$pass)
{
	include("../database/database_connection.php");
	
	$query_string = "select * from tbl_users where username='".$user."' and password=md5('".$pass."') and status='1'";
	$query = mysqli_query($connection,$query_string);
	
	if(mysqli_num_rows($query)==0)
	{
		header('location:'.Login_Page2);
	}
 
	else
	{
		$trans = mysqli_fetch_assoc($query);
			if($trans['access_level']=="P") {
				$_SESSION['valid_dts_user'] = "public search";
				header('location:'.publicsearch);
			}else {
			function mysqli_result($res,$row=0,$col=0){ 
				$numrows = mysqli_num_rows($res); 
				if ($numrows && $row <= ($numrows-1) && $row >=0){
					mysqli_data_seek($res,$row);
					$resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
					if (isset($resrow[$col])){
						return $resrow[$col];
					}
				}
				return false;
			}
			
			$_SESSION['valid_dts_user'] = mysqli_result($query, 0, 0);
			header('location:'.Home_Page);
		}
	}
}
//proccess inputs in logging in
function process_login()
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	verify_username_password($username,$password);  
}
// use to logout page
function process_logout()
{  
	?>
    <script type="text/javascript">
	var answer = confirm("Are you sure?")
	if (answer){
		//redirect to
		window.location = "../forms/logout.php";
	}
	else{
		//none
	}
	</script>
    <?php
}
?>