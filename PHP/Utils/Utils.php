<?php

namespace SafePal;

/**
* - Utility class
* -- reusables here
*/
class Utils
{

    //generate cryptographically strong keys
    // - defaults to 23 as length
    public static function GenBytes(){
        $val = openssl_random_pseudo_bytes(23);
        return bin2hex($val);
    }

    //# -- SMALL HELPER METHOD TO CONNECT AND QUERY DB
    public static function Query($query, $return){

		try {
			//connect
			$con = new mysqli(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PWD'), getenv('DB_NAME'));

			$res = $con->query($query) or die(mysql_error());

			if ($res->num_rows > 0 && $return == true) { //only return values if we need anything
				$data = $res->fetch_assoc();
				return $data;
			}

		} catch (Exception $e) {
			return $e->getMessage();
		}
    }

   	//#- METHOD TO CONSTRUCT & CLEAN UP METHODS LIST
	public static function GetListFromArray($array){
		$string = "";
		foreach ($array as $key => $value) {
			$string .= $value.",";
		}

		//remove trailing comma/clean out string
		$string = trim($string, ",");

		return $string;
	}

	public static function timebetween($tz, $start, $end) {

		$dt = new DateTime("now",new \DateTimeZone($tz));

		$hrs = intval($dt->format("G"));
		$min = intval($dt->format("i")) / 60;

		$time = $hrs + $min;

		return ($time > $start) && ($time < $end);
	}

}

?>