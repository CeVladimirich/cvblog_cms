<div class="container">
<?php
echo '<h1 class="p-2 m-3">Здравствуйте, '.htmlspecialchars($_COOKIE['login']).'!</h1>';
?>
<h2 class="h6 p-2">Вот последение изменения на вашем сайте:</h2>
<a class="btn btn-outline-success" role="button" href="?page=articles&mode=addpost"><i class="bi bi-plus"></i>Добавить пост</a>
<div class="row p-2">
    <div class="col-lg p-2 m-1 shadow">
        <h4>Последние комментарии:</h4>
        <?php
            include 'config.php';
            require_once(__DIR__.'/../../libs/db_query.php');
            $db = new db_query();
            $dblink = $db->start($server, $user, $password, $dbname);
            foreach($db->getArray($dblink, "comments", "id", "DESC", "") as $data) {
            $sdata = $db->getRecord($dblink, "posts", "id", $data['post_id'], "", "", "");
            echo $data."< >".$sdata;
            $date = date("d.m.Y", strtotime($data['date']));
            echo '<h5>'.$data['author'].'</h5>';
            echo '<em>К посту: '.$sdata['title'].'. Дата написания: '.$date.'</em>';
            echo '<p>'.$data['text'].'</p>
            <a href="?page=comments&mode=setflag&flag=0&id='.$data['id'].'" role="button" class="btn m-1 btn-outline-danger"><i class="bi bi-eye-slash"></i> Скрыть</a><hr>';
            }
            ?>
    </div>
    <div class="col-lg p-2 m-1 shadow">
        <h4>Последние посты:</h4>
        <?php
            include 'config.php';
            require_once(__DIR__.'/../../libs/db_query.php');
            $dblink = $db->start($server, $user, $password, $dbname);
            $data = $db->getRecord($dblink, "posts",  "topicid", 1, 'date', 'DESC', '10');
            $sdata = $db->getRecord($dblink, "topics", "id", $data['topicid'], "", "", "");
            $date = date("d.m.Y", strtotime($data['date']));
            $desc = base64_decode($data['description']);
            $desc = strip_tags($desc, '<a><em><b><u>');
            echo '<h5><a href="'.$url.'/?page='.$data['topicid'].'&type=read&id='.$data['id'].'">'.$data['title'].'</a></h5>';
            echo '<em>Топик: <a href="?page=articles&topic='.$sdata['id'].'">'.$sdata['topic'].'</a>. 
            Дата создания: '.$date.', автор: '.$data['author'].'</em>';
            echo '<p>'.$desc.'</p>
            <a href="?page=articles&mode=setpf&pf=0&id='.$data['id'].'" role="button" class="btn m-1 btn-outline-danger"><i class="bi bi-eye-slash"></i> Скрыть</a><a href="?page=articles&mode=addpost&type=edit&id='.$data['id'].'" role="button" class="btn m-1 btn-outline-primary"><i class="bi bi-pencil-square"></i>Изменить</a><hr>';
            ?>
    </div>
</div>
<div class="row p-2">
    <div class="col p-2 m-1 shadow">
        <h4>Неопубликованные посты</h4>
        <?php
            include 'config.php';
            require_once(__DIR__.'/../../libs/db_query.php');
            $dblink = $db->start($server, $user, $password, $dbname);
            $data = $db->getRecord($dblink, "posts", "postflag", "2", "", "", "");
            $sdata = $db->getRecord($dblink, "topics", "id", $data['topicid'], "", "", "");
            $date = date("d.m.Y", strtotime($data['date']));
            $desc = base64_decode($data['description']);
            echo '<h5><a href="'.$url.'/?page='.$data['topicid'].'&type=read&id='.$data['id'].'">'.$data['title'].'</a></h5>';
            echo '<em>Топик: <a href="?page=articles&topic='.$sdata['id'].'">'.$sdata['topic'].'</a>. 
            Дата создания: '.$date.', автор: '.$data['author'].'</em>';
            echo '<p>'.$desc.'</p>';
            echo '<a href="?page=articles&mode=addpost&type=edit&id='.$data['id'].'">Редактировать</a> | <a href="#">Опубликовать</a><hr>';

            ?>
    </div>
</div>
</div>
