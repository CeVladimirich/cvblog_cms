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
include 'gen.php';
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
$keyid = random_key();
$content = '<?php
$server = "'.$host.'";
$user = "'.$login_mysql.'";
$password = "'.$pw_mysql.'";
$dbname = "'.$name_mysql.'";
$email = "'.$email.'";
$name = "'.$blog_name.'";
$url = "'.$url.'";
$key = "'.$keyid.'";
?>';
//INSTALLING DATABASE
$dblink = mysqli_connect($host, $login_mysql, $pw_mysql);
if ($_POST['check_db'] == '0') {
mysqli_query($dblink, "CREATE DATABASE $name_mysql");
}
mysqli_select_db($dblink, $name_mysql);
mysqli_query($dblink, "CREATE TABLE articles (id int NOT NULL AUTO_INCREMENT, title text, description text, img text, text text, date date, PRIMARY KEY (id))");
mysqli_query($dblink, "CREATE TABLE admins (id int NOT NULL AUTO_INCREMENT, login text, password text, status int, PRIMARY KEY (id))");
mysqli_query($dblink, "INSERT INTO admins (login, password, status) VALUES ('$admin_login', '$admin_pw', 1)");
mysqli_query($dblink, "CREATE TABLE comments (id int NOT NULL AUTO_INCREMENT, author text, email text, text text, date date, post_id int, PRIMARY KEY (id))");
mysqli_query($dblink, "CREATE TABLE notes (id int NOT NULL AUTO_INCREMENT, title text, date date, text text, PRIMARY KEY(id))");
mysqli_query($dblink, "CREATE TABLE news (id int NOT NULL AUTO_INCREMENT, title text, text text, date date, url text, PRIMARY KEY(id))");
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
echo '<input type="checkbox" value="1" name="check_db"><label>База данных уже создана</label><br />';
echo '<label>Имя БД: </label><input type="text" name="name_mysql"><br />';
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
