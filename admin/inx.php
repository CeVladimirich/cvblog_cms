<?php
include 'admin/config.php';
$dblink = mysqli_connect($server, $user, $password);
mysqli_select_db($dblink, $dbname);
mysqli_query($dblink, "SET NAMES 'utf8'");
$query = mysqli_query($dblink, "SELECT * FROM posts WHERE topicid = 1");
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