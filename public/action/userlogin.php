<?php
require '../DBConnection.php';
include '../config/config.php';


var_dump($_REQUEST);

// $username = isset($_POST['username']) ? trim($_POST['username']) : '';
// $password = isset($_POST['password']) ? trim($_POST['password']) : '';

// if (strpos($password, "'") !== false || strpos($username, "'") !== false){
//     $response['icon'] = "warning";
//     $response['success'] = false;
//     $response['title'] = "Error!";
//     $response['message'] = 'Password cannot contain single quotes or double quotes!';
//     echo json_encode($response);
//     exit();
// }
// if (strpos($password, '"') !== false || strpos($username, '"') !== false){
//     $response['icon'] = "warning";
//     $response['success'] = false;
//     $response['title'] = "Error!";
//     $response['message'] = 'Password cannot contain single quotes or double quotes!';
//     echo json_encode($response);
//     exit();
// }

// $password = set_password($password);

// if($username == '' || $password == ''){
//     $response['icon'] = "warning";
//     $response['success'] = false;
//     $response['title'] = "Something Went Wrong!";
//     $response['message'] = "Please fill all fields!";
//     echo json_encode($response);
//     exit();
// }
// // var_dump($password);
// $check1 = mysqli_query($conn, "SELECT * FROM user_account WHERE BINARY USERNAME = '$username' AND BINARY PASSWORD = '$password' AND APPROVED_STATUS = 0 ");

// if(mysqli_num_rows($check1) > 0){
//     $response['icon'] = "error";
//     $response['success'] = false;
//     $response['title'] = "Error!";
//     $response['message'] = "Your registration is on process!";
//     echo json_encode($response);
//     exit();
// }
// $check2 = mysqli_query($conn, "SELECT * FROM user_account WHERE BINARY USERNAME = '$username' AND BINARY PASSWORD = '$password' AND APPROVED_STATUS = 0 AND ACCESS = ''  ");

// if(mysqli_num_rows($check2) > 0){
//     $response['icon'] = "error";
//     $response['success'] = false;
//     $response['title'] = "Error!";
//     $response['message'] = "Your registration is on process!";
//     echo json_encode($response);
//     exit();
// }

// $check3 = mysqli_query($conn, "SELECT * FROM user_account WHERE BINARY USERNAME = '$username' AND BINARY PASSWORD = '$password' AND APPROVED_STATUS = 2 AND LOCKED = 3 AND ACCESS != 'ADMIN'");

// if(mysqli_num_rows($check3) > 0){
//     $check4 = mysqli_query($conn, "SELECT * FROM user_account WHERE BINARY USERNAME = '$username' AND BINARY PASSWORD = '$password' AND APPROVED_STATUS = 2 AND LOCKED = 3 ");

//     if(mysqli_num_rows($check4) > 0){
//         $response['icon'] = "error";
//         $response['success'] = false;
//         $response['title'] = "Error!";
//         $response['message'] = "Your Account is Locked. Please Contact the Administrator.";
//         echo json_encode($response);
//         exit();
//     }
// }

// $query = "SELECT * FROM user_account WHERE BINARY USERNAME = ? AND BINARY PASSWORD = ? ";
// $stmt = mysqli_prepare($conn, $query);
// mysqli_stmt_bind_param($stmt, "ss", $username, $password);

// // Execute the query
// mysqli_stmt_execute($stmt);

// // Fetch the result
// $result = mysqli_stmt_get_result($stmt);



// if ($row = mysqli_fetch_assoc($result)) {
//     // Login success


//     if($row['APPROVED_STATUS'] == 1){
//         $response['icon'] = "error";
//         $response['success'] = false;
//         $response['title'] = "Error!";
//         $response['message'] = "The administrator has rejected your registration!!!";
//         echo json_encode($response);
//         exit();
//     }
    
//     // You can access the user's data from the fetched variables
//     $_SESSION['status'] = true;
//     $_SESSION['ID'] = $row['ID'];
//     $_SESSION['ACCESS'] = $row['ACCESS'];
//     $_SESSION['USERNAME'] = $row['USERNAME'];
//     $_SESSION['PASSWORD'] = $row['PASSWORD'];
//     $_SESSION['DATE_CREATED'] = $row['DATE_CREATED'];
//     $_SESSION['FNAME'] = $row['FNAME'];
//     $_SESSION['MNAME'] = $row['MNAME'];
//     $_SESSION['LNAME'] = $row['LNAME'];
//     $_SESSION['EXT_NAME'] = $row['EXT_NAME'];
//     $_SESSION['EMAIL'] = $row['EMAIL'];
//     $_SESSION['IMAGE'] = $row['IMAGE'];
//     $_SESSION['LOCKED'] = $row['LOCKED'];
//     $_SESSION['ADMIN_STATUS'] = $row['ADMIN_STATUS'];

//     if($_SESSION['ACCESS'] == ''){
//         $response['icon'] = "info";
//         $response['success'] = false;
//         $response['title'] = "Error!";
//         $response['message'] = "Your registration is on process!";
//         echo json_encode($response);
//         exit();
//     }
//     if($_SESSION['ACCESS'] == 'ENCODER' || $_SESSION['ACCESS'] == 'REQUESTOR'){
//         if($_SESSION['LOCKED'] == 3){
//             $response['icon'] = "warning";
//             $response['success'] = false;
//             $response['title'] = "Error!";
//             $response['message'] = "Your Account is Locked Please Contact the admin.";
//             echo json_encode($response);
//             exit();
//         }
    
//     }
 
    
//     $user_id = $_SESSION['ID'] ;
//     $action = "Logged in the system.";
    
//     $logs = mysqli_query($conn, "INSERT INTO `logs` (`user_id`,`action_made`) VALUES('$user_id','$action')");


//     $response['success'] = true;
//     $response['title'] = 'Welcome!';
//     $response['message'] = 'Login successful!';

//     echo json_encode($response);
//     $status = mysqli_query($conn, "UPDATE user_account SET STATUS = '1', LOCKED = '0' WHERE ID = '" . $_SESSION['ID'] . "' ");

// } else {
//     $admin_access = mysqli_query($conn, "SELECT * FROM user_account WHERE BINARY USERNAME = '" . $username . "' AND ACCESS = 'ADMIN'");
//     if( mysqli_num_rows($admin_access) > 0 ){
//         $response['icon'] = "warning";
//         $response['success'] = false;
//         $response['title'] = "Wrong Password!";
//         echo json_encode($response);
//     }else{
//             $exist = mysqli_query($conn, "SELECT * FROM user_account WHERE BINARY USERNAME = '" . $username . "' ");
//             $row = mysqli_fetch_assoc($exist);
//             if (mysqli_num_rows($exist) > 0) {
//                 $id = $row['ID'];
//                 $locked = mysqli_query($conn, "SELECT * FROM user_account WHERE BINARY USERNAME = '" . $username . "' AND BINARY PASSWORD = '" . $password . "'");
//                 $lock = mysqli_fetch_assoc($locked);
//                 if (mysqli_num_rows($locked) > 0) {
//                     if ($lock['LOCKED'] >= 3) {
//                         $response['icon'] = "warning";
//                         $response['success'] = false;
//                         $response['title'] = "Account Locked!";
//                         $response['message'] = "Your Account is Locked Please Contact the admin.";
//                         echo json_encode($response);
//                         // exit;
//                     }
//                     if ($lock['LOCKED'] < 3) {
//                         mysqli_query($conn, "UPDATE user_account set  WHERE ID = '" . $lock['ID'] . "'");
//                         // success();
//                     }
//                 } else {
//                     $id = $row['ID'];
//                     $locked = $row['LOCKED'] + 1;
//                     $user_is_locked = mysqli_query($conn, "SELECT * FROM user_account WHERE ID = '" . $id . "' ");
//                     $user = mysqli_fetch_assoc($user_is_locked);
//                     if ($user['LOCKED'] >= 3) {
//                         $response['icon'] = "warning";
//                         $response['success'] = false;
//                         $response['title'] = "Account Locked!";
//                         $response['message'] = "Your Account is Locked Please Contact the admin.";
//                         echo json_encode($response);
//                         // exit;
//                     }
//                     if ($user['LOCKED'] < 3) {
//                         $user_locked = mysqli_query($conn, "UPDATE user_account SET LOCKED ='" . $locked . "' WHERE ID = '" . $id . "'");
//                         $response['icon'] = "warning";
//                         $response['success'] = false;
//                         $response['title'] = "Wrong Password!";
//                         $response['message'] = "Attemp " . $locked;
//                         echo json_encode($response);
//                         // exit;
//                     }
//                 }
//             } else {
//                   // Login failed
//                     $response['icon'] = "error";
//                     $response['title'] = "Wrong Password!";
//                     $response['success'] = false;
//                     $response['message'] = 'Invalid username or password.';
//                     echo json_encode($response);
//             }
//         }

// }
