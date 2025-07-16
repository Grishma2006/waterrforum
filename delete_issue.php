<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in.");
}

if (!isset($_GET['id'])) {
    die("Issue ID is missing.");
}

$issue_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Step 1: Fetch the issue
$stmt = $conn->prepare("SELECT user_id FROM issues WHERE id = ?");
$stmt->bind_param("i", $issue_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Issue not found.");
}

$issue = $result->fetch_assoc();

// Step 2: Check if current user is the owner
if ($issue['user_id'] != $user_id) {
    die("You are not authorized to delete this issue.");
}

// Step 3: Proceed with deletion
$delete = $conn->prepare("DELETE FROM issues WHERE id = ?");
$delete->bind_param("i", $issue_id);
$delete->execute();

header("Location: view_issues.php");
exit;
?>
