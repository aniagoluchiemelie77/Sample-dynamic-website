<?php
session_start();
require("../connect.php");
require('../../init.php');

$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];

$email = $_GET['email'] ?? '';

$msg = '';
if (isset($_POST['validate_otp'])) {
    $secretKey = "6Ld33JwrAAAAALMCOvNYJ8T9Y-m2-XhWp19wAx5V";
    $captchaResponse = $_POST['g-recaptcha-response'];

    // Send request to Google
    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captchaResponse");
    $responseData = json_decode($verify);

    // Check if CAPTCHA was successful
    if (!$responseData->success) {
        die("CAPTCHA verification failed. Please try again.");
    }
    $email = $_POST['validate_otp_email'] ?? '';
    $otp = ($_POST['otp1'] ?? '') . ($_POST['otp2'] ?? '') . ($_POST['otp3'] ?? '') . ($_POST['otp4'] ?? '') . ($_POST['otp5'] ?? '');

    if (strlen($otp) !== 5 || !ctype_digit($otp)) {
        $msg = "Invalid OTP format.";
    } else {
        // Prepared statement with expiry check
        $stmt = $conn->prepare("
            SELECT * FROM editor 
            WHERE email = ? 
              AND token = ? 
              AND token_created_at > NOW() - INTERVAL 1 MINUTE
        ");
        $stmt->bind_param("ss", $email, $otp);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            $msg = "Error: " . $conn->error;
        } elseif ($result->num_rows > 0) {
            $_SESSION['otp_verified'] = true;
            $_SESSION['verified_email'] = $email;
            // Clear token and timestamp
            $clearStmt = $conn->prepare("UPDATE editor SET token = NULL, token_created_at = NULL WHERE email = ?");
            $clearStmt->bind_param("s", $email);
            $clearStmt->execute();
            $clearStmt->close();

            header("Location: changepassword.php");
            exit();
        } else {
            $msg = "OTP expired or invalid. Please request a new one.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <link rel="stylesheet" href="../editor.css" />
    <title>Forgot Password</title>
</head>

<body>
    <section class="section1 flexcenter">
        <div class="container flexcenter" id="signIn">
            <form method="post" class="form otp_form" id="validate_otp" action="verifyotp.php">
                <div class="g-recaptcha" data-sitekey="6Ld33JwrAAAAAL5VxabGf2jrgr0zD2m0lJ9pO9n4"></div>
                <h1>Enter OTP</h1>
                <p class="error_div"><?php echo htmlspecialchars($msg); ?></p>

                <div class="input-field">
                    <input type="number" class="otp-input" maxlength="1" name="otp1" required />
                    <input type="number" class="otp-input" maxlength="1" name="otp2" required />
                    <input type="number" class="otp-input" maxlength="1" name="otp3" required />
                    <input type="number" class="otp-input" maxlength="1" name="otp4" required />
                    <input type="number" class="otp-input" maxlength="1" name="otp5" required />
                </div>

                <input type="hidden" value="<?php echo htmlspecialchars($email); ?>" name="validate_otp_email" />
                <p id="countdown" class="timer"></p>
                <button id="btn" class="verifyButton" name="validate_otp">Verify</button>
            </form>

        </div>
    </section>
    <?php require("../extras/footer.php"); ?>
    <script src="../editor.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        window.onload = function() {
            startCountdown();
            setupInputs();
        };
    </script>
</body>

</html>