<?php
session_start();
require("../connect.php");
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
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu Diamaka" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../index.css" />
    <link id="themeStylesheet" rel="stylesheet" href="../admin.css" />
    <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['customise_frontend']; ?></title>
</head>

<body>
    <?php require("../extras/header2.php"); ?>
    <section class="sectioneer">
        <div class='pages_container'>
            <div class="page_links">
                <a href="../admin_homepage.php"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['settings']; ?></p> > <p><?php echo $translations['customise_frontend']; ?></p>
            </div>
            <h1><?php echo $translations['actions']; ?></h1>
            <div class="pages_container_subdiv theme-switcher" id="theme-icon">
                <i class="fa fa-moon night-icon" aria-hidden="true" id="theme-icon1"></i>
                <i class="fa fa-sun day-icon" aria-hidden="true" id="theme-icon2"></i>
                <a class='pages_container_subdiv-links' href="#">
                    <p id="paragraph"><?php echo $translations['change_theme']; ?></p>
                </a>
            </div>
            <div class="pages_container_subdiv">
                <a class='pages_container_subdiv-links' href="../edit/frontend_features.php">
                    <p><?php echo $translations['customise_frontend_p']; ?></p>
                </a>
            </div>
        </div>
    </section>
    <script src="../../index.js"></script>
</body>

</html>