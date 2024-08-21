<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/DBConnection.php';
require_once __DIR__ . '../../public/config/config.php';

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
            if ($user['approved_status'] == 1) {
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
            $_SESSION['ID'] = $user['id'];
            $_SESSION['ACCESS'] = $user['access'];
            $_SESSION['USERNAME'] = $user['username'];
            $_SESSION['PASSWORD'] = $user['password'];
            $_SESSION['DATE_CREATED'] = $user['date_created'];
            $_SESSION['FNAME'] = $user['fname'];
            $_SESSION['MNAME'] = $user['mname'];
            $_SESSION['LNAME'] = $user['lname'];
            $_SESSION['EXT_NAME'] = $user['ext_name'];
            $_SESSION['EMAIL'] = $user['email'];
            $_SESSION['IMAGE'] = $user['image'];
            $_SESSION['LOCKED'] = $user['locked'];
            $_SESSION['ADMIN_STATUS'] = $user['admin_status'];

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
            $logs = $conn->query("INSERT INTO logs (user_id, action_made) VALUES ($1, $2)", array($user_id, $action));

            $response['success'] = true;
            $response['title'] = 'Welcome!';
            $response['message'] = 'Login successful!';
            echo json_encode($response);

            // Update user status
            $status = $conn->query("UPDATE user_account SET status = '1', locked = '0' WHERE id = $1", array($_SESSION['ID']));
        } else {
            // Additional checks for incorrect credentials
            $admin_access = $conn->query("SELECT * FROM user_account WHERE username = $1 AND access = 'ADMIN'", array($username));
            if ($admin_access->rowCount() > 0) {
                $response['icon'] = "warning";
                $response['success'] = false;
                $response['title'] = "Wrong Password!";
                echo json_encode($response);
            } else {
                $exist = $conn->query("SELECT * FROM user_account WHERE username = $1", array($username));
                if ($exist->rowCount() > 0) {
                    $row = $exist->fetch(PDO::FETCH_ASSOC);
                    $id = $row['id'];
                    $locked = $conn->query("SELECT * FROM user_account WHERE username = $1 AND password = $2", array($username, $password));
                    $lock = $locked->fetch(PDO::FETCH_ASSOC);
                    if ($locked->rowCount() > 0) {
                        if ($lock['locked'] >= 3) {
                            $response['icon'] = "warning";
                            $response['success'] = false;
                            $response['title'] = "Account Locked!";
                            $response['message'] = "Your account is locked. Please contact the admin.";
                            echo json_encode($response);
                            exit();
                        }
                        if ($lock['locked'] < 3) {
                            $conn->query("UPDATE user_account SET locked = $1 WHERE id = $2", array($lock['locked'] + 1, $id));
                            $response['icon'] = "warning";
                            $response['success'] = false;
                            $response['title'] = "Wrong Password!";
                            $response['message'] = "Attempt " . ($lock['locked'] + 1);
                            echo json_encode($response);
                            exit();
                        }
                    } else {
                        $conn->query("UPDATE user_account SET locked = locked + 1 WHERE id = $1", array($id));
                        $response['icon'] = "warning";
                        $response['success'] = false;
                        $response['title'] = "Wrong Password!";
                        $response['message'] = "Attempt " . ($lock['locked'] + 1);
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
