<!DOCTYPE html>
<html>
<head>
<title>Установка Cevladimirich's Blog CMS</title>
<meta charset="utf-8">
</head>
<body>
<?php
$steps = $_GET['step'];
switch($steps) {
case step3:
echo '<b>Установка успешно завершена!</b><br />';
echo 'Теперь вы можете взглянуть, что получилось, <a href="../index.php">здесь.</a> Также зайдите в <a href="../admin">/admin</a> для создания первого поста.<br />';
echo 'Удалите этот файл, а <em>config.php</em> перенесите в корневой каталог и в /admin.<br />';
echo 'Спасибо за использование CVBlog CMS!';
break;
case step2:
echo 'Подождите...';
$blog_name = $_POST['blog_name'];
$login_mysql = $_POST['login_mysql'];
$pw_mysql = $_POST['pw_mysql'];
$name_mysql = $_POST['name_mysql'];
$admin_login = $_POST['admin_login'];
$admin_pw = $_POST['admin_pw'];
$url = $_POST['blog_url'];
$admin_login = htmlspecialchars(stripslashes($admin_login));
$admin_pw = htmlspecialchars(stripslashes($admin_pw));
$admin_login = trim($admin_login);
$admin_pw = md5($admin_pw);
$email = $_POST['email'];
$host = $_POST['host_mysql'];
$date = date('Y-m-d');
$content = '<?php
$server = "'.$host.'";
$user = "'.$login_mysql.'";
$password = "'.$pw_mysql.'";
$dbname = "'.$name_mysql.'";
$email = "'.$email.'";
$name = "'.$blog_name.'";
$url = "'.$url.'";
?>';
//INSTALLING DATABASE
$dblink = mysqli_connect($host, $login_mysql, $pw_mysql);
mysqli_query($dblink, "CREATE DATABASE $name_mysql");
mysqli_select_db($dblink, $name_mysql);
mysqli_query($dblink, "CREATE TABLE posts (id int NOT NULL AUTO_INCREMENT, date timestamp, topicid int, postflag int default 2, title text, post text, img text, url text, PRIMARY KEY(id))");
mysqli_query($dblink, "CREATE TABLE topics (id int NOT NULL AUTO_INCREMENT, topic text, position int, PRIMARY KEY (id))");
mysqli_query($dblink, "CREATE TABLE comments (id int NOT NULL AUTO_INCREMENT, date timestamp, post_id int, flag int default 1, author text, text text, PRIMARY KEY(id))")
//CREATING CONFIG
$fo = fopen('config.php', 'a');
fwrite($fo, $content);
fclose($fo);
echo '<meta http-equiv="refresh" content="2;URL=?step=step3">';
break;
case step1:
echo '<b>Установка</b>';
echo '<form method="post" action="?step=step2">';
echo '<label><b>База данных MySQL</b></label><br />';
echo '<label>Логин БД: </label><input type="text" name="login_mysql"><br />';
echo '<label>Пароль БД: </label><input type="password" name="pw_mysql"><br />';
echo '<label>Сервер БД (по умолчанию localhost): </label><input type="text" name="host_mysql"><br />';
echo '<label>Имя новой БД: </label><input type="text" name="name_mysql"><br />';
echo '<label><b>Админка</b></label><br />';
echo '<label>Ссылка на сайт: </label><input type="text" name="blog_url"><br />';
echo '<label>Название сайта: </label><input type="text" name="blog_name"><br />';
echo '<label>Логин: </label><input type="text" name="admin_login"><br />';
echo '<label>Пароль: </label><input type="password" name="admin_pw"><br />';
echo '<label>Email для связи с вами: </label><input type="text" name="email"><br />';
echo '<label>Если вы считаете, что все готово, нажимайте кнопку "Установить".<br />УСТАНОВИТЕ ЭТОМУ ФАЙЛУ И <em>CONFIG.PHP</em> ПРАВА 777!!!</label><br />';
echo '<input type="submit" value="Установить">';
break;
default:
echo '<h1>Добро пожаловать в установку!</h1>';
echo '<p>Это - установщик CMS для вашего блога. Даже не CMS, базы для разработки и доработки. <b>В него входит:</b>';
echo '<ul><li>Добавление, редактирование и удаление постов</li>';
echo '<li>Добавление, редактирование и удаление заметок (или кратких постов, как захотите назвать)</li>';
echo '<li>Добавление, редактирование и удаление новостей блога (НЕ ВКЛЮЧАЕТ RSS КАНАЛ)</li></ul>';
echo '<p>Для установки потребуется:</p>';
echo '<ol><li>Логин и пароль от базы даннных <b>MySQL</b></li>';
echo '<li>Придумать логин и пароль для админки</li>';
echo '<li><font color="red">Изменить права доступа <b>config.php</b> и <b>этого файла</b> на 777!</font></li></ol>';
echo '<p>Для продолжения нажмите на ссылку ниже</p>';
echo '<p align="right"><a href="?step=step1">Начать ></a></p>';
}
?>
<hr>
By CeVladimirich, 2022.
</body>
</html>
