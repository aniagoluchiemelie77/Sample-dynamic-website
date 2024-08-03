<?php
session_start();
include("../connect.php")
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
	<title>Edit Profile</title>
</head>
<body>
<header class="header">
        <div class="header_logobox">
            <img src="#" alt="Website Logo">
        </div>
        <form class="header_searchbar" action="" method="get">
            <input type="text" name="search" placeholder="Search.." />
            <a class="fa fa-search" aria-hidden="true">
            </a>
        </form>
        <div class="header_img">
            <a class="notification" href="../view_all/notification.php">
                <span></span>
                <i class="fa fa-bell" aria-hidden="true"></i>
            </a>
            <img src="images\image1.jpeg" alt="Author's Image"/>
        </div>
    </header>
    <div class="editprofile_container">
    <form class="create_editor_container" action="forms.php" method="post">
        <div class="createeditor_inputgroup">
            <h1 class="bigheader">Edit Profile</h1>
        </div>
        <div class="createeditor_inputgroup">
            <label class="createeditor_label rightmargin" for="profile_firstname">Firstname:</label>
            <input class="createeditor_input" type="text" name="profile_firstname" required/>
        </div>
        <div class="createeditor_inputgroup">
            <label class="createeditor_label rightmargin" for="profile_lastname">Lastname:</label>
            <input class="createeditor_input" type="text" name="profile_lastname" required/>
        </div>
        <div class="createeditor_inputgroup">
            <label class="createeditor_label rightmargin" for="profile_username">Username:</label>
            <input class="createeditor_input" type="text" name="profile_username" required/>
        </div>
        <div class="createeditor_inputgroup">
            <label class="createeditor_label rightmargin" for="profile_email">Email:</label>
            <input class="createeditor_input" type="email" name="profile_email" required/>
        </div>
        <div class="createeditor_inputgroup flexcolumn">
            <label class="createeditor_label rightmargin nooutline" for="profile_bio">Bio:</label>
            <textarea name="profile_bio" class="textarea"></textarea>
        </div>
        <div class="createeditor_inputgroup">
            <label class="createeditor_label rightmargin" for="profile-address1">Address 1:</label>
            <input class="createeditor_input" type="text" name="profile-address1" required/>
        </div>
        <div class="createeditor_inputgroup">
            <label class="createeditor_label rightmargin" for="profile-address2">Address 2:</label>
            <input class="createeditor_input" type="text" name="profile-address2" required/>
        </div>
        <div class="createeditor_inputgroup">
            <label class="createeditor_label rightmargin" for="profile-city">City:</label>
            <input class="createeditor_input" type="text" name="profile-city" required/>
        </div>
        <div class="createeditor_inputgroup">
            <label class="createeditor_label rightmargin" for="profile-state">State:</label>
            <input class="createeditor_input" type="text" name="profile-state" required/>
        </div>
        <div class="createeditor_inputgroup">
            <label class="createeditor_label rightmargin" for="profile-country">Country:</label>
            <input class="createeditor_input" type="text" name="profile-country" required/>
        </div>
        <div class="createeditor_inputgroup">
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile-countrycode">Country Code:</label>
                <input class="createeditor_input" type="text" name="profile-countrycode" required/>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile-mobile">Phone Number:</label>
                <input class="createeditor_input" type="number" name="profile-mobile" required/>
            </div>
        </div>
        <input class="createeditor_input-submit" value="Submit" name="profileedit_Submit" type="submit"/>
    </form>
    </div>
</body>
</html>