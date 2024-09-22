<?php

$server = "localhost";
$db_name = "dbname";
$user = "username";
$pass = "password";

$conn = new mysqli($server, $user, $pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>