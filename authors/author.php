<?php
session_start();
require('../connect.php');
require('../init.php');
$page_name = "author";
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$id = isset($_GET['id']) ? $_GET['id'] : null;
$idtype = isset($_GET['idtype']) ? $_GET['idtype'] : null;
$author_fname = isset($_GET['author_fname']) ? $_GET['author_fname'] : null;
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
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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
    <link rel="icon" href="../<?php echo $favicon; ?>" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../index.js" defer></script>
    <title>Author</title>
</head>

<body>
    <?php require("../includes/header2.php"); ?>
    <center>
        <?php
        $author_firstname = "";
        $author_lastname = "";
        $author_image = "";
        $role = "";
        $author_bio = "";
        if ($idtype == "Admin") {
            $getauthor_sql = "SELECT id, firstname, lastname, image, bio FROM admin_login_info WHERE id = $id";
            $getauthor_result = $conn->query($getauthor_sql);
            if ($getauthor_result->num_rows > 0) {
                $author = $getauthor_result->fetch_assoc();
                $author_firstname = $author['firstname'];
                $author_lastname = $author['lastname'];
                $author_bio = $author['bio'];
                $author_image = $author['image'];
                $role = "Editor-in-chief";
                echo "<section class='authordiv_container'>";
                if (!empty($author_image)) {
                    echo "<img src='$author_image' alt='article image'>";
                }
                echo    "<div class = 'authordiv_container_subdiv'>
                                <h1><span>$author_firstname $author_lastname, </span><span>$role</span></h1>
                                <p>$author_bio</p>
                            </div>
                        </section>
                        <div class='body_container'>
                            <div class='body_left'>    
                                <h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>More Posts By <span> $author_firstname  $author_lastname </span></h1>
                                <div class='more_posts'>";
            }
            $tables = ['paid_posts', 'posts', 'commentaries', 'news', 'press_releases'];
            $results = [];
            foreach ($tables as $table) {
                $sql = "SELECT id, title, niche, content, image_path, post_image_url, Date, schedule FROM $table WHERE admin_id = ? ORDER BY id DESC LIMIT 12";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $id);
                $stmt->bind_result($id, $title, $niche, $content, $image, $image2, $date, $schedule);
                $stmt->execute();
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
                        'foreign_image_path' => $image2,
                        'Date' => $date,
                        'schedule' => $schedule,
                        'table' => $table,
                        'posttype' => $posttype
                    ];
                }
            }
            foreach ($results as $result) {
                $max_length = 40;
                $id = $result['id'];
                $title = $result["title"];
                if (strlen($title) > $max_length) {
                    $title = substr($title, 0, $max_length) . '...';
                }
                $scheduleDate = !empty($result['schedule']) ? formatDateSafely($result['schedule']) : null;
                $postDate = !empty($result['Date']) ? formatDateSafely($result['Date']) : null;
                $now = date('Y-m-d H:i:s');
                if ($scheduleDate && $result['schedule'] <= $now) {
                    $publishDate = $scheduleDate;
                } else {
                    $publishDate = $postDate;
                }
                $readingTime = calculateReadingTime($result['content']);
                echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id" . $result['posttype'] . "=$id'>";
                if (!empty($result['image_path'])) {
                    echo "<img src='" . $result['image_path'] . "' alt='article image'>";
                } elseif (!empty($result['foreign_image_path'])) {
                    echo "<img src='" . $result['foreign_image_path'] . "' alt='article image'>";
                }
                echo    "<div class='more_posts_subdiv_subdiv'>
                                <h1>$title</h1>
                                <span>$publishDate</span>
                                <span>$readingTime</span>
                            </div>
                            <p class='posts_div_niche'>" . $result['niche'] . "</p>
                        </a>
                    ";
            }

            echo "</div></div>";
        }
        if ($idtype == "Editor") {
            $getauthor_sql = "SELECT id, firstname, lastname, image, bio FROM editor WHERE id = $id";
            $getauthor_result = $conn->query($getauthor_sql);
            if ($getauthor_result->num_rows > 0) {
                $author = $getauthor_result->fetch_assoc();
                $author_firstname = $author['firstname'];
                $author_lastname = $author['lastname'];
                $author_bio = $author['bio'];
                $author_image = $author['image'];
                $role = "Editor at Uniquetechcontentwriter";
                echo "<section class='authordiv_container'>";
                if (!empty($author_image)) {
                    echo "<img src='$author_image' alt='article image'>";
                }
                echo    "<div class = 'authordiv_container_subdiv'>
                                <h1><span>$author_firstname $author_lastname, </span><span>$role</span></h1>
                                <p>$author_bio</p>
                            </div>
                            </section>
                           <div class='body_container'>
                                <div class='body_left'>    
                                    <h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>More Posts By <span> $author_firstname  $author_lastname </span></h1>
                                    <div class='more_posts'>";
            }
            $tables = ['posts', 'commentaries', 'news', 'press_releases'];
            $results = [];
            foreach ($tables as $table) {
                $sql = "SELECT id, title, niche, content, image_path, post_image_url, Date FROM $table WHERE editor_id = ? ORDER BY id DESC LIMIT 12";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $id);
                $stmt->bind_result($id, $title, $niche, $content, $image, $image2, $date);
                $stmt->execute();
                while ($stmt->fetch()) {
                    $posttype = 0;
                    if ($table == 'posts') {
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
                        'foreign_image_path' => $image2,
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
                echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id" . $result['posttype'] . "=$id'>";
                if (!empty($result['image_path'])) {
                    echo "<img src='" . $result['image_path'] . "' alt='article image'>";
                } else if (!empty($result['foreign_image_path'])) {
                    echo "<img src='" . $result['foreign_image_path'] . "' alt='article image'>";
                }
                echo    "<div class='more_posts_subdiv_subdiv'>
                                <h1>$title</h1>
                                <span>$formattedDate</span>
                                <span>$readingTime</span>
                            </div>
                            <p class='posts_div_niche'>" . $result['niche'] . "</p>
                        </a>
                    ";
            }

            echo "</div></div>";
        }
        if ($idtype == "Writer") {
            $getauthor_sql = "SELECT id, firstname, lastname, image, bio FROM writer WHERE id = $id";
            $getauthor_result = $conn->query($getauthor_sql);
            if ($getauthor_result->num_rows > 0) {
                $author = $getauthor_result->fetch_assoc();
                $author_firstname = $author['firstname'];
                $author_lastname = $author['lastname'];
                $author_bio = $author['bio'];
                $author_image = $author['image'];
                $role = "Contributing Writer";
                echo "<section class='authordiv_container'>";
                if (!empty($author_image)) {
                    echo "<img src='$author_image' alt='article image'>";
                }
                echo    "<div class = 'authordiv_container_subdiv'>
                                <h1><span>$author_firstname $author_lastname, </span><span>$role</span></h1>
                                <p>$author_bio</p>
                            </div>
                        </section>
                        <div class='body_container'>
                            <div class='body_left'>    
                                <h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>More Posts By <span> $author_firstname  $author_lastname </span></h1>
                                <div class='more_posts'>";
            }
            $tables = ['posts', 'commentaries', 'news', 'press_releases'];
            $results = [];
            foreach ($tables as $table) {
                $sql = "SELECT id, title, niche, content, image_path, post_image_url, Date FROM $table WHERE authors_firstname like ? ORDER BY id DESC LIMIT 12";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $author_firstname);
                $stmt->bind_result($author_firstname, $title, $niche, $content, $image, $image2, $date);
                $stmt->execute();
                while ($stmt->fetch()) {
                    $posttype = 0;
                    if ($table == 'posts') {
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
                        'foreign_image_path' => $image2,
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
                echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id" . $result['posttype'] . "=$id'>";
                if (!empty($result['image_path'])) {
                    echo "<img src='" . $result['image_path'] . "' alt='article image'>";
                } else if (!empty($result['foreign_image_path'])) {
                    echo "<img src='" . $result['foreign_image_path'] . "' alt='article image'>";
                }
                echo    "<div class='more_posts_subdiv_subdiv'>
                                <h1>$title</h1>
                                <span>$formattedDate</span>
                                <span>$readingTime</span>
                            </div>
                            <p class='posts_div_niche'>" . $result['niche'] . "</p>
                        </a>
                    ";
            }

            echo "</div></div>";
        }
        ?>
        <div class="body_right border-gradient-leftside--lightdark">
            <div class="subscribe_container">
                <form class="sec2__susbribe-box other_width" method="POST" action="" id="susbribe-box">
                    <div class="icon">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </div>
                    <h1 class="sec2__susbribe-box-header">Subscribe to Updates</h1>
                    <p class="sec2__susbribe-box-p1">Get the latest Updates and Info from Uniquetechcontentwriter on Cybersecurity, Artificial Intelligence and lots more.</p>
                    <input class="sec2__susbribe-box_input" type="text" placeholder="Your Email Address..." name="email" required />
                    <input class="sec2__susbribe-box_btn" type="submit" value="Submit" name="submit_btn" onclick="submitPost()" />
                </form>
                <div id="thank-you-message"></div>
            </div>
            <h3 class="bodyleft_header3 border-gradient-bottom--lightdark">Editor's Picks</h3>
            <?php include("../helpers/editorspicks.php"); ?>
        </div>
    </center>
    <?php require("../includes/footer.php"); ?>
    <script>
        const closeMenuBtn = document.querySelector('.sidebarbtn');
        const sidebar = document.getElementById('sidebar');
        const menubtn = document.querySelector('.mainheader__header-nav-2');
        var messageType = "<?= $_SESSION['status_type'] ?? ' ' ?>";
        var messageText = "<?= $_SESSION['status'] ?? ' ' ?>";
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
        onClickOutside(sidebar);
        menubtn.addEventListener('click', removeHiddenClass);
        closeMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('hidden');
        });
    </script>
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
</body>

</html>