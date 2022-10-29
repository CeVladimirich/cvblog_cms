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

$keyid = ;
$keyid = md5($keyid);

if ( ( (is_null($_SESSION['devid'])) || $ep != 1 ) || ($_SESSION['devid'] != $keyid) ) {
	echo '<meta http-equiv="refresh" content="0;URL=?page=login">';

	exit(0);
}

//CUT HERE

?>
<?php
error_reporting(0);
include 'config.php';
$table = 'notes';
$dblink = mysqli_connect($server, $user, $password);
mysqli_select_db($dblink, $dbname);
$rq = $_GET['mode'];
switch ($rq) {
case edit:
$sid = $_GET['id'];
$name = $_POST['name'];
$date = $_POST['date'];
$text = $_POST['text'];

$text = nl2br($text);
$text = preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" >$3</a>", $text);
$desc = nl2br($desc);
$desc = preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" >$3</a>", $desc);

mysqli_query($dblink, "UPDATE $table SET title = '$name', date = '$date', text = '$text' WHERE id = $sid");
$error = mysqli_error($dblink);
//echo $error;
echo '<meta http-equiv="refresh" content="0;URL=?page=notes">';
break;
case add:
$date = $_POST['date'];
$name = $_POST['name'];
$text = $_POST['text'];

$text = nl2br($text);
mysqli_query($dblink, "INSERT INTO $table (title, date, text) VALUES ('$name', '$date', '$text')");
$error = mysqli_error($dblink);
//echo $error;
echo '<meta http-equiv="refresh" content="0;URL=?page=notes">';
break;
case del:
$sid = $_GET['id'];
$query = mysqli_query($dblink, "DELETE FROM $table WHERE id = $sid");
echo '<meta http-equiv="refresh" content="0;URL=?page=notes">';
break;
case addform:
if ($_GET['typeedit'] == 'on') {
$sid = $_GET['id'];
$squery = mysqli_query($dblink, "SELECT * FROM $table WHERE id = $sid");
$sdata = mysqli_fetch_array($squery);
$name = $sdata['title'];
$text = $sdata['text'];
$date = $sdata['date'];
$img = $sdata['img'];
$date = date("Y-m-d", strtotime($datesrc));
$desc = $sdata['description'];
echo '<center><table><form id="form1" name="form1" enctype="multipart/form-data" method="post" action="?page=notes&mode=edit&id='.$sid.'">';
} else {
echo '<center><table><form id="form1" name="form1" enctype="multipart/form-data" method="post" action="?page=notes&mode=add">';
}
echo '<tr><td align="center">Название: </td><td><input type="text" name="name" size="30" value="'.$name.'"></td></tr>';
echo '<tr><td align="center">Дата: </td><td><input type="date" name="date" size="30" value="'.$date.'"></td></tr>';
echo '<tr><td align="center" colspan="2">Сама заметка:<br /><textarea rows="30" cols="100" name="text">'.$text.'</textarea></td></tr>';
echo '<tr><td align="center" colspan="2"><input type="submit" value="Добавить"></form></td></tr></table></center>';
break;
default:
echo '<a href="?page=notes&mode=addform"><b>ДОБАВИТЬ ЗАМЕТКУ</b></a>';
$query = mysqli_query($dblink, "SELECT * FROM `$table`");
while ($data = mysqli_fetch_array($query)) {
	echo '<article class="post">';
	echo '<div class="post-content">';
	echo '<h2 class="post-title">'.$data['title'].'</h2>';
	echo '<b>Дата: '.$data['date'].'</b>';
	echo '<p>'.$data['description'].'</p>';
	echo '<a href="?page=notes&mode=addform&typeedit=on&id='.$data['id'].'"><b>РЕДАКТИРОВАТЬ</b></a> | <a href="?page=notes&mode=del&id='.$data['id'].'"><b>УДАЛИТЬ</b></a>';
	echo '</div>';
	echo '<hr>';
	echo '</article>'; }
}
?>
