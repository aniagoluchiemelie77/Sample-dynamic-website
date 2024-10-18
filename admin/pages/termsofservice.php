<?php
session_start();
require ("../connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="Tech News and Articles website" />
    <meta name="keywords" content="Tech News, Content Writers, Content Strategy" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu Diamaka"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../admin.css"/>
    <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdn.anychart.com/releases/8.0.1/js/anychart-core.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.0.1/js/anychart-pie.min.js"></script>
	<title>Terms of Service</title>
</head>
<body>
    <?php require("../extras/header2.php");?>
    <section class="about_section">
        <div class="page_links">
            <a href="../admin_homepage.php">Home</a> > <p>Pages</p> > <p>Terms of Services</p>
        </div>
        <div class="about_header">
            <h1>Terms of Service</h1>
        </div>
        <div class="about_contents">
            <span>
            Dark Reading: Connecting The Cybersecurity Community
            Long one of the most widely read cybersecurity news sites, Dark Reading is also the most trusted online community for security professionals like you. Our community members include thought-leading security researchers, CISOs, and technology specialists, along with thousands of other security professionals. We want you to join us. This is where enterprise security staffers and decision-makers come to learn about new cyber threats, vulnerabilities, and technology trends. It's where they learn about potential defenses against the latest attacks, and key technologies and practices that may help protect their most sensitive data in the future. It's where they come to read breaking news, deep-dive news analysis, feature articles, and special reports, as well as attend virtual events and webinars - all to help them embrace new (and big) ideas, find answers to their IT security questions, and solve their most pressing problems. Dark Reading includes 14 topical sections, each of which drills deeper into the enterprise security challenge: Cybersecurity Analytics, Cyberattacks & Data Breaches, Application Security, Cloud Security, Endpoint Security, ICS/OT Security, IoT, Cybersecurity Operations, Perimeter, Physical Security, Remote Workforce, Cyber Risk, Threat Intelligence, and Vulnerabilities & Threats. There are also two feature sections, The Edge and Dark Reading Technology, as well as our new international section, DR Global Middle East & Africa.

            Advertisement
            Each section is led by editors and subject matter experts who collaborate with security researchers, technology specialists, industry analysts and other Dark Reading members to provide timely, accurate, and informative content. Our goal is to challenge community members to think about security by providing strong, even unconventional points of view, backed by hard-nosed reporting, hands-on experience, and the professional knowledge that comes only with years of work in the information security industry. We want you to be part of this cybersecurity community. Please join us by signing up for our newsletters and participating in our polls and other interactive features -- all for free. We'll also invite you to join our live events where we can continue these conversations face-to-face.
            If you're interested in participating further, contact our editors – we're always on the lookout for industry thought leaders who'd like to offer their perspectives on IT security and its role in business.

            Contact Us
            For more details on Dark Reading’s mission and sponsorship opportunities, download the Dark Reading Media Kit. If you wish to no longer receive any promotional emails from Informa Tech, please send an email to updatemydetailsIT@informa.com.
            Title
            Name/Email
            Editor In Chief - Kelly Jackson Higgins
            Managing Editor, Features - Fahmida Y. Rashid
            Managing Editor, News - Tara Seals
            Managing Editor, Copy Desk - Jim Donahue
            Senior Editor, Features - Karen Spiegelman
            Senior Editor - Becky Bracken
            Associate Editor - Kristina Beek
            </span>
        </div>
        <button class="about_section_btn" id="Edit_about">Edit
            <i class="fa fa-pencil" aria-hidden="true"></i>
        </button>
        <form class="about_editdiv" action="../forms.php" method="post" id="hidden_aboutdiv">
            <textarea class="about_editdiv-input" name="About_content" id="myTextarea"></textarea>
            <input type="submit" value="Update" name="about_editdiv-editbtn" />
        </form>
    </section>
    <script type="text/javascript" src="https://cdn.tiny.cloud/1/mshrla4r3p3tt6dmx5hu0qocnq1fowwxrzdjjuzh49djvu2p/tinymce/6/tinymce.min.js"></script>
    <script src="../admin.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: '#myTextarea',
            width: 810,
            height: 900,
            plugins: [
                'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
                'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
                'media', 'table', 'emoticons', 'help'
            ],toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
                'forecolor backcolor emoticons | help',
            menu: {
            favs: { title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons' }
            },
            menubar: 'favs file edit view insert format tools table help',
            content_css: 'css/content.css'
        });
    </script>
</body>
</html>