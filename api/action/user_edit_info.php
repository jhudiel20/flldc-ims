<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Get POST data
$user_id = isset($_POST['ID']) ? trim($_POST['ID']) : '';
$firstname = isset($_POST['Firstname']) ? trim($_POST['Firstname']) : '';
$middlename = isset($_POST['Middlename']) ? trim($_POST['Middlename']) : '';
$lastname = isset($_POST['Lastname']) ? trim($_POST['Lastname']) : '';
$extn = isset($_POST['extn']) ? trim($_POST['extn']) : '';
$email = isset($_POST['Email']) ? trim($_POST['Email']) : '';
$contact = isset($_POST['Contact']) ? trim($_POST['Contact']) : '';

// Validation
if ($firstname == '' || $lastname == '' || $email == '') {
    $response['message'] = 'Please fill up all fields with (*) asterisk!';
    echo json_encode($response);
    exit();
}

if (!preg_match('/^[a-zA-Z]+$/', $firstname) || !preg_match('/^[a-zA-Z]+$/', $lastname)) {
    $response['message'] = 'Invalid Name!';
    echo json_encode($response);
    exit();
}

if ($middlename != '' && !preg_match('/^[a-zA-Z]+$/', $middlename)) {
    $response['message'] = 'Invalid Name!';
    echo json_encode($response);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['message'] = 'Invalid Email!';
    echo json_encode($response);
    exit();
}

// Update user information in the database
try {
    $stmt = $conn->prepare("
        UPDATE user_account
        SET FNAME = :firstname,
            MNAME = :middlename,
            LNAME = :lastname,
            EXT_NAME = :extn,
            EMAIL = :email,
            CONTACT = :contact
        WHERE ID = :user_id
    ");
    $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
    $stmt->bindParam(':middlename', $middlename, PDO::PARAM_STR);
    $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $stmt->bindParam(':extn', $extn, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':contact', $contact, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch updated user information
    $stmt = $conn->prepare("SELECT FNAME, MNAME, LNAME, EXT_NAME FROM user_account WHERE ID = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Log the action
    $action = "Updated User information of user: " . $row['FNAME'] . ' ' . $row['MNAME'] . ' ' . $row['LNAME'] . ' ' . $row['EXT_NAME'];
    $user_id = $_SESSION['ID'];
    $stmt = $conn->prepare("INSERT INTO logs (USER_ID, ACTION_MADE) VALUES (:user_id, :action)");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindParam(':action', $action, PDO::PARAM_STR);
    $stmt->execute();

    $response['success'] = true;
    $response['title'] = 'Success';
    $response['message'] = 'Successfully Updated User information!';
    echo json_encode($response);
    exit();

} catch (PDOException $e) {
    $response['message'] = 'Database error: ' . $e->getMessage();
    echo json_encode($response);
    exit();
}
}
?>
