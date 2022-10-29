<?php

//CUT HERE

//NDR\DAN ADMIN LOGIN 2.1
//by Darkine
session_start();
include 'config.php';
$edblink = mysqli_connect($server, $user, $password);
mysqli_select_db($edblink, $dbname);
mysqli_query($edblink, "SET NAMES 'utf8'");
$elogin = $_SESSION['login'];
$equery = mysqli_query($edblink, "SELECT * FROM ceadmins WHERE login = '$elogin'");
$edata = mysqli_fetch_array($equery);

//------------EDIT HERE------------
$ep = intval($edata['status']);
//---------------------------------

mysqli_close($edblink);

$keyid = 'CE'.'lGgaZyK5J'.$_SERVER["REMOTE_ADDR"];
$keyid = md5($keyid);

if ( ( (is_null($_SESSION['devid'])) || $ep != 1 ) || ($_SESSION['devid'] != $keyid) ) {
	//echo $_SESSION['devid']." RECV ".$ep." MUST ".$keyid;
	echo '<meta http-equiv="refresh" content="0;URL=?page=login">';

	exit(0);
}

//CUT HERE

?>
<?php
echo '<center><a href="?page=post"><b>ПОСТЫ</b></a> | <a href="?page=news"><b>НОВОСТИ</b></a> | <a href="?page=notes"><b>ЗАМЕТКИ</b></a> | <a href="?page=comments"><b>КОММЕНТАРИИ</b></a> | <a href="?page=login&f=logout"><b>ВЫХОД</b></a></center>';
?>