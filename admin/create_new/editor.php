<?php
session_start();
require("../connect.php");
require("../init.php");
require('../../init.php');
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$translationFile = "../../translation_files/lang/{$language}.php";
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
    <link rel="stylesheet" href="../admin.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['create_editor']; ?></title>
</head>

<body>
    <?php require("../extras/header3.php"); ?>
    <section class="about_section">
        <div class="page_links">
            <a href="<?php echo $base_url . 'admin_homepage.php'; ?>"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['users']; ?></p> > <p> <?php echo $translations['change_language']; ?></p>
        </div>
        <form class="formcontainer" id="topicForm" method="post" action="../../helpers/forms.php" enctype="multipart/form-data">
            <div class="head_paragraph">
                <h3><?php echo $translations['create_editor']; ?></h3>
            </div>
            <div class="formcontainer_subdiv">
                <div class="input_group">
                    <label for="editor_firstname"><?php echo $translations['editors_firstname']; ?>:</label>
                    <input type="text" name="editor_firstname" id="topicName" />
                </div>
                <div class="input_group">
                    <label for="editor_lastname"><?php echo $translations['editors_lastname']; ?>:</label>
                    <input type="text" name="editor_lastname" id="topicName" />
                </div>
                <div class="input_group">
                    <label for="editor_email"><?php echo $translations['editors_email']; ?>:</label>
                    <input type="email" name="editor_email" id="topicName" />
                </div>
                <div class="newpost_container_div6 newpost_subdiv">
                    <label class="form__label" for="Img"><?php echo $translations['editors_image']; ?>:</label>
                    <div class="newpost_subdiv2">
                        <input class="form__input" name="Img" type="file" />
                    </div>
                </div>
                <div class="input_group">
                    <label for="editor_password"><?php echo $translations['editors_password']; ?>:</label>
                    <input type="password" name="editor_password" id="topicName" />
                </div>
                <div class="input_group">
                    <label for="editor_password-confirm"><?php echo $translations['confirm_editors_password']; ?>:</label>
                    <input type="password" name="editor_password-confirm" id="topicName" />
                </div>
            </div>
            <input class="formcontainer_submit" value="<?php echo $translations['save']; ?>" type="submit" name="create_editor" />
        </form>
    </section>
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