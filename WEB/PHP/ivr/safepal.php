<?php 
require_once '../vendor/autoload.php'; //autoload all app namespaces/classes
require '../vendor/predis/predis/autoload.php';

//imports
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use AfricasTalking\AfricasTalkingGateway;
use SafePal\Utils;
use SafePal\ivr; 

//predis
Predis\Autoloader::register(); //register predis


//dotenv
$dotenv = new Dotenv\Dotenv('../', ".env.php");
$dotenv->load();

/*
--MONOLOG
*/
//create loggers
$mainlogger = new Logger(getenv('MAIN_LOG'));
$pushlogger = new Logger(getenv('PUSH_OVER_LOG'));

//formatter
$outputFormat = getenv('LOG_OUTPUT_FORMAT');
$dateformat = getenv('LOG_DATE_FORMAT');
$lineformatter = new LineFormatter($outputFormat, $dateformat, true, true);

//set/add handlers
$mainhandler = new StreamHandler(getenv('LOG_FILE'), Logger::DEBUG);
$mainhandler->setFormatter($lineformatter);
$mainlogger->pushhandler($mainhandler);

//check post
if (!(isset($_POST['sessionId']) && 
	isset($_POST['direction']) && 
	isset($_POST['isActive']) && 
	isset($_POST['callerNumber']) && 
	isset($_POST['destinationNumber']))) {
	
	$mainlogger->warning("Access from non-IVR client, ip=".$_SERVER['REMOTE_ADDR']);
	exit(0);
}

//Get POST data sent to this callbackurl from Africa Is Talking (AIT) API
$sessionID = $_POST['sessionId'];
$direction = $_POST['direction']; //direction of call, can be 'Inbound' or 'Outbound'
$isCallActive = intval($_POST['isActive']); //determines if call is active/on-going (1) or not/ended (0)
$callerNumber = $_POST['callerNumber']; //number that has called SafePal service
$aitNumber = $_POST['destinationNumber'];

//redis
$redis = new Predis\Client(array("auth" => getenv('REDIS_AUTH')));

//ivr
$ivr = new ivr($redis, $callerNumber, $sessionID, new AfricasTalkingGateway(getenv('AIT_USERNAME'),getenv('AIT_KEY')), $aitNumber, $mainlogger);

if ($isCallActive == 1) {
	//we are rejecting all incoming calls and calling number back
	if ($direction == "Inbound") {

		try {

			$ivr->HangUp("Thank you for calling SafePal. We'll call you back shortly."); //hangup call

			/*$x = new AfricasTalkingGateway(getenv('AIT_USERNAME'),getenv('AIT_KEY'));
			$res = $x->call($aitNumber, $callerNumber); */

			$x = $ivr->CallBackUser();

			$mainlogger->error($x);
			$mainlogger->addError($x);
			//isset($callerNumber) ? $ivr->CallBackUser() : exit(0); //try to call back user immediately
		} catch (Exception $e) {
			$mainlogger->error($e->getTraceAsString());
		}
	}

	//we try to get caller report
	else{
		try {
			$digits = null;

			if (isset($_POST['dtmfDigits'])) {
				$digits = $_POST['dtmfDigits'];
			}

			$ivr->GetCallerReport($digits);

		} catch (Exception $e) {
			$mainlogger->debug("Error processing caller report: ".$e->getMessage());
			exit(0); //exit gracefully
		}
	}
}

//if call ends/drops
else{
	//save session data and call data/responses
	// $ivr->SaveCallData(isset($_POST['durationInSeconds']) ? intval($_POST['durationInSeconds']) : 0, isset($_POST['amount']) ? $_POST['amount'] : 0, isset($_POST['status']) ? $_POST['status'] : "Dropped", isset($_POST['recordingUrl']) ? $_POST['recordingUrl'] : "");
}


?>