<?php

/** @var \mysqli $conn */
global $conn;
session_start();
$language = $language ?? 'en';
$translations = $translations ?? [];
$base_url = $base_url ?? '';
require("../connect.php");
require('../init.php');
require("init.php");
$device_type = getDeviceType();
$ip_address = getVisitorIP();
$logFilePath = '../helpers/activites.txt';
$attemptLogFile = '../helpers/login_attempts.log';
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
$id = $_SESSION['id'];
$firstName = $_SESSION['firstname'];
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$editor_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$editor_email = isset($_GET['email']) ? $_GET['email'] : null;
$translationFile = "../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = [];
}
if (isset($_POST['admin_personalaccess_to_editorpage'])) {
    $loginAllowed = isLoginAllowed($ip_address, $attemptLogFile);
    if (!$loginAllowed) {
        $action = "attempted too many unsuccessful logins to editor's page";
        logUserAction($ip_address, $device_type, $logFilePath, $action, $firstName);
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Too many login attempts. Please try again after a few minutes.";
        header('location: admin_homepage.php');
        exit();
    } else {
        $password = $_POST['password'];
        adminAccessToEditoPage($id, $password, $editor_id, $firstName);
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
    <link rel="icon" href="../<?php echo $favicon; ?>" type="image/x-icon">
    <link rel="stylesheet" href="../css/admin.css" />
    <script src="../javascript/admin.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title><?php echo $translations['editor_login_verify']; ?></title>
</head>

<body>
    <section class="section1 flexcenter">
        <div class="container" id="signIn">
            <form method="post" class="form" id="validate_form" action="../helpers/forms.php">
                <h1><?php echo $translations['editor_login_verify_header']; ?></h1>
                <div class="input_group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="form_input" placeholder="Password" data-parsley-type="password" data-parsley-trigger="keyup" required />
                    <label for="password"><?php echo $translations['password']; ?></label>
                </div>
                <input type="submit" id='loginBtn' value="<?php echo $translations['editor_login_verify_btn']; ?>" class="btn_main" name="admin_personalaccess_to_editorpage" />
            </form>
        </div>
    </section>
    <?php require("extras/footer.php"); ?>
    <script src="sweetalert2.all.min.js"></script>
    <script>
        const loginAllowed = <?php echo json_encode($loginAllowed); ?>;
        document.addEventListener("DOMContentLoaded", function() {
            const loginBtn = document.getElementById("loginBtn");
            if (!loginAllowed) {
                loginBtn.disabled = true;
                loginBtn.style.opacity = "0.5";
                loginBtn.style.cursor = "not-allowed";
            }
        });
    </script>

    <script>
        var messageType = "<?= $_SESSION['status_type'] ?>";
        var messageText = "<?= $_SESSION['status'] ?>";
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