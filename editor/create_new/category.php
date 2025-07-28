<?php
session_start();
require("../connect.php");
require('../../init.php');
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$content = "";
require("../init.php");
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
    <meta name="description" content="Tech News and Articles website" />
    <meta name="keywords" content="Tech News, Content Writers, Content Strategy" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu Diamaka" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../editor.css" />
    <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['create_category']; ?></title>
</head>

<body>
    <?php require("../extras/header3.php"); ?>
    <section class="about_section">
        <div class="page_links">
            <a href="<?php echo $editor_base_url . 'editor_homepage.php'; ?>"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['pages']; ?></p> > <a href="../pages/categories.php"><?php echo $translations['categories']; ?></a> > <p><?php echo $translations['create_category']; ?></p>
        </div>
        <form class="formcontainer" id="topicForm" action="../../helpers/forms.php" method="POST" enctype="multipart/form-data">
            <div class="head_paragraph">
                <h3><?php echo $translations['create_category']; ?></h3>
            </div>
            <div class="formcontainer_subdiv">
                <div class="input_group">
                    <label for="name"><?php echo $translations['category_name']; ?>:</label>
                    <input type="text" name="topicName" id="topicName" />
                </div>
                <div class="newpost_container_div6 newpost_subdiv">
                    <label class="form__label" for="topicImg"><?php echo $translations['category_image']; ?>:</label>
                    <div class="newpost_subdiv2">
                        <input class="form__input" name="topicImg" type="file" />
                        <p class="newpost_subdiv2-p leftp"><span>*</span><?php echo $translations['message_title_i']; ?></p>
                    </div>
                </div>
            </div>
            <input class="formcontainer_submit" name='create_page' value="<?php echo $translations['save']; ?>" type="submit" />
        </form>
    </section>
    <script src="../editor.js"></script>
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