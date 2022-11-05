<div class="container row">
	<div class="posts-list">
		<?php
			$arm_1 = $_GET['type'];
			switch($arm_1) {
			case com:
				$id = $_GET['post_id'];
				include "admin/config.php";
				$table1 = 'comments';
				$dblink = mysqli_connect($server, $user, $password);
				mysqli_select_db($dblink, $dbname);
				$name = $_POST['name'];
				$email = $_POST['email'];
				$date = date("Y-m-d");
				$text = $_POST['text'];
				mysqli_query($dblink, "INSERT INTO $table1 (author, text, email, date, post_id) VALUES ('$name', '$text', '$email', '$date', $id)");
				echo '<meta http-equiv="refresh" content="0;URL=?page=post&type=read&id='.$id.'">';
				break;
			case read:
				$sid = $_GET['id'];
				include "admin/config.php";
				$table = 'articles';
				$dblink = mysqli_connect($server, $user, $password);
				mysqli_select_db($dblink, $dbname);
				$sql = mysqli_query($dblink, "SELECT * FROM $table WHERE `id`=$sid");
				while ($row = mysqli_fetch_array($sql)) {
					echo '<article class="post" id="'.$row['id'].'">
					<div class="post-content">
					<h2 class="post-title">'.$row['title'].'</h2><br>
					<p><em>Дата создания: '.$row['date'].'</em></p>';
					echo $row['text'];
					echo '</div><hr>';
					echo '<h2>комментарии</h2>';
					echo '<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="?page=post&type=com&post_id='.$sid.'">';
					echo 'Ваше имя*: <input type="text" name="name" required="required"><br>';
					echo 'Ваш Email*: <input type="text" name="email" required="required"><br>';
					echo 'Сам комментарий*:<br><textarea name="text" rows="20" cols="70" required="required"></textarea><br>';
					echo '<input type="submit" value="Отправить"></form>';
					echo '* - все поля обязательны!<br><hr>';
					$query = mysqli_query($dblink, "SELECT * FROM comments WHERE post_id = $sid ORDER BY id DESC");
					while($data = mysqli_fetch_array($query)) {
					$date = $data['date'];
					$date = date("d.m.Y", strtotime($date));
					echo '<b>'.$data['author'].'</b><br>';
					echo '<em>Дата: '.$date.'</em><br>';
					echo '<p>'.$data['text'].'</p><hr>'; 
					}
				}	
			break;
			default:
				echo '<h2>все статьи.</h2><br>';
				include "admin/config.php";
				$table = 'articles';
				$dblink = mysqli_connect($server, $user, $password);
				mysqli_select_db($dblink, $dbname);
				$sql = mysqli_query($dblink, "SELECT * FROM $table ORDER BY `date` DESC");
				while ($row = mysqli_fetch_array($sql)) {
					echo '<article class="post" id="'.$row['id'].'">
						<div class="post-content">
						<a href="?page=post&type=read&id='.$row['id'].'"><h2 class="post-title">'.$row['title'].'</h2></a>
						<em>Дата создания: '.$row['date'].'</em>
						<p>'.$row['description'].'</p>
						</div>
						<hr>
					</article>';
				}
			break;
			}
		?>	
	</div>
</div>

