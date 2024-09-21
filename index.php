<?php
session_start();
require('connect.php');
function getDeviceType() {
    $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    if (strpos($user_agent, 'mobile') !== false) {
        return 'Mobile';
    } elseif (strpos($user_agent, 'tablet') !== false) {
        return 'Tablet';
    } else {
        return 'Desktop';
    }
}
$device_type = getDeviceType();
function getVisitorIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}
$ip_address = getVisitorIP();
$visit_type = "";
$api_url = "http://www.geoplugin.net/json.gp?ip=" . $ip_address;
$response = file_get_contents($api_url);
$data = json_decode($response);
$country = $data->geoplugin_countryName;
date_default_timezone_set('UTC');
$date = date('Y-m-d');
$time = date("H:iA");
$visitor_check = "SELECT * FROM web_visitors WHERE ip_address = '$ip_address'";
$result_check = $conn->query($visitor_check);
if ($result_check->num_rows > 0) {
    $visit_type = 'returning';
    if ($visit_type == 'returning') {
        $sql_update = "UPDATE web_visitors SET visit_type = '$visit_type', visit_time = '$time' WHERE ip_address = '$ip_address'";
        $update_check = $conn->query($sql_update);
    }
} else {
    $visit_type = 'new';
    $insertIP = "INSERT INTO web_visitors (ip_address, country, user_devicetype, visit_time, visit_type) VALUES ('$ip_address', '$country', '$device_type', '$time', '$visit_type')";
    $result1 = $conn->query($insertIP);
}
require("connect.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$userEmail = " ";
if(isset($_POST['submit_btn'])){
    $message = "<div><h1><br>Thank you for subscribing with us.</br></h1>
        <p>Thank you for subscribing to our email updates, We will keep you updated with the latest updates and information.</p>
         </div>";
    $response = array();
    $userEmail = $_POST['email'];
    $email = $userEmail;
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;  
    $mail -> IsSMTP();
    $mail -> SMTPAuth = true;
    $mail -> SMTPSecure = "tls";
    $mail -> Host = "stmp.gmail.com";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 587;
    $mail -> Username = "aniagoluchiemelie77@gmail.com";
    $mail -> Password = "otxteulzfnelidgd";
    $mail -> FromName = "Uniquetechcontentwriter";
    $mail -> AddAddress ($email);
    $mail->addReplyTo('aniagoluachiemelie77@gmail.com', 'Information');
    $mail -> Subject = "Successful Email Updates Subscription";
    $mail -> isHTML(TRUE);
    $mail -> Body = $message;
    if(filter_var($userEmail, FILTER_VALIDATE_EMAIL)){
        $sql = "INSERT INTO subscribers (email, date, time) VALUES ('$userEmail', '$date', '$time')";
        $result = $conn->query($sql);
        if($mail->preSend() and $result === TRUE){
            $response['success'] = true;
            $response['message'] = "Thank You For Subscribing With Us.";
            $msg = "Thank You For Subscribing With Us.";
        }else{
            $response['success'] = false;
            $response['message'] = "Error: " . $sql . "<br>" . $conn->error;
        }
    }else{
        $response['success'] = false;
        $response['message'] = "Error: " . $sql . "<br>" . $conn->error;
        $msg = "Invalid Email";
    }
    $conn->close();
    echo json_encode($response);

}
if (isset($_POST['accept_cookies'])) {
    setcookie('tracker', 'accepted', time() + (86400 * 30), "/"); // 30 days
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="Article website" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu chiemelie"/>
    <link rel="stylesheet" href="index.css"/>
	<title>Home</title>
    </head>
    <body id="container">
        <?php include("includes/header.php");?>
        <?php if (!isset($_COOKIE['tracker'])): ?>
            <div class="cookie_container" id ="cookie_container">
                <p class="cookie_container_p">This website uses cookies and similar technologies to operate the site, analyze data, improve user experience. By using this site, you agree to our use of cookies to enhance your experience. Check our <a href="pages/privacypolicy.php">Privacy Policy</a> for more details.</p>
                <form class="cookie_container_subdiv" method="post">
                    <button class="cookie_container_subdiv-btns" type="submit" name="accept_cookies">Accept</button>
                </form>
            </div>
        <?php endif; ?>
        <div class="header__menu-sidebar hidden" id="sidebar">
            <div class="header__menu-sidebar-div1 sidebar-input">
                <a class="sidebarbtn">
                    <svg width="2.9rem" height="2.9rem" viewBox="0 0 24 24" fill="#222222" xmlns="http://www.w3.org/2000/svg">
                        <rect width="24" height="24" fill="black"/>
                        <path d="M7 17L16.8995 7.10051" stroke="#FAFAFA" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M7 7.00001L16.8995 16.8995" stroke="#FAFAFA" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
            <div class="header__menu-sidebar-div1 border-gradient-top-dark">
                <div class="sidebar__logobox">
                    <img src="#" alt="companylogo">
                </div> 
                <div class="header__menu-sidebar-div1-subdiv2">
                    <h1 class="sidebar__col-header">More</h1>
                    <a href="OtherHtmlPages\aboutus.html" class="sidebar__links">About Us</a>
                    <a href="#" class="sidebar__links">Pitch to Us</a>
                    <a href="#" class="OtherHtmlPages\Advertise.html">Advertise with Us</a>
                </div>
                <div class="header__menu-sidebar-div1-subdiv3">
                    <h1 class="sidebar__col-header">Sources</h1>
                    <a href="#" class="sidebar__links">White Papers</a>
                    <a href="#" class="sidebar__links">Webinars</a>
                    <a href="#" class="sidebar__links">Ebooks</a>
                    <a href="#" class="sidebar__links">Press Release</a>
                </div>
            </div>
            <div class="header__menu-sidebar-div2 border-gradient-top-dark">
                <p class="paragraph">&copy; Aniagolu Chiemelie 2024. All rights reserved</p>
                <div class="header__menu-sidebar-div2-subdiv1">
                    <h1 class="sidebar__col-header">Follow Us</h1>
                    <div class="header__menu-sidebar-div2-subdiv1-subdiv">
                        <a class="sidebar__links" href="#">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                        <a class="sidebar__links" href="#">
                            <i class="fab fa-linkedin" aria-hidden="true"></i>
                        </a>
                        <a class="sidebar__links" href="#">
                            <i class="fab fa-facebook" aria-hidden="true"></i> 
                        </a>
                        <a class="sidebar__links" href="#">
                            <i class="fa fa-rss" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <section class="section1">
        <?php 
            $selectpaidposts = "SELECT id, title, niche, image, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM paid_posts ORDER BY date DESC";
            $paidpostselection_result = $conn->query($selectpaidposts); 
            if ($paidpostselection_result->num_rows > 0) {
                $counter = 0;
                while($row = $paidpostselection_result->fetch_assoc()) {
                    $counter++;
                    $class = $counter == 1 ? "section1__div1 larger__div" : "section1__div2 smallerdivs";
                    $class2 = $counter == 1 ? "larger__div__subdiv" : "smaller__div__subdiv";
                    echo "<div class='$class'>
                            <a href='pages/view_post.php?id=". $row['id'] ."'>
                                <img src='images/".$row['image']."' alt='article image'/>
                                <div class='$class2'>
                                    <h1>". $row['niche'] ."</h1>
                                    <h2>". $row['title'] ."</h2>
                                    <p>" . $row["formatted_date"] . "</p>
                                </div>
                            </a>
                        </div>";
                }
            }
        ?>
        </section>
        <section class="section2">
            <div class="section2__div1">
            <div class="section2__div1__header headers">
                <h1>Latest Articles</h1>
            </div>
            <div class="section2__div1__div1 normal-divs">
                <a class="normal-divs__subdiv">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php" >
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div1 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div2 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div3 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div4 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <div class="section2__div1__div5 normal-divs border-gradient-top-dark">
                <a class="normal-divs__subdiv" href="pages/view_post.php">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="normal-divs__subdiv__div">
                        <h1 class="normal-divs__header">Sample Niche</h1>
                        <h2 class="normal-divs__title">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div>
                            <p class="normal-divs__releasedate firstp">June 13, 2024</p>
                            <p class="normal-divs__releasedate">
                                <i class="fa fa-clock" aria-hidden="true"></i> 5 mins read
                            </p>
                        </div>
                    </div>
                </a>
                <div class="normal-divs__subdiv2">
                    <img src="images\image1.jpeg" alt="article image">
                    <p class="normal-divs__subdiv2__p">by <span>Elizabeth Montalbano, Contributing Writer</span></p>
                </div>
            </div>
            <a class="section2__div1__link" href="indexsub2.html">
                Load more
                <svg width="2.5rem" height="2.5rem" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="24" height="24" fill="#FAFAFA"/>
                    <path d="M9.5 7L14.5 12L9.5 17" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            </div>
            <div class="body_right border-gradient-leftside--lightdark">
                <?php include('helpers/emailsubscribeform.php');?>
                <div class="section2__div1__header headers">
                    <h1>Latest News</h1>
                </div>
                <a class="posts_div" href="#">
                <img src="images/chibs.jpg" alt="Post's Image"/>
                <p class="posts_div_niche">Cybersecurity</p>
                <h1>Unfixed Microsoft Entra ID Authentification Bypass Threatens Hybrid IDs.</h1>
                <p class="posts_div_otherp">By, <span>Chiemelie Aniagolu, Contributing Writer.</span></p>
                <div class="posts_div_subdiv">
                    <p>Aug 15th, 2024</p>
                    <p>10mins Read.</p>
                </div>
                </a>
                <a class="posts_div" href="#">
                <img src="images/chibs.jpg" alt="Post's Image"/>
                <p class="posts_div_niche">Cybersecurity</p>
                <h1>Unfixed Microsoft Entra ID Authentification Bypass Threatens Hybrid IDs.</h1>
                <p class="posts_div_otherp">By, <span>Chiemelie Aniagolu, Contributing Writer.</span></p>
                <div class="posts_div_subdiv">
                    <p>Aug 15th, 2024</p>
                    <p>10mins Read.</p>
                </div>
                </a>
                <a class="posts_div" href="#">
                <img src="images/chibs.jpg" alt="Post's Image"/>
                <p class="posts_div_niche">Cybersecurity</p>
                <h1>Unfixed Microsoft Entra ID Authentification Bypass Threatens Hybrid IDs.</h1>
                <p class="posts_div_otherp">By, <span>Chiemelie Aniagolu, Contributing Writer.</span></p>
                <div class="posts_div_subdiv">
                    <p>Aug 15th, 2024</p>
                    <p>10mins Read.</p>
                </div>
                </a>
                <div class="ads_sidebar"></div>
                <a class="posts_div" href="#">
                <img src="images/chibs.jpg" alt="Post's Image"/>
                <p class="posts_div_niche">Cybersecurity</p>
                <h1>Unfixed Microsoft Entra ID Authentification Bypass Threatens Hybrid IDs.</h1>
                <p class="posts_div_otherp">By, <span>Chiemelie Aniagolu, Contributing Writer.</span></p>
                <div class="posts_div_subdiv">
                    <p>Aug 15th, 2024</p>
                    <p>10mins Read.</p>
                </div>
                </a>
                <a class="posts_div" href="#">
                <img src="images/chibs.jpg" alt="Post's Image"/>
                <p class="posts_div_niche">Cybersecurity</p>
                <h1>Unfixed Microsoft Entra ID Authentification Bypass Threatens Hybrid IDs.</h1>
                <p class="posts_div_otherp">By, <span>Chiemelie Aniagolu, Contributing Writer.</span></p>
                <div class="posts_div_subdiv">
                    <p>Aug 15th, 2024</p>
                    <p>10mins Read.</p>
                </div>
                </a>
                <a class="posts_div" href="#">
                <img src="images/chibs.jpg" alt="Post's Image"/>
                <p class="posts_div_niche">Cybersecurity</p>
                <h1>Unfixed Microsoft Entra ID Authentification Bypass Threatens Hybrid IDs.</h1>
                <p class="posts_div_otherp">By, <span>Chiemelie Aniagolu, Contributing Writer.</span></p>
                <div class="posts_div_subdiv">
                    <p>Aug 15th, 2024</p>
                    <p>10mins Read.</p>
                </div>
                </a>
                <a href="pages/news.php" class="mainheader__signupbtn">See More News</a>
                <div class="setion2_bodyright_subdiv">
                    <h1>White Papers</h1>
                    <div class="setion2_bodyright_subdiv_subdiv">
                        <a>Paper 1</a>
                        <a>Paper 2</a>
                        <a>Paper 3</a>
                        <a>Paper 4</a>
                        <a>Paper 5</a>
                        <a>Paper 6</a>
                    </div>
                    <a class="mainheader__signupbtn">See more</a>
                </div>
                <div class="setion2_bodyright_subdiv">
                    <h1>Ebooks</h1>
                    <div class="setion2_bodyright_subdiv_subdiv">
                        <a>Ebook 1</a>
                        <a>Ebook 2</a>
                        <a>Ebook 3</a>
                        <a>Ebook 4</a>
                        <a>Ebook 5</a>
                        <a>Ebook 6</a>
                    </div>
                    <a class="mainheader__signupbtn">See More</a>
                </div>
                <div class="setion2_bodyright_subdiv">
                    <h1>Webinars</h1>
                    <div class="setion2_bodyright_subdiv_subdiv">
                        <a>Webinar 1</a>
                        <a>Webinar 2</a>
                        <a>Webinar 3</a>
                        <a>Webinar 4</a>
                        <a>Webinar 5</a>
                        <a>Webinar 6</a>
                    </div>
                    <a class ="mainheader__signupbtn">See More</a>
                </div>
                <div class="setion2_bodyright_topicsdiv">
                    <form action="index.php" method="post">
                        <input class="topics_search" name='topics_search' type='text' placeholder="Search Topics.." required/>
                        <button type="submit" class="fa fa-search" name='topics_search_submit'></button>
                    </form>
                    <h1>Categories</h1>
                    <div class="setion2_bodyright_topicsdiv_subdiv">
                        <a>Cybersecurity</a>
                        <a>Artificial Intelligence</a>
                        <a>Cloud Computing</a>
                        <a>Data Analytics</a>
                    </div>
                </div>
                <div class="ads_sidebar"></div>
                <div class="section2__div1__header headers">
                    <h1>Latest Commentary</h1>
                </div>
                <a class="commentary_divs">
                    <div class='commentary_divs_imagediv'>
                        <img src="images/chibs.jpg" alt="Commentary's Image" />
                        <div class="commentary_divs_imagediv_subdiv">
                            <h1>Aniagolu Chiemelie</h1>
                            <p>Chief Technologist for Security Research and Innovation, HP Inc. Security Labs.</p>
                        </div>
                    </div>
                    <div class="commentary_divs_body">
                        <h2>Sample Niche</h2>
                        <h3>Hardware Supply Chain Threats Can Undermine Endpoint Infrastructure</h3>
                        <div class="commentary_divs_body_subdiv">
                            <p>Sept 12th 2023</p>
                            <p><i class="fa fa-clock" aria-hidden="true"></i>
                            10mins read.</p>
                        </div>
                    </div>
                </a>
                <a class="commentary_divs">
                    <div class='commentary_divs_imagediv'>
                        <img src="images/chibs.jpg" alt="Commentary's Image" />
                        <div class="commentary_divs_imagediv_subdiv">
                            <h1>Aniagolu Chiemelie</h1>
                            <p>Chief Technologist for Security Research and Innovation, HP Inc. Security Labs.</p>
                        </div>
                    </div>
                    <div class="commentary_divs_body">
                        <h2>Sample Niche</h2>
                        <h3>Hardware Supply Chain Threats Can Undermine Endpoint Infrastructure</h3>
                        <div class="commentary_divs_body_subdiv">
                            <p>Sept 12th 2023</p>
                            <p><i class="fa fa-clock" aria-hidden="true"></i>
                            10mins read.</p>
                        </div>
                    </div>
                </a>
                <a class="commentary_divs">
                    <div class='commentary_divs_imagediv'>
                        <img src="images/chibs.jpg" alt="Commentary's Image" />
                        <div class="commentary_divs_imagediv_subdiv">
                            <h1>Aniagolu Chiemelie</h1>
                            <p>Chief Technologist for Security Research and Innovation, HP Inc. Security Labs.</p>
                        </div>
                    </div>
                    <div class="commentary_divs_body">
                        <h2>Sample Niche</h2>
                        <h3>Hardware Supply Chain Threats Can Undermine Endpoint Infrastructure</h3>
                        <div class="commentary_divs_body_subdiv">
                            <p>Sept 12th 2023</p>
                            <p><i class="fa fa-clock" aria-hidden="true"></i>
                            10mins read.</p>
                        </div>
                    </div>
                </a>
                <a class="commentary_divs">
                    <div class='commentary_divs_imagediv'>
                        <img src="images/chibs.jpg" alt="Commentary's Image" />
                        <div class="commentary_divs_imagediv_subdiv">
                            <h1>Aniagolu Chiemelie</h1>
                            <p>Chief Technologist for Security Research and Innovation, HP Inc. Security Labs.</p>
                        </div>
                    </div>
                    <div class="commentary_divs_body">
                        <h2>Sample Niche</h2>
                        <h3>Hardware Supply Chain Threats Can Undermine Endpoint Infrastructure</h3>
                        <div class="commentary_divs_body_subdiv">
                            <p>Sept 12th 2023</p>
                            <p><i class="fa fa-clock" aria-hidden="true"></i>
                            10mins read.</p>
                        </div>
                    </div>
                </a>
                <a class="commentary_divs">
                    <div class='commentary_divs_imagediv'>
                        <img src="images/chibs.jpg" alt="Commentary's Image" />
                        <div class="commentary_divs_imagediv_subdiv">
                            <h1>Aniagolu Chiemelie</h1>
                            <p>Chief Technologist for Security Research and Innovation, HP Inc. Security Labs.</p>
                        </div>
                    </div>
                    <div class="commentary_divs_body">
                        <h2>Sample Niche</h2>
                        <h3>Hardware Supply Chain Threats Can Undermine Endpoint Infrastructure</h3>
                        <div class="commentary_divs_body_subdiv">
                            <p>Sept 12th 2023</p>
                            <p><i class="fa fa-clock" aria-hidden="true"></i>
                            10mins read.</p>
                        </div>
                    </div>
                </a>
                <a class="commentary_divs">
                    <div class='commentary_divs_imagediv'>
                        <img src="images/chibs.jpg" alt="Commentary's Image" />
                        <div class="commentary_divs_imagediv_subdiv">
                            <h1>Aniagolu Chiemelie</h1>
                            <p>Chief Technologist for Security Research and Innovation, HP Inc. Security Labs.</p>
                        </div>
                    </div>
                    <div class="commentary_divs_body">
                        <h2>Sample Niche</h2>
                        <h3>Hardware Supply Chain Threats Can Undermine Endpoint Infrastructure</h3>
                        <div class="commentary_divs_body_subdiv">
                            <p>Sept 12th 2023</p>
                            <p><i class="fa fa-clock" aria-hidden="true"></i>
                            10mins read.</p>
                        </div>
                    </div>
                </a>
                <a class="commentary_divs">
                    <div class='commentary_divs_imagediv'>
                        <img src="images/chibs.jpg" alt="Commentary's Image" />
                        <div class="commentary_divs_imagediv_subdiv">
                            <h1>Aniagolu Chiemelie</h1>
                            <p>Chief Technologist for Security Research and Innovation, HP Inc. Security Labs.</p>
                        </div>
                    </div>
                    <div class="commentary_divs_body">
                        <h2>Sample Niche</h2>
                        <h3>Hardware Supply Chain Threats Can Undermine Endpoint Infrastructure</h3>
                        <div class="commentary_divs_body_subdiv">
                            <p>Sept 12th 2023</p>
                            <p><i class="fa fa-clock" aria-hidden="true"></i>
                            10mins read.</p>
                        </div>
                    </div>
                </a>
                <a class="commentary_divs">
                    <div class='commentary_divs_imagediv'>
                        <img src="images/chibs.jpg" alt="Commentary's Image" />
                        <div class="commentary_divs_imagediv_subdiv">
                            <h1>Aniagolu Chiemelie</h1>
                            <p>Chief Technologist for Security Research and Innovation, HP Inc. Security Labs.</p>
                        </div>
                    </div>
                    <div class="commentary_divs_body">
                        <h2>Sample Niche</h2>
                        <h3>Hardware Supply Chain Threats Can Undermine Endpoint Infrastructure</h3>
                        <div class="commentary_divs_body_subdiv">
                            <p>Sept 12th 2023</p>
                            <p><i class="fa fa-clock" aria-hidden="true"></i>
                            10mins read.</p>
                        </div>
                    </div>
                </a>
            </div>
        </section>
        <section class="section3">
        <center>
            <div class="section3__div1 border-gradient-bottom--lightdark">
                <h1>Press Releases</h1>
                <a href="pages/pressreleases.php" class="section2__div2__link mainheader__signupbtn">View All</a>
            </div>
            <div class="section3__div2">
                <a class="section3__div2__article1">
                    <img src="images\image1.jpeg" alt="article image">
                    <div class="section3__subdiv">
                        <h1 class="section3__subdiv-h1">Sample Niche</h1>
                        <h2 class="section3__subdiv-h2">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                        <div class="section3__subdiv_subdiv">
                            <p>June 13, 2024</p>
                            <p>10 mins read.</p>
                        </div>
                    </div>
                </a>
                <a class="section3__div2__article2">
                <img src="images\image1.jpeg" alt="article image">
                <div class="section3__subdiv">
                    <h1 class="section3__subdiv-h1">Sample Niche</h1>
                    <h2 class="section3__subdiv-h2">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                    <div class="section3__subdiv_subdiv">
                        <p>June 13, 2024</p>
                        <p>10 mins read.</p>
                    </div>
                </div>
                </a>
                <a class="section3__div2__article3">
                <img src="images\image1.jpeg" alt="article image">
                <div class="section3__subdiv">
                    <h1 class="section3__subdiv-h1">Sample Niche</h1>
                    <h2 class="section3__subdiv-h2">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                    <div class="section3__subdiv_subdiv">
                        <p>June 13, 2024</p>
                        <p>10 mins read.</p>
                    </div>
                </div>
                </a>
                <a class="section3__div2__article4">
                <img src="images\image1.jpeg" alt="article image">
                <div class="section3__subdiv">
                    <h1 class="section3__subdiv-h1">Sample Niche</h1>
                    <h2 class="section3__subdiv-h2">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                    <div class="section3__subdiv_subdiv">
                        <p>June 13, 2024</p>
                        <p>10 mins read.</p>
                    </div>
                </div>
                </a>
                <a class="section3__div2__article5">
                <img src="images\image1.jpeg" alt="article image">
                <div class="section3__subdiv">
                    <h1 class="section3__subdiv-h1">Sample Niche</h1>
                    <h2 class="section3__subdiv-h2">Microsoft, Late to the Game on Dangerous DNSSEC Zero-day flaw.</h2>
                    <div class="section3__subdiv_subdiv">
                        <p>June 13, 2024</p>
                        <p>10 mins read.</p>
                    </div>
                </div>
                </a>
            </div>
        </center>
        </section>
        <?php include("includes/footer.php");?>
        <script src="index.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            function submitPost() {
                const subscribeBox = document.getElementById('susbribe-box');
                const formData = new FormData(subscribeBox);
                fetch('index.php', {
                    method: 'POST',
                    body: formData
                    })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }
                    })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error occurred while subscription.'
                    });
                });
            }
        </script>
    </body>
</html>