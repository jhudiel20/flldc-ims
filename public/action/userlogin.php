<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

$response = array();

// Get the raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (empty($data['username']) || empty($data['password'])) {
    $response['success'] = false;
    $response['message'] = 'Please fill in both fields.';
    echo json_encode($response);
    exit;
}

$username = $data['username'];
$password = $data['password'];

try {
    include 'DBConnection.php'; // Ensure no output from this file

    $stmt = $conn->prepare('SELECT id, username, password FROM users WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_start(); // Ensure session is started
        $_SESSION['user_id'] = $user['id'];
        $response['success'] = true;
        $response['message'] = 'Login successful.';
    } else {
        $response['success'] = false;
        $response['message'] = 'Invalid username or password.';
    }
} catch (PDOException $e) {
    $response['success'] = false;
    $response['message'] = 'Database error: ' . $e->getMessage();
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = 'Unexpected error: ' . $e->getMessage();
}

echo json_encode($response);
?>
