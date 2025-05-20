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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../editor.css" />
    <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['privacy_policy']; ?></title>
</head>

<body>
    <?php require("../extras/header2.php"); ?>
    <section class="about_section">
        <div class="page_links">
            <a href="../editor_homepage.php"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['pages']; ?></p> > <p><?php echo $translations['privacy_policy']; ?></p>
        </div>
        <div class="about_header">
            <h1><?php echo $translations['privacy_policy']; ?></h1>
        </div>
        <div class="about_contents">
            <?php
            $selectpage = "SELECT content FROM privacy_policy ORDER BY id DESC LIMIT 1";
            $selectpage_result = $conn->query($selectpage);
            if ($selectpage_result->num_rows > 0) {
                while ($row = $selectpage_result->fetch_assoc()) {
                    echo " <span>" . $row['content'] . "</span>";
                }
            }
            ?>
        </div>
    </section>
    <script src="../editor.js"></script>
</body>

</html>