    <?php
    session_start();
    require('../connect.php');
    require('../init.php');
    require('../helpers/components.php');
    $_SESSION['status_type'] = "";
    $_SESSION['status'] = "";
    $page_name = "naija-latest";
    $details = getFaviconAndLogo();
    $logo = $details['logo'];
    $favicon = $details['favicon'];
    if (isset($_POST['submit_btn'])) {
        $email = $_POST["email"];
        $sendEmail = sendEmail($email);
        $_SESSION['status_type'] = $sendEmail['status_type'];
        $_SESSION['status'] = $sendEmail['status'];
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php if (isset($meta_titles[$page_name])) {
            $meta_data = $meta_titles[$page_name];
            for ($i = 1; $i <= 5; $i++) {
                $meta_name = $meta_data["meta_name$i"];
                $meta_content = $meta_data["meta_content$i"];
                if (!empty($meta_name) && !empty($meta_content)) {
                    echo "<meta name='$meta_name' content='$meta_content' />";
                }
            }
        } ?>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/main.css" />
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <script src="../javascript/main.js" defer></script>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="icon" href="../<?php echo $favicon; ?>" type="image/x-icon">
        <title>Naija Latest</title>
    </head>

    <body id="container">
        <?php
        $ucPageTitle = "Naija Latest";
        $lcPageTitle = "naijalatest";
        renderFrontendPage($ucPageTitle, $lcPageTitle);
        ?>
        <script>
            const closeMenuBtn = document.querySelector('.sidebarbtn');
            const sidebar = document.getElementById('sidebar');
            const menubtn = document.querySelector('.mainheader__header-nav-2');

            function removeHiddenClass(e) {
                e.stopPropagation();
                sidebar.classList.remove('hidden');
            };

            function onClickOutside(element) {
                document.addEventListener('click', e => {
                    if (!element.contains(e.target)) {
                        element.classList.add('hidden');
                    } else return;
                });
            };
            onClickOutside(sidebar);
            menubtn.addEventListener('click', removeHiddenClass);
            closeMenuBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                sidebar.classList.toggle('hidden');
            });
        </script>
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