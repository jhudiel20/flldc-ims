<?php
if (!isset($_COOKIE['secure_data'])){
    header("Location: /");
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../config/config.php'; // Adjusted path for config.php

if ($_SERVER["REQUEST_METHOD"] == "POST"){

$id = isset($_POST['id']) ? trim($_POST['id']) : '';
$pcv_id = isset($_POST['pcv_id']) ? trim($_POST['pcv_id']) : '';
$status = isset($_POST['status']) ? trim($_POST['status']) : '';
$pcv_no = isset($_POST['pcv_no']) ? trim($_POST['pcv_no']) : '';
$pcv_no_old = isset($_POST['pcv_no']) ? trim($_POST['pcv_no']) : '';

$employee = isset($_POST['employee']) ? trim($_POST['employee']) : '';
$sbu = isset($_POST['sbu']) ? trim($_POST['sbu']) : '';
$department = isset($_POST['department']) ? trim($_POST['department']) : '';
$expenses = isset($_POST['expenses']) ? trim($_POST['expenses']) : '';
$pcv_date = isset($_POST['pcv_date']) ? trim($_POST['pcv_date']) : '';
$sdcc = isset($_POST['sdcc']) ? trim($_POST['sdcc']) : '';
$remarks = isset($_POST['remarks']) ? trim($_POST['remarks']) : '';


    $checkduplicate = $conn->prepare("SELECT PCV_NO FROM rca WHERE ID != :id");
    $checkduplicate->bindParam(':id', $id, PDO::PARAM_STR);
    $checkduplicate->execute();
    $row_check = $checkduplicate->rowCount();
    if ($row_check >= 1) {
        $response['message'] = 'PCV No is already taken!';
        echo json_encode($response);
        exit();
    }
    
$sql = $conn->prepare("UPDATE rca SET NAME = :employee,
SBU = :sbu, STATUS = :status, REMARKS = :remarks, PCV_NO = :pcv_no,
DEPARTMENT = :department, PCV_DATE = :pcv_date, amount = :expenses, SDCCC = :sdccc WHERE ID = :id ");
$sql->bindParam(':employee', $employee, PDO::PARAM_STR);
$sql->bindParam(':sbu', $sbu, PDO::PARAM_STR);
$sql->bindParam(':expenses', $expenses, PDO::PARAM_STR);
$sql->bindParam(':status', $status, PDO::PARAM_STR);
$sql->bindParam(':remarks', $remarks, PDO::PARAM_STR);
$sql->bindParam(':pcv_no', $pcv_no, PDO::PARAM_STR);
$sql->bindParam(':department', $department, PDO::PARAM_STR);
$sql->bindParam(':pcv_date', $pcv_date, PDO::PARAM_STR);
$sql->bindParam(':sdccc', $sdccc, PDO::PARAM_STR);
$sql->bindParam(':id', $id, PDO::PARAM_STR);
$sql->execute();

$user_id = $decrypted_array['ID'];
$action = "Updated PCV Details | PCV ID : ".$pcv_id;
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
?>