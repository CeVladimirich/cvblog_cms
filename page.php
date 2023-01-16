<?php
include 'admin/config.php';
// Connecting to DB
$db = new db_query();
$show = new db_show();
$dblink = $db->start($server, $user, $password, $dbname);
$page = $_GET['page'];
$typ = $_GET['type'];
switch($typ) {
case com:
$id = $_GET['post_id'];
include "admin/config.php";
$table2 = 'comments';
$name = $_POST['name'];
$date = date("Y-m-d H:i");
$text = $_POST['text'];
mysqli_query($dblink, "INSERT INTO $table2 (author, text, date, post_id) VALUES ('$name', '$text', '$date', $id)");
echo '<meta http-equiv="refresh" content="0;URL=?page='.$page.'&type=read&id='.$id.'">';
break;
case read:
$sid = $_GET['id'];
$query2 = $db->post_query($dblink, $sid);
$query4 =$db->topic_query_pages($dblink, $page);
$comment_query = $db->comments_post_query($dblink, $sid, 'id', 'DESC');
$sdata = mysqli_fetch_array($query4);
if($sdata['one_page'] == False) {
    echo $show->show_article($query2);
    echo '<hr>';
    echo $show->show_input_comment($page, $sid);
    echo '<hr />';
    echo $show->show_comments($comment_query);
} else {
    echo $show->show_one_page($query2);
}
break;

default:
$query = $db->posts_query_list($dblink, $page, 1, 'date', 'DESC');
$query1 = $db->topic_query_pages($dblink, $page);
$sdata = mysqli_fetch_array($query1);
if ($sdata['one_page'] == False) {
while ($data = mysqli_fetch_array($query)) {
echo '<article class="post" id="'.$data['id'].'">';
echo '<div class="post-content">';
echo '<a href="?page='.$page.'&type=read&id='.$data['id'].'"><h2>'.$data['title'].'</h2></a>';
echo '<em>Дата создания: '.$data['date'].'</em>';
echo '</div></article><hr />';
}
} else {
$data = mysqli_fetch_array($query);
echo '<meta http-equiv="refresh" content="0;URL=?page='.$page.'&type=read&id='.$data['id'].'">';
}
}
?>