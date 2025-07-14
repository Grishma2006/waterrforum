<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="form-box">
    <h2>Login</h2>
    <form method="POST" action="login_submit.php">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
      <p>Don’t have an account? <a href="register.php">Register</a></p>
    </form>
  </div>
</body>
</html>
