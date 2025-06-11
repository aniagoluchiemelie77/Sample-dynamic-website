<?php
require("connect.php");
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
if (!function_exists('removeUnderscoreNoSpace')) {
    function removeUnderscoreNoSpace($string)
    {
        $string = str_replace(['_', ' '], '', $string);
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
if (!function_exists('convertToUnreadable2')) {
    function convertToUnreadable2($slug)
    {
        $string = strtolower($slug);
        $string = str_replace('-', '_', $string);
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
        return $pluralRules[$name] ?? $name;
    }
}
if (!function_exists('removeUnderscore2')) {
    function removeUnderscore2($string)
    {
        return str_replace('_', ' ', $string);
    }
}
if (!function_exists('addUnderscore')) {
    function addUnderscore($string)
    {
        return str_replace(' ', '_', $string);
    }
}
