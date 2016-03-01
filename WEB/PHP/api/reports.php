<?php

/*
Our "config.inc.php" file connects to database every time we include or require
it within a php script.  Since we want this script to add a new user to our db,
we will be talking with our database, and therefore,
let's require the connection to happen:
*/
require("config.inc.php");

//initial query
$query = "Select * FROM report";

//execute query
try {
    $stmt   = $db->prepare($query);
    $result = $stmt->execute($query_params);
}
catch (PDOException $ex) {
    $response["success"] = 0;
    $response["message"] = "Database Error!";
    die(json_encode($response));
}

// Finally, we can retrieve all of the found rows into an array using fetchAll 
$rows = $stmt->fetchAll();


if ($rows) {
    $response["success"] = 1;
    $response["message"] = "Post Available!";
    $response["posts"]   = array();
    
    foreach ($rows as $row) {
        $post = array();
	//$post["ei_caseNo"]  = $row["ei_caseNo"];
        $post["ei_gender"] = $row["ei_gender"];
        $post["ei_age"]    = $row["ei_age"];
        $post["ti_location"]  = $row["ti_location"];
        $post["ti_date"]  = $row["ti_date"];
        $post["ti_time"]  = $row["ti_time"];
        $post["ti_description"]  = $row["ti_description"];
        $post["ti_type"]  = $row["ti_type"];
        $post["ti_action"]  = $row["ti_action"];
        
        
        //update our repsonse JSON data
        array_push($response["posts"], $post);
    }
    
    // echoing JSON response
    echo json_encode($response);
    
    
} else {
    $response["success"] = 0;
    $response["message"] = "No Post Available!";
    die(json_encode($response));
}

?>