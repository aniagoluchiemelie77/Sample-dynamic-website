<?php
require("connect.php");
require('admin/crudoperations.php');
require('vendor\phpmailer\phpmailer\src\SMTP.php');
require('vendor\phpmailer\phpmailer\src\Exception.php');
require('vendor\phpmailer\phpmailer\src\PHPMailer.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
                    $mail->Body    = 'Thank you for subscribing to our newsletter! We are excited to have you with us.';
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
        $mail->SMTPDebug = 2;
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
?>