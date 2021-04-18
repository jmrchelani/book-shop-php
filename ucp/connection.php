<?php

$username = 'root';
$password = '';
$host = 'localhost';

$db = 'bookshop';

$conn = new mysqli($host, $username, $password, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 


?>