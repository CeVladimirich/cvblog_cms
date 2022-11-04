<?php
session_start();
include 'config.php';
$table = 'admins';
$dblink = mysqli_connect($server, $user, $password);
mysqli_select_db($dblink, $dbname);
mysqli_query($dblink, "SET NAMES 'utf8'");
$f = $_GET['f'];
switch($f) {
case login:
$ruser = $_POST['login'];
$pw = $_POST['password'];
$ruser = htmlspecialchars(stripslashes($ruser));
$pw = htmlspecialchars(stripslashes($pw));
$ruser = trim($ruser);
$pw = md5($pw);
$query = mysqli_query($dblink, "SELECT * FROM $table");
while ($data = mysqli_fetch_array($query)) {
	$login = $data['login'];
	$passwd = $data['password'];
	if ($login == $ruser and $passwd == $pw) {

	$key = 'CE'.$key.$_SERVER["REMOTE_ADDR"];
	$key1 = md5($key);

	$_SESSION['devid'] = $key1;
	$_SESSION['login'] = $login;	

	echo '<meta http-equiv="refresh" content="0;URL=?page=login">';

	exit(0);
	}
}
//echo '<meta http-equiv="refresh" content="4;URL=?page=adm&admtype=adminlogin">';
break;
case logout:

unset($_SESSION['devid']);
session_destroy();

echo '<meta http-equiv="refresh" content="0;URL=?page=login">';

break;
default:
$key = 'CE'.$key.$_SERVER["REMOTE_ADDR"];
$key = md5($key);
if ( $_SESSION['devid'] == $key ) {
	echo '<meta http-equiv="refresh" content="0;URL=index.php">';
} else {
echo '<table width="100%" cellspacing="0" border="0"><form action="?page=login&f=login" method="post">';
echo '<tr><td>Пользователь:</td><td><input type="text" name="login" size="10"   /></td></tr>';
echo '<tr><td>Пароль:</td><td><input type="password" name="password" size="10"  /></td></tr>';
echo '<tr><td colspan="2" align="center"><input type="submit" value="Войти" /></form></td></tr></table>';
}
}
?>
