<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель: вход</title>
    <link rel="stylesheet" href="/web/admin/css/signin.css">
    <meta name="theme-color" content="#7952b3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
<body class="text-center">
    <main class="form-signin">
        <form method="post" action="/admin/login/check">
            <img src="/web/admin/css/ceblog_logo.png" width="80" height="80" alt="">
            <h1 class="h3 mb-3 fw-normal">Вход в админ-панель</h1>
            <div class="form-floating">
                <input id="floatingInput" type="text" name="login" class="form-control">
                <label for="floatingInput">Логин</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" id="floatingPassword" class="form-control">
                <label for="floatingPassword">Пароль</label>
                <input class="w-100 btn btn-lg btn-primary" type="submit" value="Войти">
                <p class="mt-5 mb-3 text-muted">©CeBlog CMS. 2022-2023</p>
            </div>
        </form>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="/web/admin/js/ajax/login.js"></script>
</body>
</body>
</html>