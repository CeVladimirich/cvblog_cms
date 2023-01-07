<?php
session_start();
include "../config.php";
include "../../libs/db_query.php";
$db = new db_query();
$login = $_SESSION['login'];
$dblink = $db->start($server, $user, $password, $dbname);
$query = $db->admin_query($dblink, $login);
$edata = mysqli_fetch_array($query);
$status = intval($edata['status']);
mysqli_close($dblink);
$keyid = 'CE'.$key.$_SERVER["REMOTE_ADDR"];
$keyid = md5($keyid);
if ( ( (is_null($_SESSION['devid'])) || $status != 1 ) || ($_SESSION['devid'] != $keyid) ) {
	echo '<meta http-equiv="refresh" content="0;URL=login.php">';
	exit(0);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель. Bootstrap version</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
            <?php
            include 'header_side.php';
            
            $page = $_GET['page'];
            if ($page == '') {
                include 'body.php';
            } else {
                if(file_exists($page.'.php')) {
                    include $page.'.php';
                } else {
                    include '404.php';
                }
            }
            ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>