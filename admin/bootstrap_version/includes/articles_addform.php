<?php
//initialization
include_once('./articles.php');
if($_GET['type'] == 'edit') {
    $sid = $_GET['id'];
    $squery = $db->post_query($dblink, $sid);
    $sdata = mysqli_fetch_array($squery);
    $title = $sdata['title'];
    $desc = base64_decode($sdata['description']);
    $desc = strip_tags($desc, "<a><b><h1><h2><h3><p><left><center><u><i><font>");
    $text = base64_decode($sdata['post']);
    $post = strip_tags($text, "<a><b><h1><h2><h3><p><left><center><u><i><font>");
    $date = $sdata['date'];
    $date = date("Y-m-d", strtotime($date));
    $form_header = '<form method="post" action="?page=articles&mode=edit&id='.$sid.'">';
} else {
    $form_header = '<form method="post" action="?page=articles&mode=add">';
}
?>
<div class="container">
    <h1 class="p-2 m-2">
        Добавление поста
    </h1>
    <div class="container">
        <?php echo $form_header; ?>
            <div class="row">
                <div class="col-lg">
                    <label for="namePost">Название поста*</label>
                    <input type="text" required class="form-control" id="namePost" value="<?php echo $title; ?>" name="namePost">
                </div>
                <?php
                if ($_GET['type'] == 'edit') {
                    ?>
                    <div class="col-lg">
                    <label for="selectPost">Категория поста*</label>
                    <select class="form-select Disabled" disabled required id="selectPost" name="selectPost">
                        <option value="установлено ранее.."></option>
                    </select>
                </div>
                    <?php
                } else {
                    ?>
                <div class="col-lg">
                    <label for="selectPost">Категория поста*</label>
                    <select class="form-select" required id="selectPost"name="selectPost">
                        <?php
                        while($sdata = mysqli_fetch_array($squery)) {
                            echo '<option value="'.$sdata['id'].'">'.$sdata['topic'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <?php
                    }
                ?>
                <div class="col-lg">
                    <label for="datePost">Дата публикации*</label>
                    <input type="date" class="form-control" required id="datePost" value="<?php echo $date; ?>" name="datePost">
                </div>
            </div>
            <div class="row p-2">
                <div class="col">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#" onclick="showEdit()" id="editbutton" class="nav-link active">Редактирование</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" onclick="showPreview()" id="previewbutton" class="nav-link">Показ</a>
                        </li>
                    </ul>
                    <div class="container showEdit">
                    <div class="btn-toolbar p-2" role="toolbar" aria-label="">
                        <div class="btn-group p-2" role="group" alia-label="">
                            <button type="button" onclick="addBoldText()" class="btn btn-light"><i class="bi bi-type-bold"></i></button>
                            <button type="button" onclick="addUnderline()" class="btn btn-light"><i class="bi bi-type-underline"></i></button>
                            <button type="button" onclick="addItalic()" value="<i></i>" class="btn btn-light"><i class="bi bi-type-italic"></i></button>
                            <button type="button" onclick="addLink()" class="btn btn-light"><i class="bi bi-link-45deg"></i></button>
                        </div>
                        <div class="btn-group p-2" role="group" alia-label="">
                            <button type="button" onclick="addH1()" class="btn btn-light"><i class="bi bi-type-h1"></i></button>
                            <button type="button" onclick="addH2()" class="btn btn-light"><i class="bi bi-type-h2"></i></button>
                            <button type="button" onclick="addH3()" class="btn btn-light"><i class="bi bi-type-h3"></i></button>
                        </div>
                        <div class="btn-group p-2" role="group" alia-label="">
                            <button type="button" onclick="addRed()" class="btn btn-danger"><i class="bi bi-palette"></i></button>
                            <button type="button" onclick="addBlue()" class="btn btn-primary"><i class="bi bi-palette"></i></button>
                            <button type="button" onclick="addGreen()" class="btn btn-success"><i class="bi bi-palette"></i></button>
                            <button type="button" onclick="addYellow()" class="btn btn-warning"><i class="bi bi-palette"></i></button>
                        </div>
                        <div class="btn-group p-2" role="group" alia-label="">
                            <button type="button" onclick="addLeft()" class="btn btn-light"><i class="bi bi-text-left"></i></button>
                            <button type="button" onclick="addCenter()" class="btn btn-light"><i class="bi bi-text-center"></i></button>
                            <button type="button" onclick="addRight()" class="btn btn-light"><i class="bi bi-text-right"></i></button>
                        </div>
                    </div>
                    <textarea name="articlePost" id="articlePost" class="form-control" rows="20"><?php echo $post; ?></textarea>
                    <label for="descPost" class="m-2">Описание к посту*</label>
                    <textarea name="descPost" id="descPost" required class="form-control" rows="10"><?php echo $desc; ?></textarea>
                   <i>* - обязательно к заполнению</i>
                    <div class="row p-2">
                        <div class="col"><input type="submit" class="form-control m-2" value="Добавить"></div>
                        <div class="col">&nbsp;</div>
                        <div class="col">&nbsp;</div>
                        <div class="col">&nbsp;</div>
                        <div class="col">&nbsp;</div>
                    </div>
                    </div>
                    <div class="container showPreview" hidden></div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var author = '<?php echo $_SESSION['login']; ?>';
    function showEdit() {
    document.querySelector('.showEdit').hidden = false;
    document.querySelector('.showPreview').hidden = true;
    document.querySelector('#previewbutton').classList.remove('active');
    document.querySelector('#editbutton').classList.add('active');
}
function showPreview() {
    // input values
    var title = document.querySelector('#namePost').value;
    var category = document.querySelector('#selectPost').value;
    var date = document.querySelector('#datePost').value;
    var article = document.querySelector('#articlePost').value;
    article=article.replace(/\r\n|\r|\n/g,"<br>")
    // show preview & add values
    document.querySelector('.showEdit').hidden = true;
    document.querySelector('.showPreview').hidden = false;
    document.querySelector('.showPreview').innerHTML = '<h1>'+ title + '</h1><br><em>Автор поста: '+ author +'</em><br><em>Дата создания: '+ date + '</em><br>' + article;
    //buttons
    document.querySelector('#editbutton').classList.remove('active');
    document.querySelector('#previewbutton').classList.add('active');
}

</script>
<script src="article.js"></script>