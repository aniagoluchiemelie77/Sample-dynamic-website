<?php
    session_start();
    require("../connect.php");
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
	<title>Contact Us</title>
</head>
<body>
    <?php require("../includes/header2b.php");?>
    <div class="body_container">
        <div class="body_right">
            <div class="sidebar_divs_container">
                <div class="webinfo">
                    <h1>Uniquecontentwriter</h1>
                    <img src="../images\image1.jpeg" alt="Blog's Coverphoto"/>
                    <p>Here at Uniquecontentwriter.com, we give you the latest news and updates on Cybersecurity, Artificial Intelligence and lots more.</p>
                </div>
            </div>
            <?php include("../helpers/emailsubscribeform.php");?>
        </div>
        <div class="body_left border-gradient-leftside--lightdark">
            <div class="page_links">
                <a href="../">Home</a> > <p>Contact Us</p>
            </div>
            <h3 class="bodyleft_main">Contact Us</h3>
            <div class="sidebar_divs_container thickdiv">
                <p>Hullo.</p>
            </div>
        </div>
    </div>
    <?php include("../includes/footer2.php");?>
    <script src="../index.js"></script>
</body>
</html>