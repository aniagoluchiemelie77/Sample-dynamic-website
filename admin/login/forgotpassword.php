<?php
require("../connect.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';
if (isset($_REQUEST['fgtpswd'])){
    $email = $_REQUEST['email'];
    $check_email = mysqli_query($conn, "SELECT email FROM admin_login_info WHERE email = '$email'");
    $res = mysqli_num_rows($check_email);
    if ($res > 0){
        $message = "<div><p><br>Hello</br></p>
                    <p>You recieved this mail because we got a password reset request for your account.</p>
                    <br><p><button class='btn'><a href='http://localhost/Sample-dynamic-website/admin/login/resetpassword.php?secret='.base64_encode($email).''>Reset Password</a></button></p></br>
                    <p>If you did not request a password reset, no further action is required.</p>
                    </div>";
        $email = $email;
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;  
        $mail -> IsSMTP();
        $mail -> SMTPAuth = true;
        $mail -> SMTPSecure = "tls";
        $mail -> Host = "stmp.gmail.com";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 587;
        $mail -> Username = "aniagoluchiemelie77@gmail.com";
        $mail -> Password = "otxteulzfnelidgd";
        $mail -> FromName = "Uniquetechcontentwriter";
        $mail -> AddAddress ($email);
        $mail->addReplyTo('bahdmannatural@gmail.com', 'Information');
        $mail -> Subject = "Reset Password";
        $mail -> isHTML(TRUE);
        $mail -> Body = $message;
        if($mail->preSend()){
            $msg = "We have e-mailed your password reset link";
        }
    }else{
        $msg = "Sorry, couldn't find a user with specified email address.";
    };
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="Tech News and Articles website" />
    <meta name="keywords" content="Tech News, Content Writers, Content Strategy" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu Diamaka"/>
    <link rel="stylesheet" href="../admin.css"/>
	<title>Forgot Password</title>
</head>
<body>
    <section class="section1 flexcenter">
        <div class="container" id="signIn">
            <form method="post" class="form" id="validate_form" action="forgotpassword.php">
                <h1>Enter Your Email</h1>
                <p class="error_div"><?php if(!empty($msg)){ echo $msg;}?></p>
                <div class="input_group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="form_input" placeholder="Enter your email.." data-parsley-type="email" data-parsley-trigger="keyup" required/>
                    <label for="email">Email</label>
                </div>
                <input type="submit" value="Send Reset Link" class="btn_main" name="fgtpswd"/>
            </form>
        </div>
    </section>
    <?php require("../extras/footer.php");?>
    <script src="../index.js"></script>
</body>
</html>
