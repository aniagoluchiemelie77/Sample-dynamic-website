<?php
require("../connect.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com';
    $mail->SMTPDebug = 2;
    $mail->SMTPAuth = true;
    $mail->Username = 'aniagoluchiemelie77@gmail.com';
    $mail->Password = 'otxteulzfnelidgd';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('aniagoluchiemelie77@gmail.com', 'Aniagolu Chiemelie');
    $mail->addAddress('bahdmannatural@gmail.com');
    $mail->isHTML(true);
    $mail->Subject = 'Test Email';
    $mail->Body    = 'This is a test email.';
    $mail->send();
    echo 'Test email has been sent.';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
