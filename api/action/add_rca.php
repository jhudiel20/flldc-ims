<?php

require '../DBConnection.php';
include '../config/config.php';

response();
// var_dump($_REQUEST);

$employee = mysqli_real_escape_string($conn, isset($_POST['employee']) ? trim($_POST['employee']) : '');
$employee_no = mysqli_real_escape_string($conn, isset($_POST['employee_no']) ? trim($_POST['employee_no']) : '');
$paygroup = mysqli_real_escape_string($conn, isset($_POST['paygroup']) ? trim($_POST['paygroup']) : '');
$sbu = mysqli_real_escape_string($conn, isset($_POST['sbu']) ? trim($_POST['sbu']) : '');
$branch = mysqli_real_escape_string($conn, isset($_POST['branch']) ? trim($_POST['branch']) : '');
$amount = mysqli_real_escape_string($conn, isset($_POST['amount']) ? trim($_POST['amount']) : '');
$payee = mysqli_real_escape_string($conn, isset($_POST['payee']) ? trim($_POST['payee']) : '');
$account_no = mysqli_real_escape_string($conn, isset($_POST['account_no']) ? trim($_POST['account_no']) : '');
$purpose_rca = mysqli_real_escape_string($conn, isset($_POST['purpose_rca']) ? trim($_POST['purpose_rca']) : '');
$date_needed = mysqli_real_escape_string($conn, isset($_POST['date_needed']) ? trim($_POST['date_needed']) : '');
$date_event = mysqli_real_escape_string($conn, isset($_POST['date_event']) ? trim($_POST['date_event']) : '');
$purpose_travel = mysqli_real_escape_string($conn, isset($_POST['purpose_travel']) ? trim($_POST['purpose_travel']) : '');
$date_depart = mysqli_real_escape_string($conn, isset($_POST['date_depart']) ? trim($_POST['date_depart']) : '');
$date_return = mysqli_real_escape_string($conn, isset($_POST['date_return']) ? trim($_POST['date_return']) : '');

$generate_RCA_ID = generate_RCA_ID();

if (
    $employee == '' || $employee_no == '' || $paygroup == '' || $sbu == '' || $branch == ''
    || $amount == '' || $payee == '' || $account_no == ''
) {
    $response['message'] = 'Please fill up all fields with (*) asterisk!';
    echo json_encode($response);
    exit();
}

$EMAIL = $_SESSION['EMAIL'];

      $fileMimes = array(
            'image/gif',
            'image/jpeg',
            'image/jpg',
            'image/png',
            'application/pdf'
        );

        if ($_FILES['receipt']['name'] == '') {
            $response['message'] = 'Please select attachment';
            $response['title'] = 'Warning!';
            echo json_encode($response);
            exit();
        }

        if (!empty($_FILES['receipt']['name']) && in_array($_FILES['receipt']['type'], $fileMimes)) {
            $img = $_FILES['receipt']['name'];
            $img_type = $_FILES['receipt']['type'];
            $img_size = $_FILES['receipt']['size'];
            $img_temp_loc = $_FILES['receipt']['tmp_name'];
            $img_store = "../RCA_ATTACHMENTS/" . $img;
            move_uploaded_file($img_temp_loc, $img_store);
        }


if (!$sock = @fsockopen('www.google.com', 80)) {
    $response['success'] = false;
    $response['title'] = 'Error';
    $response['message'] = 'Please Check Internet Connection!';
    echo json_encode($response);
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../mail/Exception.php';
require '../mail/PHPMailer.php';
require '../mail/SMTP.php';

$mail = new PHPMailer(true);

try {
    $support_emails = [];
    $admins = mysqli_query($conn_acc, "SELECT EMAIL FROM user_account WHERE ACCESS = 'ADMIN' ");
    while ($row_admins = mysqli_fetch_assoc($admins)) {
        $support_emails[] = $row_admins['EMAIL'];
    }
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'lndreports2024@gmail.com';
    $mail->Password = 'yzmxbjcntuwkfdpe';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom('lndreports2024@gmail.com', 'Learning and Development Inventory Management System');
    foreach ($support_emails as $email) {
        $mail->addAddress($email);
    }
    $code = $generate_RCA_ID;

    $mail->isHTML(true);
    $file_path = '../RCA_ATTACHMENTS/' . $img;
    $mail->addAttachment($file_path);

    $mail->Subject = 'New RCA Added';
    $mail->Body = '
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
                                                                    <img alt="" title="" height="100px" width="200px" src="cid:logo" width="100" style="">
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
                                                            <p style="text-align:justify">I hope this message finds you well.</p>
                                                            <p style="text-align:justify">We would like to inform you that a new Request for Cash Advance has been added. Please find the details below:</p>
                                                            <p>
                                                                Submitted by : <b>' . $_SESSION['FNAME'] . ' ' . $_SESSION['MNAME'] . ' ' . $_SESSION['LNAME'] . '</b>  
                                                                <br> RCA ID : <b>' . $code . '</b> 
                                                                <br> Employee Name : <b>' . $employee . '</b> 
                                                                <br> Amount : ₱ <b>' . $amount . '</b> 
                                                                <br>' . (empty($purpose_rca) ? 'Purpose of Travel : <b>' . $purpose_travel : 'Purpose of RCA : <b>' . $purpose_rca) . '</b>
                                                                <br>' . (empty($date_needed) ? 'Date of Departure : <b>' . $date_depart : 'Date Needed : <b>' . $date_needed) . '</b>
                                                                <br>' . (empty($date_event) ? 'Date of Return : <b>' . $date_return : 'Date Event : <b>' . $date_event) . '</b>
                                                                <br> Attachments : Please see the attached file.
                                                            </p>
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
                    <td style="height:150px;  border:none;border-radius:3px;color:black;padding:15px 19px" align="center"
                        valign="middle">&copy; 2024-2025 <strong><span>FAST Learning and Development Inventory Management
                                System</span></strong></td>
                </tr>
            </table>
        </div>
</div>
';


$mail->AddEmbeddedImage('../assets/img/LOGO.png','logo','LOGO.png');

$mail->send();

$sql = mysqli_query($conn, "INSERT INTO `rca_history` (`RCA_ID`, `NAME`, `EMPLOYEE_NO`, `PAYGROUP`, `SBU`, `BRANCH`, 
`AMOUNT`, `PAYEE_NAME`, `ACCOUNT_NO`, `PURPOSE_RCA`, `DATE_NEEDED`, `DATE_EVENT`, `PURPOSE_TRAVEL`, `DATE_DEPART`, 
`DATE_RETURN`,`ATTACHMENTS`)
VALUES
('$generate_RCA_ID','$employee','$employee_no','$paygroup','$sbu','$branch','$amount','$payee','$account_no','$purpose_rca',
'$date_needed','$date_event','$purpose_travel','$date_depart','$date_return','$img')");




$user_id = $_SESSION['ID'];
$action = "Added New RCA | RCA ID : " . $generate_RCA_ID . " | Amount : " . $amount;

$logs = mysqli_query($conn, "INSERT INTO `logs` (`USER_ID`,`ACTION_MADE`) VALUES('$user_id','$action')");

$response['success'] = true;
$response['title'] = 'Success';
$response['message'] = 'Successfully Added!';
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