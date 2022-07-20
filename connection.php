<?php 

// $mysqli = new mysqli("hostname", "username", "password", "database");
$mysqlicon = new mysqli("localhost", "root", "", "login_db");
 
// Check connection
if($mysqlicon === false){
    die("ERROR: Could not connect. " . $mysqlicon->connect_error);
}
// Print host information
echo "Connection Successfully. Host info: " . $mysqlicon->host_info;
