<?php 
if (!isset($_COOKIE['secure_data'])){
    header("Location: /");
}

// Display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../config/config.php'; // Adjusted path for config.php
$user_id = $decrypted_array['ID'];

// Update the user's status to logged out
$updateStatus = $conn->prepare("UPDATE user_account SET STATUS = :status WHERE id = :id");
$updateStatus->execute([':status' => 0, ':id' => $user_id]);

// Log the user action (Logged out)
$action_made = "Logged out.";
$logAction = $conn->prepare("INSERT INTO logs (user_id, action_made) VALUES (:user_id, :action_made)");
$logSuccess = $logAction->execute([':user_id' => $user_id, ':action_made' => $action_made]);

if ($logSuccess) {

    // Check if the cookie exists
    if (isset($_COOKIE['secure_data'])) {
        // Decrypt the cookie data
        $decrypted_array = decrypt_cookie($_COOKIE['secure_data'], $encryption_key, $cipher_method);
        setcookie('secure_data', '', time() - 3600, '/', '', isset($_SERVER["HTTPS"]), true);
        unset($_COOKIE['secure_data']);

        // Check if decryption was successful
        if ($decrypted_array !== null) {
            // Clear the decrypted array
            foreach ($decrypted_array as &$value) {
                $value = null; // Set each value to null or use unset($value) to remove key-value pairs completely
            }

            // Set the cookie with an expiration time in the past to delete it
            setcookie('secure_data', '', time() - 1000000, '/', '', true, true);
        }
    }

    // Optionally, unset them from the $_COOKIE superglobal
    setcookie("secure_data", "", time() - 3600, "/", "flldc-ims.vercel.app", true, true);
    unset($_COOKIE['secure_data']);

    // Remove all cookies
    if (!empty($_COOKIE)) {
        foreach ($_COOKIE as $name => $value) {
            setcookie($name, '', time() - 3600, '/', '', true, true);
        }
    }

    // Redirect to the index page after successful logout and cookie unset
    header("Location: /");
    exit();

} else {
    // Handle the error if the logging failed
    echo "Error logging out. Please try again.";
}
?>
