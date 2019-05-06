<?php

//INCLUDE CREDS
require_once 'base.php';

//ESTABLISH CONN
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//IS CONNECTION SUCCESSFUL
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    echo "connected";
}

?>