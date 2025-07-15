<?php
include 'db_config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $issue_id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    // Check ownership
    $check_sql = "SELECT * FROM issues WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $issue_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $issue = $result->fetch_assoc();

        // Delete associated image (if any)
        if (!empty($issue['image']) && file_exists("uploads/" . $issue['image'])) {
            unlink("uploads/" . $issue['image']);
        }

        // Delete associated comments (optional)
        $conn->query("DELETE FROM comments WHERE issue_id = $issue_id");

        // Delete the issue
        $delete_sql = "DELETE FROM issues WHERE id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $issue_id);
        $stmt->execute();

        header("Location: combined_issues.php");
        exit();
    } else {
        echo "You are not authorized to delete this issue.";
    }
} else {
    echo "Invalid request.";
}
?>
