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
    
$id = isset($_POST['ID']) ? trim($_POST['ID']) : '';
$roomid = isset($_POST['roomid']) ? trim($_POST['roomid']) : '';
$roomname = isset($_POST['roomname']) ? trim($_POST['roomname']) : '';
$roomtype = isset($_POST['roomtype']) ? trim($_POST['roomtype']) : '';
$capacity = isset($_POST['capacity']) ? trim($_POST['capacity']) : '';
$floornumber = isset($_POST['floornumber']) ? trim($_POST['floornumber']) : '';
$status = isset($_POST['status']) ? trim($_POST['status']) : '';
$features = isset($_POST['features']) ? trim($_POST['features']) : '';
$usage = isset($_POST['usage']) ? trim($_POST['usage']) : '';

if ($roomname == '' || $roomtype == '' || $capacity == '' || $floornumber == '' || $status == '' || $features == '' || $usage == '' ) {
    $response['message'] = 'Please fill up all fields with (*) asterisk!';
    echo json_encode($response);
    exit();
}
if($capacity == 0){
    $response['message'] = 'Capacity cannot be Zero!';
    echo json_encode($response);
    exit(); 
}

$sql = $conn->prepare("UPDATE room_details SET room_name = :roomname, floor_number = :floornumber,
room_type = :roomtype, capacity = :capacity, status = :status, usage = :usage, features = :features WHERE ID = :id ");
$sql->bindParam(':roomname', $roomname, PDO::PARAM_STR);
$sql->bindParam(':floornumber', $floornumber, PDO::PARAM_STR);
$sql->bindParam(':roomtype', $roomtype, PDO::PARAM_STR);
$sql->bindParam(':capacity', $capacity, PDO::PARAM_STR);
$sql->bindParam(':status', $status, PDO::PARAM_STR);
$sql->bindParam(':usage', $usage, PDO::PARAM_STR);
$sql->bindParam(':features', $features, PDO::PARAM_STR);
$sql->bindParam(':id', $id, PDO::PARAM_STR);
$sql->execute();


$user_id = $decrypted_array['ID'];
$action = "Updated Room Details | Room ID : ".$roomid;
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