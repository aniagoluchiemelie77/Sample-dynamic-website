<?php
session_start();
include("../connect.php");
require('../../init.php');
require("../init.php");
$translationFile = "../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = [];
}
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$post_id2 = isset($_GET['id2']) ? intval($_GET['id2']) : 0;
$post_id3 = isset($_GET['id3']) ? intval($_GET['id3']) : 0;
$post_id4 = isset($_GET['id4']) ? intval($_GET['id4']) : 0;
$post_id5 = isset($_GET['id5']) ? intval($_GET['id5']) : 0;
$post_id6 = isset($_GET['id6']) ? intval($_GET['id6']) : 0;
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
    <title><?php echo $translations['edit_post']; ?></title>
</head>

<body>
    <?php require("../extras/header2.php"); ?>
    <section class="newpost_body">
        <form class="newpost_container" method="post" action="../forms.php" enctype="multipart/form-data" id="postForm">
            <div class="page_links">
                <a href="../editor_homepage.php"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['edit_post']; ?></p>
            </div>
            <div class="newpost_container_div1 newpost_subdiv">
                <h1><?php echo $translations['edit_post']; ?></h1>
            </div>
            <?php
            if ($post_id2 > 0) {
                $getpost_sql = " SELECT * FROM posts WHERE id = $post_id2";
                $getpost_result = $conn->query($getpost_sql);
                if ($getpost_result->num_rows > 0) {
                    $row = $getpost_result->fetch_assoc();
                    echo "
                            <div class='newpost_container_div2 newpost_subdiv'>
                                <input class='form__input input1' name='Post_Title' type='text' value='" . $row['title'] . "'required/>
                                <div class='newpost_container_div2_subdiv2'>
                                    <input class='form__input' name='Post_Niche' type='text' value='" . $row['niche'] . "'required/>
                                </div>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='Post_Sub_Title'>$translations[subtitle]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='Post_Sub_Title' type='text' value='" . $row['subtitle'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_subtitle_p]</p>
                                </div>
                            </div>
                            <input type='hidden' name='table_type' value='posts' type='text'/>
                            <input type='hidden' name='post_id' value='$post_id2' type='text'/>
                            <div class='newpost_container_div5 newpost_subdiv'>
                                <label class='form__label' for='Post_featured'>$translations[featured_audio_video]:</label>
                                <div class='newpost_container_div5_subdiv2'>
                                    <input class='form__input' name='Post_featured' type='text' value='" . $row['link'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[featured_audio_video_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div6 newpost_subdiv'>
                                <div class='newpost_container_div6_subdiv1'>
                                    <img src='../../" . $row['image_path'] . "' alt='Post Image'/>
                                </div>
                                <div class='newpost_container_div6_subdiv2'>
                                    <label class='form__label' for='Post_Image'>$translations[post_image]: </label>
                                    <div class='newpost_subdiv2'>
                                        <input class='form__input' name='Post_Image' type='file' required/>
                                        <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_image_p]</p>
                                    </div>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='Post_Content'>$translations[post_content]:</label>
                                <textarea class='newpost_container_div7_subdiv2' name='Post_content' id='myTextarea3'>
                                    " . $row['content'] . "
                                </textarea>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_firstname'>$translations[author_firstname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_firstname' type='text' value='" . $row['authors_firstname'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_firstname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_lastname'>$translations[author_lastname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_lastname' type='text' value='" . $row['authors_lastname'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_lastname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='about_author'>$translations[about_author]:</label>
                                <textarea class='newpost_container_div7_subdiv2b' name='about_author'>
                                    " . $row['about_author'] . "
                                </textarea>
                                <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[about_author_p]</p>
                            </div>
                        ";
                }
            } else if ($post_id3 > 0) {
                $getdrafts_sql = " SELECT * FROM unpublished_articles WHERE id = $post_id3";
                $getdrafts_result = $conn->query($getdrafts_sql);
                if ($getdrafts_result->num_rows > 0) {
                    $row = $getdrafts_result->fetch_assoc();
                    echo "
                            <div class='newpost_container_div2 newpost_subdiv'>
                                <input class='form__input input1' name='Post_Title' type='text' value='" . $row['title'] . "'required/>
                                <div class='newpost_container_div2_subdiv2'>
                                    <input class='form__input' name='Post_Niche' type='text' value='" . $row['niche'] . "'required/>
                                </div>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='Post_Sub_Title'>$translations[subtitle]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='Post_Sub_Title' type='text' value='" . $row['subtitle'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_subtitle_p]</p>
                                </div>
                            </div>
                            <input type='hidden' name='table_type' value='unpublished_articles' type='text'/>
                            <input type='hidden' name='post_id' value='$post_id3' type='text'/>
                            <div class='newpost_container_div5 newpost_subdiv'>
                                <label class='form__label' for='Post_featured'>$translations[featured_audio_video]:</label>
                                <div class='newpost_container_div5_subdiv2'>
                                    <input class='form__input' name='Post_featured' type='text' value='" . $row['link'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[featured_audio_video_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div6 newpost_subdiv'>
                                <div class='newpost_container_div6_subdiv1'>
                                    <img src='../../" . $row['image_path'] . "' alt='Post Image'/>
                                </div>
                                <div class='newpost_container_div6_subdiv2'>
                                    <label class='form__label' for='Post_Image'>$translations[post_image]: </label>
                                    <div class='newpost_subdiv2'>
                                        <input class='form__input' name='Post_Image' type='file' required/>
                                        <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_image_p]</p>
                                    </div>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='Post_Content'>$translations[post_content]:</label>
                                <textarea class='newpost_container_div7_subdiv2' name='Post_content' id='myTextarea3'>
                                    " . $row['content'] . "
                                </textarea>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_firstname'>$translations[author_firstname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_firstname' type='text' value='" . $row['authors_firstname'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_firstname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_lastname'>$translations[author_lastname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_lastname' type='text' value='" . $row['authors_lastname'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_lastname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='about_author'>$translations[about_author]:</label>
                                <textarea class='newpost_container_div7_subdiv2b' name='about_author'>
                                    " . $row['about_author'] . "
                                </textarea>
                                <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[about_author_p]</p>
                            </div>
                        ";
                }
            } else if ($post_id4 > 0) {
                $getnews_sql = " SELECT * FROM news WHERE id = $post_id4";
                $getnews_result = $conn->query($getnews_sql);
                if ($getnews_result->num_rows > 0) {
                    $row = $getnews_result->fetch_assoc();
                    echo "
                            <div class='newpost_container_div2 newpost_subdiv'>
                                <input class='form__input input1' name='Post_Title' type='text' value='" . $row['title'] . "'required/>
                                <div class='newpost_container_div2_subdiv2'>
                                    <input class='form__input' name='Post_Niche' type='text' value='" . $row['niche'] . "'required/>
                                </div>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='Post_Sub_Title'>$translations[subtitle]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='Post_Sub_Title' type='text' value='" . $row['subtitle'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_subtitle_p]</p>
                                </div>
                            </div>
                            <input type='hidden' name='table_type' value='news' type='text'/>
                            <input type='hidden' name='post_id' value='$post_id4' type='text'/>
                            <div class='newpost_container_div5 newpost_subdiv'>
                                <label class='form__label' for='Post_featured'>$translations[featured_audio_video]:</label>
                                <div class='newpost_container_div5_subdiv2'>
                                    <input class='form__input' name='Post_featured' type='text' value='" . $row['link'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[featured_audio_video_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div6 newpost_subdiv'>
                                <div class='newpost_container_div6_subdiv1'>
                                    <img src='../../" . $row['image_path'] . "' alt='Post Image'/>
                                </div>
                                <div class='newpost_container_div6_subdiv2'>
                                    <label class='form__label' for='Post_Image'>$translations[post_image]: </label>
                                    <div class='newpost_subdiv2'>
                                        <input class='form__input' name='Post_Image' type='file' required/>
                                        <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_image_p]</p>
                                    </div>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='Post_Content'>$translations[post_content]:</label>
                                <textarea class='newpost_container_div7_subdiv2' name='Post_content' id='myTextarea3'>
                                    " . $row['content'] . "
                                </textarea>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_firstname'>$translations[author_firstname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_firstname' type='text' value='" . $row['authors_firstname'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_firstname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_lastname'>$translations[author_lastname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_lastname' type='text' value='" . $row['authors_lastname'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_lastname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='about_author'>$translations[about_author]:</label>
                                <textarea class='newpost_container_div7_subdiv2b' name='about_author'>
                                    " . $row['about_author'] . "
                                </textarea>
                                <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[about_author_p]</p>
                            </div>
                        ";
                }
            } else if ($post_id5 > 0) {
                $getcommentary_sql = " SELECT * FROM commentaries WHERE id = $post_id5";
                $getcommentary_result = $conn->query($getcommentary_sql);
                if ($getcommentary_result->num_rows > 0) {
                    $row = $getcommentary_result->fetch_assoc();
                    echo "
                            <div class='newpost_container_div2 newpost_subdiv'>
                                <input class='form__input input1' name='Post_Title' type='text' value='" . $row['title'] . "'required/>
                                <div class='newpost_container_div2_subdiv2'>
                                    <input class='form__input' name='Post_Niche' type='text' value='" . $row['niche'] . "'required/>
                                </div>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='Post_Sub_Title'>$translations[subtitle]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='Post_Sub_Title' type='text' value='" . $row['subtitle'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_subtitle_p]</p>
                                </div>
                            </div>
                            <input type='hidden' name='table_type' value='commentaries' type='text'/>
                            <input type='hidden' name='post_id' value='$post_id5' type='text'/>
                            <div class='newpost_container_div5 newpost_subdiv'>
                                <label class='form__label' for='Post_featured'>$translations[featured_audio_video]:</label>
                                <div class='newpost_container_div5_subdiv2'>
                                    <input class='form__input' name='Post_featured' type='text' value='" . $row['link'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[featured_audio_video_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div6 newpost_subdiv'>
                                <div class='newpost_container_div6_subdiv1'>
                                    <img src='../../" . $row['image_path'] . "' alt='Post Image'/>
                                </div>
                                <div class='newpost_container_div6_subdiv2'>
                                    <label class='form__label' for='Post_Image'>$translations[post_image]: </label>
                                    <div class='newpost_subdiv2'>
                                        <input class='form__input' name='Post_Image' type='file' required/>
                                        <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_image_p]</p>
                                    </div>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='Post_Content'>$translations[post_content]:</label>
                                <textarea class='newpost_container_div7_subdiv2' name='Post_content' id='myTextarea3'>
                                    " . $row['content'] . "
                                </textarea>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_firstname'>$translations[author_firstname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_firstname' type='text' value='" . $row['authors_firstname'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_firstname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_lastname'>$translations[author_lastname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_lastname' type='text' value='" . $row['authors_lastname'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_lastname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='about_author'>$translations[about_author]:</label>
                                <textarea class='newpost_container_div7_subdiv2b' name='about_author'>
                                    " . $row['about_author'] . "
                                </textarea>
                                <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[about_author_p]</p>
                            </div>
                        ";
                }
            } else {
                $getpressrelease_sql = " SELECT * FROM press_releases WHERE id = $post_id6";
                $getpressrelease_result = $conn->query($getpressrelease_sql);
                if ($getpressrelease_result->num_rows > 0) {
                    $row = $getpressrelease_result->fetch_assoc();
                    echo "
                            <div class='newpost_container_div2 newpost_subdiv'>
                                <input class='form__input input1' name='Post_Title' type='text' value='" . $row['title'] . "'required/>
                                <div class='newpost_container_div2_subdiv2'>
                                    <input class='form__input' name='Post_Niche' type='text' value='" . $row['niche'] . "'required/>
                                </div>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='Post_Sub_Title'>$translations[subtitle]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='Post_Sub_Title' type='text' value='" . $row['subtitle'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_subtitle_p]</p>
                                </div>
                            </div>
                            <input type='hidden' name='table_type' value='press_releases' type='text'/>
                            <input type='hidden' name='post_id' value='$post_id6' type='text'/>
                            <div class='newpost_container_div5 newpost_subdiv'>
                                <label class='form__label' for='Post_featured'>$translations[featured_audio_video]:</label>
                                <div class='newpost_container_div5_subdiv2'>
                                    <input class='form__input' name='Post_featured' type='text' value='" . $row['link'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[featured_audio_video_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div6 newpost_subdiv'>
                                <div class='newpost_container_div6_subdiv1'>
                                    <img src='../../" . $row['image_path'] . "' alt='Post Image'/>
                                </div>
                                <div class='newpost_container_div6_subdiv2'>
                                    <label class='form__label' for='Post_Image'>$translations[post_image]: </label>
                                    <div class='newpost_subdiv2'>
                                        <input class='form__input' name='Post_Image' type='file' required/>
                                        <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_image_p]</p>
                                    </div>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='Post_Content'>$translations[post_content]:</label>
                                <textarea class='newpost_container_div7_subdiv2' name='Post_content' id='myTextarea3'>
                                    " . $row['content'] . "
                                </textarea>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_firstname'>$translations[author_firstname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_firstname' type='text' value='" . $row['authors_firstname'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_firstname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_lastname'>$translations[author_lastname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_lastname' type='text' value='" . $row['authors_lastname'] . "'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_lastname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='about_author'>$translations[about_author]:</label>
                                <textarea class='newpost_container_div7_subdiv2b' name='about_author'>
                                    " . $row['about_author'] . "
                                </textarea>
                                <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[about_author_p]</p>
                            </div>
                        ";
                }
            }
            ?>
            <div class="newpost_container_div9 newpost_subdiv">
                <input class="form__submit_input" type="submit" value="<?php echo $translations['update']; ?>" name="update_post" />
            </div>
        </form>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/4x49ifq5jl99k0b9aot23a5ynnqfcr8jdlee7v6905rgmzql/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="../editor.js"></script>
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
    </script>
</body>

</html>