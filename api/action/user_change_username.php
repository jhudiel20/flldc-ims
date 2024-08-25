<?php

include '../DBConnection.php';
include '../config/config.php';

response();
// var_dump($_REQUEST);
$user_id = mysqli_real_escape_string($conn, isset($_POST['ID']) ? trim($_POST['ID']) : '');
$currentusername = mysqli_real_escape_string($conn, isset($_POST['currentusername']) ? trim($_POST['currentusername']) : '');
$username = mysqli_real_escape_string($conn, isset($_POST['username']) ? trim($_POST['username']) : '');

if($_SESSION['USERNAME'] !== $currentusername){
    $response['message'] = 'Current username doesnt match to your existing username!';
        echo json_encode($response);
        exit();
}

if($_SESSION['USERNAME'] === $username){
    $response['message'] = 'Please enter new username!';
        echo json_encode($response);
        exit();
}

if(strlen($username) < 8){
    $response['message'] = 'Username must be at least 8 characters in length!';
    echo json_encode($response);
    exit();
}
$sql = mysqli_query($conn_acc,"SELECT USERNAME FROM user_account ");
    while($row_sql = mysqli_fetch_assoc($sql)){
    if($row_sql['USERNAME'] == $username){
        $response['success'] = false;
        $response['title'] = "Error!";
        $response['message'] = 'Username already taken!';
        echo json_encode($response);
        exit();
    }
}


$student = mysqli_query($conn_acc, "UPDATE user_account SET USERNAME = '" . $username . "' WHERE ID ='$user_id'");



$user_id = $_SESSION['ID'];
$action = "Change Username : User # " . $user_id . " | Full Name : ".$_SESSION['FNAME'] .' '.$_SESSION['MNAME'] .' '.$_SESSION['LNAME'];

$logs = mysqli_query($conn, "INSERT INTO `logs` (`USER_ID`,`ACTION_MADE`) VALUES('$user_id','$action')");

$response['success'] = true;
$response['title'] = 'Success';
$response['message'] = 'Successfully Updated!';
echo json_encode($response);
exit();
