<?php
session_start();
require("../connect.php");
require('../../init.php');
require('../../helpers/components.php');
$logFilePath = '../../helpers/activites.txt';
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
$email = $_SESSION['verified_email'];
$firstname = $_SESSION['firstname'];
$usertype = 'editor';
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
    <link rel="stylesheet" href="../../css/editor.css" />
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <script src="../../javascript/editor.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Forgot Password</title>
</head>

<body>
    <?php
    renderChangePasswordLoginPage($usertype, $email, $firstname);
    ?>
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
        <?php unset($_SESSION['firstname']); ?>
        <?php unset($_SESSION['verified_email']); ?>
    </script>
</body>

</html>