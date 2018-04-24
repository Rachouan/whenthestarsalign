<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

session_start();

define('DS',DIRECTORY_SEPARATOR);
define('WWW_ROOT', dirname(__FILE__).DS);
define('BASE_URL', "http://localhost:8888/");

require_once WWW_ROOT . 'classes' .DS. 'Config.php';
require_once WWW_ROOT . 'classes' .DS. 'DatabasePDO.php';
require_once WWW_ROOT . 'includes' .DS. 'routes.php';

if(empty($_GET['page'])){
	$_GET['page'] = 'creator';
}

if(empty($routes[$_GET['page']])){
	header('location:?page=creator');
	exit();
}

$route = $routes[$_GET['page']];
$controllerName = $route['controller'] . 'Controller';

require_once WWW_ROOT . 'controller' .DS. $controllerName . '.php';

$controllerObj = new $controllerName();
$controllerObj->route = $route;
$controllerObj->filter();
$controllerObj->render();
