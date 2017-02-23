<?php

//session_start();

require_once "vendor/autoload.php";

//PSR
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//Posgresql
//use Herrera\Pdo as pdo;

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

//psgre
/*$dbopts = parse_url(getenv('DB_URL'));
$app->register(new Herrera\Pdo\PdoServiceProvider(),
               array(
                   'pdo.dsn' => 'pgsql:dbname='.ltrim($dbopts["path"],'/').';host='.$dbopts["host"] . ';port=' . $dbopts["port"],
                   'pdo.username' => $dbopts["user"],
                   'pdo.password' => $dbopts["pass"]
               )
); */

//MySQL
$dicontainer['db'] = function ($db){
	$db = parse_url(getenv('CLEARDB_DATABASE_URL'));
	$server = $db["host"];
	$username = $db["user"];
	$password = $db["pass"];
	$database = substr($db["path"], 1);

	//$conn = new PDO("mysql:host=" . $server . ";dbname=" . $database . "," .$username. "," . $password);
	$conn = new mysqli($server, $username, $password, $database);
    return $conn;
};

//middleware to handle CSRF
//$app->add(new \Slim\Csrf\Guard);

///ROOT
$app->get('/', function (Request $req, Response $res){
	$res->getBody()->write("SafePal API v1.5");
	return $res;
});

$app->post('/test', function (Request $req, Response $res){

	$data = $req->getParsedBody();

	if (empty($data)) {
		throw new InvalidArgumentException("Empty request");
	} 

	/*
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
	$q = "INSERT INTO Apitest VALUES (".$data['name'].")";
	$rest = $this->conn->query($q);

	if ($rest) {
		return $this->res->withJson(array("state" => "done"));
	}

});

//run app
$app->run();

?>