<?php
include 'admin/config.php';
include 'libs/db_query.php';
include 'libs/db_show.php';
$db = new db_query();
$topic = $_SESSION['index_tpc'];
$dblink = $db->start($server, $user, $password, $dbname);
$query = $db->posts_query($dblink, 1);
$show = new db_show();
return $show->show_posts_desc($query);
?>
