<?php
include "admin/config.php";
$oh = $_GET['page'];
$oj = $_GET['type'];
$table = 'posts';
$table1 = 'topics';
$dblink = mysqli_connect($server, $user, $password);
mysqli_select_db($dblink, $dbname);
switch($oj) {
case com:
$id = $_GET['post_id'];
include "admin/config.php";
$table2 = 'comments';
$name = $_POST['name'];
$date = date("Y-m-d H:i");
$text = $_POST['text'];
mysqli_query($dblink, "INSERT INTO $table2 (author, text, date, post_id) VALUES ('$name', '$text', '$date', $id)");
echo '<meta http-equiv="refresh" content="0;URL=?page='.$oh.'&type=read&id='.$id.'">';
break;
case read:
$ot = $_GET['id'];
$query2 = mysqli_query($dblink, "SELECT * FROM $table WHERE id = $ot");
$query4 = mysqli_query($dblink, "SELECT * FROM $table1 WHERE id = $oh");
$sdata = mysqli_fetch_array($query4);
while($data = mysqli_fetch_array($query2)) {
if ($sdata['one_page'] == False) {
$post = base64_decode($data['post']);
echo '<article class="post" id="'.$data['id'].'">';
echo '<div class="post-content">';
echo '<h2 class="post-title">'.$data['title'].'</h2>';
echo '<em>Дата создания: '.$data['date'].'</em><br>';
echo $post;
echo '</div><hr />';
echo '<h2>комментарии</h2>';
echo '<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="?page='.$oh.'&type=com&post_id='.$ot.'">';
echo 'Ваше имя*: <input type="text" name="name" required="required"><br>';
echo 'Сам комментарий*:<br><textarea name="text" rows="20" cols="70" required="required"></textarea><br>';
echo '<input type="submit" value="Отправить"></form>';
echo '* - все поля обязательны!<br><hr>';
$query = mysqli_query($dblink, "SELECT * FROM comments WHERE post_id = $ot AND flag = 1 ORDER BY id DESC");
while($data = mysqli_fetch_array($query)) {
$date = $data['date'];
$date = date("d.m.Y", strtotime($date));
echo '<b>'.$data['author'].'</b><br>';
echo '<em>Дата: '.$date.'</em><br>';
echo '<p>'.$data['text'].'</p><hr>'; 
echo '</article>';
}
} else {
$post = base64_decode($data['post']);
echo '<article class="post" id="'.$data['id'].'">';
echo '<div class="post-content">';
echo $post;
echo '</div></article>';
}
}
break;

default:
$query = mysqli_query($dblink, "SELECT * FROM $table WHERE topicid = $oh AND postflag = 1 ORDER BY date DESC");
$query1 = mysqli_query($dblink, "SELECT * FROM $table1 WHERE id = $oh");
$sdata = mysqli_fetch_array($query1);
if ($sdata['one_page'] == False) {
while ($data = mysqli_fetch_array($query)) {
echo '<article class="post" id="'.$data['id'].'">';
echo '<div class="post-content">';
echo '<a href="?page='.$oh.'&type=read&id='.$data['id'].'"><h2>'.$data['title'].'</h2></a>';
echo '<em>Дата создания: '.$data['date'].'</em>';
echo '</div></article><hr />';
}
} else {
$data = mysqli_fetch_array($query);
echo '<meta http-equiv="refresh" content="0;URL=?page='.$oh.'&type=read&id='.$data['id'].'">';
}
}
?>