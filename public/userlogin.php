<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'DBConnection.php';
include 'config/config.php';

$response = array('status' => 'error', 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($username) || empty($password)) {
        $response['message'] = 'Username and password are required.';
    } else {
        try {
            $stmt = $conn->prepare("SELECT * FROM user_account WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $response['status'] = 'success';
                $response['message'] = 'Login successful!';
            } else {
                $response['message'] = 'Login failed. Please check your credentials.';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Database error: ' . $e->getMessage();
        }
    }

    // Ensure JSON output
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>
