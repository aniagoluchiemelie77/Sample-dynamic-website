<?php
session_start();
include("../connect.php");
require('../../init.php');
require("../init.php");
require('../../helpers/components.php');
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$usertype = isset($_GET['usertype']) ? $_GET['usertype'] : null;
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
    <link rel="stylesheet" href="../../css/admin.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['edit_user']; ?></title>
</head>

<body>
    <?php
    renderEditUserProfileForm($usertype, $id, $translations, $logo);
    ?>
    <script src="https://cdn.tiny.cloud/1/4x49ifq5jl99k0b9aot23a5ynnqfcr8jdlee7v6905rgmzql/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="../../javascript/admin.js"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            preventSubmitIfUnchanged('.create_editor_container', 'input[type="text"], input[type="file"], input[type="email"], input[type="number"], textarea');
        });
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
        tinymce.init({
            selector: "#myTextarea5",
            resize: true,
            setup: function(editor) {
                editor.on("init", function() {
                    editor.editorContainer.style.width = "90%";
                    editor.editorContainer.style.height = "50vh";
                });
            },
            plugins: [
                "advlist",
                "autolink",
                "link",
                "image",
                "lists",
                "charmap",
                "preview",
                "anchor",
                "pagebreak",
                "searchreplace",
                "wordcount",
                "visualblocks",
                "visualchars",
                "code",
                "fullscreen",
                "insertdatetime",
                "media",
                "table",
                "emoticons",
                "help",
            ],
            toolbar: "undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | " +
                "bullist numlist outdent indent | link image | print preview media fullscreen | " +
                "forecolor backcolor emoticons | help",
            menu: {
                favs: {
                    title: "My Favorites",
                    items: "code visualaid | searchreplace | emoticons",
                },
            },
            menubar: "favs file edit view insert format tools table help",
            content_css: "css/content.css",
        });
        window.addEventListener("resize", function() {
            if (tinymce.activeEditor) {
                let newWidth = window.innerWidth * 0.8;
                let newHeight = window.innerHeight * 0.7;
                tinymce.activeEditor.editorContainer.style.width = newWidth + "px";
                tinymce.activeEditor.editorContainer.style.height = newHeight + "px";
            }
        });
    </script>
</body>

</html>