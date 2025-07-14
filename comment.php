<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
  echo "You must be logged in to comment. <a href='login.php'>Login here</a>";
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $issue_id = $_POST['issue_id'];
  $user_id = $_SESSION['user_id'];
  $comment = trim($_POST['comment']);

  if (!empty($comment)) {
    $stmt = $conn->prepare("INSERT INTO comments (issue_id, user_id, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $issue_id, $user_id, $comment);

    if ($stmt->execute()) {
      echo "Comment posted successfully! <a href='view_issues.php'>Back to issues</a>";
    } else {
      echo "Error: " . $stmt->error;
    }
  } else {
    echo "Comment cannot be empty.";
  }
} else {
  echo "Invalid access.";
}
?>
