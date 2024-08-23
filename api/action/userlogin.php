<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

// $response = array('status' => 'error', 'message' => '');

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Validate inputs
    if (strpos($password, "'") !== false || strpos($username, "'") !== false || strpos($password, '"') !== false || strpos($username, '"') !== false) {
        $response['icon'] = "warning";
        $response['success'] = false;
        $response['title'] = "Error!";
        $response['message'] = 'Username and password cannot contain single or double quotes!';
        echo json_encode($response);
        exit();
    }

    if (empty($username) || empty($password)) {
        $response['icon'] = "warning";
        $response['success'] = false;
        $response['title'] = "Something Went Wrong!";
        $response['message'] = "Please fill all fields!";
        echo json_encode($response);
        exit();
    }

    try {
        // Check if user is in the database
        $stmt = $conn->prepare("SELECT * FROM user_account WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify password
            if (set_password($password) === $user['password']) {
                // Password matches
                if ($user['approved_status'] == 1) {
                    $response['icon'] = "error";
                    $response['success'] = false;
                    $response['title'] = "Error!";
                    $response['message'] = "The administrator has rejected your registration!";
                    echo json_encode($response);
                    exit();
                }
                
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
                    'ADMIN_STATUS' => $user['admin_status']
                ];

                // Encrypt the array before setting the cookie
                $encrypted_value = encrypt_cookie($cookieData, $encryption_key, $cipher_method);
                
                // Set the encrypted value as a single cookie
                setcookie('secure_data', $encrypted_value, [
                    'expires' => time() + (86400 * 30), // Cookie expires in 30 days
                    'path' => '/',                       // Available within the entire domain
                    'domain' => '',                     // Use the default domain
                    'secure' => true,                   // Only sent over HTTPS
                    'httponly' => true,                 // Accessible only through HTTP, not JavaScript
                    'samesite' => 'Strict'              // Restrict cookie to same-site requests
                ]);

                if (isset($_COOKIE['secure_data'])) {
                    $decrypted_array = decrypt_cookie($_COOKIE['secure_data'], $encryption_key, $cipher_method);
                }

                if ($decrypted_array['ACCESS'] == '') {
                    $response['icon'] = "info";
                    $response['success'] = false;
                    $response['title'] = "Error!";
                    $response['message'] = "Your registration is in process!";
                    echo json_encode($response);
                    exit();
                }
                if ($decrypted_array['ACCESS'] == 'ENCODER' || $decrypted_array['ACCESS'] == 'REQUESTOR') {
                    if ($decrypted_array['LOCKED'] == 3) {
                        $response['icon'] = "warning";
                        $response['success'] = false;
                        $response['title'] = "Error!";
                        $response['message'] = "Your account is locked. Please contact the admin.";
                        echo json_encode($response);
                        exit();
                    }
                }

                // Log the user action
                $action = "Logged in the system.";
                $stmt = $conn->prepare("INSERT INTO logs (user_id, action_made) VALUES (:user_id, :action_made)");
                $stmt->bindParam(':user_id', $decrypted_array['ID'], PDO::PARAM_INT);
                $stmt->bindParam(':action_made', $action, PDO::PARAM_STR);
                $stmt->execute();

                $response['success'] = true;
                $response['title'] = 'Welcome!';
                $response['message'] = 'Login successful!';
                echo json_encode($response);

                // Update user status
                $stmt = $conn->prepare("UPDATE user_account SET status = '1', locked = '0' WHERE id = :id");
                $stmt->bindParam(':id', $decrypted_array['ID'], PDO::PARAM_INT);
                $stmt->execute();
            } else {
                // Password does not match
                $response['icon'] = "warning";
                $response['success'] = false;
                $response['title'] = "Wrong Password!";
                $response['message'] = "Invalid username or password.";
                echo json_encode($response);
            }
        } else {
            // Username does not exist
            $response['icon'] = "error";
            $response['title'] = "Error!";
            $response['success'] = false;
            $response['message'] = 'Invalid username or password.';
            echo json_encode($response);
        }
    } catch (PDOException $e) {
        $response['message'] = 'Database error: ' . $e->getMessage();
        echo json_encode($response);
    }
}
?>
