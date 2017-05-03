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
$dotenv = new Dotenv\Dotenv(__DIR__, '.env');
$dotenv->load(); 

$config = ['settings'=> ['displayErrorDetails' => getenv('DISPLAYERRORDETAILS'), 'debug' => getenv('DISPLAYERRORDETAILS'),]];

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
    $app->group('/auth', function () use ($app){
        
        //get token
        $app->get('/newtoken', function (Request $req, Response $res) use ($app){

            $user = $req->getHeaderLine('userid');

            if (!empty($user)) {

                $auth = $this->get('auth');

                if (!$auth->ValidateUser($user)) {
                    return $res->withJson(array(getenv('STATUS') => getenv('FAILURE_STATUS'), getenv('MSG') => getenv('INVALID_USER_MSG')));
                }

                $token = $auth->GetToken($user);

                return $res->withJson(array(getenv('STATUS') => getenv('SUCCESS_STATUS'), "token" => $token));
            } 
        });


        //check token --handled in middleware
        $app->post('/checktoken', function (Request $req, Response $res) use ($app){
        });

        //login
        $app->post('/login', function (Request $req, Response $res) use ($app){

            $username = $req->getParsedBody()['username'];
            $hash = $req->getParsedBody()['hash'];

            $status = $this->auth->CheckAuth($username, $hash);

            return $res->withJson(array("login" => $status));
        });

    });

    /*** REPORTS ***/
    $app->group('/reports', function() use ($app) {

        //add new reports
        $app->post('/addreport', function(Request $req, Response $res) use ($app){

            $report = $req->getParsedBody();

            //add report
            $result = $this->reports->AddReport($report);

            return ($result['caseNumber']) ? $res->withJson(array(getenv('STATUS')  => getenv('SUCCESS_STATUS'), getenv('MSG') => "Report added successfully!", "casenumber" => $result['caseNumber'], "csos" => $result['csos'])) : $res->withJson(array(getenv('STATUS') => getenv('FAILURE_STATUS'), getenv('MSG') => "Failed to add report"));

        });

        //get all reports
        $app->post('/all', function (Request $req, Response $res) use ($app){

            $allreports = $this->reports->GetAllReports();

            return (sizeof($allreports) > 0) ? $res->withJson(array(getenv('STATUS')  => getenv('SUCCESS_STATUS'), "reports" => $allreports)): $res->withJson(array(getenv('STATUS')  => getenv('FAILURE_STATUS'), "reports" => NULL));

        });
});

        /*** CASE ACTIVITY ***/
    $app->group('/activity', function () use ($app){
        
        //add note
        $app->post('/addactivity', function (Request $req, Response $res) use ($app){

            $note = $req->getParsedBody();

            if (empty($note)) {
                $res->withJson(array(getenv('STATUS')  => getenv('FAILURE_STATUS'), getenv('MSG') => getenv('NOTE_EMPTY_MSG')));
            }

            $result = $this->reports->AddNote($note);

            return ($result) ? $res->withJson(array(getenv('STATUS') => getenv('SUCCESS_STATUS'), getenv('MSG') => getenv('NOTE_SUCCESS_MSG'))): $res->withJson(array(getenv('STATUS') => getenv('FAILURE_STATUS'), getenv('MSG') => getenv('NOTE_FAILURE_MSG'))); 

        });

    });
})->add(new pal\AuthMiddleware());

//run api app
$app->run();

?>