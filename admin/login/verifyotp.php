<?php
session_start();
require("../connect.php");
require('../../init.php');
require('../../helpers/components.php');
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$email = $_GET['email'] ?? '';
$msg = '';
if (isset($_GET['resend_otp']) && $_GET['resend_otp'] == 1 && isset($_GET['email'])) {
    $email = $_GET['email'];
    $stmt = $conn->prepare("SELECT firstname FROM admin_login_info WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $firstname = $user['firstname'];
        $token = rand(10000, 99999);
        $updateStmt = $conn->prepare("UPDATE admin_login_info SET token = ?, token_created_at = NOW() WHERE email = ?");
        $updateStmt->bind_param("ss", $token, $email);

        if ($updateStmt->execute()) {
            $sendOtp = sendOTP($email, $firstname, $token);
            $_SESSION['status_type'] = $sendOtp['status_type'];
            $_SESSION['status'] = "A new OTP has been sent to your email.";
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Failed to resend OTP.";
        }

        $updateStmt->close();
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Email not found.";
    }

    $stmt->close();
    header("Location: verifyotp.php?email=" . urlencode($email) . "&resent=1");
    exit();
}
$usertype = 'admin';
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
    <link rel="stylesheet" href="../../css/admin.css" />
    <script src="../../javascript/admin.js" defer></script>
    <title>Forgot Password</title>
</head>

<body>
    <?php
    renderOtpInputPage($email, $usertype);
    ?>
    <script>
        window.onload = function() {
            setupInputs();
            startCountdown(); // Always restart countdown on page load
        };
    </script>
</body>

</html>