<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; 
require_once __DIR__ . '/../../public/config/config.php';

$uploaded_item_name = isset($_POST['uploaded_item_name']) ? trim($_POST['uploaded_item_name']) : '';

// Load the GitHub token from environment variables
$githubToken = getenv('GITHUB_TOKEN');

// GitHub repository and token details
$owner = getenv('GITHUB_OWNER'); // GitHub username or organization
$repo = getenv('GITHUB_IMAGES');

$fileMimes = ['image/gif', 'image/jpeg', 'image/jpg', 'application/pdf', 'image/png'];

if (empty($_FILES['attach']['name'])) {
    echo json_encode(['success' => false, 'title' => 'Warning!', 'message' => 'Please select a file.']);
    exit();
}

// File upload handling
if (isset($_FILES['attach']) && $_FILES['attach']['error'] == UPLOAD_ERR_OK) {
    if (in_array($_FILES['attach']['type'], $fileMimes)) {
        $id = $_POST['ID'];
        $file = $_FILES['attach'];
        $fileSize = $file['size'];
        $filePath = $file['tmp_name'];
        $fileName = $file['name'];


        // Check if the file size exceeds the limit
        if ($fileSize > 100 * 1024 * 1024) { // 100 MB limit for GitHub API
            echo json_encode(['success' => false, 'title' => 'Error', 'message' => 'File size too large.']);
            exit();
        }
        $fileName = str_replace(' ', '-', $fileName);
        // Read and encode the file content to base64
        $fileContent = file_get_contents($filePath);
        $base64Content = base64_encode($fileContent);

        // Prepare the API request
        $apiUrl = 'https://api.github.com/repos/' . $owner . '/' . $repo . '/contents/PO_ATTACHMENTS/' . urlencode($fileName);
        $data = json_encode(['message' => 'Upload ' . $fileName, 'content' => $base64Content]);

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: token ' . $githubToken,
            'User-Agent: PHP Script',
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo json_encode(['success' => false, 'title' => 'Curl Error', 'message' => curl_error($ch)]);
        } else {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpCode == 201) {
                $fileName = urlencode($fileName);
                // Successful upload
                $sql = "UPDATE purchase_order SET attachments = :file WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':file', $fileName);
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                $user_id = $decrypted_array['ID'];
                $action = "Uploaded Purchase Order Attachments in Item Name: " . $uploaded_item_name;
                $logs = $conn->prepare("INSERT INTO logs (USER_ID, ACTION_MADE) VALUES (:user_id, :action)");

                $logs->bindParam(':user_id', $user_id, PDO::PARAM_STR);
                $logs->bindParam(':action', $action, PDO::PARAM_STR);
                $logs->execute();

                echo json_encode(['success' => true, 'title' => 'Success', 'message' => 'File uploaded successfully.']);
            } elseif ($httpCode == 413) {
                echo json_encode(['success' => false, 'title' => 'Error', 'message' => 'File size too large.']);
            } else {
                echo json_encode(['success' => false, 'title' => 'GitHub API Error', 'message' => 'Failed to upload file. HTTP Code: ' . $httpCode . ' Response: ' . $response]);
            }
        }
        curl_close($ch);
    } else {
        echo json_encode(['success' => false, 'title' => 'Error', 'message' => 'Please insert a valid format! (jpg, png, jpeg, gif, pdf)']);
        exit();
    }
} else {
    $errorMessage = $_FILES['attach']['error'] ?? 'No file uploaded';
    echo json_encode(['success' => false, 'title' => 'Upload Error', 'message' => 'File upload failed. Error Code: ' . $errorMessage]);
}
?>
