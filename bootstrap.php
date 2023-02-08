<?php
session_start();
// Config, libs
require_once(__DIR__."/web/admin/config.php");
require_once(__DIR__."/libs/db_query.php");
require_once(__DIR__."/libs/show.php");
require_once(__DIR__."/web/routes/routes.php");
// Select theme
$db = new db_query();
$dblink = $db->start($server, $user, $password, $dbname);
$query = $db->getRecord($dblink, 'config', 'name', 'active_theme');
$theme = $query->fetchAll();
$_SESSION['theme'] = $theme;