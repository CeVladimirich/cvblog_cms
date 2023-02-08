<?php
class Show {
    // Gets all from web/routes/routes.php
    function get($name) {
        require(__DIR__.'/../web/themes/'.$_SESSION['theme'].'/'.$name.'.php');
    }
    function get_user_id($id) {
        require(__DIR__.'/../web/themes/'.$_SESSION['theme'].'/page.php?id='.$id);
    }
    function getindex() {
        $key = key($_SESSION['theme']);
        require(__DIR__.'/../web/themes/'.$key.'/index.php'); 
    }
    function get_admin($page) {
        $json = file_get_contents(__DIR__.'/../web/admin/routes.json');
        $json = json_decode($json, true);
        if ($page == "login" || $page == "login/check") {
            require(__DIR__."/../web/admin/".$json[$page]["file"]);
        } else {
            $this->show_page_admin($json[$page]["file"]);
        }
    }
    function get_admin_index() {
        $this->show_page_admin("body.php");
    }
    private function show_page_admin($page) {
        require(__DIR__."/../web/admin/bootstrap.php");
        require(__DIR__."/../web/admin/".$page);
        require(__DIR__."/../web/admin/includes/footer.php");
    }
}