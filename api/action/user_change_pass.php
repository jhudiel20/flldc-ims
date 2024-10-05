<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$user_id = isset($_POST['id']) ? trim($_POST['id']) : '';
$currentpassword = isset($_POST['currentpassword']) ? trim($_POST['currentpassword']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
$newpassword = isset($_POST['newpassword']) ? trim($_POST['newpassword']) : '';

$currentpassword = set_password($currentpassword);
$checkpassword = set_password($password);

    // Validate user_id
    if (empty($user_id) || !is_numeric($user_id)) {
        $response['success'] = false;
        $response['title'] = "Error!";
        $response['message'] = 'Invalid user ID!'.$user_id;
        echo json_encode($response);
        exit();
    }

    $db_pass = $conn->prepare("SELECT password FROM user_account WHERE ID = :user_id");
    $db_pass->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $db_pass->execute();
    $row_pass = $db_pass->fetch(PDO::FETCH_ASSOC);

if($row_pass['password'] !== $currentpassword){
    $response['success'] = false;
    $response['title'] = "Error!";
    $response['message'] = 'Current password doesnt match to your existing password!';
        echo json_encode($response);
        exit();
}
if($row_pass['password'] === $checkpassword){
    $response['success'] = false;
    $response['title'] = "Error!";
    $response['message'] = 'Please enter new password!';
        echo json_encode($response);
        exit();
}

if ($currentpassword == '' || $password == '' || $newpassword == '') {
    $response['success'] = false;
    $response['title'] = "Error!";
    $response['message'] = 'Please fill up all fields with (*) asterisk!';
    echo json_encode($response);
    exit();
}
if($newpassword != $password){
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

$sql = "UPDATE user_account SET password = :password WHERE ID = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

$action = "Change Password : User # " . $user_id . " | Full Name : ".$decrypted_array['FNAME'] .' '.$decrypted_array['MNAME'] .' '.$decrypted_array['LNAME'];
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
