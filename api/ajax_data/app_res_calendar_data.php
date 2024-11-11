<?php
require_once __DIR__ . '/../DBConnection.php';
require_once __DIR__ . '/../../public/config/config.php';

header('Content-Type: application/json');

try {
    // Query to fetch reservations
    $status = 'APPROVED';
    $stmt = $conn->prepare('SELECT reservation_id, room_name, reserve_date, time, business_unit, contact, email, hdmi, extension, guest, setup, fname,
    lname, chair, "table" AS table_no, message 
    FROM reservations 
    JOIN room_details ON room = room_id WHERE reserve_status = :reserve_status');
    $stmt->bindParam(':reserve_status', $status);
    $stmt->execute();

    $reservations = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Split the time slot into start and end times
        $times = explode('-', $row['time']);
        
        // Convert time to 24-hour format for FullCalendar
        $start_time = date("H:i:s", strtotime($times[0]));
        $end_time = date("H:i:s", strtotime($times[1]));

        // Format the event data for FullCalendar
        $reservations[] = [
            'title' => $row['room_name'] .'-'.$row['fname'] .' '. $row['lname'],
            'name' => $row['fname'] .' '. $row['lname'],
            'reserve_id' => $row['reservation_id'],
            'bu' => $row['business_unit'],
            'contact_no' => $row['contact'],
            'email_add' => $row['email'],
            'hdmi' => $row['hdmi'],
            'extension' => $row['extension'],
            'guest_no' => $row['guest'],
            'chair_setup' => $row['setup'],
            'chair_no' => $row['chair'],
            'table_no' => $row['table_no'],
            'message' => $row['message'],
            'start' => $row['reserve_date'] . 'T' . $start_time,
            'end' => $row['reserve_date'] . 'T' . $end_time
        ];
    }

      // Output the reservations array as JSON
      echo json_encode($reservations ?: []); // Returns an empty array if no reservations found
      exit();
  
  } catch (PDOException $e) {
      // Return an error message as JSON if something goes wrong
      echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
      exit();
  }
?>
