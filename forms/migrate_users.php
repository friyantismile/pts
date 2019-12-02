<?php
include("../database/database_connection.php");


$qry_existing = mysqli_query($connection2,"select username,fullname,dep_code,role from users where status='Enabled' and role!='Administrator'");

for($a=1;$a<=mysqli_num_rows($qry_existing);$a++){
	$users = mysqli_fetch_assoc($qry_existing);

	mysqli_query($connection,"insert into tbl_users values('$users[username]','$users[fullname]',md5('$users[username]'),'$users[dep_code]','U','1')");
}
echo "ok";

?>