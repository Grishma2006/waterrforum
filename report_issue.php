<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Report Issue</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="form-box">
    <h2>Report Water Issue</h2>
    <form action="submit_issue.php" method="POST" enctype="multipart/form-data">
      <input type="text" name="title" placeholder="Issue Title" required>
      <textarea name="description" placeholder="Describe the issue..." required></textarea>
      <input type="text" name="category" placeholder="e.g. Leakage, Scarcity" required>
      <input type="text" name="location" placeholder="Location" required>
      <input type="file" name="image">
      <button type="submit">Submit</button>
    </form>
  </div>
</body>
</html>
