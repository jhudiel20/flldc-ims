<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

// PHPMailer integration
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Function to get the sha of an existing file from GitHub
function getGitHubFileSha($owner, $repo, $filePath, $githubToken) {
    $apiUrl = "https://api.github.com/repos/$owner/$repo/contents/$filePath";
    
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: token ' . $githubToken,
        'User-Agent: PHP script access',
        'Content-Type: application/json'
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {
        $responseArray = json_decode($response, true);
        return $responseArray['sha'] ?? null;
    }

    return null;
}

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get POST data and sanitize inputs
    $ITEM_NAME = isset($_POST['item_name']) ? trim($_POST['item_name']) : '';
    $QUANTITY = isset($_POST['quantity']) ? trim($_POST['quantity']) : '';
    $REMARKS = isset($_POST['remarks']) ? trim($_POST['remarks']) : '';
    $PURPOSE = isset($_POST['purpose']) ? trim($_POST['purpose']) : '';
    $DESCRIPTION = isset($_POST['description']) ? trim($_POST['description']) : '';
    $DATE_NEEDED = isset($_POST['date_needed']) ? trim($_POST['date_needed']) : '';
    $EMAIL = isset($_POST['email']) ? trim($_POST['email']) : '';

    // Sanitize item name
    $ITEM_NAME = str_replace("'", "", $ITEM_NAME);

    // Generate a unique request ID
    $generate_REQUEST_ID = generate_REQUEST_ID();

    // Validate required fields
    if ($ITEM_NAME == '' || $QUANTITY == '' || $DATE_NEEDED == '') {
        $response['message'] = 'Please fill up all fields with (*) asterisk!';
        echo json_encode($response);
        exit();
    }
    
    $current_access = $decrypted_array['ACCESS'];

    // Check if email is provided for admins
    if ($current_access === 'ADMIN') {
        if ($EMAIL == '') {
            $response['title'] = 'Warning!';
            $response['message'] = 'Please enter the email of requestor!';
            echo json_encode($response);
            exit();
        }
    } else {
        if ($EMAIL == '') {
            $response['title'] = 'Warning!';
            $response['message'] = 'Please enter the email of requestor!';
            echo json_encode($response);
            exit();
        } else {
            $EMAIL = $current_access;
        }
    }

    $githubToken = getenv('GITHUB_TOKEN');

    if (!isset($_FILES['item_photo']) || $_FILES['item_photo']['error'] != UPLOAD_ERR_OK) {
        $response['title'] = 'Error';
        $response['message'] = 'File upload failed.';
        echo json_encode($response);
        exit();
    }

    $owner = 'jhudiel20'; // GitHub username or organization
    $repo = 'flldc-user-image';

    $img = $_FILES['item_photo'];
    $img_temp_loc = $img['tmp_name'];
    $fileName = $img['name'];

    $fileContent = file_get_contents($img_temp_loc);
    if ($fileContent === false) {
        $response['title'] = 'Error';
        $response['message'] = 'Failed to read the uploaded file.';
        echo json_encode($response);
        exit();
    }

    $base64Content = base64_encode($fileContent);
    $fileName = urlencode($img['name']); // URL-encode the file name
    $filePath = "requested-items/" . $fileName;

    // Check if the file exists on GitHub and get its sha if it does
    $fileSha = getGitHubFileSha($owner, $repo, $filePath, $githubToken);

    // Prepare the API request for uploading or updating the file
    $data = [
        'message' => 'Upload image: ' . $fileName,
        'content' => $base64Content,
    ];

    if ($fileSha !== null) {
        $data['sha'] = $fileSha; // Add sha if the file exists
    }

    $data = json_encode($data);

    $apiUrl = "https://api.github.com/repos/$owner/$repo/contents/$filePath";
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: token ' . $githubToken,
        'User-Agent: PHP script access',
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Print the raw response for debugging purposes
    echo "Raw API Response: " . $response . "\n";

    // Stop the script execution here to inspect the response
    exit();

    if ($httpCode != 201) { // 201 is the expected status code for a successful file creation in GitHub
        $response['title'] = 'Error';
        $response['message'] = 'GitHub API returned an error: ' . $response;
        echo json_encode($response);
        exit();
    }

    // Prepare the INSERT statement for purchase_order
    $sql_purchase_order = $conn->prepare("
        INSERT INTO purchase_order(REQUEST_ID, ITEM_NAME, QUANTITY, REMARKS, EMAIL, PURPOSE, DATE_NEEDED, DESCRIPTION) 
        VALUES(:request_id, :item_name, :quantity, :remarks, :email, :purpose, :date_needed, :description)
    ");

    // Bind the parameters to the prepared statement
    $sql_purchase_order->bindParam(':request_id', $generate_REQUEST_ID, PDO::PARAM_STR);
    $sql_purchase_order->bindParam(':item_name', $ITEM_NAME, PDO::PARAM_STR);
    $sql_purchase_order->bindParam(':quantity', $QUANTITY, PDO::PARAM_STR);
    $sql_purchase_order->bindParam(':remarks', $REMARKS, PDO::PARAM_STR);
    $sql_purchase_order->bindParam(':email', $EMAIL, PDO::PARAM_STR);
    $sql_purchase_order->bindParam(':purpose', $PURPOSE, PDO::PARAM_STR);
    $sql_purchase_order->bindParam(':date_needed', $DATE_NEEDED, PDO::PARAM_STR);
    $sql_purchase_order->bindParam(':description', $DESCRIPTION, PDO::PARAM_STR);

    // Execute the prepared statement
    $sql_purchase_order->execute();

    $sql = "UPDATE purchase_order SET item_photo = :img WHERE request_id = :request_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':img', $fileName);
    $stmt->bindParam(':request_id', $generate_REQUEST_ID);
    $stmt->execute();

    // Prepare and execute INSERT statement for po_history
    $history_title = "Request Created";
    $history_remarks = "Created by Email : " . $EMAIL . "\n" . "Request ID : " . $generate_REQUEST_ID . "\n" . "Request Item: " . $ITEM_NAME . "\n" . "Quantity : " . $QUANTITY .
    "\n" . "Purpose : " . $PURPOSE . "\n" . "Date Needed : " . $DATE_NEEDED . "\n" . "Remarks : " . $REMARKS . 
    "\n" . "Description : " . $DESCRIPTION;

    $sql_history = $conn->prepare("INSERT INTO po_history (REQUEST_ID, TITLE, REMARKS) 
    VALUES (?, ?, ?)");
    $sql_history->execute([$generate_REQUEST_ID, $history_title, $history_remarks]);

    // Log the action
    $action = "Added New Request | Request ID : " . $generate_REQUEST_ID . " | Item Name : " . $ITEM_NAME;
    $user_id = $decrypted_array['ID'];

    if (isset($decrypted_array['ID']) && is_numeric($decrypted_array['ID'])) {
        $user_id = (int)$decrypted_array['ID'];
    } else {
        // Handle the case where ID is missing or invalid
        $response['success'] = false;
        $response['message'] = 'Invalid user ID.';
        echo json_encode($response);
        exit();
    }

    $logs = $conn->prepare("INSERT INTO logs (USER_ID, ACTION_MADE) VALUES (:user_id, :action)");
    $logs->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $logs->bindParam(':action', $action, PDO::PARAM_STR);
    $logs->execute();

    // Respond to the client
    $response['title'] = 'Success!';
    $response['message'] = 'You have successfully added a new request.';
    echo json_encode($response);
}
?>
