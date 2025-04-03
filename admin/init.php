<?php
require("connect.php");
$userId = $_SESSION['id'];
$result = $conn->query("SELECT language FROM admin_login_info WHERE id = $userId");
$language = $result->fetch_assoc()['language'] ?? 'en'; // Default to English

$translationFile = "translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = []; // Initialize as empty array to avoid undefined variable errors
}

$timezone = $_SESSION['timezone'] ?? 'UTC'; // Retrieve from session or use default
date_default_timezone_set($timezone);

?>