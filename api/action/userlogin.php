<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../config/config.php'; // Adjusted path for config.php

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Validate inputs
    if (strpos($password, "'") !== false || strpos($username, "'") !== false || strpos($password, '"') !== false || strpos($username, '"') !== false) {
        $response = [
            'icon' => "warning",
            'success' => false,
            'title' => "Error!",
            'message' => 'Username and password cannot contain single or double quotes!'
        ];
        echo json_encode($response);
        exit();
    }

    if (empty($username) || empty($password)) {
        $response = [
            'icon' => "warning",
            'success' => false,
            'title' => "Something Went Wrong!",
            'message' => "Please fill all fields!"
        ];
        echo json_encode($response);
        exit();
    }

    try {
        $password = set_password($password);
        $stmt = $conn->prepare("SELECT * FROM user_account WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $check3 = $conn->prepare("SELECT * FROM user_account WHERE username = :username AND password = :password AND approved_status = 2 AND locked = 3 AND access != 'ADMIN' ");
        $check3->bindParam(':username', $username, PDO::PARAM_STR);
        $check3->bindParam(':password', $password, PDO::PARAM_STR);
        $rowcheck3 = $check3->rowCount();

        if($rowcheck3 > 0){
            $check4 = $conn->prepare("SELECT * FROM user_account WHERE username = :username AND password = :password AND approved_status = 2 AND locked = 3 ");
            $check4->bindParam(':username', $username, PDO::PARAM_STR);
            $check4->bindParam(':password', $password, PDO::PARAM_STR);
            $rowcheck4 = $check4->rowCount();

            if($rowcheck4 > 0){
                $response['icon'] = "error";
                $response['success'] = false;
                $response['title'] = "Error!";
                $response['message'] = "Your Account is Locked. Please Contact the Administrator.";
                echo json_encode($response);
                exit();
            }
        }

        if ($user) {
            // Verify password
            if ($password === $user['password']) {
                // Password matches
                if ($user['approved_status'] == 1) {
                    $response = [
                        'icon' => "error",
                        'success' => false,
                        'title' => "Error!",
                        'message' => "The administrator has rejected your registration!"
                    ];
                    echo json_encode($response);
                    exit();
                }

                // Encrypt the array before setting the cookie
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
                    'ADMIN_STATUS' => $user['admin_status'],
                    'RESERVATION_ACCESS' => $user['reservation_access']
                ];

                $encrypted_value = encrypt_cookie($cookieData, $encryption_key, $cipher_method);
                
                setcookie('secure_data', $encrypted_value, [
                    'expires' => time() + 1800,  // Cookie expires in 30 minutes (1800 seconds)
                    'path' => '/',                       // Available within the entire domain
                    'domain' => '',                     // Use the default domain
                    'secure' => true,                   // Only sent over HTTPS
                    'httponly' => true,                 // Accessible only through HTTP, not JavaScript
                    'samesite' => 'Strict'              // Restrict cookie to same-site requests
                ]);

                setcookie("Toast-title", "Welcome!", time() + 10, "/"); // Set status as success
                setcookie("Toast-message", "Login successful!", time() + 10, "/"); // Message valid for 10 seconds

                // Log the user action
                $action = "Logged in the system.";
                $stmt = $conn->prepare("INSERT INTO logs (USER_ID, ACTION_MADE) VALUES (:user_id, :action_made)");
                $stmt->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
                $stmt->bindParam(':action_made', $action, PDO::PARAM_STR);
                $stmt->execute();

                // Update user status
                $stmt = $conn->prepare("UPDATE user_account SET status = '1', locked = '0' WHERE id = :id");
                $stmt->bindParam(':id', $user['id'], PDO::PARAM_INT);
                $stmt->execute();

                $response = [
                    'success' => true,
                    // 'title' => 'Welcome!',
                    // 'message' => 'Login successful!'
                ];
                echo json_encode($response);

            } else {
                $admin_access = $conn->prepare("SELECT * FROM user_account WHERE username = :username AND access = 'ADMIN' ");
                $admin_access->bindParam(':username', $username, PDO::PARAM_STR);
                $admin_access->execute();
                $admin_access = $admin_access->rowCount();

                if($admin_access > 0 ){
                    $response = [
                        'icon' => "error",
                        'title' => "Error!",
                        'success' => false,
                        'message' => 'Wrong Password!'
                    ];
                    echo json_encode($response);
                    exit;
                }else{

                    $exist = $conn->prepare("SELECT id,locked,username FROM user_account WHERE username = :username ");
                    $exist->bindParam(':username', $username, PDO::PARAM_STR);
                    $exist->execute();
                    $row_exist = $exist->fetch(PDO::FETCH_ASSOC);
                    
                    if($row_exist){
                        $id = $row_exist['id'];  
                        $locked = $row_exist['locked'] + 1;
                        if($row_exist['locked'] >= 3){
                            $response = [
                                'icon' => "warning",
                                'title' => "Account Locked!",
                                'success' => false,
                                'message' => 'Your Account is Locked Please Contact the admin.'
                            ];
                            echo json_encode($response);
                        }else{
                            if ($locked >= 3) {
                                $response = [
                                    'icon' => "warning",
                                    'title' => "Account Locked!",
                                    'success' => false,
                                    'message' => 'Your Account is Locked. Please contact the admin.'
                                ];
                                echo json_encode($response);
                            } else {
                                // Update the lock count
                                $add_locked = $conn->prepare("UPDATE user_account SET locked = :locked WHERE id = :id");
                                $add_locked->bindParam(':locked', $locked, PDO::PARAM_INT);
                                $add_locked->bindParam(':id', $id, PDO::PARAM_INT);
                                $add_locked->execute();
                    
                                $response = [
                                    'icon' => "warning",
                                    'title' => "Wrong Password!",
                                    'success' => false,
                                    'message' => 'Attempt ' . $locked
                                ];
                                echo json_encode($response);
                            }
                        }
                    }else{
                        $response = [
                            'icon' => "error",
                            'title' => "Error!",
                            'success' => false,
                            'message' => 'Invalid username or password.'
                        ];
                        echo json_encode($response);
                    }

                }
            }
        }else{
            $response = [
                'icon' => "error",
                'title' => "Error!",
                'success' => false,
                'message' => 'Invalid username or password.'
            ];
            echo json_encode($response);
        }
    } catch (PDOException $e) {
        $response = [
            'message' => 'Database error: ' . $e->getMessage(),
            'success' => false
        ];
        echo json_encode($response);
    }
}
        // $check1 = $conn->prepare("SELECT * FROM user_account WHERE username = :username AND password = :password AND approved_status = 0 ");
        // $check1->bindParam(':username', $username, PDO::PARAM_STR);
        // $check1->bindParam(':password', $password, PDO::PARAM_STR);
        // $check1->execute();

        // $rowcheck1 = $check1->rowCount();

        // if($rowcheck1 > 0){
        //     $response = [
        //         'icon' => "error",
        //         'title' => "Error!",
        //         'success' => false,
        //         'message' => 'Your registration is on process!'
        //     ];
        //     echo json_encode($response);
        // }

        // $check2 = $conn->prepare("SELECT * FROM user_account WHERE username = :username AND password = :password AND approved_status = 0 and access = '' ");
        // $check2->bindParam(':username', $username, PDO::PARAM_STR);
        // $check2->bindParam(':password', $password, PDO::PARAM_STR);
        // $check2->execute();
        // $rowcheck2 = $check2->rowCount();

        // if($rowcheck2 > 0){
        //     $response = [
        //         'icon' => "error",
        //         'title' => "Error!",
        //         'success' => false,
        //         'message' => 'Your registration is on process!'
        //     ];
        //     echo json_encode($response);
        // }
?>
