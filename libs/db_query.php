<?php
/** MySQLi Queries class
 * for CeBlog CMS
 * @author CeVladimirich
 * @version 0.1
 */
class db_query {
    // Connect to database
    function start($server, $user, $password, $dbname) {
        $dblink = mysqli_connect($server, $user, $password);
        mysqli_select_db($dblink, $dbname);
        mysqli_query($dblink, "SET NAMES 'utf8'");
        return $dblink;
    }
    // Return topics
    function topic_query($dblink) {
        $query = mysqli_query($dblink, "SELECT * FROM topics");
        return $query;
    }
    // Return topics on page
    function topic_query_pages($dblink, $id) {
        $query = mysqli_query($dblink, "SELECT * FROM topics WHERE id = $id");
        return $query;
    }
    // Return post
    function post_query($dblink, $id) {
        $query = mysqli_query($dblink, "SELECT * FROM posts WHERE id = $id");
        return $query;
    }
    // Return posts on page
    function posts_query_list($dblink, $topic, $pf, $id, $des) {
        $query = mysqli_query($dblink, "SELECT * FROM posts WHERE topicid = $topic AND postflag = $pf ORDER BY $id $des");
        return $query;
    }
    // Return posts on index
    function posts_query_index($dblink, $topic, $id, $des) {
        $query = mysqli_query($dblink, "SELECT * FROM posts WHERE topicid = $topic ORDER BY $id $des");
        return $query;
    }
    // Return admins
    function admins_query($dblink) {
        $query = mysqli_query($dblink, "SELECT * FROM admins");
        return $query;
    }
    // Return comments
    function comments_query($dblink, $id, $des) {
        $query = mysqli_query($dblink, "SELECT * FROM comments ORDER BY $id $des");
        return $query;
    }
    // Return comments (for posts)
    function comments_post_query($dblink, $postid, $id, $des) {
        $query = mysqli_query($dblink, "SELECT * FROM comments WHERE post_id = $postid ORDER BY $id $des");
        return $query;
    }
    // Return config
    function config_query($dblink) {
        $query = mysqli_query($dblink, "SELECT * FROM config");
        return $query;
    }
}