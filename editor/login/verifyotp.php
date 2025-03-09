<?php
session_start();
require("../connect.php");
include("../crudoperations.php");
$email = $_SESSION['email'];
if (isset($_REQUEST['resend_otp'])) {
    header("Location: forgotpassword.php");
}
if (isset($_POST['validate_otp'])) {
    $otp = $_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'] . $_POST['otp5'];
    $query = "SELECT * FROM editor WHERE email='$email' AND token='$otp'";
    $result = mysqli_query($conn, $query);
    if ($result === false) {
        $msg = "Error: " . mysqli_error($conn);
    } elseif (mysqli_num_rows($result) > 0) {
        header("Location: changepassword.php");
        exit();
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
        <div class="container flexcenter" id="signIn">
            <form method="post" class="form otp_form" id="validate_otp" action="verifyotp.php">
                <h1>Enter 5 Digit OTP</h1>
                <!--<p class="error_div"><?php if (!empty($msg)) {
                                                echo $msg;
                                            } ?></p>-->
                <div class="input-field">
                    <input type="hidden" name="email" />
                    <input type="number" class="otp-input" maxlength="1" name="otp1" />
                    <input type="number" class="otp-input" maxlength="1" name="otp2" />
                    <input type="number" class="otp-input" maxlength="1" name="otp3" />
                    <input type="number" class="otp-input" maxlength="1" name="otp4" />
                    <input type="number" class="otp-input" maxlength="1" name="otp5" />
                </div>
                <p id="countdown" class="timer"></p>
                <button id="btn" class="verifyButton" name="validate_otp">Verify</button>
            </form>
        </div>
    </section>
    <?php require("../extras/footer.php"); ?>
    <script src="../editor.js"></script>
    <script>
        window.onload = function() {
            startCountdown();
            setupInputs();
        };
    </script>
</body>

</html>