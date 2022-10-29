<?php
	$arm_1 = $_GET['type'];
	switch($arm_1) {
	case read:
			include 'config.php';
			$table = 'notes';
			$dblink = mysqli_connect($server, $user, $password);
			mysqli_select_db($dblink, $dbname);
			$id = $_GET['id'];
			$sql = mysqli_query($dblink, "SELECT * FROM $table WHERE `id`=$id");
			while ($row = mysqli_fetch_array($sql)) {
				echo "<article class='post' id='{$row['id']}'>
					<div class='post-content'>
					<h2 class='post-title'>{$row['title']}</h2>
					{$row['text']}
					</div>
				</article>";
			}
	break;
	default:
		include 'config.php';
		$table = 'notes';
		$dblink = mysqli_connect($server, $user, $password);
		mysqli_select_db($dblink, $dbname);
		$sql = mysqli_query($dblink, "SELECT * FROM $table ORDER BY `date` DESC");
		while ($row = mysqli_fetch_array($sql)) {
			echo '<h2>все заметки.</h2><br>';
			echo "<article class='post' id='{$row['id']}'>
				<div class='post-content'>
				<a href='?page=note&type=read&id={$row['id']}'><h2 class='post-title'>{$row['title']}</h2></a>
				<p>Дата создания: {$row['date']}</p>
				</div>
				<hr>
			</article>";
		}
	break;
	}
?>	
