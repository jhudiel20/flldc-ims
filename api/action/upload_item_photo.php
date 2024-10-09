<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

// Load the GitHub token from the environment variables
$githubToken = getenv('GITHUB_TOKEN');

// Define your GitHub repository and token
$owner = getenv('GITHUB_OWNER'); // GitHub username or organization
$repo = getenv('GITHUB_IMAGES');
$fileMimes = ['image/gif', 'image/jpeg', 'image/jpg', 'image/png'];

if (empty($_FILES['item_photo']['name'])) {
    echo json_encode(['success' => false, 'title' => 'Warning!', 'message' => 'Please select an image.']);
    exit();
}

// Check if file is uploaded
if (isset($_FILES['item_photo']) && $_FILES['item_photo']['error'] == UPLOAD_ERR_OK) {
        $id = $_POST['ID'];
        $pr_id = $_POST['pr_id'];
        $item_name = $_POST['item_name'];
        $file = $_FILES['item_photo'];
        $filePath = $file['tmp_name'];
        $fileName = $file['name'];
    if (in_array($_FILES['item_photo']['type'], $fileMimes)) {
        

        // Read the file content
        $fileName = str_replace(' ', '-', $fileName);
        $fileContent = file_get_contents($filePath);

        // Encode the content to base64
        $base64Content = base64_encode($fileContent);

        // Prepare the API request
        $apiUrl = 'https://api.github.com/repos/' . $owner . '/' . $repo . '/contents/requested-items/' . $fileName;
        $data = json_encode([
            'message' => 'Upload ' . $fileName,
            'content' => $base64Content,
        ]);

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: token ' . $githubToken,  // Use the token from the environment variable
            'User-Agent: PHP Script',
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);
        
        $sql = "UPDATE purchase_order SET item_photo = :img WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':img', $fileName);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $user_id = $decrypted_array['ID'];
        $action = "Uploaded Item Photo in PR ID. : " . $pr_id;
        $logs = $conn->prepare("INSERT INTO logs (USER_ID, ACTION_MADE) VALUES (:user_id, :action)");

        $logs->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $logs->bindParam(':action', $action, PDO::PARAM_STR);
        $logs->execute();

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
    }else{
        echo json_encode(['success' => false, 'title' => 'Error', 'message' => 'Please insert a valid format! (jpg, png, jpeg, gif)']);
        exit();
    }
} else {
    // Handle the case where no file is uploaded or an error occurred
    $errorMessage = $_FILES['item_photo']['error'] ?? 'No file uploaded';
    echo json_encode([
    'success' => false,
    'title' => 'Upload Error',
    'message' => 'File upload failed. Error Code: ' . $errorMessage,
    ]);
}
