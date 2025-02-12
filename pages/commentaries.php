<?php
    session_start();
    require('../connect.php');
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
	<title>Commentaries</title>
    </head>
    <body id="container">
        <?php require("../includes/header2.php");?>
        <div class="body_container">
            <div class="body_left">
                <div class="page_links">
                    <a href="../">Home</a> > <p>Commentaries</p>
                </div>
                <h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>Latest Commentaries</h1>
                <div class='more_posts'>;
                <?php
                    $selectnewsposts_sql = "SELECT id, title, niche, content, image_path, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM commentaries ORDER BY id DESC LIMIT 12";
                    $selectnewsposts_result = $conn->query($selectnewsposts_sql);
                    if ($selectnewsposts_result->num_rows > 0) {
                        $i = 0;
                        if (!function_exists('calculateReadingTime')) {
                            function calculateReadingTime($content) {
                                $wordCount = str_word_count(strip_tags($content));
                                $minutes = floor($wordCount / 200);
                                return $minutes  . ' mins read ';
                            }
                        }
                        while($row = $selectnewsposts_result->fetch_assoc()) {
                            $id = $row["id"];
                            $i++;
                            $title = $row["title"];
                            $niche = $row["niche"];
                            $image = $row["image_path"];
                            $date = $row["formatted_date"];
                            $content = $row["content"];
                            $readingTime = calculateReadingTime($row['content']);
                            if (!function_exists('calculateReadingTime')) {
                                function calculateReadingTime($content) {
                                    $wordCount = str_word_count(strip_tags($content));
                                    $minutes = floor($wordCount / 200);
                                    return $minutes  . ' mins read ';
                                }
                            }
                            echo "<a class='more_posts_subdiv' href='view_post.php?id4=$id'>
                                    <img src='../$image' alt = 'Post's Image'/>
                                    <div class='more_posts_subdiv_subdiv'>
                                        <h1>$title</h1>
                                        <span>$date</span>
                                        <span>$readingTime</span>
                                    </div>
                                    <p class='posts_div_niche'>$niche</p>
                                </a>";
                        }
                    }
                ?>
                </div>
            </div>
            <div class="body_right border-gradient-leftside--lightdark">
                <?php include('../helpers/emailsubscribeform.php');?>
            </div>
        </div>
        <section class="section2">
            <div class="section2__div1">
                <div class="search_div" id="result"></div>
                <div class="section2__div1__header headers">
                    <h1>For You</h1>
                </div>
                <?php
                    $selectposts_sql = "SELECT id, admin_id, editor_id, authors_firstname, authors_lastname, about_author, title, niche, content, image_path, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM posts ORDER BY id DESC LIMIT 15";
                    $selectposts_result = $conn->query($selectposts_sql);
                    $author_firstname = "";
                    $author_lastname = "";
                    $author_image = "";
                    $author_bio = "";
                    $id_type = '';
                    $role = "";
                    if ($selectposts_result->num_rows > 0) {
                        $i = 0;
                        if (!function_exists('calculateReadingTime')) {
                            function calculateReadingTime($content) {
                                $wordCount = str_word_count(strip_tags($content));
                                $minutes = floor($wordCount / 200);
                                return $minutes  . ' mins read ';
                            }
                        }
                        while($row = $selectposts_result->fetch_assoc()) {
                            $id = $row["id"];
                            $i++;
                            $title = $row["title"];
                            $niche = $row["niche"];
                            $image = $row["image_path"];
                            $date = $row["formatted_date"];
                            $content = $row["content"];
                            $readingTime = calculateReadingTime($row['content']);
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
                            echo "
                            <div class='section2__div1__div1 normal-divs'>
                                    <a class='normal-divs__subdiv' href='view_post.php? id2=".$row["id"]."'>
                                        <img src='../$image' alt='article image'>
                                        <div class='normal-divs__subdiv__div'>
                                            <h1 class='normal-divs__header'>$niche</h1>
                                            <h2 class='normal-divs__title'>$title</h2>
                                            <div>
                                                <p class='normal-divs__releasedate firstp'>$date</p>
                                                <p class='normal-divs__releasedate'><i class='fa fa-clock' aria-hidden='true'></i> $readingTime</p>
                                            </div>
                                        </div>
                                    </a>
                                    <div class='normal-divs__subdiv2'>
                                        <img src='../$author_image' alt='article image'>
                                        <p class='normal-divs__subdiv2__p'>By <span>$author_firstname $author_lastname, </span><span>$role</span></p>
                                    </div>
                            </div>";
                        }
                    }
                ?>
            </div>
        </section>
        <script src="../index.js"></script>
    </body>
</html>