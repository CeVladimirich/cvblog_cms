<?php
	$arm_1 = $_GET['type'];
	switch($arm_1) {
	case read:
			include "admin/config.php";
			$table = 'notes';
			$dblink = mysqli_connect($server, $user, $password);
			mysqli_select_db($dblink, $dbname);
			$id = $_GET['id'];
			$sql = mysqli_query($dblink, "SELECT * FROM $table WHERE `id`=$id");
			while ($row = mysqli_fetch_array($sql)) {
				$post = base64_decode($row['text']);
				echo "<article class='post' id='{$row['id']}'>
					<div class='post-content'>
					<h2 class='post-title'>{$row['title']}</h2>
					{$post}
					</div>
				</article>";
			}
	break;
	default:
		include "admin/config.php";
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
