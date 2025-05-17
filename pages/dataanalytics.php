<?php
session_start();
require('../connect.php');
require('../init.php');
$page_name = "data-analytics";
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
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
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../index.css" />
    <script src="../index.js" defer></script>
    <link rel="icon" href="../<?php echo $favicon; ?>" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Data Analytics</title>
</head>

<body id="container">
    <?php require("../includes/header2.php"); ?>
    <div class="body_container">
        <div class="body_left">
            <div class="page_links">
                <a href="../">Home</a> > <p>Data Analytics</p>
            </div>
            <h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>Latest On Data Analytics</h1>
            <div class='more_posts'>;
                <?php
                $tables = ['paid_posts', 'posts', 'commentaries', 'news', 'press_releases'];
                $results = [];
                foreach ($tables as $table) {
                    $sql = "SELECT id, title, niche, content, image_path, Date FROM $table WHERE niche LIKE ? ORDER BY id DESC LIMIT 2";
                    $stmt = $conn->prepare($sql);
                    $nicheq = 'Data Analytics';
                    $searchTerm = "%" . $nicheq . "%";
                    $stmt->bind_param("s", $searchTerm);
                    $stmt->execute();
                    $stmt->bind_result($id, $title, $niche, $content, $image, $date);
                    while ($stmt->fetch()) {
                        $posttype = 0;
                        if ($table == 'paid_posts') {
                            $posttype = 1;
                        } elseif ($table == 'posts') {
                            $posttype = 2;
                        } elseif ($table == 'commentaries') {
                            $posttype = 4;
                        } elseif ($table == 'news') {
                            $posttype = 3;
                        } elseif ($table == 'press_releases') {
                            $posttype = 5;
                        }
                        $results[] = [
                            'id' => $id,
                            'title' => $title,
                            'niche' => $niche,
                            'content' => $content,
                            'image_path' => $image,
                            'Date' => $date,
                            'table' => $table,
                            'posttype' => $posttype
                        ];
                    }
                }
        foreach ($results as $result) {
                    $max_length = 60;
                    $id = $result['id'];
                    $title = $result["title"];
                    $date = $result["Date"];
                    $image = $result['image_path'];
                    if (strlen($title) > $max_length) {
                        $title = substr($title, 0, $max_length) . '...';
                    }
                    $dateTime = new DateTime($date);
                    $day = $dateTime->format('j');
                    $month = $dateTime->format('M');
                    $year = $dateTime->format('Y');
                    $ordinalSuffix = getOrdinalSuffix($day);
                    $formattedDate = $month . ' ' . $day . $ordinalSuffix . ', ' . $year;
                    $readingTime = calculateReadingTime($result['content']);
                    echo "<a class='more_posts_subdiv' href='view_post.php?id" . $result['posttype'] . "=$id'>";
                    if (!empty($image)) {
                        echo "<img src='../$image' alt = 'Post's Image'/>";
                    }
                    echo   "<div class='more_posts_subdiv_subdiv'>
                                    <h1>$title</h1>
                                    <span>$formattedDate</span>
                                    <span>$readingTime</span>
                                </div>
                                <p class='posts_div_niche'>" . $result['niche'] . "</p>
                            </a>";
                }
                ?>
            </div>
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
    <section class="section2">
        <div class="section2__div1">
            <div class="search_div" id="result"></div>
            <div class="section2__div1__header headers">
                <h1>For You</h1>
            </div>
            <?php include('../includes/pagination.php'); ?>
        </div>
    </section>
    <?php include("../includes/footer2.php"); ?>
    <script src="sweetalert2.all.min.js"></script>
    <script>
        const closeMenuBtn = document.querySelector('.sidebarbtn');
        const sidebar = document.getElementById('sidebar');
        const menubtn = document.querySelector('.mainheader__header-nav-2');
        var messageType = "<?= $_SESSION['status_type'] ?? ' ' ?>";
        var messageText = "<?= $_SESSION['status'] ?? ' ' ?>";

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
        if (messageType == 'Error' && messageText != " ") {
            Swal.fire({
                title: 'Error!',
                text: messageText,
                icon: 'error',
                confirmButtonText: 'Ok'
            })
        } else if (messageType == 'Info' && messageText != " ") {
            Swal.fire({
                title: 'Info!',
                text: messageText,
                showConfirmButton: true,
                confirmButtonText: 'Ok',
                icon: 'info'
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