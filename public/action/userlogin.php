<?php
include 'DBConnection.php';

$response = array();

if (empty($_POST['username']) || empty($_POST['password'])) {
    $response['success'] = false;
    $response['message'] = 'Please fill in both fields.';
    echo json_encode($response);
    exit;
}

$username = $_POST['username'];
$password = $_POST['password'];


    $stmt = $conn->prepare('SELECT id, username, password FROM users WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $response['success'] = true;
        $response['message'] = 'Login successful.';
        echo json_encode($response);
        exit;
    } else {
        $response['success'] = false;
        $response['message'] = 'Invalid username or password.';
        echo json_encode($response);
        exit;
    }


?>
