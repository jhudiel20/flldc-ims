<?php
session_start();
include '../DBConnection.php';

// Set content type to JSON
header('Content-Type: application/json');

// Initialize response array
$response = array();

// Check if username and password are provided
if (empty($_POST['username']) || empty($_POST['password'])) {
    $response['success'] = false;
    $response['message'] = 'Please fill in both fields.';
    echo json_encode($response);
    exit;
}

// Get posted data
$username = $_POST['username'];
$password = $_POST['password'];

try {
    // Prepare SQL query to fetch user details
    $stmt = $conn->prepare('SELECT id, username, password FROM users WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Fetch user data
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Successful login
        $_SESSION['user_id'] = $user['id'];
        $response['success'] = true;
        $response['message'] = 'Login successful.';
    } else {
        // Invalid credentials
        $response['success'] = false;
        $response['message'] = 'Invalid username or password.';
    }
} catch (PDOException $e) {
    // Database error
    $response['success'] = false;
    $response['message'] = 'Database error: ' . $e->getMessage();
} catch (Exception $e) {
    // General error
    $response['success'] = false;
    $response['message'] = 'Unexpected error: ' . $e->getMessage();
}

// Return JSON response
echo json_encode($response);
?>
