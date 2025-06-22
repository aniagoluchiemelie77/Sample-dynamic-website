<?php
session_start();
require("../connect.php");
require('../../init.php');
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
if (isset($_POST['fgtpswd'])) {
    $email = $_POST['email'];
    $check_email = mysqli_query($conn, "SELECT firstname, email FROM admin_login_info WHERE email = '$email'");
    $res = mysqli_num_rows($check_email);
    if ($res > 0) {
        $row = mysqli_fetch_assoc($check_email);
        $firstname = $row['firstname'];
        $token = rand(10000, 99999);
        $stmt = $conn->prepare("UPDATE admin_login_info SET token = ? WHERE email = ?");
        $stmt->bind_param('ss', $token, $email);
        if ($stmt->execute()) {
            $sendOtp = sendOTP($email, $firstname, $token);
            $_SESSION['status_type'] = $sendOtp['status_type'];
            $_SESSION['status'] = $sendOtp['status'];
        }
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Sorry, could't find user with specified email.";
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
    <link rel="stylesheet" href="../admin.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Forgot Password</title>
</head>

<body>
    <section class="section1 flexcenter">
        <div class="container" id="signIn">
            <form method="post" class="form" id="validate_form" action="forgotpassword.php">
                <h1>Enter Your Email</h1>
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
    <script src="../index.js"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script>
        var messageType = "<?= $_SESSION['status_type'] ?? ' ' ?>";
        var messageText = "<?= $_SESSION['status'] ?? ' ' ?>";
        if (messageType == 'Error' && messageText != " ") {
            Swal.fire({
                title: 'Error!',
                text: messageText,
                icon: 'error',
                confirmButtonText: 'Ok'
            })
        } else if (messageType == 'Success' && messageText != " ") {
            Swal.fire({
                title: 'Success',
                text: messageText,
                icon: 'success',
                confirmButtonText: 'Ok'
            })
        }
        <?php unset($_SESSION['status_type']); ?>
        <?php unset($_SESSION['status']); ?>
    </script>
</body>

</html>