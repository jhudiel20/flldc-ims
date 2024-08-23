<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection and config
require_once __DIR__ . '/../DBConnection.php'; // Adjusted path for DBConnection.php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fileMimes = array(
        'image/gif',
        'image/jpeg',
        'image/jpg',
        'image/png'
    );

    $maxFileSize = 2 * 1024 * 1024; // 2MB in bytes

    if ($_FILES['image']['name'] == '') {
        $response['message'] = 'Please select a photo';
        $response['title'] = 'Warning!';
        echo json_encode($response);
        exit();
    }

    if (!in_array($_FILES['image']['type'], $fileMimes)) {
        $response['message'] = 'PLEASE INSERT VALID FORMAT! (jpg, png, jpeg, gif)';
        echo json_encode($response);
        exit();
    }

    if ($_FILES['image']['size'] > $maxFileSize) {
        $response['message'] = 'The image size must be less than 2MB!';
        $response['title'] = 'Warning!';
        echo json_encode($response);
        exit();
    }

    $id = $_POST['ID'];
    $img = $_FILES['image']['name'];
    $img_temp_loc = $_FILES['image']['tmp_name'];
    $img_store = require_once __DIR__ . "/../../public/user_image/" . $img;

    if (move_uploaded_file($img_temp_loc, $img_store)) {
        $sql = $conn->prepare("UPDATE user_account SET image = :img WHERE ID = :id");
        $sql->bindParam(':img', $img, PDO::PARAM_STR);
        $sql->bindParam(':id', $id, PDO::PARAM_STR);
        $sql->execute();

        $response['success'] = true;
        $response['title'] = 'Success';
        $response['message'] = 'User Picture Updated';
        echo json_encode($response);

        $user_id = $_COOKIE['ID'];
        $action = "Updated picture in User: " . $_COOKIE['FNAME'] . ' ' . $_COOKIE['MNAME'] . ' ' . $_COOKIE['LNAME'];
        $stmt = $conn->prepare("INSERT INTO logs (user_id, action_made) VALUES (:user_id, :action_made)");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':action_made', $action, PDO::PARAM_STR);
        $stmt->execute();
    } else {
        $response['message'] = 'Failed to upload image!';
        echo json_encode($response);
    }
    exit();
}
?>
