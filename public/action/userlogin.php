<?php
header('Content-Type: application/json');

// Simulate a successful response for testing
$response = array(
    'success' => true,
    'message' => 'Test response'
);

echo json_encode($response);
?>
