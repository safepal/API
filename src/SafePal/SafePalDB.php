<?php 
namespace SafePal;

use Predis as redis;

//register Redis
redis\Autoloader::register();

/**
* Handles all database work/interaction
*/
final class SafePalDB 
{
	protected $pdo;
	protected $redisclient;
	protected $cleardb;

	function __construct()
	{	
		//$this->pdo = new \PDO('mysql:host='.getenv('HOST').';dbname='.getenv('DB').';port='.getenv('PORT').';charset=utf8',''.getenv('DBUSER'));
		$cleardb = parse_url(getenv("CLEARDB_DATABASE_URL"));
		$this->pdo = new \PDO("mysql:host=".$cleardb['host'].";dbname=".substr($cleardb["path"], 1).";charset=utf8",$cleardb['user'], $cleardb['pass']);
		$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
		$this->pdo->setAttribute(\PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
	} 

	//check if user exists
	public function CheckUser($userid){

		$user = $this->pdo->prepare(getenv('CHECKUSER_QUERY'));
		$user->execute(array("userid" => $userid));
		$result = $user->fetchColumn();

		return ($result) ? true : false; 
	}

	//save new report
	public function SaveReport($report){
		$result = $this->AddReport($report);
		return $result;
	}

	//add report to db
	private function AddReport($report){
		$result = null;
		$nearbycsos = array();

		//- location data
		$mapping = new SafePalMapping;
		$district = $mapping->GetLocationDistrict($report['latitude'], $report['longitude']);

		$query = getenv('ADD_REPORT_QUERY_1').' VALUES '.getenv('ADD_REPORT_QUERY_2');

		if (!empty($report)) {
			$query_params = array(
						'type' => $report['type'],
				        'gender' => $report['gender'],
				        'reporter' => $report['reporter'],
				        'district' => $district,
				        'latitude' => $report['latitude'],
				        'longitude' => $report['longitude'],
				        'location' => $district,
				        'reportDate' => $report['reportDate'],
				        'incident_date' => $report['incident_date'],
				    	'perpetuator' => $report['perpetuator'],
				    	'age' => $report['age'],
				    	'contact' => $report['contact'],
				    	'details' => $report['details'],
				    	'report_source' => $report['report_source'],
						);

			$stmt = $this->pdo->prepare($query);

			$res = $stmt->execute(filter_var_array($query_params));

			($res) ? ($result['caseNumber'] = ("{$this->pdo->lastInsertId()}")) : ($result['caseNumber'] = null);
		}

		//get nearest CSOs based on district --NOTE: CHANGE IMPROVE AFTER PILOT FOR RADIUS OF 5km MAX

		$csos = $this->GetCSOs();

		for ($i=0; $i < sizeof($csos); $i++) {

			$csoDistrict = $mapping->GetLocationDistrict($csos[$i]['cso_latitude'], $csos[$i]['cso_longitude']);

			if ($csoDistrict == $district) {
				//--notify via email TO-DO: Refactor
				array_push($nearbycsos, $csos[$i]);
			}
		}

		$result['csos'] = $nearbycsos;

		return $result;
	}

	//add note/case activity
	public function AddCaseActivity($note){
		$params = array(
			'note' => $note['note'],
			'action' => $note['action'],
			'action_date' => $note['action_date'],
			'user' => $note['user'],
			);

		$stmt = $this->pdo->prepare(getenv('NEW_CASE_ACTIVITY_QUERY'));

		$res = $stmt->execute(filter_var_array($params));

		return $res;
	}

	//get all reports
	public function GetReports(){
		$q = $this->pdo->prepare(getenv('GET_ALL_REPORTS_QUERY'));
		$q->execute();
		return $q->fetchAll();
	}

	//get all CSOs
	private function GetCSOs(){
		$query = $this->pdo->prepare(getenv('GET_ALL_CSOS_QUERY'));
		$query->execute();

		return $query->fetchAll();
	}

	//get district csos
	public function NearestDistrictCSO($district){
		//query
		$nCSO = $this->pdo->prepare(getenv('GET_CSO_BY_DISTRICT_QUERY'));
		$nCSO->execute(array("district" => $district));
		$centres = $nCSO->fetchAll();

		if (sizeof($centres) > 0) {
			return $centres;
		}

		return null;
	}

	//check auth
	public function CheckAuth($user, $hash){
		$query = $this->pdo->prepare(getenv('CHECKAUTH_QUERY'));
		$query->execute(array("hash" => $hash, "user" => $user));

		$result = $query->fetchAll();

		if (sizeof($result) > 0) {
			return true;
		}

		
		return false;
	}
}
?>