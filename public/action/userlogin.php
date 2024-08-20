<?php
header('Content-Type: application/json');

try {
    // Your login logic here
    $response = [
        'success' => true,
        'title' => 'Login Successful',
        'message' => 'You will be redirected shortly.'
    ];

    echo json_encode($response);

} catch (Exception $e) {
    $response = [
        'success' => false,
        'title' => 'Error',
        'message' => $e->getMessage()
    ];

    echo json_encode($response);
}
