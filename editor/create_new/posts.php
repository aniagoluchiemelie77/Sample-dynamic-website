<?php
session_start();
include("../connect.php");
require("../init.php");
require('../../init.php');
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$translationFile = "../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../editor.css" />
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title><?php echo $translations['create_new_post']; ?></title>
</head>

<body>
    <?php require("../extras/header3.php"); ?>
    <section class="newpost_body">
        <form class="newpost_container" method="post" action="../forms.php" enctype="multipart/form-data" id="postForm">
            <div class="page_links">
                <a href="../editor_homepage.php"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['create_new_post']; ?></p>
            </div>
            <div class="newpost_container_div1 newpost_subdiv">
                <h1><?php echo $translations['new_post']; ?></h1>
            </div>
            <div class="newpost_container_div3 newpost_subdiv">
                <label class="form__label" for="Post_Title"><?php echo $translations['post_title']; ?>:</label>
                <div class="newpost_container_div3_subdiv2">
                    <input class="form__input" name="Post_Title" type="text" />
                </div>
            </div>
            <div class="newpost_container_div3 newpost_subdiv">
                <label class="form__label" for="Post_Sub_Title"><?php echo $translations['post_subtitle']; ?>:</label>
                <div class="newpost_container_div3_subdiv2">
                    <input class="form__input" name="Post_Sub_Title" type="text" />
                    <p class="newpost_subdiv2-p leftp"><span>*</span><?php echo $translations['post_subtitle_p']; ?></p>
                </div>
            </div>
            <div class="newpost_container_div4 newpost_subdiv">
                <label class="form__select" for="Post_Niche"><?php echo $translations['category']; ?>:</label>
                <select class="newpost_subdiv2" name="Post_Niche">
                    <option class="newpost_subdiv4-option" value="">-- <?php echo $translations['category_option']; ?> --</option>
                    <?php
                    $selectcategory = "SELECT name FROM topics ORDER BY id";
                    $selectcategory_result = $conn->query($selectcategory);
                    if ($selectcategory_result->num_rows > 0) {
                        if (!function_exists('convertToReadable')) {
                            function convertToReadable($slug)
                            {
                                $string = str_replace('-', ' ', $slug);
                                $string = ucwords($string);
                                return $string;
                            }
                        }
                        while ($row = $selectcategory_result->fetch_assoc()) {
                            $category_names = $row['name'];
                            $readableString = convertToReadable($category_names);
                            echo "<option class='newpost_subdiv4-option' value='$readableString'>$readableString</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="newpost_container_div4 newpost_subdiv">
                <label class="form__select" for="Post_status"><?php echo $translations['post_type']; ?>:</label>
                <select class="newpost_subdiv2" name="Post_status">
                    <option class="newpost_subdiv4-option" value="">-- <?php echo $translations['post_type_option']; ?> --</option>
                    <option class="newpost_subdiv4-option" value="posts"><?php echo $translations['article']; ?></option>
                    <option class="newpost_subdiv4-option" value="news"><?php echo $translations['news']; ?></option>
                    <option class="newpost_subdiv4-option" value="press_releases"><?php echo $translations['press_release']; ?></option>
                    <option class="newpost_subdiv4-option" value="commentaries"><?php echo $translations['commentary']; ?></option>
                </select>
            </div>
            <div class="newpost_container_div5 newpost_subdiv">
                <label class="form__label" for="Post_featured"><?php echo $translations['featured_audio_video']; ?>:</label>
                <div class="newpost_container_div5_subdiv2">
                    <input class="form__input" name="Post_featured" type="text" />
                    <p class="newpost_subdiv2-p leftp"><span>*</span><?php echo $translations['featured_audio_video_p']; ?></p>
                </div>
            </div>
            <div class="newpost_container_div6">
                <div class="newpost_container_div6_subdiv">
                    <label class="form__label" for="Post_Image1"><?php echo $translations['post_image']; ?></label>
                    <div class="newpost_subdiv2">
                        <input class="form__input" name="Post_Image1" type="file" />
                        <p class="newpost_subdiv2-p leftp"><span>*</span><?php echo $translations['post_image_p']; ?></p>
                    </div>
                </div>
                <p>------ <?php echo $translations['or']; ?> ------</p>
                <div class="newpost_container_div6_subdiv">
                    <label class="form__label" for="Post_Image2"><?php echo $translations['image_url']; ?>:</label>
                    <div class="newpost_container_div5_subdiv2">
                        <input class="form__input" name="Post_Image2" type="text" placeholder="Enter Image Url..." />
                    </div>
                </div>
            </div>
            <div class="newpost_container_div7 newpost_subdiv">
                <label class="form__label" for="Post_content"><?php echo $translations['post_content']; ?>:</label>
                <textarea class="newpost_container_div7_subdiv2" name="Post_content" id="myTextarea">
                </textarea>
            </div>
            <div class="newpost_container_div3 newpost_subdiv">
                <label class="form__label" for="author_firstname"><?php echo $translations['author_firstname']; ?>:</label>
                <div class="newpost_container_div3_subdiv2">
                    <input class="form__input" name="author_firstname" type="text" />
                    <p class="newpost_subdiv2-p leftp"><span>*</span> <?php echo $translations['author_firstname_p']; ?></p>
                </div>
            </div>
            <div class="newpost_container_div3 newpost_subdiv">
                <label class="form__label" for="author_lastname"><?php echo $translations['author_lastname']; ?>:</label>
                <div class="newpost_container_div3_subdiv2">
                    <input class="form__input" name="author_lastname" type="text" />
                    <p class="newpost_subdiv2-p leftp"><span>*</span> <?php echo $translations['author_lastname_p']; ?></p>
                </div>
            </div>
            <div class="newpost_container_div7 newpost_subdiv">
                <label class="form__label" for="about_author"><?php echo $translations['about_author']; ?>:</label>
                <textarea class="newpost_container_div7_subdiv2b" name="about_author">
                </textarea>
                <p class="newpost_subdiv2-p leftp"><span>*</span> <?php echo $translations['about_author_p']; ?></p>
            </div>
            <div class="newpost_container_div9 newpost_subdiv">
                <input class="form__submit_input" type="submit" value="<?php echo $translations['publish']; ?>" name="create_post" />
            </div>
            <div class="newpost_container_div10 newpost_subdiv">
                <p class="form__submit_or centerp bold">----------- <?php echo $translations['or']; ?> -----------</p>
            </div>
            <div class="newpost_container_div11 newpost_subdiv">
                <label class="form__label bold" for="schedule"><?php echo $translations['schedule_publish']; ?></label>
                <input class="" type="date" name="schedule" />
            </div>
        </form>
    </section>
    <script src="https://cdn.tiny.cloud/1/4x49ifq5jl99k0b9aot23a5ynnqfcr8jdlee7v6905rgmzql/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="../editor.js"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script>
        var messageType = "<?= $_SESSION['status_type'] ?? ' ' ?>";
        var messageText = "<?= $_SESSION['status'] ?? ' ' ?>";
        if (messageType == 'Error' && messageText != " ") {
            Swal.fire({
                title: 'Error!',
                text: messageText,
                icon: 'error',
                confirmButtonText: 'Ok'
            })
        } else if (messageType == 'Success' && messageText != " ") {
            Swal.fire({
                title: 'Success',
                text: messageText,
                icon: 'success',
                confirmButtonText: 'Ok'
            })
        }
        <?php unset($_SESSION['status_type']); ?>
        <?php unset($_SESSION['status']); ?>
        tinymce.init({
            selector: '#myTextarea',
            setup: function(editor) {
                editor.on('init', function() {
                    editor.editorContainer.style.width = "90%";
                    editor.editorContainer.style.height = "50vh";
                });
            },
            resize: true,
            plugins: [
                'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
                'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
                'media', 'table', 'emoticons', 'help'
            ],
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
                'forecolor backcolor emoticons | help',
            menu: {
                favs: {
                    title: 'My Favorites',
                    items: 'code visualaid | searchreplace | emoticons'
                }
            },
            menubar: 'favs file edit view insert format tools table help',
            content_css: 'css/content.css'
        });
        window.addEventListener("resize", function() {
            if (tinymce.activeEditor) {
                let newWidth = window.innerWidth * 0.8;
                let newHeight = window.innerHeight * 0.7;
                tinymce.activeEditor.editorContainer.style.width = newWidth + "px";
                tinymce.activeEditor.editorContainer.style.height = newHeight + "px";
            }
        });
    </script>
</body>

</html>