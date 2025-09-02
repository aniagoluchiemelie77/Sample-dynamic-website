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
if (isset($_POST['fgtpswd'])) {
    $password = $_POST['password'];
    $check_password_sql = "SELECT password FROM admin_login_info WHERE id = ?";
    $stmt = $conn->prepare($check_password_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
        if (password_verify($password, $hashed_password)) {
            $editor_sql = "SELECT * FROM editor WHERE id = ?";
            $stmt = $conn->prepare($editor_sql);
            $stmt->bind_param("i", $editor_id);
            $stmt->execute();
            $editor_result = $stmt->get_result();
            if ($editor_result->num_rows > 0) {
                $action = "successfully logged in to editor's page";
                logUserAction($ipAddress, $deviceType, $logFilePath, $action, $firstName);
                $editor_row = $editor_result->fetch_assoc();
                $_SESSION['email'] = $editor_row['email'];
                $_SESSION['id'] = $editor_row['id'];
                $_SESSION['firstname'] = $editor_row['firstname'];
                $_SESSION['lastname'] = $editor_row['lastname'];
                $_SESSION['username'] = $editor_row['username'];
                $_SESSION['image'] = $editor_row['image'];
                $_SESSION['bio'] = $editor_row['bio'];
                $_SESSION['mobile'] = $editor_row['mobile'];
                $_SESSION['country'] = $editor_row['country'];
                $_SESSION['city'] = $editor_row['city'];
                $_SESSION['state'] = $editor_row['state'];
                $_SESSION['address'] = $editor_row['address1'];
                $_SESSION['addresstwo'] = $editor_row['address2'];
                $_SESSION['country_code'] = $editor_row['country_code'];
                $_SESSION['date_joined'] = $editor_row['date_joined'];
                $_SESSION['language'] = $editor_row['language'];
                header("location: ../editor/editor_homepage.php");
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "No editor found with this ID!";
            }
        } else {
            $action = "attempted an unsuccessful login to editor's page";
            logUserAction($ipAddress, $deviceType, $logFilePath, $action, $firstName);
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Incorrect password. Please try again.";
            header('location: admin_homepage.php');
            exit();
        }
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Admin not found..";
        header('location: login/index.php');
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="icon" href="../<?php echo $favicon; ?>" type="image/x-icon">
    <link rel="stylesheet" href="../css/admin.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title><?php echo $translations['editor_login_verify']; ?></title>
</head>

<body>
    <section class="section1 flexcenter">
        <div class="container" id="signIn">
            <form method="post" class="form" id="validate_form" action=" ">
                <h1><?php echo $translations['editor_login_verify_header']; ?></h1>
                <div class="input_group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="form_input" placeholder="Password" data-parsley-type="password" data-parsley-trigger="keyup" required />
                    <label for="password"><?php echo $translations['password']; ?></label>
                </div>
                <input type="submit" value="<?php echo $translations['editor_login_verify_btn']; ?>" class="btn_main" name="fgtpswd" />
            </form>
        </div>
    </section>
    <?php require("extras/footer.php"); ?>
    <script src="index.js"></script>
    <script src="sweetalert2.all.min.js"></script>
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