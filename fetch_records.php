<?php
include("db.php");
// Fetch the latest records
$sql = "SELECT id, team_name,prompt, image FROM imagegen ORDER BY id DESC"; // Adjust the query as needed
$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Return the data as JSON
echo json_encode($data);

$conn->close();
?>
