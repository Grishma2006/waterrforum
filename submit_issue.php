<?php
session_start();
include 'db_config.php';

$user_id = $_SESSION['user_id'];
$title = $_POST['title'];
$description = $_POST['description'];
$category = $_POST['category'];
$location = $_POST['location'];

$image = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];
$upload_path = "uploads/" . basename($image);
move_uploaded_file($tmp, $upload_path);

$stmt = $conn->prepare("INSERT INTO issues (user_id, title, description, category, location, image) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssss", $user_id, $title, $description, $category, $location, $image);
$stmt->execute();

echo "Issue submitted successfully. <a href='view_issues.php'>View Issues</a>";
?>
