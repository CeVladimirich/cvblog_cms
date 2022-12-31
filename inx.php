<?php
include '/admin/config.php';
$table = 'posts';
$tpc = $_SESSION['indx_tpc'];
$dblink = mysqli_connect($server, $user, $password);
mysqli_select_db($dblink, $dbname);
$query = mysqli_query($dblink, "SELECT * FROM $table WHERE topicid = $tpc AND postflag = 1 ORDER BY date DESC");
while($data = mysqli_fetch_array($query)) {
$desc = base64_decode($data['description']);
echo '<article class="post" id="'.$data['id'].'">';
echo '<div class="post-content">';
echo '<h2 class="post-title"><a href="?page=post&type=read&id='.$data['id'].'">'.$data['title'].'</h2>';
echo '<p><em>Дата создания: '.$data['date'].'</em></p>';
echo '<p>'.$desc.'</p></a>';
echo '</div></article><hr>';
}
?>