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
	<title>Drafts</title>
</head>
<body>
<?php require("../extras/header.php");?>
    <section class="newpost_body">
        <form class="newpost_container" method="post" action="../forms.php" enctype="multipart/form-data" id="postForm">
            <div class="newpost_container_div1 newpost_subdiv">
                <h1>New Draft</h1>
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
                    <input class="form__input" name="Post_Sub_Title" type="text"/>
                    <p class="newpost_subdiv2-p leftp"><span>*</span>Text displayed under title (OPTIONAL)</p>
                </div>
            </div>
            <div class="newpost_container_div5 newpost_subdiv">
                <label class="form__label" for="Post_featured">Featured Video/Audio:</label>
                <div class="newpost_container_div5_subdiv2">
                    <input class="form__input" name="Post_featured" type="text"/>
                    <p class="newpost_subdiv2-p leftp"><span>*</span>Enter url to video/audio (optional)</p>
                </div>
            </div>
            <div class="newpost_container_div6 newpost_subdiv">
                <label class="form__label" for="Post_Image">Draft Post's Image</label>
                <div class="newpost_subdiv2">
                    <input class="form__input" name="Post_Image" type="file" required/>
                    <p class="newpost_subdiv2-p leftp"><span>*</span>Image should be less than 300KB</p>
                </div>
            </div>
            <div class="newpost_container_div7 newpost_subdiv">
                <label class="form__label" for="Post_Content">Draft Post's Content:</label>
                <textarea class="newpost_container_div7_subdiv2" name="Post_content" id="workspace_area">
                </textarea>
            </div>
            <div class="newpost_container_div3 newpost_subdiv">
                <label class="form__label" for="author_firstname">Author's Firstname:</label>
                <div class="newpost_container_div3_subdiv2">
                    <input class="form__input" name="author_firstname" type="text"/>
                    <p class="newpost_subdiv2-p leftp"><span>*</span> Author's First Name (OPTIONAL)</p>
                </div>
            </div>
            <div class="newpost_container_div3 newpost_subdiv">
                <label class="form__label" for="author_lastname">Author's Lastname:</label>
                <div class="newpost_container_div3_subdiv2">
                    <input class="form__input" name="author_lastname" type="text"/>
                    <p class="newpost_subdiv2-p leftp"><span>*</span> Author's Last Name (OPTIONAL)</p>
                </div>
            </div>
            <div class="newpost_container_div7 newpost_subdiv">
                <label class="form__label" for="about_author">About Author:</label>
                <textarea class="newpost_container_div7_subdiv2b" name="about_author">
                </textarea>
                <p class="newpost_subdiv2-p leftp"><span>*</span> About Author (OPTIONAL)</p>
            </div>
            <div class="newpost_container_div9 newpost_subdiv">
                <input class="form__submit_input" type="submit" value="Save" name="create_draft" onclick="submitPost()"/>
            </div>
        </form>
    </section>
    <script type="text/javascript" src="https://cdn.tiny.cloud/1/mshrla4r3p3tt6dmx5hu0qocnq1fowwxrzdjjuzh49djvu2p/tinymce/6/tinymce.min.js"></script>
    <script src="../admin.js"></script>
    <script>
        tinymce.init({
            selector: '#workspace_area',
            width: 800,
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