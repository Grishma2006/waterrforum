<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
  die("Unauthorized access.");
}

$comment_id = $_GET['id'] ?? null;
$user_id = $_SESSION['user_id'];

if ($comment_id) {
  // Check if the comment belongs to the logged-in user
  $check = $conn->prepare("SELECT * FROM comments WHERE id = ? AND user_id = ?");
  $check->bind_param("ii", $comment_id, $user_id);
  $check->execute();
  $result = $check->get_result();

  if ($result->num_rows === 1) {
    $conn->query("DELETE FROM comments WHERE id = $comment_id");
    echo "Comment deleted. <a href='view_issues.php'>Go back</a>";
  } else {
    echo "You are not allowed to delete this comment.";
  }
} else {
  echo "Invalid request.";
}
?>
