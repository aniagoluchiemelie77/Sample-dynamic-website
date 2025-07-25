<?php
require("../connect.php");
require('../../init.php');
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
if (isset($_REQUEST['Sign_In'])) {
    $email = $_REQUEST['Email'];
    $password = $_REQUEST['Password'];
    if (isset($_REQUEST['remember'])) {
        setcookie("emailid", $_REQUEST['Email'], time() + 60 * 60);
        setcookie("passwordid", $_REQUEST['Password'], time() + 60 * 60);
    }
    $query = "SELECT * FROM editor WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $editor = $result->fetch_assoc();
    if (password_verify($password, $editor['password'])) {
        session_start();
        $_SESSION['email'] = $editor['email'];
        $_SESSION['id'] = $editor['id'];
        $_SESSION['firstname'] = $editor['firstname'];
        $_SESSION['lastname'] = $editor['lastname'];
        $_SESSION['username'] = $editor['username'];
        $_SESSION['image'] = $editor['image'];
        $_SESSION['bio'] = $editor['bio'];
        $_SESSION['mobile'] = $editor['mobile'];
        $_SESSION['country'] = $editor['country'];
        $_SESSION['city'] = $editor['city'];
        $_SESSION['state'] = $editor['state'];
        $_SESSION['address'] = $editor['address1'];
        $_SESSION['addresstwo'] = $editor['address2'];
        $_SESSION['country_code'] = $editor['country_code'];
        $_SESSION['date_joined'] = $editor['date_joined'];
        $_SESSION['language'] = $editor['language'];
        $_SESSION['user'] = 'Editor';
        header("location: ../editor_homepage.php");
        exit();
    } else {
        $msg = "Invalid Password";
    }
}

if (isset($_COOKIE['emailid']) && isset($_COOKIE['passwordid'])) {
    $emailid = $_COOKIE['emailid'];
    $passwordid = $_COOKIE['passwordid'];
} else {
    $emailid = $passwordid = " ";
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
    <title>Editor Login</title>
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
                <input type="submit" value="Sign In" class="btn_main" name="Sign_In" />
            </form>
        </div>
    </section>
    <?php require("../extras/footer.php"); ?>
    <script src="../editor.js"></script>
</body>

</html>