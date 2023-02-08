<?php
require(__DIR__.'/../../vendor/autoload.php');
require_once(__DIR__.'/../../libs/show.php');
// ====EDIT HERE====
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', Show::class."/getindex");
    $r->addRoute('GET', '/pages/{id:\d+}', Show::class.'/get_user_id');
    $r->addRoute('GET', '/admin/', Show::class.'/get_admin_index');
    $r->addRoute(['GET', 'POST'], '/admin/{page:.+}', Show::class.'/get_admin');
    $r->addRoute(['GET', 'POST'], '/admin/{page:.+}/{id:\d+}', Show::class.'/get_admin_id');
});
// ====EDIT HERE====

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        header("404 not found");
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        header("405 not allowed");
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        list($class, $method) = explode("/", $handler, 2);
        call_user_func_array(array(new $class, $method), $vars);
        
        break;
}