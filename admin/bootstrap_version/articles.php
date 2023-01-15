<?php
require_once("./../config.php");
require_once("./../../libs/db_query.php");
$db = new db_query();
$dblink = $db->start($server, $user, $password, $dbname);
$mode = $_GET['mode'];
$stype = $_GET['type'];
switch($mode) {
    case 'del':
        $sid = $_GET['id'];
        $squery1 = $db->post_query($dblink, $sid);
        $sdata = mysqli_fetch_array($squery1);
        $tpc = $sdata['topicid'];
        mysqli_query($dblink, "DELETE FROM posts WHERE id = $sid");
        echo '<meta http-equiv="refresh" content="0;URL=?page=articles&topic='.$tpc.'">';
        break;
    case 'edit':
        $sid = $_GET['id'];
        $name = $_POST['namePost'];
        $date = $_POST['datePost'];
        $article = $_POST['articlePost'];
        $article = nl2br($article);
        $article = base64_encode($article);
        $desc = $_POST['descPost'];
        $desc = nl2br($desc);
        $desc = base64_encode($desc);
        mysqli_query($dblink, "UPDATE posts SET title = '$name', date = '$date', post = '$article', description = '$desc' WHERE id = $sid");
        $squery1 = $db->post_query($dblink, $sid);
        $sdata = mysqli_fetch_array($squery1);
        $tpc = $sdata['topicid'];
        echo '<meta http-equiv="refresh" content="0;URL=?page=articles&topic='.$tpc.'">';
        break;
    case 'add':
        $name = $_POST['namePost'];
        $tpc = $_POST['selectPost'];
        $date = $_POST['datePost'];
        $article = $_POST['articlePost'];
        $article = nl2br($article);
        $article = base64_encode($article);
        $pf = 2; // status draft
        $author = $_SESSION['login'];
        $desc = $_POST['descPost'];
        $desc = nl2br($desc);
        $desc = base64_encode($desc);
        mysqli_query($dblink, "INSERT INTO posts (date, topicid, postflag, title, author, post, description) VALUES ('$date', $tpc, $pf, '$name', '$author', '$article', '$desc')");
        echo '<meta http-equiv="refresh" content="0;URL=?page=articles&topic='.$tpc.'">';
        break;
    case 'addpost':
        $squery = $db->topic_query($dblink);
        include './includes/articles_addform.php';
        break;
    case 'setpf':
        $pf = $_GET['pf'];
        $sid = $_GET['id'];
        $tpc = $_GET['from_tpc'];
        mysqli_query($dblink, "UPDATE posts SET postflag = $pf WHERE id = $sid");
        echo '<meta http-equiv="refresh" content="0;URL=?page=articles&topic='.$tpc.'">';
        break;
    default:
    //check on topic ID exists
    $tpcid = filter_input(INPUT_GET, 'topic', FILTER_SANITIZE_STRING);
    if(!isset($mode)) {
    if(!isset($tpcid) || $tpcid == '') {
        $squery = $db->topic_query($dblink);
        $sdata = mysqli_fetch_array($squery);
        echo '<meta http-equiv="refresh" content="0;URL=?page=articles&topic='.$sdata['id'].'">';
    } else {
        $squery = $db->topic_query_pages($dblink, $tpcid);
        $sdata = mysqli_fetch_array($squery);
        $query_2 = $db->posts_query_list($dblink, $tpcid, 2, "id", "DESC"); // postflag = 2, drafts
        $query_1 = $db->posts_query_list($dblink, $tpcid, 1, "id", "DESC"); // postflag = 1, published
        $query_0 = $db->posts_query_list($dblink, $tpcid, 0, "id", "DESC"); // postflag = 0, deleted
        include './includes/articles_default.php';
    }
}
}
