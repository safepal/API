<?php
// Start PHP session
session_start();

require_once "vendor/autoload.php";

//PSR
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Csrf as csrf;

//SafePal
use SafePal as pal;

//ENV
/*$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load(); */

$config = ['settings'=> ['displayErrorDetails' => true, 'debug' => true,]];

//INIT SLIM
$app = new \Slim\App($config);

//DI container
$dicontainer = $app->getContainer();

//Monolog
$dicontainer['logger'] = function ($logger){
	$log = new \Monolog\Logger(getenv('LOGGER'));
	$file = new \Monolog\Handler\StreamHandler(getenv('STREAM_HANDLER'));
	$log->pushHandler($file);
	return $log;
};

//auth
$dicontainer['auth'] = function ($d){
	$auth = new pal\SafePalAuth;
	return $auth;
};

//reports
$dicontainer['reports'] = function ($rp){
	return new pal\SafePalReport();
};

//middleware to handle CSRF
//$app->add(new csrf\Guard);

$app->add(function($req, $res, $next){
	if (!$req->isXhr()) {
		return $next($req, $res);
	}
});



///ROOT
$app->get('/', function (Request $req, Response $res){
	$res->getBody()->write("SafePal API v1.5");
	return $res;
});

/// API V1
$app->group('/api/v1', function () use ($app) {

    /*** AUTH ***/
    $app->group('/tokens', function () use ($app){
    	
    	//get token
    	$app->get('/newtoken', function (Request $req, Response $res) use ($app){

    		$user = $req->getHeaderLine('userid');

    		if (!empty($user)) {

    			$auth = $this->get('auth');

    			if (!$auth->ValidateUser($user)) {
    				return $res->withJson(array("status" => "failure", "msg" => "invalid user"));
    			}

    			$token = $auth->GetToken($user);

    			return $res->withJson(array("status" => "success", "token" => $token));
    		} 
    	});


    	//check token
    	$app->post('/checktoken', function (Request $req, Response $res) use ($app){
    		$token = $req->getParsedBody()['token'];

    		if (empty($token)) {
    			return $res->withJson(array("status" => "failure", "msg" => "'token' missing in your request"));
    		}

    		$tokenExists = $this->auth->CheckToken($token);

    		return $res->withJson(array("tokenstatus" => ($tokenExists ? "token is valid" : "invalid token")));
    	});

	});

	/*** REPORTS ***/
	$app->group('/reports', function() use ($app) {

		//add new reports
		$app->post('/addreport', function(Request $req, Response $res) use ($app){
			$report = $req->getParsedBody();
			$user = $req->getHeaderLine('userid');

			if (empty($report['token'])) {
				throw new InvalidArgumentException("No token provided");
			}

			$tokenExists = $this->auth->CheckToken($report['token'], $user);

			if (!$tokenExists) {
				return $res->withJson(array("status" => "failure", "msg" => "invalid token"));
			}

			//add report
			$result = $this->reports->AddReport($report);

			return ($result['spid']) ? $res->withJson(array("status" => "success", "msg" => "Report added successfully!", "casenumber" => $result['spid'], "csos" => $result['csos'])) : $res->withJson(array("status" => "failure", "msg" => "Failed to add report"));

		});

        //get all reports
        $app->post('/all', function (Request $req, Response $res) use ($app){
        	$token = $req->getParsedBody()['token'];
        	$user = $req->getHeaderLine('userid');

        	$tokenExists = $this->auth->CheckToken($token, $user);

        	if (!$tokenExists) {
				return $res->withJson(array("status" => "failure", "msg" => "invalid token"));
			}

			$allreports = $this->reports->GetAllReports();

			return (sizeof($allreports) > 0) ? $res->withJson(array("status" => "success", "reports" => $allreports)): $res->withJson(array("status" => "failure", "reports" => NULL));

        });
	});

	/*** CSOs ***/

	/*** USERS ***/
});
//->add(); -- add middleware to run auth

function IsRequestEmpty($reqData){
	if (empty($reqData)) {
		throw new InvalidArgumentException("Empty request");
	}
}

//run api app
$app->run();

?>