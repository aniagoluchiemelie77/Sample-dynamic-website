<?php
require('connect.php');
require('admin/crudoperations.php');
require 'vendor\phpmailer\phpmailer\src\SMTP.php';
require 'vendor\phpmailer\phpmailer\src\Exception.php';
require 'vendor\phpmailer\phpmailer\src\PHPMailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$thankYouMessage = "";
$msg = "";
if (isset($_POST['submit_btn'])) {
    $email = $_POST["email"];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $date = date("Y-m-d");
        $time = date("H:i:s");
        $checkStmt = $conn->prepare("SELECT * FROM subscribers WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        if ($result->num_rows > 0) {
            $msg = "You are already subscribed with us!";
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
                    $thankYouMessage = "Thank You For Subscribing With Us!";
                } catch (Exception $e) {
                    $thankYouMessage = "Subscription successful, but the welcome email could not be sent.";
                }
            } else {
                $msg = "Error: " . $stmt->error;
            }
        }
    } else {
        $msg = "Invalid email address. Please try again.";
    }
}
?>
<div class="subscribe_container">
    <form class="sec2__susbribe-box other_width" method="POST" action="index.php" id="susbribe-box">
        <div class="icon">
            <i class="fa fa-envelope" aria-hidden="true"></i>
        </div>
        <h1 class="sec2__susbribe-box-header">Subscribe to Updates</h1>
        <p class="sec2__susbribe-box-p1">Get the latest Updates and Info from Uniquetechcontentwriter on Cybersecurity, Artificial Intelligence and lots more.</p>
        <p class="error_div" id="error_message"><?php if (!empty($msg)) {
                                                    echo $msg;
                                                } ?></p>
        <input class="sec2__susbribe-box_input" type="text" placeholder="Your Email Address..." name="email" required />
        <input class="sec2__susbribe-box_btn" type="submit" value="Submit" name="submit_btn" onclick="submitPost()" />
    </form>
    <div id="thank-you-message"></div>
</div>