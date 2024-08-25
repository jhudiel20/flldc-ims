<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$user_id = isset($_POST['ID']) ? trim($_POST['ID']) : '';
$currentpassword = isset($_POST['currentpassword']) ? trim($_POST['currentpassword']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
$newpassword = isset($_POST['newpassword']) ? trim($_POST['newpassword']) : '';

$currentpassword = set_password($currentpassword);
$checkpassword = set_password($password);

if($decrypted_array['PASSWORD'] !== $currentpassword){
    $response['message'] = 'Current password doesnt match to your existing password!';
        echo json_encode($response);
        exit();
}
if($decrypted_array['PASSWORD'] === $checkpassword){
    $response['message'] = 'Please enter new password!';
        echo json_encode($response);
        exit();
}

if ($currentpassword == '' || $password == '' || $newpassword == '') {
    $response['message'] = 'Please fill up all fields with (*) asterisk!';
    echo json_encode($response);
    exit();
}
if($newpassword != $password){
    $response['message'] = 'Password did not match!';
    echo json_encode($response);
    exit();
}
if(!preg_match('@[A-Z]@',$password)){
    $response['message'] = 'Password must include at least one Uppercase Letter!';
    echo json_encode($response);
    exit();
}
if(!preg_match('@[a-z]@',$password)){
    $response['message'] = 'Password must include at least one Lowercase Letter!';
    echo json_encode($response);
    exit();
}
if(!preg_match('@[0-9]@',$password)){
    $response['message'] = 'Password must include at least one Number!';
    echo json_encode($response);
    exit();
}
if(strlen($password) < 8){
    $response['message'] = 'Password must be at least 8 characters in length!';
    echo json_encode($response);
    exit();
}

$password = set_password($password);

$student = mysqli_query($conn_acc, "UPDATE user_account SET PASSWORD = '" . $password . "' WHERE ID ='$user_id'");
$sql = "UPDATE user_account SET password = :password WHERE id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

$action = "Change Password : User # " . $user_id . " | Full Name : ".$decrypted_array['FNAME'] .' '.$decrypted_array['MNAME'] .' '.$decrypted_array['LNAME'];
$user_id = $decrypted_array['ID'];
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
