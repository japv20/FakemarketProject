<?php 

// $mysqli = new mysqli("hostname", "username", "password", "database");
// $mysqlicon = new mysqli("localhost", "root", "", "login_db");
$mysqlicon = new mysqli("eu-cdbr-west-03.cleardb.net", "b21d46832d533e", "8f35cee4", "heroku_b2764aba82c3a92");
 
// Check connection
if($mysqlicon === false){
    die("ERROR: Could not connect. " . $mysqlicon->connect_error);
}
// Print host information
echo "Connection Successfully. Host info: " . $mysqlicon->host_info;
