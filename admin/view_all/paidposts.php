<?php
session_start();
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
    $translations = [];
}
$posttype = 'Paid Posts';
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
    <script src="../admin.js" async></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['view_paid_posts']; ?></title>
</head>

<body>
    <?php
    require("../extras/header2.php");
    $userType = $_SESSION['user'] ?? 'Admin';
    $post_type_dbname = "paid_posts";
    $postTypeVal = 'id1';
    $delete_querytype = 'confirmDeletePP2';
    $postTypeVal2 = 'post_id1';
    $favType = 'isfavourite1';
    renderPostTypePage($base_url, $userType, $post_type_dbname, $postTypeVal, $delete_querytype, $postTypeVal2, $favType);
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const allForms = document.querySelectorAll('.favouriteForm');

            allForms.forEach(function(form) {
                const starButton = form.querySelector('.star');
                const favInput = form.querySelector('input[name="isfavourite1"]');
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
    <script>
        const ToastMessage = Swal.mixin({
            toast: true,
            position: 'top-end',
            timer: 4000,
            timerProgressBar: true,
            showConfirmButton: false,
            iconColor: '#fff',
            customClass: {
                popup: 'rounded-xl shadow-xl text-white bg-zinc-800 border border-gray-600'
            },
            showClass: {
                popup: 'animate__animated animate__fadeInRight'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutRight'
            }
        });
        if (typeof messageType !== "undefined" && messageText.trim() !== "") {
            const iconColors = {
                'Error': '#e74c3c',
                'Success': '#2ecc71',
                'Info': '#3498db'
            };
            ToastMessage.fire({
                icon: messageType.toLowerCase(),
                title: messageText,
                iconColor: iconColors[messageType] || '#3498db'
            });
        }
        <?php unset($_SESSION['status_type']); ?>
        <?php unset($_SESSION['status']); ?>
    </script>
    <script>
        function submitSearch() {
            var query = document.getElementById("search-bar").value;
            if (query.trim() !== "") {
                fetch("paidposts.php?query=" + encodeURIComponent(query))
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById("search-results").innerHTML = data;
                        document.getElementById("search-results").style.display = "block";
                    })
                    .catch(error => console.error("Error fetching results:", error));
            } else {
                document.getElementById("search-results").style.display = "none";
            }
        }
    </script>
</body>

</html>