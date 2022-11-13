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
include 'config.php';
$dblink = mysqli_connect($server, $user, $password); 
mysqli_select_db($dblink, $dbname);
mysqli_query($dblink, "SET NAMES 'utf8'");
$tr = $_GET['mode'];
switch($tr) {
case setpasswd:
$tek_passwd = $_POST['tek_passwd'];
$tek_passwd = md5($tek_passwd);
$new = $_POST['new_passwd'];
$re_new = $_POST['re_new_passwd'];
$new = md5($new);
$re_new = md5($re_new);
$query = mysqli_query($dblink, "SELECT * FROM admins WHERE id = 1");
$data = mysqli_fetch_array($query);
$tek_mysql = $data['password'];
if($tek_passwd == $tek_mysql and $new == $re_new) {
	mysqli_query($dblink, "UPDATE admins SET password = '$new' WHERE id = 1");
	echo '<meta http-equiv="refresh" content="0;URL=?page=settings&mode=site">';
} else {
echo '<b>ТЕКУЩИЙ ПАРОЛЬ ВВЕДЕН НЕПРАВИЛЬНО//ПАРОЛИ ВВЕДЕНЫ НЕПРАВИЛЬНО! Попробуйте еще...</b>';
echo '<meta http-equiv="refresh" content="2;URL=?page=settings&mode=setpasswdfrm">';
}
break;
case setpasswdfrm:
echo '<center><form method="post" action="?page=settings&mode=setpasswd">';
echo '<label>Текущий пароль: </label><input type="password" name="tek_passwd"><br><br>';
echo '<label>Новый пароль: </label><input type="password" name="new_passwd"><br>';
echo '<label>Повторите пароль: </label><input type="password" name="re_new_passwd"><br>';
echo '<input type="submit" value="Применить">';
echo '</form></center>';
break;
case setconf:
include 'gen.php';
$email = $_POST['email'];
$name = $_POST['name'];
$server1 = $server;
$user1 = $user;
$pw1 = $password;
$dbname1 = $dbname;
$url = $_POST['url'];
$key = random_key();
$data = '<?php
$server = "'.$server1.'";
$user = "'.$user1.'";
$password = "'.$pw1.'";
$dbname = "'.$dbname1.'";
$email = "'.$email.'";
$name = "'.$name.'";
$url = "'.$url.'";
$key = "'.$key.'";
?>';
$fo = fopen('config.php', 'w+');
fwrite($fo, $data);
fclose($fo);
echo '<meta http-equiv="refresh" content="0;URL=?page=settings&mode=site">';
break;
case pos:
$sid = $_GET['id'];
$squery = mysqli_query($dblink, "SELECT * FROM topics WHERE id = $sid");
$source = mysqli_fetch_array($squery);
$spos = intval($source['position']);
$tpos = intval($_GET['pos']);
$q1 = mysqli_query($dblink,"UPDATE topics SET position = $spos WHERE position = $tpos");
$q2 = mysqli_query($dblink,"UPDATE topics SET position = $tpos WHERE id = $sid");
echo '<meta http-equiv="refresh" content="0;URL=?page=settings&mode=topics">';
break;
case edit:
$sid = $_GET['id'];
$name = $_POST['name'];
$tp = $_POST['type_page'];
mysqli_query($dblink, "UPDATE topics SET topic = '$name', one_page = $tp WHERE id = $sid");
echo '<meta http-equiv="refresh" content="0;URL=?page=settings&mode=topics">';
break;
case add:
$name = $_POST['name'];
$last = mysqli_query($dblink, "SELECT * FROM topics ORDER BY position DESC");
$sdata = mysqli_fetch_array($last);
$tp = $_POST['type_page'];
$spos = intval($sdata['position'])+1;
mysqli_query($dblink, "INSERT INTO topics (topic, position, one_page) VALUES ('$name', $spos, $tp)");
$error = mysqli_error($dblink);
//echo $error;
if ($tp == "False") {
echo '<meta http-equiv="refresh" content="0;URL=?page=settings&mode=topics">';
} else {
echo '<meta http-equiv="refresh" content="0;URL=?page=post&mode=addform">';
}
break;
case addtopic:
if ($_GET['type'] == 'edit') {
$sid = $_GET['id'];
$squery = mysqli_query($dblink, "SELECT * FROM topics WHERE id = $sid");
$sdata = mysqli_fetch_array($squery);
$sname = $sdata['topic'];
echo '<center><table><form id="form1" name="form1" enctype="multipart/form-data" method="post" action="?page=settings&mode=edit&id='.$sid.'">';
} else {
echo '<center><table><form id="form1" name="form1" enctype="multipart/form-data" method="post" action="?page=settings&mode=add">';
}
echo '<tr><td align="center">Тип раздела</td><td><select name="type_page">';
echo '<option value="True">Одностраничный</option>';
echo '<option value="False">Многостраничный</option>';
echo '</select></td></tr>';
echo '<tr><td colspan="2">После создания одностраничного раздела вы будете переброшены на страницу с созданием поста. Выберите названный раздел и начните писать.</td></tr>';
echo '<tr><td align="center">Название: </td><td><input type="text" name="name" size="30" value="'.$sname.'"></td></tr>';
echo '<tr><td align="center" colspan="2"><input type="submit" value="Добавить"></form></td></tr></table></center>';
break;
case del:
$sid = $_GET['id'];
$squery = mysqli_query($dblink, "SELECT * FROM topics WHERE id = $sid");
$source = mysqli_fetch_array($squery);
$spos = intval($source['position']);
mysqli_query($dblink, "DELETE FROM topics WHERE id = $sid");
mysqli_query($dblink, "UPDATE topics SET position = position - 1 WHERE position > $spos");
echo '<meta http-equiv="refresh" content="0;URL=?page=settings&mode=topics">';
break;
case site:
echo '<b>настройки сайта</b><br>';
echo '<form method="post" action="?page=settings&mode=setconf">';
echo '<label>Email: </label><input type="text" size="30" name="email" value="'.$email.'"><br>';
echo '<label>Название сайта: </label><input type="text" size="30" name="name" value="'.$name.'"><br>';
echo '<label>URL сайта: </label><input type="text" size="30" name="url" value="'.$url.'"><br>';
echo '<input type="submit" value="Изменить"><br>';
echo '</form>';
echo '<em>ПЕРЕЗАГРУЗИТЕ СТРАНИЦУ ПОСЛЕ ПРИМЕНЕНИЯ И ЗАНОВО ВОЙДИТЕ В АДМИНКУ!</em><br>';
echo '<b>админка</b><br>';
echo '<b><a href="?page=settings&mode=setpasswdfrm">изменить пароль</a></b>';
break;
case topics:
echo '<a href="?page=settings&mode=addtopic"><b>СОЗДАТЬ ТОПИК</b></a>';
echo '<center><table border="0">';
echo '<tr><td colspan="2">ID/Поз.</td><td>Название</td><td>Действия</td></tr>';
$query = mysqli_query($dblink, "SELECT * FROM topics ORDER BY position ASC");
while($data = mysqli_fetch_array($query)) {
echo '<tr><td>'.$data['id'].'</td><td>'.$data['position'].'</td><td>'.$data['topic'].'</td><td><a href="?page=settings&mode=addtopic&type=edit&id='.$data['id'].'">ИЗМЕНИТЬ</a><br>';
if(intval($data['position']) > 0) {
echo '<a href="?page=settings&mode=pos&pos='.(intval($data['position'])-1).'&id='.$data['id'].'">ВЛЕВО</a><br>';
}
if(intval($data['position']) < mysqli_num_rows($query)) {
echo '<a href="?page=settings&mode=pos&pos='.(intval($data['position'])+1).'&id='.$data['id'].'">ВПРАВО</a><br>';
}
echo '<a href="?page=settings&mode=del&id='.$data['id'].'">УДАЛИТЬ</a></td></tr>';
}
echo '</table></center>';
break;
default:
echo '<center><b><a href="?page=settings&mode=topics">НАСТРОЙКИ РАЗДЕЛОВ</a> | <a href="?page=settings&mode=site">НАСТРОЙКИ САЙТА</a> | <a href="index.php">НА ГЛАВНУЮ</a></b></center>';
}
?>