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
    <link rel="stylesheet" href="../admin.css" />
    <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['work_with_us']; ?></title>
</head>

<body>
    <?php require("../extras/header2.php"); ?>
    <section class="about_section">
        <div class="page_links">
            <a href="../admin_homepage.php"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['pages']; ?></p> > <p><?php echo $translations['work_with_us']; ?></p>
        </div>
        <div class="about_header">
            <h1><?php echo $translations['work_with_us']; ?></h1>
        </div>
        <div class="about_contents">
            <?php
            $selectpage = "SELECT content FROM work_with_us ORDER BY id DESC LIMIT 1";
            $selectpage_result = $conn->query($selectpage);
            if ($selectpage_result->num_rows > 0) {
                while ($row = $selectpage_result->fetch_assoc()) {
                    echo " <span>" . $row['content'] . "</span>";
                }
            }
            ?>
        </div>
        <button class="about_section_btn" id="Edit_about6"><?php echo $translations['edit']; ?>
            <i class="fa fa-pencil" aria-hidden="true"></i>
        </button>
        <form class="about_editdiv" action="../forms.php" method="post" id="hidden_aboutdiv6">
            <textarea class="about_editdiv-input" name="work_withus" id="myTextarea10"></textarea>
            <input type="submit" value="<?php echo $translations['save']; ?>" name="workwithus_editbtn" />
        </form>
    </section>
    <script type="text/javascript" src="https://cdn.tiny.cloud/1/mshrla4r3p3tt6dmx5hu0qocnq1fowwxrzdjjuzh49djvu2p/tinymce/6/tinymce.min.js"></script>
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
    <script>
        const editAboutBtn6 = document.getElementById("Edit_about6");
        const editTextEditor6 = document.getElementById("hidden_aboutdiv6")
        editAction(editAboutBtn6, editTextEditor6);
    </script>
    <script src="sweetalert2.all.min.js"></script>
</body>

</html>