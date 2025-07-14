<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
  die("Unauthorized access.");
}

$issue_id = $_GET['id'] ?? null;
$user_id = $_SESSION['user_id'];

if ($issue_id) {
  // Check if the user owns the issue
  $check = $conn->prepare("SELECT * FROM issues WHERE id = ? AND user_id = ?");
  $check->bind_param("ii", $issue_id, $user_id);
  $check->execute();
  $result = $check->get_result();

  if ($result->num_rows === 1) {
    // Delete comments first (foreign key constraint workaround)
    $conn->query("DELETE FROM comments WHERE issue_id = $issue_id");

    // Delete the issue
    $conn->query("DELETE FROM issues WHERE id = $issue_id");

    echo "Issue deleted successfully. <a href='view_issues.php'>Go back</a>";
  } else {
    echo "You are not authorized to delete this issue.";
  }
} else {
  echo "Invalid request.";
}
?>
