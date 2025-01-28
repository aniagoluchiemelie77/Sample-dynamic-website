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
	<title>Customise Webpage</title>
</head>
<body>
    <?php require("../extras/header2.php");?>
    <section class="sectioneer">
       <div class='pages_container'>
            <div class="page_links">
                <a href="../admin_homepage.php">Home</a> > <p>Settings</p> > <p>Customise Website</p>
            </div>
            <h1>Actions</h1>
            <div class="pages_container_subdiv">
                <a class='pages_container_subdiv-links' href="pages/categories.php">
                    <p>Change Theme</p>
                </a>
            </div>
            <div class="pages_container_subdiv">
                <a class='pages_container_subdiv-links' href="pages/advertisewithus.php">
                    <p>Edit Messages</p>
                </a>
            </div>
            <div class="pages_container_subdiv">
                <a class='pages_container_subdiv-links' href="pages/privacypolicy.php">
                    <p>Edit Website Features (logo, Image..)</p>
                </a>
            </div>
        </div>
    </section>
</body>
</html>