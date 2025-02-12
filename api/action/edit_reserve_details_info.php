<?php
if (!isset($_COOKIE['secure_data'])){
    header("Location: /");
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

// var_dump($_REQUEST);
$id = isset($_POST['ID']) ? trim($_POST['ID']) : '';
$reserve_status =  isset($_POST['reserve_status']) ? trim($_POST['reserve_status']) : '';
$reserve_date =  isset($_POST['reserve_date']) ? trim($_POST['reserve_date']) : '';
$fname =  isset($_POST['fname']) ? trim($_POST['fname']) : '';
$lname =  isset($_POST['lname']) ? trim($_POST['lname']) : '';
$time =  isset($_POST['time']) ? trim($_POST['time']) : '';
$setup =  isset($_POST['setup']) ? trim($_POST['setup']) : '';
$businessunit =  isset($_POST['businessunit']) ? trim($_POST['businessunit']) : '';
$guest =  isset($_POST['guest']) ? trim($_POST['guest']) : '';
$contact =  isset($_POST['contact']) ? trim($_POST['contact']) : '';
$email =  isset($_POST['email']) ? trim($_POST['email']) : '';
$message =  isset($_POST['message']) ? trim($_POST['message']) : '';
$bookingID =  isset($_POST['bookingID']) ? trim($_POST['bookingID']) : '';
$reservationID =  isset($_POST['reservationID']) ? trim($_POST['reservationID']) : '';
$reason_message =  isset($_POST['reason_message']) ? trim($_POST['reason_message']) : '';

$room_value =  isset($_POST['room']) ? trim($_POST['room']) : '';

list($room, $room_id) = explode('|', $room_value);

if (empty($reason_message) || $reason_message == '') {
    $response['success'] = false;
    $response['title'] = 'Error';
    $response['message'] = 'Please provide a message!';
    echo json_encode($response);
    exit();
}
$updated_time = $time;
$selected_time = $time;

$time_slots = [
    "7:00AM-12:00PM" => ['overlaps' => ["7:00AM-12:00PM", "7:00AM-6:00PM"]],
    "1:00PM-6:00PM" => ['overlaps' => ["1:00PM-6:00PM", "7:00AM-6:00PM"]],
    "7:00AM-6:00PM" => ['overlaps' => ["7:00AM-12:00PM", "1:00PM-6:00PM", "7:00AM-6:00PM"]]
];
$overlapping_times = $time_slots[$selected_time]['overlaps'];

// Prepare placeholders for the query (using named placeholders instead of positional ones)
$inPlaceholders = [];
for ($i = 0; $i < count($overlapping_times); $i++) {
    $inPlaceholders[] = ':time' . $i;
}
$inClause = implode(',', $inPlaceholders);

// Prepare the SQL query to check for overlapping reservations for the selected room and date
$counter = $conn->prepare("
    SELECT * FROM reservations 
    WHERE room = :room 
    AND reserve_date = :reserve_date
    AND reserve_status = 'APPROVED'
    AND ID != :tableID
    AND time IN ($inClause)
");

$counter->bindParam(':tableID', $id, PDO::PARAM_STR);
$counter->bindParam(':room', $room, PDO::PARAM_STR);
$counter->bindParam(':reserve_date', $reserve_date, PDO::PARAM_STR);

// Bind the overlapping time slots dynamically
foreach ($overlapping_times as $index => $time) {
    $counter->bindValue(':time' . $index, $time, PDO::PARAM_STR);
}

// Execute the query
$counter->execute();

    if($reserve_status == 'APPROVED'){
        if ($counter->rowCount() > 0) {
            // If a record exists, the room is already booked for the selected time slot
            $response['success'] = false;
            $response['title'] = 'Error';
            $response['message'] = 'The room is already booked for the selected date and time. Please choose another time or date.';
            echo json_encode($response);
            exit();  // Stop further execution
        }
    }


// Mailer setup
require __DIR__ . '/../../public/mail/Exception.php';
require __DIR__ . '/../../public/mail/PHPMailer.php';
require __DIR__ . '/../../public/mail/SMTP.php';

$mail = new PHPMailer(true);
$generateReserveID  = generateReserveID();
try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'lndreports2024@gmail.com';                     //SMTP username
    $mail->Password = $_ENV['EMAIL_PASS'];                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('lndreports2024@gmail.com', 'Learning and Development Inventory Management System');
    $mail->addAddress($email);     //Add a recipient
    $mail->addEmbeddedImage($_SERVER['DOCUMENT_ROOT'] . '/public/assets/img/LOGO.png', 'logo_cid');
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML

    if($reserve_status == 'APPROVED'){
        $mail->Subject = 'Updates in your Booking ID : '.$bookingID;
        $mail->addAttachment($_SERVER['DOCUMENT_ROOT'] . '/public/assets/Reservation-Terms-and-Agreement.pdf', 'Reservation-Terms-and-Agreement.pdf.pdf'); 
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
                                                    <img alt="" title="" height="100px" width="200px" src="cid:logo_cid" style="">
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
                                                            <p style="text-align:justify">We would like to inform you of a change in your reservation details but your reservation has been approved!. We apologize for any inconvenience caused by this adjustment. Below are the updated details of your reservation. Please present the reservation ID at the security desk when you arrive at the center.</p>
                                                            
                                                            <p><strong>Updated Reservation Details:</strong><br>
                                                            '.($reservationID == 'PENDING' ? '<b>Reservation ID:</b> '.$generateReserveID.'<br>' : '<b>Booking ID:</b> '.$bookingID.'<br>').'
                                                            <b>Room:</b> '.$room.'<br>
                                                            <b>Setup:</b> '.$setup.'<br>
                                                            <b>Date:</b> '.$reserve_date.'<br>                               
                                                            <b>Time:</b> '.$time.'<br>
                                                            <b>Reply from Admin :</b> '.$reason_message.'<br>
                                                            </p>

                                                            <p style="text-align:justify">If you are not willing to accept these changes, please email us at jppsolis@fast.com.ph or contact us at +63 969 450 9412 as soon as possible, and we will assist you further. We apologize again for the inconvenience and look forward to accommodating you at the FAST Learning and Development Center.</p>
                                                            <p style="text-align:justify">Thank you for your understanding and continued trust in FAST Learning and Development Center.</p>
                                                            
                                                            <p style="text-align:center; margin-top: 20px;">
                                                                <a href="https://flldc-booking-app.vercel.app/check" style="background-color:#4CAF50;color:white;padding:12px 24px;text-align:center;text-decoration:none;border-radius:4px;font-size:16px;display:inline-block">Cancel Booking</a>
                                                            </p>
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
                        <td style="height:150px; border:none;border-radius:3px;color:black;padding:15px 19px" align="center" valign="middle">&copy; 2024-2025 <strong><span>FAST Learning and Development Center</span></strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        ';
    }else{
        $mail->Subject = 'Updates in your Booking ID : '.$bookingID;
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
                                                    <img alt="" title="" height="100px" width="200px" src="cid:logo_cid" style="">
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
                                                            <p style="text-align:justify">We regret to inform you that your reservation has been declined. We sincerely apologize for any inconvenience this may have caused. Below are the details of your declined reservation:</p>
                                                            
                                                            <p><strong>Reservation Details:</strong><br>
                                                           '.($reservationID == 'PENDING' ? '<b>Reservation ID:</b> '.$reservationID.'<br>' : '<b>Booking ID:</b> '.$bookingID.'<br>').'
                                                            <b>Business Unit:</b> '.$businessunit.'<br>
                                                            <b>Room:</b> '.$room.'<br>
                                                            <b>Contact:</b> '.$contact.'<br>
                                                            <b>Email:</b> '.$email.'<br>
                                                            <b>Date:</b> '.$reserve_date.'<br>   
                                                            <b>Time:</b> '.$time.'<br>
                                                            <b>Setup:</b> '.$setup.'<br>
                                                            <b>Reserved By:</b> '.$fname.' '.$lname.'<br>
                                                            <b>Message :</b> '.$message.'<br>
                                                            </p>

                                                            <p style="text-align:justify">We understand that this may disrupt your plans, and we are happy to assist you with rescheduling your reservation or exploring other options. Please feel free to reach out to us at jppsolis@fast.com.ph or call us at +63 969 450 9412 if you would like to discuss alternative arrangements.</p>
                                                            <p style="text-align:justify">We apologize once again for the inconvenience and appreciate your understanding. We look forward to assisting you with future reservations at FAST Learning and Development Center.</p>
                                                            
                                                            <p style="text-align:center; margin-top: 20px;">
                                                                <a href="https://flldc-booking-app.vercel.app/check" style="background-color:#4CAF50;color:white;padding:12px 24px;text-align:center;text-decoration:none;border-radius:4px;font-size:16px;display:inline-block">Cancel Booking</a>
                                                            </p>
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
                        <td style="height:150px; border:none;border-radius:3px;color:black;padding:15px 19px" align="center" valign="middle">&copy; 2024-2025 <strong><span>FAST Learning and Development Center</span></strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        ';
    }

    $mail->send();

    if($reserve_status == 'APPROVED'){
        $sql = $conn->prepare("UPDATE reservations SET reservation_id = :reservation_id, RESERVE_STATUS = :reserve_status, RESERVE_DATE = :reserve_date, FNAME = :fname, 
        LNAME = :lname, ROOM = :room, time = :selected_time, SETUP = :setup, BUSINESS_UNIT = :businessunit, GUEST = :guest, CONTACT = :contact, EMAIL = :email, MESSAGE = :message, roomid = :roomid WHERE ID = :id ");
        $sql->bindParam(':reserve_status', $reserve_status, PDO::PARAM_STR);
        $sql->bindParam(':reservation_id', $generateReserveID, PDO::PARAM_STR);

        $sql->bindParam(':reserve_date', $reserve_date, PDO::PARAM_STR);
        $sql->bindParam(':fname', $fname, PDO::PARAM_STR);
        $sql->bindParam(':lname', $lname, PDO::PARAM_STR);
        $sql->bindParam(':selected_time', $updated_time, PDO::PARAM_STR);
        $sql->bindParam(':room', $room, PDO::PARAM_STR);
        $sql->bindParam(':setup', $setup, PDO::PARAM_STR);
        $sql->bindParam(':businessunit', $businessunit, PDO::PARAM_STR);
        $sql->bindParam(':guest', $guest, PDO::PARAM_STR);
        $sql->bindParam(':contact', $contact, PDO::PARAM_STR);
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->bindParam(':message', $message, PDO::PARAM_STR);
        $sql->bindParam(':roomid', $room_id, PDO::PARAM_STR);
        $sql->bindParam(':id', $id, PDO::PARAM_STR);
        $sql->execute();

        $user_id = $decrypted_array['ID'];
        $action = "Updated Booking Details | Booking ID : ".$bookingID;

        $logs = $conn->prepare("INSERT INTO logs (USER_ID, ACTION_MADE) VALUES (:user_id, :action)");

        $logs->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $logs->bindParam(':action', $action, PDO::PARAM_STR);
        $logs->execute();

        $response['success'] = true;
        $response['title'] = 'Success';
        $response['message'] = 'Successfully Updated!';
        echo json_encode($response);
        exit();

    }else{
        $declined_status = 'DECLINED';
        $sql = $conn->prepare("UPDATE reservations SET RESERVE_STATUS = :reserve_status, reservation_id = :reservation_id, RESERVE_DATE = :reserve_date, FNAME = :fname, 
        LNAME = :lname, ROOM = :room, time = :selected_time, SETUP = :setup, BUSINESS_UNIT = :businessunit, GUEST = :guest, 
        CONTACT = :contact, EMAIL = :email, MESSAGE = :message, roomid = :roomid WHERE ID = :id ");
        $sql->bindParam(':reservation_id', $declined_status, PDO::PARAM_STR);
        $sql->bindParam(':reserve_status', $reserve_status, PDO::PARAM_STR);
        $sql->bindParam(':reserve_date', $reserve_date, PDO::PARAM_STR);
        $sql->bindParam(':fname', $fname, PDO::PARAM_STR);
        $sql->bindParam(':lname', $lname, PDO::PARAM_STR);
        $sql->bindParam(':selected_time', $updated_time, PDO::PARAM_STR);
        $sql->bindParam(':room', $room, PDO::PARAM_STR);
        $sql->bindParam(':setup', $setup, PDO::PARAM_STR);
        $sql->bindParam(':businessunit', $businessunit, PDO::PARAM_STR);
        $sql->bindParam(':guest', $guest, PDO::PARAM_STR);
        $sql->bindParam(':contact', $contact, PDO::PARAM_STR);
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->bindParam(':message', $message, PDO::PARAM_STR);
        $sql->bindParam(':roomid', $room_id, PDO::PARAM_STR);
        $sql->bindParam(':id', $id, PDO::PARAM_STR);
        $sql->execute();
    
        $user_id = $decrypted_array['ID'];
        $action = "Updated Booking Details | Booking ID : ".$bookingID;
    
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

    



    
}catch (Exception $e) {
    // If an error occurs during sending email
    $response['success'] = false;
    $response['title'] = 'Error';
    $response['message'] = 'Email could not be sent. Error: ' . $mail->ErrorInfo;
    echo json_encode($response);
    exit();
} 

}
