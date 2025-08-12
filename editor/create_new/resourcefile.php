<?php
session_start();
require("../connect.php");
require("../init.php");
require('../../init.php');
require("../../helpers/components.php");
$resource_type = isset($_GET['resource_type']) ? $_GET['resource_type'] : null;
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
    <link rel="stylesheet" href="../editor.css" />
    <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['create_new_resource_file']; ?></title>
</head>

<body>
    <?php
    require("../extras/header3.php");
    $usertype = $_SESSION['user'];
    renderCreateNewResourceFile($translations, $base_url, $usertype, $resource_type);
    ?>
    <script src="sweetalert2.all.min.js"></script>
    <script src="../editor.js"></script>
    <script>
        function preventSubmitIfEmpty(formSelector, inputSelector) {
            document.addEventListener("DOMContentLoaded", () => {
                const form = document.querySelector(formSelector);
                if (!form) return;

                const inputs = form.querySelectorAll(inputSelector);
                const originalValues = Array.from(inputs).map((input) =>
                    input.value.trim()
                );

                form.addEventListener("submit", (e) => {
                    let hasChanged = false;
                    inputs.forEach((input, index) => {
                        if (input.type === "file") {
                            if (input.files.length > 0) {
                                hasChanged = true;
                            }
                        } else if (input.value.trim() !== originalValues[index]) {
                            hasChanged = true;
                        }
                    });

                    if (!hasChanged) {
                        e.preventDefault();
                        Swal.fire({
                            title: "Empty Form",
                            text: "Cannot submit an empty form.",
                            icon: "info",
                            confirmButtonText: "Ok",
                        });
                    }
                });
            });
        }
        preventSubmitIfEmpty('.formcontainer', 'input, textarea');
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