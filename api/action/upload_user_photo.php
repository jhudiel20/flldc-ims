<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

// GitHub credentials and repository details
$token = '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';
$owner = 'jhudiel20'; // or organization name if applicable
$repo = 'flldc-user-image';
$branch = 'main'; // Default branch or the branch you want to upload to

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fileMimes = array(
        'image/gif',
        'image/jpeg',
        'image/jpg',
        'image/png'
    );

    if ($_FILES['image']['name'] == '') {
        $response['message'] = 'Please select a photo';
        $response['title'] = 'Warning!';
        echo json_encode($response);
        exit();
    }

    if (!empty($_FILES['image']['name']) && in_array($_FILES['image']['type'], $fileMimes)) {
        $id = $_POST['ID'];
        $img = $_FILES['image']['name'];
        $img_temp_loc = $_FILES['image']['tmp_name'];

        // Read the file content
        $fileContent = file_get_contents($img_temp_loc);

        // Base64 encode the file content
        $encodedContent = base64_encode($fileContent);

        // GitHub API URL to create or update a file
        $url = "https://api.github.com/repos/$owner/$repo/contents/user_image/$img";

        // Create the cURL request
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: token $token",
            "User-Agent: YourAppName",
            "Content-Type: application/json"
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
            'message' => 'Upload image',
            'content' => $encodedContent,
            'branch' => $branch
        )));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 201) {
            // Success
            $response['success'] = true;
            $response['title'] = 'Success';
            $response['message'] = 'User Picture Updated';
        } else {
            // Failure
            $response['message'] = 'Failed to upload image!';
            $response['title'] = 'Error!';
        }

        echo json_encode($response);
        exit();
    } else {
        $response['message'] = 'PLEASE INSERT VALID FORMAT! (jpg, png, jpeg, gif)';
        $response['title'] = 'Error!';
        echo json_encode($response);
        exit();
    }
}
?>
