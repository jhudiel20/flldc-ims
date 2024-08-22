<?php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php
// if (!isset($_SESSION['ACCESS'])) {
//     header("Location:index.php");
// }
session_start();
echo session_save_path();
echo $_SESSION['ACCESS'];
print_r($_SESSION);
?>

