<?php
session_start();
require("../connect.php");
require('../init.php');
$page_name = "view-post";
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
require_once '../vendor/ezyang\htmlpurifier/library/HTMLPurifier.auto.php';
$post_id = isset($_GET['id1']) ? intval($_GET['id1']) : 0;
$post_id2 = isset($_GET['id2']) ? intval($_GET['id2']) : 0;
$post_id3 = isset($_GET['id3']) ? intval($_GET['id3']) : 0;
$post_id4 = isset($_GET['id4']) ? intval($_GET['id4']) : 0;
$post_id5 = isset($_GET['id5']) ? intval($_GET['id5']) : 0;
$url = "http://localhost/Sample-dynamic-website";
$title1 = "";
$subtitle1 = "";
$img1 = "";
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
if (isset($_POST['submit_btn'])) {
    $email = $_POST["email"];
    $sendEmail = sendEmail($email);
    $_SESSION['status_type'] = $sendEmail['status_type'];
    $_SESSION['status'] = $sendEmail['status'];
}
if (isset($_POST['subscribe_btn2'])) {
    $email = $_POST["email"];
    $sendEmail = sendEmail($email);
    $_SESSION['status_type'] = $sendEmail['status_type'];
    $_SESSION['status'] = $sendEmail['status'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php
    if (isset($meta_titles[$page_name])) {
        $meta_data = $meta_titles[$page_name];
        for ($i = 1; $i <= 5; $i++) {
            $meta_name = $meta_data["meta_name$i"];
            $meta_content = $meta_data["meta_content$i"];
            if (!empty($meta_name) && !empty($meta_content)) {
                echo "<meta name='$meta_name' content='$meta_content' />";
            }
        }
    }
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../index.css" />
    <script src="../index.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../<?php echo $favicon; ?>" type="image/x-icon">
    <title>View post</title>
</head>

<body>
    <?php require("../includes/header2.php"); ?>
    <div class="body_container">
        <div class="body_left">
            <div class="page_links">
                <a href="../">Home</a> > <p>View Post</p>
            </div>
            <?php
            $getniche_sql = " SELECT name FROM topics ORDER BY id";
            $getniche_result = $conn->query($getniche_sql);
            if ($getniche_result->num_rows > 0) {
                echo "<div class='body_left_relatedniches'>";
                while ($row = $getniche_result->fetch_assoc()) {
                    $category_name = $row['name'];
                    $cleanString = removeHyphen($category_name);
                    $readableString = convertToReadable($category_name);
                    echo "<a href='$cleanString.php'>$readableString</a>";
                }
                echo "</div>";
            }
            if ($post_id > 0) {
                $getposts_sql = " SELECT id, admin_id, title, niche, content, subtitle, image_path, post_image_url, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date, authors_firstname, authors_lastname, about_author, link FROM paid_posts WHERE id = '$post_id' LIMIT 1";
                $getposts_result = $conn->query($getposts_sql);
                if ($getposts_result->num_rows > 0) {
                    $row = $getposts_result->fetch_assoc();
                    $idtype = 'Admin';
                    $time = $row['time'];
                    $title = $row['title'];
                    $niche = $row['niche'];
                    $content = $row['content'];
                    $subtitle = $row['subtitle'];
                    $image = $row['image_path'];
                    $foreign_imagePath = $row["post_image_url"];
                    $date = $row['formatted_date'];
                    $id = $row['id'];
                    $admin_id = $row['admin_id'];
                    $link = $row['link'];
                    $formatted_time = date("g:i A", strtotime($time));
                    $title1 = $title;
                    $subtitle1 = $subtitle;
                    $img1 = $image;
                    $selectwriter = "SELECT id, firstname, lastname, bio, image FROM admin_login_info WHERE id = '$admin_id'";
                    $selectwriter_result = $conn->query($selectwriter);
                    if ($selectwriter_result->num_rows > 0) {
                        $read_count = '';
                        $read_count = calculateReadingTime($content);
                        while ($row = $selectwriter_result->fetch_assoc()) {
                            $bio = $row["bio"];
                            $max_length = 250;
                            if (strlen($bio) > $max_length) {
                                $bio = substr($bio, 0, $max_length) . '...';
                            }

                            echo "<h1 class='Post_header'>" . $title . "</h1>
                                        <h2>" . $subtitle . "</h2>
                                        <div class='authors_div'>
                                            <div class='authors_div_imgbox'>
                                                <img src='" . $row['image'] . "' alt='Author's Image'/>
                                                <p><span class='span1'>" . $row['firstname'] . "  " . $row['lastname'] . ", Editor-in-chief, Uniquetechcontentwriter.</span><span class='span3'>" . $date . "</span><span class='span3'>" . $formatted_time . "</span></p>
                                            </div>
                                            <div class='authors_div_otherdiv'>
                                                <i class='fa fa-clock' aria-hidden='true'></i>
                                                <p>$read_count</p>
                                            </div>
                                        </div>";
                            if (!empty($link)) {
                                echo " <video width='70%' controls>
                                            <source src='" . $link . "' type='video/mp4'>
                                            Your browser does not support the video tag.
                                        </video>";
                            }
                            if (!empty($image)) {
                                echo   "<div class='post_image_div'>
                                            <img src='$image' alt='Post Image'/>
                                        </div>
                                    ";
                            } elseif (!empty($foreign_imagePath)) {
                                echo   "<div class='post_image_div'>
                                            <img src='$foreign_imagePath' alt='Post Image'/>
                                        </div>";
                            }
                            echo "
                                        <div class='socialmedia_links'>
                                            <a class='twitter-share-button' id='xShareBtn'><i class='fa-brands fa-x-twitter'></i></a>
                                            <a href='https://www.facebook.com/sharer/sharer.php?u=$url' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                            <a href='https://www.linkedin.com/shareArticle?mini=true&url={$url}&title={$title}' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                            <a href='https://www.reddit.com/submit?url=$url&title=$title' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                            <a onclick='window.print()' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                            <a href='mailto:?subject=$title&body=$subtitle' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                                        </div>
                                        <p class='content'>$content</p>
                                        <div class='socialmedia_links'>
                                            <a id='xShareBtn2' class='twitter-share-button'><i class='fa-brands fa-x-twitter'></i></a>
                                            <a href='https://www.facebook.com/sharer/sharer.php?u=$url' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                            <a href='https://www.linkedin.com/shareArticle?mini=true&url={$url}&title={$title}' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                            <a href='https://www.reddit.com/submit?url=$url&title=$title' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                            <a onclick='window.print()' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                            <a href='mailto:?subject=$title&body=$subtitle' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                                        </div>
                                        <h3 class='bodyleft_header3'>About the Author</h3>
                                        <center>
                                            <a href='../authors/author.php?idtype=$idtype&id=$admin_id' class='aboutauthor_div'>
                                                <div class='aboutauthor_div_subdiv1'>
                                                    <img src='" . $row['image'] . "' alt ='Author's Image'/>
                                                </div>
                                                <div class='aboutauthor_div_subdiv2'>
                                                    <p class='p--bold'>" . $row['firstname'] . " " . $row['lastname'] . "</p>
                                                    <p class='p--bold2'>Editor-in-chief, Uniquetechcontentwriter.</p>
                                                    <p>$bio</p>
                                                </div>
                                            </a>
                                        </center>
                                    ";
                        }
                    }
                }
                $otherpaidposts_sql = "SELECT id, title, niche, content, image_path, post_image_url, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM paid_posts WHERE id != '$post_id' ORDER BY date DESC";
                $otherpaidposts_result = $conn->query($otherpaidposts_sql);
                if ($otherpaidposts_result->num_rows > 0) {
                    echo "<h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>You may also like</h1>
                              <div class='more_posts'>
                        ";
                    while ($row = $otherpaidposts_result->fetch_assoc()) {
                        $id = $row["id"];
                        $max_length2 = 40;
                        $title = $row["title"];
                        $niche = $row["niche"];
                        $image = $row["image_path"];
                        $foreign_imagePath = $row["post_image_url"];
                        $date = $row["formatted_date"];
                        $content = $row["content"];
                        if (strlen($title) > $max_length2) {
                            $title = substr($title, 0, $max_length2) . '...';
                        }
                        $readingTime = calculateReadingTime($row['content']);
                        echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id1=$id'>";
                        if (!empty($image)) {
                            echo "<img src='$image' alt='article image'>";
                        } elseif (!empty($foreign_imagePath)) {
                            echo "<img src='$foreign_imagePath' alt='article image'>";
                        }
                        echo   "
                                    <div class='more_posts_subdiv_subdiv'>
                                        <h1>$title</h1>
                                        <span>$date</span>
                                        <span>$readingTime</span>
                                    </div>
                                    <p class='posts_div_niche'>$niche</p>
                                </a>";
                    }
                    echo "</div>";
                }
            }
            if ($post_id2 > 0) {
                $getposts_sql = " SELECT id,admin_id, editor_id, title, niche, content, subtitle, post_image_url, image_path, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date, authors_firstname, authors_lastname, about_author, link FROM posts WHERE id = '$post_id2'";
                $getposts_result = $conn->query($getposts_sql);
                if ($getposts_result->num_rows > 0) {
                    $id_admin = '';
                    $id_editor = "";
                    $id_writer = "";
                    $row = $getposts_result->fetch_assoc();
                    $author1 = $row['authors_firstname'];
                    $author2 = $row['editor_id'];
                    $author3 = $row['admin_id'];
                    $time = $row['time'];
                    $title = $row['title'];
                    $niche = $row['niche'];
                    $content = $row['content'];
                    $read_count = '';
                    if (!empty($author3) && empty($author2) && empty($author1)) {
                        $admin_id = $row['admin_id'];
                        $sql_admin = "SELECT id, firstname, lastname, image, bio FROM admin_login_info WHERE id = $admin_id";
                        $result_admin = $conn->query($sql_admin);
                        if ($result_admin->num_rows > 0) {
                            $admin = $result_admin->fetch_assoc();
                            $author_firstname = $admin['firstname'];
                            $author_lastname = $admin['lastname'];
                            $author_image = $admin['image'];
                            $id_type = "Admin";
                            $id_admin = $admin['id'];
                            $author_bio = $admin['bio'];
                            $role = "Editor-in-chief Uniquetechcontentwriter.com";
                        }
                    } elseif (!empty($author2) && empty($author3) && empty($author1)) {
                        $editor_id = $row['editor_id'];
                        $sql_editor = "SELECT id, firstname, lastname, image, bio FROM editor WHERE id = $editor_id";
                        $result_editor = $conn->query($sql_editor);
                        if ($result_editor->num_rows > 0) {
                            $editor = $result_editor->fetch_assoc();
                            $author_firstname = $editor['firstname'];
                            $author_image = $editor['image'];
                            $author_lastname = $editor['lastname'];
                            $author_bio = $editor['bio'];
                            $id_editor = $editor['id'];
                            $id_type = "Editor";
                            $role = 'Editor At Uniquetechcontentwriter.com';
                        }
                    } elseif (!empty($author1) && !empty($author3) && empty($author2)) {
                        $author_firstname = $row['authors_firstname'];
                        $author_lastname = $row['authors_lastname'];
                        $sql_writer = "SELECT id, firstname, lastname, image, bio FROM writer WHERE firstname = '$author_firstname'";
                        $result_writer = $conn->query($sql_writer);
                        if ($result_writer->num_rows > 0) {
                            $writer = $result_writer->fetch_assoc();
                            $author_firstname = $writer['firstname'];
                            $author_lastname = $writer['lastname'];
                            $author_image = $writer['image'];
                            $id_type = "Writer";
                            $id_writer = $writer['id'];
                            $author_bio = $writer['bio'];
                            $role = "Contributing Writer";
                        }
                    }
                    $max_length = 200;
                    if (strlen($author_bio) > $max_length) {
                        $author_bio = substr($author_bio, 0, $max_length) . '...';
                    }
                    $read_count = calculateReadingTime($content);
                    $subtitle = $row['subtitle'];
                    $image = $row['image_path'];
                    $foreign_imagePath = $row["post_image_url"];
                    $date = $row['formatted_date'];
                    $id = $row['id'];
                    $link = $row['link'];
                    $title1 = $title;
                    $subtitle1 = $subtitle;
                    $img1 = $image;
                    $formatted_time = date("g:i A", strtotime($time));
                    echo "<h1 class='Post_header'>$title</h1>
                                <h2>$subtitle</h2>
                                <div class='authors_div'>
                                    <div class='authors_div_imgbox'>
                                        <img src='$author_image' alt='Author's Image'/>
                                        <p><span class='span1'>$author_firstname $author_lastname, $role.</span><span class='span3'>$date</span><span class='span3'>$formatted_time</span></p>
                                    </div>
                                    <div class='authors_div_otherdiv'>
                                        <i class='fa fa-clock' aria-hidden='true'></i>
                                        <p>$read_count</p>
                                    </div>
                                </div>";
                    if (!empty($link)) {
                        echo " <video width='70%' controls>
                                    <source src='$link' type='video/mp4'>
                                    Your browser does not support the video tag.
                                </video>";
                    }
                    if (!empty($image)) {
                        echo "   <div class='post_image_div'>
                                    <img src='$image' alt='Post Image'/>
                                </div>
                            ";
                    } elseif (!empty($foreign_imagePath)) {
                        echo "   <div class='post_image_div'>
                                    <img src='$foreign_imagePath' alt='Post Image'/>
                                </div>
                            ";
                    }
                    echo "
                            <div class='socialmedia_links'>
                                <a class='twitter-share-button' id='xShareBtn3'><i class='fa-brands fa-x-twitter'></i></a>
                                <a href='https://www.facebook.com/sharer/sharer.php?u=$url' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                <a href='https://www.linkedin.com/shareArticle?mini=true&url={$url}&title={$title}' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                <a href='https://www.reddit.com/submit?url=$url&title=$title' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                <a onclick='window.print()' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                <a href='mailto:?subject=$title&body=$subtitle' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                            </div>
                            <p class='content'>$content</p>
                            <div class='socialmedia_links'>
                                <a class='twitter-share-button' id='xShareBtn4'><i class='fa-brands fa-x-twitter'></i></a>
                                <a href='https://www.facebook.com/sharer/sharer.php?u=$url' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                <a href='https://www.linkedin.com/shareArticle?mini=true&url={$url}&title={$title}' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                <a href='https://www.reddit.com/submit?url=$url&title=$title' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                <a onclick='window.print()' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                <a href='mailto:?subject=$title&body=$subtitle' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                            </div>
                            <h3 class='bodyleft_header3'>About the Author</h3>
                            <center>
                                <a href='../authors/author.php?id=$id_admin$id_editor&idtype=$id_type' class='aboutauthor_div'>
                                    <div class='aboutauthor_div_subdiv1'>
                                        <img src='$author_image' alt ='Author's Image'/>
                                    </div>
                                    <div class='aboutauthor_div_subdiv2'>
                                        <p class='p--bold'>$author_firstname $author_lastname</p>
                                        <p class='p--bold2'>$role</p>
                                        <p>$author_bio</p>
                                    </div>
                                </a>
                            </center>
                        ";
                }
                $otherposts_sql = "SELECT id, title, niche, content, image_path, post_image_url, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM posts WHERE id != '$post_id2' ORDER BY date DESC LIMIT 8";
                $otherposts_result = $conn->query($otherposts_sql);
                if ($otherposts_result->num_rows > 0) {
                    echo "<h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>You may also like</h1>
                              <div class='more_posts'>
                        ";
                    while ($row = $otherposts_result->fetch_assoc()) {
                        $id = $row["id"];
                        $max_length2 = 40;
                        $title = $row["title"];
                        $niche = $row["niche"];
                        $image = $row["image_path"];
                        $foreign_imagePath = $row["post_image_url"];
                        $date = $row["formatted_date"];
                        $content = $row["content"];
                        if (strlen($title) > $max_length2) {
                            $title = substr($title, 0, $max_length2) . '...';
                        }
                        $readingTime = calculateReadingTime($row['content']);
                        echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id2=$id'>";
                        if (!empty($image)) {
                            echo "<img src='$image' alt='article image'>";
                        } elseif (!empty($foreign_imagePath)) {
                            echo "<img src='$foreign_imagePath' alt='article image'>";
                        }
                        echo   "
                                    <div class='more_posts_subdiv_subdiv'>
                                        <h1>$title</h1>
                                        <span>$date</span>
                                        <span>$readingTime</span>
                                    </div>
                                    <p class='posts_div_niche'>$niche</p>
                                </a>";
                    }
                    echo "</div>";
                }
            }
            if ($post_id3 > 0) {
                $getposts_sql = " SELECT id,admin_id, editor_id, title, niche, content, subtitle, image_path, post_image_url, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date, authors_firstname, authors_lastname, about_author, link FROM news WHERE id = '$post_id3'";
                $getposts_result = $conn->query($getposts_sql);
                if ($getposts_result->num_rows > 0) {
                    $row = $getposts_result->fetch_assoc();
                    $author1 = $row['authors_firstname'];
                    $author2 = $row['editor_id'];
                    $author3 = $row['admin_id'];
                    $time = $row['time'];
                    $title = $row['title'];
                    $niche = $row['niche'];
                    $content = $row['content'];
                    $read_count = '';
                    $id_admin = "";
                    $id_editor = "";
                    $id_writer = "";
                    if (!empty($author3) && empty($author2) && empty($author1)) {
                        $admin_id = $row['admin_id'];
                        $sql_admin = "SELECT id, firstname, lastname, image, bio FROM admin_login_info WHERE id = $admin_id";
                        $result_admin = $conn->query($sql_admin);
                        if ($result_admin->num_rows > 0) {
                            $admin = $result_admin->fetch_assoc();
                            $author_firstname = $admin['firstname'];
                            $author_lastname = $admin['lastname'];
                            $author_image = $admin['image'];
                            $id_type = "Admin";
                            $id_admin = $admin['id'];
                            $author_bio = $admin['bio'];
                            $role = "Editor-in-chief Uniquetechcontentwriter.com";
                        }
                    } elseif (!empty($author2) && empty($author3) && empty($author1)) {
                        $editor_id = $row['editor_id'];
                        $sql_editor = "SELECT id, firstname, lastname, image, bio FROM editor WHERE id = $editor_id";
                        $result_editor = $conn->query($sql_editor);
                        if ($result_editor->num_rows > 0) {
                            $editor = $result_editor->fetch_assoc();
                            $author_firstname = $editor['firstname'];
                            $author_image = $editor['image'];
                            $author_lastname = $editor['lastname'];
                            $author_bio = $editor['bio'];
                            $id_editor = $editor['id'];
                            $id_type = "Editor";
                            $role = 'Editor At Uniquetechcontentwriter.com';
                        }
                    } elseif (!empty($author1) && !empty($author3) && empty($author2)) {
                        $author_firstname = $row['authors_firstname'];
                        $author_lastname = $row['authors_lastname'];
                        $sql_writer = "SELECT id, firstname, lastname, image, bio FROM writer WHERE firstname = '$author_firstname'";
                        $result_writer = $conn->query($sql_writer);
                        if ($result_writer->num_rows > 0) {
                            $writer = $result_writer->fetch_assoc();
                            $author_firstname = $writer['firstname'];
                            $author_lastname = $writer['lastname'];
                            $author_image = $writer['image'];
                            $id_type = "Writer";
                            $id_writer = $writer['id'];
                            $author_bio = $writer['bio'];
                            $role = "Contributing Writer";
                        }
                    }
                    $max_length = 200;
                    if (strlen($author_bio) > $max_length) {
                        $author_bio = substr($author_bio, 0, $max_length) . '...';
                    }
                    $read_count = calculateReadingTime($content);
                    $subtitle = $row['subtitle'];
                    $image = $row['image_path'];
                    $foreign_imagePath = $row["post_image_url"];
                    $date = $row['formatted_date'];
                    $id = $row['id'];
                    $link = $row['link'];
                    $formatted_time = date("g:i A", strtotime($time));
                    $title1 = $title;
                    $subtitle1 = $subtitle;
                    $img1 = $image;
                    echo "<h1 class='Post_header'>" . $title . "</h1>
                                <h2>" . $subtitle . "</h2>
                                <div class='authors_div'>
                                    <div class='authors_div_imgbox'>
                                        <img src='$author_image' alt='Author's Image'/>
                                        <p><span class='span1'>$author_firstname $author_lastname, $role.</span><span class='span3'>$date</span><span class='span3'>$formatted_time</span></p>
                                    </div>
                                    <div class='authors_div_otherdiv'>
                                        <i class='fa fa-clock' aria-hidden='true'></i>
                                        <p>$read_count</p>
                                    </div>
                                </div>
                            ";
                    if (!empty($link)) {
                        echo " <video width='70%' controls>
                                        <source src='" . $link . "' type='video/mp4'>
                                        Your browser does not support the video tag.
                                    </video>";
                    }
                    if (!empty($image)) {
                        echo "   <div class='post_image_div'>
                                    <img src='$image' alt='Post Image'/>
                                </div>
                            ";
                    } elseif (!empty($foreign_imagePath)) {
                        echo "   <div class='post_image_div'>
                                    <img src='$foreign_imagePath.jpg' alt='Post Image'/>
                                </div>
                            ";
                    }
                    echo "
                                    <div class='socialmedia_links'>
                                        <a class='twitter-share-button' id='xShareBtn5'><i class='fa-brands fa-x-twitter'></i></a>
                                        <a href='https://www.facebook.com/sharer/sharer.php?u=$url' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                        <a href='https://www.linkedin.com/shareArticle?mini=true&url={$url}&title={$title}' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                        <a href='https://www.reddit.com/submit?url=$url&title=$title' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                        <a onclick='window.print()' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                        <a href='mailto:?subject=$title&body=$subtitle' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                                    </div>
                                    <p class='content'>$content</p>
                                    <div class='socialmedia_links'>
                                        <a class='twitter-share-button' id='xShareBtn6'><i class='fa-brands fa-x-twitter'></i></a>
                                        <a href='https://www.facebook.com/sharer/sharer.php?u=$url' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                        <a href='https://www.linkedin.com/shareArticle?mini=true&url={$url}&title={$title}' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                        <a href='https://www.reddit.com/submit?url=$url&title=$title' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                        <a onclick='window.print()' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                        <a href='mailto:?subject=$title&body=$subtitle' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                                    </div>
                                    <h3 class='bodyleft_header3'>About the Author</h3>
                                    <center>
                                        <a href='../authors/author.php?id=$id_admin$id_editor$id_writer&idtype=$id_type' class='aboutauthor_div'>
                                            <div class='aboutauthor_div_subdiv1'>
                                                <img src='$author_image' alt ='Author's Image'/>
                                            </div>
                                            <div class='aboutauthor_div_subdiv2'>
                                                <p class='p--bold'>$author_firstname $author_lastname</p>
                                                <p class='p--bold2'>$role</p>
                                                <p>$author_bio</p>
                                            </div>
                                        </a>
                                    </center>
                                ";
                }
                $otherposts_sql = "SELECT id, title, niche, content, image_path, post_image_url, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM news WHERE id != '$post_id3' ORDER BY date DESC LIMIT 8";
                $otherposts_result = $conn->query($otherposts_sql);
                if ($otherposts_result->num_rows > 0) {
                    echo "<h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>You may also like</h1>
                              <div class='more_posts'>
                        ";
                    while ($row = $otherposts_result->fetch_assoc()) {
                        $id = $row["id"];
                        $max_length2 = 40;
                        $title = $row["title"];
                        $niche = $row["niche"];
                        $image = $row["image_path"];
                        $foreign_imagePath = $row["post_image_url"];
                        $date = $row["formatted_date"];
                        $content = $row["content"];
                        if (strlen($title) > $max_length2) {
                            $title = substr($title, 0, $max_length2) . '...';
                        }
                        $readingTime = calculateReadingTime($row['content']);
                        echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id3=$id'>";
                        if (!empty($image)) {
                            echo "<img src='$image' alt='article image'>";
                        } elseif (!empty($foreign_imagePath)) {
                            echo "<img src='$foreign_imagePath' alt='article image'>";
                        }
                        echo   "
                                    <div class='more_posts_subdiv_subdiv'>
                                        <h1>$title</h1>
                                        <span>$date</span>
                                        <span>$readingTime</span>
                                    </div>
                                    <p class='posts_div_niche'>$niche</p>
                                </a>";
                    }
                    echo "</div>";
                }
            }
            if ($post_id4 > 0) {
                $getposts_sql = " SELECT id, admin_id, editor_id, title, niche, content, subtitle, post_image_url, image_path, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date, authors_firstname, authors_lastname, about_author, authors_image, schedule, link FROM commentaries WHERE id = '$post_id4'";
                $getposts_result = $conn->query($getposts_sql);
                if ($getposts_result->num_rows > 0) {
                    $row = $getposts_result->fetch_assoc();
                    $author1 = $row['authors_firstname'];
                    $author2 = $row['editor_id'];
                    $author3 = $row['admin_id'];
                    $time = $row['time'];
                    $title = $row['title'];
                    $niche = $row['niche'];
                    $content = $row['content'];
                    $read_count = '';
                    $id_admin = "";
                    $id_editor = "";
                    $id_writer = "";
                    if (!empty($author3) && empty($author2) && empty($author1)) {
                        $admin_id = $row['admin_id'];
                        $sql_admin = "SELECT id, firstname, lastname, image, bio FROM admin_login_info WHERE id = $admin_id";
                        $result_admin = $conn->query($sql_admin);
                        if ($result_admin->num_rows > 0) {
                            $admin = $result_admin->fetch_assoc();
                            $author_firstname = $admin['firstname'];
                            $author_lastname = $admin['lastname'];
                            $author_image = $admin['image'];
                            $id_type = "Admin";
                            $id_admin = $admin['id'];
                            $author_bio = $admin['bio'];
                            $role = "Editor-in-chief Uniquetechcontentwriter.com";
                        }
                    } elseif (!empty($author2) && empty($author3) && empty($author1)) {
                        $editor_id = $row['editor_id'];
                        $sql_editor = "SELECT id, firstname, lastname, image, bio FROM editor WHERE id = $editor_id";
                        $result_editor = $conn->query($sql_editor);
                        if ($result_editor->num_rows > 0) {
                            $editor = $result_editor->fetch_assoc();
                            $author_firstname = $editor['firstname'];
                            $author_image = $editor['image'];
                            $author_lastname = $editor['lastname'];
                            $author_bio = $editor['bio'];
                            $id_editor = $editor['id'];
                            $id_type = "Editor";
                            $role = 'Editor At Uniquetechcontentwriter.com';
                        }
                    } elseif (!empty($author1) && !empty($author3) && empty($author2)) {
                        $author_firstname = $row['authors_firstname'];
                        $author_lastname = $row['authors_lastname'];
                        $sql_writer = "SELECT id, firstname, lastname, image, bio FROM writer WHERE firstname = '$author_firstname'";
                        $result_writer = $conn->query($sql_writer);
                        if ($result_writer->num_rows > 0) {
                            $writer = $result_writer->fetch_assoc();
                            $author_firstname = $writer['firstname'];
                            $author_lastname = $writer['lastname'];
                            $author_image = $writer['image'];
                            $id_type = "Writer";
                            $id_writer = $writer['id'];
                            $author_bio = $writer['bio'];
                            $role = "Contributing Writer";
                        }
                    }
                    $max_length = 200;
                    if (strlen($author_bio) > $max_length) {
                        $author_bio = substr($author_bio, 0, $max_length) . '...';
                    }
                    $read_count = calculateReadingTime($content);
                    $subtitle = $row['subtitle'];
                    $image = $row['image_path'];
                    $foreign_imagePath = $row["post_image_url"];
                    $date = $row['formatted_date'];
                    $id = $row['id'];
                    $link = $row['link'];
                    $formatted_time = date("g:i A", strtotime($time));
                    echo "<h1 class='Post_header'>" . $title . "</h1>
                                <h2>" . $subtitle . "</h2>
                                <div class='authors_div'>
                                    <div class='authors_div_imgbox'>
                                        <img src='$author_image' alt='Author's Image'/>
                                        <p><span class='span1'>$author_firstname $author_lastname, $role.</span><span class='span3'>$date</span><span class='span3'>$formatted_time</span></p>
                                    </div>
                                    <div class='authors_div_otherdiv'>
                                        <i class='fa fa-clock' aria-hidden='true'></i>
                                        <p>$read_count</p>
                                    </div>
                                </div>
                            ";
                    if (!empty($link)) {
                        echo " <video width='70%' controls>
                                    <source src='" . $link . "' type='video/mp4'>
                                    Your browser does not support the video tag.
                                </video>";
                    }
                    if (!empty($image)) {
                        echo "   <div class='post_image_div'>
                                    <img src='$image' alt='Post Image'/>
                                </div>
                            ";
                    } elseif (!empty($foreign_imagePath)) {
                        echo "   <div class='post_image_div'>
                                    <img src='$foreign_imagePath' alt='Post Image'/>
                                </div>
                            ";
                    }
                    echo "
                                <div class='socialmedia_links'>
                                    <a href='https://twitter.com/intent/tweet?url=" . $url . "&text=" . $title . " target='_blank'><i class='fa-brands fa-x-twitter'></i></a>
                                    <a href='https://www.facebook.com/sharer/sharer.php?u=$url' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                    <a href='https://www.linkedin.com/shareArticle?mini=true&url={$url}&title={$title}' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                    <a href='https://www.reddit.com/submit?url=$url&title=$title' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                    <a onclick='window.print()' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                    <a href='mailto:?subject=$title&body=$subtitle' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                                </div>
                                <p class='content'>$content</p>
                                <div class='socialmedia_links'>
                                    <a href='https://twitter.com/intent/tweet?url=" . $url . "&text=" . $title . " target='_blank'><i class='fa-brands fa-x-twitter'></i></a>
                                    <a href='https://www.facebook.com/sharer/sharer.php?u=$url' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                    <a href='https://www.linkedin.com/shareArticle?mini=true&url={$url}&title={$title}' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                    <a href='https://www.reddit.com/submit?url=$url&title=$title' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                    <a onclick='window.print()' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                    <a href='mailto:?subject=$title&body=$subtitle' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                                </div>
                                <h3 class='bodyleft_header3'>About the Author</h3>
                                <center>
                                    <a href='../authors/author.php?id=$id_admin$id_editor$id_writer&idtype=$id_type' class='aboutauthor_div'>
                                        <div class='aboutauthor_div_subdiv1'>
                                            <img src='$author_image' alt ='Author's Image'/>
                                        </div>
                                        <div class='aboutauthor_div_subdiv2'>
                                            <p class='p--bold'>$author_firstname $author_lastname</p>
                                            <p class='p--bold2'>$role</p>
                                            <p>$author_bio</p>
                                        </div>
                                    </a>
                                </center>
                                ";
                }
                $otherposts_sql = "SELECT id, title, niche, content, image_path, post_image_url, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM commentaries WHERE id != '$post_id4' ORDER BY date DESC LIMIT 8";
                $otherposts_result = $conn->query($otherposts_sql);
                if ($otherposts_result->num_rows > 0) {
                    echo "<h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>You may also like</h1>
                              <div class='more_posts'>
                        ";
                    while ($row = $otherposts_result->fetch_assoc()) {
                        $id = $row["id"];
                        $max_length2 = 40;
                        $title = $row["title"];
                        $niche = $row["niche"];
                        $image = $row["image_path"];
                        $foreign_imagePath = $row["post_image_url"];
                        $date = $row["formatted_date"];
                        $content = $row["content"];
                        if (strlen($title) > $max_length2) {
                            $title = substr($title, 0, $max_length2) . '...';
                        }
                        $readingTime = calculateReadingTime($row['content']);
                        echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id3=$id'>";
                        if (!empty($image)) {
                            echo "<img src='$image' alt='article image'>";
                        } elseif (!empty($foreign_imagePath)) {
                            echo "<img src='$foreign_imagePath' alt='article image'>";
                        }
                        echo   "
                                    <div class='more_posts_subdiv_subdiv'>
                                        <h1>$title</h1>
                                        <span>$date</span>
                                        <span>$readingTime</span>
                                    </div>
                                    <p class='posts_div_niche'>$niche</p>
                                </a>
                                </div>
                                <section class='section2' id='section1'>
                                    <div class='section2__div1'>
                                        <div class='section2__div1__header headers'>
                                            <h1>For You</h1>
                                        </div>
                                        <?php include('../includes/pagination.php');?>
                                    </div>
                                </section>";
                    }
                }
            }
            if ($post_id5 > 0) {
                $getposts_sql = " SELECT id, admin_id, editor_id, title, niche, content, subtitle, image_path, post_image_url, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date, authors_firstname, authors_lastname, about_author, link, schedule, authors_image FROM press_releases WHERE id = '$post_id5'";
                $getposts_result = $conn->query($getposts_sql);
                if ($getposts_result->num_rows > 0) {
                    $row = $getposts_result->fetch_assoc();
                    $author1 = $row['authors_firstname'];
                    $author2 = $row['editor_id'];
                    $author3 = $row['admin_id'];
                    $time = $row['time'];
                    $title = $row['title'];
                    $niche = $row['niche'];
                    $content = $row['content'];
                    $read_count = '';
                    $id_admin = "";
                    $id_editor = "";
                    $id_writer = "";
                    if (!empty($author1) && !empty($author3)) {
                        $author_firstname = $row['author_firstname'];
                        $author_lastname = $row['author_lastname'];
                        $sql_writer = "SELECT id, firstname, lastname, image, bio FROM writer WHERE firstname = $author_firstname OR lastname = $author_lastname";
                        $result_writer = $conn->query($sql_writer);
                        if ($result_writer->num_rows > 0) {
                            $writer = $result_writer->fetch_assoc();
                            $author_firstname = $writer['firstname'];
                            $author_lastname = $writer['lastname'];
                            $author_image = $writer['image'];
                            $id_type = "Writer";
                            $id_writer = $writer['id'];
                            $author_bio = $writer['bio'];
                            $role = "Contributing Writer";
                        }
                    } else if (!empty($author3) && empty($author2) && empty($author1)) {
                        $admin_id = $row['admin_id'];
                        $sql_admin = "SELECT id, firstname, lastname, image, bio FROM admin_login_info WHERE id = $admin_id";
                        $result_admin = $conn->query($sql_admin);
                        if ($result_admin->num_rows > 0) {
                            $admin = $result_admin->fetch_assoc();
                            $author_firstname = $admin['firstname'];
                            $author_lastname = $admin['lastname'];
                            $author_image = $admin['image'];
                            $id_type = "Admin";
                            $id_admin = $admin['id'];
                            $author_bio = $admin['bio'];
                            $role = "Editor-in-chief Uniquetechcontentwriter.com";
                        }
                    } elseif (empty($author1) && empty($author3) && !empty($author2)) {
                        $editor_id = $row['editor_id'];
                        $sql_editor = "SELECT id, firstname, lastname, image, bio FROM editor WHERE id = $editor_id";
                        $result_editor = $conn->query($sql_editor);
                        if ($result_editor->num_rows > 0) {
                            $editor = $result_editor->fetch_assoc();
                            $author_firstname = $editor['firstname'];
                            $author_lastname = $editor['lastname'];
                            $author_image = $editor['image'];
                            $id_type = "Editor";
                            $id_editor = $editor['id'];
                            $author_bio = $editor['bio'];
                            $role = "Editor at Uniquetechcontentwriter.com";
                        }
                    }
                    $max_length = 200;
                    if (strlen($author_bio) > $max_length) {
                        $author_bio = substr($author_bio, 0, $max_length) . '...';
                    }
                    $read_count = calculateReadingTime($content);
                    $subtitle = $row['subtitle'];
                    $image = $row['image_path'];
                    $foreign_imagePath = $row["post_image_url"];
                    $date = $row['formatted_date'];
                    $id = $row['id'];
                    $link = $row['link'];
                    $formatted_time = date("g:i A", strtotime($time));
                    echo "<h1 class='Post_header'>" . $title . "</h1>
                                <h2>" . $subtitle . "</h2>
                                <div class='authors_div'>
                                    <div class='authors_div_imgbox'>
                                        <img src='$author_image' alt='Author's Image'/>
                                        <p><span class='span1'>$author_firstname $author_lastname, $role.</span><span class='span3'>$date</span><span class='span3'>$formatted_time</span></p>
                                    </div>
                                    <div class='authors_div_otherdiv'>
                                        <i class='fa fa-clock' aria-hidden='true'></i>
                                        <p>$read_count</p>
                                    </div>
                                </div>
                            ";
                    if (!empty($link)) {
                        echo " <video width='70%' controls>
                                        <source src='" . $link . "' type='video/mp4'>
                                        Your browser does not support the video tag.
                                    </video>";
                    }
                    if (!empty($image)) {
                        echo "   <div class='post_image_div'>
                                    <img src='$image' alt='Post Image'/>
                                </div>
                            ";
                    } elseif (!empty($foreign_imagePath)) {
                        echo "   <div class='post_image_div'>
                                    <img src='$foreign_imagePath' alt='Post Image'/>
                                </div>
                            ";
                    }
                    echo "
                                <div class='socialmedia_links'>
                                    <a href='https://twitter.com/intent/tweet?url=" . $url . "&text=" . $title . " target='_blank'><i class='fa-brands fa-x-twitter'></i></a>
                                    <a href='https://www.facebook.com/sharer/sharer.php?u=$url' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                    <a href='https://www.linkedin.com/shareArticle?mini=true&url={$url}&title={$title}' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                    <a href='https://www.reddit.com/submit?url=$url&title=$title' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                    <a onclick='window.print()' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                    <a href='mailto:?subject=$title&body=$subtitle' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                                </div>
                                <p class='content'>$content</p>
                                <div class='socialmedia_links'>
                                    <a href='https://twitter.com/intent/tweet?url=" . $url . "&text=" . $title . " target='_blank'><i class='fa-brands fa-x-twitter'></i></a>
                                    <a href='https://www.facebook.com/sharer/sharer.php?u=$url' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                    <a href='https://www.linkedin.com/shareArticle?mini=true&url={$url}&title={$title}' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                    <a href='https://www.reddit.com/submit?url=$url&title=$title' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                    <a onclick='window.print()' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                    <a href='mailto:?subject=$title&body=$subtitle' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                                </div>
                                <h3 class='bodyleft_header3'>About the Author</h3>
                                <center>
                                    <a href='../authors/author.php?id=$id_admin$id_editor$id_writer&idtype=$id_type' class='aboutauthor_div'>
                                        <div class='aboutauthor_div_subdiv1'>
                                            <img src='$author_image' alt ='Author's Image'/>
                                        </div>
                                        <div class='aboutauthor_div_subdiv2'>
                                            <p class='p--bold'>$author_firstname $author_lastname</p>
                                            <p class='p--bold2'>$role</p>
                                            <p>$author_bio</p>
                                        </div>
                                    </a>
                                </center>
                            ";
                }
                $otherposts_sql = "SELECT id, title, niche, content, image_path, post_image_url, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM press_releases WHERE id != '$post_id5' ORDER BY date DESC LIMIT 8";
                $otherposts_result = $conn->query($otherposts_sql);
                if ($otherposts_result->num_rows > 0) {
                    echo "<h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>You may also like</h1>
                              <div class='more_posts'>
                        ";
                    while ($row = $otherposts_result->fetch_assoc()) {
                        $id = $row["id"];
                        $max_length2 = 40;
                        $title = $row["title"];
                        $niche = $row["niche"];
                        $image = $row["image_path"];
                        $foreign_imagePath = $row["post_image_url"];
                        $date = $row["formatted_date"];
                        $content = $row["content"];
                        if (strlen($title) > $max_length2) {
                            $title = substr($title, 0, $max_length2) . '...';
                        }
                        $readingTime = calculateReadingTime($row['content']);
                        echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id2=$id'>";
                        if (!empty($image)) {
                            echo "<img src='$image' alt='article image'>";
                        } elseif (!empty($foreign_imagePath)) {
                            echo "<img src='$foreign_imagePath' alt='article image'>";
                        }
                        echo   "
                                    <div class='more_posts_subdiv_subdiv'>
                                        <h1>$title</h1>
                                        <span>$date</span>
                                        <span>$readingTime</span>
                                    </div>
                                    <p class='posts_div_niche'>$niche</p>
                                </a>
                                </div>";
                    }
                }
            }
            ?>
        </div>
        <div class="body_right border-gradient-leftside--lightdark">
            <div class="subscribe_container">
                <form class="sec2__susbribe-box other_width" method="POST" action="" id="susbribe-box">
                    <div class="icon">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </div>
                    <h1 class="sec2__susbribe-box-header">Subscribe to Updates</h1>
                    <p class="sec2__susbribe-box-p1">Get the latest Updates and Info from Uniquetechcontentwriter on Cybersecurity, Artificial Intelligence and lots more.</p>
                    <input class="sec2__susbribe-box_input" type="text" placeholder="Your Email Address..." name="email" required />
                    <input class="sec2__susbribe-box_btn" type="submit" value="Submit" name="submit_btn" />
                </form>
                <div id="thank-you-message"></div>
            </div>
            <h3 class="bodyleft_header3 border-gradient-bottom--lightdark">Editor's Picks</h3>
            <?php include("../helpers/editorspicks.php"); ?>
        </div>
    </div>
    <?php include("../includes/footer2.php"); ?>
    <script>
        const closeMenuBtn = document.querySelector('.sidebarbtn');
        const sidebar = document.getElementById('sidebar');
        const menubtn = document.querySelector('.mainheader__header-nav-2');
        document.addEventListener("DOMContentLoaded", function() {
            const scrollContainer = document.querySelector(".more_posts");
            setTimeout(() => {
                scrollContainer.scrollBy({
                    left: 300,
                    behavior: 'smooth'
                });
            }, 1000);
        });

        function removeHiddenClass(e) {
            e.stopPropagation();
            sidebar.classList.remove('hidden');
        };

        function onClickOutside(element) {
            document.addEventListener('click', e => {
                if (!element.contains(e.target)) {
                    element.classList.add('hidden');
                } else return;
            });
        };

        function shareFunction() {
            const postTitle = "<?php echo addslashes($title1); ?>";
            const postSubtitle = "<?php echo addslashes($subtitle1); ?>";
            const postImage = "<?php echo addslashes($img1); ?>";
            const postUrl = window.location.href;
            const tweetUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(postTitle + ' - ' + postSubtitle)}&url=${encodeURIComponent(postUrl)}&via=yourTwitterHandle&hashtags=yourHashtags`;
            window.open(tweetUrl, "_blank");
        };
        onClickOutside(sidebar);
        menubtn.addEventListener('click', removeHiddenClass);
        closeMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('hidden');
        });
    </script>
    <script>
        document.getElementById("xShareBtn").addEventListener("click", shareFunction);
        document.getElementById("xShareBtn2").addEventListener("click", shareFunction);
        document.getElementById("xShareBtn3").addEventListener("click", shareFunction);
        document.getElementById("xShareBtn4").addEventListener("click", shareFunction);
        document.getElementById("xShareBtn5").addEventListener("click", shareFunction);
        document.getElementById("xShareBtn6").addEventListener("click", shareFunction);
        var messageType = "<?= $_SESSION['status_type'] ?? ' ' ?>";
        var messageText = "<?= $_SESSION['status'] ?? ' ' ?>";
    </script>
    <script>
        const Toast = Swal.mixin({
            customClass: {
                popup: 'rounded-xl shadow-lg',
                title: 'text-lg font-semibold',
                confirmButton: 'bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700'
            },
            buttonsStyling: false,
            backdrop: `rgba(0,0,0,0.4)`,
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });

        if (messageType && messageText.trim() !== "") {
            let iconColors = {
                'Error': '#e74c3c',
                'Success': '#2ecc71',
                'Info': '#3498db'
            };

            Toast.fire({
                icon: messageType.toLowerCase(),
                title: messageText,
                iconColor: iconColors[messageType] || '#3498db',
                confirmButtonText: 'Got it'
            });
        }

        <?php unset($_SESSION['status_type']); ?>
        <?php unset($_SESSION['status']); ?>
    </script>
</body>

</html>