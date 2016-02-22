<?php

//load and connect to MySQL database stuff
require("config.inc.php");

if (!empty($_POST)) {
	//initial query
	$query = "INSERT INTO report (ei_phoneNumber, ei_gender, ei_age, ti_location, ti_date, ti_time, ti_description, ti_type, ti_action) VALUES (:ei_phoneNumber, :ei_gender, :ei_age, :ti_location, :ti_date, :ti_time, :ti_description, :ti_type, :ti_action ) ";

    //Update query
    $query_params = array(
        ':ei_phoneNumber' => $_POST['ei_phoneNumber'],
        ':ei_gender' => $_POST['ei_gender'],
        ':ei_age' => $_POST['ei_age'],
        ':ti_location' => $_POST['ti_location'],
        ':ti_date' => $_POST['ti_date'],
        ':ti_time' => $_POST['ti_time'],
        ':ti_description' => $_POST['ti_description'],
        ':ti_type' => $_POST['ti_type'],
        ':ti_action' => $_POST['ti_action']
    );
  
	//execute query
    try {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) {
        // For testing, you could use a die and message. 
        //die("Failed to run query: " . $ex->getMessage());
        
        //or just use this use this one:
        $response["success"] = 0;
        $response["message"] = "Database Error. Couldn't add post!";
        die(json_encode($response));
    }

    $response["success"] = 1;
    $response["message"] = "Post Successfully Added!";
    echo json_encode($response);
   
} else {
?>
		<h1>Add Comment</h1> 
		<form action="addreport.php" method="post"> 
		    phoneNumber:<br /> 
		    <input type="text" name="ei_phoneNumber" placeholder="phonenumber" /> 
		    <br /><br /> 
		     gender:<br /> 
		    <input type="text" name="ei_gender" placeholder="gender" /> 
		    <br /><br /> 
		     age:<br /> 
		    <input type="text" name="ei_age" placeholder="age" /> 
		    <br /><br /> 
		    location:<br /> 
		    <input type="text" name="ti_location" placeholder="location of incident" /> 
		    <br /><br />
			date:<br /> 
		    <input type="text" name="ti_date" placeholder="date of incident" /> 
		    <br /><br />
		     time:<br /> 
		    <input type="text" name="ti_time" placeholder="time of incident" /> 
		    <br /><br /> 
		     description:<br /> 
		    <input type="text" name="ti_description" placeholder="description of incident" /> 
		    <br /><br /> 
		     type:<br /> 
		    <input type="text" name="ti_type" placeholder="type of incident" /> 
		    <br /><br /> 
		     action:<br /> 
		    <input type="text" name="ti_action" placeholder="action taken" /> 
		    <br /><br /> 
		    <input type="submit" value="Add report" /> 
		</form> 
	<?php
}

?> 