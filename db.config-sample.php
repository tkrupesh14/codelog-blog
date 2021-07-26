<?php
session_start();
$host = "db_host";
$username = "db_username";
$password = "db_password";
$dbname = "db_name";

$conn = mysqli_connect($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  // echo "Connected successfully";
  ?>

