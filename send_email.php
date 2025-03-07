<?php
    require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
	//Server settings
	$mail->isSMTP();
	$mail->Host       = 'smtp.mailgun.org';
	$mail->SMTPAuth   = true;
	$mail->Username   = 'chiboy@sandbox67de3d64b109403fba5332138900366d.mailgun.org'; // Replace with your Mailgun SMTP username
	$mail->Password   = 'fc2f872a41f1365cc4005d8255348530-e298dd8e-f63dda9f';
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
	$mail->Port       = 587;

	//Recipients
	$mail->setFrom('chiboy@sandbox67de3d64b109403fba5332138900366d.mailgun.org', 'Aniagolu');
	$mail->addAddress('chiboyaniagolu3@gmail.com', 'Aniagolu Chiemelie');

	//Content
	$mail->isHTML(true);
	$mail->Subject = 'Test Email';
	$mail->Body    = 'This is a test email sent using Mailgun SMTP.';

	$mail->send();
	echo 'Message has been sent';
} catch (Exception $e) {
	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>