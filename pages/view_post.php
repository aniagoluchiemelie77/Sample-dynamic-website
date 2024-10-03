<?php
session_start();
require("../connect.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
$post_id = isset($_GET['id1']) ? intval($_GET['id1']) : 0;
$post_id2 = isset($_GET['id2']) ? intval($_GET['id2']) : 0;
$post_id3 = isset($_GET['id3']) ? intval($_GET['id3']) : 0;
$post_id4 = isset($_GET['id4']) ? intval($_GET['id4']) : 0;
$post_id5 = isset($_GET['id5']) ? intval($_GET['id5']) : 0;
$url = "http://localhost/Sample-dynamic-website";
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
    <?php require("../includes/header2.php");?>
    <div class="body_container">
        <div class="body_left">
            <div class="page_links">
                <a href="../">Home</a> > <p>View Post</p>
            </div>
            <?php
                $getniche_sql = " SELECT name FROM topics ORDER BY id";
                $getniche_result = $conn->query($getniche_sql);
                if ($getniche_result->num_rows > 0) {
                    if (!function_exists('convertToReadable')) {
                        function convertToReadable($slug) {
                            $string = str_replace('-', ' ', $slug);
                            $string = ucwords($string);
                            return $string;
                        }
                    }
                    if (!function_exists('removeHyphen')) {
                        function removeHyphen($string) {
                            $string = str_replace(['-', ' '], '', $string);
                            return $string;
                        }
                    }
                    echo "<div class='body_left_relatedniches'>";
                    while($row = $getniche_result->fetch_assoc()) {
                        $category_name = $row['name'];
                        $cleanString = removeHyphen($category_name);
                        $readableString = convertToReadable($category_name);
                        echo "<a href='$cleanString.php'>$readableString</a>";
                    }
                    echo "</div>";
                }
                if ($post_id > 0) {
                    $getposts_sql = " SELECT id, admin_id, title, niche, content, subtitle, image_path, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date, authors_firstname, authors_lastname, about_author, link FROM paid_posts WHERE id = '$post_id' LIMIT 1";
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
                        $date = $row['formatted_date'];
                        $id = $row['id'];
                        $admin_id = $row['admin_id'];
                        $link = $row['link'];
                        $formatted_time = date("g:i A", strtotime($time));
                        $selectwriter = "SELECT id, firstname, lastname, bio, image FROM admin_login_info WHERE id = '$admin_id'";
                        $selectwriter_result = $conn->query($selectwriter);
                        if ($selectwriter_result->num_rows > 0) {
                            $read_count = '';
                            if (!function_exists('calculateReadingTime')) {
                                function calculateReadingTime($content) {
                                    $wordCount = str_word_count(strip_tags($content));
                                    $minutes = floor($wordCount / 200);
                                    return $minutes  . ' mins read ';
                                }
                                $read_count = calculateReadingTime($content);
                            }
                            while($row = $selectwriter_result->fetch_assoc()) {
                                $bio = $row["bio"];
                                $max_length = 250;
                                if (strlen($bio) > $max_length) {
                                    $bio = substr($bio, 0, $max_length) . '...';
                                }
                                echo "<h1 class='Post_header'>".$title."</h1>
                                        <h2>".$subtitle."</h2>
                                        <div class='authors_div'>
                                            <div class='authors_div_imgbox'>
                                                <img src='../".$row['image']."' alt='Author's Image'/>
                                                <p><span class='span1'>".$row['firstname']."  ".$row['lastname'].", Editor-in-chief, Uniquetechcontentwriter.</span><span class='span3'>".$date."</span><span class='span3'>".$formatted_time."</span></p>
                                            </div>
                                            <div class='authors_div_otherdiv'>
                                                <i class='fa fa-clock' aria-hidden='true'></i>
                                                <p>$read_count</p>
                                            </div>
                                        </div>
                                        <video width='70%' controls>
                                            <source src='".$link."' type='video/mp4'>
                                            Your browser does not support the video tag.
                                        </video>
                                        <div class='post_image_div'>
                                            <img src='../".$image."' alt='Post Image'/>
                                            <span>Source: Getty Images</span>
                                        </div>
                                        <div class='socialmedia_links'>
                                            <a href='https://twitter.com/intent/tweet?url=<?php echo urlencode(".$url."); ?>&text=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fa-brands fa-x-twitter'></i></a>
                                            <a href='https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                            <a href='https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                            <a href='https://www.reddit.com/submit?url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                            <a onclick='window.print() return false;' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                            <a href='mailto:?subject=<?php echo urlencode(".$title."); ?>&body=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                                        </div>
                                        <p>".$content."</p>
                                        <div class='socialmedia_links'>
                                            <a href='https://twitter.com/intent/tweet?url=<?php echo urlencode(".$url."); ?>&text=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fa-brands fa-x-twitter'></i></a>
                                            <a href='https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                            <a href='https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                            <a href='https://www.reddit.com/submit?url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                            <a onclick='window.print() return false;' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                            <a href='mailto:?subject=<?php echo urlencode(".$title."); ?>&body=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                                        </div>
                                        <h3 class='bodyleft_header3'>About the Author</h3>
                                        <center>
                                            <a href='../authors/author.php?idtype=$idtype&id=$admin_id' class='aboutauthor_div'>
                                                <div class='aboutauthor_div_subdiv1'>
                                                    <img src='../".$row['image']."' alt ='Author's Image'/>
                                                </div>
                                                <div class='aboutauthor_div_subdiv2'>
                                                    <p class='p--bold'>".$row['firstname']." ".$row['lastname'].", Editor-in-chief, Uniquetechcontentwriter.</p>
                                                    <p>".$bio."</p>
                                                </div>
                                            </a>
                                            <div class = 'subscribe_div'>
                                                <p>Keep up with the latest cybersecurity threats, newly discovered vulnerabilities, data breach information, and emerging trends. Delivered daily or weekly right to your email inbox.</p>
                                                <a class ='mainheader__signupbtn'>Subscribe</a>
                                            </div>
                                        </center>
                                    ";
                            }
                        }
                    }
                    $otherpaidposts_sql = "SELECT id, title, niche, content, image_path, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM paid_posts WHERE id != '$post_id' ORDER BY date DESC";
                    $otherpaidposts_result = $conn->query($otherpaidposts_sql);
                    if ($otherpaidposts_result->num_rows > 0) {
                        echo "<h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>You may also like</h1>
                              <div class='more_posts'>
                        ";
                        if (!function_exists('calculateReadingTime')) {
                            function calculateReadingTime($content) {
                                $wordCount = str_word_count(strip_tags($content));
                                $minutes = floor($wordCount / 200);
                                return $minutes  . ' mins read ';
                            }
                        }
                        while ($row = $otherpaidposts_result->fetch_assoc()) {
                            $id = $row["id"];
                            $max_length2 = 120;
                            $title = $row["title"];
                            $niche = $row["niche"];
                            $image = $row["image_path"];
                            $date = $row["formatted_date"];
                            $content = $row["content"];
                            if (strlen($title) > $max_length2) {
                                $title = substr($title, 0, $max_length2) . '...';
                            }
                            $readingTime = calculateReadingTime($row['content']);
                            echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id1=$id'>
                                    <img src='../images/$image' alt = 'Post Image'/>
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
                if ($post_id2 > 0) {
                    $getposts_sql = " SELECT id,admin_id, editor_id, title, niche, content, subtitle, image_path, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date, authors_firstname, authors_lastname, about_author, link FROM posts WHERE id = '$post_id2'";
                    $getposts_result = $conn->query($getposts_sql);
                    if ($getposts_result->num_rows > 0) {
                        $row = $getposts_result->fetch_assoc();
                        $author_firstname = "";
                        $author_lastname = "";
                        $author_image = "";
                        $author_bio = "";
                        $id_type = '';
                        $role = "";
                        $id_admin="";
                        $id_editor="";
                        $id_writer="";
                        $time = $row['time'];
                        $title = $row['title'];
                        $niche = $row['niche'];
                        $content = $row['content'];
                        $read_count = '';
                        if (!empty($row['admin_id'])) {
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
                        }
                        elseif (!empty($row['editor_id'])) {
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
                        }
                        else {
                            $author_firstname = $row['author_firstname'];
                            $author_lastname = $row['author_lastname'];
                            $author_bio = $row['author_bio'];
                            $role = 'Contributing Writer';
                            $id_writer = 4;
                            $id_type = "Writer";
                        }
                        $max_length = 200;
                        if (strlen($author_bio) > $max_length) {
                            $author_bio = substr($author_bio, 0, $max_length) . '...';
                        }
                        if (!function_exists('calculateReadingTime')) {
                            function calculateReadingTime($content) {
                                $wordCount = str_word_count(strip_tags($content));
                                $minutes = floor($wordCount / 200);
                                return $minutes  . ' mins read ';
                            }
                            $read_count = calculateReadingTime($content);
                        }
                        $subtitle = $row['subtitle'];
                        $image = $row['image_path'];
                        $date = $row['formatted_date'];
                        $id = $row['id'];
                        $link = $row['link'];
                        $formatted_time = date("g:i A", strtotime($time));
                        echo "<h1 class='Post_header'>".$title."</h1>
                                        <h2>".$subtitle."</h2>
                                        <div class='authors_div'>
                                            <div class='authors_div_imgbox'>
                                                <img src='../$author_image' alt='Author's Image'/>
                                                <p><span class='span1'>$author_firstname $author_lastname, $role.</span><span class='span3'>$date</span><span class='span3'>$formatted_time</span></p>
                                            </div>
                                            <div class='authors_div_otherdiv'>
                                                <i class='fa fa-clock' aria-hidden='true'></i>
                                                <p>$read_count</p>
                                            </div>
                                        </div>
                                        <video width='70%' controls>
                                            <source src='".$link."' type='video/mp4'>
                                            Your browser does not support the video tag.
                                        </video>
                                        <div class='post_image_div'>
                                            <img src='../".$image."' alt='Post Image'/>
                                            <span>Source: Getty Images</span>
                                        </div>
                                        <div class='socialmedia_links'>
                                            <a href='https://twitter.com/intent/tweet?url=<?php echo urlencode(".$url."); ?>&text=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fa-brands fa-x-twitter'></i></a>
                                            <a href='https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                            <a href='https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                            <a href='https://www.reddit.com/submit?url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                            <a onclick='window.print() return false;' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                            <a href='mailto:?subject=<?php echo urlencode(".$title."); ?>&body=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                                        </div>
                                        <p>".$content."</p>
                                        <div class='socialmedia_links'>
                                            <a href='https://twitter.com/intent/tweet?url=<?php echo urlencode(".$url."); ?>&text=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fa-brands fa-x-twitter'></i></a>
                                            <a href='https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                            <a href='https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                            <a href='https://www.reddit.com/submit?url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                            <a onclick='window.print() return false;' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                            <a href='mailto:?subject=<?php echo urlencode(".$title."); ?>&body=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                                        </div>
                                        <h3 class='bodyleft_header3'>About the Author</h3>
                                        <center>
                                            <a href='../authors/author.php?id=$id_admin$id_editor&idtype=$id_type' class='aboutauthor_div'>
                                                <div class='aboutauthor_div_subdiv1'>
                                                    <img src='../$author_image' alt ='Author's Image'/>
                                                </div>
                                                <div class='aboutauthor_div_subdiv2'>
                                                    <p class='p--bold'>$author_firstname $author_lastname, $role.</p>
                                                    <p>$author_bio </p>
                                                </div>
                                            </a>
                                            <div class = 'subscribe_div'>
                                                <p>Keep up with the latest cybersecurity threats, newly discovered vulnerabilities, data breach information, and emerging trends. Delivered daily or weekly right to your email inbox.</p>
                                                <a class ='mainheader__signupbtn'>Subscribe</a>
                                            </div>
                                        </center>
                                    ";
                    }
                    $otherposts_sql = "SELECT id, title, niche, content, image_path, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM posts WHERE id != '$post_id2' ORDER BY date DESC LIMIT 8";
                    $otherposts_result = $conn->query($otherposts_sql);
                    if ($otherposts_result->num_rows > 0) {
                        echo "<h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>You may also like</h1>
                              <div class='more_posts'>
                        ";
                        if (!function_exists('calculateReadingTime')) {
                            function calculateReadingTime($content) {
                                $wordCount = str_word_count(strip_tags($content));
                                $minutes = floor($wordCount / 200);
                                return $minutes  . ' mins read ';
                            }
                        }
                        while ($row = $otherposts_result->fetch_assoc()) {
                            $id = $row["id"];
                            $max_length2 = 600;
                            $title = $row["title"];
                            $niche = $row["niche"];
                            $image = $row["image_path"];
                            $date = $row["formatted_date"];
                            $content = $row["content"];
                            if (strlen($title) > $max_length2) {
                                $title = substr($title, 0, $max_length2) . '...';
                            }
                            $readingTime = calculateReadingTime($row['content']);
                            echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id2=$id'>
                                    <img src='../$image' alt = 'Post Image'/>
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
                if ($post_id3 > 0) {
                    $getposts_sql = " SELECT id,admin_id, editor_id, title, niche, content, subtitle, image_path, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date, authors_firstname, authors_lastname, about_author, link FROM news WHERE id = '$post_id3'";
                    $getposts_result = $conn->query($getposts_sql);
                    if ($getposts_result->num_rows > 0) {
                        $row = $getposts_result->fetch_assoc();
                        $author_firstname = "";
                        $author_lastname = "";
                        $author_image = "";
                        $author_bio = "";
                        $id_type = '';
                        $role = "";
                        $id_admin="";
                        $id_editor="";
                        $id_writer="";
                        $time = $row['time'];
                        $title = $row['title'];
                        $niche = $row['niche'];
                        $content = $row['content'];
                        $read_count = '';
                        if (!empty($row['admin_id'])) {
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
                        }
                        elseif (!empty($row['editor_id'])) {
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
                        }
                        else {
                            $author_firstname = $row['author_firstname'];
                            $author_lastname = $row['author_lastname'];
                            $sql_writer = "SELECT id, firstname, lastname, image, bio FROM writer WHERE firstname = $author_firstname AND lastname = $author_lastname";
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
                            }else{
                                $author_bio = $row['author_bio'];
                                $role = 'Contributing Writer';
                                $id_writer = '';
                                $id_type = "Writer";
                            }
                        }
                        $max_length = 200;
                        if (strlen($author_bio) > $max_length) {
                            $author_bio = substr($author_bio, 0, $max_length) . '...';
                        }
                        if (!function_exists('calculateReadingTime')) {
                            function calculateReadingTime($content) {
                                $wordCount = str_word_count(strip_tags($content));
                                $minutes = floor($wordCount / 200);
                                return $minutes  . ' mins read ';
                            }
                            $read_count = calculateReadingTime($content);
                        }
                        $subtitle = $row['subtitle'];
                        $image = $row['image_path'];
                        $date = $row['formatted_date'];
                        $id = $row['id'];
                        $link = $row['link'];
                        $formatted_time = date("g:i A", strtotime($time));
                        echo "<h1 class='Post_header'>".$title."</h1>
                                <h2>".$subtitle."</h2>
                                <div class='authors_div'>
                                    <div class='authors_div_imgbox'>
                                        <img src='../$author_image' alt='Author's Image'/>
                                        <p><span class='span1'>$author_firstname $author_lastname, $role.</span><span class='span3'>$date</span><span class='span3'>$formatted_time</span></p>
                                    </div>
                                    <div class='authors_div_otherdiv'>
                                        <i class='fa fa-clock' aria-hidden='true'></i>
                                        <p>$read_count</p>
                                        </div>
                                    </div>
                                    <video width='70%' controls>
                                        <source src='".$link."' type='video/mp4'>
                                        Your browser does not support the video tag.
                                    </video>
                                    <div class='post_image_div'>
                                        <img src='../".$image."' alt='Post Image'/>
                                        <span>Source: Getty Images</span>
                                    </div>
                                    <div class='socialmedia_links'>
                                        <a href='https://twitter.com/intent/tweet?url=<?php echo urlencode(".$url."); ?>&text=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fa-brands fa-x-twitter'></i></a>
                                        <a href='https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                        <a href='https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                        <a href='https://www.reddit.com/submit?url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                        <a onclick='window.print() return false;' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                        <a href='mailto:?subject=<?php echo urlencode(".$title."); ?>&body=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                                    </div>
                                    <p>".$content."</p>
                                    <div class='socialmedia_links'>
                                        <a href='https://twitter.com/intent/tweet?url=<?php echo urlencode(".$url."); ?>&text=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fa-brands fa-x-twitter'></i></a>
                                        <a href='https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                        <a href='https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                        <a href='https://www.reddit.com/submit?url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                        <a onclick='window.print() return false;' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                        <a href='mailto:?subject=<?php echo urlencode(".$title."); ?>&body=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                                    </div>
                                    <h3 class='bodyleft_header3'>About the Author</h3>
                                    <center>
                                        <a href='../authors/author.php?id=$id_admin$id_editor$id_writer&idtype=$id_type' class='aboutauthor_div'>
                                            <div class='aboutauthor_div_subdiv1'>
                                                <img src='../$author_image' alt ='Author's Image'/>
                                            </div>
                                            <div class='aboutauthor_div_subdiv2'>
                                                <p class='p--bold'>$author_firstname $author_lastname, $role.</p>
                                                <p>$author_bio </p>
                                            </div>
                                        </a>
                                        <div class = 'subscribe_div'>
                                            <p>Keep up with the latest cybersecurity threats, newly discovered vulnerabilities, data breach information, and emerging trends. Delivered daily or weekly right to your email inbox.</p>
                                            <a class ='mainheader__signupbtn'>Subscribe</a>
                                        </div>
                                    </center>
                                ";
                    }
                    $otherposts_sql = "SELECT id, title, niche, content, image_path, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM news WHERE id != '$post_id3' ORDER BY date DESC LIMIT 8";
                    $otherposts_result = $conn->query($otherposts_sql);
                    if ($otherposts_result->num_rows > 0) {
                        echo "<h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>You may also like</h1>
                              <div class='more_posts'>
                        ";
                        if (!function_exists('calculateReadingTime')) {
                            function calculateReadingTime($content) {
                                $wordCount = str_word_count(strip_tags($content));
                                $minutes = floor($wordCount / 200);
                                return $minutes  . ' mins read ';
                            }
                        }
                        while ($row = $otherposts_result->fetch_assoc()) {
                            $id = $row["id"];
                            $max_length2 = 60;
                            $title = $row["title"];
                            $niche = $row["niche"];
                            $image = $row["image_path"];
                            $date = $row["formatted_date"];
                            $content = $row["content"];
                            if (strlen($title) > $max_length2) {
                                $title = substr($title, 0, $max_length2) . '...';
                            }
                            $readingTime = calculateReadingTime($row['content']);
                            echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id3=$id'>
                                    <img src='../$image' alt = 'Post Image'/>
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
                if ($post_id4 > 0) {
                    $getposts_sql = " SELECT id,admin_id, editor_id, title, niche, content, subtitle, image_path, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date, authors_firstname, authors_lastname, about_author, link FROM commentaries WHERE id = '$post_id4'";
                    $getposts_result = $conn->query($getposts_sql);
                    if ($getposts_result->num_rows > 0) {
                        $row = $getposts_result->fetch_assoc();
                        $author_firstname = "";
                        $author_lastname = "";
                        $author_image = "";
                        $author_bio = "";
                        $id_type = '';
                        $role = "";
                        $id_admin="";
                        $id_editor="";
                        $id_writer="";
                        $time = $row['time'];
                        $title = $row['title'];
                        $niche = $row['niche'];
                        $content = $row['content'];
                        $read_count = '';
                        if (!empty($row['admin_id'])) {
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
                        }
                        elseif (!empty($row['editor_id'])) {
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
                        }
                        else {
                            $author_firstname = $row['author_firstname'];
                            $author_lastname = $row['author_lastname'];
                            $sql_writer = "SELECT id, firstname, lastname, image, bio FROM writer WHERE firstname = $author_firstname AND lastname = $author_lastname";
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
                            }else{
                                $author_bio = $row['author_bio'];
                                $role = 'Contributing Writer';
                                $id_writer = '';
                                $id_type = "Writer";
                            }
                        }
                        $max_length = 200;
                        if (strlen($author_bio) > $max_length) {
                            $author_bio = substr($author_bio, 0, $max_length) . '...';
                        }
                        if (!function_exists('calculateReadingTime')) {
                            function calculateReadingTime($content) {
                                $wordCount = str_word_count(strip_tags($content));
                                $minutes = floor($wordCount / 200);
                                return $minutes  . ' mins read ';
                            }
                            $read_count = calculateReadingTime($content);
                        }
                        $subtitle = $row['subtitle'];
                        $image = $row['image_path'];
                        $date = $row['formatted_date'];
                        $id = $row['id'];
                        $link = $row['link'];
                        $formatted_time = date("g:i A", strtotime($time));
                        echo "<h1 class='Post_header'>".$title."</h1>
                                <h2>".$subtitle."</h2>
                                <div class='authors_div'>
                                    <div class='authors_div_imgbox'>
                                        <img src='../$author_image' alt='Author's Image'/>
                                        <p><span class='span1'>$author_firstname $author_lastname, $role.</span><span class='span3'>$date</span><span class='span3'>$formatted_time</span></p>
                                    </div>
                                    <div class='authors_div_otherdiv'>
                                        <i class='fa fa-clock' aria-hidden='true'></i>
                                        <p>$read_count</p>
                                    </div>
                                </div>
                                <video width='70%' controls>
                                    <source src='".$link."' type='video/mp4'>
                                    Your browser does not support the video tag.
                                </video>
                                <div class='post_image_div'>
                                    <img src='../".$image."' alt='Post Image'/>
                                    <span>Source: Getty Images</span>
                                </div>
                                <div class='socialmedia_links'>
                                    <a href='https://twitter.com/intent/tweet?url=<?php echo urlencode(".$url."); ?>&text=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fa-brands fa-x-twitter'></i></a>
                                    <a href='https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                    <a href='https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                    <a href='https://www.reddit.com/submit?url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                    <a onclick='window.print() return false;' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                    <a href='mailto:?subject=<?php echo urlencode(".$title."); ?>&body=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                                </div>
                                <p>".$content."</p>
                                <div class='socialmedia_links'>
                                    <a href='https://twitter.com/intent/tweet?url=<?php echo urlencode(".$url."); ?>&text=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fa-brands fa-x-twitter'></i></a>
                                    <a href='https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                    <a href='https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                    <a href='https://www.reddit.com/submit?url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                    <a onclick='window.print() return false;' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                    <a href='mailto:?subject=<?php echo urlencode(".$title."); ?>&body=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                                </div>
                                <h3 class='bodyleft_header3'>About the Author</h3>
                                <center>
                                    <a href='../authors/author.php?id=$id_admin$id_editor$id_writer&idtype=$id_type' class='aboutauthor_div'>
                                        <div class='aboutauthor_div_subdiv1'>
                                            <img src='../$author_image' alt ='Author's Image'/>
                                        </div>
                                        <div class='aboutauthor_div_subdiv2'>
                                            <p class='p--bold'>$author_firstname $author_lastname, $role.</p>
                                            <p>$author_bio </p>
                                        </div>
                                    </a>
                                    <div class = 'subscribe_div'>
                                        <p>Keep up with the latest cybersecurity threats, newly discovered vulnerabilities, data breach information, and emerging trends. Delivered daily or weekly right to your email inbox.</p>
                                        <a class ='mainheader__signupbtn'>Subscribe</a>
                                    </div>
                                </center>
                                ";
                    }
                    $otherposts_sql = "SELECT id, title, niche, content, image_path, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM commentaries WHERE id != '$post_id4' ORDER BY date DESC LIMIT 8";
                    $otherposts_result = $conn->query($otherposts_sql);
                    if ($otherposts_result->num_rows > 0) {
                        echo "<h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>You may also like</h1>
                              <div class='more_posts'>
                        ";
                        if (!function_exists('calculateReadingTime')) {
                            function calculateReadingTime($content) {
                                $wordCount = str_word_count(strip_tags($content));
                                $minutes = floor($wordCount / 200);
                                return $minutes  . ' mins read ';
                            }
                        }
                        while ($row = $otherposts_result->fetch_assoc()) {
                            $id = $row["id"];
                            $max_length2 = 60;
                            $title = $row["title"];
                            $niche = $row["niche"];
                            $image = $row["image_path"];
                            $date = $row["formatted_date"];
                            $content = $row["content"];
                            if (strlen($title) > $max_length2) {
                                $title = substr($title, 0, $max_length2) . '...';
                            }
                            $readingTime = calculateReadingTime($row['content']);
                            echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id3=$id'>
                                    <img src='../$image' alt = 'Post Image'/>
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
                if ($post_id5 > 0) {
                    $getposts_sql = " SELECT id,admin_id, editor_id, title, niche, content, subtitle, image_path, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date, authors_firstname, authors_lastname, about_author, link FROM press_releases WHERE id = '$post_id5'";
                    $getposts_result = $conn->query($getposts_sql);
                    if ($getposts_result->num_rows > 0) {
                        $row = $getposts_result->fetch_assoc();
                        $author_firstname = "";
                        $author_lastname = "";
                        $author_image = "";
                        $author_bio = "";
                        $id_type = '';
                        $role = "";
                        $id_admin="";
                        $id_editor="";
                        $id_writer="";
                        $time = $row['time'];
                        $title = $row['title'];
                        $niche = $row['niche'];
                        $content = $row['content'];
                        $read_count = '';
                        if (!empty($row['admin_id'])) {
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
                        }
                        elseif (!empty($row['editor_id'])) {
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
                        }
                        else {
                            $author_firstname = $row['author_firstname'];
                            $author_lastname = $row['author_lastname'];
                            $sql_writer = "SELECT id, firstname, lastname, image, bio FROM writer WHERE firstname = $author_firstname AND lastname = $author_lastname";
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
                            }else{
                                $author_bio = $row['author_bio'];
                                $role = 'Contributing Writer';
                                $id_writer = '';
                                $id_type = "Writer";
                            }
                            $author_bio = $row['author_bio'];
                            $role = 'Contributing Writer';
                            $id_writer = 4;
                            $id_type = "Writer";
                        }
                        $max_length = 200;
                        if (strlen($author_bio) > $max_length) {
                            $author_bio = substr($author_bio, 0, $max_length) . '...';
                        }
                        if (!function_exists('calculateReadingTime')) {
                            function calculateReadingTime($content) {
                                $wordCount = str_word_count(strip_tags($content));
                                $minutes = floor($wordCount / 200);
                                return $minutes  . ' mins read ';
                            }
                            $read_count = calculateReadingTime($content);
                        }
                        $subtitle = $row['subtitle'];
                        $image = $row['image_path'];
                        $date = $row['formatted_date'];
                        $id = $row['id'];
                        $link = $row['link'];
                        $formatted_time = date("g:i A", strtotime($time));
                        echo "<h1 class='Post_header'>".$title."</h1>
                                        <h2>".$subtitle."</h2>
                                        <div class='authors_div'>
                                            <div class='authors_div_imgbox'>
                                                <img src='../$author_image' alt='Author's Image'/>
                                                <p><span class='span1'>$author_firstname $author_lastname, $role.</span><span class='span3'>$date</span><span class='span3'>$formatted_time</span></p>
                                            </div>
                                            <div class='authors_div_otherdiv'>
                                                <i class='fa fa-clock' aria-hidden='true'></i>
                                                <p>$read_count</p>
                                            </div>
                                        </div>
                                        <video width='70%' controls>
                                            <source src='".$link."' type='video/mp4'>
                                            Your browser does not support the video tag.
                                        </video>
                                        <div class='post_image_div'>
                                            <img src='../".$image."' alt='Post Image'/>
                                            <span>Source: Getty Images</span>
                                        </div>
                                        <div class='socialmedia_links'>
                                            <a href='https://twitter.com/intent/tweet?url=<?php echo urlencode(".$url."); ?>&text=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fa-brands fa-x-twitter'></i></a>
                                            <a href='https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                            <a href='https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                            <a href='https://www.reddit.com/submit?url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                            <a onclick='window.print() return false;' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                            <a href='mailto:?subject=<?php echo urlencode(".$title."); ?>&body=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                                        </div>
                                        <p>".$content."</p>
                                        <div class='socialmedia_links'>
                                            <a href='https://twitter.com/intent/tweet?url=<?php echo urlencode(".$url."); ?>&text=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fa-brands fa-x-twitter'></i></a>
                                            <a href='https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fab fa-facebook' aria-hidden='true'></i></a>
                                            <a href='https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-linkedin' aria-hidden='true'></i></a>
                                            <a href='https://www.reddit.com/submit?url=<?php echo urlencode(".$url."); ?>&title=<?php echo urlencode(".$title."); ?>' target='_blank'><i class='fab fa-reddit-alien' aria-hidden='true'></i></a>
                                            <a onclick='window.print() return false;' href='#'><i class='fa fa-print' aria-hidden='true'></i></a>
                                            <a href='mailto:?subject=<?php echo urlencode(".$title."); ?>&body=<?php echo urlencode(".$url."); ?>' target='_blank'><i class='fa fa-envelope' aria-hidden='true'></i></a>
                                        </div>
                                        <h3 class='bodyleft_header3'>About the Author</h3>
                                        <center>
                                            <a href='../authors/author.php?id=$id_admin$id_editor$id_writer&idtype=$id_type' class='aboutauthor_div'>
                                                <div class='aboutauthor_div_subdiv1'>
                                                    <img src='../$author_image' alt ='Author's Image'/>
                                                </div>
                                                <div class='aboutauthor_div_subdiv2'>
                                                    <p class='p--bold'>$author_firstname $author_lastname, $role.</p>
                                                    <p>$author_bio </p>
                                                </div>
                                            </a>
                                            <div class = 'subscribe_div'>
                                                <p>Keep up with the latest cybersecurity threats, newly discovered vulnerabilities, data breach information, and emerging trends. Delivered daily or weekly right to your email inbox.</p>
                                                <a class ='mainheader__signupbtn'>Subscribe</a>
                                            </div>
                                        </center>
                                    ";
                    }
                    $otherposts_sql = "SELECT id, title, niche, content, image_path, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM press_releases WHERE id != '$post_id5' ORDER BY date DESC LIMIT 8";
                    $otherposts_result = $conn->query($otherposts_sql);
                    if ($otherposts_result->num_rows > 0) {
                        echo "<h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>You may also like</h1>
                              <div class='more_posts'>
                        ";
                        if (!function_exists('calculateReadingTime')) {
                            function calculateReadingTime($content) {
                                $wordCount = str_word_count(strip_tags($content));
                                $minutes = floor($wordCount / 200);
                                return $minutes  . ' mins read ';
                            }
                        }
                        while ($row = $otherposts_result->fetch_assoc()) {
                            $id = $row["id"];
                            $max_length2 = 120;
                            $title = $row["title"];
                            $niche = $row["niche"];
                            $image = $row["image_path"];
                            $date = $row["formatted_date"];
                            $content = $row["content"];
                            if (strlen($title) > $max_length2) {
                                $title = substr($title, 0, $max_length2) . '...';
                            }
                            $readingTime = calculateReadingTime($row['content']);
                            echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id2=$id'>
                                    <img src='../images\Pressreleasesimg.png' alt = 'Post Image'/>
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
            <h3 class="bodyleft_header3 border-gradient-bottom--lightdark">Editor's Picks</h3>
            <a class="posts_div" href="#">
                <img src="../images/chibs.jpg" alt="Post's Image"/>
                <p class="posts_div_niche">Cybersecurity</p>
                <h1>Unfixed Microsoft Entra ID Authentification Bypass Threatens Hybrid IDs.</h1>
                <p class="posts_div_otherp">By, <span>Chiemelie Aniagolu, Contributing Writer.</span></p>
                <div class="posts_div_subdiv">
                    <p>Aug 15th, 2024</p>
                    <p>10mins Read.</p>
                </div>
            </a>
            <a class="posts_div" href="#">
                <img src="../images/chibs.jpg" alt="Post's Image"/>
                <p class="posts_div_niche">Cybersecurity</p>
                <h1>Unfixed Microsoft Entra ID Authentification Bypass Threatens Hybrid IDs.</h1>
                <p class="posts_div_otherp">By, <span>Chiemelie Aniagolu, Contributing Writer.</span></p>
                <div class="posts_div_subdiv">
                    <p>Aug 15th, 2024</p>
                    <p>10mins Read.</p>
                </div>
            </a>
            <a class="posts_div" href="#">
                <img src="../images/chibs.jpg" alt="Post's Image"/>
                <p class="posts_div_niche">Cybersecurity</p>
                <h1>Unfixed Microsoft Entra ID Authentification Bypass Threatens Hybrid IDs.</h1>
                <p class="posts_div_otherp">By, <span>Chiemelie Aniagolu, Contributing Writer.</span></p>
                <div class="posts_div_subdiv">
                    <p>Aug 15th, 2024</p>
                    <p>10mins Read.</p>
                </div>
            </a>
            <?php
                $userEmail = " ";
                if(isset($_POST['submit_btn'])){
                    $message = "<div><h1><br>Thank you for subscribing with us.</br></h1>
                        <p>Thank you for subscribing to our email updates, We will keep you updated with the latest updates and information.</p>
                         </div>";
                    $userEmail = $_POST['email'];
                    $email = $userEmail;
                    $mail = new PHPMailer(true);
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;  
                    $mail -> IsSMTP();
                    $mail -> SMTPAuth = true;
                    $mail -> SMTPSecure = "tls";
                    $mail -> Host = "stmp.gmail.com";
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port = 587;
                    $mail -> Username = "aniagoluchiemelie77@gmail.com";
                    $mail -> Password = "otxteulzfnelidgd";
                    $mail -> FromName = "Uniquetechcontentwriter";
                    $mail -> AddAddress ($email);
                    $mail->addReplyTo('aniagoluachiemelie77@gmail.com', 'Information');
                    $mail -> Subject = "Successful Email Updates Subscription";
                    $mail -> isHTML(TRUE);
                    $mail -> Body = $message;
                    if(filter_var($userEmail, FILTER_VALIDATE_EMAIL)){
                        if($mail->preSend()){
                            $msg = "Thank You For Subscribing With Us.";
                        }
                    }else{
                        $msg = "Invalid Email";
                    }
                
                }
                include('../helpers/emailsubscribeform.php');
            ?>
        </div>
    </div>
    <?php include("../includes/footer2.php");?>
    <script src="../index.js"></script>
</body>
</html>