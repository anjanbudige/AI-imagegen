<?php
$generateUrl = "https://api.prodia.com/v1/sdxl/generate";
$model = $_POST["model"];

if (isset($_POST["aimodel"])) {
    $aimodel = $_POST["aimodel"];
    $payload = json_encode([
        "prompt" => $_POST["prompt"],
        "style_preset" => $model,
        "steps" => 50,
        "cfg_scale" => 10,
        "sampler" => "DPM++ 2M Karras",
        "model" => $aimodel
    ]);
} else {
    $payload = json_encode([
        "prompt" => $_POST["prompt"],
        "style_preset" => $model,
        "steps" => 50,
        "cfg_scale" => 10,
        "sampler" => "DPM++ 2M Karras"
    ]);
}

$headers = [
    "Content-Type: application/json",
    "X-Prodia-Key: 7d8669a7-494f-40a0-b533-e71be4e4187f"
];

$ch = curl_init($generateUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$responseGenerate = curl_exec($ch);
$statusCodeGenerate = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

// Check if the request was successful (status code 200)
if ($statusCodeGenerate == 200) {
    // Parse the JSON response
    $generateData = json_decode($responseGenerate, true);

    // Extract job
    $job = $generateData['job'] ?? null;

    if ($job) {
        // Send back the job ID and prompt in the response
        echo json_encode(["job" => $job]);
        exit;
    } else {
        echo json_encode(["error" => "No job ID in the generate response."]);
        exit;
    }
} else {
    echo json_encode(["error" => "Generate request failed with status code: $statusCodeGenerate"]);
    exit;
}
?>
