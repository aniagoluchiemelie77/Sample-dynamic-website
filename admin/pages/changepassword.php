<?php

/** @var \mysqli $conn */
global $conn;
$language = $language ?? 'en';
$translations = $translations ?? [];
$base_url = $base_url ?? '';
session_start();
include("../connect.php");
require("../init.php");
require('../../init.php');
require_once('../../helpers/components.php');
$device_type = getDeviceType();
$ip_address = getVisitorIP();
$logFilePath = '../../helpers/activites.txt';
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$translationFile = "../../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = [];
}
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
if (isset($_POST['change_pwd'])) {
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $password3 = $_POST['password3'];
    $email = $_SESSION['email'];
    if (empty($password1) && empty($password2) && empty($password3)) {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "All fields are required.";
        exit();
    }
    $query = "SELECT * FROM admin_login_info WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if ($password2 !== $password3) {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "New passwords do not match.";
            exit();
        }
        if (password_verify($password1, $admin['password'])) {
            $newPassword = password_hash($password3, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE admin_login_info SET password = ? WHERE email = ?");
            $stmt->bind_param('ss', $newPassword, $email);
            $firstname = $_SESSION['firstname'];
            if ($stmt->execute()) {
                $action = 'successfully changed his/her password';
                logUserAction($ipAddress, $deviceType, $logFilePath, $action, $firstname);
                $content = "Admin " . $firstname . " changed password";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Password Updated Successfully";
            } else {
                $action = 'attempted an unsuccessful password change';
                logUserAction($ipAddress, $deviceType, $logFilePath, $action, $firstname);
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error updating password. Please try again.";
            }
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Incorrect old password, Please try again.";
            exit();
        }
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Incorrect password, Please try again.";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../css/admin.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['change_password']; ?></title>
</head>

<body>
    <?php
    $usertype = $_SESSION['user'] ?? 'Admin';
    renderChangePasswordForm($base_url, $usertype);
    ?>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="../../javascript/admin.js"></script>
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