<?php
namespace SafePal;

//geocoder
use \Geocoder\Provider\GoogleMaps as gmaps;

//adapter
use \Ivory\HttpAdapter\CurlHttpAdapter as CurlHttpAdapter; 

/**
* Handles all mapping-related work
*/
final class SafePalMapping 
{
	
	public function GetLocationDistrict($lat, $long){

		if (!empty($lat) && !empty($long)) {
			//curl http adapter -- *note: should be optional since slim already implements PSR-7
			$curl = new CurlHttpAdapter();
			$gmaps = new gmaps($curl);

			$district = $gmaps->reverse($lat, $long)->first()->getLocality();

			if ($district) {
				return $district;
			}
		}
	}

	public static function GetDistance($userlat, $userlng, $destlat, $destlng){
		//calculate distance -- 

		$theta = $userlng - $destlng;

		$d = sin(deg2rad($userlat)) * sin(deg2rad($destlat)) 
			+ cos(deg2rad($userlat)) * cos(deg2rad($destlat)) * cos(deg2rad($theta));

		$d = (float) rad2deg(acos($d)) * 69.09; //converted to miles from nautical miles? (60 * 1.1515)

		return $d;
	}
	
}
?>