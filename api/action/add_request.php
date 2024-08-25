<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get POST data
    $ITEM_NAME = isset($_POST['item_name']) ? trim($_POST['item_name']) : '';
    $QUANTITY = isset($_POST['quantity']) ? trim($_POST['quantity']) : '';
    $REMARKS = isset($_POST['remarks']) ? trim($_POST['remarks']) : '';
    $PURPOSE = isset($_POST['purpose']) ? trim($_POST['purpose']) : '';
    $DESCRIPTION = isset($_POST['description']) ? trim($_POST['description']) : '';
    $DATE_NEEDED = isset($_POST['date_needed']) ? trim($_POST['date_needed']) : '';

    // Sanitize item name
    $ITEM_NAME = str_replace("'", "", $ITEM_NAME);

    $generate_REQUEST_ID = generate_REQUEST_ID();

    // Validate fields
    if ($ITEM_NAME == '' || $QUANTITY == '' || $DATE_NEEDED == '') {
        $response['message'] = 'Please fill up all fields with (*) asterisk!';
        echo json_encode($response);
        exit();
    }

    if ($decrypted_array['ACCESS'] == 'ADMIN') {
        $EMAIL = isset($_POST['email']) ? trim($_POST['email']) : '';
        if ($EMAIL == '') {
            $response['message'] = 'Please enter the email of requestor!';
            echo json_encode($response);
            exit();
        }
    } else {
        $EMAIL = $decrypted_array['EMAIL'];
    }

    $fileMimes = array(
        'image/gif',
        'image/jpeg',
        'image/jpg',
        'image/png',
        'application/pdf'
    );

    if ($_FILES['item_photo']['name'] == '') {
        $response['message'] = 'Please select a photo';
        $response['title'] = 'Warning!';
        echo json_encode($response);
        exit();
    }

    if (!empty($_FILES['item_photo']['name']) && in_array($_FILES['item_photo']['type'], $fileMimes)) {
        $img = $_FILES['item_photo']['name'];
        $img_temp_loc = $_FILES['item_photo']['tmp_name'];
        $githubToken = getenv('GITHUB_TOKEN');
        // Define the GitHub API URL
        $githubApiUrl = 'https://api.github.com/repos/jhudiel20/flldc-user-image/contents/requested-items/' . $img;

        // Read the file content
        $fileContent = file_get_contents($img);

        // Prepare the data for GitHub API
        $data = json_encode([
            'message' => 'Upload image: ' . $img,
            'content' => base64_encode($fileContent)
        ]);

        // Initialize cURL
        $ch = curl_init($githubApiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: token ' . $githubToken,  // Replace YOUR_GITHUB_TOKEN with your actual token
            'User-Agent: PHP Script',
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);
        if (isset($responseData['content']['download_url'])) {
            $img_url = $responseData['content']['download_url'];
        } else {
            $response['message'] = 'Failed to upload image to GitHub.';
            echo json_encode($response);
            exit();
        }
    } else {
        $response['message'] = 'Invalid file type.';
        echo json_encode($response);
        exit();
    }

    if (!$sock = @fsockopen('www.google.com', 80)) {
        $response['success'] = false;
        $response['title'] = 'Error';
        $response['message'] = 'Please Check Internet Connection!';
        echo json_encode($response);
        exit();
    }

    // Send email using PHPMailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require __DIR__ . '/../../public/mail/Exception.php';
    require __DIR__ . '/../../public/mail/PHPMailer.php';
    require __DIR__ . '/../../public/mail/SMTP.php';

    $mail = new PHPMailer(true);

    try {
        $support_emails = [];
        $admins = $conn->prepare("SELECT email FROM user_account WHERE access = 'ADMIN'");
        $admins->execute();

        while ($row_admins = $admins->fetch(PDO::FETCH_ASSOC)) {
            $support_emails[] = $row_admins['email'];
        }

        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'lndreports2024@gmail.com';
        $mail->Password   = 'yzmxbjcntuwkfdpe';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        //Recipients
        $mail->setFrom('lndreports2024@gmail.com', 'Learning and Development Inventory Management System');
        foreach ($support_emails as $email) {
            $mail->addAddress($email);
        }

        $mail->isHTML(true);
        $mail->Subject = 'New Request Added';
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
                    
                                                            <h2 style="font-family:Whitney,Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:18px;line-height:28px;margin:0px">New Request Submitted</h2>
                                                            <p>Dear Admin,</p>
                                                            <p>A new request has been submitted:</p>
                                                            <p><b>Request ID:</b> ' . $generate_REQUEST_ID . '<br>
                                                            <b>Item Name:</b> ' . $ITEM_NAME . '<br>
                                                            <b>Quantity:</b> ' . $QUANTITY . '<br>
                                                            <b>Description:</b> ' . $DESCRIPTION . '<br>
                                                            <b>Purpose:</b> ' . $PURPOSE . '<br>
                                                            <b>Date Needed:</b> ' . $DATE_NEEDED . '<br>
                                                            <b>Remarks:</b> ' . $REMARKS . '<br>
                                                            <b>Image:</b> <a href="' . $img_url . '">View Image</a></p>
                                                            <p>Best Regards,<br>L&D Inventory Management System</p>
                                                        </div>
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
                </div>
            </div>
        ';

        $mail->send();
        $response['success'] = true;
        $response['title'] = 'Success';
        $response['message'] = 'Request added successfully!';
        echo json_encode($response);
        exit();

    } catch (Exception $e) {
        $response['success'] = false;
        $response['title'] = 'Error';
        $response['message'] = 'Mailer Error: ' . $mail->ErrorInfo;
        echo json_encode($response);
        exit();
    }
}
?>
