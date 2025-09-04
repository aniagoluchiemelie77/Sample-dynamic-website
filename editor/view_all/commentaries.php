<?php
session_start();
$language = $language ?? 'en';
$translations = $translations ?? [];
$editor_base_url = $editor_base_url ?? '';
include("../connect.php");
require("../init.php");
require('../../init.php');
require("../../helpers/components.php");
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$translationFile = "../../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = []; // Initialize as empty array to avoid undefined variable errors
}
$posttype = 'Commentaries';
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
    <link rel="stylesheet" href="../../css/editor.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <script src="../../javascript/editor.js" defer></script>
    <title><?php echo $translations['view_commentaries']; ?></title>
</head>

<body>
    <?php
    require("../extras/header2.php");
    $userType = $_SESSION['user'] ?? 'Editor';
    $userFirstname = $_SESSION['firstname'];
    $post_type_dbname = "commentaries";
    $postTypeVal = 'id5';
    $delete_querytype = 'confirmDeleteC';
    $postTypeVal2 = 'post_id5';
    $favType = 'isfavourite5';
    renderPostTypePage($editor_base_url, $userFirstname, $userType, $post_type_dbname, $postTypeVal, $delete_querytype, $postTypeVal2, $favType);
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const allForms = document.querySelectorAll('.favouriteForm');

            allForms.forEach(function(form) {
                const starButton = form.querySelector('.star');
                const favInput = form.querySelector('input[name="isfavourite5"]');
                if (!starButton || !favInput) return;
                if (favInput.value === 'True') {
                    starButton.classList.add('favourite');
                } else {
                    starButton.classList.add('users_delete2');
                }

                starButton.addEventListener('click', function(event) {
                    const isFav = favInput.value === 'True';
                    favInput.value = isFav ? 'False' : 'True';

                    starButton.classList.toggle('favourite', !isFav);
                    starButton.classList.toggle('users_delete2', isFav);
                    Swal.fire({
                        toast: false,
                        icon: isFav ? 'info' : 'success',
                        title: isFav ? 'Removed from Favourites' : 'Added to Favourites',
                        text: isFav ?
                            'You just unmarked this post as favourite.' : 'This post is now marked as favourite.',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        iconColor: isFav ? '#f39c12' : '#2ecc71',
                        allowOutsideClick: false,
                        allowEscapeKey: true,
                        backdrop: true
                    });
                });
            });
        });
    </script>
    <script src="sweetalert2.all.min.js"></script>
    <script>
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
    </script>
</body>

</html>