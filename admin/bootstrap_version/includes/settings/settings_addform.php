<?php
// initialization

include_once('settings.php');
if($_GET['type'] == 'edit') {
    $sid = $_GET['id'];
    $squery = $db->topic_query($dblink);
    $sdata = mysqli_fetch_array($squery);
    $title = $sdata['topic'];
    $form_header = '<form method="post" action="?page=settings&mode=edit&type=topic&id='.$sid.'">';
} else {
    $form_header = '<form method="post" action="?page=settings&mode=add&type=topic">';
}
?>
<div class="container">
    <h1 class="m-2 p-3">Добавление топика</h1>
    <div class="container">
        <?php echo $form_header; ?>
        <div class="row">
        <div class="col-lg">
                <div class="mb-3">
                    <label for="namePost">Название топика</label>
                    <input type="text" required class="form-control" id="namePost" value="<?php echo $title; ?>" name="namePost">
                </div>
                Тип раздела: <i data-bs-toggle="tooltip" data-bs-title="После добавления раздела (при выборе одностраничного) вы будете переброшены на страницу создания постов. Выберите только что созданый топик." class="bi bi-question-circle"></i>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="onepage" value="0" id="flexRadioDefault1" checked>
                <label class="form-check-label" for="flexRadioDefault1">
                    Многостраничный
                </label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="onepage" value="1" id="flexRadioDefault2">
                <label class="form-check-label" for="flexRadioDefault2">
                    Одностраничный
                </label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="setindex" role="switch" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Установить на главную</label>
                </div>
            </div>
            <div class="col-lg">&nbsp;&nbsp;&nbsp;&nbsp;</div>
        </div>
        <div class="row">
            <div class="col-lg">
                <input type="submit" value="Добавить" class="form-control">
            </div>
            <div class="col-lg">
            &nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-lg">
            &nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-lg">
            &nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-lg">
            &nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-lg">
            &nbsp;&nbsp;&nbsp;&nbsp;
            </div>
        </div>
        </form>
    </div>
</div>