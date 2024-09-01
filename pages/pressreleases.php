<?php
session_start();
//$id = $_GET["ID"];
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
	<title>Press Releases</title>
</head>
<body>
    <?php require("../includes/header.php");?>
    <div class="ads_bar"></div>
    <div class="body_container">
        <div class="body_left">
            <h1 class="Post_header">DARK READING NEWSLETTER</h1>
            <h2>Register for Your Free Newsletter Now:</h2>
            <div class = "subscribe_div">
                <p>Your keyhole into the chaos and mystery of network and data security. Delivered daily or weekly, our newsletters are chock-full of product and industry news, threat reports, vulnerability discoveries, compliance issues, and user experiences. In addition, there's also our enlightened and insightful commentary.</p>
            </div>
            <h2>Offered Free by: Dark Reading</h2>
            <form class="formcontainer">
                <div class="head_paragraph">
                    <h3>Complete the form below:</h3>
                </div>
                <div class="formcontainer_subdiv">
                    <div class="input_group">
                    <label for ="email">Email</label>
                    <input type="email" name="email" required/>
                    </div>
                    <div class="input_group">
                        <label for ="firstname">First Name</label>
                        <input type="text" name="firstname" required/>
                    </div>
                    <div class="input_group">
                    <label for ="lastname">Last Name</label>
                    <input type="text" name="lastname" required/>
                    </div>
                    <div class="input_group">
                    <label for ="companyname">Company Name</label>
                    <input type="text" name="companyname" required/>
                    </div>
                    <div class="input_group">
                    <label for ="jobtitle">Job Title</label>
                    <input type="text" name="jobtitle" required/>
                    </div>
                    <div class="input_group">
                    <label for ="mobile">Mobile</label>
                    <input type="text" name="mobile" required/>
                    </div>
                </div>
                <div class="formcontainer_subdiv">
                    <p>In return for this content, I agree to the Informa Group and/or Dark Reading contacting me (including by email) about this and other subject matter matching my interests. I understand that I can opt-out at any time by clicking 'unsubscribe' on emails or contacting Informa as set out in our <a>Privacy Policy.</a></p>
                </div>
                <div class="formcontainer_subdiv">
                    <p>Checkboxes</p>
                </div>
                <input class="formcontainer_submit" value="Submit" type="submit"/>
            </form>
        </div>
        <div class="body_right border-gradient-leftside--lightdark">
            <div class="ads_sidebar"></div>
            <h3 class="bodyleft_header3 border-gradient-bottom--lightdark">Top Posts</h3>
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
        </div>
    </div>
    <?php include("../includes/footer.php");?>
    <script src="../index.js"></script>
</body>
</html>