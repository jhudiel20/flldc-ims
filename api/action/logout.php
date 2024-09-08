<?php 
// Display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php
$user_id = $decrypted_array['ID'];

// Update the user's status to logged out
$updateStatus = $conn->prepare("UPDATE user_account SET STATUS = :status WHERE id = :id");
$updateStatus->execute([':status' => 0, ':id' => $user_id]);

// Log the user action (Logged out)
$action_made = "Logged out.";
$logAction = $conn->prepare("INSERT INTO logs (user_id, action_made) VALUES (:user_id, :action_made)");
$logSuccess = $logAction->execute([':user_id' => $user_id, ':action_made' => $action_made]);

if ($logSuccess) {

    // Unset the cookies only if the log was successfully inserted
    setcookie('status', '', time() - 1000000, '/');
    setcookie('ID', '', time() - 1000000, '/');
    setcookie('ACCESS', '', time() - 1000000, '/');
    setcookie('USERNAME', '', time() - 1000000, '/');
    setcookie('PASSWORD', '', time() - 1000000, '/');
    setcookie('DATE_CREATED', '', time() - 1000000, '/');
    setcookie('FNAME', '', time() - 1000000, '/');
    setcookie('MNAME', '', time() - 1000000, '/');
    setcookie('LNAME', '', time() - 1000000, '/');
    setcookie('EXT_NAME', '', time() - 1000000, '/');
    setcookie('EMAIL', '', time() - 1000000, '/');
    setcookie('IMAGE', '', time() - 1000000, '/');
    setcookie('LOCKED', '', time() - 1000000, '/');
    setcookie('ADMIN_STATUS', '', time() - 1000000, '/');
    // Redirect to the index page
    header("Location: /index");
    exit();
    // print_r($_COOKIE);
} else {
    // Handle the error if the logging failed
    echo "Error logging out. Please try again.";
}
?>
