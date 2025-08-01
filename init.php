<?php
require("connect.php");
require 'vendor/autoload.php';
require('helpers/crudoperations.php');
require('vendor\phpmailer\phpmailer\src\SMTP.php');
require('vendor\phpmailer\phpmailer\src\Exception.php');
require('vendor\phpmailer\phpmailer\src\PHPMailer.php');
require 'vendor/autoload.php';

use Dotenv\Dotenv;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


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
$meta_titles = metaTitles();
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
function calculateReadingTime($content)
{
    $wordCount = str_word_count(strip_tags($content));
    $minutes = floor($wordCount / 200);
    return $minutes  . ' mins read ';
}
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
$base_url = "http://localhost/Sample-dynamic-website/admin/";
$editor_base_url = "http://localhost/Sample-dynamic-website/editor/";