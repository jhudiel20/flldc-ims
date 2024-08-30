<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

// PHPMailer integration
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get POST data and sanitize inputs
    $ITEM_NAME = isset($_POST['item_name']) ? trim($_POST['item_name']) : '';
    $QUANTITY = isset($_POST['quantity']) ? trim($_POST['quantity']) : '';
    $REMARKS = isset($_POST['remarks']) ? trim($_POST['remarks']) : '';
    $PURPOSE = isset($_POST['purpose']) ? trim($_POST['purpose']) : '';
    $DESCRIPTION = isset($_POST['description']) ? trim($_POST['description']) : '';
    $DATE_NEEDED = isset($_POST['date_needed']) ? trim($_POST['date_needed']) : '';
    $EMAIL = isset($_POST['email']) ? trim($_POST['email']) : '';

    // Sanitize item name
    $ITEM_NAME = str_replace("'", "", $ITEM_NAME);

    // Generate a unique request ID
    $generate_REQUEST_ID = generate_REQUEST_ID();

    // Validate required fields
    if ($ITEM_NAME == '' || $QUANTITY == '' || $DATE_NEEDED == '') {
        $response['message'] = 'Please fill up all fields with (*) asterisk!';
        echo json_encode($response);
        exit();
    }
    
    $current_access = $decrypted_array['ACCESS'];

    // Check if email is provided for admins
    if ($current_access === 'ADMIN') {
        if ($EMAIL == '') {
            $response['title'] = 'Warning!';
            $response['message'] = 'Please enter the email of requestor!';
            echo json_encode($response);
            exit();
        }
    } else {
        if ($EMAIL == '') {
            $response['title'] = 'Warning!';
            $response['message'] = 'Please enter the email of requestor!';
            echo json_encode($response);
            exit();
        } else {
            $EMAIL = $current_access;
        }
    }

    $githubToken = getenv('GITHUB_TOKEN');

    if (isset($_FILES['item_photo']) && $_FILES['item_photo']['error'] == UPLOAD_ERR_OK) {
        $owner = 'jhudiel20'; // GitHub username or organization
        $repo = 'flldc-user-image';

        $img = $_FILES['item_photo'];
        $img_temp_loc = $img['tmp_name'];
        $fileName = $img['name'];

        $fileContent = file_get_contents($img_temp_loc);

        $base64Content = base64_encode($fileContent);

        // Check if the file exists on GitHub and get its sha if it does
        $apiUrl = "https://api.github.com/repos/$owner/$repo/contents/$fileName";
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

        $mail = new PHPMailer(true);

    try {
        $support_emails = [];
        $admins = $conn->prepare("SELECT email FROM user_account WHERE access = 'ADMIN'");
        $admins->execute();

        while ($row_admins = $admins->fetch(PDO::FETCH_ASSOC)) {
            $support_emails[] = $row_admins['email'];
        }

        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'lndreports2024@gmail.com';
        $mail->Password   = 'yzmxbjcntuwkfdpe';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom('lndreports2024@gmail.com', 'Learning and Development Inventory Management System');
        foreach ($support_emails as $email) {
            $mail->addAddress($email);
        }

        // Content
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
                                            <img alt="" title="" height="100px" width="200px" src="/LOGO.png" width="100" style="">
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
                                                            <p> Please click the link below to Approved or Declined the request :</p>
                                                            <a href="https://flldc-ims.vercel.app/request-list">Approved / Declined<a>
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
    }catch (Exception $e) {
        $response['success'] = false;
        $response['title'] = 'Error';
        $response['message'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        echo json_encode($response);
        exit();
    }


        // Prepare the INSERT statement for purchase_order
        $sql_purchase_order = $conn->prepare("
            INSERT INTO purchase_order(REQUEST_ID, ITEM_NAME, QUANTITY, REMARKS, EMAIL, PURPOSE, DATE_NEEDED, DESCRIPTION, ITEM_PHOTO) 
            VALUES(:request_id, :item_name, :quantity, :remarks, :email, :purpose, :date_needed, :description, :img)
        ");

        // Bind the parameters to the prepared statement
        $sql_purchase_order->bindParam(':request_id', $generate_REQUEST_ID, PDO::PARAM_STR);
        $sql_purchase_order->bindParam(':item_name', $ITEM_NAME, PDO::PARAM_STR);
        $sql_purchase_order->bindParam(':quantity', $QUANTITY, PDO::PARAM_STR);
        $sql_purchase_order->bindParam(':remarks', $REMARKS, PDO::PARAM_STR);
        $sql_purchase_order->bindParam(':email', $EMAIL, PDO::PARAM_STR);
        $sql_purchase_order->bindParam(':purpose', $PURPOSE, PDO::PARAM_STR);
        $sql_purchase_order->bindParam(':date_needed', $DATE_NEEDED, PDO::PARAM_STR);
        $sql_purchase_order->bindParam(':description', $DESCRIPTION, PDO::PARAM_STR);
        $sql_purchase_order->bindParam(':img', $fileName, PDO::PARAM_STR);
        // Execute the prepared statement
        $sql_purchase_order->execute();


        // Prepare and execute INSERT statement for po_history
        $history_title = "Request Created";
        $history_remarks = "Created by Email : " . $EMAIL . "\n" . "Request ID : " . $generate_REQUEST_ID . "\n" . "Request Item: " . $ITEM_NAME . "\n" . "Quantity : " . $QUANTITY .
        "\n" . "Purpose : " . $PURPOSE . "\n" . "Date Needed : " . $DATE_NEEDED . "\n" . "Remarks : " . $REMARKS . 
        "\n" . "Description : " . $DESCRIPTION;

        $sql_history = $conn->prepare("INSERT INTO po_history (REQUEST_ID, TITLE, REMARKS) 
        VALUES (?, ?, ?)");
        $sql_history->execute([$generate_REQUEST_ID, $history_title, $history_remarks]);

        // Log the action
        $action = "Added New Request | Request ID : " . $generate_REQUEST_ID . " | Item Name : " . $ITEM_NAME;
        $user_id = $decrypted_array['ID'];

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
    $errorMessage = $_FILES['item_photo']['error'] ?? 'No file uploaded';
    echo json_encode([
        'success' => false,
        'title' => 'Upload Error',
        'message' => 'File upload failed. Error Code: ' . $errorMessage,
    ]);
    }
    
}
?>
