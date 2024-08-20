<?php
require 'DBConnection.php';
include 'config/config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

// Output the content of the $_REQUEST array to validate incoming data
print_r($_REQUEST);
exit();

// The rest of your code...
