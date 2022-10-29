<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="/css/main.css">
		<title><?php include 'config.php'; echo $name;?></title>
		<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	</head>
	<body>
		<header>
			<nav class="container">
				<a href="<?php include 'config.php'; echo $url; ?>" id="logo"><p><?php include 'config.php'; echo $name; ?></p></a>
				<div class="nav-toggle"><span></span></div>
				<ul id="menu">
				<li><a href="?page=post">статьи</a></li>
				<li><a href="?page=news">новости</a></li>
				<li><a href="?page=me">обо мне</a></li>
				<li><a href="?page=note">заметки</a></li>
				</ul>
			</nav>
		</header>
		<hr>
			<div class="container row">
						<div class="posts-list">
						<?php
$op = $_GET['page'];
switch($op) {
case note:
include 'notes.php';
break;
case me:
include 'me.php';
break;
case news:
include 'news.php';
break;
case post:
include 'posts.php';
break;
case com:
include 'comments.php';
default:
include 'inx.php';
}
						?>
						</div>
			</div>
		<footer>
			<div class="container">
				<div class="footer-col"><span>Powered on Cevladimirich's Blog CMS<br>By CeVladimirich, 2022</span></div>
				<div class="footer-col" align="right"><span><a href="mailto:<?php include 'config.php'; echo $email;?>">написать письмо</a></span></div>
			</div>
		</footer>
	</body>
	<script>
	$('.nav-toggle').on('click', function(){
		$('#menu').toggleClass('active');
	});
	</script>
</html>

