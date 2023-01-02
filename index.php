<?php
/**
 * CeVladimirich's Blog CMS
 * @copyright Vladimir Volkov, 2022.
 * @version 2.0
 * @author CeVladimirich
 **/

//bootstrap

session_start();
include 'admin/config.php';
include_once 'libs/db_query.php';
include_once 'libs/db_show.php';
$db = new db_query();
$dblink = $db->start($server, $user, $password, $dbname);
$squery = $db->config_query($dblink);
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
				$db = new db_query();
				$query = $db -> topic_query($dblink);
				$show = new db_show();
				echo $show->show_topics($query);
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
		<?php
		$show = new db_show();
		echo $show->show_footer();
		?>
	</body>
	<script>
	$('.nav-toggle').on('click', function(){
		$('#menu').toggleClass('active');
	});
	</script>
</html>
