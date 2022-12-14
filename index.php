<?php
/**
 * CeVladimirich's Blog CMS
 * @copyright Vladimir Volkov, 2022.
 * @version 2.0
 * @author CeVladimirich
 **/

//bootstrap
include 'admin/config.php';
session_start();
$edblink = mysqli_connect($server, $user, $password); 
mysqli_select_db($edblink, $dbname);
mysqli_query($edblink, "SET NAMES 'utf8'");
$squery = mysqli_query($edblink, "SELECT * FROM config");
$sdata = mysqli_fetch_array($squery);
$_SESSION['indx_tpc'] = $sdata['index_tpc'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="/css/main.css">
		<title><?php include "admin/config.php"; echo $name;?></title>
		<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	</head>
	<body>
		<header>
			<nav class="container">
				<a href="<?php include "admin/config.php"; echo $url; ?>" id="logo"><p><?php include "admin/config.php"; echo $name; ?></p></a>
				<div class="nav-toggle"><span></span></div>
				<ul id="menu">
				<?php
				include "admin/config.php";
				$table = 'topics';
				$dblink = mysqli_connect($server, $user, $password);
				mysqli_select_db($dblink, $dbname);
				$query = mysqli_query($dblink, "SELECT * FROM topics");
				while($data = mysqli_fetch_array($query)) {
					echo '<li><a href="?page='.$data['id'].'">'.$data['topic'].'</a></li> ';
				}
				?>
				</ul>
			</nav>
		</header>
		<hr>
			<div class="container row">
						<div class="posts-list">
						<?php
$op = $_GET['page'];
if ($op != '') {
include 'page.php';
} else {
include 'inx.php';
}
						?>
						</div>
			</div>
		<footer>
			<div class="container">
				<div class="footer-col"><span>Powered on Cevladimirich's Blog CMS<br>By CeVladimirich, 2022</span></div>
				<div class="footer-col" align="right"><span><a href="mailto:<?php include "admin/config.php"; echo $email;?>">написать письмо</a></span></div>
			</div>
		</footer>
	</body>
	<script>
	$('.nav-toggle').on('click', function(){
		$('#menu').toggleClass('active');
	});
	</script>
</html>
