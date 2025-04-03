<?php
session_start();
require('..\connect.php');
require('..\admin/crudoperations.php');
require('..\vendor\phpmailer\phpmailer\src\SMTP.php');
require('..\vendor\phpmailer\phpmailer\src\Exception.php');
require('..\vendor\phpmailer\phpmailer\src\PHPMailer.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$id = isset($_GET['id']) ? $_GET['id'] : null;
$idtype = isset($_GET['idtype']) ? $_GET['idtype'] : null;
$author_fname = isset($_GET['author_fname']) ? $_GET['author_fname'] : null;
$thankYouMessage = "";
$msg = "";
if (isset($_POST['submit_btn'])) {
    $email = $_POST["email"];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $date = date("Y-m-d");
        $time = date("H:i:s");
        $checkStmt = $conn->prepare("SELECT * FROM subscribers WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        if ($result->num_rows > 0) {
            $msg = "You are already subscribed with us!";
        } else {
            $stmt = $conn->prepare("INSERT INTO subscribers (email, date, time) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $date, $time);
            if ($stmt->execute()) {
                $forUser = 0;
                $action = 'New Email Subscription alert';
                logUpdate($conn, $forUser, $action);
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'aniagoluchiemelie77@gmail.com';
                    $mail->Password   = 'ozmsoscaivmkrbuu';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;
                    $mail->setFrom('aniagoluchiemelie77@gmail.com', 'Aniagolu Chiemelie');
                    $mail->addAddress($email, 'Chiboy');
                    $mail->isHTML(true);
                    $mail->Subject = 'Welcome to Our Newsletter';
                    $mail->Body    = 'Thank you for subscribing to our newsletter! We are excited to have you with us.';
                    $mail->send();
                    $thankYouMessage = "Thank You For Subscribing With Us!";
                } catch (Exception $e) {
                    $thankYouMessage = "Subscription successful, but the welcome email could not be sent.";
                }
            } else {
                $msg = "Error: " . $stmt->error;
            }
        }
    } else {
        $msg = "Invalid email address. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="Article website" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu chiemelie" />
    <link rel="stylesheet" href="../index.css" />
    <script src="../index.js" defer></script>
    <title>Author</title>
</head>

<body>
    <?php require("../includes/header2.php"); ?>
    <center>
        <?php
        function calculateReadingTime($content)
        {
            $wordCount = str_word_count(strip_tags($content));
            $minutes = floor($wordCount / 200);
            return $minutes  . ' mins read ';
        }
        function convertToReadable($slug)
        {
            $string = str_replace('-', ' ', $slug);
            $string = ucwords($string);
            return $string;
        }
        function removeHyphen($string)
        {
            $string = str_replace(['-', ' '], '', $string);
            return $string;
        }
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
                    echo "<img src='../$author_image' alt='article image'>";
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
                $sql = "SELECT id, title, niche, content, image_path, Date FROM $table WHERE admin_id = ? ORDER BY id DESC LIMIT 12";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $id);
                $stmt->bind_result($id, $title, $niche, $content, $image, $date);
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
                        'Date' => $date,
                        'table' => $table,
                        'posttype' => $posttype
                    ];
                }
            }
            foreach ($results as $result) {
                if (!function_exists('getOrdinalSuffix')) {
                    function getOrdinalSuffix($day)
                    {
                        if (!in_array(($day % 100), [11, 12, 13])) {
                            switch ($day % 10) {
                                case 1:
                                    return 'st';
                                case 2:
                                    return 'nd';
                                case 3:
                                    return 'rd';
                            }
                        }
                        return 'th';
                    }
                }
                if (!function_exists('calculateReadingTime')) {
                    function calculateReadingTime($content)
                    {
                        $wordCount = str_word_count(strip_tags($content));
                        $minutes = floor($wordCount / 200);
                        return $minutes  . ' mins read ';
                    }
                }
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
                    echo "<img src='../" . $result['image_path'] . "' alt='article image'>";
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
                    echo "<img src='../$author_image' alt='article image'>";
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
                $sql = "SELECT id, title, niche, content, image_path, Date FROM $table WHERE editor_id = ? ORDER BY id DESC LIMIT 12";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $id);
                $stmt->bind_result($id, $title, $niche, $content, $image, $date);
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
                        'Date' => $date,
                        'table' => $table,
                        'posttype' => $posttype
                    ];
                }
            }
            foreach ($results as $result) {
                if (!function_exists('getOrdinalSuffix')) {
                    function getOrdinalSuffix($day)
                    {
                        if (!in_array(($day % 100), [11, 12, 13])) {
                            switch ($day % 10) {
                                case 1:
                                    return 'st';
                                case 2:
                                    return 'nd';
                                case 3:
                                    return 'rd';
                            }
                        }
                        return 'th';
                    }
                }
                if (!function_exists('calculateReadingTime')) {
                    function calculateReadingTime($content)
                    {
                        $wordCount = str_word_count(strip_tags($content));
                        $minutes = floor($wordCount / 200);
                        return $minutes  . ' mins read ';
                    }
                }
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
                    echo "<img src='../" . $result['image_path'] . "' alt='article image'>";
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
                    echo "<img src='../$author_image' alt='article image'>";
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
                $sql = "SELECT id, title, niche, content, image_path, Date FROM $table WHERE authors_firstname like ? ORDER BY id DESC LIMIT 12";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $author_firstname);
                $stmt->bind_result($author_firstname, $title, $niche, $content, $image, $date);
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
                        'Date' => $date,
                        'table' => $table,
                        'posttype' => $posttype
                    ];
                }
            }
            foreach ($results as $result) {
                if (!function_exists('getOrdinalSuffix')) {
                    function getOrdinalSuffix($day)
                    {
                        if (!in_array(($day % 100), [11, 12, 13])) {
                            switch ($day % 10) {
                                case 1:
                                    return 'st';
                                case 2:
                                    return 'nd';
                                case 3:
                                    return 'rd';
                            }
                        }
                        return 'th';
                    }
                }
                if (!function_exists('calculateReadingTime')) {
                    function calculateReadingTime($content)
                    {
                        $wordCount = str_word_count(strip_tags($content));
                        $minutes = floor($wordCount / 200);
                        return $minutes  . ' mins read ';
                    }
                }
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
                    echo "<img src='../" . $result['image_path'] . "' alt='article image'>";
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
                    <p class="error_div" id="error_message"><?php if (!empty($msg)) {
                                                                echo $msg;
                                                            } ?></p>
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

        function removeHiddenClass(e) {
            e.stopPropagation();
            sidebar.classList.remove('hidden');
        };

        function displayThankYouMessage() {
            var thankYouMessage = "<?php echo $thankYouMessage; ?>";
            const thankDiv = document.getElementById('thank-you-message');
            if (thankYouMessage) {
                document.getElementById('susbribe-box').style.display = "none";
                document.getElementById('subscribe_box2').style.display = "none";
                thankDiv.scrollIntoView({
                    behavior: 'smooth'
                });
                thankDiv.innerHTML = `<p>${thankYouMessage}</p>`;
                thankDiv.style.display = "flex";
            }
        }

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
</body>

</html>