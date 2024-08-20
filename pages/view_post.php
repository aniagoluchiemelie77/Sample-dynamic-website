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
	<title>View post</title>
</head>
<body>
    <header class="header">
        <center>
            <div class="mainheader">
            <div class="mainheader__header-nav">
                <a class="mainheader__header-nav-1" href="../">
                    <i class="fa fa-home" aria-hidden="true"></i>
                </a>
                <a class="mainheader__header-nav-2" id="searchicon">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </a>
            </div>
            <div class="mainheader__logobox">
                <img src="#" alt="companylogo">
            </div>
            <a class="mainheader__signupbtn">Newsletter Signup</a>
            </div>
        </center>
        <center>
            <form class="header_searchbar hidden" action="forms.php" method="get" id="search_form">
                <input type="text" name="search" placeholder="Search.." />
                <button class="fa fa-search" id="tutorial_name" aria-hidden="true" name="search_btn" type="submit" formenctype="text/plain"></button>
            </form>
        </center>
        <center>
    </header>
    <div class="ads_bar"></div>
    <div class="body_container">
        <div class="body_left"></div>
        <div class="body_right"></div>
    </div>
    <script src="../index.js"></script>
</body>
</html>