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


?>
<?php
error_reporting(0);
include 'config.php';
$table = 'comments';
$dblink = mysqli_connect($server, $user, $password);
mysqli_select_db($dblink, $dbname);
$rq = $_GET['mode'];
switch ($rq) {
case set:
$sid = $_GET['id'];
$set = $_GET['flag'];
mysqli_query($dblink, "UPDATE $table SET flag = $set WHERE id = $sid");
echo '<meta http-equiv="refresh" content="0;URL=?page=comments">';
break;
case del:
$sid = $_GET['id'];
$query = mysqli_query($dblink, "DELETE FROM $table WHERE id = $sid");
echo '<meta http-equiv="refresh" content="0;URL=?page=comments">';
break;
default:
echo '<b>сортировать по: <u>комментариям</u> <a href="?page=comments">новые</a> | <a href="?page=comments&sort=com_old">старые<br><u>постам</u> <a href="?page=comments&sort=post_new">новые</a> | <a href="?page=comments&sort=post_old">старые</a></b>';
$lk = $_GET['sort'];
echo '<div class="post-content">';
switch($lk) {
case post_old:
$query = mysqli_query($dblink, "SELECT * FROM $table WHERE flag = 1 ORDER BY post_id ASC");
break;
case post_new:
$query = mysqli_query($dblink, "SELECT * FROM $table WHERE flag = 1 ORDER BY post_id DESC");
break;
case com_old:
$query = mysqli_query($dblink, "SELECT * FROM $table WHERE flag = 1 ORDER BY id ASC");
break;
default:
$query = mysqli_query($dblink, "SELECT * FROM $table WHERE flag = 1 ORDER BY id DESC");
break;
}
while($data = mysqli_fetch_array($query)) {
echo '<b>Автор: '.$data['author'].'</b><br>';
echo '<b>Дата: '.$data['date'].'</b>';
echo '<p>'.$data['text'].'</p>';
echo '<b><a href="?page=comments&mode=set&flag=0&id='.$data['id'].'">ЗАБЛОКИРОВАТЬ</a></b><hr>';
}
echo '<b><font color="grey">заблокированные комментарии</font></b><br>';
switch($lk) {
case post_old:
$query1 = mysqli_query($dblink, "SELECT * FROM $table WHERE flag = 0 ORDER BY post_id ASC");
break;
case post_new:
$query1 = mysqli_query($dblink, "SELECT * FROM $table WHERE flag = 0 ORDER BY post_id DESC");
break;
case com_old:
$query1 = mysqli_query($dblink, "SELECT * FROM $table WHERE flag = 0 ORDER BY id ASC");
break;
default:
$query1 = mysqli_query($dblink, "SELECT * FROM $table WHERE flag = 0 ORDER BY id DESC");
break;
}
while($data = mysqli_fetch_array($query1)) {
echo '<font color="grey"><b>Автор: '.$data['author'].'</b><br>';
echo '<b>Дата: '.$data['date'].'</b>';
echo '<p>'.$data['text'].'</p></font>';
echo '<b><a href="?page=comments&mode=del&id='.$data['id'].'"><font color="grey">УДАЛИТЬ</font></a> | <a href="?page=comments&mode=set&flag=1&id='.$data['id'].'"><font color="grey">ВОССТАНОВИТЬ</font></a></b><hr>';
}
echo '</div>';
break;
}
?>
