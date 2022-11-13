<?php
include "admin/config.php";
$table = 'articles';
$dblink = mysqli_connect($server, $user, $password);
mysqli_select_db($dblink, $dbname);
$query = mysqli_query($dblink, "SELECT * FROM $table ORDER BY date DESC");
while($data = mysqli_fetch_array($query)) {
$post = base64_decode($data['description']);
echo '<article class="post" id="'.$data['id'].'">';
echo '<div class="post-content">';
echo '<h2 class="post-title"><a href="?page=post&type=read&id='.$data['id'].'">'.$data['title'].'</h2>';
echo '<p><em>Дата создания: '.$data['date'].'</em></p>';
echo '<p>'.$post.'</p>';
echo '<img width="100%" src="/tmp/'.$data['img'].'">';
echo '</div></article><hr>';
}
?>