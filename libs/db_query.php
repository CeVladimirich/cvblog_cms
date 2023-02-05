<?php
/** MySQLi Queries class
 * for CeBlog CMS
 * @author CeVladimirich
 * @version 0.1
 */
class db_query {
    // Connect to database
    function start($server, $user, $password, $dbname) {
        $dsn = "mysql:host=$server;dbname=$dbname;charset=utf8";
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, $user, $password, $opt);
        return $pdo;
    }
    // Return topics
    function topic_query($dblink) {
        $query = mysqli_query($dblink, "SELECT * FROM topics");
        return $query;
    }
    function topic_query_desc($dblink, $pos, $desc) {
        $query = mysqli_query($dblink, "SELECT * FROM topics ORDER BY $pos $desc");
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
    // Return posts on admin
    function posts_query_admin($dblink, $pf, $id, $des, $limit) {
        $query = mysqli_query($dblink, "SELECT * FROM posts WHERE postflag = $pf ORDER BY $id $des LIMIT $limit");
        return $query;
    }
    // Return posts on index
    function posts_query_index($dblink, $topic, $id, $des) {
        $query = mysqli_query($dblink, "SELECT * FROM posts WHERE topicid = $topic AND postflag = 1 ORDER BY $id $des");
        return $query;
    }
    // Return posts on admin (only postflag)
    function posts_query_admin_pf($dblink, $pf, $id, $des) {
        $query = mysqli_query($dblink, "SELECT * FROM posts WHERE postflag = $pf ORDER BY $id $des");
        return $query;
    }
    // Return admins
    function admins_query($dblink) {
        $query = mysqli_query($dblink, "SELECT * FROM admins");
        return $query;
    }
    // Return admin (for adminpanel)
    function admin_query($dblink, $user) {
        $query = mysqli_query($dblink, "SELECT * FROM admins WHERE login = '$user'");
        return $query;
    }
    // Return admin id (for adminpanel)
    function admin_id_query($dblink, $id) {
        $query = mysqli_query($dblink, "SELECT * FROM admins WHERE id = $id");
        return $query;
    }
    // Return comments
    function comments_query($dblink, $id, $des) {
        $query = mysqli_query($dblink, "SELECT * FROM comments ORDER BY $id $des");
        return $query;
    }
    // Return comments (for posts)
    function comments_post_query($dblink, $postid, $id, $des) {
        $query = mysqli_query($dblink, "SELECT * FROM comments WHERE post_id = $postid AND flag = 1 ORDER BY $id $des");
        return $query;
    }
    // Return comments (for admin)
    function comments_admin_query($dblink, $id, $des, $limit, $flag) {
        $query = mysqli_query($dblink, "SELECT * FROM comments WHERE flag = $flag ORDER BY $id $des LIMIT $limit");
        return $query;
    }
    // Return config
    function config_query($dblink) {
        $query = mysqli_query($dblink, "SELECT * FROM config");
        return $query;
    }
}
