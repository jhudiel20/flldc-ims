<?php
// Your GitHub personal access token
$githubToken = getenv('GITHUB_TOKEN');// Use your GitHub token securely

$apiUrl = 'https://raw.githubusercontent.com/jhudiel20/flldc-user-image/main/PO_ATTACHMENTS/' . $_GET['file'];

// Initialize cURL
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: token ' . $githubToken,
    'User-Agent: PHP Script',
    'Accept: application/vnd.github.v3+json'
]);

// Execute the request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($httpCode == 200) {
    // Decode the JSON response
    $responseData = json_decode($response, true);

    // Get the download URL
    $downloadUrl = $responseData['download_url'];

    // Fetch the actual file content using the download URL
    $fileContent = file_get_contents($downloadUrl);

    if ($fileContent !== false) {
        // Determine the file type based on the file extension
        $fileExtension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        // Set appropriate headers for PDF or image
        if ($fileExtension === 'pdf') {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . basename($path) . '"');
        } elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $mimeType = mime_content_type($downloadUrl); // Get MIME type
            header('Content-Type: ' . $mimeType);
            header('Content-Disposition: inline; filename="' . basename($path) . '"');
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo "Error: Unsupported file type.";
            exit;
        }

        // Output the file content
        echo $fileContent;
    } else {
        echo 'Error: Unable to fetch the actual file content.';
    }
} else {
    // Handle errors
    header('HTTP/1.1 404 Not Found');
    echo "Error: Unable to fetch file from GitHub API. HTTP Code: $httpCode";
}

curl_close($ch);
?>
