<?php
session_start();
include("../connect.php");
require('../../init.php');
require("../init.php");
$translationFile = "../../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = [];
}
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$post_id1 = isset($_GET['id1']) ? intval($_GET['id1']) : 0;
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../admin.css" />
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['edit_post']; ?></title>
</head>

<body>
    <?php require("../extras/header3.php"); ?>
    <section class="newpost_body">
        <?php
        if ($post_id1 > 0) {
            $getpost_sql = " SELECT * FROM paid_posts WHERE id = $post_id1";
            $getpost_result = $conn->query($getpost_sql);
            if ($getpost_result->num_rows > 0) {
                $row = $getpost_result->fetch_assoc();
                $title = $row['title'];
                $subtitle = $row['subtitle'];
                $category = $row['niche'];
                $link = $row['link'];
                $image = $row['image_path'];
                $content = $row['content'];
                $foreign_imagePath = $row['post_image_url'];
                $author_firstname = $row['authors_firstname'];
                $author_lastname = $row['authors_lastname'];
                echo "<form class='newpost_container' method='post' action='../../helpers/forms.php' enctype='multipart/form-data' id='postForm'>
                            <div class='page_links'>
                                <a href=" . $base_url . "admin_homepage.php'>$translations[home]</a> > <p>$translations[edit_post]</p>
                            </div>
                            <div class='newpost_container_div1 newpost_subdiv'>
                                <h1>$translations[edit_post]</h1>
                            </div>
                            <div class='newpost_container_div2 newpost_subdiv'>
                                <input class='form__input input1' name='Post_Title' type='text' value='$title'/>
                                <div class='newpost_container_div2_subdiv2'>
                                    <input class='form__input' name='Post_Niche' type='text' value='$category'/>
                                </div>
                            </div>
                            <input type='hidden' name='table_type' value='paid_posts' type='text'/>
                            <input type='hidden' name='post_id' value='$post_id1' type='text'/>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='Post_Sub_Title'>$translations[subtitle]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='Post_Sub_Title' type='text' value='$subtitle'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_subtitle_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div5 newpost_subdiv'>
                                <label class='form__label' for='Post_featured'>$translations[featured_audio_video]:</label>
                                <div class='newpost_container_div5_subdiv2'>
                                    <input class='form__input' name='Post_featured' type='text' value='$link'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[featured_audio_video_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div6 newpost_subdiv'>";
                if (!empty($image)) {
                    echo "      <div class='newpost_container_div6_subdiv1'>
                                    <img src='$image' alt='Post Image'/>
                                </div>
                            ";
                } elseif (!empty($foreign_imagePath)) {
                    echo "   <div class='newpost_container_div6_subdiv1'>
                                <img src='$foreign_imagePath' alt='Post Image'/>
                            </div>
                        ";
                }
                echo "
                                <div class='newpost_container_div6_subdiv2'>
                                    <label class='form__label' for='Post_Image'>$translations[post_image]: </label>
                                    <div class='newpost_subdiv2'>
                                        <input class='form__input' name='Post_Image' type='file' />
                                        <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_image_p]</p>
                                    </div>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='Post_content'>$translations[post_content]:</label>
                                <textarea class='newpost_container_div7_subdiv2' name='Post_content' id='myTextarea3'>
                                    $content
                                </textarea>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_firstname'>$translations[author_firstname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_firstname' type='text' value='$author_firstname'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_firstname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_lastname'>$translations[author_lastname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_lastname' type='text' value='$author_lastname'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_lastname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='about_author'>$translations[about_author]:</label>
                                <textarea class='newpost_container_div7_subdiv2b' name='about_author'>
                                    " . $row['about_author'] . "
                                </textarea>
                                <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[about_author_p]</p>
                            </div>
                            <input class='form__submit_input btn' type='submit' value='$translations[update]' name='update_post' />
                        </form>
                        ";
            }
        } else if ($post_id2 > 0) {
            $getpost_sql = " SELECT * FROM posts WHERE id = $post_id2";
            $getpost_result = $conn->query($getpost_sql);
            if ($getpost_result->num_rows > 0) {
                $row = $getpost_result->fetch_assoc();
                $title = $row['title'];
                $subtitle = $row['subtitle'];
                $category = $row['niche'];
                $link = $row['link'];
                $image = $row['image_path'];
                $content = $row['content'];
                $foreign_imagePath = $row['post_image_url'];
                $author_firstname = $row['authors_firstname'];
                $author_lastname = $row['authors_lastname'];
                echo "<form class='newpost_container' method='post' action='../../helpers/forms.php' enctype='multipart/form-data' id='postForm'>
                            <div class='page_links'>
                                <a href=" . $base_url . "admin_homepage.php'>$translations[home]</a> > <p>$translations[edit_post]</p>
                            </div>
                            <div class='newpost_container_div1 newpost_subdiv'>
                                <h1>$translations[edit_post]</h1>
                            </div>
                            <div class='newpost_container_div2 newpost_subdiv'>
                                <input class='form__input input1' name='Post_Title' type='text' value='$title'/>
                                <div class='newpost_container_div2_subdiv2'>
                                    <input class='form__input' name='Post_Niche' type='text' value='$category'/>
                                </div>
                            </div>
                            <input type='hidden' name='table_type' value='posts' type='text'/>
                            <input type='hidden' name='post_id' value='$post_id2' type='text'/>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='Post_Sub_Title'>$translations[subtitle]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='Post_Sub_Title' type='text' value='$subtitle'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_subtitle_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div5 newpost_subdiv'>
                                <label class='form__label' for='Post_featured'>$translations[featured_audio_video]:</label>
                                <div class='newpost_container_div5_subdiv2'>
                                    <input class='form__input' name='Post_featured' type='text' value='$link'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[featured_audio_video_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div6 newpost_subdiv'>";
                if (!empty($image)) {
                    echo "      <div class='newpost_container_div6_subdiv1'>
                                    <img src='$image' alt='Post Image'/>
                                </div>
                            ";
                } elseif (!empty($foreign_imagePath)) {
                    echo "   <div class='newpost_container_div6_subdiv1'>
                                <img src='$foreign_imagePath' alt='Post Image'/>
                            </div>
                        ";
                }
                echo "
                                <div class='newpost_container_div6_subdiv2'>
                                    <label class='form__label' for='Post_Image'>$translations[post_image]: </label>
                                    <div class='newpost_subdiv2'>
                                        <input class='form__input' name='Post_Image' type='file' />
                                        <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_image_p]</p>
                                    </div>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='Post_content'>$translations[post_content]:</label>
                                <textarea class='newpost_container_div7_subdiv2' name='Post_content' id='myTextarea3'>
                                    $content
                                </textarea>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_firstname'>$translations[author_firstname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_firstname' type='text' value='$author_firstname'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_firstname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_lastname'>$translations[author_lastname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_lastname' type='text' value='$author_lastname'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_lastname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='about_author'>$translations[about_author]:</label>
                                <textarea class='newpost_container_div7_subdiv2b' name='about_author'>
                                    " . $row['about_author'] . "
                                </textarea>
                                <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[about_author_p]</p>
                            </div>
                            <input class='form__submit_input btn' type='submit' value='$translations[update]' name='update_post' />
                        </form>
                        ";
            }
        } else if ($post_id3 > 0) {
            $getpost_sql = " SELECT * FROM unpublished_articles WHERE id = $post_id3";
            $getpost_result = $conn->query($getpost_sql);
            if ($getpost_result->num_rows > 0) {
                $row = $getpost_result->fetch_assoc();
                $title = $row['title'];
                $subtitle = $row['subtitle'];
                $category = $row['niche'];
                $link = $row['link'];
                $image = $row['image'];
                $foreign_imagePath = $row['post_image_url'];
                $content = $row['content'];
                echo "<form class='newpost_container' method='post' action='../../helpers/forms.php' enctype='multipart/form-data' id='postForm'>
                            <div class='page_links'>
                                <a href=" . $base_url . "admin_homepage.php'>$translations[home]</a> > <p>$translations[edit_post]</p>
                            </div>
                            <div class='newpost_container_div1 newpost_subdiv'>
                                <h1>$translations[edit_post]</h1>
                            </div>
                            <div class='newpost_container_div2 newpost_subdiv'>
                                <input class='form__input input1' name='Post_Title' type='text' value='$title'/>
                                <div class='newpost_container_div2_subdiv2'>
                                    <input class='form__input' name='Post_Niche' type='text' value='$category'/>
                                </div>
                            </div>
                            <input type='hidden' name='table_type' value='unpublished_articles' type='text'/>
                            <input type='hidden' name='post_id' value='$post_id3' type='text'/>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='Post_Sub_Title'>$translations[subtitle]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='Post_Sub_Title' type='text' value='$subtitle'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_subtitle_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div5 newpost_subdiv'>
                                <label class='form__label' for='Post_featured'>$translations[featured_audio_video]:</label>
                                <div class='newpost_container_div5_subdiv2'>
                                    <input class='form__input' name='Post_featured' type='text' value='$link'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[featured_audio_video_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div6 newpost_subdiv'>";
                if (!empty($image)) {
                    echo "      <div class='newpost_container_div6_subdiv1'>
                                    <img src='$image' alt='Post Image'/>
                                </div>
                            ";
                } elseif (!empty($foreign_imagePath)) {
                    echo "   <div class='newpost_container_div6_subdiv1'>
                                <img src='$foreign_imagePath' alt='Post Image'/>
                            </div>
                        ";
                }
                echo "
                                <div class='newpost_container_div6_subdiv2'>
                                    <label class='form__label' for='Post_Image'>$translations[post_image]: </label>
                                    <div class='newpost_subdiv2'>
                                        <input class='form__input' name='Post_Image' type='file' />
                                        <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_image_p]</p>
                                    </div>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='Post_content'>$translations[post_content]:</label>
                                <textarea class='newpost_container_div7_subdiv2' name='Post_content' id='myTextarea3'>
                                    $content
                                </textarea>
                            </div>
                            <input class='form__submit_input btn' type='submit' value='$translations[update]' name='update_post' />
                        </form>
                        ";
            }
        } else if ($post_id4 > 0) {
            $getpost_sql = " SELECT * FROM news WHERE id = $post_id4";
            $getpost_result = $conn->query($getpost_sql);
            if ($getpost_result->num_rows > 0) {
                $row = $getpost_result->fetch_assoc();
                $title = $row['title'];
                $subtitle = $row['subtitle'];
                $category = $row['niche'];
                $link = $row['link'];
                $image = $row['image_path'];
                $content = $row['content'];
                $foreign_imagePath = $row['post_image_url'];
                $author_firstname = $row['authors_firstname'];
                $author_lastname = $row['authors_lastname'];
                echo "<form class='newpost_container' method='post' action='../../helpers/forms.php' enctype='multipart/form-data' id='postForm'>
                            <div class='page_links'>
                                <a href=" . $base_url . "admin_homepage.php'>$translations[home]</a> > <p>$translations[edit_post]</p>
                            </div>
                            <div class='newpost_container_div1 newpost_subdiv'>
                                <h1>$translations[edit_post]</h1>
                            </div>
                            <div class='newpost_container_div2 newpost_subdiv'>
                                <input class='form__input input1' name='Post_Title' type='text' value='$title'/>
                                <div class='newpost_container_div2_subdiv2'>
                                    <input class='form__input' name='Post_Niche' type='text' value='$category'/>
                                </div>
                            </div>
                            <input type='hidden' name='table_type' value='news' type='text'/>
                            <input type='hidden' name='post_id' value='$post_id4' type='text'/>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='Post_Sub_Title'>$translations[subtitle]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='Post_Sub_Title' type='text' value='$subtitle'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_subtitle_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div5 newpost_subdiv'>
                                <label class='form__label' for='Post_featured'>$translations[featured_audio_video]:</label>
                                <div class='newpost_container_div5_subdiv2'>
                                    <input class='form__input' name='Post_featured' type='text' value='$link'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[featured_audio_video_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div6 newpost_subdiv'>";
                if (!empty($image)) {
                    echo "      <div class='newpost_container_div6_subdiv1'>
                                    <img src='$image' alt='Post Image'/>
                                </div>
                            ";
                } elseif (!empty($foreign_imagePath)) {
                    echo "   <div class='newpost_container_div6_subdiv1'>
                                <img src='$foreign_imagePath' alt='Post Image'/>
                            </div>
                        ";
                }
                echo "
                                <div class='newpost_container_div6_subdiv2'>
                                    <label class='form__label' for='Post_Image'>$translations[post_image]: </label>
                                    <div class='newpost_subdiv2'>
                                        <input class='form__input' name='Post_Image' type='file' />
                                        <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_image_p]</p>
                                    </div>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='Post_content'>$translations[post_content]:</label>
                                <textarea class='newpost_container_div7_subdiv2' name='Post_content' id='myTextarea3'>
                                    $content
                                </textarea>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_firstname'>$translations[author_firstname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_firstname' type='text' value='$author_firstname'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_firstname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_lastname'>$translations[author_lastname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_lastname' type='text' value='$author_lastname'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_lastname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='about_author'>$translations[about_author]:</label>
                                <textarea class='newpost_container_div7_subdiv2b' name='about_author'>
                                    " . $row['about_author'] . "
                                </textarea>
                                <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[about_author_p]</p>
                            </div>
                            <input class='form__submit_input btn' type='submit' value='$translations[update]' name='update_post' />
                        </form>
                        ";
            }
        } else if ($post_id5 > 0) {
            $getpost_sql = " SELECT * FROM commentaries WHERE id = $post_id5";
            $getpost_result = $conn->query($getpost_sql);
            if ($getpost_result->num_rows > 0) {
                $row = $getpost_result->fetch_assoc();
                $title = $row['title'];
                $subtitle = $row['subtitle'];
                $category = $row['niche'];
                $link = $row['link'];
                $image = $row['image_path'];
                $content = $row['content'];
                $foreign_imagePath = $row['post_image_url'];
                $author_firstname = $row['authors_firstname'];
                $author_lastname = $row['authors_lastname'];
                echo "<form class='newpost_container' method='post' action='../../helpers/forms.php' enctype='multipart/form-data' id='postForm'>
                            <div class='page_links'>
                                <a href=" . $base_url . "admin_homepage.php'>$translations[home]</a> > <p>$translations[edit_post]</p>
                            </div>
                            <div class='newpost_container_div1 newpost_subdiv'>
                                <h1>$translations[edit_post]</h1>
                            </div>
                            <div class='newpost_container_div2 newpost_subdiv'>
                                <input class='form__input input1' name='Post_Title' type='text' value='$title'/>
                                <div class='newpost_container_div2_subdiv2'>
                                    <input class='form__input' name='Post_Niche' type='text' value='$category'/>
                                </div>
                            </div>
                            <input type='hidden' name='table_type' value='commentaries' type='text'/>
                            <input type='hidden' name='post_id' value='$post_id5' type='text'/>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='Post_Sub_Title'>$translations[subtitle]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='Post_Sub_Title' type='text' value='$subtitle'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_subtitle_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div5 newpost_subdiv'>
                                <label class='form__label' for='Post_featured'>$translations[featured_audio_video]:</label>
                                <div class='newpost_container_div5_subdiv2'>
                                    <input class='form__input' name='Post_featured' type='text' value='$link'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[featured_audio_video_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div6 newpost_subdiv'>";
                if (!empty($image)) {
                    echo "      <div class='newpost_container_div6_subdiv1'>
                                    <img src='$image' alt='Post Image'/>
                                </div>
                            ";
                } elseif (!empty($foreign_imagePath)) {
                    echo "   <div class='newpost_container_div6_subdiv1'>
                                <img src='$foreign_imagePath' alt='Post Image'/>
                            </div>
                        ";
                }
                echo "
                                <div class='newpost_container_div6_subdiv2'>
                                    <label class='form__label' for='Post_Image'>$translations[post_image]: </label>
                                    <div class='newpost_subdiv2'>
                                        <input class='form__input' name='Post_Image' type='file' />
                                        <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_image_p]</p>
                                    </div>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='Post_content'>$translations[post_content]:</label>
                                <textarea class='newpost_container_div7_subdiv2' name='Post_content' id='myTextarea3'>
                                    $content
                                </textarea>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_firstname'>$translations[author_firstname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_firstname' type='text' value='$author_firstname'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_firstname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_lastname'>$translations[author_lastname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_lastname' type='text' value='$author_lastname'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_lastname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='about_author'>$translations[about_author]:</label>
                                <textarea class='newpost_container_div7_subdiv2b' name='about_author'>
                                    " . $row['about_author'] . "
                                </textarea>
                                <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[about_author_p]</p>
                            </div>
                            <input class='form__submit_input btn' type='submit' value='$translations[update]' name='update_post' />
                        </form>
                        ";
            }
        } else if ($post_id6 > 0) {
            $getpost_sql = " SELECT * FROM press_releases WHERE id = $post_id6";
            $getpost_result = $conn->query($getpost_sql);
            if ($getpost_result->num_rows > 0) {
                $row = $getpost_result->fetch_assoc();
                $title = $row['title'];
                $subtitle = $row['subtitle'];
                $category = $row['niche'];
                $link = $row['link'];
                $image = $row['image_path'];
                $content = $row['content'];
                $foreign_imagePath = $row['post_image_url'];
                $author_firstname = $row['authors_firstname'];
                $author_lastname = $row['authors_lastname'];
                echo "<form class='newpost_container' method='post' action='../../helpers/forms.php' enctype='multipart/form-data' id='postForm'>
                            <div class='page_links'>
                                <a href=" . $base_url . "admin_homepage.php'>$translations[home]</a> > <p>$translations[edit_post]</p>
                            </div>
                            <div class='newpost_container_div1 newpost_subdiv'>
                                <h1>$translations[edit_post]</h1>
                            </div>
                            <div class='newpost_container_div2 newpost_subdiv'>
                                <input class='form__input input1' name='Post_Title' type='text' value='$title'/>
                                <div class='newpost_container_div2_subdiv2'>
                                    <input class='form__input' name='Post_Niche' type='text' value='$category'/>
                                </div>
                            </div>
                            <input type='hidden' name='table_type' value='press_releases' type='text'/>
                            <input type='hidden' name='post_id' value='$post_id6' type='text'/>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='Post_Sub_Title'>$translations[subtitle]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='Post_Sub_Title' type='text' value='$subtitle'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_subtitle_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div5 newpost_subdiv'>
                                <label class='form__label' for='Post_featured'>$translations[featured_audio_video]:</label>
                                <div class='newpost_container_div5_subdiv2'>
                                    <input class='form__input' name='Post_featured' type='text' value='$link'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[featured_audio_video_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div6 newpost_subdiv'>";
                if (!empty($image)) {
                    echo "      <div class='newpost_container_div6_subdiv1'>
                                    <img src='$image' alt='Post Image'/>
                                </div>
                            ";
                } elseif (!empty($foreign_imagePath)) {
                    echo "   <div class='newpost_container_div6_subdiv1'>
                                <img src='$foreign_imagePath' alt='Post Image'/>
                            </div>
                        ";
                }
                echo "
                                <div class='newpost_container_div6_subdiv2'>
                                    <label class='form__label' for='Post_Image'>$translations[post_image]: </label>
                                    <div class='newpost_subdiv2'>
                                        <input class='form__input' name='Post_Image' type='file' />
                                        <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[post_image_p]</p>
                                    </div>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='Post_content'>$translations[post_content]:</label>
                                <textarea class='newpost_container_div7_subdiv2' name='Post_content' id='myTextarea3'>
                                    $content
                                </textarea>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_firstname'>$translations[author_firstname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_firstname' type='text' value='$author_firstname'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_firstname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div3 newpost_subdiv'>
                                <label class='form__label' for='author_lastname'>$translations[author_lastname]:</label>
                                <div class='newpost_container_div3_subdiv2'>
                                    <input class='form__input' name='author_lastname' type='text' value='$author_lastname'/>
                                    <p class='newpost_subdiv2-p leftp'><span>*</span> $translations[author_lastname_p]</p>
                                </div>
                            </div>
                            <div class='newpost_container_div7 newpost_subdiv'>
                                <label class='form__label' for='about_author'>$translations[about_author]:</label>
                                <textarea class='newpost_container_div7_subdiv2b' name='about_author'>
                                    " . $row['about_author'] . "
                                </textarea>
                                <p class='newpost_subdiv2-p leftp'><span>*</span>$translations[about_author_p]</p>
                            </div>
                            <input class='form__submit_input btn' type='submit' value='$translations[update]' name='update_post' />
                        </form>
                        ";
            }
        }
        ?>
    </section>
    <script src="https://cdn.tiny.cloud/1/4x49ifq5jl99k0b9aot23a5ynnqfcr8jdlee7v6905rgmzql/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="../admin.js"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script>
        preventSubmitIfUnchanged('.newpost_container', 'input[type="text"], input[type="file"], textarea');
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
            selector: "#myTextarea3",
            resize: true,
            setup: function(editor) {
                editor.on("init", function() {
                    editor.editorContainer.style.width = "90%";
                    editor.editorContainer.style.height = "50vh";
                });
            },
            plugins: [
                "advlist",
                "autolink",
                "link",
                "image",
                "lists",
                "charmap",
                "preview",
                "anchor",
                "pagebreak",
                "searchreplace",
                "wordcount",
                "visualblocks",
                "visualchars",
                "code",
                "fullscreen",
                "insertdatetime",
                "media",
                "table",
                "emoticons",
                "help",
            ],
            toolbar: "undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | " +
                "bullist numlist outdent indent | link image | print preview media fullscreen | " +
                "forecolor backcolor emoticons | help",
            menu: {
                favs: {
                    title: "My Favorites",
                    items: "code visualaid | searchreplace | emoticons",
                },
            },
            menubar: "favs file edit view insert format tools table help",
            content_css: "css/content.css",
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