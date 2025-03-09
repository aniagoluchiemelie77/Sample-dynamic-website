<?php
session_start();
require("../connect.php");
include("../crudoperations.php");
require '../../vendor\phpmailer\phpmailer\src\SMTP.php';
require '../../vendor\phpmailer\phpmailer\src\Exception.php';
require '../../vendor\phpmailer\phpmailer\src\PHPMailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$msg = " ";
if (isset($_REQUEST['fgtpswd'])) {
    $email = $_REQUEST['email'];
    $_SESSION['email'] = $email;
    $check_email = mysqli_query($conn, "SELECT firstname, email FROM editor WHERE email = '$email'");
    $res = mysqli_num_rows($check_email);
    if ($res > 0) {
        $row = mysqli_fetch_assoc($check_email);
        $firstname = $row['firstname'];
        $token = rand(10000, 99999);
        $stmt = $conn->prepare("UPDATE editor SET token = ? WHERE email = ?");
        $stmt->bind_param('ss', $token, $email);
        if ($stmt->execute()) {
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
                $msg = "Password Reset OTP sent!";
                header("Location: verifyotp.php");
            } catch (Exception $e) {
                $msg = "OTP could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    } else {
        $msg = "Sorry, could't find user with specified email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="Tech News and Articles website" />
    <meta name="keywords" content="Tech News, Content Writers, Content Strategy" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu Diamaka" />
    <link rel="stylesheet" href="../editor.css" />
    <title>Forgot Password</title>
</head>

<body>
    <section class="section1 flexcenter">
        <div class="container" id="signIn">
            <form method="post" class="form" id="validate_form" action="forgotpassword.php">
                <h1>Enter Your Email</h1>
                <p class="error_div"><?php if (!empty($msg)) {
                                            echo $msg;
                                        } ?></p>
                <div class="input_group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="form_input" placeholder="Enter your email.." data-parsley-type="email" data-parsley-trigger="keyup" required />
                    <label for="email">Email</label>
                </div>
                <input type="submit" value="Send OTP" class="btn_main" name="fgtpswd" />
            </form>
        </div>
    </section>
    <?php require("../extras/footer.php"); ?>
    <script src="../editor.js"></script>
</body>

</html>