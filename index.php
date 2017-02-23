<?php

session_start();

require_once "vendor/autoload.php";

//PSR
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//SafePal
use \SafePal\SafePal;

//dotenv
$dotenv = new Dotenv\Dotenv(dirname(__FILE__), '.env.php');
$dotenv->load();

//init slim
$app = new \Slim\App;

//DI container
$dicontainer = $app->getContainer();

//Monolog
/*$dicontainer['logger'] = function ($logger){
	$logger = new \Monolog\Logger(getenv('LOGGER'));
	$file = new \Monolog\Handler\StreamHandler(getenv('STREAM_HANDLER'));
	$logger->pushHandler($file);
	return $logger;
};*/

//middleware to handle CSRF
//$app->add(new \Slim\Csrf\Guard);

///ROOT
$app->get('/', function (Request $req, Response $res){
	$res->getBody()->write("SafePal API v1.");
	return $res;
});

//run app
$app->run();

?>