<?php
session_start();
include("../connect.php");
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
	<title>Create New Post</title>
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
            <a class="notification" href="#">
                <span></span>
                <i class="fa fa-bell" aria-hidden="true"></i>
            </a>
            <img src="../images/image1.jpeg" alt="Author's Image"/>
        </div>
    </header>
    <section class="newpost_body">
        <form class="newpost_container" method="post" action="../forms.php" enctype="multipart/form-data">
            <div class="newpost_container_div1 newpost_subdiv">
                <h1>Create New Post</h1>
            </div>
            <div class="newpost_container_div2 newpost_subdiv">
                <input class="form__input input1" name="Post_Title" type="text" placeholder="Add Title.." required/>
                <div class="newpost_container_div2_subdiv2">
                    <input class="form__input" name="Post_Niche" type="text" placeholder="Niche.." required/>
                </div>
            </div>
            <div class="newpost_container_div3 newpost_subdiv">
                <label class="form__label" for="Post_Sub_Title">Sub Title:</label>
                <div class="newpost_container_div3_subdiv2">
                    <input class="form__input" name="Post_Sub_Title" type="text" required/>
                    <p class="newpost_subdiv2-p"><span>*</span>Text displayed under title</p>
                </div>
            </div>
            <div class="newpost_container_div4 newpost_subdiv">
                <label class="form__select" for="Post_Status">Status</label>
                <select class="newpost_subdiv2" name="Post_Status">      
                    <option class="newpost_subdiv4-option" value="">-- Please Select --</option>      
                    <option class="newpost_subdiv4-option" value="none">None</option>
                    <option class="newpost_subdiv4-option" value="paid_post">Paid Post</option>
                </select>
            </div>
            <div class="newpost_container_div5 newpost_subdiv">
                <label class="form__label" for="Post_featured">Featured Video/Audio</label>
                <div class="newpost_container_div5_subdiv2">
                    <input class="form__input" name="Post_featured" type="text" required/>
                    <p class="newpost_subdiv2-p">Enter url to video/audio (optional)</p>
                </div>
            </div>
            <div class="newpost_container_div6 newpost_subdiv">
                <label class="form__label" for="Post_Image">Post Image</label>
                <div class="newpost_subdiv2">
                    <input class="form__input" name="Post_Image" type="file" required/>
                    <p class="newpost_subdiv2-p"><span>*</span>Image should be less than 300KB</p>
                </div>
            </div>
            <div class="newpost_container_div7 newpost_subdiv">
                <label class="form__label" for="Post_Content">Post Content</label>
                <textarea class="newpost_container_div7_subdiv2" name="Post_content">
                </textarea>
            </div>
            <div class="newpost_container_div8 newpost_subdiv">
                <label class="form__label" for="Post_Review">Enable Review?</label>
                <div class="newpost_subdiv2">
                </div>
            </div>
            <div class="newpost_container_div9 newpost_subdiv">
                <input class="form__submit_input" type="submit" value="Publish" name="create_post" />
            </div>
        </form>
    </section>
</body>
</html>