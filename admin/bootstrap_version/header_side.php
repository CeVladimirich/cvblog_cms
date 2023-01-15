<nav class="navbar navbar-expand-lg bg-dark shadow sticky-top bg-dark flex-md-nowrap p-0">
    <div class="container-fluid">
    <a href="index.php" class="navbar-brand" style="color: #FFF; background-color: #212529; font-size: 17px;">
    <img src="./../../css/ceblog_logo.png" alt="" width="32" height="32" class="d-inline-block align-text-block">
    Админ-панель
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Переключатель">
        <i style="color: #FFF;" class="bi bi-list"></i>
    </button><div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav me-auto mb-2 mb-lg-0">
<li class="nav-item dropdown">
<a href="#" style="color: #FFF; text-decoration: none;" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
Публикации
</a>
<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
<?php
include '../config.php';
include '/libs/db_query.php';
$db = new db_query();
$dblink = $db->start($server, $user, $password, $dbname);
$query = $db->topic_query($dblink);
while($data = mysqli_fetch_array($query)) {
    echo '<li><a href="?page=articles&topic='.$data['id'].'" class="dropdown-item">'.$data['topic'].'</a></li>';
}
?>
<li><hr class="dropdown-divider"></li>
<li><a href="?page=settings#topics" class="dropdown-item">Изменить</a></li>
</ul>
</li>
<li class="nav-item">
    <a href="?page=comments" class="nav-link" style="color: #FFF; text-decoration: none; ">Комментарии</a>
</li>
</ul>
<ul class="navbar-nav mb-2 mb-lg-0">
<li class="nav-item">
<a href="?page=settings" style="color: #fff; text-decoration: none;">Настройки</a>
</li>
<li class="nav-item">
<a href="login.php?mode=logout" style="color: #fff; text-decoration: none;">&nbsp;Выход</a>
</li>
</ul>
</div>
    </div>
</nav>