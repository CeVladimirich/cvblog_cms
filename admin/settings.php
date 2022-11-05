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
default:
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
}
?>