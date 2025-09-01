<?php
session_start();
$page_name = isset($_GET['page_name']) ? $_GET['page_name'] : "Unknown Page";
include("../connect.php");
require("../init.php");
require('../../init.php');
require('../../helpers/components.php');
if (isset($_POST['edit_metatitle'])) {
    $meta_name1 = $_POST['meta_name1'];
    $meta_name2 = $_POST['meta_name2'];
    $meta_name3 = $_POST['meta_name3'];
    $meta_name4 = $_POST['meta_name4'];
    $meta_name5 = $_POST['meta_name5'];
    $meta_content1 = $_POST['meta_content1'];
    $meta_content2 = $_POST['meta_content2'];
    $meta_content3 = $_POST['meta_content3'];
    $meta_content4 = $_POST['meta_content4'];
    $meta_content5 = $_POST['meta_content5'];
    $usertype = $_SESSION['user'] ?? 'Editor'; // Default to Admin if not set
    updateMetatitle($meta_name1, $meta_name2, $meta_name3, $meta_name4, $meta_name5, $meta_content1, $meta_content2, $meta_content3, $meta_content4, $meta_content5, $page_name, $usertype);
}
$orginalPageName = $page_name; // Store the original page name for later use
$page_name = removeHyphenUc($page_name);
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$translationFile = "../../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = []; // Initialize as empty array to avoid undefined variable errors
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../css/editor.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['edit_metatitles']; ?></title>
</head>

<body>
    <?php
    require("../extras/header2.php");
    renderEditMetatitlesForm($translations, $page_name);
    ?>
    <script src="../../javascript/editor.js"></script>
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