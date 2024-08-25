<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

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
// $sql = mysqli_query($conn_acc,"SELECT USERNAME FROM user_account ");
//     while($row_sql = mysqli_fetch_assoc($sql)){
//     if($row_sql['USERNAME'] == $username){
//         $response['success'] = false;
//         $response['title'] = "Error!";
//         $response['message'] = 'Username already taken!';
//         echo json_encode($response);
//         exit();
//     }
// }

// $is_password = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";
// if(!preg_match($is_password,$password)){
//     $response['message'] = 'Minimum eight characters, at least one letter and one number:';
//     echo json_encode($response);
//     exit();
// }


$password = set_password($password);

$student = mysqli_query($conn_acc, "UPDATE user_account SET PASSWORD = '" . $password . "' WHERE ID ='$user_id'");



$user_id = $_SESSION['ID'];
$action = "Change Password : User # " . $user_id . " | Full Name : ".$_SESSION['FNAME'] .' '.$_SESSION['MNAME'] .' '.$_SESSION['LNAME'];

$logs = mysqli_query($conn, "INSERT INTO `logs` (`USER_ID`,`ACTION_MADE`) VALUES('$user_id','$action')");

$response['success'] = true;
$response['title'] = 'Success';
$response['message'] = 'Successfully Updated!';
echo json_encode($response);
exit();
