<?php
session_start();
include 'db_config.php';

// Step 1: Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "You must be logged in to delete a comment.";
    header("Location: login.php");
    exit;
}

// Step 2: Check if comment ID is provided
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "Comment ID is missing.";
    header("Location: view_issues.php");
    exit;
}

$comment_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Step 3: Fetch the comment from the database
$stmt = $conn->prepare("SELECT user_id FROM comments WHERE id = ?");
$stmt->bind_param("i", $comment_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Comment not found.";
    header("Location: view_issues.php");
    exit;
}

$comment = $result->fetch_assoc();

// Step 4: Verify ownership
if ($comment['user_id'] != $user_id) {
    $_SESSION['error'] = "You are not authorized to delete this comment.";
    header("Location: view_issues.php");
    exit;
}

// Step 5: Delete the comment
$delete = $conn->prepare("DELETE FROM comments WHERE id = ?");
$delete->bind_param("i", $comment_id);
$delete->execute();

// Step 6: Redirect back with success message
$_SESSION['success'] = "Comment deleted successfully.";
header("Location: view_issues.php");
exit;
?>
