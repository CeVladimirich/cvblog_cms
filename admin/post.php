<?php

//by Darkine
session_start();
include 'config.php';
$edblink = mysqli_connect($server, $user, $password); 
mysqli_select_db($edblink, $dbname);
mysqli_query($edblink, "SET NAMES 'utf8'");
$elogin = $_SESSION['login'];
$equery = mysqli_query($edblink, "SELECT * FROM admins WHERE login = '$elogin'");
$edata = mysqli_fetch_array($equery);

$ep = intval($edata['status']);

mysqli_close($edblink);

$keyid = 'CE'.$key.$_SERVER["REMOTE_ADDR"];
$keyid = md5($keyid);

if ( ( (is_null($_SESSION['devid'])) || $ep != 1 ) || ($_SESSION['devid'] != $keyid) ) {
	echo '<meta http-equiv="refresh" content="0;URL=?page=login">';

	exit(0);
}

//CUT HERE

?>
<?php
include 'config.php';
$tid = $_GET['topicid'];
$mp = $_GET['mode'];
$dblink = mysqli_connect($server, $user, $password); 
mysqli_select_db($dblink, $dbname);
mysqli_query($dblink, "SET NAMES 'utf8'");
switch($mp) {
case postoff:
$sid = $_GET['id'];
mysqli_query($dblink, "UPDATE posts SET postflag = 0 WHERE id = $sid");
echo '<meta http-equiv="refresh" content="0;URL=?page=post&topicid='.$tid.'">';
break;
case edit:
$sid = $_GET['id'];
$name = $_POST['name'];
$date = $_POST['date'];
$text = $_POST['text'];
$desc = $_POST['desc'];

$text = nl2br($text);
$desc = nl2br($desc);

$text = base64_encode($text);
$desc = base64_encode($desc);

mysqli_query($dblink, "UPDATE posts SET title = '$name', date = '$date', post = '$text', description = '$desc' WHERE id = $sid");
$error = mysqli_error($dblink);
//echo $error;
echo '<meta http-equiv="refresh" content="0;URL=?page=post&topicid='.$tid.'">';
break;
case poston:
$sid = $_GET['id'];
mysqli_query($dblink, "UPDATE posts SET postflag = 1 WHERE id = $sid");
echo '<meta http-equiv="refresh" content="0;URL=?page=post&topicid='.$tid.'">';
break;
case add:
$type = $_GET['type'];
switch($type) {
case viewpost:
$date = $_POST['date'];
$date = date("Y-m-d H:i", strtotime($date));
$name = $_POST['name'];
$text = $_POST['text'];
$desc = $_POST['desc'];
$topic = $_POST['topicid'];
$text = nl2br($text);
$desc = nl2br($desc);
echo '<article class="post" id="">';
echo '<div class="post-content">';
echo '<em>??????????????????, ?????? ?????? ???????????????? ???????????? ??????, ?????? ???? ??????????????????????, ?? ?????????????? ?????????? ???????????? "????????????????"</em><br />';
echo '<em>?????????????????????? ?????????????????????? ???????? ?????????? ???????????????? ???? ???????????????? ????????????!</em><br />';
echo '<h2 class="post-title">'.$name.'</h2>';
echo '<em>??????????: '>$_SESSION['login'].'</em><br>';
echo '<em>???????? ????????????????: '.$date.'</em><br>';
echo $text;
echo '<form action="?page=post&mode=add" method="post">';
echo '<input type="hidden" name="name" value="'.$name.'">';
echo '<input type="hidden" name="text" value="'.$text.'">';
echo '<input type="hidden" name="date" value="'.$date.'">';
echo '<input type="hidden" name="topicid" value="'.$topic.'">';
echo '<input type="hidden" name="desc" value="'.$desc.'">';
echo '<input type="submit" value="????????????????"></form>';
echo '</div></article>';
break;
default:
$postflag = 2;
$date = $_POST['date'];
$date = date("Y-m-d H:i", strtotime($date));
$name = $_POST['name'];
$text = $_POST['text'];
$autor = $_SESSION['login'];
$desc = $_POST['desc'];
$topic = $_POST['topicid'];
$text = base64_encode($text);
$desc = base64_encode($desc);
mysqli_query($dblink, "INSERT INTO posts (title, date, post, description, author, topicid, postflag) VALUES ('$name', '$date', '$text', '$desc', '$autor', $topic, $postflag)");
$error = mysqli_error($dblink);
//echo $error;
echo '<meta http-equiv="refresh" content="0;URL=?page=post&topicid='.$topic.'">';
}
break;
case del:
$sid = $_GET['id'];
$query = mysqli_query($dblink, "DELETE FROM posts WHERE id = $sid");
echo '<meta http-equiv="refresh" content="0;URL=?page=post&topicid='.$tid.'">';
break;
case addform:
if ($_GET['typeedit'] == 'on') {
$sid = $_GET['id'];
$squery = mysqli_query($dblink, "SELECT * FROM posts WHERE id = $sid");
$sdata = mysqli_fetch_array($squery);
$sname = $sdata['title'];
$text = $sdata['post'];
$datesrc = $sdata['date'];
$img = $sdata['img'];
$pf = $sdata['postflag'];
$date = date("Y-m-d", strtotime($datesrc));
$desc = $sdata['description'];
$desc = base64_decode($desc);
$text = base64_decode($text);

echo '<center><table><form id="form1" name="form1" enctype="multipart/form-data" method="post" action="?page=post&topicid='.$tid.'&mode=edit&id='.$sid.'">';
} else {
echo '<center><table><form id="form1" name="form1" enctype="multipart/form-data" method="post" action="?page=post&mode=add&type=viewpost">';
echo '<tr><td align="center">?????????? ??????????: </td><td><select name="topicid">';
$squery = mysqli_query($dblink, "SELECT * FROM topics");
while ($sdata = mysqli_fetch_array($squery)) {
echo '<option value="'.$sdata['id'].'">'.$sdata['topic'].'</option>';
}
echo '</select></td></tr>';
}
echo '<tr><td align="center">????????????????: </td><td><input type="text" name="name" size="30" value="'.$sname.'"></td></tr>';
echo '<tr><td align="center">????????: </td><td><input type="date" name="date" size="30" value="'.$date.'"></td></tr>';
echo '<tr><td align="center" colspan="2">???????? ????????????:<br /><textarea rows="30" cols="100" name="text">'.$text.'</textarea></td></tr>';
echo '<tr><td align="center" colspan="2">????????????????:<br><textarea rows="20" cols="100" name="desc">'.$desc.'</textarea></td></tr>';
echo '<tr><td align="center" colspan="2"><input type="submit" value="????????????????"></form></td></tr></table></center>';
break;
default:
echo '<a href="?page=post&topicid='.$tid.'&mode=addform"><b>???????????????? ????????</b></a><br>';
$query = mysqli_query($dblink, "SELECT * FROM posts WHERE topicid = $tid AND postflag = 2 ORDER BY id DESC");
echo '<b>??????????????????</b><br>';
while($data = mysqli_fetch_array($query)) {
echo '<article class="post">';
echo '<div class="post-content">';
echo '<h2 class="post-title">'.$data['title'].'</h2>';
echo '<b>????????: '.$data['date'].'</b>';
$desc = base64_decode($data['description']);
echo '<p>'.$desc.'</p>';
echo '<a href="?page=post&topicid='.$tid.'&mode=poston&id='.$data['id'].'"><b>????????????????????????</b></a> | <a href="?page=post&topicid='.$tid.'&mode=addform&typeedit=on&id='.$data['id'].'"><b>??????????????????????????</b></a> | <a href="?page=post&topicid='.$tid.'&mode=postoff&id='.$data['id'].'"><b>??????????????</b></a>';
echo '</div>';
echo '<hr>';
echo '</article>';
}
$query = mysqli_query($dblink, "SELECT * FROM posts WHERE topicid = $tid AND postflag = 1 ORDER BY id DESC");
echo '<b>????????????????????????????</b><br>';
while($data = mysqli_fetch_array($query)) {
echo '<article class="post">';
echo '<div class="post-content">';
echo '<h2 class="post-title">'.$data['title'].'</h2>';
echo '<b>????????: '.$data['date'].'</b>';
$desc = base64_decode($data['description']);
echo '<p>'.$desc.'</p>';
echo '<a href="?page=post&topicid='.$tid.'&mode=addform&typeedit=on&topicid='.$tid.'&id='.$data['id'].'"><b>??????????????????????????</b></a> | <a href="?page=post&topicid='.$tid.'&mode=postoff&id='.$data['id'].'"><b>??????????????</b></a>';
echo '</div>';
echo '<hr>';
echo '</article>';
}
$query = mysqli_query($dblink, "SELECT * FROM posts WHERE topicid = $tid AND postflag = 0 ORDER BY id DESC");
echo '<font color="grey"><b>???????????????????? ????????????????</b><br>';
while($data = mysqli_fetch_array($query)) {
echo '<article class="post">';
echo '<div class="post-content">';
echo '<h2 class="post-title">'.$data['title'].'</h2>';
echo '<b>????????: '.$data['date'].'</b>';
$desc = base64_decode($data['description']);
echo '<p>'.$desc.'</p>';
echo '<a href="?page=post&topicid='.$tid.'&mode=poston&id='.$data['id'].'"><font color="grey"><b>????????????????????????</b></font></a> | <a href="?page=post&topicid='.$tid.'&mode=del&id='.$data['id'].'"><font color="grey"><b>?????????????? ????????????????????????</b></font></a>';
echo '</div>';
echo '<hr>';
echo '</article>';
}
echo '</font>';
}
?>
