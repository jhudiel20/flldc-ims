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

$PR_NO_OLD =  isset($_POST['PR_NO_OLD']) ? trim($_POST['PR_NO_OLD']) : '';
$PO_NO_OLD =  isset($_POST['PO_NO_OLD']) ? trim($_POST['PO_NO_OLD']) : '';
$OSTICKET_OLD =  isset($_POST['OSTICKET_OLD']) ? trim($_POST['OSTICKET_OLD']) : '';

$PR_NO =  isset($_POST['PR_NO']) ? trim($_POST['PR_NO']) : '';
$PO_NO =  isset($_POST['PO_NO']) ? trim($_POST['PO_NO']) : '';
$OS_TICKET_NO =  isset($_POST['OS_TICKET_NO']) ? trim($_POST['OS_TICKET_NO']) : '';

$ITEM_NAME =  isset($_POST['ITEM_NAME']) ? trim($_POST['ITEM_NAME']) : '';
$ITEM_DESC =  isset($_POST['ITEM_DESC']) ? trim($_POST['ITEM_DESC']) : '';

$QUANTITY =  isset($_POST['QUANTITY']) ? trim($_POST['QUANTITY']) : '';
$STATUS =  isset($_POST['STATUS']) ? trim($_POST['STATUS']) : '';
$REMARKS =  isset($_POST['REMARKS']) ? trim($_POST['REMARKS']) : '';



$compare = $conn->prepare("SELECT pr_no,po_no,os_ticket_no FROM purchase_order WHERE id = :id ");
$compare->bindParam('id', $id, PDO::PARAM_STR);
$compare->execute();
$row_compare = $compare->fetch(PDO::FETCH_ASSOC);


if($row_compare['pr_no'] == '' || $row_compare['pr_no'] == NULL){
    if(!empty($PR_NO)){
        $history_title = "PR No. Inserted";
        $history_remarks = "PR No. : " . $PR_NO;
        $sql_history = $conn->prepare("INSERT INTO po_history (REQUEST_ID,TITLE,REMARKS) 
        VALUES (:request_id,:history_title,:history_remarks)");
        $sql_history->bindParam(':request_id', $REQUEST_ID, PDO::PARAM_STR);
        $sql_history->bindParam(':history_title', $history_title, PDO::PARAM_STR);
        $sql_history->bindParam(':history_remarks', $history_remarks, PDO::PARAM_STR);
        $sql_history->execute();
    }
}else{
    if($PR_NO_OLD == $PR_NO){
        if(!empty($PR_NO)){
            $history_title = "PR No. Inserted";
            $history_remarks = "PR No. : " . $PR_NO;
            $sql_history = $conn->prepare("INSERT INTO po_history (REQUEST_ID,TITLE,REMARKS) 
            VALUES (:request_id,:history_title,:history_remarks)");
            $sql_history->bindParam(':request_id', $REQUEST_ID, PDO::PARAM_STR);
            $sql_history->bindParam(':history_title', $history_title, PDO::PARAM_STR);
            $sql_history->bindParam(':history_remarks', $history_remarks, PDO::PARAM_STR);
            $sql_history->execute();
        }
    }
    if($row_compare['pr_no'] != $PR_NO){
        if(!empty($PR_NO)){
            $history_title = "PR No. Updated";
            $history_remarks = "PR No. : " . $PR_NO;
            $sql_history = $conn->prepare("INSERT INTO po_history (REQUEST_ID,TITLE,REMARKS) 
            VALUES (:request_id,:history_title,:history_remarks)");
            $sql_history->bindParam(':request_id', $REQUEST_ID, PDO::PARAM_STR);
            $sql_history->bindParam(':history_title', $history_title, PDO::PARAM_STR);
            $sql_history->bindParam(':history_remarks', $history_remarks, PDO::PARAM_STR);
            $sql_history->execute();
        } 
    }
}

if($row_compare['po_no'] == '' || $row_compare['po_no'] == NULL){
    if(!empty($PO_NO)){
        $history_title = "PO No. Inserted";
        $history_remarks = "PO No. : " . $PO_NO;
        $sql_history = $conn->prepare("INSERT INTO po_history (REQUEST_ID,TITLE,REMARKS) 
        VALUES (:request_id,:history_title,:history_remarks)");
        $sql_history->bindParam(':request_id', $REQUEST_ID, PDO::PARAM_STR);
        $sql_history->bindParam(':history_title', $history_title, PDO::PARAM_STR);
        $sql_history->bindParam(':history_remarks', $history_remarks, PDO::PARAM_STR);
        $sql_history->execute();
    }
}else{
    if($PO_NO_OLD == $PO_NO){
        if(!empty($PO_NO)){
            $history_title = "PO No. Inserted";
            $history_remarks = "PO No. : " . $PO_NO;
            $sql_history = $conn->prepare("INSERT INTO po_history (REQUEST_ID,TITLE,REMARKS) 
            VALUES (:request_id,:history_title,:history_remarks)");
            $sql_history->bindParam(':request_id', $REQUEST_ID, PDO::PARAM_STR);
            $sql_history->bindParam(':history_title', $history_title, PDO::PARAM_STR);
            $sql_history->bindParam(':history_remarks', $history_remarks, PDO::PARAM_STR);  
            $sql_history->execute();
        }
    }
    if($row_compare['po_no'] != $PO_NO){
        if(!empty($PO_NO)){
            $history_title = "PO No. Updated";
            $history_remarks = "PO No. : " . $PO_NO;
            $sql_history = $conn->prepare("INSERT INTO po_history (REQUEST_ID,TITLE,REMARKS) 
            VALUES (:request_id,:history_title,:history_remarks)");
            $sql_history->bindParam(':request_id', $REQUEST_ID, PDO::PARAM_STR);
            $sql_history->bindParam(':history_title', $history_title, PDO::PARAM_STR);
            $sql_history->bindParam(':history_remarks', $history_remarks, PDO::PARAM_STR);
            $sql_history->execute();
        } 
    }
}

if($row_compare['os_ticket_no'] == '' || $row_compare['os_ticket_no'] == NULL){
    if(!empty($OS_TICKET_NO)){
        $history_title = "OS-Ticket No. Inserted";
        $history_remarks = "OS-Ticket No. : " . $OS_TICKET_NO;
        $sql_history = $conn->prepare("INSERT INTO po_history (REQUEST_ID,TITLE,REMARKS) 
        VALUES (:request_id,:history_title,:history_remarks)");
        $sql_history->bindParam(':request_id', $REQUEST_ID, PDO::PARAM_STR);
        $sql_history->bindParam(':history_title', $history_title, PDO::PARAM_STR);
        $sql_history->bindParam(':history_remarks', $history_remarks, PDO::PARAM_STR);
        $sql_history->execute();
    }
}else{
    // if($OSTICKET_OLD !== $OS_TICKET_NO){
    //     if(!empty($OS_TICKET_NO)){
    //         $history_title = "OS-Ticket No. Inserted2";
    //         $history_remarks = "OS-Ticket No. : " . $OS_TICKET_NO;
    //         $sql_history = mysqli_query($conn, "INSERT INTO po_history (REQUEST_ID,TITLE,REMARKS) 
    //         VALUES ('$REQUEST_ID','$history_title','$history_remarks')");
    //     }
    // }
    if($row_compare['os_ticket_no'] != $OS_TICKET_NO){
        if(!empty($PO_NO)){
            $history_title = "OS-Ticket No. Updated";
            $history_remarks = "OS-Ticket No. : " . $OS_TICKET_NO;
            $sql_history = $conn->prepare("INSERT INTO po_history (REQUEST_ID,TITLE,REMARKS) 
            VALUES (:request_id,:history_title,:history_remarks)");
            $sql_history->bindParam(':request_id', $REQUEST_ID, PDO::PARAM_STR);
            $sql_history->bindParam(':history_title', $history_title, PDO::PARAM_STR);
            $sql_history->bindParam(':history_remarks', $history_remarks, PDO::PARAM_STR);
            $sql_history->execute();
        } 
    }
}

if($STATUS !== 'PENDING'){
    $history_title = "Purchase Status Updated";
    $history_remarks = "Status : " . $STATUS;
    $sql_history = $conn->prepare("INSERT INTO po_history (REQUEST_ID,TITLE,REMARKS) 
    VALUES (:request_id,:history_title,:history_remarks)");
    $sql_history->bindParam(':request_id', $REQUEST_ID, PDO::PARAM_STR);
    $sql_history->bindParam(':history_title', $history_title, PDO::PARAM_STR);
    $sql_history->bindParam(':history_remarks', $history_remarks, PDO::PARAM_STR);
    $sql_history->execute();
}


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
