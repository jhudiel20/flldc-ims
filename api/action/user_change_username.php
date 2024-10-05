<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$user_id = isset($_POST['id']) ? trim($_POST['id']) : '';
$currentusername = isset($_POST['currentusername']) ? trim($_POST['currentusername']) : '';
$username = isset($_POST['username']) ? trim($_POST['username']) : '';

    // Validate user_id
    if (empty($user_id) || !is_numeric($user_id)) {
        $response['success'] = false;
        $response['title'] = "Error!";
        $response['message'] = 'Invalid user ID!'.$user_id;
        echo json_encode($response);
        exit();
    }

    $db_username = $conn->prepare("SELECT username FROM user_account WHERE ID = :user_id");
    $db_username->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $db_username->execute();
    $row_username = $db_username->fetch(PDO::FETCH_ASSOC);

if($row_username['username'] !== $currentusername){
    $response['success'] = false;
    $response['title'] = "Error!";
    $response['message'] = 'Current username doesnt match to your existing username!';
        echo json_encode($response);
        exit();
}

if($row_username['username'] === $username){
    $response['success'] = false;
    $response['title'] = "Error!";
    $response['message'] = 'Please enter new username!';
        echo json_encode($response);
        exit();
}

if(strlen($username) < 8){
    $response['success'] = false;
    $response['title'] = "Error!";
    $response['message'] = 'Username must be at least 8 characters in length!';
    echo json_encode($response);
    exit();
}
$verify = "SELECT username FROM user_account";
$verify = $conn->prepare($verify);
$verify->execute();

while ($row_sql = $verify->fetch(PDO::FETCH_ASSOC)) {
    if ($row_sql['username'] == $username) {
        $response['success'] = false;
        $response['title'] = "Error!";
        $response['message'] = 'Username already taken!';
        echo json_encode($response);
        exit();
    }
}



$sql = "UPDATE user_account SET username = :username WHERE id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

$action = "Change Username : User # " . $user_id . " | Full Name : ".$decrypted_array['FNAME'] .' '.$decrypted_array['MNAME'] .' '.$decrypted_array['LNAME'];
$user_id = $decrypted_array['ID'];
$logs = $conn->prepare("INSERT INTO logs (USER_ID, ACTION_MADE) VALUES (:user_id, :action)");

$logs->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$logs->bindParam(':action', $action, PDO::PARAM_STR);
$logs->execute();

$response['success'] = true;
$response['title'] = 'Success';
$response['message'] = 'Successfully Updated!';
echo json_encode($response);
exit();
}