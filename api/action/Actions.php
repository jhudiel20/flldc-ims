<?php 
// Display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php

        $updateStatus = $conn_acc->prepare("UPDATE user_account SET STATUS = :status WHERE ID = :id");
        $updateStatus->execute([
        ':status' => 0,
        ':id' => $_COOKIE['ID']
        ]);

        // Log the user action (Logged out)
        $user_id = $_COOKIE['ID'];
        $action_made = "Logged out.";

        $logAction = $conn_acc->prepare("INSERT INTO logs (user_id, action_made) VALUES (:user_id, :action_made)");
        $logAction->execute([
        ':user_id' => $user_id,
        ':action_made' => $action_made
        ]);

        $cookieNames = [
                'ID',
                'ACCESS',
                'USERNAME',
                'PASSWORD',
                'DATE_CREATED',
                'FNAME',
                'MNAME',
                'LNAME',
                'EXT_NAME',
                'EMAIL',
                'IMAGE',
                'LOCKED',
                'ADMIN_STATUS'
            ];
            
            // Loop through the array and destroy each cookie
            foreach ($cookieNames as $cookieName) {
                setcookie($cookieName, '', time() - 3600, '/');
            }

        header("Location: /login.php");
exit();
