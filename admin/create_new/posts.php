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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu Diamaka"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../admin.css"/>
	<title>Create New Post</title>
</head>
<body>
    <?php require("../extras/header2.php");?>
    <section class="newpost_body">
        <form class="newpost_container" method="post" action="../forms.php" enctype="multipart/form-data" id="postForm">
        <div class="page_links">
            <a href="../admin_homepage.php">Home</a> > <p>Create Post</p>
        </div>
            <div class="newpost_container_div1 newpost_subdiv">
                <h1>Create Post</h1>
            </div>
            <div class="newpost_container_div3 newpost_subdiv">
                <label class="form__label" for="Post_Title">Post Title:</label>
                <div class="newpost_container_div3_subdiv2">
                    <input class="form__input" name="Post_Title" type="text" required/>
                </div>
            </div>
            <div class="newpost_container_div3 newpost_subdiv">
                <label class="form__label" for="Post_Sub_Title">Sub Title:</label>
                <div class="newpost_container_div3_subdiv2">
                    <input class="form__input" name="Post_Sub_Title" type="text"/>
                    <p class="newpost_subdiv2-p leftp"><span>*</span>Text displayed under title (OPTIONAL)</p>
                </div>
            </div>
            <div class="newpost_container_div4 newpost_subdiv">
                <label class="form__select" for="Post_Niche">Category:</label>
                <select class="newpost_subdiv2" name="Post_Niche">
                    <option class="newpost_subdiv4-option" value="">-- Please Select --</option>
                    <?php 
                        $selectcategory = "SELECT name FROM topics ORDER BY id";
                        $selectcategory_result = $conn->query($selectcategory);
                        if ($selectcategory_result->num_rows > 0) {
                            if (!function_exists('convertToReadable')) {
                                function convertToReadable($slug) {
                                    $string = str_replace('-', ' ', $slug);
                                    $string = ucwords($string);
                                    return $string;
                                }
                            }
                            while($row = $selectcategory_result->fetch_assoc()) {
                                $category_names = $row['name'];
                                $readableString = convertToReadable($category_names);
                                echo "<option class='newpost_subdiv4-option' value='$readableString'>$readableString</option>";
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="newpost_container_div4 newpost_subdiv">
                <label class="form__select" for="Post_Status">Post Type:</label>
                <select class="newpost_subdiv2" name="Post_Status">      
                    <option class="newpost_subdiv4-option" value="">-- Please Select --</option>
                    <option class="newpost_subdiv4-option" value="paid_post">Paid Post</option>      
                    <option class="newpost_subdiv4-option" value="posts">Article</option>
                    <option class="newpost_subdiv4-option" value="news">News</option>
                    <option class="newpost_subdiv4-option" value="press_releases">Press Release</option>
                    <option class="newpost_subdiv4-option" value="commentaries">Commentary</option>
                </select>
            </div>
            <div class="newpost_container_div5 newpost_subdiv">
                <label class="form__label" for="Post_featured">Featured Video/Audio:</label>
                <div class="newpost_container_div5_subdiv2">
                    <input class="form__input" name="Post_featured" type="text"/>
                    <p class="newpost_subdiv2-p leftp"><span>*</span>Enter url to video/audio (optional)</p>
                </div>
            </div>
            <div class="newpost_container_div6 newpost_subdiv">
                <label class="form__label" for="Post_Image">Post Image</label>
                <div class="newpost_subdiv2">
                    <input class="form__input" name="Post_Image" type="file" required/>
                    <p class="newpost_subdiv2-p leftp"><span>*</span>Image should be less than 300KB</p>
                </div>
            </div>
            <div class="newpost_container_div7 newpost_subdiv">
                <label class="form__label" for="Post_Content">Post Content:</label>
                <textarea class="newpost_container_div7_subdiv2" name="Post_content" id="myTextarea">
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
                <input class="form__submit_input" type="submit" value="Publish" name="create_post"/>
            </div>
            <div class="newpost_container_div10 newpost_subdiv">
                <p class="form__submit_or centerp bold">----------- Or -----------</p>
            </div>
            <div class="newpost_container_div11 newpost_subdiv">
                <label class="form__label bold" for="schedule">Schedule Post Publish</label>
                <input class="" type="datetime-local" name="schedule" />
            </div>
        </form>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="https://cdn.tiny.cloud/1/mshrla4r3p3tt6dmx5hu0qocnq1fowwxrzdjjuzh49djvu2p/tinymce/6/tinymce.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
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
    <script>
        var messageType = "<?= $_SESSION['status_type']?? ' '?>";
        var messageText = "<?= $_SESSION['status']?? ' '?>";
        if (messageType == 'Error' && messageText != " "){
            Swal.fire({
                title: 'Error!',
                text: messageText,
                icon: 'error',
                confirmButtonText: 'Ok'
            })  
        }else if (messageType == 'Success' && messageText != " "){
            Swal.fire({
                title: 'Success',
                text: messageText,
                icon: 'success',
                confirmButtonText: 'Ok'
            })  
        }
        <?php unset($_SESSION['status_type']);?>
        <?php unset($_SESSION['status']);?>
    </script>
</body>
</html>