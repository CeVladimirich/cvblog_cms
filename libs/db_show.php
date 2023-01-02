<?php
/** MySQLi Show class
 * for CeBlog CMS
 * @author CeVladimirich
 * @version 0.1
 */
class db_show {
    // Show posts in index
    function show_posts_desc($query) {
        while($data = mysqli_fetch_array($query)) {
            $desc = base64_decode($data['description']);
            echo '<article class="post" id="'.$data['id'].'">';
            echo '<div class="post-content">';
            echo '<h2 class="post-title"><a href="?page=post&type=read&id='.$data['id'].'">'.$data['title'].'</h2>';
            echo '<p><em>Дата создания: '.$data['date'].'</em></p>';
            echo '<p>'.$desc.'</p></a>';
            echo '</div></article><hr>';
        }
        return $data;
    }
}