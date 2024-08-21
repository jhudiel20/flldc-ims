<?php
require 'DBConnection.php';
include 'config/config.php';

$response = array('status' => 'error', 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get POST data
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validate inputs (you can add more validation as needed)
    if (empty($username) || empty($password)) {
        $response['message'] = 'Username and password are required.';
    } else {
        // Prepare and execute the query
        $stmt = $conn->prepare("SELECT * FROM user_account WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check password
        if ($user && password_verify($password, $user['password'])) {
            // Successful login
            $response['status'] = 'success';
            $response['message'] = 'Login successful!';
        } else {
            // Failed login
            $response['message'] = 'Login failed. Please check your credentials.';
        }
    }

    // Send JSON response
    echo json_encode($response);
    exit();
}
?>
