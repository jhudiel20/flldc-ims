<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php';
require_once __DIR__ . '/../../public/config/config.php';

$response = array('status' => 'error', 'message' => '');

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

    // Encrypt the password
    $password = set_password($password);

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
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            if ($user['APPROVED_STATUS'] == 1) {
                $response['icon'] = "error";
                $response['success'] = false;
                $response['title'] = "Error!";
                $response['message'] = "The administrator has rejected your registration!";
                echo json_encode($response);
                exit();
            }

            // Set session variables
            session_start();
            $_SESSION['status'] = true;
            $_SESSION['ID'] = $user['ID'];
            $_SESSION['ACCESS'] = $user['ACCESS'];
            $_SESSION['USERNAME'] = $user['USERNAME'];
            $_SESSION['PASSWORD'] = $user['PASSWORD'];
            $_SESSION['DATE_CREATED'] = $user['DATE_CREATED'];
            $_SESSION['FNAME'] = $user['FNAME'];
            $_SESSION['MNAME'] = $user['MNAME'];
            $_SESSION['LNAME'] = $user['LNAME'];
            $_SESSION['EXT_NAME'] = $user['EXT_NAME'];
            $_SESSION['EMAIL'] = $user['EMAIL'];
            $_SESSION['IMAGE'] = $user['IMAGE'];
            $_SESSION['LOCKED'] = $user['LOCKED'];
            $_SESSION['ADMIN_STATUS'] = $user['ADMIN_STATUS'];

            if ($_SESSION['ACCESS'] == '') {
                $response['icon'] = "info";
                $response['success'] = false;
                $response['title'] = "Error!";
                $response['message'] = "Your registration is in process!";
                echo json_encode($response);
                exit();
            }
            if ($_SESSION['ACCESS'] == 'ENCODER' || $_SESSION['ACCESS'] == 'REQUESTOR') {
                if ($_SESSION['LOCKED'] == 3) {
                    $response['icon'] = "warning";
                    $response['success'] = false;
                    $response['title'] = "Error!";
                    $response['message'] = "Your account is locked. Please contact the admin.";
                    echo json_encode($response);
                    exit();
                }
            }

            // Log the user action
            $user_id = $_SESSION['ID'];
            $action = "Logged in the system.";
            $logs = $conn->query("INSERT INTO logs (user_id, action_made) VALUES ('$user_id', '$action')");

            $response['success'] = true;
            $response['title'] = 'Welcome!';
            $response['message'] = 'Login successful!';
            echo json_encode($response);

            // Update user status
            $status = $conn->query("UPDATE user_account SET STATUS = '1', LOCKED = '0' WHERE ID = '" . $_SESSION['ID'] . "'");
        } else {
            // Additional checks for incorrect credentials
            $admin_access = $conn->query("SELECT * FROM user_account WHERE BINARY USERNAME = '$username' AND ACCESS = 'ADMIN'");
            if ($admin_access->rowCount() > 0) {
                $response['icon'] = "warning";
                $response['success'] = false;
                $response['title'] = "Wrong Password!";
                echo json_encode($response);
            } else {
                $exist = $conn->query("SELECT * FROM user_account WHERE BINARY USERNAME = '$username'");
                if ($exist->rowCount() > 0) {
                    $row = $exist->fetch(PDO::FETCH_ASSOC);
                    $id = $row['ID'];
                    $locked = $conn->query("SELECT * FROM user_account WHERE BINARY USERNAME = '$username' AND BINARY PASSWORD = '$password'");
                    $lock = $locked->fetch(PDO::FETCH_ASSOC);
                    if ($locked->rowCount() > 0) {
                        if ($lock['LOCKED'] >= 3) {
                            $response['icon'] = "warning";
                            $response['success'] = false;
                            $response['title'] = "Account Locked!";
                            $response['message'] = "Your account is locked. Please contact the admin.";
                            echo json_encode($response);
                            exit();
                        }
                        if ($lock['LOCKED'] < 3) {
                            $conn->query("UPDATE user_account SET LOCKED = '" . ($lock['LOCKED'] + 1) . "' WHERE ID = '" . $id . "'");
                            $response['icon'] = "warning";
                            $response['success'] = false;
                            $response['title'] = "Wrong Password!";
                            $response['message'] = "Attempt " . ($lock['LOCKED'] + 1);
                            echo json_encode($response);
                            exit();
                        }
                    } else {
                        $conn->query("UPDATE user_account SET LOCKED = LOCKED + 1 WHERE ID = '$id'");
                        $response['icon'] = "warning";
                        $response['success'] = false;
                        $response['title'] = "Wrong Password!";
                        $response['message'] = "Attempt " . ($lock['LOCKED'] + 1);
                        echo json_encode($response);
                        exit();
                    }
                } else {
                    $response['icon'] = "error";
                    $response['title'] = "Wrong Password!";
                    $response['success'] = false;
                    $response['message'] = 'Invalid username or password.';
                    echo json_encode($response);
                }
            }
        }
    } catch (PDOException $e) {
        $response['message'] = 'Database error: ' . $e->getMessage();
        echo json_encode($response);
    }
}
?>
