<?php
session_start();
require("../connect.php");
require('../init.php');
require_once '../helpers/components.php';
$page_name = "view-post";
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
require_once '../vendor/ezyang\htmlpurifier/library/HTMLPurifier.auto.php';
$post_id = isset($_GET['id1']) ? intval($_GET['id1']) : 0;
$post_id2 = isset($_GET['id2']) ? intval($_GET['id2']) : 0;
$post_id3 = isset($_GET['id3']) ? intval($_GET['id3']) : 0;
$post_id4 = isset($_GET['id4']) ? intval($_GET['id4']) : 0;
$post_id5 = isset($_GET['id5']) ? intval($_GET['id5']) : 0;
$url = "http://localhost/Sample-dynamic-website";
$title1 = "";
$subtitle1 = "";
$img1 = "";
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
if (isset($_POST['submit_btn'])) {
    $email = $_POST["email"];
    $sendEmail = sendEmail($email);
    $_SESSION['status_type'] = $sendEmail['status_type'];
    $_SESSION['status'] = $sendEmail['status'];
}
if (isset($_POST['subscribe_btn2'])) {
    $email = $_POST["email"];
    $sendEmail = sendEmail($email);
    $_SESSION['status_type'] = $sendEmail['status_type'];
    $_SESSION['status'] = $sendEmail['status'];
}
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../index.css" />
    <script src="../index.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../<?php echo $favicon; ?>" type="image/x-icon">
    <title>View post</title>
</head>

<body>
    <?php require("../includes/header2.php"); ?>
    <div class="body_container">
        <div class="body_left">
            <div class="page_links">
                <a href="../">Home</a> > <p>View Post</p>
            </div>
            <?php
            $getniche_sql = " SELECT name FROM topics ORDER BY id";
            $getniche_result = $conn->query($getniche_sql);
            if ($getniche_result->num_rows > 0) {
                echo "<div class='body_left_relatedniches'>";
                while ($row = $getniche_result->fetch_assoc()) {
                    $category_name = $row['name'];
                    $cleanString = removeHyphen($category_name);
                    $readableString = convertToReadable($category_name);
                    echo "<a href='$cleanString.php'>$readableString</a>";
                }
                echo "</div>";
            }
            if ($post_id > 0) {
                $tablename = 'paid_posts';
                $postIdVal = 'id1';
                renderViewPost($tablename, $post_id, $url, $postIdVal);
            }
            if ($post_id2 > 0) {
                $tablename = 'posts';
                $postIdVal = 'id2';
                renderViewPost($tablename, $post_id2, $url, $postIdVal);
            }
            if ($post_id3 > 0) {
                $tablename = 'news';
                $postIdVal = 'id3';
                renderViewPost($tablename, $post_id3, $url, $postIdVal);
            }
            if ($post_id4 > 0) {
                $tablename = 'commentaries';
                $postIdVal = 'id4';
                renderViewPost($tablename, $post_id4, $url, $postIdVal);
            }
            if ($post_id5 > 0) {
                $tablename = 'press_releases';
                $postIdVal = 'id5';
                renderViewPost($tablename, $post_id5, $url, $postIdVal);
            }
            ?>
        </div>
        <div class="body_right border-gradient-leftside--lightdark">
            <div class="subscribe_container">
                <form class="sec2__susbribe-box other_width" method="POST" action="" id="susbribe-box">
                    <div class="icon">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </div>
                    <h1 class="sec2__susbribe-box-header">Subscribe to Updates</h1>
                    <p class="sec2__susbribe-box-p1">Get the latest Updates and Info from Uniquetechcontentwriter on Cybersecurity, Artificial Intelligence and lots more.</p>
                    <input class="sec2__susbribe-box_input" type="text" placeholder="Your Email Address..." name="email" required />
                    <input class="sec2__susbribe-box_btn" type="submit" value="Submit" name="submit_btn" />
                </form>
                <div id="thank-you-message"></div>
            </div>
            <h3 class="bodyleft_header3 border-gradient-bottom--lightdark">Editor's Picks</h3>
            <?php include("../helpers/editorspicks.php"); ?>
        </div>
    </div>
    <?php include("../includes/footer2.php"); ?>
    <script>
        const closeMenuBtn = document.querySelector('.sidebarbtn');
        const sidebar = document.getElementById('sidebar');
        const menubtn = document.querySelector('.mainheader__header-nav-2');
        document.addEventListener("DOMContentLoaded", function() {
            const scrollContainer = document.querySelector(".more_posts");
            setTimeout(() => {
                scrollContainer.scrollBy({
                    left: 300,
                    behavior: 'smooth'
                });
            }, 1000);
        });

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

        function shareFunction() {
            const postTitle = "<?php echo addslashes($title1); ?>";
            const postSubtitle = "<?php echo addslashes($subtitle1); ?>";
            const postImage = "<?php echo addslashes($img1); ?>";
            const postUrl = window.location.href;
            const tweetUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(postTitle + ' - ' + postSubtitle)}&url=${encodeURIComponent(postUrl)}&via=yourTwitterHandle&hashtags=yourHashtags`;
            window.open(tweetUrl, "_blank");
        };
        onClickOutside(sidebar);
        menubtn.addEventListener('click', removeHiddenClass);
        closeMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('hidden');
        });
    </script>
    <script>
        document.getElementById("xShareBtn").addEventListener("click", shareFunction);
        document.getElementById("xShareBtn2").addEventListener("click", shareFunction);
        document.getElementById("xShareBtn3").addEventListener("click", shareFunction);
        document.getElementById("xShareBtn4").addEventListener("click", shareFunction);
        document.getElementById("xShareBtn5").addEventListener("click", shareFunction);
        document.getElementById("xShareBtn6").addEventListener("click", shareFunction);
        var messageType = "<?= $_SESSION['status_type'] ?? ' ' ?>";
        var messageText = "<?= $_SESSION['status'] ?? ' ' ?>";
    </script>
    <script>
        const Toast = Swal.mixin({
            customClass: {
                popup: 'rounded-xl shadow-lg',
                title: 'text-lg font-semibold',
                confirmButton: 'bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700'
            },
            buttonsStyling: false,
            backdrop: `rgba(0,0,0,0.4)`,
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });

        if (messageType && messageText.trim() !== "") {
            let iconColors = {
                'Error': '#e74c3c',
                'Success': '#2ecc71',
                'Info': '#3498db'
            };

            Toast.fire({
                icon: messageType.toLowerCase(),
                title: messageText,
                iconColor: iconColors[messageType] || '#3498db',
                confirmButtonText: 'Got it'
            });
        }

        <?php unset($_SESSION['status_type']); ?>
        <?php unset($_SESSION['status']); ?>
    </script>
</body>

</html>