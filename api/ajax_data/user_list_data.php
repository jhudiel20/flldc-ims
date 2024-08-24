<?php
// Sample user data
$data = [
    [
        "ID" => 1,
        "FNAME" => "John",
        "MNAME" => "A.",
        "LNAME" => "Doe",
        "EXT_NAME" => "",
        "STATUS" => "Active",
        "EMAIL" => "john.doe@example.com",
        "CONTACT" => "1234567890",
        "ACCESS" => "Admin",
        "IMAGE" => "john_doe.jpg",
        "LOCKED" => 0,
        "APPROVED_STATUS" => 2,
        "ADMIN_STATUS" => "PRIMARY"
    ],
    [
        "ID" => 2,
        "FNAME" => "Jane",
        "MNAME" => "B.",
        "LNAME" => "Smith",
        "EXT_NAME" => "",
        "STATUS" => "Inactive",
        "EMAIL" => "jane.smith@example.com",
        "CONTACT" => "0987654321",
        "ACCESS" => "User",
        "IMAGE" => "",
        "LOCKED" => 0,
        "APPROVED_STATUS" => 0,
        "ADMIN_STATUS" => "SECONDARY"
    ],
    // Add more user data as needed
];

// Convert the data to JSON format
echo json_encode($data);
?>
