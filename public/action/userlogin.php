<?php
session_start();
include 'DBConnection.php'; // Include your database connection script

header('Content-Type: application/json');

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Please fill in both fields.']);
    exit;
}

try {
    $stmt = $conn->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Set session variable or perform other actions as needed
        $_SESSION['user_id'] = $user['id'];
        echo json_encode(['success' => true, 'message' => 'Login successful.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
    }
} catch (PDOException $e) {
    // Output detailed error message
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    error_log('Database error: ' . $e->getMessage()); // Log error to the server log
} catch (Exception $e) {
    // Handle other types of exceptions
    echo json_encode(['success' => false, 'message' => 'Unexpected error: ' . $e->getMessage()]);
    error_log('Unexpected error: ' . $e->getMessage()); // Log error to the server log
}
?>
