<?php
session_start();
require("../connect.php");
require('../../init.php');
$msg = "";
$device_type = getDeviceType();
$ip_address = getVisitorIP();
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
        if (isset($_POST['remember'])) {
            setcookie("emailid", $email, time() + 3600, "/", "", true, true);
            setcookie("passwordid", $_POST['Password'], time() + 60 * 60);
        }
        $query = "SELECT * FROM admin_login_info WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $admin = $result->fetch_assoc();
            if ($admin && password_verify($password, $admin['password'])) {
                $action = 'successfully logged in to admin page';
                logUserAction($ipAddress, $deviceType, $logFilePath, $action);
                $_SESSION['email'] = $admin['email'];
                $_SESSION['id'] = $admin['id'];
                $_SESSION['firstname'] = $admin['firstname'];
                $_SESSION['lastname'] = $admin['lastname'];
                $_SESSION['username'] = $admin['username'];
                $_SESSION['image'] = $admin['image'];
                $_SESSION['bio'] = $admin['bio'];
                $_SESSION['mobile'] = $admin['mobile'];
                $_SESSION['country'] = $admin['country'];
                $_SESSION['city'] = $admin['city'];
                $_SESSION['state'] = $admin['state'];
                $_SESSION['address'] = $admin['address1'];
                $_SESSION['addresstwo'] = $admin['address2'];
                $_SESSION['country_code'] = $admin['country_code'];
                $_SESSION['date_joined'] = $admin['date_joined'];
                $_SESSION['language'] = $admin['language'];
                $_SESSION['user'] = 'Admin';
                header("location: ../admin_homepage.php");
                exit();
            } else {
                $action = 'attempted login unsucessfully to admin page';
                logUserAction($ipAddress, $deviceType, $logFilePath, $action);
                $msg = "Invalid Password";
            }
        } else {
            $msg = "User not found";
        }
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
    <link rel="stylesheet" href="../admin.css" />
    <title>Admin Login</title>
</head>

<body>
    <section class="section1 flexcenter">
        <div class="container" id="signIn">
            <h1 class="form__title">Sign In</h1>
            <form method="post" class="form">
                <p class="error_div"><?php if (!empty($msg)) {
                                            echo $msg;
                                        } ?>
                </p>
                <div class="input_group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="Email" id="form_input" placeholder="Email" value="<?php echo $emailid; ?>" required />
                    <label for="Email">Email</label>
                </div>
                <div class="input_group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="Password" id="form_input" placeholder="Password" value="<?php echo $passwordid; ?>" required />
                    <label for="Password">Password</label>
                </div>
                <div class="checkbox_group">
                    <input type="checkbox" name="remember" id="remember_me" />
                    <p>Remember Me</p>
                </div>
                <p class="recover"><a href="forgotpassword.php">Forgot Password?</a></p>
                <input type="submit" value="Sign In" class="btn_main" name="Sign_In" id="loginBtn" />
            </form>
        </div>
    </section>
    <?php require("../extras/footer.php"); ?>
    <script src="../admin.js"></script>
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