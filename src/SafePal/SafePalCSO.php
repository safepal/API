<?php

namespace SafePal;

//db
use SafePalDB;

//mapping
use SafePalMapping;

/**
* 
*/
final class SafePalCSO
{
	/* PROPERTIES */
	private protected $cso_name;

	private protected $cso_latitude;

	private protected $cso_longitude; 

	private protected $typeofownership; 

	private protected $contacts;

	private protected $db;

	private protected $map;


	 function __construct()
	{
		$this->db = new SafePalDb;
		$this->map = new SafePalMapping;
	} 

	//add new cso
	public function AddCSO($name, $latitude, $longitude, $contactsArray, $typeofownership = "NGO"){
		$this->cso_name = $name;
		$this->cso_latitude = $latitude;
		$this->cso_latitude = $longitude;
		$this->contacts = $contacts; 
		$this->typeofownership = $typeofownership;

		$cso = $this;

		$res = $this->db->AddCSO($cso);
		return $res;
	}

	//get all CSOs
	//return array of csos with 
	public static function GetNearestCSO($reportergps){

		$gps = json_decode($reportergps);

		//get district name
		$district = $this->map->GetLocationDistrict($gps['reporter_lat'], $gps['reporter_long']);

		if (!empty($district)) {
			$csos = $this->db->NearestCSO($district);
			return $csos;
		}

		$this->db = null; //close connection
	}
}

?>