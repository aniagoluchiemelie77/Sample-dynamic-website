<?php
session_start();
include("../connect.php");
include("../crudoperations.php");
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
$language = $_SESSION['language'] ?? 'en';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_lng'])) {
    $language = $_POST['language'];
    $userId = $_SESSION['id'];
    $stmt = $conn->prepare("UPDATE admin_login_info SET language = ? WHERE id = ?");
    $stmt->bind_param("si", $language, $userId);
    if($stmt->execute()){
        $_SESSION['language'] = $language;
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Language changed successfully.";
    }
}
$userId = $_SESSION['id']; 
$result = $conn->query("SELECT language FROM admin_login_info WHERE id = $userId");
$language = $result->fetch_assoc()['language'] ?? 'en';
$translationFile = "../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    die("Translation file not found!");
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu Diamaka" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../admin.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Change Language</title>
</head>

<body>
    <?php require("../extras/header2.php"); ?>
    <section class="newpost_body">
        <form method="POST" action="changelang.php" enctype="multipart/form-data" id="postForm" class="newpost_container">
            <div class="page_links">
                <a href="../admin_homepage.php">Home</a> > <p>Pages</p> > <p>Change Language</p>
            </div>
            <div class="newpost_container_divnew newpost_subdiv">
                <div class='newpost_subdiv_subdiv2'>
                    <label class="form__label" for="language">Select Language:</i></label>
                    <select name="language" id="language">
                        <option value="en" <?php if ($language === 'en') echo 'selected'; ?>>English</option>
                        <option value="fr" <?php if ($language === 'fr') echo 'selected'; ?>>French</option>
                        <option value="es" <?php if ($language === 'es') echo 'selected'; ?>>Spanish</option>
                        <!-- Add more languages as needed -->
                    </select>
                </div>
                <input type="submit" class="btn" name="change_lng">
            </div>
        </form>
    </section>
    <script src="sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="https://cdn.tiny.cloud/1/mshrla4r3p3tt6dmx5hu0qocnq1fowwxrzdjjuzh49djvu2p/tinymce/6/tinymce.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="../admin.js"></script>
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