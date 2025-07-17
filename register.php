<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Register</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="form-box">
    <h2>Create an Account</h2>
    <form method="POST" action="register_submit.php">
      <input type="text" name="name" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Register</button>
      <p>Already registered? <a href="login.php">Login</a></p>
    </form>
  </div>
</body>
</html>
