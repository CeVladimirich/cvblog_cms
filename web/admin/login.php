<?php
include "config.php";
require_once(__DIR__."/../../libs/db_query.php");
$db = new db_query();
$dblink = $db->start($server, $user, $password, $dbname);
// from loginform
$ruser = $_POST['login'];
$pw = $_POST['password'];
$ruser = htmlspecialchars(stripslashes($ruser));
$pw = htmlspecialchars(stripslashes($pw));
$ruser = trim($ruser);
$pw = md5($pw); // encode to hash
foreach($db->getArray($dblink, "admins", "", "", "") as $data) {
    $login = $data['login'];
    $passwd = $data['password'];
    if ($login == $ruser and $passwd == $pw) {
    echo json_encode(array("success" => 1));
    setcookie("ip_address", $_SERVER['REMOTE_ADDR'], time()+7200, '/admin');
    setcookie("login", $login, time()+7200, '/admin');
    setcookie("hash", $passwd, time()+7200, '/admin');
    } else {
        echo json_encode(array("success" => 0));
    }
}