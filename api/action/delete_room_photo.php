<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../config/config.php'; // Adjusted path for config.php

// Load the GitHub token from the environment variables
$githubToken = getenv('GITHUB_TOKEN');

// Define your GitHub repository and token
$owner = getenv('GITHUB_OWNER'); // GitHub username or organization
$repo = getenv('GITHUB_IMAGES'); 
$fileMimes = ['image/gif', 'image/jpeg', 'image/jpg', 'image/png'];

if(empty($_POST['item_to_delete'])){
    echo json_encode([
        'success' => false,
        'title' => 'Warning!',
        'message' => 'File does not exist',
    ]);
    exit();
}

// Check if file is uploaded
if (isset($_POST['item_to_delete']) && isset($_POST['ID'])) {
        $id = $_POST['ID'];
        $room_id = $_POST['room_id'];
        $fileName = $_POST['item_to_delete'];        
        $fileName = str_replace(' ', '-', $fileName);

        // Prepare the API request
        $apiUrl = 'https://api.github.com/repos/' . $owner . '/' . $repo . '/contents/room-photo/' . $fileName;

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: token ' . $githubToken,  // Use the token from the environment variable
            'User-Agent: PHP Script',
            'Content-Type: application/json',
        ]);

        $response = curl_exec($ch);
        $responseArray = json_decode($response, true);
    
        if (isset($responseArray['sha'])) {
            $fileSha = $responseArray['sha'];
    
            // Prepare the API request for deletion
            $deleteData = json_encode([
                'message' => 'Delete Room Photo' . $fileName,
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
                $sql = "UPDATE room_details SET room_photo = '' WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
    
                $user_id = $decrypted_array['ID'];
                $action = "Deleted Room Photo in Room ID : " . $room_id;
                $logs = $conn->prepare("INSERT INTO logs (USER_ID, ACTION_MADE) VALUES (:user_id, :action)");
        
                $logs->bindParam(':user_id', $user_id, PDO::PARAM_STR);
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
    // Handle the case where no file is uploaded or an error occurred
    $errorMessage = $_FILES['item_to_delete']['error'] ?? 'No file uploaded';
    echo json_encode([
    'success' => false,
    'title' => 'Upload Error',
    'message' => 'File upload failed. Error Code: ' . $errorMessage,
    ]);
}
