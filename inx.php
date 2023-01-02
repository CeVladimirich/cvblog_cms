<?php
include 'admin/config.php';
$db = new db_query();
$topic = $_SESSION['indx_tpc'];
$dblink = $db->start($server, $user, $password, $dbname);
$query = $db->posts_query_index($dblink, $topic, "id", "DESC");
$show = new db_show();
return $show->show_posts_desc($query);
?>
