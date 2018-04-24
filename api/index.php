<?php
header('Access-Control-Allow-Origin: *');

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('DS',DIRECTORY_SEPARATOR);
define("WWW_ROOT",dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);


require_once WWW_ROOT . 'classes' .DS. 'Config.php';
require_once WWW_ROOT . 'classes' .DS. 'DatabasePDO.php';

require_once WWW_ROOT. "dao" .DIRECTORY_SEPARATOR. 'PlacesDAO.php';
require_once WWW_ROOT. "dao" .DIRECTORY_SEPARATOR. 'CategoryDAO.php';

require_once WWW_ROOT. "api" .DIRECTORY_SEPARATOR. 'Slim'. DIRECTORY_SEPARATOR .'Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$placesDAO = new PlacesDAO();
$categoryDAO = new CategoryDAO();


//locaties ophalen via search query

$app->get("/places/?", function() use ($app, $placesDAO){

	header("Content-Type:application/json");
	$post = $app->request->post();
	if(empty($post)){
		$post = (array) json_decode($app->request()->getBody());
	}

	echo json_encode($placesDAO->getPlaces());

	exit();

});

$app->get("/categories/?", function() use ($app, $categoryDAO){

	header("Content-Type:application/json");

	$lang = $app->request()->params("lang");

	echo json_encode($categoryDAO->getCategories($lang));

	exit();

});

$app->get("/place/?", function() use ($app, $placesDAO){

	header("Content-Type:application/json");
	$placeid = $app->request()->params("id");
	$lang = $app->request()->params("lang");

	echo json_encode($placesDAO->getPlaceById($placeid,$lang));

	exit();

});

//locaties ophalen via search query

$app->get("/places/filters/?", function() use ($app, $placesDAO){

	header("Content-Type:application/json");

  $name = $app->request()->params("name");
	$category = $app->request()->params("category");
	$lang = $app->request()->params("lang");

  $places = $placesDAO->getPlacesByFilter($name,$category,$lang);


	echo json_encode($places);

	exit();

});

$app->run();
