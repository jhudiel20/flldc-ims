<?php
require 'DBConnection.php';
include 'config/config.php';

// Start the session
session_start();

// Get POST data
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Initialize response array
$response = [
    'success' => false,
    'title' => 'Login Failed',
    'message' => 'Invalid username or password.',
    'icon' => 'error'
];

if (!empty($username) && !empty($password)) {
    // Prepare and execute query
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
        // Update response
        $response['success'] = true;
        $response['title'] = 'Login Successful';
        $response['message'] = 'You have successfully logged in.';
        $response['icon'] = 'success';
    }
}

// Return JSON response
echo json_encode($response);
