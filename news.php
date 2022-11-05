<h2>новости.</h2><br>
<?php
include "admin/config.php";
$table = 'news';
$dblink = mysqli_connect($server, $user, $password);
mysqli_select_db($dblink, $dbname);
$query = mysqli_query($dblink, "SELECT * FROM news ORDER BY id DESC");
while ($data = mysqli_fetch_array($query)) {
$date = $data['date'];
$date = date("d.m.Y", strtotime($date));
echo '<article class="post" id='.$data['id'].'>';
echo '<div class="post-content">';
echo '<h3 class="post-title">'.$data['title'].'</h3>';
echo '<em>Дата публикации: '.$date.'</em>';
echo '<p>'.$data['text'].'</p>';
echo '</div>';
echo '<hr>';
echo '</article>';
}
?>