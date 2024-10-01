<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$user_id =  isset($_POST['clear_id']) ? trim($_POST['clear_id']) : '';

$sql_query = $conn->prepare("UPDATE user_account SET locked = 0 WHERE id = :user_id ");
$sql_query->bindParam(':user_id',$user_id,PDO::PARAM_STR);
$sql_query->execute();


$sql = $conn->prepare("SELECT fname,mname,lname,ext_name FROM user_account WHERE id = :user_id");
$sql->bindParam(':user_id',$user_id,PDO::PARAM_STR);
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);

$user_id = $decrypted_array['ID'];
$action = "Clear Attempts of the Account :  " . $row['fname'].' '.$row['mname'].' '.$row['lname'].' '.$row['ext_name'];

$logs = $conn->prepare("INSERT INTO logs (USER_ID, ACTION_MADE,DATE_CREATED) VALUES (:user_id, :action,NOW() AT TIME ZONE 'Asia/Manila')");

$logs->bindParam(':user_id', $user_id, PDO::PARAM_STR);
$logs->bindParam(':action', $action, PDO::PARAM_STR);
$logs->execute();


$response['success'] = true;
$response['title'] = 'Success';
$response['message'] = 'Successfully Clear User Attempts!';
echo json_encode($response);
exit();


}

