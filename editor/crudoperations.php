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
function createcategory($filename, $content, $description)
{
    $file = fopen('../../pages/' . $filename, 'w');
    if ($file) {
        fwrite($file, $content);
        fclose($file);
    } else {
        die("Unable to create file.");
    }
    global $conn;
    $stmt = $conn->prepare("INSERT INTO topics (name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $filename, $description);
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
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
?>