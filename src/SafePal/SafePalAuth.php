<?php

namespace SafePal;

use Predis as redis;

//register Redis
redis\Autoloader::register();

//use \Firebase\JWT\JWT; //to handle login/sessions

/**
* Handles all authentication work with db
*/
final class SafePalAuth
{
	protected $redis;

	function __construct()
	{
		try {

			//$this->redis = new redis\Client(getenv('REDIS_URL'));
			$this->redis = new redis\Client(getenv('REDIS_URL'));

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
		$token = bin2hex(openssl_random_pseudo_bytes(getenv('TOKEN_SIZE'))); 
		return $token;
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
			return false;
		}

		return true;
	}

	//authenticate user
	public function CheckAuth($username, $hash){
		$db = new SafePalDB();
		return $db->CheckAuth($username, $hash);
	}

}

?>