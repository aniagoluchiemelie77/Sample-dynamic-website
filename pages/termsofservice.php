<?php
session_start();
require("../connect.php");
require('../init.php');
$page_name = "terms-of-service";
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
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
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../index.css" />
    <script src="../index.js" defer></script>
    <link rel="icon" href="../<?php echo $favicon; ?>" type="image/x-icon">
    <title>Terms of Services</title>
</head>

<body>
    <?php require("../includes/header2b.php"); ?>
    <div class="body_container">
        <div class="body_right">
            <div class="sidebar_divs_container">
                <div class="webinfo">
                    <h1>Uniquecontentwriter</h1>
                    <img src="../images\image1.jpeg" alt="Blog's Coverphoto" />
                    <p>Here at Uniquecontentwriter.com, we give you the latest news and updates on Cybersecurity, Artificial Intelligence and lots more.</p>
                </div>
            </div>
        </div>
        <div class="body_left border-gradient-leftside--lightdark">
            <div class="page_links">
                <a href="../">Home</a> > <p>Terms of Service</p>
            </div>
            <h3 class="bodyleft_main">Our Terms of Service</h3>
            <div class="sidebar_divs_container thickdiv">
                <?php
                $selectpage = "SELECT content FROM terms_of_service ORDER BY id DESC LIMIT 1";
                $selectpage_result = $conn->query($selectpage);
                if ($selectpage_result->num_rows > 0) {
                    while ($row = $selectpage_result->fetch_assoc()) {
                        echo " <p>" . $row['content'] . "</p>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <?php include("../includes/footer2.php"); ?>
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