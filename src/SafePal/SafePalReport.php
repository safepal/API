<?php 
namespace SafePal;

require_once "vendor/autoload.php";

/**
* 
*/
final class SafePalReport
{
	private $db;

	/**
	* report properties
	*/
	private $survivor_gender;

	private $survivor_date_of_birth;

	private $unique_case_number;

	private $incident_type;

	private $incident_location;

	private $incident_date_and_time;

	private $incident_description;

	private $incident_reported_by;

	private $reporter_lat;

	private $reporter_long;

	private $survivor_contact_phone_number;

	private $survivor_contact_email;

	private $report_source;

	private $spid;

	function __construct()
	{
		$this->db = new SafePalDB();
	} 

	//data from json/array
	public function AddReport($reportarray){

		$data = $this->db->SaveReport((array)$reportarray);
		$this->db = null; //close connection
		return $data;
	}

	//get all reports
	public function GetAllReports(){
		$reports = $this->db->GetReports();
		return $reports;
	}

}
?>