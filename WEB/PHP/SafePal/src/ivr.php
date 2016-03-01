<?php

namespace SafePal;

//imports
use Monolog\Logger;
use SafePal\Utils;

/**
* SafePal IVR class
*/
class IVR 
{

	private $redis;
	private $callerNum;
	private $sessionID;
	private $AITgateway;
	private $aitnum;
	private $responseskey; //-- log responses
	private $rediskey; //-- screening key 
	private $mainlogger;
	
	function __construct($redis, $callerNum, $sessionID, $AITgateway, $aitnum, $mainlogger)
	{
		$this->redis = $redis;
		$this->callerNum = $callerNum;
		$this->sessionID = $sessionID;
		$this->AITgateway = $AITgateway;
		$this->aitnum = $aitnum;
		$this->responseskey = "responses:".$sessionID;
		$this->rediskey = $callerNum.":".$sessionID;
		$this->mainlogger = $mainlogger;
	}

	//send hangup response
	public function HangUp($msg = "Thank for using SafePal. Goodbye!"){
		$response = '<?xml version="1.0" encoding="UTF-8"?>';
	    $response .= '<Response>';
	    $response .= '<Say>'.$msg.'</Say>';
	    $response .= '<Reject/>';
	    $response .= '</Response>';

	    header('Content-type: text/plain');
	    echo $response;
	}

	//call back user
	public function CallBackUser(){
		try {
			$result = $this->AITgateway->call($this->aitnum, $this->callerNum);
	        return $result;

		} catch (Exception $e) {
			$this->mainlogger->error($e->getTraceAsString());
		}
	}

	//send and get user response
	public function SendResponse($msg, $getdigits = true){
		//construct response
		$response = '<?xml version="1.0" encoding="UTF-8"?>';
		$response .= '<Response>';

		if (!$getdigits) {
			$response .= '<Say'.$msg.'/>';
		}

		else{
			$response .= '<GetDigits  timeout="30" finishOnKey="#">';
			$response .= '<Say>'.$msg.'</Say>';
			$response .= '<GetDigits/>';
		}

		$response .= '</Response>';
		header('Content-type: text/plain');
		echo $response;
	}

	//play response
	public function PlayResponse($getUserInput, $playbackURL, $responseFiles) {

		//construct response
		$response = '<?xml version="1.0" encoding="UTF-8"?>';
		$response .= '<Response>';

		//if we don't care about user input just play a bunch of files
		if (!$getUserInput) {
			foreach ($responseFiles as $file) {
				$response .= '<Play url="'.$playbackURL.$file.'.mp3"/>';
			}
		} else {

			//get the last file, around which we wrap the the "GetDigits" call
			$lastFile = array_pop($responseFiles);

			//now loop through any remaining files and create calls to the "Play" command
			foreach ($responseFiles as $file) {
				$response .= '<Play url="'.$playbackURL.$file.'.mp3"/>';
			}

			$response .= '<GetDigits  timeout="30" finishOnKey="#">';
			$response .= '<Play url="'.$playbackURL.$lastFile.'.mp3"/>';
			$response .= '</GetDigits>';
		}

		$response .= '</Response>';
		header('Content-type: text/plain');
		echo $response;
	}

	//record user message
	public function RecordResponse($playbackURL, $instructionFiles) {

		//construct response
		$response = '<?xml version="1.0" encoding="UTF-8"?>';
		$response .= '<Response>';

		foreach ($instructionFiles as $instruction) {
			$response .= '<Play url="'.$playbackURL.$instruction.'.mp3"/>';
		}

		$response .= '<Say playBeep="true"/>';

		$response .= '<Record/>';
		$response .= '</Response>';
		header('Content-type: text/plain');
		echo $response;
	}

	//forward call
	public function ForwardCallWithPlayback($playbackURL, $instructionFiles, $forwardingNumber) {

		//construct response
		$response = '<?xml version="1.0" encoding="UTF-8"?>';
		$response .= '<Response>';

		foreach ($instructionFiles as $instruction) {
			$response .= '<Play url="'.$playbackURL.$instruction.'.mp3"/>';
		}

		$response .= '<Dial phoneNumbers="'.$forwardingNumber.'"/>';
		$response .= '</Response>';
		header('Content-type: text/plain');
		echo $response;
	}

	//forward call
	public function ForwardCall($forwardingNumber) {

		//construct response
		$response = '<?xml version="1.0" encoding="UTF-8"?>';
		$response .= '<Response>';
		$response .= '<Dial phoneNumbers="'.$forwardingNumber.'"/>';
		$response .= '</Response>';
		header('Content-type: text/plain');
		echo $response;
	}

	//send sms to user
	public function SendSMS($to, $msg) {
		try {
			$res = $this->AITgateway->sendMessage($to, $msg, $this->aitnum);
		} catch (Exception $e) {
			echo "Oops! Something wrong happened and we couldn't send the SMS to ".$to;
		}
	}

	//get user report
	public function GetCallerReport($callerinput){

		$lastcallstate = $this->GetLastCallState();
		$currentcallstate = $this->GetCurrentCallState();

		if ($currentcallstate == "start") {
			$nextStep = "getAge";
			$msg = "Welcome to SafePal. We will ask you a few questions in order to better connect you to help. How old are you? Use the keypad on the phone to enter your age followed by the hash key";
			$this->SendResponse($msg, true);
			$this->SetNewCallState($nextStep);
		}

		elseif ($currentcallstate == "getAge") {
			if (isset($callerinput)) {
				//log user's age

				$nextStep = "getGender";
				$msg = "Are you female or male? Press 1 if you are a female and 2 if you are male";
				$this->SendResponse($msg, true);
				$this->SetNewCallState($nextStep);
			}
		}

		elseif ($currentcallstate == "getGender") {
			if (isset($callerinput)) {
				//log user's gender
				$this->SetCallerType($callerinput);

				$nextStep = "getNumber";
				$msg = "Is there a number we can use to get in touch with you to help you? This can be a phone number for a trusted relative, friend or someone you know. If yes, enter the number followed by hash. If no, enter 0 followed by hash";
				$this->SendResponse($msg, true);
				$this->SetNewCallState($nextStep);
			}
		}

		elseif ($currentcallstate == "getNumber") {
			if (isset($callerinput)) {

				if (intval($callerinput) == 0) { //if user doesn't have number to use, forward call immediately
					$this->ForwardCall(getenv('REF_NUM'));
				}

				else{
					//log user's contact for use later


					$nextStep = "whatHappened";
					$msg = "Thank you. Can you tell us what you'd like to report? Press 1 for sexual violence like rape or defilement. Press 2 for physical violence like domestic violence";
					$this->SendResponse($msg, true);
					$this->SetNewCallState($nextStep);
				}
			}
		}

		elseif ($currentcallstate == "whatHappened") {
			if (isset($callerinput)) {
				//log type of violence


				if (intval($callerinput) == 1) { //if it was sexual violence, need to forward immediately
					$this->ForwardCall(getenv('REF_NUM'));
				}

				else{
					$nextStep = "whenItHappened";
					$msg = "Sorry to hear about that. We will ask a few more questions to improve the help we can get you. How many days ago did the incident happen?";
					$this->SendResponse($msg, true);
					$this->SetNewCallState($nextStep);
				}
			}
		}

		elseif ($currentcallstate == "whenItHappened") {
			if (isset($callerinput)) {
				//log days since incident


				$nextStep = "whereItHappened";
				$msg = "Where did the incident happen? Press 1 for home, press 2 for school and press 3 if it happened at work";
				$this->SendResponse($msg, true);
				$this->SetNewCallState($nextStep);
			}
		}

		elseif ($currentcallstate == "whereItHappened") {
			if (isset($callerinput)) {
				//log incident location


				$nextStep = "helpGotten";
				$msg = "Have you reported to or been helped by any of the following: Press 1 for Police, press 2 for any medical help, press 3 for LC, press 4 for Safe Shelter or press 5 for any form of legal help got";
				$this->SendResponse($msg, true);
				$this->SetNewCallState($nextStep);
			}
		}

		elseif ($currentcallstate == "helpGotten") {
			if (isset($callerinput)) {
				//log help so far


				$nextStep = "callEnd";
				$msg = "Thank for your report. We will have someone get in touch to help you quickly. Remember to also report to the police or nearest medical centre or clinic as soon as possible. Goodbye!";
				$this->SendResponse($msg, false);
				$this->SetNewCallState($nextStep);
			}
		}

		else {
			$msg = "Thank for your report. Remember to also report to the police or nearest medical centre or clinic as soon as possible.";
			$this->HangUp($msg);
		}


	}

	//save call data
	/*public function SaveCallData($duration, $amount, $status, $recordingUrl) {

		$sessionend = (new \DateTime())->getTimestamp();
		$session = $this->redis->hgetall($this->rediskey);

		//if the duration of the session is empty, calculate it
		if (empty($duration))
			$duration = $sessionend - $session["sessionstart"];

		$callLog = new CallLog($this->logger);

		//call data
		$responses = $this->redis->hgetall($this->responseskey);
		if (!empty($responses))
			$calldata = array_merge($session, $responses);
		else
			$calldata = $session;
		$calldata["sessionend"] = $sessionend;

		$this->mainlogger->debug("Saving call data: ".json_encode($calldata));
		$callLog->saveCallLog($calldata);

		//screening data
		$responses = $this->redis->hgetall($this->screeningkey);
		if (!empty($responses)) {
			$screeningdata = array_merge($session, $responses);
			$screeningdata["sessionend"] = $sessionend;
			$screeningdata["lastcallstate"] = $session["callstate"];
			$screeningdata["duration"] = $duration;
			$screeningdata["amount"] = $amount;
			$screeningdata["recordingurl"] = $recordingUrl;

			$this->logger->debug("Saving screening data: ".json_encode($screeningdata));
			$callLog->saveScreening($screeningdata);
		}
	}*/

	private function SetupSession() {

		$dt = new \DateTime();
		$this->mainlogger->addError($dt);
		$this->mainlogger->addError($redis);
		$this->redis->hmset($this->rediskey,
				[
						"sessionstart" => $dt->getTimestamp(),
						"sessionid" => $this->sessionID,
						"caller" => $this->callerNum,
						"callstate" => "start"
				]);
	}

	//#-- METHOD TO GET CURRENT CALL STATE
	private function GetCurrentCallState() {

		//if there is no current call state, then return "start" by default
		//and setup a new session
		//otherwise verify the session details and get the call state
		$callState = "start";
        if ($this->redis->exists($this->rediskey) == 1) {
            $state = $this->redis->hgetall($this->rediskey);

            if ($state['sessionid'] == $this->rediskey && $state['caller'] == $this->callerNum) {
                $callState = !empty($state['callstate']) ? $state['callstate'] : "start";
            }
        } else {
        	$this->SetupSession();
        }

        //set the last call state to the current one
        $this->redis->hset($this->rediskey,"lastcallstate",$callState);

        //reset the expiry time from now
        $this->redis->expireat($this->rediskey, time() + getenv('REDIS_EXPIRE'));

        return $callState;
	}

	//#-- METHOD TO SET CURRENT CALL STATE
	private function SetNewCallState($callState) {

        $this->redis->hmset($this->rediskey, "callstate", $callState);
	}

	//#-- METHOD TO GET LAST USER CALL STATE
	private function GetLastCallState(){

		$callState = "--";
		if ($this->redis->exists($this->rediskey) == 1) {
			$state = $this->redis->hgetall($this->rediskey);

			if ($state['sessionid'] == $this->rediskey && $state['caller'] == $this->callerNum) {
				$callState = $state['lastcallstate'];
			}
		}

		return $callState;
	}

	private function SetCallerType($callerResponse) {
		$this->redis->hset($this->rediskey, "callerType", $callerResponse);
	}

	private function GetCallerType() {

		//if we don't find a caller type then return woman by default as that is the most
		//likely case
		if ($this->redis->exists($this->rediskey, "callerType") == 1) {
			$callerType = $this->redis->hget($this->rediskey, "callerType");
			return intval($callerType);
		} else {
			return 2;
		}
	}
}



?>