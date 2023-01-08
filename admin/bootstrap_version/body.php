<div class="container">
<?php
echo '<h1 class="p-2 m-3">Здравствуйте, '.$_SESSION['login'].'!</h1>';
?>
<h2 class="h6 p-2">Вот последение изменения на вашем сайте:</h2>
<a class="btn btn-outline-success" role="button" href="?page=articles&mode=addpost"><i class="bi bi-plus"></i>Добавить пост</a>
<div class="row p-2">
    <div class="col p-2 m-1 shadow">
        <h4>Последние комментарии:</h4>
        <?php
            include '../config.php';
            include_once('./../../libs/db_query.php');
            $db = new db_query();
            $dblink = $db->start($server, $user, $password, $dbname);
            $query = $db->comments_admin_query($dblink, 'id', 'DESC', 10, 1);
            while($data = mysqli_fetch_array($query)) {
                $squery = $db->post_query($dblink, $data['post_id']);
                $sdata = mysqli_fetch_array($squery);
                $date = date("d.m.Y", strtotime($data['date']));
                echo '<h5>'.$data['author'].'</h5>';
                echo '<em>К посту: '.$sdata['title'].'. Дата написания: '.$date.'</em>';
                echo '<p>'.$data['text'].'</p>
                <a href="?page=comments&mode=setflag&flag=0&id='.$data['id'].'" role="button" class="btn m-1 btn-outline-danger"><i class="bi bi-trash"></i>Удалить</a><hr>';
            }
            ?>
    </div>
    <div class="col p-2 m-1 shadow">
        <h4>Последние посты:</h4>
        <?php
            include '../config.php';
            include_once '../../libs/db_query.php';
            $dblink = $db->start($server, $user, $password, $dbname);
            $query = $db->posts_query_admin($dblink, 1, 'date', 'DESC', 10);
            while($data = mysqli_fetch_array($query)) {
                $squery = $db->topic_query_pages($dblink, $data['topicid']);
                $sdata = mysqli_fetch_array($squery);
                $date = date("d.m.Y", strtotime($data['date']));
                $desc = base64_decode($data['description']);
                $desc = strip_tags($desc, '<a><em><b><u>');
                echo '<h5><a href="'.$url.'/?page='.$data['topicid'].'&type=read&id='.$data['id'].'">'.$data['title'].'</a></h5>';
                echo '<em>Топик: <a href="?page=articles&topic='.$sdata['id'].'">'.$sdata['topic'].'</a>. 
                Дата создания: '.$date.', автор: '.$data['author'].'</em>';
                echo '<p>'.$desc.'</p>
                <a href="?page=articles&mode=setpf&pf=0&id='.$data['id'].'" role="button" class="btn m-1 btn-outline-danger"><i class="bi bi-eye-slash"></i> Скрыть</a><a href="?page=articles&mode=addpost&type=edit&id='.$data['id'].'" role="button" class="btn m-1 btn-outline-primary"><i class="bi bi-pencil-square"></i>Изменить</a><hr>';
            }
            ?>
    </div>
</div>
<div class="row p-2">
    <div class="col p-2 m-1 shadow">
        <h4>Неопубликованные посты</h4>
        <?php
            include '../config.php';
            include_once '../../libs/db_query.php';
            $dblink = $db->start($server, $user, $password, $dbname);
            $query = $db->posts_query_admin_pf($dblink, 0, 'date', 'DESC');
            while($data = mysqli_fetch_array($query)) {
                $squery = $db->topic_query_pages($dblink, $data['topicid']);
                $sdata = mysqli_fetch_array($squery);
                $date = date("d.m.Y", strtotime($data['date']));
                $desc = base64_decode($data['description']);
                echo '<h5><a href="'.$url.'/?page='.$data['topicid'].'&type=read&id='.$data['id'].'">'.$data['title'].'</a></h5>';
                echo '<em>Топик: <a href="?page=articles&topic='.$sdata['id'].'">'.$sdata['topic'].'</a>. 
                Дата создания: '.$date.', автор: '.$data['author'].'</em>';
                echo '<p>'.$desc.'</p>';
                echo '<a href="?page=articles&mode=addpost&type=edit&id='.$data['id'].'">Редактировать</a> | <a href="#">Опубликовать</a>';
            }
            ?>
    </div>
</div>
</div>