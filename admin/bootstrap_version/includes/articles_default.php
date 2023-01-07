<?php
// initialization
include_once('./articles.php');
$tpc = $_GET['topic']; 
?>
<div class="container">
    <h1 class="p-2 m-3">Посты в топике "<?php echo $sdata['topic']; ?>"</h1>
    <a href="?page=articles&mode=addpost" role="button" class="btn btn-outline-success m-2"><i class="bi bi-plus"></i>Добавить пост</a>
    <div class="row">
        <div class="col">
            Название
        </div>
        <div class="col-6">
            Описание
        </div>
        <div class="col">
            Действия
        </div>
    </div><hr>
    <h5>Черновики</h5><hr>
    <?php
    while($data = mysqli_fetch_array($query_2)) {
        $desc = base64_decode($data['description']);
        $desc = strip_tags($desc, '<a><em><b><u>');
        echo '<div class="row">
        <div class="col">'.$data['title'].'</div>
        <div class="col-6">'.$desc.'</div>
        <div class="col">
            <a href="?page=articles&mode=addpost&type=edit&id='.$data['id'].'" role="button" class="btn m-1 btn-outline-primary"><i class="bi bi-pencil-square"></i>Изменить</a><br>
            <a href="?page=articles&mode=setpf&pf=1&id='.$data['id'].'&from_tpc='.$tpc.'" role="button" class="btn m-1 btn-outline-success">Опубликовать</a><br>
            <a href="?page=articles&mode=setpf&pf=0&id='.$data['id'].'&from_tpc='.$tpc.'" role="button" class="btn m-1 btn-outline-danger">Удалить</a>
        </div>
        </div><hr>';
    }
    ?>
    <h5>Опубликованные</h5><hr>
    <?php
    while($data = mysqli_fetch_array($query_1)) {
        $desc = base64_decode($data['description']);
        $desc = strip_tags($desc, '<a><em><b><u>');
        echo '<div class="row">
        <div class="col">'.$data['title'].'</div>
        <div class="col-6">'.$desc.'</div>
        <div class="col">
            <a href="?page=articles&mode=addpost&type=edit&id='.$data['id'].'" role="button" class="btn m-1 btn-outline-primary"><i class="bi bi-pencil-square"></i> Изменить</a><br>
            <a href="?page=articles&mode=setpf&pf=0&id='.$data['id'].'&from_tpc='.$tpc.'" role="button" class="btn m-1 btn-outline-danger">Удалить</a>
        </div>
        </div><hr>';
    }
    ?>
    <h5>Подлежащие удалению</h5><hr>
    <?php
    while($data = mysqli_fetch_array($query_0)) {
        $desc = base64_decode($data['description']);
        $desc = strip_tags($desc, '<a><em><b><u>');
        echo '<div class="row">
        <div class="col">'.$data['title'].'</div>
        <div class="col-6">'.$desc.'</div>
        <div class="col">
            <a href="?page=articles&mode=addpost&type=edit&id='.$data['id'].'" role="button" class="btn m-1 btn-outline-primary"><i class="bi bi-pencil-square"></i> Изменить</a><br>
            <a href="?page=articles&mode=setpf&pf=1&id='.$data['id'].'&from_tpc='.$tpc.'" role="button" class="btn m-1 btn-outline-success">Восстановить</a><br>
            <a href="#" role="button" class="btn m-1 btn-outline-danger">Удалить</a>
        </div>
        </div><hr>';
    }
    ?>
</div>