<?php
require_once("./config.php");
require_once("./../libs/db_query.php");
$db = new db_query();
$dblink = $db->start($server, $user, $password, $dbname);
$mode = $_GET['mode'];
switch($mode) {
    case 'del':
        $sid = $_GET['id'];
        mysqli_query($dblink, "DELETE FROM comments WHERE id = $sid");
        echo '<meta http-equiv="refresh" content="0;URL=?page=comments">';
        break;
    case 'setflag':
        $flag = $_GET['flag'];
        $id = $_GET['id'];
        mysqli_query($dblink, "UPDATE comments SET flag = $flag WHERE id = $id");
        echo '<meta http-equiv="refresh" content="0;URL=?page=comments">';
        break;
    default:
        include './includes/comments_default.php';
}