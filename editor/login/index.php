<?php
session_start();
require("../connect.php");
require('../../init.php');
require('../../helpers/components.php');
$msg = '';
$emailid = '';
$passwordid = '';
$logFilePath = '../../helpers/activites.txt';
$attemptLogFile = '../../helpers/login_attempts.log';
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
if (!isLoginAllowed($ip_address, $attemptLogFile)) {
    $msg = "Too many login attempts. Please try again after a few minutes.";
} else {
    if (isset($_POST['Sign_In'])) {
        $email = trim($_POST['Email']);
        $password = trim($_POST['Password']);
        $usertype = 'editor';
        $userDbName = 'editor';
        userLogIn($usertype, $userDbName);
    }
    if (isset($_COOKIE['emailid']) && isset($_COOKIE['passwordid'])) {
        $emailid = $_COOKIE['emailid'];
        $passwordid = $_COOKIE['passwordid'];
    } else {
        $emailid = $passwordid = " ";
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
    <link rel="stylesheet" href="../../css/editor.css" />
    <title>Editor Login</title>
</head>

<body>
    <?php
    renderSignInPage($msg, $emailid, $passwordid);
    ?>
    <script src="../../javascript/editor.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const errorDiv = document.querySelector(".error_div");
            const loginBtn = document.getElementById("loginBtn");
            if (errorDiv && errorDiv.textContent.includes("Too many login attempts")) {
                loginBtn.disabled = true;
                loginBtn.style.opacity = "0.5";
                loginBtn.style.cursor = "not-allowed";
            }
        });
    </script>
</body>

</html>