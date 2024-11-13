<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';

if($email == ''){
    $response['icon'] = "error";
    $response['success'] = false;
    $response['title'] = "Please enter email!";
    echo json_encode($response);
    exit();
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    
    $response['icon'] = "error";
    $response['success'] = false;
    $response['title'] = "Enter valid email!";
    echo json_encode($response);
    exit();

}

$db_email = $conn->prepare("SELECT EMAIL FROM user_account WHERE EMAIL = :email ");
$db_email->bindParam(':email', $email, PDO::PARAM_STR);
$db_email->execute();
$row_email = $db_email->fetch(PDO::FETCH_ASSOC);
// Check if the query returned any rows
if (!$row_email) {
    $response['icon'] = "error";
    $response['success'] = false;
    $response['title'] = "Please enter correct email address!";
    echo json_encode($response);
}else{

        
        // Mailer setup
        require __DIR__ . '/../../public/mail/Exception.php';
        require __DIR__ . '/../../public/mail/PHPMailer.php';
        require __DIR__ . '/../../public/mail/SMTP.php';

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        
        try {
            
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'lndreports2024@gmail.com';
            $mail->Password   = $_ENV['EMAIL_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;                                  
        
            //Recipients
            $mail->setFrom('lndreports2024@gmail.com', 'Learning and Development Inventory Management System');
            $mail->addAddress($email);     //Add a recipient
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $code = substr(str_shuffle('1234567890QWERTYUIOPASDFGHJKLZXCVBNM'),0,10);
            $mail->addEmbeddedImage('/var/task/user/public/assets/img/LOGO.png', 'logo_cid');

            
                $mail->Subject = 'Password Reset Request for (Learning and Development Inventory Management System)';
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
                                                                    <p style="text-align:justify">Your Account in (Learning and Development Inventory Management System) password can be reset by clicking the button below and valid for 1 day. If you did not request a new password, please ignore this email.</p>
                                                                
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="word-break:break-word;font-size:0px;padding:10px 25px;padding-top:20px" align="center">
                                                                <table role="presentation" cellpadding="0" cellspacing="0" style="border-collapse:separate" align="center" border="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="border:none;border-radius:3px;color:white;padding:15px 19px" align="center" valign="middle" bgcolor="#358eca">
                                                                                <a href=https://flldc-ims.vercel.app/change-password?code='.$code.'" style="text-decoration:none;line-height:100%;background:#358eca;color:white;font-family:Ubuntu,Helvetica,Arial,sans-serif;font-size:15px;font-weight:normal;text-transform:none;margin:0px" target="_blank" >
                                                                                Reset Password
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
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
                        
                $codeQuery = $conn->prepare("UPDATE user_account SET reset_token = :code, reset_time = NOW() WHERE email = :email");
                $codeQuery->bindParam(':code', $code, PDO::PARAM_STR);
                $codeQuery->bindParam(':email', $email, PDO::PARAM_STR);
                $codeQuery->execute();

                $mail->send();

                $user_id = '0';
                $action = "Password reset request in email : " . $email;

                $logs = $conn->prepare("INSERT INTO logs (USER_ID, ACTION_MADE) VALUES (:user_id, :action)");

                $logs->bindParam(':user_id', $user_id, PDO::PARAM_STR);
                $logs->bindParam(':action', $action, PDO::PARAM_STR);
                $logs->execute();


                $response['success'] = true;
                $response['title'] = 'Success!';
                $response['message'] = 'Successfully Requested!';
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