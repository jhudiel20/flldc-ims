<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../config/config.php'; // Adjusted path for config.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$code = isset($_POST['code']) ? trim($_POST['code']) : '';
$confirmpassword = isset($_POST['confirmpassword']) ? trim($_POST['confirmpassword']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if($password == ""){
    $response['icon'] = "error";
    $response['success'] = false;
    $response['message'] = 'Please enter password!';
    echo json_encode($response);
    exit();
}

if($confirmpassword != $password){
    $response['success'] = false;
    $response['title'] = "Error!";
    $response['message'] = 'Password did not match!';
    echo json_encode($response);
    exit();
}
if(!preg_match('@[A-Z]@',$password)){
    $response['success'] = false;
    $response['title'] = "Error!";
    $response['message'] = 'Password must include at least one Uppercase Letter!';
    echo json_encode($response);
    exit();
}
if(!preg_match('@[a-z]@',$password)){
    $response['success'] = false;
    $response['title'] = "Error!";
    $response['message'] = 'Password must include at least one Lowercase Letter!';
    echo json_encode($response);
    exit();
}
if(!preg_match('@[0-9]@',$password)){
    $response['success'] = false;
    $response['title'] = "Error!";
    $response['message'] = 'Password must include at least one Number!';
    echo json_encode($response);
    exit();
}
if(strlen($password) < 8){
    $response['success'] = false;
    $response['title'] = "Error!";
    $response['message'] = 'Password must be at least 8 characters in length!';
    echo json_encode($response);
    exit();
}

    $password = set_password($password);
    $sql_check_token = $conn->prepare("SELECT RESET_TOKEN, RESET_TIME FROM user_account WHERE RESET_TOKEN = :code AND RESET_TIME > (now() - interval 1 day) ");
    $sql_check_token->bindParam(':code', $code, PDO::PARAM_INT);
    $sql_check_token->execute();

if ($sql_check_token->rowCount() == 0) {
    $response['icon'] = "error";
    $response['success'] = false;
    $response['title'] = "Expired Token";
    $response['message'] = 'Please Request Change Password Again!';
    echo json_encode($response);
    exit();
}else{

    $change_pass = $conn->prepare("UPDATE user_account SET password = :password WHERE RESET_TOKEN = :code AND RESET_TIME > (now() - interval 1 day) ");
    $change_pass->bindParam(':password', $password, PDO::PARAM_INT);
    $change_pass->bindParam(':code', $code, PDO::PARAM_INT);
    $change_pass->execute();

    $query_email = $conn->prepare("SELECT EMAIL FROM user_account WHERE RESET_TOKEN = :code ");
    $query_email->bindParam(':code', $code, PDO::PARAM_INT);
    $query_email->execute();
    $row_email = $query_email->fetch(PDO::FETCH_ASSOC);

    $user_id = '0';
    $action = "Change Password : Email : " . $row_email['EMAIL'];

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
}
