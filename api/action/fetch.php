<?php

$owner = getenv('GITHUB_OWNER');
$repo = getenv('GITHUB_IMAGES');
$githubToken = getenv('GITHUB_TOKEN'); // Make sure your GitHub token is set securely

$db = $_GET['db'];
$fileName = $_GET['file'];

// GitHub API URL to fetch the file metadata
$apiUrl = "https://api.github.com/repos/$owner/$repo/contents/$db/" . $fileName;

// Initialize cURL
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: token ' . $githubToken,
    'User-Agent: PHP Script',
    'Accept: application/vnd.github.v3.raw'
]);

// Execute the request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Check if the request was successful
if ($httpCode == 200) {
    // Decode the JSON response to get the content in base64
    $responseData = json_decode($response, true);

    if (isset($responseData['content'])) {
        // Decode the base64 content
        $fileContent = base64_decode($responseData['content']);

        // Determine the file type based on the file extension
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Set appropriate headers for PDF or image
        if ($fileExtension === 'pdf') {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . basename($fileName) . '"');
        } elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $mimeType = mime_content_type_from_string($fileContent); // Custom function to determine MIME type from string content
            header('Content-Type: ' . $mimeType);
            header('Content-Disposition: inline; filename="' . basename($fileName) . '"');
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

/**
 * Custom function to determine MIME type from the content string
 * @param string $content
 * @return string
 */
function mime_content_type_from_string($content) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_buffer($finfo, $content);
    finfo_close($finfo);
    return $mimeType;
}
?>
