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

    if ($_FILES['image']['name'] == '') {
        $response['title'] = 'Warning!';
        $response['message'] = 'Please select a photo';
        echo json_encode($response);
        exit();
    }

    if (!empty($_FILES['image']['name']) && in_array($_FILES['image']['type'], $fileMimes)) {
        $img_directory = __DIR__ . '/../../public/user_image/';
        if (!is_dir($img_directory)) {
            mkdir($img_directory, 0755, true);
        }

        $id = $_POST['ID'];
        $img = $_FILES['image']['name'];
        $img_temp_loc = $_FILES['image']['tmp_name'];
        $img_store = $img_directory . $img;

        // Check if the path exists
        if (!is_dir($img_directory)) {
            $response['title'] = 'Error!';
            $response['message'] = 'Upload directory does not exist!';
            echo json_encode($response);
            exit();
        }

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
            $action = "Updated picture in User : " . $_COOKIE['FNAME'] . ' ' . $_COOKIE['MNAME'] . ' ' . $_COOKIE['LNAME'];
            $stmt = $conn->prepare("INSERT INTO logs (user_id, action_made) VALUES (:user_id, :action_made)");
            $stmt->bindParam(':user_id', $_COOKIE['ID'], PDO::PARAM_INT);
            $stmt->bindParam(':action_made', $action, PDO::PARAM_STR);
            $stmt->execute();
            exit();
        } else {
            $response['title'] = 'Error!';
            $response['message'] = 'Failed to upload image!';
            echo json_encode($response);
            exit();
        }
    } else {
        $response['title'] = 'Warning!';
        $response['message'] = 'Please insert a valid format! (jpg, png, jpeg, gif)';
        echo json_encode($response);
        exit();
    }
}
