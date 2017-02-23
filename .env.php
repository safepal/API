<?php 
/** SLIM config **/
DISPLAYERRORDETAILS = true;
ADDCONTENTLENGTHHEADER = false;

/** DB config **/
HOST = "localhost";
DBUSER = "admin_safepal";
DB = "safepaldb";
DBPWD = "safepal";

/** MONOLOG **/
LOGGER = "apilog";
STREAM_HANDLER = "logs/api.log";

/** QUERIES **/
ADD_REPORT = "INSERT INTO incident_report_details(survivor_gender, survivor_date_of_birth, unique_case_number, incident_type, incident_location, incident_date_and_time, status, incident_description, incident_reported_by, report_timestamp, reporter_lat, reporter_long, survivor_contact_phone_number, survivor_contact_email) VALUES (:survivor_gender, :survivor_date_of_birth, '$safepalNum', :incident_type, :incident_location, :incident_date_and_time, :status, :incident_description, :incident_reported_by,'$timestamp', :reporter_lat, :reporter_long, :survivor_contact_phone_number, :survivor_contact_email)";
GET_CSO = "SELECT * FROM cso_details";

/** JSON RESPONSE MESSAGES **/
STATUS = "status"; //refactor
MSG = "msg";
//success
SUCCESS_STATUS = "Success";
SUCCESS_REPORT_MSG = "Report submitted successfully";

//failure
FAILURE_STATUS= "Failed";
FAILURE_REPORT_MSG = "Report submission failed";

/** MISC **/
DISTANCE_THRESHOLD = 3.0; //distance threshold in km
?>