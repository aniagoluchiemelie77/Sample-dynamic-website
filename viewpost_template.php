<?php
session_start();
require('../connect.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
// Get the post ID from the URL
$post_title = isset($_GET['title']) ? intval($_GET['title']) : 0;
if ($post_title > 0) {
    $getposts_sql = " SELECT * FROM posts WHERE title = $post_title LIMIT 1";
    $getpaidposts_sql = " SELECT * FROM paid_posts WHERE title = $post_title LIMIT 1";
    $getnews_sql = " SELECT * FROM news WHERE title = $post_title LIMIT 1";
    $getcommentary_sql = " SELECT * FROM commentaries WHERE title = $post_title LIMIT 1";
    $getpressrelease_sql = " SELECT * FROM press_releases WHERE title = $post_title LIMIT 1";
    $getposts_result = $conn->query($getposts_sql);
    $getpaidposts_result = $conn->query($getpaidposts_sql);
    $getnews_result = $conn->query($getnews_sql);
    $getcommentary_result = $conn->query($getcommentary_sql);
    $getpressrelease_result = $conn->query($getpressrelease_sql);
    if ($getposts_result->num_rows > 0 || $getpaidposts_result->num_rows > 0 || $getnews_result->num_rows > 0 || $getcommentary_result->num_rows > 0 || $getpressrelease_result->num_rows > 0) {
        $row = $getposts_result->fetch_assoc() || $getpaidposts_result->fetch_assoc() || $getnews_result->fetch_assoc() || $getcommentary_result->fetch_assoc() || $getpressrelease_result->fetch_assoc();
        $time = $row['time'];
        $formatted_time = date("g:i A", strtotime($time));
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="Article website" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu chiemelie"/>
    <link rel="stylesheet" href="../index.css"/>
	<title><?php echo $row['niche'];?> </title>
</head>
<body>
    <?php require("../includes/header2.php");?>
    <div class="ads_bar"></div>
    <div class="body_container">
        <div class="body_left">
            <div class="page_links">
                <a href="../">Home</a> > <a href="../pages/<?php echo $row['niche'];?>.php"><?php echo $row['niche'];?></a> > <p><?php echo $row['title'];?></p>
            </div>
            <div class="body_left_relatedniches">
                <a>Artificial Intelligence</a>
                <a>Cloud Computing</a>
                <a>Data Analytics</a>
                <a>Cybersecurity</a>
            </div>
            <h1 class="Post_header"><?php echo $row["title"];?></h1>
            <h2><?php echo $row["subtitle"];?></h2>
            <div class="authors_div">
                <div class="authors_div_imgbox">
                    <img src="../images\chibs.jpg" alt="Author's Image"/>
                    <p><span class="span1">Aniagolu Chiemelie, Contributing Writer.</span> <span class="span3"><?php echo $row["formatted_date"];?></span><span class="span3"><?php echo $formatted_time;?></span></p>
                </div>
                <div class="authors_div_otherdiv">
                    <i class="fa fa-clock" aria-hidden="true"></i>
                    <p>10 mins read.</p>
                </div>
            </div>
            <div class="post_image_div">
                <img src="../images/<?php echo $row["image"];?>" alt="Post Image"/>
                <span>Source: Getty Images</span>
            </div>
            <div class="socialmedia_links">
                <a><i class="fa-brands fa-x-twitter"></i></a>
                <a><i class="fab fa-facebook" aria-hidden="true"></i></a>
                <a><i class="fab fa-linkedin" aria-hidden="true"></i></a>
                <a><i class="fab fa-reddit-alien" aria-hidden="true"></i></a>
                <a><i class="fa fa-print" aria-hidden="true"></i></a>
                <a><i class="fa fa-envelope" aria-hidden="true"></i></a>
            </div>
            <p><?php echo $row["content"];?></p>
            <div class="socialmedia_links">
            <a><i class="fa-brands fa-x-twitter"></i></a>
                <a><i class="fab fa-facebook" aria-hidden="true"></i></a>
                <a><i class="fab fa-linkedin" aria-hidden="true"></i></a>
                <a><i class="fab fa-reddit-alien" aria-hidden="true"></i></a>
                <a><i class="fa fa-print" aria-hidden="true"></i></a>
                <a><i class="fa fa-envelope" aria-hidden="true"></i></a>
            </div>
            <h3 class="bodyleft_header3">About the Author</h3>
            <center>
                <a href="../authors/author.php" class="aboutauthor_div">
                    <div class="aboutauthor_div_subdiv1">
                        <img src="../images/chibs.jpg" alt ="Author's Image"/>
                    </div>
                    <div class="aboutauthor_div_subdiv2">
                        <p class="p--bold">Aniagolu Chiemelie, Contributing Writer</p>
                        <p>Nate Nelson is a freelance writer based in New York City. Formerly a reporter at Threatpost, he contributes to a number of cybersecurity blogs and podcasts. He writes "Malicious Life" -- an</p>
                    </div>
                </a>
                <?php 
                        } else {
                            echo "Post not found.";
                        }
                    } else {
                        echo "Invalid post ID.";
                    }
                ?>
                <div class = "subscribe_div">
                    <p>Keep up with the latest cybersecurity threats, newly discovered vulnerabilities, data breach information, and emerging trends. Delivered daily or weekly right to your email inbox.
                    </p>
                    <a class ="mainheader__signupbtn">Subscribe</a>
                </div>
            </center>
            <h1 class="bodyleft_header3 border-gradient-bottom--lightdark">You may also like</h1>
            <div class="more_posts">
                <a class="more_posts_subdiv" href="#">
                    <img src="../images/66b7389276868Bigdata_artificial_intelligence.png" alt = "Post's Image"/>
                    <div class="more_posts_subdiv_subdiv">
                        <h1>Patch Now: Second SolarWinds Critical Bug in Web Help Desk</h1>
                        <span>June 24th 2024.</span>
                    </div>
                    <p class="posts_div_niche">Cybersecurity</p>
                </a>
                <a class="more_posts_subdiv" href="#">
                    <img src="../images/66b7389276868Bigdata_artificial_intelligence.png" alt = "Post's Image"/>
                    <div class="more_posts_subdiv_subdiv">
                        <h1>Patch Now: Second SolarWinds Critical Bug in Web Help Desk</h1>
                        <span>June 24th 2024.</span>
                    </div>
                    <p class="posts_div_niche">Cybersecurity</p>
                </a>
                <a class="more_posts_subdiv" href="#">
                    <img src="../images/66b7389276868Bigdata_artificial_intelligence.png" alt = "Post's Image"/>
                    <div class="more_posts_subdiv_subdiv">
                        <h1>Patch Now: Second SolarWinds Critical Bug in Web Help Desk</h1>
                        <span>June 24th 2024.</span>
                    </div>
                    <p class="posts_div_niche">Cybersecurity</p>
                </a>
                <a class="more_posts_subdiv" href="#">
                    <img src="../images/66b7389276868Bigdata_artificial_intelligence.png" alt = "Post's Image"/>
                    <div class="more_posts_subdiv_subdiv">
                        <h1>Patch Now: Second SolarWinds Critical Bug in Web Help Desk</h1>
                        <span>June 24th 2024.</span>
                    </div>
                    <p class="posts_div_niche">Cybersecurity</p>
                </a>
                <a class="more_posts_subdiv" href="#">
                    <img src="../images/66b7389276868Bigdata_artificial_intelligence.png" alt = "Post's Image"/>
                    <div class="more_posts_subdiv_subdiv">
                        <h1>Patch Now: Second SolarWinds Critical Bug in Web Help Desk</h1>
                        <span>June 24th 2024.</span>
                    </div>
                    <p class="posts_div_niche">Cybersecurity</p>
                </a>
                <a class="more_posts_subdiv" href="#">
                    <img src="../images/66b7389276868Bigdata_artificial_intelligence.png" alt = "Post's Image"/>
                    <div class="more_posts_subdiv_subdiv">
                        <h1>Patch Now: Second SolarWinds Critical Bug in Web Help Desk</h1>
                        <span>June 24th 2024.</span>
                    </div>
                    <p class="posts_div_niche">Cybersecurity</p>
                </a>
            </div>
        </div>
        <div class="body_right border-gradient-leftside--lightdark">
            <div class="ads_sidebar"></div>
            <h3 class="bodyleft_header3 border-gradient-bottom--lightdark">Editor's Picks</h3>
            <a class="posts_div" href="#">
                <img src="../images/chibs.jpg" alt="Post's Image"/>
                <p class="posts_div_niche">Cybersecurity</p>
                <h1>Unfixed Microsoft Entra ID Authentification Bypass Threatens Hybrid IDs.</h1>
                <p class="posts_div_otherp">By, <span>Chiemelie Aniagolu, Contributing Writer.</span></p>
                <div class="posts_div_subdiv">
                    <p>Aug 15th, 2024</p>
                    <p>10mins Read.</p>
                </div>
            </a>
            <a class="posts_div" href="#">
                <img src="../images/chibs.jpg" alt="Post's Image"/>
                <p class="posts_div_niche">Cybersecurity</p>
                <h1>Unfixed Microsoft Entra ID Authentification Bypass Threatens Hybrid IDs.</h1>
                <p class="posts_div_otherp">By, <span>Chiemelie Aniagolu, Contributing Writer.</span></p>
                <div class="posts_div_subdiv">
                    <p>Aug 15th, 2024</p>
                    <p>10mins Read.</p>
                </div>
            </a>
            <a class="posts_div" href="#">
                <img src="../images/chibs.jpg" alt="Post's Image"/>
                <p class="posts_div_niche">Cybersecurity</p>
                <h1>Unfixed Microsoft Entra ID Authentification Bypass Threatens Hybrid IDs.</h1>
                <p class="posts_div_otherp">By, <span>Chiemelie Aniagolu, Contributing Writer.</span></p>
                <div class="posts_div_subdiv">
                    <p>Aug 15th, 2024</p>
                    <p>10mins Read.</p>
                </div>
            </a>
            <?php
                $userEmail = " ";
                if(isset($_POST['submit_btn'])){
                    $message = "<div><h1><br>Thank you for subscribing with us.</br></h1>
                        <p>Thank you for subscribing to our email updates, We will keep you updated with the latest updates and information.</p>
                         </div>";
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
                        if($mail->preSend()){
                            $msg = "Thank You For Subscribing With Us.";
                        }
                    }else{
                        $msg = "Invalid Email";
                    }
                
                }
                include('../helpers/emailsubscribeform.php');
            ?>
        </div>
    </div>
    <?php include("../includes/footer2.php");?>
    <script src="../index.js"></script>
</body>
</html>