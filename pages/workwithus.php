<?php
session_start();
require("../connect.php");
require('../init.php');
require("../helpers/components.php");
$page_name = "work-with-us";
$details = getFaviconAndLogo();
$details2 = cookieMessageAndVision();
$logo = $details['logo'];
$favicon = $details['favicon'];
$website_description = $details2['website_vision'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php
    if (isset($meta_titles[$page_name])) {
        $meta_data = $meta_titles[$page_name];
        for ($i = 1; $i <= 5; $i++) {
            $meta_name = $meta_data["meta_name$i"];
            $meta_content = $meta_data["meta_content$i"];
            if (!empty($meta_name) && !empty($meta_content)) {
                echo "<meta name='$meta_name' content='$meta_content' />";
            }
        }
    }
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="icon" href="../<?php echo $favicon; ?>" type="image/x-icon">
    <script src="../index.js" defer></script>
    <title>Work With Us</title>
</head>

<body>
    <?php
    require("../includes/header2b.php");
    $page_title = "Work With Us";
    $table_name = "work_with_us";
    renderPageFrontend($logo, $website_description, $page_title, $table_name);
    include("../includes/footer2.php");
    ?>
    <script>
        const sidebar = document.getElementById('sidebar');
        const menubtn = document.getElementById('searchicon');
        const closeMenuBtn = document.querySelector('.sidebarbtn');

        function onClickOutside(element) {
            document.addEventListener('click', e => {
                if (!element.contains(e.target)) {
                    element.classList.add('hidden');
                } else return;
            });
        };

        function removeHiddenClass(e) {
            e.stopPropagation();
            sidebar.classList.remove('hidden');
        };
        onClickOutside(sidebar);
        menubtn.addEventListener('click', removeHiddenClass);
        closeMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('hidden');
        });
    </script>
</body>

</html>