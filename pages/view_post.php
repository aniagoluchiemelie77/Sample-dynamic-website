<?php
session_start();
require("../connect.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
//$id = $_GET['id'];

// Get the post ID from the URL
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($post_id > 0) {
    $sql = "
        SELECT title, niche, image, content, DATE_FORMAT(date, '%M %d, %Y') as formatted_date
        FROM paid_posts
        WHERE id = $post_id
    ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<div class='post-details'>
                <h1>" . $row["title"] . "</h1>
                <p><strong>Niche:</strong> " . $row["niche"] . "</p>
                <img src='" . $row["image"] . "' alt='" . $row["title"] . "' />
                <p><strong>Date:</strong> " . $row["formatted_date"] . "</p>
                <div class='content'>" . $row["content"] . "</div>
              </div>";
    } else {
        echo "Post not found.";
    }
} else {
    echo "Invalid post ID.";
}

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
	<title>View post</title>
</head>
<body>
    <?php require("../includes/header2.php");?>
    <div class="ads_bar"></div>
    <div class="body_container">
        <div class="body_left">
            <div class="page_links">
                <a href="../">Home</a> > <p>View Post</p>
            </div>
            <div class="body_left_relatedniches">
                <a>Artificial Intelligence</a>
                <a>Cloud Computing</a>
                <a>Data Analytics</a>
                <a>Cybersecurity</a>
            </div>
            <h1 class="Post_header">Patch Now: Second SolarWinds Critical Bug in Web Help Desk</h1>
            <h2>The disclosure of CVE-2024-28987 means that, in two weeks, there have been two critical bugs and corresponding patches for SolarWinds' less-often-discussed IT help desk software.</h2>
            <div class="authors_div">
                <div class="authors_div_imgbox">
                    <img src="../images\chibs.jpg" alt="Author's Image"/>
                    <p><span class="span1">Aniagolu Chiemelie, Contributing Writer.</span> <span class="span3">August 23, 2024.</span></p>
                </div>
                <div class="authors_div_otherdiv">
                    <i class="fa fa-clock" aria-hidden="true"></i>
                    <p>10 mins read.</p>
                </div>
            </div>
            <div class="post_image_div">
                <img src="../images/image1.jpeg" alt="Post Image"/>
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
            <p>
                For the second week in a row, SolarWinds has released a patch for a critical vulnerability in its IT help and ticketing software, Web Help Desk (WHD). According to its latest hotfix notice, the issue — tracked as CVE-2024-28987 — concerns hardcoded credentials that could allow a remote, unauthenticated attacker to break into WHD and modify data.
                "Security is hard and a continuous process," says Horizon3.ai vulnerability researcher Zach Hanley, who first discovered and reported the bug. "This application had just received a security look from being exploited in the wild, and a few years [before] had a different hardcoded credential vulnerability. Regular security reviews on the same application can still be valuable for companies."
                Two Critical Bugs & Two Urgent Fixes 
                <span class="inline_adsbar"></span>
                On Aug. 13, SolarWinds released a hotfix for CVE-2024-28986, a Java deserialization issue that could have allowed an attacker to run commands on a targeted machine. It was given a "critical" 9.8 out of 10 score on the CVSS scale. Following what the company described as "thorough testing," it was unable to prove that the issue could be exploited by an unauthenticated attacker. But just two days after news of it broke, CISA added CVE-2024-28986 to its catalog of known exploited vulnerabilities, indicating that active exploitation by threat actors was already underway.
                This week, the company followed up this initial bad news with more of the same, this time concerning a second vulnerability in the same program. In this case, there was no ambiguity that an unauthenticated attacker could leverage hardcoded credentials in WHD to access internal functionalities and data, which goes some way to justifying its "critical" 9.1 CVSS score.
                Contrary to other reporting, CVE-2024-28987 was not first introduced in the patch for CVE-2024-28986. "This issue has existed for some time in the product, likely for several years," Hanley reports. SolarWinds declined to provide Dark Reading with further comment.
                SolarWinds' newest patch incorporates fixes for both issues. Customers are advised to update immediately. To hammer the point home, Hanley says, "Imagine if an attacker had access to all the details in help desk tickets — what sensitive information may they be able to extract? Credentials, business operations details, etc."

            </p>
            <div class="socialmedia_links">
                <a><i class="fa-brands fa-x-twitter"></i></a>
                <a class="fab fa-facebook" aria-hidden="true"></a>
                <a class="fab fa-linkedin" aria-hidden="true"></a>
                <a class="fab fa-reddit-alien" aria-hidden="true"></a>
                <a class="fa fa-print" aria-hidden="true"></a>
                <a class="fa fa-envelope" aria-hidden="true"></a>
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
            ?>
            <form class="sec2__susbribe-box other_width" method="post" action="view_post.php">
                <div class="icon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                <h1 class="sec2__susbribe-box-header">Subscribe to Updates</h1>
                <p class="sec2__susbribe-box-p1">Get the latest Updates and Info from Uniquetechcontentwriter on Cybersecurity, Artificial Intelligence and lots more.</p>
                <p class="error_div"><?php if(!empty($msg)){ echo $msg;}?></p>
                <input class="sec2__susbribe-box_input" type="text" placeholder="Your Email Address..." name="email" required/>
                <input class="sec2__susbribe-box_btn" type="submit" value="Submit" name="submit_btn"/>
            </form>
        </div>
    </div>
    <?php include("../includes/footer2.php");?>
    <script src="../index.js"></script>
</body>
</html>