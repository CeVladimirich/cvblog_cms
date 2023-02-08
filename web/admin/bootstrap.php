<?php
require("config.php");
require_once(__DIR__."/../../libs/db_query.php");
$db = new db_query();
$login = $_COOKIE['login'];
$hash = $_COOKIE['hash'];
$dblink = $db->start($server, $user, $password, $dbname);
$edata = $db->getRecord($dblink, "admins", "login", $login, "", "", "");
$status = intval($edata['status']);
if ( ( (is_null($_COOKIE['login'])) || $status != 1 ) || ($_COOKIE['hash'] != $edata['password']) ) {
	echo '<meta http-equiv="refresh" content="0;URL=/admin/login">';
	exit(0);
}
require(__DIR__."/includes/head.php");
require(__DIR__."/includes/header.php");
?>