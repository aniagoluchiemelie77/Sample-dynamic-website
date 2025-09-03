<?php
$language = $language ?? 'en';
$translations = $translations ?? [];
$base_url = $base_url ?? '';
session_start();
require("../connect.php");
require("../init.php");
require('../../init.php');
require('../../helpers/components.php');
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$_SESSION['logo_id'] = '';
$_SESSION['message_id'] = "";
$translationFile = "../../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = [];
}
$userFirstname = $_SESSION['firstname'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link id="themeStylesheet" rel="stylesheet" href="../../css/admin.css" />
    <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="../../javascript/admin.js" defer></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title><?php echo $translations['customise_frontend']; ?></title>
</head>

<body>
    <?php
    $usertype = $_SESSION['user'];
    renderEditFrontendFeaturespage($translations, $base_url, $usertype, $logo, $userFirstname);
    ?>
    <script>
        async function selectImage(inputType, recordId) {
            const {
                value: file
            } = await Swal.fire({
                title: "Select image",
                input: "file",
                inputAttributes: {
                    accept: "image/*",
                    "aria-label": "Upload your image"
                }
            });

            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    Swal.fire({
                        title: "Your uploaded Image",
                        imageUrl: e.target.result,
                        imageAlt: "The uploaded Image",
                        confirmButtonText: "Upload"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            uploadImage(file, inputType, recordId);
                        }
                    });
                };
                reader.readAsDataURL(file);
            }
        }

        function uploadImage(file, inputType, recordId) {
            let formData = new FormData();
            formData.append(inputType, file);
            formData.append("id", recordId);

            fetch("../../helpers/forms.php?id=" + encodeURIComponent(recordId), {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log("Server Response:", data);
                    Swal.fire("Success!", "Image uploaded successfully!", "success");
                })
                .catch(error => {
                    Swal.fire("Error!", "Image upload failed!", "error");
                });
        }
    </script>
    <script src="sweetalert2.all.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/4x49ifq5jl99k0b9aot23a5ynnqfcr8jdlee7v6905rgmzql/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            displayExit();
            displayExit2();
            cancelExit();
            cancelExit2();
            preventSubmitIfUnchanged('.div_special', 'textarea');
            preventSubmitIfUnchanged('.newpost_container', 'input');
        });
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
        tinymce.init({
            selector: "#myTextarea6b",
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
        tinymce.init({
            selector: "#myTextarea6c",
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