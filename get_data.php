<?php
include 'db.php';

$query = "SELECT category, SUM(amount) as total FROM expenses GROUP BY category";
$result = $conn->query($query);

$data = [];
while($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>