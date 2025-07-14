<?php
include 'db_config.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>All Reported Issues</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Water Issues Reported by Community</h2>

    <?php if (isset($_SESSION['user_id'])): ?>
      <p>Welcome, <?= $_SESSION['user_name'] ?> | <a href="index.php">Home</a> | <a href="logout.php">Logout</a></p>
    <?php else: ?>
      <p><a href="login.php">Login</a> or <a href="register.php">Register</a> to comment.</p>
    <?php endif; ?>

    <?php
    $result = $conn->query("SELECT * FROM issues ORDER BY created_at DESC");
    while ($row = $result->fetch_assoc()):
    ?>
      <div class="card">
        <h3><?= htmlspecialchars($row['title']) ?></h3>
        <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
        <small><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?> | 
               <strong>Category:</strong> <?= htmlspecialchars($row['category']) ?></small><br>
        <?php if ($row['image']): ?>
          <img src="uploads/<?= $row['image'] ?>" width="300"><br>
        <?php endif; ?>
        <small><em>Posted on <?= $row['created_at'] ?></em></small>

        <!-- Comments Section -->
        <?php
        $issue_id = $row['id'];
        $comments = $conn->query("SELECT c.comment, u.name, c.created_at 
                                  FROM comments c 
                                  JOIN users u ON c.user_id = u.id 
                                  WHERE c.issue_id = $issue_id 
                                  ORDER BY c.created_at DESC");
        ?>

        <?php if ($comments->num_rows > 0): ?>
          <div class="comments">
            <strong>Comments:</strong>
            <?php while ($c = $comments->fetch_assoc()): ?>
              <p><strong><?= htmlspecialchars($c['name']) ?>:</strong> 
              <?= htmlspecialchars($c['comment']) ?><br>
              <small><?= $c['created_at'] ?></small></p>
            <?php endwhile; ?>
          </div>
        <?php endif; ?>

        <!-- Add Comment Form -->
        <?php if (isset($_SESSION['user_id'])): ?>
          <form action="comment.php" method="POST">
            <input type="hidden" name="issue_id" value="<?= $issue_id ?>">
            <textarea name="comment" placeholder="Add your comment..." required></textarea>
            <button type="submit">Post Comment</button>
          </form>
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  </div>
</body>
</html>
