<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php


// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

// var_dump($_REQUEST);
$ITEM_NAME =  isset($_POST['item_name']) ? trim($_POST['item_name']) : '';
$QUANTITY =  isset($_POST['quantity']) ? trim($_POST['quantity']) : '';
$REMARKS =  isset($_POST['remarks']) ? trim($_POST['remarks']) : '';
$PURPOSE =  isset($_POST['purpose']) ? trim($_POST['purpose']) : '';
$DESCRIPTION =  isset($_POST['description']) ? trim($_POST['description']) : '';
$DATE_NEEDED =  isset($_POST['date_needed']) ? trim($_POST['date_needed']) : '';

$ITEM_NAME = str_replace("'", "", $ITEM_NAME);


$generate_REQUEST_ID = generate_REQUEST_ID();

        if ($ITEM_NAME == '' || $QUANTITY == '' || $DATE_NEEDED == '') {
            $response['message'] = 'Please fill up all fields with (*) asterisk!';
            echo json_encode($response);
            exit();
        }
        if($decrypted_array['ACCESS'] == 'ADMIN'){
            $EMAIL = isset($_POST['email']) ? trim($_POST['email']) : '';

            if ($EMAIL == '' ) {
                $response['message'] = 'Please enter the email of requestor!';
                echo json_encode($response);
                exit();
            }
        }else{
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
        }

        if (!empty($_FILES['item_photo']['name']) && in_array($_FILES['item_photo']['type'], $fileMimes)) {
            $img = $_FILES['item_photo']['name'];
            $img_type = $_FILES['item_photo']['type'];
            $img_size = $_FILES['item_photo']['size'];
            $img_temp_loc = $_FILES['item_photo']['tmp_name'];
            $img_store = "../ITEM_PHOTO/" . $img;
            move_uploaded_file($img_temp_loc, $img_store);
        }



    if(!$sock = @fsockopen('www.google.com', 80))
   {

    $response['success'] = false;
    $response['title'] = 'Error';
    $response['message'] = 'Please Check Internet Connection!';
    echo json_encode($response);
    exit();
   }

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
   
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function

    require __DIR__ . '/../../public/mail/Exception.php';
    require __DIR__ . '/../../public/mail/PHPMailer.php';
    require __DIR__ . '/../../public/mail/SMTP.php';



    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    
    try {
        $support_emails = [];
        $admins = $conn->prepare("SELECT email FROM user_account WHERE access = 'ADMIN'");
        $admins->execute();

        while ($row_admins = $admins->fetch(PDO::FETCH_ASSOC)) {
            $support_emails[] = $row_admins['email'];
        }
        // $support_emails = ["sueltojhudiel20@gmail.com", "lndreports2024@gmail.com"];
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'lndreports2024@gmail.com';                     //SMTP username
        $mail->Password   = 'yzmxbjcntuwkfdpe';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('lndreports2024@gmail.com', 'Learning and Development Inventory Management System');
        // $mail->addAddress($support_email);     //Add a recipient
        foreach ($support_emails as $email) {
            $mail->addAddress($email);     //Add a recipient
        }
        $code = $generate_REQUEST_ID;
        $ITEM_NAME = $ITEM_NAME;
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $file_path = '/ITEM_PHOTO/'.$img; // Update this with the actual file path
        $mail->addAttachment($file_path);
  
        
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
                                                
                                                                <h2 style="font-family:Whitney,Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-weight:500;font-size:20px;color:#4f545c;letter-spacing:0.27px">Hi good day,</h2>
                                                                <p style="text-align:justify">I hope this message finds you well.</p>
                                                                <p style="text-align:justify">We would like to inform you that a new request has been added to your queue. Please find the details of the request below:</p>
                                                                <p>
                                                                    Submitted by : <b>'.$decrypted_array['fname'].' '.$decrypted_array['mname'].' '.$decrypted_array['lname'].'</b>  
                                                                    <br> Request ID : <b>'.$code.'</b> 
                                                                    <br> Request Item : <b>'.$ITEM_NAME.'</b> 
                                                                    <br> Quantity : <b>'.$QUANTITY.'</b> 
                                                                    <br> Purpose : <b>'.$PURPOSE.'</b> 
                                                                    <br> Date Needed : <b>'.$DATE_NEEDED.'</b> 
                                                                    <br> Item Description : <b>'.$PURPOSE.'</b> 
                                                                    <br> Remarks : <b>'.$REMARKS.'</b> 
                                                                    <br> Item Photo : Please see the attached filed</b> 
                                                                    <br> 
                                                                </p>
                                                                <p> Please click the link below to Approved or Declined the request :</p>
                                                                <a href="https://flldc-ims.vercel.app/">Approved / Declined<a>

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
        

        $mail->AddEmbeddedImage('/img/LOGO.png','logo','LOGO.png');
   
        $mail->send();

        // Prepare the INSERT statement for purchase_order
        $sql = $conn->prepare("INSERT INTO purchase_order (REQUEST_ID, ITEM_NAME, QUANTITY, REMARKS, EMAIL, PURPOSE, DATE_NEEDED, DESCRIPTION, ITEM_PHOTO) 
        VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9)");

        // Execute the prepared statement with the actual values
        $sql->execute([$generate_REQUEST_ID, $ITEM_NAME, $QUANTITY, $REMARKS, $EMAIL, $PURPOSE, $DATE_NEEDED, $DESCRIPTION, $img]);

        // Prepare the INSERT statement for po_history
        $history_title = "Request Created";
        $history_remarks = "Created by Email : " . $EMAIL . "\n" . "Request ID : " . $generate_REQUEST_ID . "\n" . "Request Item: " . $ITEM_NAME . "\n" . "Quantity : " . $QUANTITY .
        "\n" . "Purpose : " . $PURPOSE . "\n" . "Date Needed : " . $DATE_NEEDED . "\n" . "Remarks : " . $REMARKS . 
        "\n" . "Description : " . $DESCRIPTION;

        $sql_history = $conn->prepare("INSERT INTO po_history (REQUEST_ID, TITLE, REMARKS) 
        VALUES ($1, $2, $3)");

        // Execute the prepared statement with the actual values
        $sql_history->execute([$generate_REQUEST_ID, $history_title, $history_remarks]);


        $action = "Added New Request | Request ID : " . $generate_REQUEST_ID . " | Item Name : " . $ITEM_NAME;
        $user_id = $_COOKIE['ID'];
        $logs = $conn->prepare("INSERT INTO logs (USER_ID, ACTION_MADE) VALUES (:user_id, :action)");
        $logs->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $logs->bindParam(':action', $action, PDO::PARAM_STR);
        $logs->execute();

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

}

        
    