<?php
require("connect.php");
require 'vendor/autoload.php';
require('helpers/crudoperations.php');

use Dotenv\Dotenv;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($conn)) {
    $conn = new class {
        public function query($sql)
        {
            return new class {
                public $num_rows = 0;
                public function fetch_assoc()
                {
                    return null;
                }
            };
        }
    };
}

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
$cloud_name = $_ENV['CLOUDINARY_CLOUD_NAME'];
$api_key = $_ENV['CLOUDINARY_API_KEY'];
$api_secret = $_ENV['CLOUDINARY_API_SECRET'];
Configuration::instance([
    'cloud' => [
        'cloud_name' => $cloud_name,
        'api_key' => $api_key,
        'api_secret' => $api_secret
    ],
    'url' => [
        'secure' => true
    ]
]);
if (!function_exists('getFaviconAndLogo')) {
function getFaviconAndLogo()
{
    global $conn;
    $geticons_sql = "SELECT logo_imagepath, favicon_imagepath FROM website_logo ORDER BY id DESC LIMIT 1";
    $geticons_result = $conn->query($geticons_sql);
    if ($geticons_result->num_rows > 0) {
        while ($row = $geticons_result->fetch_assoc()) {
            $logo_path = $row['logo_imagepath'];
            $favicon_path = $row['favicon_imagepath'];
            return ["logo" => $logo_path, "favicon" => $favicon_path];
        }
        }
    }
}
if (!function_exists('cookieMessageAndVision')) {
function cookieMessageAndVision()
{
    global $conn;
    $getmessages_sql = "SELECT cookie_consent, website_vision FROM website_messages ORDER BY id DESC LIMIT 1";
    $getmessages_result = $conn->query($getmessages_sql);
    if ($getmessages_result->num_rows > 0) {
        while ($row = $getmessages_result->fetch_assoc()) {
            $cookie_message = $row['cookie_consent'];
            $vision_message = $row['website_vision'];
            return ["cookie_message" => $cookie_message, "website_vision" => $vision_message];
        }
    }
    }
}
if (!function_exists('metaTitles')) {
function metaTitles()
{
    global $conn;
    $getmetatitles_sql = "SELECT * FROM meta_titles ORDER BY id";
    $getmetatitles_result = $conn->query($getmetatitles_sql);

    $meta_data = [];
    if ($getmetatitles_result->num_rows > 0) {
        while ($row = $getmetatitles_result->fetch_assoc()) {
            $meta_data[strtolower($row['page_name'])] = [
                "meta_name1" => $row['meta_name1'],
                "meta_name2" => $row['meta_name2'],
                "meta_name3" => $row['meta_name3'],
                "meta_name4" => $row['meta_name4'],
                "meta_name5" => $row['meta_name5'],
                "meta_content1" => $row['meta_content1'],
                "meta_content2" => $row['meta_content2'],
                "meta_content3" => $row['meta_content3'],
                "meta_content4" => $row['meta_content4'],
                "meta_content5" => $row['meta_content5']
            ];
        }
    }
    return $meta_data;
}
}
if (!function_exists('sendEmail')) {
function sendEmail($email)
{
    global $conn;
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $date = date("Y-m-d");
        $time = date("H:i:s");
        $checkStmt = $conn->prepare("SELECT * FROM subscribers WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        if ($result->num_rows > 0) {
            $status_type = "Info";
            $status = "You are already subscribed with us!";
            return ["status" => $status, "status_type" => $status_type];
        } else {
            $stmt = $conn->prepare("INSERT INTO subscribers (email, date, time) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $date, $time);
            if ($stmt->execute()) {
                $forUser = 0;
                $action = 'New Email Subscription alert';
                logUpdate($conn, $forUser, $action);
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'aniagoluchiemelie77@gmail.com';
                    $mail->Password   = 'ozmsoscaivmkrbuu';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;
                    $mail->setFrom('aniagoluchiemelie77@gmail.com', 'Aniagolu Chiemelie');
                    $mail->addAddress($email, 'Chiboy');
                    $mail->isHTML(true);
                    $mail->Subject = 'Welcome to Our Newsletter';
                    $mail->Body    = "<h1>Thank you for subscribing to our newsletter! We are excited to have you with us.</h1>
                    <a href='http://localhost/Sample-dynamic-website/forms.php?email=$email' style='text-decoration:none;padding:10px 16px;margin:8px auto;border-radius:1rem;color:white;background-color:#222;cursor:pointer;'>unsubscribe</a>";
                    $mail->send();
                    $status_type = "Success";
                    $status = "Email Subscription Added Successfully";
                    return ["status" => $status, "status_type" => $status_type];
                } catch (Exception $e) {
                    $status_type = "Info";
                    $status = "Subscription successful, but welcome email could not be sent.";
                    return ["status" => $status, "status_type" => $status_type];
                }
            } else {
                $status_type = "Error";
                $status = "Email Subscription Failed";
                return ["status" => $status, "status_type" => $status_type];
            }
        }
    } else {
        $status_type = "Error";
        $status = "Invalid email address. Please try again.";
        return ["status" => $status, "status_type" => $status_type];
    }
    $stmt->close();
    $conn->close();
}
}
if (!function_exists('sendOTP')) {
function sendOTP($email, $firstname, $token)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->SMTPKeepAlive = true;
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'aniagoluchiemelie77@gmail.com';
        $mail->Password   = 'ozmsoscaivmkrbuu';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->setFrom('aniagoluchiemelie77@gmail.com', 'Aniagolu Chiemelie');
        $mail->addAddress($email, 'Chiboy');
        $mail->isHTML(true);
        $mail->Subject = 'Password Change Request';
        $mail->Body = "<h1>Hi $firstname,</h1>You are required to enter the following code in order to complete a password change action requested by you. Please enter this code in 1 minute. <center><h1>$token</h1></center>";
        $mail->send();
        $status_type = "Success";
        $status = "Password Reset OTP sent!";
        return ["status" => $status, "status_type" => $status_type];
        header("Location: verifyotp.php");
    } catch (Exception $e) {
        $status_type = "Error";
        $status = "Error, OTP could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return ["status" => $status, "status_type" => $status_type];
    }
}
}
if (!function_exists('calculateReadingTime')) {
function calculateReadingTime($content)
{
    $wordCount = str_word_count(strip_tags($content));
    $minutes = floor($wordCount / 200);
    return $minutes  . ' mins read ';
}
}
if (!function_exists('getOrdinalSuffix')) {
function getOrdinalSuffix($day)
{
    if (!in_array(($day % 100), [11, 12, 13])) {
        switch ($day % 10) {
            case 1:
                return 'st';
            case 2:
                return 'nd';
            case 3:
                return 'rd';
        }
    }
    return 'th';
}
}
if (!function_exists('unsubscribe')) {
function unsubscribe($email)
{
    global $conn;
    $sql = "DELETE FROM subscribers WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    if ($stmt->execute()) {
        $forUser = 0;
        $action = 'Cancelled Email Subscription alert';
        logUpdate($conn, $forUser, $action);
        $status = "Newsletter Subscription Cancelled Successfully";
        $status_type = "Success";
        return ["status" => $status, "status_type" => $status_type];
        header('location: http://localhost/Sample-dynamic-website/');
    } else {
        $status = "Newsletter Subscription Cancellation Failed";
        $status_type = "Error";
        return ["status" => $status, "status_type" => $status_type];
        header('location: http://localhost/Sample-dynamic-website/');
    }
}
}
if (!function_exists('sendNewPostNotification')) {
function sendNewpostNotification($post_title, $post_link, $post_image, $post_subtitle)
{
    global $conn;
    $sql = "SELECT email FROM subscribers";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $email = $row['email'];
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->SMTPKeepAlive = true;
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'aniagoluchiemelie77@gmail.com';
                $mail->Password = 'ozmsoscaivmkrbuu';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->setFrom('aniagoluchiemelie77@gmail.com', 'Aniagolu Chiemelie');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = "$post_title";
                $mail->Body = "<div style='font-family: Arial, sans-serif;width: 80%; padding: 1rem;'>
                                    <img src='$post_image' alt='Post Image' style='width:600px;height:400px;'/>
                                    <h1 style='padding:1rem;display:block;'>$post_title</h1>
                                    <h2 style='padding:1rem;display:block'>$post_subtitle</h2>
                                    <a href='$post_link' style='text-decoration:none;padding:10px 16px;border-radius:16pz;color: white;background-color:#222;cursor:pointer;margin-right:16px;'>Read Post</a>
                                    <a href='http://localhost/Sample-dynamic-website/forms.php?email=$email' style='text-decoration:none;padding:10px 16px;border-radius:16px;color: white;background-color:#222;cursor:pointer;'>Unsubscribe</a>
                                    
                                </div>";
                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent to $email. Error: {$mail->ErrorInfo}<br>";
            }
        }
    } else {
        echo "No subscribers found.";
    }
}
}
if (!function_exists('sendMessageToSubscriber')) {
function sendMessageToSubscriber($id, $message_title = null, $message_body = null)
{
    global $conn;
    $getSubscriber = "SELECT email FROM subscribers WHERE id = $id";
    $getSubscriber_result = $conn->query($getSubscriber);
    if ($getSubscriber_result->num_rows > 0) {
        while ($row = $getSubscriber_result->fetch_assoc()) {
            $email = $row['email'];
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->SMTPKeepAlive = true;
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'aniagoluchiemelie77@gmail.com';
                $mail->Password = 'ozmsoscaivmkrbuu';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->setFrom('aniagoluchiemelie77@gmail.com', 'Aniagolu Chiemelie');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = "$message_title";
                $mail->Body = "<div style='font-family: Arial, sans-serif;color:#222;width: 80%;padding:16px;'>
                                    $message_body
                                    <a href='http://localhost/Sample-dynamic-website/forms.php?email=$email' style='text-decoration:none;padding:10px 16px;margin:8px auto;border-radius:1rem;color:white;background-color:#222;cursor:pointer;'>unsubscribe</a>
                                </div>";
                if ($mail->send()) {
                    $forUser = 0;
                    $action = 'Email Sucessfully sent to ' . $email;
                    logUpdate($conn, $forUser, $action);
                    $status = "Message Delivered Successfully";
                    $status_type = "Success";
                    return ["status" => $status, "status_type" => $status_type];
                };
            } catch (Exception $e) {
                $status = "Message could not be sent to $email. Error: {$mail->ErrorInfo}";
                $status_type = "Success";
                return ["status" => $status, "status_type" => $status_type];
            }
        }
    } else {
        $status = "No subscribers found.";
        $status_type = "Error";
        return ["status" => $status, "status_type" => $status_type];
    }
}
}
if (!function_exists('sendMessageToUser')) {
function sendMessageToUser($id, $message_title = null, $message_body = null)
{
    global $conn;
    $getSubscriber = "SELECT email FROM otherwebsite_users WHERE id = $id";
    $getSubscriber_result = $conn->query($getSubscriber);
    if ($getSubscriber_result->num_rows > 0) {
        while ($row = $getSubscriber_result->fetch_assoc()) {
            $email = $row['email'];
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->SMTPKeepAlive = true;
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'aniagoluchiemelie77@gmail.com';
                $mail->Password = 'ozmsoscaivmkrbuu';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->setFrom('aniagoluchiemelie77@gmail.com', 'Aniagolu Chiemelie');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = "$message_title";
                $mail->Body = "<div style='font-family: Arial, sans-serif;color:#222;width: 80%;padding:16px;'>
                                    $message_body
                                </div>";
                if ($mail->send()) {
                    $forUser = 0;
                    $action = 'Email Sucessfully sent to ' . $email;
                    logUpdate($conn, $forUser, $action);
                    $status = "Message Delivered Successfully";
                    $status_type = "Success";
                    return ["status" => $status, "status_type" => $status_type];
                };
            } catch (Exception $e) {
                $status = "Message could not be sent to $email. Error: {$mail->ErrorInfo}";
                $status_type = "Success";
                return ["status" => $status, "status_type" => $status_type];
            }
        }
    } else {
        $status = "No subscribers found.";
        $status_type = "Error";
        return ["status" => $status, "status_type" => $status_type];
    }
}
}
if (!function_exists('sendMessageToWriter')) {
function sendMessageToWriter($id, $message_title = null, $message_body = null)
{
    global $conn;
    $getSubscriber = "SELECT email FROM writer WHERE id = $id";
    $getSubscriber_result = $conn->query($getSubscriber);
    if ($getSubscriber_result->num_rows > 0) {
        while ($row = $getSubscriber_result->fetch_assoc()) {
            $email = $row['email'];
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->SMTPKeepAlive = true;
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'aniagoluchiemelie77@gmail.com';
                $mail->Password = 'ozmsoscaivmkrbuu';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->setFrom('aniagoluchiemelie77@gmail.com', 'Aniagolu Chiemelie');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = "$message_title";
                $mail->Body = "<div style='font-family: Arial, sans-serif;color:#222;width: 80%;padding:16px;'>
                                    $message_body
                                </div>";
                if ($mail->send()) {
                    $forUser = 0;
                    $action = 'Email Sucessfully sent to ' . $email;
                    logUpdate($conn, $forUser, $action);
                    $status = "Message Delivered Successfully";
                    $status_type = "Success";
                    return ["status" => $status, "status_type" => $status_type];
                };
            } catch (Exception $e) {
                $status = "Message could not be sent to $email. Error: {$mail->ErrorInfo}";
                $status_type = "Success";
                return ["status" => $status, "status_type" => $status_type];
            }
        }
    } else {
        $status = "No subscribers found.";
        $status_type = "Error";
        return ["status" => $status, "status_type" => $status_type];
    }
}
}
if (!function_exists('updateTranslations')) {
function updateTranslations($string)
{
    $languages = ['arb' => 'ar', 'en' => 'en', 'es' => 'es', 'fr' => 'fr', 'ger' => 'de', 'mdn' => 'zh', 'rsn' => 'ru'];
    $folder = "translation_files";
    $results = [];
    foreach ($languages as $langFile => $langCode) {
        $filePath = "$folder/lang/$langFile.php";
        if (!file_exists($filePath)) {
            $results[] = ["status" => "Skipping: $filePath does not exist.", "status_type" => "Error"];
            continue;
        }
        $fileContent = file_get_contents($filePath);
        if (preg_match('/\$translations\s*=\s*\[(.*?)\];/s', $fileContent, $matches)) {
            $translationsArrayContent = $matches[1];
            $key = strtolower(str_replace(' ', '_', $string));
            $translator = new GoogleTranslate($langCode);
            $value = $translator->translate($string);

            if (strpos($translationsArrayContent, "'$key'") === false) {
                $newEntry = "    '$key' => '$value',\n";
                $updatedArrayContent = $translationsArrayContent . "\n" . $newEntry;
                $updatedContent = str_replace($matches[0], "\$translations = [$updatedArrayContent];", $fileContent);
                file_put_contents($filePath, $updatedContent);
                $results[] = ["status" => "Created Page successfully.", "status_type" => "Success"];
            } else {
                $results[] = ["status" => "'$key' already exists in $filePath", "status_type" => "Error"];
            }
        } else {
            $results[] = ["status" => "Could not locate \$translations array in $filePath", "status_type" => "Error"];
        }
    }
    return $results;
}
}
if (!function_exists('formatDateSafely')) {
function formatDateSafely($dateString)
{
    if (!empty($dateString) && $dateString !== '0000-00-00' && strtotime($dateString)) {
        return date('F d, Y', strtotime($dateString));
    }
    return null;
}
}
if (!function_exists('uploadToCloudinary')) {
function uploadToCloudinary($filePath)
{
    $upload = new UploadApi();
    $result = $upload->upload($filePath, [
        'folder' => 'uploads',
        'public_id' => pathinfo($filePath, PATHINFO_FILENAME),
        'crop' => 'fit',
        'width' => 800, // Resize width
        'height' => 600,
        'quality' => 'auto',
    ]);
    return $result['secure_url'] ?? null;
}
}
if (!function_exists('getDeviceType')) {
function getDeviceType()
{
    $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    if (strpos($user_agent, 'mobile') !== false) {
        return 'Mobile';
    } elseif (strpos($user_agent, 'tablet') !== false) {
        return 'Tablet';
    } else {
        return 'Desktop';
    }
}
}
if (!function_exists('getVisitorIP')) {
function getVisitorIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}
}
if (!function_exists('getIconForTable')) {
function getIconForTable($tableName)
{
    $iconMap = [
        'ebooks' => 'fa-book',
        'videoscripts' => 'fa-film',
        'googledrivedocs' => 'fa-file',
        'whitepapers' => 'fa-file-alt',
        'webfiles' => 'fa-file',
        'landingpage' => 'fa-globe',
        'pdffiles' => 'fa-file-text',
    ];
    foreach ($iconMap as $keyword => $iconClass) {
        if (strpos($tableName, $keyword) !== false) {
            return $iconClass;
        }
    }
    return 'fa-database';
}
}
if (!function_exists('logUserAction')) {
function logUserAction($ipAddress, $deviceType, $logFilePath, $action, $firstName = null)
{
    date_default_timezone_set('Africa/Lagos');
    $formattedDate = date('D jS Y');
    $formattedTime = date('h:i A');
    $logMessage = "User $firstName with $ipAddress, $deviceType $action at $formattedDate $formattedTime" . PHP_EOL;
    if (!file_exists($logFilePath)) {
        file_put_contents($logFilePath, "=== User Action Log ===" . PHP_EOL, LOCK_EX);
    }
    file_put_contents($logFilePath, $logMessage, FILE_APPEND | LOCK_EX);
}
}
if (!function_exists('isLoginAllowed')) {
function isLoginAllowed($ipAddress, $logFilePath, $maxAttempts = 10, $timeWindow = 600)
{
    $now = time();
    $attempts = [];

    if (!file_exists($logFilePath)) {
        file_put_contents($logFilePath, '');
    }

    $lines = file($logFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '|') !== false) {
            list($ip, $timestamp) = explode('|', $line);
            if ($ip === $ipAddress && ($now - (int)$timestamp) <= $timeWindow) {
                $attempts[] = $timestamp;
            }
        }
    }

    if (count($attempts) >= $maxAttempts) {
        return false;
    }

    file_put_contents($logFilePath, "$ipAddress|$now" . PHP_EOL, FILE_APPEND | LOCK_EX);
    return true;
}
}
if (!function_exists('userLogin')) {
function userLogIn($usertype, $userDbName,)
{
    global $conn, $email, $password, $ipAddress, $deviceType, $logFilePath, $action;
    if (isset($_POST['remember'])) {
        setcookie("emailid", $email, time() + 3600, "/", "", true, true);
        setcookie("passwordid", $_POST['Password'], time() + 60 * 60);
    }
    $query = "SELECT * FROM $userDbName WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if ($user && password_verify($password, $user['password'])) {
            $action = 'successfully logged in to ' . $usertype . ' page';
            logUserAction($ipAddress, $deviceType, $logFilePath, $action);
            $_SESSION['email'] = $user['email'];
            $_SESSION['id'] = $user['id'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['image'] = $user['image'];
            $_SESSION['bio'] = $user['bio'];
            $_SESSION['mobile'] = $user['mobile'];
            $_SESSION['country'] = $user['country'];
            $_SESSION['city'] = $user['city'];
            $_SESSION['state'] = $user['state'];
            $_SESSION['address'] = $user['address1'];
            $_SESSION['addresstwo'] = $user['address2'];
            $_SESSION['country_code'] = $user['country_code'];
            $_SESSION['date_joined'] = $user['date_joined'];
            $_SESSION['language'] = $user['language'];
            if ($usertype === 'admin') {
                $_SESSION['user'] = 'Admin';
                header("location: ../admin_homepage.php");
            } else if ($usertype === 'editor') {
                    $_SESSION['user'] = 'Editor';
                header("location: ../editor_homepage.php");
            }
            exit();
        } else {
            $action = 'attempted login unsucessfully to ' . $usertype . ' page';
            logUserAction($ipAddress, $deviceType, $logFilePath, $action);
            $msg = "Invalid Password";
        }
    } else {
        $msg = "User not found";
    }
    return $msg;
}
}
if (!function_exists('adminAccessToEditoPage')) {
    function adminAccessToEditoPage($id, $password, $editor_id, $firstName)
    {
        global $conn, $ip_address, $device_type, $logFilePath;
        $check_password_sql = "SELECT password FROM admin_login_info WHERE id = ?";
        $stmt = $conn->prepare($check_password_sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];
            if (password_verify($password, $hashed_password)) {
                $editor_sql = "SELECT * FROM editor WHERE id = ?";
                $stmt = $conn->prepare($editor_sql);
                $stmt->bind_param("i", $editor_id);
                $stmt->execute();
                $editor_result = $stmt->get_result();
                if ($editor_result->num_rows > 0) {
                    $action = "successfully logged in to editor's page";
                    logUserAction($ip_address, $device_type, $logFilePath, $action, $firstName);
                    $editor_row = $editor_result->fetch_assoc();
                    $_SESSION['email'] = $editor_row['email'];
                    $_SESSION['id'] = $editor_row['id'];
                    $_SESSION['firstname'] = $editor_row['firstname'];
                    $_SESSION['lastname'] = $editor_row['lastname'];
                    $_SESSION['username'] = $editor_row['username'];
                    $_SESSION['image'] = $editor_row['image'];
                    $_SESSION['bio'] = $editor_row['bio'];
                    $_SESSION['mobile'] = $editor_row['mobile'];
                    $_SESSION['country'] = $editor_row['country'];
                    $_SESSION['city'] = $editor_row['city'];
                    $_SESSION['state'] = $editor_row['state'];
                    $_SESSION['address'] = $editor_row['address1'];
                    $_SESSION['addresstwo'] = $editor_row['address2'];
                    $_SESSION['country_code'] = $editor_row['country_code'];
                    $_SESSION['date_joined'] = $editor_row['date_joined'];
                    $_SESSION['language'] = $editor_row['language'];
                    header("location: ../editor/editor_homepage.php");
                    exit();
                } else {
                    $_SESSION['status_type'] = "Error";
                    $_SESSION['status'] = "No editor found with this ID!";
                    header('location: ../admin/admin_homepage.php');
                }
            } else {
                $action = "attempted an unsuccessful login to editor's page";
                logUserAction($ip_address, $device_type, $logFilePath, $action, $firstName);
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Incorrect password. Please try again.";
                header('location: ../admin/admin_homepage.php');
                exit();
            }
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Admin not found, repeat login process..";
            header('location: ../admin/login/index.php');
            exit();
        }
    }
}
$base_url = "http://localhost/Sample-dynamic-website/admin/";
$editor_base_url = "http://localhost/Sample-dynamic-website/editor/";

if (php_sapi_name() !== 'cli' || defined('PHPSTAN_RUNNING')) {
    $device_type = getDeviceType();
    $ip_address = getVisitorIP();
    $meta_titles = metaTitles();
}
