<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

// Get the image file name from the query parameter
$fileName = $_GET['file'] ?? 'user.png'; // Fallback to a default image if no file specified

// Ensure the file name is sanitized
$fileName = basename($fileName);

$githubToken = getenv('GITHUB_TOKEN');// Use your GitHub token securely

// GitHub API URL
$apiUrl = 'https://api.github.com/repos/jhudiel20/flldc-user-image/contents/images/' . $fileName;

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: token ' . $githubToken,
    'User-Agent: PHP Script',
]);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$imageUrl = $data['download_url'] ?? 'user.png';

// Fetch the image content
$imageContent = file_get_contents($imageUrl);

// Set the appropriate content type header
header('Content-Type: ' . mime_content_type($imageUrl));
echo $imageContent;
?>