<?php
include 'db_config.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Reported Issues</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .container {
      width: 90%;
      margin: auto;
      font-family: Arial, sans-serif;
    }
    .card {
      background: #f5f5f5;
      padding: 15px;
      margin: 15px 0;
      border-radius: 10px;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
    }
    .card img {
      max-width: 100%;
      margin-top: 10px;
    }
    textarea {
      width: 100%;
      height: 60px;
      margin-top: 10px;
    }
    button, .delete-btn {
      padding: 6px 12px;
      margin-top: 6px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
    }
    button:hover, .delete-btn:hover {
      opacity: 0.9;
    }
    .comments {
      background: #fff;
      padding: 10px;
      margin-top: 15px;
      border-left: 4px solid #3498db;
    }
    .comments p {
      font-size: 14px;
      margin: 8px 0;
    }
    .delete-btn {
      background: red;
      color: white;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Community Reported Water Issues</h2>

    <?php if (isset($_SESSION['user_id'])): ?>
      <p>Welcome, <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?> |
      <a href="index.php">Home</a> | <a href="logout.php">Logout</a></p>
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
        <small>
          <strong>Location:</strong> <?= htmlspecialchars($row['location']) ?> |
          <strong>Category:</strong> <?= htmlspecialchars($row['category']) ?> |
          <em>Posted on <?= $row['created_at'] ?></em>
        </small><br>

        <?php if (!empty($row['image'])): ?>
          <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="Issue Image">
        <?php endif; ?>

        <!-- Delete Issue Button -->
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['user_id']): ?>
          <form action="delete_issue.php" method="GET" onsubmit="return confirm('Delete this issue?');">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <button class="delete-btn" type="submit">Delete Issue</button>
          </form>
        <?php endif; ?>

        <!-- Display Comments -->
        <?php
        $issue_id = $row['id'];
        $comments = $conn->query("SELECT c.id, c.comment, c.user_id, u.name, c.created_at 
                                  FROM comments c 
                                  JOIN users u ON c.user_id = u.id 
                                  WHERE c.issue_id = $issue_id 
                                  ORDER BY c.created_at DESC");
        ?>

        <?php if ($comments->num_rows > 0): ?>
          <div class="comments">
            <strong>Comments:</strong>
            <?php while ($c = $comments->fetch_assoc()): ?>
              <p>
                <strong><?= htmlspecialchars($c['name']) ?>:</strong>
                <?= htmlspecialchars($c['comment']) ?><br>
                <small><?= $c['created_at'] ?></small>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $c['user_id']): ?>
                  <form action="delete_comment.php" method="GET" style="display:inline;" onsubmit="return confirm('Delete this comment?');">
                    <input type="hidden" name="id" value="<?= $c['id'] ?>">
                    <button type="submit" class="delete-btn" style="font-size:12px;padding:2px 6px;">Delete</button>
                  </form>
                <?php endif; ?>
              </p>
            <?php endwhile; ?>
          </div>
        <?php endif; ?>

        <!-- Comment Form -->
        <?php if (isset($_SESSION['user_id'])): ?>
          <form action="comment.php" method="POST">
            <input type="hidden" name="issue_id" value="<?= $row['id'] ?>">
            <textarea name="comment" placeholder="Add your comment..." required></textarea>
            <button type="submit" style="background:#3498db;color:#fff;">Post Comment</button>
          </form>
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  </div>
</body>
</html>
