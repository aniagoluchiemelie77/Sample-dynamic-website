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
	<title>Press Releases</title>
    </head>
    <body id="container">
        <?php require("../includes/header2.php");?>
        <div class="body_container">
            <div class="body_left">
                <div class="page_links">
                    <a href="../">Home</a> > <p>Press Releases</p>
                </div>
                <h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>Latest Press Releases</h1>
                <div class='more_posts'>;
                <?php
                    $selectnewsposts_sql = "SELECT id, title, niche, content, image_path, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM press_releases ORDER BY id DESC LIMIT 12";
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
                            echo "<a class='more_posts_subdiv' href='view_post.php?id5=$id'>
                                    <img src='../images\Pressreleasesimg.png' alt = 'Post's Image'/>
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
                <?php include('../includes/pagination.php');?>
            </div>
        </section>
        <?php include ("../includes/footer2.php");?>
        <script src="../index.js"></script>
    </body>
</html>