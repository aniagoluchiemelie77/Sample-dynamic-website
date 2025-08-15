<?php
session_start();
include("../connect.php");
require("../init.php");
require('../../init.php');
require('../../helpers/components.php');
$details = getFaviconAndLogo();
$translationFile = "../../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = []; // Initialize as empty array to avoid undefined variable errors
}
$logo = $details['logo'];
$favicon = $details['favicon'];
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
$userId = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../admin.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['meta_titles_management']; ?></title>
</head>

<body>
    <?php
    $usertype = $_SESSION['user'] ?? 'Admin';
    renderMetaTitlesManagementForm($base_url, $usertype);
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <script>
        $(document).ready(function() {
            $(".viewMeta").click(function() {
                var pageId = $(this).data("id");
                $.ajax({
                    url: "fetch_meta.php",
                    type: "POST",
                    data: {
                        page_id: pageId
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            let queryString = `../edit/editmetatitles.php?page_name=${encodeURIComponent(data.page_name)}`;

                            for (let i = 1; i <= 5; i++) {
                                queryString += `&meta_name${i}=${encodeURIComponent(data["meta_name" + i])}`;
                                queryString += `&meta_content${i}=${encodeURIComponent(data["meta_content" + i])}`;
                            }
                            window.location.href = queryString;
                        } else {
                            alert("No metadata found.");
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>