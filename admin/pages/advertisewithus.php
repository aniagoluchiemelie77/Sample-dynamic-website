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
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title><?php echo $translations['advertise_with_us']; ?></title>
</head>

<body>
    <?php require("../extras/header3.php"); ?>
    <section class="about_section">
        <div class="page_links">
            <a href="../editor_homepage.php"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['pages']; ?></p> > <p><?php echo $translations['advertise_with_us']; ?></p>
        </div>
        <div class="about_header">
            <h1><?php echo $translations['advertise_with_us']; ?></h1>
        </div>
        <div class="about_contents">
            <?php
            $selectpage = "SELECT content FROM advertise_with_us ORDER BY id DESC LIMIT 1";
            $selectpage_result = $conn->query($selectpage);
            if ($selectpage_result->num_rows > 0) {
                while ($row = $selectpage_result->fetch_assoc()) {
                    echo " <span>" . $row['content'] . "</span>";
                }
            }
            ?>
        </div>
        <button class="about_section_btn" id="Edit_about2"><?php echo $translations['edit']; ?>
            <i class="fa fa-pencil" aria-hidden="true"></i>
        </button>
        <form class="about_editdiv" action="../forms.php" method="post" id="hidden_aboutdiv2">
            <textarea class="about_editdiv-input" name="advertise_content" id="myTextarea"></textarea>
            <input type="submit" value="<?php echo $translations['save']; ?>" name="advertedit_btn" />
        </form>
    </section>
    <script src="https://cdn.tiny.cloud/1/4x49ifq5jl99k0b9aot23a5ynnqfcr8jdlee7v6905rgmzql/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="../admin.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: '#myTextarea',
            setup: function(editor) {
                editor.on('init', function() {
                    editor.editorContainer.style.width = "90%";
                    editor.editorContainer.style.height = "50vh";
                });
            },
            resize: true,
            plugins: [
                'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
                'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
                'media', 'table', 'emoticons', 'help'
            ],
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
                'forecolor backcolor emoticons | help',
            menu: {
                favs: {
                    title: 'My Favorites',
                    items: 'code visualaid | searchreplace | emoticons'
                }
            },
            menubar: 'favs file edit view insert format tools table help',
            content_css: 'css/content.css'
        });
    </script>
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
    <script>
        const editAboutBtn2 = document.getElementById("Edit_about2");
        const editTextEditor2 = document.getElementById("hidden_aboutdiv2");
        editAction(editAboutBtn2, editTextEditor2);
    </script>
    <script src="sweetalert2.all.min.js"></script>
</body>

</html>