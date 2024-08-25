<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

// GitHub credentials and repository details
// $token = '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';
// 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

$owner = 'jhudiel20'; // or organization name if applicable
$repo = 'flldc-user-image';

// Define constants for GitHub repository and token
define('GITHUB_REPO', 'jhudiel20/flldc-user-image');
define('GITHUB_TOKEN', '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');

// Check if file is uploaded
if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $file = $_FILES['image'];
    $filePath = $file['tmp_name'];
    $fileName = $file['name'];

    // Read the file content
    $fileContent = file_get_contents($filePath);

    // Encode the content to base64
    $base64Content = base64_encode($fileContent);

    // Prepare the API request
    $apiUrl = 'https://api.github.com/repos/' . GITHUB_REPO . '/contents/images/' . $fileName;
    $data = json_encode([
        'message' => 'Upload ' . $fileName,
        'content' => $base64Content,
    ]);

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: token ' . GITHUB_TOKEN,
        'User-Agent: PHP script access',
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        // Output curl errors for debugging
        echo json_encode([
            'success' => false,
            'title' => 'Curl Error',
            'message' => curl_error($ch),
        ]);
    } else {
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode == 201) {
            // Successful upload
            echo json_encode([
                'success' => true,
                'title' => 'Success',
                'message' => 'File uploaded successfully.',
            ]);
        } else {
            // Output response for debugging
            echo json_encode([
                'success' => false,
                'title' => 'GitHub API Error',
                'message' => 'Failed to upload file. HTTP Code: ' . $httpCode . ' Response: ' . $response,
            ]);
        }
    }

    curl_close($ch);
} else {
    // Handle the case where no file is uploaded or an error occurred
    $errorMessage = $_FILES['image']['error'] ?? 'No file uploaded';
    echo json_encode([
        'success' => false,
        'title' => 'Upload Error',
        'message' => 'File upload failed. Error Code: ' . $errorMessage,
    ]);
}
