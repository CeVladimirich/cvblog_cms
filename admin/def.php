<?php

//by Darkine
session_start();
include 'config.php';
$edblink = mysqli_connect($server, $user, $password); 
mysqli_select_db($edblink, $dbname);
mysqli_query($edblink, "SET NAMES 'utf8'");
$elogin = $_SESSION['login'];
$equery = mysqli_query($edblink, "SELECT * FROM admins WHERE login = '$elogin'");
$edata = mysqli_fetch_array($equery);

$ep = intval($edata['status']);

mysqli_close($edblink);

$keyid = 'CE'.$key.$_SERVER["REMOTE_ADDR"];
$keyid = md5($keyid);

if ( ( (is_null($_SESSION['devid'])) || $ep != 1 ) || ($_SESSION['devid'] != $keyid) ) {
	echo '<meta http-equiv="refresh" content="0;URL=?page=login">';

	exit(0);
}

//CUT HERE

?>
<?php
include 'config.php';
echo '<center>';
$dblink = mysqli_connect($server, $user, $password);
mysqli_select_db($dblink, $dbname);
mysqli_query($dblink, "SET NAMES 'utf8'");
$query = mysqli_query($dblink, "SELECT * FROM topics");
while($data = mysqli_fetch_array($query)) {
echo '| <a href="?page=post&topicid='.$data['id'].'"><b>'.$data['topic'].'</b></a> ';
}
echo '| <a href="?page=comments"><b>комментарии</b></a> | <a href="?page=settings"><b>настройки</b></a> | <a href="?page=login&f=logout"><b>выход</b></a> |</center>';
?>
