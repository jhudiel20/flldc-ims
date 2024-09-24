<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

// var_dump($_REQUEST);
$id = isset($_POST['ID']) ? trim($_POST['ID']) : '';
$REQUEST_ID =  isset($_POST['REQUEST_ID']) ? trim($_POST['REQUEST_ID']) : '';

$sql = $conn->prepare("UPDATE purchase_order SET ITEM_NAME = :item_name, QUANTITY = :quantity, STATUS = :status, 
DESCRIPTION = :item_desc, REMARKS = :remarks, PR_NO = :pr_no, PO_NO = :po_no, OS_TICKET_NO = :os_ticket_no WHERE ID = :id ");
$sql->bindParam(':item_name', $ITEM_NAME, PDO::PARAM_STR);
$sql->bindParam(':quantity', $QUANTITY, PDO::PARAM_STR);
$sql->bindParam(':status', $STATUS, PDO::PARAM_STR);
$sql->bindParam(':item_desc', $ITEM_DESC, PDO::PARAM_STR);
$sql->bindParam(':remarks', $REMARKS, PDO::PARAM_STR);
$sql->bindParam(':pr_no', $PR_NO, PDO::PARAM_STR);
$sql->bindParam(':po_no', $PO_NO, PDO::PARAM_STR);
$sql->bindParam(':os_ticket_no', $ITEM_NAME, PDO::PARAM_STR);
$sql->bindParam(':id', $id, PDO::PARAM_STR);
$sql->execute();

$user_id = $decrypted_array['ID'];
$action = "Updated Purchase Order Details | Product Item : ".$ITEM_NAME;

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
