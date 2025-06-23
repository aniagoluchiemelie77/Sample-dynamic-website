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
$userId = $_SESSION['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_lng'])) {
    $language = $_POST['language'];
    $stmt = $conn->prepare("UPDATE admin_login_info SET language = ? WHERE id = ?");
    $stmt->bind_param("si", $language, $userId);
    if ($stmt->execute()) {
        $_SESSION['language'] = $language;
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Language changed successfully.";
    }
}
$stmt = $conn->prepare("SELECT language FROM admin_login_info WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
if ($result && $result->num_rows > 0) {
    $language = $result->fetch_assoc()['language'];
} else {
    $language = 'en'; // Default language fallback
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
    <title><?php echo $translations['change_language']; ?></title>
</head>

<body>
    <?php require("../extras/header3.php"); ?>
    <section class="newpost_body">
        <form method="POST" action="changelang.php" enctype="multipart/form-data" id="postForm" class="newpost_container">
            <div class="page_links">
                <a href="../admin_homepage.php"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['pages']; ?></p> > <p><?php echo $translations['change_language']; ?></p>
            </div>
            <div class="newpost_container_divnew newpost_subdiv">
                <div class='newpost_subdiv_subdiv2'>
                    <label class="form__label" for="language"><?php echo $translations['select_language']; ?>:</i></label>
                    <select name="language" id="language">
                        <option value="en" <?php if ($language === 'en') echo 'selected'; ?>>English</option>
                        <option value="fr" <?php if ($language === 'fr') echo 'selected'; ?>>French</option>
                        <option value="es" <?php if ($language === 'es') echo 'selected'; ?>>Spanish</option>
                        <option value="ger" <?php if ($language === 'ger') echo 'selected'; ?>>German</option>
                        <option value="arb" <?php if ($language === 'arb') echo 'selected'; ?>>Arabic</option>
                        <option value="mdn" <?php if ($language === 'mdn') echo 'selected'; ?>>Chinese</option>
                        <option value="rsn" <?php if ($language === 'rsn') echo 'selected'; ?>>Russian</option>
                    </select>
                </div>
                <input type="submit" class="btn" name="change_lng" value="<?php echo $translations['save']; ?>" id="submit" />
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