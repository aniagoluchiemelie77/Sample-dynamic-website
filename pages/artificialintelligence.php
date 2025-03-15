<?php
session_start();
require('../connect.php');
require('..\admin/crudoperations.php');
require('..\vendor\phpmailer\phpmailer\src\SMTP.php');
require('..\vendor\phpmailer\phpmailer\src\Exception.php');
require('..\vendor\phpmailer\phpmailer\src\PHPMailer.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
if (!function_exists('calculateReadingTime')) {
    function calculateReadingTime($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        $minutes = floor($wordCount / 200);
        return $minutes  . ' mins read ';
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
    <title>Artificial Intelligence</title>
</head>

<body id="container">
    <?php require("../includes/header2.php"); ?>
    <div class="body_container">
        <div class="body_left">
            <div class="page_links">
                <a href="../">Home</a> > <p>Artificial Intelligence</p>
            </div>
            <h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>Latest On Artificial Intelligence</h1>
            <div class='more_posts'>;
                <?php
                $tables = ['paid_posts', 'posts', 'commentaries', 'news', 'press_releases'];
                $results = [];
                foreach ($tables as $table) {
                    $sql = "SELECT id, title, niche, content, image_path, Date FROM $table WHERE niche LIKE ? ORDER BY id DESC LIMIT 2";
                    $stmt = $conn->prepare($sql);
                    $nicheq = 'Artificial Intelligence';
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
</body>

</html>