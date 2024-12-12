<?php
if (!isset($_COOKIE['secure_data'])){
    header("Location: /");
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../config/config.php'; // Adjusted path for config.php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
$roomId = isset($_POST['ROOMID']) ? trim($_POST['ROOMID']) : '';
$roomName = isset($_POST['ROOMNAME']) ? trim($_POST['ROOMNAME']) : '';
$roomStatus = isset($_POST['STATUS']) ? trim($_POST['STATUS']) : '';

if ($roomStatus == '' ) {
    $response['message'] = 'Please fill up all fields with (*) asterisk!';
    echo json_encode($response);
    exit();
}

$sql = $conn->prepare("UPDATE room_details SET status = :status WHERE ID = :id ");
$sql->bindParam(':status', $roomStatus, PDO::PARAM_STR);
$sql->bindParam(':id', $roomId, PDO::PARAM_STR);
$sql->execute();


$user_id = $decrypted_array['ID'];
$action = "Updated Room Status | Room Name : " . $roomName ." | Status : ".$roomStatus;
$logs = $conn->prepare("INSERT INTO logs (USER_ID, ACTION_MADE) VALUES (:user_id, :action)");
$logs->bindParam(':user_id', $user_id, PDO::PARAM_STR);
$logs->bindParam(':action', $action, PDO::PARAM_STR);
$logs->execute();

$response['success'] = true;
$response['title'] = 'Success';
$response['message'] = 'Successfully Updated!';
echo json_encode($response);
exit();

}