<?php
require '../DBConnection.php';
include '../config/config.php';

session_start();

header('Content-Type: application/json');

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if (strpos($password, "'") !== false || strpos($username, "'") !== false || 
    strpos($password, '"') !== false || strpos($username, '"') !== false) {
    echo json_encode([
        'icon' => 'warning',
        'success' => false,
        'title' => 'Error!',
        'message' => 'Password and username cannot contain single or double quotes!'
    ]);
    exit();
}

if ($username == '' || $password == '') {
    echo json_encode([
        'icon' => 'warning',
        'success' => false,
        'title' => 'Something Went Wrong!',
        'message' => 'Please fill all fields!'
    ]);
    exit();
}

$password = set_password($password);

// Prepared statement for PostgreSQL
$query = "SELECT * FROM user_account WHERE username = $1 AND password = $2";
$result = pg_query_params($conn, $query, [$username, $password]);

if ($row = pg_fetch_assoc($result)) {
    if ($row['approved_status'] == 1) {
        echo json_encode([
            'icon' => 'error',
            'success' => false,
            'title' => 'Error!',
            'message' => 'The administrator has rejected your registration!'
        ]);
        exit();
    }

    $_SESSION = array_merge($_SESSION, [
        'status' => true,
        'ID' => $row['id'],
        'ACCESS' => $row['access'],
        'USERNAME' => $row['username'],
        'PASSWORD' => $row['password'],
        'DATE_CREATED' => $row['date_created'],
        'FNAME' => $row['fname'],
        'MNAME' => $row['mname'],
        'LNAME' => $row['lname'],
        'EXT_NAME' => $row['ext_name'],
        'EMAIL' => $row['email'],
        'IMAGE' => $row['image'],
        'LOCKED' => $row['locked'],
        'ADMIN_STATUS' => $row['admin_status']
    ]);

    if ($row['access'] == '' || $row['locked'] == 3) {
        echo json_encode([
            'icon' => 'warning',
            'success' => false,
            'title' => 'Error!',
            'message' => 'Your Account is Locked or registration is in process. Please contact the administrator.'
        ]);
        exit();
    }

    pg_query_params($conn, "INSERT INTO logs (user_id, action_made) VALUES ($1, $2)", [$_SESSION['ID'], 'Logged in the system.']);
    pg_query_params($conn, "UPDATE user_account SET status = '1', locked = '0' WHERE id = $1", [$_SESSION['ID']]);

    echo json_encode([
        'success' => true,
        'title' => 'Welcome!',
        'message' => 'Login successful!'
    ]);
} else {
    $admin_access = pg_query_params($conn, "SELECT * FROM user_account WHERE username = $1 AND access = 'ADMIN'", [$username]);
    if (pg_num_rows($admin_access) > 0) {
        echo json_encode([
            'icon' => 'warning',
            'success' => false,
            'title' => 'Wrong Password!'
        ]);
    } else {
        $exist = pg_query_params($conn, "SELECT * FROM user_account WHERE username = $1", [$username]);
        if (pg_num_rows($exist) > 0) {
            $row = pg_fetch_assoc($exist);
            $id = $row['id'];
            $locked = $row['locked'] + 1;

            if ($row['locked'] >= 3) {
                echo json_encode([
                    'icon' => 'warning',
                    'success' => false,
                    'title' => 'Account Locked!',
                    'message' => 'Your Account is Locked. Please contact the admin.'
                ]);
            } else {
                pg_query_params($conn, "UPDATE user_account SET locked = $1 WHERE id = $2", [$locked, $id]);
                echo json_encode([
                    'icon' => 'warning',
                    'success' => false,
                    'title' => 'Wrong Password!',
                    'message' => 'Attempt ' . $locked
                ]);
            }
        } else {
            echo json_encode([
                'icon' => 'error',
                'title' => 'Wrong Password!',
                'success' => false,
                'message' => 'Invalid username or password.'
            ]);
        }
    }
}
?>
