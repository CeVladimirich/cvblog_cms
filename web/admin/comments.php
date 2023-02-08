<?php
require("bootstrap.php");
require_once("./config.php");
require_once("./../libs/db_query.php");
$db = new db_query();
$dblink = $db->start($server, $user, $password, $dbname);
$mode = $_GET['mode'];
switch($mode) {
    case 'del':
        $sid = $_GET['id'];
        $dbq = $dblink->prepare("DELETE FROM comments WHERE id = :id");
        $dbq->bindParam(':id', $sid);
        $dbq->execute();
        echo '<meta http-equiv="refresh" content="0;URL=?page=comments">';
        break;
    case 'setflag':
        $flag = $_GET['flag'];
        $id = $_GET['id'];
        $dbq = $dblink->prepare("UPDATE comments SET flag = :flag WHERE id = :id");
        $dbq->bindParam(':flag', $flag);
        $dbq->bindParam(':id', $id);
        $dbq->execute();
        echo '<meta http-equiv="refresh" content="0;URL=?page=comments">';
        break;
    default:
        include './includes/comments_default.php';
}