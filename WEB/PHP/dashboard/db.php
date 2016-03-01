<?php

require_once '../vendor/autoload.php'; //autoload all app namespaces/classes

//dotenv
$dotenv = new Dotenv\Dotenv('../', ".env.php");
$dotenv->load();


$connection = mysql_connect(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PWD'));
if (!$connection){
    die("Database Connection Failed" . mysql_error());
}
$select_db = mysql_select_db(getenv('DB_NAME'));
if (!$select_db){
    die("Database Selection Failed" . mysql_error());
}
?>