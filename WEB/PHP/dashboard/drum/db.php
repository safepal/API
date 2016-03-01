<?php
$connection = mysql_connect('localhost', 'thinkitl_safe', '$@F3p@l2015');
if (!$connection){
    die("Database Connection Failed" . mysql_error());
}
$select_db = mysql_select_db('thinkitl_safepal');
if (!$select_db){
    die("Database Selection Failed" . mysql_error());
}
?>