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

$user_id =  isset($_POST['ID']) ? trim($_POST['ID']) : '';
$firstname =  isset($_POST['FNAME']) ? trim($_POST['FNAME']) : '';
$middlename =  isset($_POST['MNAME']) ? trim($_POST['MNAME']) : '';
$lastname =  isset($_POST['LNAME']) ? trim($_POST['LNAME']) : '';
$contact =  isset($_POST['CONTACT']) ? trim($_POST['CONTACT']) : '';
$extn =  isset($_POST['SUFFIX']) ? trim($_POST['SUFFIX']) : '';
$email =  isset($_POST['EMAIL']) ? trim($_POST['EMAIL']) : '';
$access =  isset($_POST['ACCESS']) ? trim($_POST['ACCESS']) : '';

if ($firstname == '' || $lastname == '' || $email == '' || $access == '') {
    $response['message'] = 'Please fill up all fields with (*) asterisk!';
    echo json_encode($response);
    exit();
}


if (!preg_match(is_letter, $firstname) || !preg_match(is_letter, $lastname)) {
    $response['message'] = 'Invalid Name!';
    echo json_encode($response);
    exit();
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    
    $response['success'] = false;
    $response['title'] = "Error!";
    $response['message'] = 'Invalid Email!';
    echo json_encode($response);
    exit();

}

if($access == 'ADMIN'){
    $stmt = $conn->prepare("UPDATE user_account SET 
        FNAME = :firstname, 
        MNAME = :middlename, 
        LNAME = :lastname, 
        EXT_NAME = :extn, 
        CONTACT = :contact, 
        EMAIL = :email, 
        ACCESS = :access, 
        ADMIN_STATUS = 'DEFAULT' 
        WHERE ID = :user_id");

    // Bind the parameters to the placeholders
    $stmt->bindParam(':firstname', strip_tags($firstname), PDO::PARAM_STR);
    $stmt->bindParam(':middlename', strip_tags($middlename), PDO::PARAM_STR);
    $stmt->bindParam(':lastname', strip_tags($lastname), PDO::PARAM_STR);
    $stmt->bindParam(':extn', strip_tags($extn), PDO::PARAM_STR);
    $stmt->bindParam(':contact', strip_tags($contact), PDO::PARAM_STR);
    $stmt->bindParam(':email', strip_tags($email), PDO::PARAM_STR);
    $stmt->bindParam(':access', strip_tags($access), PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT); // Assuming ID is an integer

    // Execute the prepared statement
    $stmt->execute();
}else{
    $stmt = $conn->prepare("UPDATE user_account SET 
        FNAME = :firstname, 
        MNAME = :middlename, 
        LNAME = :lastname, 
        EXT_NAME = :extn, 
        CONTACT = :contact, 
        EMAIL = :email, 
        ACCESS = :access
        WHERE ID = :user_id");

    // Bind the parameters to the placeholders
    $stmt->bindParam(':firstname', strip_tags($firstname), PDO::PARAM_STR);
    $stmt->bindParam(':middlename', strip_tags($middlename), PDO::PARAM_STR);
    $stmt->bindParam(':lastname', strip_tags($lastname), PDO::PARAM_STR);
    $stmt->bindParam(':extn', strip_tags($extn), PDO::PARAM_STR);
    $stmt->bindParam(':contact', strip_tags($contact), PDO::PARAM_STR);
    $stmt->bindParam(':email', strip_tags($email), PDO::PARAM_STR);
    $stmt->bindParam(':access', strip_tags($access), PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT); // Assuming ID is an integer

    // Execute the prepared statement
    $stmt->execute();

}

$sql = $conn->prepare("SELECT fname,mname,lname,ext_name FROM user_account WHERE id = :user_id");
$sql->bindParam(':user_id',$user_id,PDO::PARAM_STR);
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);

$user_id = $decrypted_array['ID'];
$action = "Updated User information  of user :  " . $row['fname'].' '.$row['mname'].' '.$row['lname'].' '.$row['ext_name'];

$logs = $conn->prepare("INSERT INTO logs (USER_ID, ACTION_MADE) VALUES (:user_id, :action)");

$logs->bindParam(':user_id', $user_id, PDO::PARAM_STR);
$logs->bindParam(':action', $action, PDO::PARAM_STR);
$logs->execute();

$response['success'] = true;
$response['title'] = 'Success';
$response['message'] = 'Successfully Updated User information!';
echo json_encode($response);
exit();


}
