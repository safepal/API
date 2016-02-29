<?php
$connection = mysql_connect('localhost', 'safepalAdm1n', 'Af3ceybTA9Yt6nszHvkCetq');
if (!$connection){
    die("Database Connection Failed" . mysql_error());
}
$select_db = mysql_select_db('SFPdb');
if (!$select_db){
    die("Database Selection Failed" . mysql_error());
}
?>