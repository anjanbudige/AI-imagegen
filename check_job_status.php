<?php
include("db.php");
$job = $_POST["job"];
$prompt = $_POST["prompt"];
$path = $_POST["currentPath"];
$jobUrl = "https://api.prodia.com/v1/job/" . $job;
$headers = [
    "X-Prodia-Key: 582c7bd4-eece-416a-9b58-1a5a78fc005d"
];

$ch = curl_init($jobUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$responseJob = curl_exec($ch);
$statusCodeJob = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

// Check if the request was successful (status code 200)
if ($statusCodeJob == 200) {
    // Parse the JSON response
    $jobData = json_decode($responseJob, true);

    // Extract imageUrl and status
    $imageUrl = $jobData['imageUrl'] ?? null;
    $status = $jobData['status'] ?? null;

    if ($imageUrl) {
        echo json_encode(["imageUrl" => $imageUrl, "status" => "successed"]);
        $sql = "INSERT INTO imagegen (team_name,prompt,image) VALUES ('$path','$prompt','$imageUrl')";
        $conn->query($sql);
        exit;
    } elseif ($status === "failed") {
        echo json_encode(["status" => "failed"]);
        exit;
    } else {
        echo json_encode(["status" => "pending"]);
        exit;
    }
} else {
    echo json_encode(["error" => "Job request failed with status code: $statusCodeJob"]);
    exit;
}
?>
