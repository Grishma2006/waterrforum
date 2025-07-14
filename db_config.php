<?php
$host = "sql12.freesqldatabase.com";
$user = "sql12789865";
$pass = "DBFvd7HTtm"; // XAMPP default has no password
$db = "sql12789865";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
