<?php
if (!isset($_COOKIE['secure_data'])){
    header("Location: /");
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../config/config.php'; // Adjusted path for config.php

// PHPMailer integration
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

$fname = isset($_POST['fname']) ? trim($_POST['fname']) : '';
$mname = isset($_POST['mname']) ? trim($_POST['mname']) : '';
$lname = isset($_POST['lname']) ? trim($_POST['lname']) : '';
$suffix = isset($_POST['suffix']) ? trim($_POST['suffix']) : '';


$contact = isset($_POST['contact']) ? trim($_POST['contact']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$access = isset($_POST['access']) ? trim($_POST['access']) : '';

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// if(!preg_match(ACCESS,$access)){
//     $response['message'] = 'Access did not match!';
//     echo json_encode($response);
//     exit();
// }

if ($username == '' || $password == '' || $fname == '' || $lname == ''  || $email == '' || $access == '') {
    $response['message'] = 'Please fill up all fields with (*) asterisk!';
    echo json_encode($response);
    exit();
}
if(!preg_match('@[A-Z]@',$password)){
    $response['message'] = 'Password must include at least one Uppercase Letter!';
    echo json_encode($response);
    exit();
}
if(!preg_match('@[a-z]@',$password)){
    $response['message'] = 'Password must include at least one Lowercase Letter!';
    echo json_encode($response);
    exit();
}
if(!preg_match('@[0-9]@',$password)){
    $response['message'] = 'Password must include at least one Number!';
    echo json_encode($response);
    exit();
}
if(strlen($password) < 8){
    $response['message'] = 'Password must be at least 8 characters in length!';
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


$db_email = $conn->prepare("SELECT email FROM user_account WHERE EMAIL = :email ");
$db_email->bindParam(':email',$email, PDO::PARAM_STR);
$db_email->execute();
$row_email_count = $db_email->rowCount();

// Check if the query returned any rows
if ($row_email_count > 0) {
    $response['success'] = false;
    $response['title'] = "Error!";
    $response['message'] = 'Email already registered!';
    echo json_encode($response);
}

$db_username = $conn->prepare("SELECT username FROM user_account WHERE username = :username ");
$db_username->bindParam(':username',$username, PDO::PARAM_STR);
$db_username->execute();
$row_username_count = $db_username->rowCount();

// Check if the query returned any rows
if ($row_username_count > 0) {
    $response['success'] = false;
    $response['title'] = "Error!";
    $response['message'] = 'Username already taken!';
    echo json_encode($response);
}

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
            $mail->addAddress($email);     //Add a recipient
            $mail->addEmbeddedImage('/var/task/user/public/assets/img/LOGO.png', 'logo_cid');
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML

            
                $mail->Subject = 'Account for LDIMS (Learning and Development Inventory Management System)';
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
                                                                    <p style="text-align:justify">Your LDIMS (Learning and Development Inventory Management System) account has been successfully created. To complete the setup of your account, please click the button below. If you did not request this account creation, please ignore this email.</p>
                                                                    <p>Login Credentials : </p> 
                                                                    <p>Username : '.$username.'</p>
                                                                    <p>Password : '.$password.'</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="word-break:break-word;font-size:0px;padding:10px 25px;padding-top:20px" align="center">
                                                                <table role="presentation" cellpadding="0" cellspacing="0" style="border-collapse:separate" align="center" border="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="border:none;border-radius:3px;color:white;padding:15px 19px" align="center" valign="middle" bgcolor="#358eca">
                                                                            
                                                                                <a href="https://flldc-ims.vercel.app" style="text-decoration:none;line-height:100%;background:#358eca;color:white;font-family:Ubuntu,Helvetica,Arial,sans-serif;font-size:15px;font-weight:normal;text-transform:none;margin:0px" target="_blank" >
                                                                                Login
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
            
                $password = set_password($password);
                $approved_status = '2';
                $admin_status = 'DEFAULT';
                $locked = 0;
            $create_user = $conn->prepare(" INSERT INTO user_account(USERNAME, PASSWORD, EMAIL, FNAME, MNAME, LNAME, EXT_NAME, ACCESS, APPROVED_STATUS, ADMIN_STATUS, CONTACT, LOCKED) 
                VALUES(:username, :password, :email, :fname, :mname, :lname, :ext_name, :access, :approved_status, :admin_status, :contact, :locked)
            ");
    
            // Bind the parameters to the prepared statement
            $create_user->bindParam(':username', $username, PDO::PARAM_STR);
            $create_user->bindParam(':password', $password, PDO::PARAM_STR);
            $create_user->bindParam(':email', $email, PDO::PARAM_STR);
            $create_user->bindParam(':fname', $fname, PDO::PARAM_STR);
            $create_user->bindParam(':mname', $mname, PDO::PARAM_STR);
            $create_user->bindParam(':lname', $lname, PDO::PARAM_STR);
            $create_user->bindParam(':ext_name', $suffix, PDO::PARAM_STR);
            $create_user->bindParam(':access', $access, PDO::PARAM_STR);
            $create_user->bindParam(':approved_status', $approved_status, PDO::PARAM_STR);
            $create_user->bindParam(':admin_status', $admin_status, PDO::PARAM_STR);
            $create_user->bindParam(':contact', $contact, PDO::PARAM_STR);
            $create_user->bindParam(':locked', $locked, PDO::PARAM_STR);
            // Execute the prepared statement
            $create_user->execute();


            $action = "Inserted New User ";
            $user_id = $decrypted_array['ID'];
    
            $logs = $conn->prepare("INSERT INTO logs (USER_ID, ACTION_MADE) VALUES (:user_id, :action)");

            $logs->bindParam(':user_id', $user_id, PDO::PARAM_STR);
            $logs->bindParam(':action', $action, PDO::PARAM_STR);
            $logs->execute();

            $response['success'] = true;
            $response['title'] = 'Success';
            $response['message'] = 'Successfully Inserted New User!';
            echo json_encode($response);
            $mail->send();
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