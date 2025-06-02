<?php
require("connect.php");
$encryptionKey = "mySecretKey12345";
if (!function_exists('logUpdate')) {
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
}
if (!function_exists('encryptPassword')) {
    function encryptPassword($password)
    {
        $iv = openssl_random_pseudo_bytes(16); // Ensures it's 16 bytes
        $encryptionKey = "mySecretKey12345";
        $cipher = "AES-128-CBC"; // Encryption method
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher)); // Generate a random IV
        $encryptedPassword = openssl_encrypt($password, $cipher, $encryptionKey, 0, $iv);
        return base64_encode($iv . "::" . $encryptedPassword); // Combine IV and encrypted password
    }
}
if (!function_exists('decryptPassword')) {
    function decryptPassword($encryptedData)
    {
        $iv = openssl_random_pseudo_bytes(16);
        $encryptionKey = "mySecretKey12345";
        $cipher = "AES-128-CBC";
        list($iv, $encryptedData) = explode("::", base64_decode($encryptedData), 2); // Split IV and encrypted data
        return openssl_decrypt($encryptedData, $cipher, $encryptionKey, 0, $iv);
    }
}
if (!function_exists('noHyphenUppercase')) {
    function noHyphenUppercase($string)
    {
        $string = str_replace('-', ' ', $string);
        return ucwords($string);
    }
}
if (!function_exists('removeHyphenNoSpace')) {
    function removeHyphenNoSpace($string)
    {
        $string = str_replace(['-', ' '], '', $string);
        $string = strtolower($string);
        return $string;
    }
}
if (!function_exists('convertToReadable')) {
    function convertToReadable($slug)
    {
        $string = str_replace('-', ' ', $slug);
        $string = ucwords($string);
        return $string;
    }
}
if (!function_exists('convertToReadable2')) {
    function convertToReadable2($slug)
    {
        $string = str_replace('_', ' ', $slug);
        $string = ucwords($string);
        return $string;
    }
}
if (!function_exists('convertToUnreadable')) {
    function convertToUnreadable($slug)
    {
        $string = strtolower($slug);
        $string = str_replace(' ', '_', $string);
        return $string;
    }
}
if (!function_exists('removeHyphen')) {
    function removeHyphen($string)
    {
        $string = str_replace(['-', ' '], '', $string);
        return $string;
    }
}
if (!function_exists('removeHyphen2')) {
    function removeHyphen2($string)
    {
        return str_replace('-', ' ', $string);
    }
}
if (!function_exists('convertPath')) {
    function convertPath($path)
    {
        $cleaned = str_replace("../", " ", $path);
        $base = basename($cleaned);
        $finalPath = 'images/' . $base;
        return $finalPath;
    }
}
if (!function_exists('convertPath2')) {
    function convertPath2($path)
    {
        $cleaned = str_replace("../", " ", $path);
        $base = basename($cleaned);
        $finalPath = 'files/' . $base;
        return $finalPath;
    }
}
if (!function_exists('noHyphenLowercase')) {
    function noHyphenLowercase($string)
    {
        $string = str_replace('-', '', $string);
        $string = strtolower($string);
        return $string;
    }
}
if (!function_exists('lowercaseNoSpace')) {
    function lowercaseNoSpace($text)
    {
        return strtolower(str_replace(' ', '', $text));
    }
}
if (!function_exists('pluralizeTableName')) {
    function pluralizeTableName($name)
    {
        $name = strtolower(str_replace(' ', '', $name));
        $pluralRules = [
            "whitepaper" => "whitepapers",
            "resource" => "resources",
            "videoscript" => "videoscripts",
            "ebook" => "ebooks",
            "pdffile" => "pdffiles",
        ];
        return $pluralRules[$name] ?? ($name . 's');
    }
}
