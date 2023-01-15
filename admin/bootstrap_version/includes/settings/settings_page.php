<?php
// initialization
include_once('settings.php');
?>
<style>
    a#site {
        color: #000;
        text-decoration: none;
    }
    a#topics {
        color: #000;
        text-decoration: none;
    }
</style>
<div class="container">
    <h1 class="p-2 m-3">Настройки</h1>
    <div class="d-lg-flex">
        <div class="flex-fill border-end p-2">
        <ul class="nav flex-lg-column">
            <li class="nav-item">
                <a href="#site" class="nav-link">Сайт</a>
            </li>
            <li class="nav-item">
                <a href="#topics" class="nav-link">Разделы</a>
            </li>
            <li class="nav-item">
                <a href="#accounts" class="nav-link">Аккаунты</a>
            </li>
        </ul>
        </div>
        <div class="container flex-fill">
            <h3><a id="site">Сайт</a></h3>
            <em>Скоро в новой версии...</em>
            <h3><a href="#" id="topics">Категории (Топики)</a></h3>
            <a class="btn btn-outline-success m-2" role="button" href="?page=settings&mode=addtopic"><i class="bi bi-plus"></i>Добавить топик</a>
            <div class="container shadow text-center">
                <div class="row m-2 border-bottom">
                    <div class="col col-lg-2 p-2">ID/Поз.</div>
                    <div class="col col-lg-2 p-2">Одностраничный</div>
                    <div class="col p-2">Название</div>
                    <div class="col p-2">Действия</div>
                </div>
                <?php
                $query = $db->topic_query_desc($dblink, 'position', 'ASC');
                while($data = mysqli_fetch_array($query)) {
                    $squery = $db->config_query($dblink);
                    $sdata = mysqli_fetch_array($squery);
                    echo '<div class="row m-2 border-bottom">
                        <div class="col col-lg-2" p-2>'.$data['id'].'/'.$data['position'].'</div>
                        <div class="col col-lg-2 p-2">'.$data['one_page'].'</div>
                        <div class="col p-2">'.$data['topic'].'</div>
                        <div class="col p-2">
                        <a href="?page=settings&mode=addtopic&type=edit&id='.$data['id'].'" role="button" class="btn m-1 btn-outline-primary"><i class="bi bi-pencil-square"></i>Изменить</a> <a href="?page=settings&mode=del&type=topic&id='.$data['id'].'" role="button" class="btn m-1 btn-outline-danger"><i class="bi bi-trash"></i>Удалить</a><br>';
                        if(intval($data['position']) > 0) {
                            echo '<a href="?page=settings&mode=pos&pos='.(intval($data['position'])-1).'&id='.$data['id'].'" role="button" class="btn m-1 btn-outline-primary"><i class="bi bi-arrow-up"></i>Выше</a>';
                            }
                        if(intval($data['position']) < mysqli_num_rows($query)) {
                            echo '<a href="?page=settings&mode=pos&pos='.(intval($data['position'])+1).'&id='.$data['id'].'" role="button" class="btn m-1 btn-outline-primary"><i class="bi bi-arrow-down"></i>Ниже</a>';
                        }
                        if($data['id'] != $sdata['index_tpc']) {
                            echo '<a href="?page=settings&mode=setindx&id='.$data['id'].'" role="button" class="btn m-1 btn-outline-primary"><i class="bi bi-check"></i> Установить на главную</a>';
                        }
                    echo '</div>
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
