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
    <link rel="stylesheet" href="../admin.css" />
    <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['create_writer']; ?></title>
</head>

<body>
    <?php require("../extras/header3.php"); ?>
    <section class="about_section">
        <div class="page_links">
            <a href="../admin_homepage.php"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['users']; ?></p> > <p> <?php echo $translations['create_writer']; ?></p>
        </div>
        <form class="formcontainer" id="topicForm" method="post" action="../forms.php" enctype="multipart/form-data">
            <div class="head_paragraph">
                <h3><?php echo $translations['create_writer']; ?></h3>
            </div>
            <div class="formcontainer_subdiv">
                <div class="input_group">
                    <label for="writer_firstname"><?php echo $translations['writers_firstname']; ?>:</label>
                    <input type="text" name="writer_firstname" id="topicName" />
                </div>
                <div class="input_group">
                    <label for="writer_lastname"><?php echo $translations['writers_lastname']; ?>:</label>
                    <input type="text" name="writer_lastname" id="topicName" />
                </div>
                <div class="input_group">
                    <label for="writer_email"><?php echo $translations['writers_email']; ?>:</label>
                    <input type="email" name="writer_email" id="topicName" />
                </div>
                <div class="newpost_container_div6 newpost_subdiv">
                    <label class="form__label" for="Img"><?php echo $translations['writers_image']; ?>:</label>
                    <div class="newpost_subdiv2">
                        <input class="form__input" name="Img" type="file" />
                    </div>
                </div>
            </div>
            <input class="formcontainer_submit" value="<?php echo $translations['save']; ?>" type="submit" name="create_writer" />
        </form>
    </section>
    <script src="../admin.js"></script>
    <script>
        const Toast = Swal.mixin({
            customClass: {
                popup: 'rounded-xl shadow-lg',
                title: 'text-lg font-semibold',
                confirmButton: 'bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700'
            },
            buttonsStyling: false,
            backdrop: `rgba(0,0,0,0.4)`,
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });

        if (messageType && messageText.trim() !== "") {
            let iconColors = {
                'Error': '#e74c3c',
                'Success': '#2ecc71',
                'Info': '#3498db'
            };

            Toast.fire({
                icon: messageType.toLowerCase(),
                title: messageText,
                iconColor: iconColors[messageType] || '#3498db',
                confirmButtonText: 'Got it'
            });
        }

        <?php unset($_SESSION['status_type']); ?>
        <?php unset($_SESSION['status']); ?>
    </script>
</body>

</html>