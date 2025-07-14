<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Home - Water Forum</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Welcome to Water Forum</h1>
    <?php if (isset($_SESSION['user_id'])): ?>
      <p>Hello, <?= $_SESSION['user_name'] ?>! <a href="logout.php">Logout</a></p>
      <a class="btn" href="report_issue.php">Report New Issue</a>
      <a class="btn" href="view_issues.php">View All Issues</a>
    <?php else: ?>
      <a class="btn" href="login.php">Login</a>
      <a class="btn" href="register.php">Register</a>
    <?php endif; ?>
  </div>
</body>
</html>
