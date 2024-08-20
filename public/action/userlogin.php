<?php
include 'DBConnection.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

$response = array();

if (empty($_POST['username']) || empty($_POST['password'])) {
    $response['success'] = false;
    $response['message'] = 'Please fill in both fields.';
    echo json_encode($response);
    exit;
}

$username = $_POST['username'];
$password = $_POST['password'];

try {
    $stmt = $conn->prepare('SELECT id, username, password FROM users WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
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
