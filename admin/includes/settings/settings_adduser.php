<?php
// initialization
include_once('settings.php');
if($_GET['type'] == 'edit') {
    $sid = $_GET['id'];
    $squery = $db->admin_id_query($dblink, $sid);
    $sdata = mysqli_fetch_array($squery);
    $userlogin = $sdata['login'];
    $form_header = '<form method="post" action="?page=settings&mode=edit&type=user&id='.$sid.'">';
} else {
    $form_header = '<form method="post" action="?page=settings&mode=add&type=user">';
}
?>
<div class="container">
    <h1 class="m-2 p-3">Добавление пользователя</h1>
    <div class="container">
        <?php echo $form_header; ?>
        <div class="d-flex">
            <div class="flex-fill">
                <label for="login">Имя пользователя</label>
                <input type="text" required class="form-control" value="<?php echo $userlogin; ?>" id="login" name="login">
            </div>
            <div class="flex-fill">&nbsp;</div>
        </div>
        <div class="d-flex">
            <div class="flex-fill">
                <label for="passwd">Пароль</label>
                <input type="password" required class="form-control <?php if ($_GET['type'] == 'edit') { echo 'disabled'; } ?>" <?php if ($_GET['type'] == 'edit') { echo 'disabled'; } ?> name="passwd" id="passwd">
            </div>
            <div class="flex-fill">&nbsp;</div>
        </div>
        <div class="d-flex">
            <div class="flex-fill">
                <label for="passwd_re">Повторите пароль</label>
                <input type="password" required class="form-control <?php if ($_GET['type'] == 'edit') { echo 'disabled'; } ?>" <?php if ($_GET['type'] == 'edit') { echo 'disabled'; } ?> name="passwd_re" id="passwd_re"><br>
            </div>
            <div class="flex-fill">&nbsp;</div>
        </div>
        <div class="d-flex">
            <div class="flex-fill">
                <input type="submit" value="Добавить" class="form-control">
            </div>
            <div class="flex-fill">&nbsp;</div>
            <div class="flex-fill">&nbsp;</div>
        </div>
        </form>
    </div>
</div>