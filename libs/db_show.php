<?php
/** MySQLi Show class
 * for CeBlog CMS
 * @author CeVladimirich
 * @version 0.1
 */
class db_show {
    // Show posts in index
    function show_posts_desc($query, $topicid) {
        while($data = mysqli_fetch_array($query)) {
            $desc = base64_decode($data['description']);
            echo '<article class="post" id="'.$data['id'].'">';
            echo '<div class="post-content">';
            echo '<h2 class="post-title"><a href="?page='.$topicid.'&type=read&id='.$data['id'].'">'.$data['title'].'</h2>';
            echo '<p><em>Дата создания: '.$data['date'].'</em></p>';
            echo '<p>'.$desc.'</p></a>';
            echo '</div></article><hr>';
        }
        return $data;
    }
    // Show topics
    function show_topics($query) {
        while($data = mysqli_fetch_array($query)) {
            echo '<li><a href="?page='.$data['id'].'">'.$data['topic'].'</a></li> ';
        }
        return $data;
    }
    function show_footer() {
        echo '<footer>';
        echo '<div class="container">';
        echo "<div class='footer-col'><span>Powered on Cevladimirich's Blog CMS<br>By CeVladimirich, 2022</span></div>";
        echo '<div class="footer-col" align="right"><span><a href="mailto:'.include "admin/config.php"; echo $email.'">написать письмо</a></span></div>';
        echo '</div></footer>';
    }
    // Show article
    function show_article($query) {
        while($data = mysqli_fetch_array($query)) {
            $post = base64_decode($data['post']);
            $date = date("d.m.Y", strtotime($data['date']));
            echo '<article class="post" id="'.$data['id'].'">';
            echo '<div class="post-content">';
            echo '<h2 class="post-title">'.$data['title'].'</h2>';
            echo '<b><em>Автор: '.$data['author'].'</em></b><br>';
            echo '<em>Дата создания: '.$date.'</em><br>';
            echo $post;
            echo '</div></article>';
        }
        return $data;
    }
    // Show article (without author and date)
    function show_one_page($query) {
        while($data = mysqli_fetch_array($query)) {
            $post = base64_decode($data['post']);
            echo '<article class="post" id="'.$data['id'].'">';
            echo '<div class="post-content">';
            echo $post;
            echo '</div></article>';
        }
        return $data;
    }
    // Show input comment
    function show_input_comment($page, $id) {
        echo '<h2>комментарии</h2>';
        echo '<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="?page='.$page.'&type=com&post_id='.$id.'">';
        echo 'Ваше имя*: <input type="text" name="name" required="required"><br>';
        echo 'Сам комментарий*:<br><textarea name="text" rows="20" cols="70" required="required"></textarea><br>';
        echo '<input type="submit" value="Отправить"></form>';
        echo '* - все поля обязательны!';
    }
    // Show comments
    function show_comments($query) {
        while($data = mysqli_fetch_array($query)) {
            $date = $data['date'];
            $date = date("d.m.Y", strtotime($date));
            echo '<b>'.$data['author'].'</b><br>';
            echo '<em>Дата: '.$date.'</em><br>';
            echo '<p>'.$data['text'].'</p><hr>'; 
            echo '</article>';
        }
        return $data;
    }
    // Show admin container on index
    function show_admin() {
        echo '<div class="admin" style="background-color: #000; color:#FFF; padding: 5px;">
        Здравствуйте, '.$_SESSION['login'].'. <a style="color: #fff; text-decoration: none;" href="/admin/bootstrap_version">Перейти в админ-панель</a> | <a href="/admin/bootstrap_version/?page=articles&mode=addpost" style="color: #fff; text-decoration: none;">Добавить пост</a> | <a href="/admin/bootstrap_version/login.php?mode=logout" style="color: #fff; text-decoration: none;">Выйти</a>
        </div>';
    }
}