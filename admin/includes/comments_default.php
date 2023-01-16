<?php
// initialization
include_once('comments.php')
?>
<div class="container">
    <h1 class="p-2 m-3">Комментарии</h1>
    <div class="row p-2">
        <div class="col shadow p-2 m-1">
            <h4>Последние</h4>
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
                <a href="?page=comments&mode=setflag&flag=0&id='.$data['id'].'" role="button" class="btn m-1 btn-outline-danger"><i class="bi bi-eye-slash"></i> Скрыть</a><hr>';
            }
            ?>
        </div>
        <div class="col shadow p-2 m-1">
            <h4>Удаленные</h4>
            <?php
            include '../config.php';
            include_once('./../../libs/db_query.php');
            $db = new db_query();
            $dblink = $db->start($server, $user, $password, $dbname);
            $query = $db->comments_admin_query($dblink, 'id', 'DESC', 10, 0);
            while($data = mysqli_fetch_array($query)) {
                $text = strip_tags($data['text'], '<br>');
                $squery = $db->post_query($dblink, $data['post_id']);
                $sdata = mysqli_fetch_array($squery);
                $date = date("d.m.Y", strtotime($data['date']));
                echo '<h5>'.$data['author'].'</h5>';
                echo '<em>К посту: '.$sdata['title'].'. Дата написания: '.$date.'</em>';
                echo '<p>'.$text.'</p><br>
                <a href="?page=comments&mode=setflag&flag=1&id='.$data['id'].'" role="button" class="btn m-1 btn-outline-success">Восстановить</a><a href="?page=comments&mode=del&id='.$data['id'].'" role="button" class="btn m-1 btn-outline-danger"><i class="bi bi-trash"></i>Удалить</a><hr>';
            }
            ?>
        </div>
    </div>
</div>