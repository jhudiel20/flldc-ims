<?php
header("Access-Control-Allow-Origin: https://flldc-booking-app.vercel.app");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../config/config.php'; // Adjusted path for config.php

$data = json_decode(file_get_contents("php://input"), true);
$username = isset($data['email']) ? trim($data['email']) : '';
$password = isset($data['password']) ? trim($data['password']) : '';

if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required']);
    exit();
}

try {
    $stmt = $conn->prepare("SELECT * FROM user_account WHERE username = :username");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {

        if (set_password($password) === $user['password']) {

        $cookieData = [
            'status' => true,
            'ID' => $user['id'],  // Consider encrypting this for security
            'ACCESS' => $user['access'],
            'USERNAME' => $user['username'],
            'PASSWORD' => $user['password'],  // Consider encrypting this for security
            'DATE_CREATED' => $user['date_created'],
            'FNAME' => $user['fname'],
            'MNAME' => $user['mname'],
            'LNAME' => $user['lname'],
            'EXT_NAME' => $user['ext_name'],
            'EMAIL' => $user['email'],
            'IMAGE' => $user['image'],
            'LOCKED' => $user['locked'],
            'ADMIN_STATUS' => $user['admin_status'],
            'RESERVATION_ACCESS' => $user['reservation_access']
        ];

        $encrypted_value = encrypt_cookie($cookieData, $encryption_key, $cipher_method);
        
        setcookie('secure_data', $encrypted_value, [
            'expires' => time() + 1800,  // Cookie expires in 30 minutes (1800 seconds)
            'path' => '/',                       // Available within the entire domain
            'domain' => '',                     // Use the default domain
            'secure' => true,                   // Only sent over HTTPS
            'httponly' => true,                 // Accessible only through HTTP, not JavaScript
            'samesite' => 'Strict'              // Restrict cookie to same-site requests
        ]);

        setcookie("Toast-title", "Welcome!", time() + 10, "/"); // Set status as success
        setcookie("Toast-message", "Login successful!", time() + 10, "/"); // Message valid for 10 seconds


        echo json_encode([
            'success' => true,
            'redirectUrl' => '/dashboard-lnd' // Change to actual dashboard route
        ]);
    
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid password']);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
