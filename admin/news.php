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
error_reporting(0);
include 'config.php';
$table = 'news';
$dblink = mysqli_connect($server, $user, $password);
mysqli_select_db($dblink, $dbname);
$rq = $_GET['mode'];
switch($rq) {
case edit:
$sid = $_GET['id'];
$name = $_POST['name'];
$date = $_POST['date'];
$text = $_POST['text'];
$url = $url.'/?page=news';

$text = nl2br($text);
$text = preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" >$3</a>", $text);
$text = base64_encode($text);
mysqli_query($dblink, "UPDATE $table SET title = '$name', date = '$date', text = '$text', url = '$url' WHERE id = $sid");
$error = mysqli_error($dblink);
//echo $error;
echo '<meta http-equiv="refresh" content="0;URL=?page=news">';
break;
case add:
$type = $_GET['type'];
switch($type) {
case viewpost:
$date = $_POST['date'];
$date = date("Y-m-d H:i", strtotime($date));
$name = $_POST['name'];
$text = $_POST['text'];
$text = nl2br($text);
echo '<article class="post" id="">';
echo '<div class="post-content">';
echo '<em>Убедитесь, что всё выглядит именно так, как вы планировали, и нажмите снизу кнопку "Добавить"</em><br />';
echo '<h2 class="post-title">'.$name.'</h2>';
echo '<em>Дата создания: '.$date.'</em><br>';
echo $text;
echo '<form action="?page=news&mode=add" method="post">';
echo '<input type="hidden" name="name" value="'.$name.'">';
echo '<input type="hidden" name="text" value="'.$text.'">';
echo '<input type="hidden" name="date" value="'.$date.'">';
echo '<input type="submit" value="Добавить"></form>';
echo '</div></article>';
break;
default:
$date = $_POST['date'];
$name = $_POST['name'];
$text = $_POST['text'];
$url = $url.'/?page=news';
$text = base64_encode($text);
mysqli_query($dblink, "INSERT INTO $table (title, date, text, url) VALUES ('$name', '$date', '$text', '$url')");
$error = mysqli_error($dblink);
//echo $error;
echo '<meta http-equiv="refresh" content="0;URL=?page=news">';
}
break;
case del:
$sid = $_GET['id'];
$query = mysqli_query($dblink, "DELETE FROM $table WHERE id = $sid");
echo '<meta http-equiv="refresh" content="0;URL=?page=news">';
break;
case addform:
if ($_GET['typeedit'] == 'on') {
$sid = $_GET['id'];
$squery = mysqli_query($dblink, "SELECT * FROM $table WHERE id = $sid");
$sdata = mysqli_fetch_array($squery);
$name = $sdata['title'];
$text = $sdata['text'];
$date = $sdata['date'];
$text = base64_decode($text);
$date = date("Y-m-d", strtotime($datesrc));
echo '<center><table><form id="form1" name="form1" enctype="multipart/form-data" method="post" action="?page=news&mode=edit&id='.$sid.'">';
} else {
echo '<center><table><form id="form1" name="form1" enctype="multipart/form-data" method="post" action="?page=news&mode=add&type=viewpost">';
}
echo '<tr><td align="center">Название: </td><td><input type="text" name="name" size="30" value="'.$name.'"></td></tr>';
echo '<tr><td align="center">Дата: </td><td><input type="date" name="date" size="30" value="'.$date.'"></td></tr>';
echo '<tr><td align="center" colspan="2">Сама новость:<br /><textarea rows="30" cols="100" name="text">'.$text.'</textarea></td></tr>';
echo '<tr><td align="center" colspan="2"><input type="submit" value="Добавить"></form></td></tr></table></center>';
break;
default:
echo '<a href="?page=news&mode=addform"><b>ДОБАВИТЬ НОВОСТЬ</b></a>';
$query = mysqli_query($dblink, "SELECT * FROM `$table`");
while ($data = mysqli_fetch_array($query)) {
	$text = base64_decode($data['text']);
	echo '<article class="post">';
	echo '<div class="post-content">';
	echo '<h2 class="post-title">'.$data['title'].'</h2>';
	echo '<b>Дата: '.$data['date'].'</b>';
	echo '<p>'.$text.'</p>';
	echo '<a href="?page=news&mode=addform&typeedit=on&id='.$data['id'].'"><b>РЕДАКТИРОВАТЬ</b></a> | <a href="?page=news&mode=del&id='.$data['id'].'"><b>УДАЛИТЬ</b></a>';
	echo '</div>';
	echo '<hr>';
	echo '</article>'; 
}
break;
}
?>
