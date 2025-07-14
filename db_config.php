<?php
$host = "sql212.ezyro.com";
$user = "ezyro_39462996";
$pass = ""; // XAMPP default has no password
$db = "water_forum";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
