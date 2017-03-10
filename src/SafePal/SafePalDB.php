<?php 
namespace SafePal;

require_once "vendor/autoload.php";

use Predis as redis;

//register Redis
redis\Autoloader::register();

//dotenv
/*$dotenv = new Dotenv\Dotenv(dirname(__FILE__), '.env.php');
$dotenv->load(); */

/**
* 
*/
final class SafePalDB 
{
	protected $pdo;
	protected $cso;
	protected $redisclient;

	function __construct()
	{	
		//pdo
		//$this->pdo = new PDO("mysql:host=".getenv('HOST').";dbname=".getenv('DB').",".getenv('DBUSER').",".getenv('DBPWD'));
		$this->pdo = new \PDO('mysql:host=localhost;dbname=safepaldb;charset=utf8','root');
		$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
		$this->pdo->setAttribute(\PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
	} 

	//check if user exists
	public function CheckUser($userid){

		$user = $this->pdo->prepare("SELECT id FROM auth WHERE userid = :userid");
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
	private function AddReport($report, $prefix = "SPM"){
		$result = null;
		$nearbycsos = array();

		$q = "INSERT INTO incident_report_details(survivor_gender, survivor_date_of_birth, unique_case_number, incident_type, incident_location, incident_date_and_time, incident_description, incident_reported_by, reporter_lat, reporter_long, survivor_contact_phone_number, survivor_contact_email, report_source) VALUES (:survivor_gender, :survivor_date_of_birth, :prefix, :incident_type, :incident_location, :incident_date_and_time, :incident_description, :incident_reported_by, :reporter_lat, :reporter_long, :survivor_contact_phone_number, :survivor_contact_email, :report_source)";

		if (!empty($report)) {
			$query_params = array(
						'survivor_gender' => $report['survivor_gender'],
				        'survivor_date_of_birth' => $report['survivor_date_of_birth'],
				        'prefix' => $prefix,
				        'incident_type' => $report['incident_type'],
				        'incident_location' => $report['incident_location'],
				        'incident_date_and_time' => $report['incident_date_and_time'],
				        'incident_description' => $report['incident_description'],
				        'incident_reported_by' => $report['incident_reported_by'],
				    	'reporter_lat' => $report['reporter_lat'],
				    	'reporter_long' => $report['reporter_long'],
				    	'survivor_contact_phone_number' => $report['survivor_contact_phone_number'],
				    	'survivor_contact_email' => $report['survivor_contact_email'],
				    	'report_source' => $report['report_source'],
						);

			$stmt = $this->pdo->prepare($q);

			$res = $stmt->execute(filter_var_array($query_params));

			($res) ? ($result['spid'] = $prefix."{$this->pdo->lastInsertId()}") : ($result['spid'] = null);
		}

		//get nearest CSOs based on district --NOTE: CHANGE IMPROVE AFTER PILOT FOR RADIUS OF 5km MAX
		$mapping = new SafePalMapping;
		$userdistrict = $mapping->GetLocationDistrict($report['reporter_lat'], $report['reporter_long']);

		$csos = $this->GetCSOs();

		for ($i=0; $i < sizeof($csos); $i++) {

			$csoDistrict = $mapping->GetLocationDistrict($csos[$i]['cso_latitude'], $csos[$i]['cso_longitude']);

			if ($csoDistrict == $userdistrict) {
				array_push($nearbycsos, $csos[$i]);
			}
		}

		$result['csos'] = $nearbycsos;

		return $result;
	}

	//get all reports
	public function GetReports(){
		$q = "SELECT * FROM incident_report_details";
		$reports = $this->GetAllReports($q);
		return $reports;
	}

	private function GetAllReports($query){
		$rp = $this->pdo->prepare($query);
		$rp->execute();
		$rps = $rp->fetchAll();
		return $rps;
	}

	//get all CSOs
	private function GetCSOs(){
		$query = $this->pdo->prepare("SELECT cso_name, cso_email, cso_location, cso_latitude, cso_longitude, cso_working_hours, cso_phone_number FROM cso_details");
		$query->execute();

		return $query->fetchAll();
	}

	//return assoc
	public function AddCSO($cso){
		$this->$cso = (array) $cso;
	}

	//get district csos
	public function NearestDistrictCSO($district){
		//query
		$nCSO = $this->pdo->prepare("SELECT * FROM cso_details WHERE cso_location = :district");
		$nCSO->execute(array("district" => $district));
		$centres = $nCSO->fetchAll();

		if (sizeof($centres) > 0) {
			return $centres;
		}

		return null;
	}
}
?>