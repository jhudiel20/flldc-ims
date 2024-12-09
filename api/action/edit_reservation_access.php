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
    
$id = isset($_POST['access_id']) ? trim($_POST['access_id']) : '';
$user = isset($_POST['user']) ? trim($_POST['user']) : '';
$new_access = isset($_POST['new_access']) ? trim($_POST['new_access']) : '';
$old_access = isset($_POST['old_access']) ? trim($_POST['old_access']) : '';


if ($new_access == '' || $old_access == '' || $id == '' ) {
    $response['message'] = 'Please fill up all fields with (*) asterisk!';
    echo json_encode($response);
    exit();
}

$sql = $conn->prepare("UPDATE user_account SET reservation_access = :reservation_access WHERE ID = :id ");
$sql->bindParam(':reservation_access', $new_access, PDO::PARAM_STR);
$sql->bindParam(':id', $id, PDO::PARAM_STR);
$sql->execute();


$user_id = $decrypted_array['ID'];
$action = "Updated User Room Acess | User " . $user ." | Reservation Access : ".$new_access;
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