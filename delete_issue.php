<?php
session_start();
include 'db_config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "You must be logged in to delete an issue.";
    header("Location: login.php");
    exit;
}

// Check if issue ID is provided
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "Issue ID is missing.";
    header("Location: view_issues.php");
    exit;
}

$issue_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Step 1: Fetch the issue from the database
$stmt = $conn->prepare("SELECT user_id FROM issues WHERE id = ?");
$stmt->bind_param("i", $issue_id);
$stmt->execute();
$result = $stmt->get_result();

// Step 2: Check if issue exists
if ($result->num_rows === 0) {
    $_SESSION['error'] = "Issue not found.";
    header("Location: view_issues.php");
    exit;
}

$issue = $result->fetch_assoc();

// Debug (optional): uncomment for testing
// echo "Logged in user ID: $user_id<br>";
// echo "Issue posted by user ID: " . $issue['user_id']; exit;

// Step 3: Check ownership
if ($issue['user_id'] != $user_id) {
    $_SESSION['error'] = "You are not authorized to delete this issue.";
    header("Location: view_issues.php");
    exit;
}

// Step 4: Proceed with deletion
$delete = $conn->prepare("DELETE FROM issues WHERE id = ?");
$delete->bind_param("i", $issue_id);
$delete->execute();

// Step 5: Redirect back to issues page
$_SESSION['success'] = "Issue deleted successfully.";
header("Location: view_issues.php");
exit;
?>
