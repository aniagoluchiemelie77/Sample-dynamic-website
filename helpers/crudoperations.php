<?php
require __DIR__ . '/../connect.php';
/** @var \mysqli $conn */
global $conn;
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
if (!function_exists('convertToUnreadable3')) {
    function convertToUnreadable3($slug)
    {
        $string = strtolower($slug);
        $string = str_replace(' ', '-', $string);
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
if (!function_exists('formatDate')) {
    function formatDate($dateString)
    {
        $timestamp = strtotime($dateString);
        $day = date('j', $timestamp);
        $month = date('F', $timestamp);
        $year = date('Y', $timestamp);
        $daySuffix = date('jS', $timestamp);
        return "$month $daySuffix $year";
    }
}
if (!function_exists('formatTime')) {
    function formatTime($timeString)
    {
        $time_object = DateTime::createFromFormat('H:i:s', $timeString);
        $formatted_time = $time_object->format('g:i A');
        return $formatted_time;
    }
}
if (!function_exists('personalizeMessageEditor')) {
    function personalizeMessageEditor($content, $user)
    {
        if (preg_match("/Editor\s+$user\b/i", $content)) {
            $content = preg_replace("/Editor\s+$user\b/i", "You", $content);
            $replacements = [
                "/\bhis\/her\b/i" => "your",
                "/\bhis\s*\/\s*her\b/i" => "your",
                "/\bhis\s+or\s+her\b/i" => "your",
                "/\bhis\b/i" => "your",
                "/\bher\b/i" => "your",
                "/\btheir\b/i" => "your",
                "/\btheirs\b/i" => "yours",
            ];

            foreach ($replacements as $pattern => $replacement) {
                $content = preg_replace($pattern, $replacement, $content);
            }
        }
        return $content;
    }
}
if (!function_exists('personalizeMessageAdmin')) {
    function personalizeMessageAdmin($content, $user)
    {
        if (preg_match("/Admin\s+$user\b/i", $content)) {
            $content = preg_replace("/Admin\s+$user\b/i", "You", $content);
            $replacements = [
                "/\bhis\/her\b/i" => "your",
                "/\bhis\s*\/\s*her\b/i" => "your",
                "/\bhis\s+or\s+her\b/i" => "your",
                "/\bhis\b/i" => "your",
                "/\bher\b/i" => "your",
                "/\btheir\b/i" => "your",
                "/\btheirs\b/i" => "yours",
            ];

            foreach ($replacements as $pattern => $replacement) {
                $content = preg_replace($pattern, $replacement, $content);
            }
        }
        return $content;
    }
}
if (!function_exists('getTimeBasedGreeting')) {
    function getTimeBasedGreeting($name)
    {
        date_default_timezone_set('Africa/Lagos');
        $hour = (int) date('G');
        if ($hour >= 5 && $hour < 12) {
            $greeting = "Good morning";
        } elseif ($hour >= 12 && $hour < 17) {
            $greeting = "Good afternoon";
        } elseif ($hour >= 17 && $hour < 21) {
            $greeting = "Good evening";
        } else {
            $greeting = "Good night";
        }
        return $name ? "$greeting, $name" : "$greeting";
    }
}
if (!function_exists('removeHyphenUc')) {
    function removeHyphenUc($string)
    {
        $string = str_replace(['-', ' '], ' ', $string);
        $string = ucwords($string);
        return $string;
    }
}
if (!function_exists('updateMetatitle')) {
    function updateMetatitle($meta1, $meta2, $meta3, $meta4, $meta5, $content1, $content2, $content3, $content4, $content5, $page_name, $usertype)
    {
        global $conn;
        $usertype === 'Admin' ? $user = 'Admin' : $user = 'Editor';
        $stmt = $conn->prepare("UPDATE meta_titles SET meta_name1 = ?, meta_name2 = ?, meta_name3 = ?, meta_name4 = ?, meta_name5 = ?, meta_content1 = ?, meta_content2 = ?, meta_content3 = ?, meta_content4 = ?, meta_content5 = ? WHERE page_name = ?");
        $stmt->bind_param("sssssssssss", $meta1, $meta2, $meta3, $meta4, $meta5, $content1, $content2, $content3, $content4, $content5, $page_name);
        if ($stmt->execute()) {
            $page_name = removeHyphenUc($page_name);
            $content = "$user " . $_SESSION['firstname'] . " updated Meta titles and contents for $page_name";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Meta Titles and Content Updated Successfully";
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
        }
    }
}
