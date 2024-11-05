<?php
require_once __DIR__ . '/../DBConnection.php';
require_once __DIR__ . '/../../public/config/config.php';

header('Content-Type: application/json');


    // Query to fetch reservations
    $stmt = $conn->prepare("SELECT room_name, reserve_date, time FROM reservations");
    $stmt->execute();

    $reservations = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Convert the time slot to a start and end time
        $times = explode('-', $row['time']);
        $start_time = date("H:i:s", strtotime($times[0]));
        $end_time = date("H:i:s", strtotime($times[1]));

        // Format the event for FullCalendar
        $reservations[] = [
            'title' => $row['room_name'],
            'start' => $row['reserve_date'] . 'T' . $start_time,
            'end' => $row['reserve_date'] . 'T' . $end_time
        ];
    }

    // Output the reservations as JSON
    echo json_encode($reservations);

?>
