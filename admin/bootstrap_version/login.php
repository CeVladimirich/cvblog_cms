<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель: вход</title>
    <link rel="stylesheet" href="../../css/signin.css">
    <meta name="theme-color" content="#7952b3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<?php
session_start();
include "../config.php";
include "../../libs/db_query.php";
$db = new db_query();
$mode = $_GET['mode'];
$dblink = $db->start($server, $user, $password, $dbname);
switch($mode) {
    case login:
        $ruser = $_POST['login'];
        $pw = $_POST['password'];
        $ruser = htmlspecialchars(stripslashes($ruser));
        $pw = htmlspecialchars(stripslashes($pw));
        $ruser = trim($ruser);
        $pw = md5($pw);
        $query = $db->admins_query($dblink);
        while($data = mysqli_fetch_array($query)) {
            $login = $data['login'];
            $passwd = $data['password'];
            if ($login == $ruser and $passwd == $pw) {
        
            $key = 'CE'.$key.$_SERVER["REMOTE_ADDR"];
            $key1 = md5($key);
        
            $_SESSION['devid'] = $key1;
            $_SESSION['login'] = $login;	
        
            echo '<meta http-equiv="refresh" content="0;URL=login.php">';
            exit(0);
            }
        }
        echo 'логин и пароль неправильные! попробуйте еще раз...';
        echo '<meta http-equiv="refresh" content="4;URL=login.php">';
        break;
    case logout:
            unset($_SESSION['devid']);
            session_destroy();
            
            echo '<meta http-equiv="refresh" content="0;URL=login.php">';
            
            break;
    default:
    $key = 'CE'.$key.$_SERVER["REMOTE_ADDR"];
    $key = md5($key);
    if ($_SESSION['devid'] == $key) {
        echo '<meta http-equiv="refresh" content="0;URL=index.php">';
    } else { 
        ?>
            <body class="text-center">
                <main class="form-signin">
                    <form method="post" action="?mode=login">
                        <img src="./../../css/ceblog_logo.png" width="80" height="80" alt="">
                        <h1 class="h3 mb-3 fw-normal">Вход в админ-панель</h1>
                        <div class="form-floating">
                            <input id="floatingInput" type="text" name="login" class="form-control">
                            <label for="floatingInput">Логин</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" name="password" id="floatingPassword" class="form-control">
                            <label for="floatingPassword">Пароль</label>
                            <button class="w-100 btn btn-lg btn-primary" type="submit">Войти</button>
                            <p class="mt-5 mb-3 text-muted">CeBlog CMS. 2022-2023</p>
                        </div>
                    </form>
                </main>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
            </body>
    <?php
    }
}
?>
</html>