<?php
session_start();
include("../connect.php");
require("../init.php");
require('../../init.php');
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$translationFile = "../translation_files/lang/{$language}.php";
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
    if (empty($password1) || empty($password2) || empty($password3)) {
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
            $newPassword = md5($password3);
            $stmt = $conn->prepare("UPDATE admin_login_info SET password = ? WHERE email = ?");
            $stmt->bind_param('ss', $newPassword, $email);
            if ($stmt->execute()) {
                $content = "Admin " . $_SESSION['firstname'] . " changed password";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Password Updated Successfully";
            } else {
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
    $stmt->close();
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
    <link rel="stylesheet" href="../admin.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['change_password']; ?></title>
</head>

<body>
    <?php require("../extras/header3.php"); ?>
    <section class="newpost_body">
        <form class="newpost_container" method="post" action="changepassword.php" enctype="multipart/form-data" id="postForm">
            <div class="page_links">
                <a href="../admin_homepage.php"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['pages']; ?></p> > <p><?php echo $translations['change_password']; ?></p>
            </div>
            <div class="newpost_container_div1 newpost_subdiv">
                <h1><?php echo $translations['change_password']; ?></h1>
            </div>
            <div class="newpost_container_div3 newpost_subdiv">
                <label class="form__label" for="password1"><i class="fas fa-lock"></i></label>
                <div class="newpost_container_div3_subdiv2">
                    <input class="form__input" name="password1" type="password" placeholder="<?php echo $translations['change_password1']; ?>..." />
                </div>
            </div>
            <div class="newpost_container_div3 newpost_subdiv">
                <label class="form__label" for="password2"><i class="fas fa-lock"></i></label>
                <div class="newpost_container_div3_subdiv2">
                    <input class="form__input" name="password2" type="password" placeholder="<?php echo $translations['change_password2']; ?>..." />
                </div>
            </div>
            <div class="newpost_container_div3 newpost_subdiv">
                <label class="form__label" for="password3"><i class="fas fa-lock"></i></label>
                <div class="newpost_container_div3_subdiv2">
                    <input class="form__input" name="password3" type="password" placeholder="<?php echo $translations['change_password3']; ?>..." />
                </div>
            </div>
            <div class="newpost_container_div9 newpost_subdiv">
                <input class="form__submit_input" type="submit" value="<?php echo $translations['save']; ?>" name="change_pwd" />
            </div>
        </form>
    </section>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="../admin.js"></script>
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