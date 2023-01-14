<?php
include_once('./../config.php');
include_once('./../../libs/db_query.php');
$db = new db_query();
$dblink = $db->start($server, $user, $password, $dbname);
$mode = $_GET['mode'];
switch($mode) {
    case 'setindx':
        $sid = $_GET['id'];
        mysqli_query($dblink, "UPDATE config SET index_tpc = $sid");
        echo '<meta http-equiv="refresh" content="0;URL=?page=settings">';
        break;
    case 'pos':
        $sid = $_GET['id'];
        $squery = mysqli_query($dblink, "SELECT * FROM topics WHERE id = $sid");
        $source = mysqli_fetch_array($squery);
        $spos = intval($source['position']);
        $tpos = intval($_GET['pos']);
        $q1 = mysqli_query($dblink,"UPDATE topics SET position = $spos WHERE position = $tpos");
        $q2 = mysqli_query($dblink,"UPDATE topics SET position = $tpos WHERE id = $sid");
        echo '<meta http-equiv="refresh" content="0;URL=?page=settings">';
        break;
    case 'edit':
        $type = $_GET['type'];
        switch($type) {
            case 'topic':
                $sid = $_GET['id'];
                $topicname = $_POST['namePost'];
                $op = intval($_POST['onepage']);
                mysqli_query($dblink, "UPDATE topics SET topic = '$topicname', one_page = $op WHERE id = $sid");
                echo '<meta http-equiv="refresh" content="0;URL=?page=settings">';
                break;
            default:
                include_once('404.php');
        }
        break;
    case 'del':
        $type = $_GET['type'];
        switch($type) {
            case 'topic':
                $sid = $_GET['id'];
                // get position
                $squery = $db -> topic_query_pages($dblink, $sid);
                $source = mysqli_fetch_array($squery);
                $spos = intval($source['position']);
                // get index
                $squery = mysqli_query($dblink, "SELECT * FROM config");
                $sdata = mysqli_fetch_array($squery);
                $index = $sdata['index_tpc'];

                // deleting
                mysqli_query($dblink, "DELETE FROM topics WHERE id = $sid");
                // update positions
                mysqli_query($dblink, "UPDATE topics SET position = position - 1 WHERE position > $spos");
                // update index
                if ($sid == $index) {
                    $squery = mysqli_query($dblink, "SELECT * FROM topics ORDER BY id ASC");
                    $sdata = mysqli_fetch_array($squery);
                    $spos = intval($sdata['id']);
                    mysqli_query($dblink, "UPDATE config SET index_tpc = $spos WHERE id = 1");
                }
                echo '<meta http-equiv="refresh" content="0;URL=?page=settings">';
                break;
            default:
            include_once('404.php');
        }
        break;
    case 'add':
        $type = $_GET['type'];
        switch($type) {
            case 'topic':
                $topicname = $_POST['namePost'];
                $op = $_POST['onepage'];
                $setindex = $_POST['setindex'];
                $last = mysqli_query($dblink, "SELECT * FROM topics ORDER BY position DESC");
                $sdata = mysqli_fetch_array($last);
                $spos = intval($sdata['position'])+1;
                mysqli_query($dblink, "INSERT INTO topics (topic, position, one_page) VALUES ('$topicname', $spos, $op)");
                // set topic in index page
                if (isset($setindex)) {
                $last = mysqli_query($dblink, "SELECT * FROM topics ORDER BY id DESC");
                $sdata = mysqli_fetch_array($last);
                $sid = $sdata['id'];
                mysqli_query($dblink, "UPDATE config SET index_tpc = $sid");
                }
                echo mysqli_error($dblink);
                // redirect to adding post
                if ($op == '1') {
                    echo '<meta http-equiv="refresh" content="0;URL=?page=articles&mode=addpost">';
                } else {
                    echo '<meta http-equiv="refresh" content="0;URL=?page=settings">';
                }
                break;
            default:
            include_once('404.php');
        }
        break;
    case 'addtopic':
        include_once('./includes/settings/settings_addform.php');
        break;
    default:
        include './includes/settings/settings_page.php';
}