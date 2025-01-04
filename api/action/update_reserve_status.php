<?php
if (!isset($_COOKIE['secure_data'])) {
    header("Location: /");
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../config/config.php'; // Adjusted path for config.php
require_once __DIR__ . '/../pdf/tcpdf.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Define GitHub API details
$githubToken = getenv('GITHUB_TOKEN'); // Your GitHub token from environment variables
$owner = getenv('GITHUB_OWNER');       // GitHub username or organization
$repo = getenv('GITHUB_IMAGES');   

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $approval_status = isset($_POST['approval_status']) ? trim($_POST['approval_status']) : '';
    $ID = isset($_POST['ID']) ? trim($_POST['ID']) : '';
    $ROOMID = isset($_POST['ROOMID']) ? trim($_POST['ROOMID']) : '';
    $EMAIL = isset($_POST['EMAIL']) ? trim($_POST['EMAIL']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    if (empty($message) || $message == '') {
        $response['success'] = false;
        $response['title'] = 'Error';
        $response['message'] = 'Please provide a message!';
        echo json_encode($response);
        exit();
    }


    $sql = $conn->prepare("SELECT * FROM reservations join room_details on room_id = :roomid WHERE reservations.ID = :id ");
    $sql->bindParam(':roomid', $ROOMID, PDO::PARAM_STR);
    $sql->bindParam(':id', $ID, PDO::PARAM_STR);
    $sql->execute();
    $row = $sql->fetch(PDO::FETCH_ASSOC);

    $selected_time = $row['time'];
    $room = $row['room'];
    $reserve_date = $row['reserve_date'];

    // Define time slots and their relationships (what overlaps with what)
    $time_slots = [
        "7:00AM-12:00PM" => ['overlaps' => ["7:00AM-12:00PM", "7:00AM-6:00PM"]],
        "1:00PM-6:00PM" => ['overlaps' => ["1:00PM-6:00PM", "7:00AM-6:00PM"]],
        "7:00AM-6:00PM" => ['overlaps' => ["7:00AM-12:00PM", "1:00PM-6:00PM", "7:00AM-6:00PM"]]
    ];

    // Get the overlapping time slots for the selected time
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
    AND reserve_status = :reserve_status
    AND time IN ($inClause)
");

    $counter->bindParam(':room', $room, PDO::PARAM_STR);
    $counter->bindParam(':reserve_date', $reserve_date, PDO::PARAM_STR);
    $counter->bindParam(':reserve_status', $approval_status, PDO::PARAM_STR);

    // Bind the overlapping time slots dynamically
    foreach ($overlapping_times as $index => $time) {
        $counter->bindValue(':time' . $index, $time, PDO::PARAM_STR);
    }

    // Execute the query
    $counter->execute();

    // Check if any conflicting reservation exists
    if ($counter->rowCount() > 0) {
        // If a record exists, the room is already booked for the selected time slot
        $response['success'] = false;
        $response['title'] = 'Error';
        $response['message'] = 'The room is already booked for the selected date and time. Please choose another time or date.';
        echo json_encode($response);
        exit();  // Stop further execution
    }

    // Mailer setup
    require __DIR__ . '/../../public/mail/Exception.php';
    require __DIR__ . '/../../public/mail/PHPMailer.php';
    require __DIR__ . '/../../public/mail/SMTP.php';


    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    $generateReserveID = generateReserveID();
    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'lndreports2024@gmail.com';                     //SMTP username
        $mail->Password = $_ENV['EMAIL_PASS'];                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('lndreports2024@gmail.com', 'Learning and Development Inventory Management System');
        $mail->addAddress($EMAIL);     //Add a recipient
        $mail->addEmbeddedImage($_SERVER['DOCUMENT_ROOT'] . '/public/assets/img/LOGO.png', 'logo_cid');
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
       // <img src="/../../public/assets/img/LOGO.png" style="height: 40px; margin: 0 auto; display: inline;">
            // <img src="/../../assets/img/LOGO.png" style="height: 40px; margin: 0 auto; display: inline;">
            // <img src="cid:logo_cid" style="height: 40px; margin: 0 auto; display: inline;">

        if ($approval_status == 'APPROVED') {
            // Create a new instance of the PDF
            $pdf = new TCPDF('P', 'mm', 'LETTER', true, 'UTF-8', false);
            $pdf->AddPage();

            $logoPath = dirname(__DIR__, 2) . '/public/assets/img/LOGO.png'; // Adjusted for folder structure
            if (file_exists($logoPath)) {
                $imgTag = '<img src="' . $logoPath . '" style="height: 40px; margin: 0 auto; display: inline;">';
            } else {
                $imgTag = '<strong>[Logo Missing]</strong>'; // Fallback if the logo file is not found
            }


            $html = '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Bill Invoice</title>
                </style>
                </head>
                <body style="font-family: Arial, sans-serif; margin: 0; padding: 0;">
                    <div style="width: 90%;">
                        <div style="font-size: 16px; font-weight: bold; display: flex; align-items: center; justify-content: space-between; width: 100%;">
                            <img src="https://flldc-ims.vercel.app/assets/img/LOGO.png" style="height: 40px;">
                            <div style="flex-grow: 1; text-align: center;">SERVICE INVOICE</div>
                        </div>
                        <table style="border: 1px solid white; padding-top: 40px; padding-bottom: 20px; width: 100%;">
                            <tr>
                                <th style="border: 1px solid white;">
                                    <strong>INVOICE-' . $generateReserveID . '</strong>
                                </th>
                                <th style="text-align: right;">
                                    <strong>DATE: ' . $date_now = date('M d, Y') . '</strong>
                                </th>
                            </tr>
                        </table>
                        <div style="margin-bottom: 20px;">
                            <strong>FAST LOGISTICS LEARNING AND DEVELOPMENT CORPORATION</strong><br>
                            Fast Warehouse Complex, Pulo-Diezmo Road,<br>
                            Barangay Pulo, Cabuyao City Laguna.
                        </div>
                        <div style="margin-bottom: 20px;">
                            <strong>BILL TO: </strong>' . $row['fname'] . ' ' . $row['lname'] . '<br>
                            <strong>RE: Room Reservation</strong><br>
                        </div>
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th style="border: 1px solid #000; padding: 8px; text-align: left; font-weight: bold;">Room Name</th>
                                    <th style="border: 1px solid #000; padding: 8px; text-align: left; font-weight: bold;">Date Reserved</th>
                                    <th style="border: 1px solid #000; padding: 8px; text-align: left; font-weight: bold;">Time Reserved</th>
                                    <th style="border: 1px solid #000; padding: 8px; text-align: center; font-weight: bold;">No. of Pax</th>
                                    <th style="border: 1px solid #000; padding: 8px; text-align: right; font-weight: bold;">RATE (Php)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">' . $row['room_name'] . '</td>
                                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">' . $row['reserve_date'] . '</td>
                                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">' . $row['time'] . '</td>
                                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">' . $row['guest'] . '</td>
                                    <td style="border: 1px solid #000; padding: 8px; text-align: right;">' . $row['prices'] . '</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="border: 1px solid #000; padding: 8px; text-align: right; font-weight: bold;">Grand Total</td>
                                    <td style="border: 1px solid #000; padding: 8px; text-align: right;">' . $row['prices'] . '</td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <div style="margin-top: 20px; font-size: 12px;">
                            <strong>PAYMENT INSTRUCTION:</strong><br><br>
                            Please make payable to:<br>
                            Account Name: Fast Logistics Learning and Development Corporation<br>
                            Account Number: 759-084367-1<br>
                            Bank: RCBC
                        </div>
                    </div>
                </body>
                </html>
            ';
            $pdf->writeHTML($html, true, false, true, false, '');

            ob_start();
            $pdf->Output('S'); // Save PDF output to a variable as a string
            $pdfContent = ob_get_clean();

            // File details
            $fileName = 'INVOICE-' . $generateReserveID .'.pdf';

            // Encode the PDF content to base64
            $base64Content = base64_encode($pdfContent);

            // Prepare the API request 
            $fileUrl = 'https://api.github.com/repos/' . $owner . '/' . $repo . '/contents/RESERVATION_INVOICE/' . urlencode($fileName);
            $data = json_encode([
                'message' => 'Upload invoice ' . $fileName,
                'content' => $base64Content,
            ]);

            $ch = curl_init($fileUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: token ' . $githubToken,
                'User-Agent: PHP Script',
                'Content-Type: application/json',
            ]);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            $responses = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if (curl_errno($ch)) {
                // Handle curl errors
                echo json_encode([
                    'success' => false,
                    'title' => 'Curl Error',
                    'message' => curl_error($ch),
                ]);
                curl_close($ch);
                exit();
            }

            curl_close($ch);

            // GitHub file URL (raw file URL for downloading)
            $rawFileUrl = 'https://raw.githubusercontent.com/' . $owner . '/' . $repo . '/main/RESERVATION_INVOICE/' . urlencode($fileName);

            // Download the file content from GitHub
            $fileContent = downloadFileFromGitHub($rawFileUrl);

            // Create a temporary file to store the content
            $tempFilePath = tempnam(sys_get_temp_dir(), 'invoice_' . $generateReserveID);
            file_put_contents($tempFilePath, $fileContent);


            $mail->Subject = 'Reservation Status Update: ' . $approval_status;

            // Attach the downloaded file
            $mail->addAttachment($tempFilePath, $fileName);


            $mail->addAttachment($_SERVER['DOCUMENT_ROOT'] . '/public/assets/Reservation-Terms-and-Agreement.pdf', 'Reservation-Terms-and-Agreement.pdf.pdf');
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
                                                                <p style="text-align:justify">Your reservation has been approved! Below are the details of your reservation. Please present the reservation ID at the security desk when you arrive at the center.</p>
                                                                
                                                                <p><strong>Reservation Details:</strong><br>
                                                                <b>Reservation ID:</b> ' . $generateReserveID . '<br>
                                                                <b>Business Unit:</b> ' . $row['business_unit'] . '<br>
                                                                <b>Room:</b> ' . $row['room_name'] . '<br>
                                                                <b>Contact:</b> ' . $row['contact'] . '<br>
                                                                <b>Email:</b> ' . $row['email'] . '<br>
                                                                <b>Date:</b> ' . $row['reserve_date'] . '<br>
                                                                <b>Time:</b> ' . $row['time'] . '<br>
                                                                <b>Setup:</b> ' . $row['setup'] . '<br>
                                                                <b>Reserved By:</b> ' . $row['fname'] . ' ' . $row['lname'] . '<br>
                                                                <b>Message :</b> ' . $message . '<br>
                                                                </p>

                                                                <p style="text-align:justify">We look forward to assisting you at the FAST Learning and Development Center. If you have any questions or need further assistance, feel free to contact us at jppsolis@fast.com.ph | Viber Number: +63 969 450 9412.</p>
                                                                <p style="text-align:justify">Thank you for choosing FAST Learning and Development Center.</p>

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
        } else {
            $mail->Subject = 'Reservation Status Update: ' . $approval_status;
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
                                                                <p style="text-align:justify">Your reservation request has been declined. Below are the details of your request.</p>
                                                                
                                                                <p><strong>Reservation Details:</strong><br>
                                                                ' . ($row['reservation_id'] == 'PENDING' ? '<b>Reservation ID:</b> ' . $row['reservation_id'] . '<br>' : '<b>Booking ID:</b> ' . $row['booking_id'] . '<br>') . '
                                                                <b>Business Unit:</b> ' . $row['business_unit'] . '<br>
                                                                <b>Room:</b> ' . $row['room_name'] . '<br>
                                                                <b>Contact:</b> ' . $row['contact'] . '<br>
                                                                <b>Email:</b> ' . $row['email'] . '<br>
                                                                <b>Date:</b> ' . $row['reserve_date'] . '<br>
                                                                <b>Time:</b> ' . $row['time'] . '<br>
                                                                <b>Setup:</b> ' . $row['setup'] . '<br>
                                                                <b>Reserved By:</b> ' . $row['fname'] . ' ' . $row['lname'] . '<br>
                                                                <b>Reason for Declining :</b> ' . $message . '<br>
                                                                </p>
        
                                                                <p style="text-align:justify">We look forward to assisting you at the FAST Learning and Development Center. If you have any questions or need further assistance, feel free to contact us at jppsolis@fast.com.ph | Viber Number: +63 969 450 9412.</p>
                                                                <p style="text-align:justify">Thank you for choosing FAST Learning and Development Center.</p>
        
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

        // Clean up the temporary file
         unlink($tempFilePath);

        $decline_counter = $conn->prepare("
                SELECT EMAIL FROM reservations 
                WHERE room = :room 
                AND reserve_date = :reserve_date
                AND reserve_status = 'DECLINED'
                AND ID != :ID
                AND time IN ($inClause)
            ");
        $decline_counter->bindParam(':ID', $ID, PDO::PARAM_INT);
        $decline_counter->bindParam(':room', $room, PDO::PARAM_STR);
        $decline_counter->bindParam(':reserve_date', $reserve_date, PDO::PARAM_STR);

        // Bind the overlapping time slots for the declined email notifications
        foreach ($overlapping_times as $index => $time) {
            $decline_counter->bindValue(':time' . $index, $time, PDO::PARAM_STR);
        }

        // Execute the query to get declined reservation emails
        $decline_counter->execute();
        $reservation_count = $decline_counter->fetchAll(PDO::FETCH_COLUMN);

        if ($reservation_count > 0) {

            // Now, decline all overlapping pending reservations for the same room, date, and overlapping time slots
            $decline_pending = $conn->prepare("
                UPDATE reservations 
                SET reserve_status = 'DECLINED', 
                reservation_id = 'DECLINED'
                WHERE room = :room 
                AND reserve_date = :reserve_date
                AND reserve_status = 'PENDING'
                AND ID != :ID
                AND time IN ($inClause)
            ");
            $decline_pending->bindParam(':ID', $ID, PDO::PARAM_INT);
            $decline_pending->bindParam(':room', $room, PDO::PARAM_STR);
            $decline_pending->bindParam(':reserve_date', $reserve_date, PDO::PARAM_STR);

            // Bind the overlapping time slots for the pending reservations
            foreach ($overlapping_times as $index => $time) {
                $decline_pending->bindValue(':time' . $index, $time, PDO::PARAM_STR);
            }
            // Execute the decline query
            $decline_pending->execute();

            // Prepare to send email notifications for declined reservations
            $decline_email = $conn->prepare("
                SELECT EMAIL FROM reservations 
                WHERE room = :room 
                AND reserve_date = :reserve_date
                AND reserve_status = 'DECLINED'
                AND time IN ($inClause)
            ");
            $decline_email->bindParam(':room', $room, PDO::PARAM_STR);
            $decline_email->bindParam(':reserve_date', $reserve_date, PDO::PARAM_STR);

            // Bind the overlapping time slots for the declined email notifications
            foreach ($overlapping_times as $index => $time) {
                $decline_email->bindValue(':time' . $index, $time, PDO::PARAM_STR);
            }

            // Execute the query to get declined reservation emails
            $decline_email->execute();
            $declined_emails = $decline_email->fetchAll(PDO::FETCH_COLUMN);

            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth = true;                                   //Enable SMTP authentication
                $mail->Username = 'lndreports2024@gmail.com';                     //SMTP username
                $mail->Password = $_ENV['EMAIL_PASS'];                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port = 465;                                           // TCP port to connect to

                $mail->setFrom('lndreports2024@gmail.com', 'Learning and Development Inventory Management System');
                foreach ($declined_emails as $declined_email) {
                    $mail->addAddress($declined_email);
                }    //Add a recipient
                $mail->addEmbeddedImage('/var/task/user/public/assets/img/LOGO.png', 'logo_cid');
                //Content
                $mail->isHTML(true);

                $mail->Subject = 'Reservation Status Update: DECLINED';
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
                                                                    <p style="text-align:justify">Your reservation request has been declined. Below are the details of your request.</p>
                                                                    
                                                                    <p><strong>Reservation Details:</strong><br>
                                                                    ' . ($row['reservation_id'] == 'PENDING' ? '<b>Reservation ID:</b> ' . $row['reservation_id'] . '<br>' : '<b>Booking ID:</b> ' . $row['booking_id'] . '<br>') . '
                                                                    <b>Business Unit:</b> ' . $row['business_unit'] . '<br>
                                                                    <b>Room:</b> ' . $row['room_name'] . '<br>
                                                                    <b>Contact:</b> ' . $row['contact'] . '<br>
                                                                    <b>Email:</b> ' . $row['email'] . '<br>
                                                                    <b>Date:</b> ' . $row['reserve_date'] . '<br>   
                                                                    <b>Time:</b> ' . $row['time'] . '<br>
                                                                    <b>Setup:</b> ' . $row['setup'] . '<br>
                                                                    <b>Reserved By:</b> ' . $row['fname'] . ' ' . $row['lname'] . '<br>
                                                                    <b>Reason for Declining : The room is already booked for the selected date and time. Please choose another time or date.
                                                                    </p>
                                                                    <p style="text-align:justify">This is an automated reply from the Reservation System. Please do not reply to this email.</p>
                                                                    <p style="text-align:justify">We look forward to assisting you at the FAST Learning and Development Center. If you have any questions or need further assistance, feel free to contact us at jppsolis@fast.com.ph | Viber Number: +63 969 450 9412.</p>
                                                                    <p style="text-align:justify">Thank you for choosing FAST Learning and Development Center.</p>
            
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


                $mail->send();
            } catch (Exception $e) {
                error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            }
        }

        $sql = $conn->prepare("UPDATE reservations SET invoice = :invoice, reserve_status = :reserve_status, reservation_id = :reservation_id, status_date_created = NOW() AT TIME ZONE 'Asia/Manila' WHERE id = :id ");
        $sql->bindParam(':invoice', $fileName, PDO::PARAM_STR);
        $sql->bindParam(':reserve_status', $approval_status, PDO::PARAM_STR);
        $sql->bindParam(':reservation_id', $generateReserveID, PDO::PARAM_STR);
        $sql->bindParam(':id', $ID, PDO::PARAM_STR);
        // Execute the prepared statement
        $sql->execute();

        $history_title = "Updated Reserve Status";
        $history_remarks = "Status Reserve : " . $approval_status;

        if ($approval_status = " APPROVED ") {
            $action = "Reserve Status : Approved | Reserve ID : " . $generateReserveID;
        } else {
            $action = "Reserve Status : Declined | Reserve ID : " . $generateReserveID;
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


    } catch (Exception $e) {
        // If an error occurs during sending email
        $response['success'] = false;
        $response['title'] = 'Error';
        $response['message'] = 'Email could not be sent. Error: ' . $mail->ErrorInfo;
        echo json_encode($response);
        exit();
    }
}