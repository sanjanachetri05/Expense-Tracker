<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        header('Location: index.php');
        exit;
    }

    $id = (int) $_POST['id'];

    $stmt = $conn->prepare('DELETE FROM expenses WHERE id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    header('Location: index.php');
    exit;
}

header('Location: index.php');
exit;

?>
