<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

// Load the GitHub token from the environment variables
$githubToken = getenv('GITHUB_TOKEN');

// Define your GitHub repository and token
$owner = 'jhudiel20'; // GitHub username or organization
$repo = 'flldc-user-image';

// Check if the file to delete is specified
if (isset($_POST['photo_to_delete']) && isset($_POST['ID'])) {
    $fileName = $_POST['photo_to_delete'];
    $id = $_POST['ID'];

    // Prepare the API request URL
    $apiUrl = 'https://api.github.com/repos/' . $owner . '/' . $repo . '/contents/images/' . $fileName;

    // Get the current file SHA (necessary for deletion)
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: token ' . $githubToken,
        'User-Agent: PHP Script',
    ]);

    $response = curl_exec($ch);
    $responseArray = json_decode($response, true);

    if (isset($responseArray['sha'])) {
        $fileSha = $responseArray['sha'];

        // Prepare the API request for deletion
        $deleteData = json_encode([
            'message' => 'Delete ' . $fileName,
            'sha' => $fileSha,
        ]);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $deleteData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: token ' . $githubToken,
            'User-Agent: PHP Script',
            'Content-Type: application/json',
        ]);

        $deleteResponse = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Update database and log the action if successful
        if ($httpCode == 200) {
            $user_id = $decrypted_array['ID'];
            $sql = "UPDATE user_account SET image = '' WHERE id = :user_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            $action = "Deleted picture for User ID: " . $id;
            $logs = $conn->prepare("INSERT INTO logs (USER_ID, ACTION_MADE) VALUES (:user_id, :action)");
            $logs->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $logs->bindParam(':action', $action, PDO::PARAM_STR);
            $logs->execute();

            echo json_encode([
                'success' => true,
                'title' => 'Success',
                'message' => 'File deleted successfully.',
            ]);
        } else {
            // Output response for debugging
            echo json_encode([
                'success' => false,
                'title' => 'GitHub API Error',
                'message' => 'Failed to delete file. HTTP Code: ' . $httpCode . ' Response: ' . $deleteResponse,
            ]);
        }
    } else {
        // Handle the case where file SHA is not found
        echo json_encode([
            'success' => false,
            'title' => 'GitHub API Error',
            'message' => 'File not found or unable to retrieve SHA.',
        ]);
    }

    curl_close($ch);
} else {
    // Handle the case where no file is specified
    echo json_encode([
        'success' => false,
        'title' => 'Delete Error',
        'message' => 'No file specified for deletion.',
    ]);
}