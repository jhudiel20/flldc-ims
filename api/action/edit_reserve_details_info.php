<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

// var_dump($_REQUEST);
$id = isset($_POST['ID']) ? trim($_POST['ID']) : '';
$reserve_status =  isset($_POST['reserve_status']) ? trim($_POST['reserve_status']) : '';
$reserve_date =  isset($_POST['reserve_date']) ? trim($_POST['reserve_date']) : '';
$fname =  isset($_POST['fname']) ? trim($_POST['fname']) : '';
$lname =  isset($_POST['lname']) ? trim($_POST['lname']) : '';
$time =  isset($_POST['time']) ? trim($_POST['time']) : '';
$setup =  isset($_POST['setup']) ? trim($_POST['setup']) : '';
$businessunit =  isset($_POST['businessunit']) ? trim($_POST['businessunit']) : '';
$guest =  isset($_POST['guest']) ? trim($_POST['guest']) : '';
$contact =  isset($_POST['contact']) ? trim($_POST['contact']) : '';
$email =  isset($_POST['email']) ? trim($_POST['email']) : '';
$message =  isset($_POST['message']) ? trim($_POST['message']) : '';
$bookingID =  isset($_POST['bookingID']) ? trim($_POST['bookingID']) : '';

$sql = $conn->prepare("UPDATE reservations SET RESERVE_STATUS = :reserve_status, RESERVE_DATE = :reserve_date, FNAME = :fname, 
LNAME = :lname, TIME = :time, SETUP = :setup, BUSINESS_UNIT = :businessunit, GUEST = :guest, CONTACT = :contact, EMAIL = :email, MESSAGE = :message WHERE ID = :id ");
$sql->bindParam(':reserve_status', $reserve_status, PDO::PARAM_STR);
$sql->bindParam(':reserve_date', $reserve_date, PDO::PARAM_STR);
$sql->bindParam(':fname', $fname, PDO::PARAM_STR);
$sql->bindParam(':lname', $lname, PDO::PARAM_STR);
$sql->bindParam(':time', $time, PDO::PARAM_STR);
$sql->bindParam(':setup', $setup, PDO::PARAM_STR);
$sql->bindParam(':businessunit', $businessunit, PDO::PARAM_STR);
$sql->bindParam(':guest', $guest, PDO::PARAM_STR);
$sql->bindParam(':contact', $contact, PDO::PARAM_STR);
$sql->bindParam(':email', $email, PDO::PARAM_STR);
$sql->bindParam(':message', $message, PDO::PARAM_STR);
$sql->bindParam(':id', $id, PDO::PARAM_STR);
$sql->execute();

$user_id = $decrypted_array['ID'];
$action = "Updated Booking Details | Booking ID : ".$bookingID;

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
