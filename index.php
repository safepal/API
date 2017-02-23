<?php

//session_start();

require_once "vendor/autoload.php";

//PSR
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//SafePal
//use \SafePal\SafePal;

//dotenv
$dotenv = new Dotenv\Dotenv(dirname(__FILE__), '.env.php');
$dotenv->load();

//init slim
$app = new \Slim\App;

//DI container
$dicontainer = $app->getContainer();

//Monolog
$dicontainer['logger'] = function ($logger){
	$logger = new \Monolog\Logger(getenv('LOGGER'));
	$file = new \Monolog\Handler\StreamHandler(getenv('STREAM_HANDLER'));
	$logger->pushHandler($file);
	return $logger;
};

//middleware to handle CSRF
//$app->add(new \Slim\Csrf\Guard);

///ROOT
$app->get('/', function (Request $req, Response $res){
	$res->getBody()->write("SafePal API v1.5");
	return $res;
});

$app->post('/test', function (Request $req, Response $res){

	/*if (empty($req->getParsedBody())) {
		throw new InvalidArgumentException("Empty request");
	} */

	/*$data = json_decode($req->getParsedBody());

	$pd = new PDO("mysql:host=".getenv('HOST').";dbname=".getenv('DB').",".getenv('DBUSER').",".getenv('DBPWD'));
	$pd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	$pd->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');

	$nCSO = $pd->prepare("INSERT INTO Apitest VALUES (?)")->execute($data['name']);
	$pd->query($nCSO);
	$result = $pd->execute(filter_var_array($nCSO));

	if ($nCSO) {
		$res->withJson(json_encode($nCSO));
	}
	
	$pd = null; */
	$d = $req->getBody();
	return $d;
});

//run app
$app->run();

?>