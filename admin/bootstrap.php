<?php
session_start();
include "config.php";
include "../libs/db_query.php";
$db = new db_query();
$login = $_SESSION['login'];
$dblink = $db->start($server, $user, $password, $dbname);
$query = $db->admin_query($dblink, $login);
$edata = mysqli_fetch_array($query);
$status = intval($edata['status']);
mysqli_close($dblink);
$keyid = 'CE'.$key.$_SERVER["REMOTE_ADDR"];
$keyid = md5($keyid);
if ( ( (is_null($_SESSION['devid'])) || $status != 1 ) || ($_SESSION['devid'] != $keyid) ) {
	echo '<meta http-equiv="refresh" content="0;URL=login.php">';
	exit(0);
}
?>