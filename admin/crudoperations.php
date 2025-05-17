<?php
require("connect.php");
$encryptionKey = "mySecretKey12345";
function logUpdate($conn, $forUser, $action)
{
    global $conn;
    date_default_timezone_set('UTC');
    $date = date('Y-m-d');
    $time = date("H:iA");
    $sql = "INSERT INTO updates (content, for_user, Date, time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $action, $forUser, $date, $time);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
    $stmt->close();
}
function encryptPassword($password)
{
    $iv = openssl_random_pseudo_bytes(16); // Ensures it's 16 bytes
    $encryptionKey = "mySecretKey12345";
    $cipher = "AES-128-CBC"; // Encryption method
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher)); // Generate a random IV
    $encryptedPassword = openssl_encrypt($password, $cipher, $encryptionKey, 0, $iv);
    return base64_encode($iv . "::" . $encryptedPassword); // Combine IV and encrypted password
}
function decryptPassword($encryptedData)
{
    $iv = openssl_random_pseudo_bytes(16);
    $encryptionKey = "mySecretKey12345";
    $cipher = "AES-128-CBC";
    list($iv, $encryptedData) = explode("::", base64_decode($encryptedData), 2); // Split IV and encrypted data
    return openssl_decrypt($encryptedData, $cipher, $encryptionKey, 0, $iv);
}
function noHyphenUppercase($string)
{
    $string = str_replace('-', ' ', $string);
    return ucwords($string);
}
function removeHyphenNoSpace($string)
{
    $string = str_replace(['-', ' '], '', $string);
    $string = strtolower($string);
    return $string;
}
function convertToReadable($slug)
{
    $string = str_replace('-', ' ', $slug);
    $string = ucwords($string);
    return $string;
}
function convertToUnreadable($slug)
{
    $string = strtolower($slug);
    $string = str_replace(' ', '_', $string);
    return $string;
}
function removeHyphen($string)
{
    $string = str_replace(['-', ' '], '', $string);
    return $string;
}
function convertPath($path)
{
    $cleaned = str_replace("../../", " ", $path);
    return basename($cleaned);
}
?>