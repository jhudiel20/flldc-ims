<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

if ($_SERVER["REQUEST_METHOD"] == "POST"){

$id = isset($_POST['id']) ? trim($_POST['id']) : '';
$rca_id = isset($_POST['rca_id']) ? trim($_POST['rca_id']) : '';
$status = isset($_POST['status']) ? trim($_POST['status']) : '';
$employee = isset($_POST['employee']) ? trim($_POST['employee']) : '';
$employee_no = isset($_POST['employee_no']) ? trim($_POST['employee_no']) : '';
$paygroup = isset($_POST['paygroup']) ? trim($_POST['paygroup']) : '';
$sbu = isset($_POST['sbu']) ? trim($_POST['sbu']) : '';
$branch = isset($_POST['branch']) ? trim($_POST['branch']) : '';
$amount = isset($_POST['amount']) ? trim($_POST['amount']) : '';
$payee = isset($_POST['payee']) ? trim($_POST['payee']) : '';
$account_no = isset($_POST['account_no']) ? trim($_POST['account_no']) : '';

$purpose_rca = isset($_POST['purpose_rca']) ? trim($_POST['purpose_rca']) : '';
$date_needed = isset($_POST['date_needed']) ? trim($_POST['date_needed']) : '';
$date_event = isset($_POST['date_event']) ? trim($_POST['date_event']) : '';

$purpose_travel = isset($_POST['purpose_travel']) ? trim($_POST['purpose_travel']) : '';
$date_depart = isset($_POST['date_depart']) ? trim($_POST['date_depart']) : '';
$date_return = isset($_POST['date_return']) ? trim($_POST['date_return']) : '';
$remarks = isset($_POST['remarks']) ? trim($_POST['remarks']) : '';


$sql = $conn->prepare("UPDATE rca SET NAME = :employee,
SBU = :sbu, AMOUNT = :expenses, STATUS = :status, REMARKS = :remarks, PCV_NO = :pcv_no,
DEPARTMENT = :department, PCV_DATE = :pcv_date, AMOUNT = :expenses, SDCCC = :sdccc WHERE ID = :id ");
$sql->bindParam(':employee', $employee, PDO::PARAM_STR);
$sql->bindParam(':employee_no', $employee_no, PDO::PARAM_STR);
$sql->bindParam(':paygroup', $paygroup, PDO::PARAM_STR);
$sql->bindParam(':sbu', $sbu, PDO::PARAM_STR);
$sql->bindParam(':branch', $branch, PDO::PARAM_STR);
$sql->bindParam(':amount', $amount, PDO::PARAM_STR);
$sql->bindParam(':payee', $payee, PDO::PARAM_STR);
$sql->bindParam(':account_no', $account_no, PDO::PARAM_STR);
$sql->bindParam(':purpose_rca', $purpose_rca, PDO::PARAM_STR);
$sql->bindParam(':date_needed', $date_needed, PDO::PARAM_STR);
$sql->bindParam(':date_event', $date_event, PDO::PARAM_STR);
$sql->bindParam(':purpose_travel', $purpose_travel, PDO::PARAM_STR);
$sql->bindParam(':date_depart', $date_depart, PDO::PARAM_STR);
$sql->bindParam(':date_return', $date_return, PDO::PARAM_STR);
$sql->bindParam(':status', $status, PDO::PARAM_STR);
$sql->bindParam(':remarks', $remarks, PDO::PARAM_STR);
$sql->bindParam(':id', $id, PDO::PARAM_STR);
$sql->execute();


$user_id = $decrypted_array['ID'];
$action = "Updated RCA Details | RCA ID : ".$rca_id;
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