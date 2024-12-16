<?php
if (!isset($_COOKIE['secure_data'])){
    header("Location: /");
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../config/config.php'; // Adjusted path for config.php

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get POST data and sanitize inputs
    $roomname = isset($_POST['roomname']) ? trim($_POST['roomname']) : '';
    $price = isset($_POST['price']) ? trim($_POST['price']) : '';
    $roomtype = isset($_POST['roomtype']) ? trim($_POST['roomtype']) : '';
    $capacity = isset($_POST['capacity']) ? trim($_POST['capacity']) : '';
    $floornumber = isset($_POST['floornumber']) ? trim($_POST['floornumber']) : '';
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';
    $features = isset($_POST['features']) ? trim($_POST['features']) : '';
    $usage = isset($_POST['usage']) ? trim($_POST['usage']) : '';
    // $remarks = isset($_POST['remarks']) ? trim($_POST['remarks']) : '';

    // Sanitize item name
    $roomname = str_replace("'", "", $roomname);

    if($capacity == 0){
        $response['message'] = 'Room capacity cannot be Zero!';
        echo json_encode($response);
        exit();
    }
    // Generate a unique request ID
    $generateRoomID = generateRoomID();

    // Validate required fields
    if ($roomname == '' || $roomtype == '' || $capacity == '' || $floornumber == '' || $status == '' || $features == '' || $usage == '' ) {
        $response['message'] = 'Please fill up all fields with (*) asterisk!';
        echo json_encode($response);
        exit();
    }

    $githubToken = getenv('GITHUB_TOKEN');
    $githubOwner= getenv('GITHUB_OWNER');
    $githubImages = getenv('GITHUB_IMAGES');

    if ($_FILES['roomphoto']['name'] == '') {
        $response['message'] = 'Please select a photo';
        $response['title'] = 'Warning!';
        echo json_encode($response);
    }

    if (isset($_FILES['roomphoto']) && $_FILES['roomphoto']['error'] == UPLOAD_ERR_OK) {
        $owner = $githubOwner;// GitHub username or organization
        $repo = $githubImages;

        $img = $_FILES['roomphoto'];
        $img_temp_loc = $img['tmp_name'];
        $fileName = $img['name'];

        $fileName = str_replace(' ', '-', $fileName);
        $fileContent = file_get_contents($img_temp_loc);
        $base64Content = base64_encode($fileContent);

        // Check if the file exists on GitHub and get its sha if it does
        $apiUrl = "https://api.github.com/repos/$owner/$repo/contents/room-photo/$fileName";
        $data = json_encode([
            'message' => 'Upload Room image: ' . $fileName,
            'content' => $base64Content,
        ]);

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

        if (curl_errno($ch)) {
            // Handle cURL errors
            echo json_encode([
                'success' => false,
                'title' => 'Curl Error',
                'message' => curl_error($ch),
            ]);
            curl_close($ch);
            exit();
        }

        // Decode the response
        $responseData = json_decode($response, true);

        // Check for a valid JSON response
        if ($responseData === null && json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode([
                'success' => false,
                'title' => 'GitHub API Error',
                'message' => 'Failed to decode GitHub API response: ' . json_last_error_msg(),
            ]);
            curl_close($ch);
            exit();
        }

        // Check if the file was successfully uploaded
        if (isset($responseData['content']['download_url'])) {
            $img_url = $responseData['content']['download_url'];
        } else {
            echo json_encode([
                'success' => false,
                'title' => 'GitHub API Error',
                'message' => 'Failed to upload image to GitHub. Response: ' . $response,
            ]);
            curl_close($ch);
            exit();
        }


        // Prepare the INSERT statement for purchase_order
        $sql_add_room = $conn->prepare("
            INSERT INTO room_details(ROOM_ID, ROOM_NAME, PRICES, ROOM_TYPE, CAPACITY, FLOOR_NUMBER, STATUS, FEATURES, USAGE, ROOM_PHOTO) 
            VALUES(:room_id, :roomname, :prices, :roomtype, :capacity, :floornumber, :status, :features, :usage, :img)
        ");

        // Bind the parameters to the prepared statement
        $sql_add_room->bindParam(':room_id', $generateRoomID, PDO::PARAM_STR);
        $sql_add_room->bindParam(':roomname', $roomname, PDO::PARAM_STR);
        $sql_add_room->bindParam(':prices', $price, PDO::PARAM_STR);
        $sql_add_room->bindParam(':roomtype', $roomtype, PDO::PARAM_STR);
        $sql_add_room->bindParam(':capacity', $capacity, PDO::PARAM_STR);
        $sql_add_room->bindParam(':floornumber', $floornumber, PDO::PARAM_STR);
        $sql_add_room->bindParam(':status', $status, PDO::PARAM_STR);
        // $sql_add_room->bindParam(':remarks', $remarks, PDO::PARAM_STR);
        $sql_add_room->bindParam(':features', $features, PDO::PARAM_STR);
        $sql_add_room->bindParam(':usage', $usage, PDO::PARAM_STR);
        $sql_add_room->bindParam(':img', $fileName, PDO::PARAM_STR);
        // Execute the prepared statement
        $sql_add_room->execute();

        // Log the action
        $action = "Added New Room | Room ID : " . $generateRoomID . " | Room Name : " . $roomname;
        $user_id = $decrypted_array['ID'];

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
                    'message' => 'Successfully Added',
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
        // Handle the case where no file is uploaded or an error occurred
    $errorMessage = $_FILES['roomphoto']['error'] ?? 'No file uploaded';
    echo json_encode([
        'success' => false,
        'title' => 'Upload Error',
        'message' => 'File upload failed. Error Code: ' . $errorMessage,
    ]);
    }
    
}
?>