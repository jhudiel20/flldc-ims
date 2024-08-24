<?php
// Enable error reporting for debugging purposes (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Sample user data array
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

// For demonstration, hardcoding total records and page count
$totalRecords = 2; // Total number of records in the database
$perPage = 20; // Number of records per page
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page from request

// Calculate total pages
$lastPage = ceil($totalRecords / $perPage);

// Validate that $data is an array
if (!is_array($data)) {
    $data = []; // Ensure $data is an empty array if validation fails
}

// Set the Content-Type header to application/json
header('Content-Type: application/json');

// Return the data as JSON with pagination information
echo json_encode([
    'last_page' => $lastPage,
    'data' => $data,
	'total_record' => $totalRecords
]);
?>
