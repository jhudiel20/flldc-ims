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
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $sbu = isset($_POST['sbu']) ? trim($_POST['sbu']) : '';
    $pcv_no = isset($_POST['pcv_no']) ? trim($_POST['pcv_no']) : '';
    $employee = isset($_POST['employee']) ? trim($_POST['employee']) : '';
    $department = isset($_POST['department']) ? trim($_POST['department']) : '';
    $expenses = isset($_POST['expenses']) ? trim($_POST['expenses']) : '';
    $sdcc = isset($_POST['sdcc']) ? trim($_POST['sdcc']) : '';
    $remarks = isset($_POST['remarks']) ? trim($_POST['remarks']) : '';
    $pcv_date = isset($_POST['pcv_date']) ? trim($_POST['pcv_date']) : '';

    $generate_PCV_ID = generate_PCV_ID();

    if ($sbu == '' || $pcv_no == '' || $employee == '' || $department == '' || $expenses == ''|| $sdcc == '' || $remarks == '' || $pcv_date == '') {
        $response['message'] = 'Please fill up all fields with (*) asterisk!';
        echo json_encode($response);
        exit();
    }

    $sql_check = $conn->prepare("SELECT PCV_NO FROM rca WHERE PCV_NO = :pcv_no");
    $sql_check->bindParam(':pcv_no', $pcv_no, PDO::PARAM_STR);
    $sql_check->execute();
    $row_check = $sql_check->rowCount();
    if ($row_check >= 1) {
        $response['message'] = 'PCV No is already taken!';
        echo json_encode($response);
        exit();
    }

    $githubToken = getenv('GITHUB_TOKEN');
    $githubOwner = getenv('GITHUB_OWNER');
    $githubImages = getenv('GITHUB_IMAGES');

    if ($_FILES['pcv_file']['name'] == '') {
        $response['message'] = 'Please select a photo';
        $response['title'] = 'Warning!';
        echo json_encode($response);
    }

    if (isset($_FILES['pcv_file']) && $_FILES['pcv_file']['error'] == UPLOAD_ERR_OK) {
        $owner = $githubOwner;
        $repo = $githubImages;

        $img = $_FILES['pcv_file'];
        $img_temp_loc = $img['tmp_name'];
        $fileName = $img['name'];
        
        $fileName = str_replace(' ', '-', $fileName);
        $fileContent = file_get_contents($img_temp_loc);
        $base64Content = base64_encode($fileContent);

        // Check if the file exists on GitHub and get its sha if it does
        $apiUrl = "https://api.github.com/repos/$owner/$repo/contents/PCV_ATTACHMENTS/$fileName";
        $data = json_encode([
            'message' => 'Upload image: ' . $fileName,
            'content' => $base64Content,
        ]);

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: token ' . $githubToken,
            'User-Agent: PHP script access',
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            // Handle cURL errors
            echo json_encode([
                'success' => false,
                'title' => 'Curl Error',
                'message' => curl_error($ch),
            ]);
            curl_close($ch);
            exit();
        }

        // Decode the response
        $responseData = json_decode($response, true);

                // Check for a valid JSON response
                if ($responseData === null && json_last_error() !== JSON_ERROR_NONE) {
                    echo json_encode([
                        'success' => false,
                        'title' => 'GitHub API Error',
                        'message' => 'Failed to decode GitHub API response: ' . json_last_error_msg(),
                    ]);
                    curl_close($ch);
                    exit();
                }
        
                // Check if the file was successfully uploaded
                if (isset($responseData['content']['download_url'])) {
                    $img_url = $responseData['content']['download_url'];
                } else {
                    echo json_encode([
                        'success' => false,
                        'title' => 'GitHub API Error',
                        'message' => 'Failed to upload image to GitHub. Response: ' . $response,
                    ]);
                    curl_close($ch);
                    exit();
                }



        // Mailer setup
        require __DIR__ . '/../../public/mail/Exception.php';
        require __DIR__ . '/../../public/mail/PHPMailer.php';
        require __DIR__ . '/../../public/mail/SMTP.php';

        $mail = new PHPMailer(true);

        try {
            $support_emails = [];
            // $admins = $conn->prepare("SELECT email FROM user_account WHERE access = 'ADMIN'");
            // $admins->execute();

            // while ($row_admins = $admins->fetch(PDO::FETCH_ASSOC)) {
            //     $support_emails[] = $row_admins['email'];
            // }
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'lndreports2024@gmail.com';
            $mail->Password   = $_ENV['EMAIL_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('lndreports2024@gmail.com', 'Learning and Development Inventory Management System');
            // foreach ($support_emails as $email) {
            //     $mail->addAddress($email);
            // }
            $mail->addAddress($decrypted_array['EMAIL']);
            $code = $generate_PCV_ID;

            $mail->isHTML(true);
            $mail->addEmbeddedImage('/var/task/user/public/assets/img/LOGO.png', 'logo_cid');
            $mail->Subject = 'New PCV Added';
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
                                                                    <p style="text-align:justify">I hope this message finds you well.</p>
                                                                    <p style="text-align:justify">We would like to inform you that a new Petty Cash Voucher has been added. Please find the details below:</p>
                                                                    <p>
                                                                        Submitted by : <b>' . $decrypted_array['FNAME'] . ' ' . $decrypted_array['MNAME'] . ' ' . $decrypted_array['LNAME'] . '</b>  
                                                                        <br> PCV ID : <b>' . $code . '</b> 
                                                                        <br> PCV NO. : <b>' . $pcv_no . '</b> 
                                                                        <br> Employee Name : <b>' . $employee . '</b> 
                                                                        <br> Total Expenses : ₱ <b>' . $expenses . '</b> 
                                                                        <br> Attachments <a href="' . $img_url . '">here</a> to view or download the file.
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
                                    <td style="height:150px;  border:none;border-radius:3px;color:black;padding:15px 19px" align="center" valign="middle">&copy; 2024-2025 <strong><span>FAST Learning and Development Inventory Management System</span></strong></td>
                                    </tr>
                                </table>
                    </div>
                </div>';
                $mail->send();
        }catch (Exception $e) {
            $response['success'] = false;
            $response['title'] = 'Error';
            $response['message'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            echo json_encode($response);
            exit();
        }
        $date_needed = !empty($date_needed) ? $date_needed : null;
        $date_event = !empty($date_event) ? $date_event : null;
        $date_depart = !empty($date_depart) ? $date_depart : null;
        $date_return = !empty($date_return) ? $date_return : null;

        $sql = $conn->prepare("INSERT INTO rca (RCA_ID,PCV_NO, NAME, SBU, DEPARTMENT, AMOUNT, PCV_DATE, SDCCC, REMARKS, ATTACHMENTS)
        VALUES (:generate_PCV_ID,:pcv_no,:employee,:sbu,:department,:amount,:pcv_date,:sdccc,:remarks,:img)");

                // Bind the parameters to the prepared statement
                $sql->bindParam(':generate_PCV_ID', $generate_PCV_ID, PDO::PARAM_STR);
                $sql->bindParam(':pcv_no', $pcv_no, PDO::PARAM_STR);
                $sql->bindParam(':employee', $employee, PDO::PARAM_STR);
                $sql->bindParam(':sbu', $sbu, PDO::PARAM_STR);
                $sql->bindParam(':department', $department, PDO::PARAM_STR);
                $sql->bindParam(':amount', $expenses, PDO::PARAM_STR);
                $sql->bindParam(':pcv_date', $pcv_date, PDO::PARAM_STR);
                $sql->bindParam(':sdccc', $sdcc, PDO::PARAM_STR);
                $sql->bindParam(':remarks', $remarks, PDO::PARAM_STR);
                $sql->bindParam(':img', $fileName, PDO::PARAM_STR);
                // Execute the prepared statement
                $sql->execute();

                $user_id = $decrypted_array['ID'];
                $action = "Added New PCV | PCV ID : " . $generate_PCV_ID . " | PCV NO. : " . $pcv_no;

                $logs = $conn->prepare("INSERT INTO logs (USER_ID, ACTION_MADE) VALUES (:user_id, :action)");

                $logs->bindParam(':user_id', $user_id, PDO::PARAM_STR);
                $logs->bindParam(':action', $action, PDO::PARAM_STR);
                $logs->execute();

            if (curl_errno($ch)) {
                // Output curl errors for debugging
                echo json_encode([
                    'success' => false,
                    'title' => 'Curl Error',
                    'message' => curl_error($ch),
                ]);
            } else {
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if ($httpCode == 201) {
                    // Successful upload
                    echo json_encode([
                        'success' => true,
                        'title' => 'Success',
                        'message' => 'Successfully Added',
                    ]);
                } else {
                    // Output response for debugging
                    echo json_encode([
                        'success' => false,
                        'title' => 'GitHub API Error',
                        'message' => 'Failed to upload file. HTTP Code: ' . $httpCode . ' Response: ' . $response,
                    ]);
                }
            }


            curl_close($ch);
    }else{
        // Handle the case where no file is uploaded or an error occurred
        $errorMessage = $_FILES['pcv_file']['error'] ?? 'No file uploaded';
        echo json_encode([
            'success' => false,
            'title' => 'Upload Error',
            'message' => 'File upload failed. Error Code: ' . $errorMessage,
        ]);
    }

}
?>