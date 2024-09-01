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
    <?php require("../extras/header.php");?>
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
            <div class="newpost_body_addition">
                <input class="form__input1" name="Post_Block" type="text" placeholder="Type / to choose a block.."/> 
                <div class="newpost_body_addition_subdiv">
                    <div class="div1">
                        <input class="form__input" name="search" type="text" placeholder="Search.."/> 
                        <button class="fa fa-search" type="submit"></button>
                    </div>
                    <div class="div2">
                        <i class="fa fa-paragraph" aria-hidden="true"></i>
                        <span>Paragraph</span>
                    </div>
                    <div class="div3">
                        <i class="fa fa-file" aria-hidden="true"></i>
                        <span>Images</span>
                    </div>
                    <div class="div4">
                        <i class="fa fa-bookmark" aria-hidden="true"></i>
                        <span>Heading</span>
                    </div>
                    <div class="div5">
                        <i class="fa fa-list" aria-hidden="true"></i>
                        <span>Lists</span>
                    </div>
                    <div class="div6">
                        <i class="fa fa-quote-right" aria-hidden="true"></i>
                        <span>Quotes</span>
                    </div>
                    <div class="div7">
                        <i class="fa fa-table" aria-hidden="true"></i>
                        <span>Tables</span>
                    </div>
                    <a class="div8">View All</a>
                </div>
            </div>
            <div class="newpost_container_div3 newpost_subdiv">
                <label class="form__label" for="Post_Sub_Title">Sub Title:</label>
                <div class="newpost_container_div3_subdiv2">
                    <input class="form__input" name="Post_Sub_Title" type="text"/>
                    <p class="newpost_subdiv2-p"><span>*</span>Text displayed under title (OPTIONAL)</p>
                </div>
            </div>
            <div class="newpost_container_div4 newpost_subdiv">
                <label class="form__select" for="Post_Status">Status:</label>
                <select class="newpost_subdiv2" name="Post_Status">      
                    <option class="newpost_subdiv4-option" value="">-- Please Select --</option>      
                    <option class="newpost_subdiv4-option" value="none">None</option>
                    <option class="newpost_subdiv4-option" value="paid_post">Paid Post</option>
                </select>
            </div>
            <div class="newpost_container_div5 newpost_subdiv">
                <label class="form__label" for="Post_featured">Featured Video/Audio:</label>
                <div class="newpost_container_div5_subdiv2">
                    <input class="form__input" name="Post_featured" type="text"/>
                    <p class="newpost_subdiv2-p"><span>*</span>Enter url to video/audio (optional)</p>
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
                <label class="form__label" for="Post_Content">Post Content:</label>
                <textarea class="newpost_container_div7_subdiv2" name="Post_content">
                </textarea>
            </div>
            <div class="newpost_container_div9 newpost_subdiv">
                <input class="form__submit_input" type="submit" value="Publish" name="create_post" />
            </div>
        </form>
    </section>
</body>
</html>