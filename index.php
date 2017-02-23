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
$dicontainer['logger'] = function ($logger){
	$logger = new \Monolog\Logger(getenv('LOGGER'));
	$file = new \Monolog\Handler\StreamHandler(getenv('STREAM_HANDLER'));
	$logger->pushHandler($file);
	return $logger;
};

//middleware to handle CSRF
$app->add(new \Slim\Csrf\Guard);

///ROOT
$app->get('/', function (Request $req, Response $res){
	$res->getBody()->write("SafePal API v1.");
	return $res;
});

$app->group('/api/v1', function () use ($app){

	/*** AUTH ***/

	/*** REPORTS ***/
	//add reports
	$app->post('reports/add', function (Request $req, Response $res){
		$report = $req->getParsedBody();

		if (!empty($report)) {
	    	try {
	    		$rep = new \SafePal\SafePal\SafePalReport;
	    		$rep->AddReport($report);

	    		//return status
	    		return $res->withJson(array(getenv('SUCCESS_RESPONSE'));

	    	} catch (PDOException $e) {
	    		$this->logger->addInfo($e);

	    		//return status
	    		return $res->withJson(getenv('FAILURE_RESPONSE'));
	    	}
		}
	});

	//get all reports
	$app->post('reports/all', function (Request $req, Response $res){

	});

	//return report by id
	$app->get('reports/{rid}', function (Request $req, Response $res){
		$rID = $req->getAttribute('rid');
	});

	//delete report
	$app->post('reports/del/{rid}', function (Request $req, Response $res){
		$rID = $req->getAttribute('rid');
	});




	/*** USERS ***/

	/*** HEALTH CENTRES/CSOs ***/

	//get nearest health centres based on GPS
	$app->post('locations/nearest', function (Request $req, Response $res){

		$gps = $req->getParsedBody();

		//quick check
		if (!empty($gps)) {
			$location = new SafePalCSO;
			$dist = new SafePalMapping;

			$centres = $location->GetNearestCSO($gps);
			
			$nearest = new array();

			//**note: consider refactoring here
			if (sizeof($centres) > 0) {

				for ($centres as $key => $value) {
					//calculate distance -- could be optional since we are sending back centres in the same district

					//construct result array
					array_push($nearest, array(
						"cso_name" => $centres["cso_name"], 
						"cso_location" => $centres["cso_location"], 
						"cso_distance" => $dist->GetDistance($gps['reporter_lat'], $gps['reporter_lat']), $centres['cso_latitude'], $centres['cso_longtitude']) * (int) 1.61, 
						"cso_phone_number" => $centres["cso_phone_number"]));
				}
			}
			//return json
			return $res->withJson(sort($nearest));
		}

	});

	/*** IVR ***/
});

//run app
$app->run();

?>