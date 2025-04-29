<?php
require("connect.php");
$userId = $_SESSION['id'];
$stmt = $conn->prepare("SELECT language FROM admin_login_info WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
if ($result && $result->num_rows > 0) {
    $language = $result->fetch_assoc()['language'] ?? 'en';
} else {
    $language = 'en'; // Default language fallback
}
$translationFile = "translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = []; // Initialize as empty array to avoid undefined variable errors
}
error_log("User language: " . $language);

$timezone = $_SESSION['timezone'] ?? 'UTC'; // Retrieve from session or use default
date_default_timezone_set($timezone);

?>