<?php

namespace SafePal;

require_once "vendor/autoload.php";
use Predis as redis;

//register Redis
redis\Autoloader::register();

//use \Firebase\JWT\JWT; //to handle login/sessions

//ENV
/*$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load(); */

/**
* 
*/
final class SafePalAuth
{
	protected $redis;

	function __construct()
	{
		try {

			$this->redis = new redis\Client();

		} catch (Exception $e) {

			throw new Exception($e->getMessage(), 1);
		} 
	} 

	//get token
	public function GetToken($userid){
		$token = $this->GenerateToken();

		//cache with redis
		$this->redis->set("{$token}", "{$userid}");  //--NOTE: MUST BE CAST AS STRINGS!!
		//$this->redis->expire($token, 60);
		$this->redis->ttl($token); //expires in 60 mins
		return $token;
	}

	//generate token
	protected function GenerateToken(){
		$token = bin2hex(openssl_random_pseudo_bytes(32)); //64 characters, 512 bits
		return $token;
	}

	//track token/user matches
	protected function TrackToken(){

	}

	//check if token-user match exists
	public function CheckToken($token, $user){
		if ($this->ValidateUser($user)) {
			return ($this->redis->exists($token)) ? true : false;
		}
	}

	//validate user
	public function ValidateUser($userid){
		$db = new SafePalDB();
		$user = $db->CheckUser($userid);
		if (!$user) {
			return false;;
		}

		return true;
	}
}

?>