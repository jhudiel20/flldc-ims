<?php
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php
// if (!isset($_SESSION['ACCESS'])) {
//     header("Location:index.php");
// }
ini_set('session.cookie_secure', 1);
echo $_COOKIE['ACCESS'];
?>

