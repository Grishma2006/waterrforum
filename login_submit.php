<?php
session_start();
include 'db_config.php';

$email = $_POST['email'];
$password = $_POST['password'];

$result = $conn->query("SELECT * FROM users WHERE email = '$email'");
if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();
  if (password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name']; // For greeting
    header("Location: index.php"); // Redirect to homepage
    exit();
  } else {
    echo "Incorrect password.";
  }
} else {
  echo "User not found.";
}
?>
