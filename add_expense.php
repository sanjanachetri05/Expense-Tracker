<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $date = $_POST['date_added'];

    $sql = "INSERT INTO expenses (title, amount, category, date_added) VALUES ('$title', '$amount', '$category', '$date')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); // Redirect back to the main page
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>