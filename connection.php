<?php 

// $mysqli = new mysqli("hostname", "username", "password", "database");
$mysqlicon = new mysqli("localhost", "root", "", "login_db");
 
// Check connection
if($mysqlicon === false){
    die("ERROR: Could not connect. " . $mysqlicon->connect_error);
}
// Print host information
echo "Connection Successfully. Host info: " . $mysqlicon->host_info;

//Get Heroku ClearDB connection information
// $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
// $cleardb_server = $cleardb_url["eu-cdbr-west-03.cleardb.net"];
// $cleardb_username = $cleardb_url["b3b8a5d2b47e70"];
// $cleardb_password = $cleardb_url["5f9c330e"];
// $cleardb_db = substr($cleardb_url["path"],1);
// $active_group = 'default';
// $query_builder = TRUE;
// // Connect to DB
// $conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

// echo "Hello there heroku"
?>