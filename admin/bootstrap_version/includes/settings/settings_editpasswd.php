<?php
// initialization

include_once('settings.php');
$sid = $_GET['id'];
$squery = $db->admin_id_query($dblink, $sid);
$sdata = mysqli_fetch_array($squery);
$title = $sdata['topic'];
$form_header = '<form method="post" action="?page=settings&mode=editpasswd&id='.$sid.'">';
?>
<div class="container">
    <h1 class="m-2 p-3">Изменение пароля</h1>
    <div class="container">
        <?php echo $form_header; ?>
        <div class="d-flex">
            <div class="flex-fill">
                <label for="usepasswd">Текущий пароль</label>
                <input type="password" required class="form-control" id="usepasswd" name="usepasswd">
            </div>
            <div class="flex-fill">&nbsp;</div>
        </div>
        <div class="d-flex">
            <div class="flex-fill">
                <label for="passwd">Новый пароль</label>
                <input type="password" required class="form-control" name="passwd" id="passwd">
            </div>
            <div class="flex-fill">&nbsp;</div>
        </div>
        <div class="d-flex">
            <div class="flex-fill">
                <label for="passwd_re">Повторите пароль</label>
                <input type="password" required class="form-control" name="passwd_re" id="passwd_re"><br>
            </div>
            <div class="flex-fill">&nbsp;</div>
        </div>
        <div class="d-flex">
            <div class="flex-fill">
                <input type="submit" value="Изменить" class="form-control">
            </div>
            <div class="flex-fill">&nbsp;</div>
            <div class="flex-fill">&nbsp;</div>
        </div>
        </form>
    </div>
</div>