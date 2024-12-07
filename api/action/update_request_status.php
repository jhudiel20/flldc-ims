<?php
if (!isset($_COOKIE['secure_data'])){
    header("Location: /#");
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../config/config.php'; // Adjusted path for config.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

$approval_status = isset($_POST['approval_status']) ? trim($_POST['approval_status']) : '';
$ID = isset($_POST['ID']) ? trim($_POST['ID']) : '';
$EMAIL = isset($_POST['EMAIL']) ? trim($_POST['EMAIL']) : '';  
$REQUEST_ID = isset($_POST['REQUEST_ID']) ? trim($_POST['REQUEST_ID']) : '';  

$ITEM_NAME = isset($_POST['ITEM_NAME']) ? trim($_POST['ITEM_NAME']) : '';

$generate_PR_ID  = generate_PR_ID();
    
        // Mailer setup
        require __DIR__ . '/../../public/mail/Exception.php';
        require __DIR__ . '/../../public/mail/PHPMailer.php';
        require __DIR__ . '/../../public/mail/SMTP.php';


    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'lndreports2024@gmail.com';                     //SMTP username
        $mail->Password   = $_ENV['EMAIL_PASS'];                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('lndreports2024@gmail.com', 'Learning and Development Inventory Management System');
        $mail->addAddress($EMAIL);     //Add a recipient
        $mail->addEmbeddedImage('/var/task/user/public/assets/img/LOGO.png', 'logo_cid');
        $code = $REQUEST_ID;
        $ITEM_NAME = $ITEM_NAME;
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
  
        if($approval_status == 'APPROVED'){
            $mail->Subject = 'Request Status Update : '.$approval_status;
            $mail->Body    = '
                <div style="background:#f3f3f3">
                        <div style="margin:0px auto;max-width:640px;background:transparent">
                            <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:transparent" align="center" border="0">
                            <tbody>
                                <tr>
                                <td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:40px 0px">
                                    <div aria-labelledby="mj-column-per-100" class="m_29934315870093561mj-column-per-100" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%">
                                    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                                        <tbody>
                                        <tr>
                                            <td style="word-break:break-word;font-size:0px;padding:0px" align="center">
                                                <table role="presentation" cellpadding="0" cellspacing="0" style="border-collapse:collapse;border-spacing:0px" align="center" border="0">
                                                    <tbody>
                                                        <tr>
                                                        <td style="width:138px">
                                                            <img alt="" title="" height="100px" width="200px" src="cid:logo_cid" width="100" style="">
                                                        </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>

                    <div style="max-width:640px;margin:0 auto;border-radius:4px;overflow:hidden">
                    <div style="margin:0px auto;max-width:640px;background:#fdfdfd">
                        <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#fdfdfd" align="center" border="0">
                            <tbody>
                                <tr>
                                    <td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:40px 50px">
                                        <div aria-labelledby="mj-column-per-100" class="m_29934315870093561mj-column-per-100" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%">
                                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="word-break:break-word;font-size:0px;padding:0px" align="left">
                                                            <div style="color:#737f8d;font-family:Whitney,Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:16px;line-height:24px;text-align:left">
                                                
                                                                <h2 style="font-family:Whitney,Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-weight:500;font-size:20px;color:#4f545c;letter-spacing:0.27px">Hi good day,</h2>
                                                                <p style="text-align:justify">I trust this email finds you well. I am reaching out to provide you with an update on the status of your recent request with us. Your satisfaction remains our top priority, and we are committed to keeping you informed every step of the way.</p>
                                                                <p style="text-align:justify">If you did not initiate a purchase in Learning and Development Inventory Management System, kindly disregard this message.</p>
                                                                <p style="text-align:justify">I am delighted to inform you that after careful review and consideration, your request has been approved. We are pleased to move forward with fulfilling your request, and we aim to provide you with exceptional service throughout the process.</p>
                                                                <p>Here are some details related to your request: <b><br><br> Request ID : <b>'.$code.'</b> <br> Request Item : <b>'.$ITEM_NAME.'</b> <br> Status : <b>Approved</b>  </p>

                                                                <p style="text-align:justify">We appreciate the opportunity to assist you and are excited to proceed with your request. If you have any questions or need further assistance, please do not hesitate to contact our support [ bjrufino@fast.com.ph ]. We are here to ensure a smooth and seamless experience for you.</p>
                                                                <p style="text-align:justify">Thank you for choosing FAST Learning and Development Inventory Management System. We look forward to serving you.</p>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                 
                                                    <tr>
                                                        <td style="word-break:break-word;font-size:0px;padding:30px 0px">
                                                            <p style="font-size:1px;margin:0px auto;border-top:1px solid #dcddde;width:100%"></p>
                                                        </td>
                                                    </tr>               
                                                </tbody>    
                                            </table>
                                        </div>  
                                    </td>
                                </tr>
                            </tbody>    
                        </table>
                    </div>
                    <div>
                    <table align="center">
                        <tr>
                        <td style="height:150px;  border:none;border-radius:3px;color:black;padding:15px 19px" align="center" valign="middle">&copy; 2024-2025 <strong><span>FAST Learning and Development Inventory Management System</span></strong></td>
                        </tr>
                    </table>
                    </div>
                </div>
            ';
        }else{
            $mail->Subject = 'Request Status Update : '.$approval_status;
            $mail->Body    = '
                <div style="background:#f3f3f3">
                    <div style="margin:0px auto;max-width:640px;background:transparent">
                    <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:transparent" align="center" border="0">
                        <tbody>
                        <tr>
                            <td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:40px 0px">
                            <div aria-labelledby="mj-column-per-100" class="m_29934315870093561mj-column-per-100" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%">
                                <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                                <tbody>
                                    <tr>
                                    <td style="word-break:break-word;font-size:0px;padding:0px" align="center">
                                        <table role="presentation" cellpadding="0" cellspacing="0" style="border-collapse:collapse;border-spacing:0px" align="center" border="0">
                                        <tbody>
                                            <tr>
                                            <td style="width:138px">
                                                <img alt="" title="" height="100px" width="200px" src="../assets/img/LOGO.png" width="100" style="">
                                            </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    </div>

                    <div style="max-width:640px;margin:0 auto;border-radius:4px;overflow:hidden">
                    <div style="margin:0px auto;max-width:640px;background:#fdfdfd">
                        <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#fdfdfd" align="center" border="0">
                            <tbody>
                                <tr>
                                    <td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:40px 50px">
                                        <div aria-labelledby="mj-column-per-100" class="m_29934315870093561mj-column-per-100" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%">
                                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="word-break:break-word;font-size:0px;padding:0px" align="left">
                                                            <div style="color:#737f8d;font-family:Whitney,Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:16px;line-height:24px;text-align:left">
                                                
                                                                <h2 style="font-family:Whitney,Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-weight:500;font-size:20px;color:#4f545c;letter-spacing:0.27px">Hi good day,</h2>
                                                                <p style="text-align:justify">I trust this email finds you in good spirits. I am reaching out to provide you with an update on the status of your recent request with us. Ensuring your satisfaction remains our utmost priority, and we are dedicated to keeping you informed throughout the process.</p>
                                                                <p style="text-align:justify">If you did not initiate a purchase in Learning and Development Inventory Management System, kindly disregard this message.</p>
                                                                <p style="text-align:justify">Following thorough review and deliberation, I regret to inform you that your request has been declined. The decision was made after careful consideration of various factors, and we understand this may not be the outcome you were hoping for.</p>
                                                                <p>Here are some details related to your request: <b><br><br> Request ID : <b>'.$code.'</b> <br> Request Item : <b>'.$ITEM_NAME.'</b> <br> Status : <b>Declined</b> </p>

                                                                <p style="text-align:justify">We appreciate the opportunity to assist you and are excited to proceed with your request. If you have any questions or need further assistance, please do not hesitate to contact our support [ bjrufino@fast.com.ph ]. We are here to ensure a smooth and seamless experience for you.</p>
                                                                <p style="text-align:justify">Thank you for choosing FAST Learning and Development Inventory Management System. We look forward to serving you.</p>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                 
                                                    <tr>
                                                        <td style="word-break:break-word;font-size:0px;padding:30px 0px">
                                                            <p style="font-size:1px;margin:0px auto;border-top:1px solid #dcddde;width:100%"></p>
                                                        </td>
                                                    </tr>               
                                                </tbody>    
                                            </table>
                                        </div>  
                                    </td>
                                </tr>
                            </tbody>    
                        </table>
                    </div>
                <div>
                    <table align="center">
                        <tr>
                        <td style="height:150px;  border:none;border-radius:3px;color:black;padding:15px 19px" align="center" valign="middle">&copy; 2024-2025 <strong><span>FAST Learning and Development Inventory Management System</span></strong></td>
                        </tr>
                    </table>
                    </div>
                </div>
            ';
        }
        $mail->send();

        $sql = $conn->prepare("UPDATE purchase_order SET PR_ID = :pr_id ,
        APPROVAL = :approval_status ,APPROVAL_DATE_CREATED = NOW() AT TIME ZONE 'Asia/Manila' WHERE id = :id ");
        $sql->bindParam(':pr_id', $generate_PR_ID, PDO::PARAM_STR);
        $sql->bindParam(':approval_status', $approval_status, PDO::PARAM_STR);
        $sql->bindParam(':id', $ID, PDO::PARAM_STR);
        // Execute the prepared statement
        $sql->execute();

        $history_title = "Updated Request Status";
        $history_remarks = "Status Request : " . $approval_status;

        $sql_history = $conn->prepare("INSERT INTO po_history (REQUEST_ID,TITLE,REMARKS) 
        VALUES (:request_id,:title,:remarks)");
        $sql_history->bindParam(':request_id', $REQUEST_ID, PDO::PARAM_STR);
        $sql_history->bindParam(':title', $history_title, PDO::PARAM_STR);
        $sql_history->bindParam(':remarks', $history_remarks, PDO::PARAM_STR);
        // Execute the prepared statement
        $sql_history->execute();


        if($approval_status = " APPROVED "){
            $action = "Request Status : Approved | Request Item Name : " . $ITEM_NAME;
        }else{
            $action = "Request Status : Declined | Request Item Name : ". $ITEM_NAME;
        }
                // Log the action
                $user_id = $decrypted_array['ID'];
                $logs = $conn->prepare("INSERT INTO logs (USER_ID, ACTION_MADE) VALUES (:user_id, :action)");

                $logs->bindParam(':user_id', $user_id, PDO::PARAM_STR);
                $logs->bindParam(':action', $action, PDO::PARAM_STR);
                $logs->execute();

        $response['success'] = true;
        $response['title'] = 'Success';
        $response['message'] = 'Successfully Updated!';
        echo json_encode($response);
        exit();
    
        
    }catch (Exception $e) {
        // If an error occurs during sending email
        $response['success'] = false;
        $response['title'] = 'Error';
        $response['message'] = 'Email could not be sent. Error: ' . $mail->ErrorInfo;
        echo json_encode($response);
        exit();
    } 
}
    