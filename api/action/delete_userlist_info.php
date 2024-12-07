<?php
if (!isset($_COOKIE['secure_data'])){
    header("Location: /#");
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../config/config.php'; // Adjusted path for config.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id =  isset($_POST['DELETE_ID']) ? trim($_POST['DELETE_ID']) : '';
    $DELETE_FNAME =  isset($_POST['DELETE_FNAME']) ? trim($_POST['DELETE_FNAME']) : '';
    $DELETE_LNAME =  isset($_POST['DELETE_LNAME']) ? trim($_POST['DELETE_LNAME']) : '';

    $sql = $conn-prepare("DELETE FROM user_account WHERE id = :id");
    $sql->bindParam(':id',$id,PDO::PARAM_STR);
    $sql->execute();

    $user_id = $decrypted_array['ID'];
    $action = "Deleted User Account ID : " . $id . " | Full Name : " . $DELETE_FNAME . ' ' . $DELETE_LNAME;

    $logs = $conn->prepare("INSERT INTO logs (USER_ID, ACTION_MADE) VALUES (:user_id, :action)");

    $logs->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $logs->bindParam(':action', $action, PDO::PARAM_STR);
    $logs->execute();

    $response['success'] = true;
    $response['title'] = 'Success';
    $response['message'] = 'User Account Deleted';
    echo json_encode($response);
    exit();

}

