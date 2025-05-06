<?php
session_start();
include("../connect.php");
require('../../init.php');
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="Tech News and Articles website" />
    <meta name="keywords" content="Tech News, Content Writers, Content Strategy" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu Diamaka" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../admin.css" />
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title>User Activities</title>
</head>

<body>
    <?php require("../extras/header2.php"); ?>
    <section class="sectioneer">
        <div class="posts_div1 postsdiv sectioneer_divcontainer">
            <div class="page_links">
                <a href="../admin_homepage.php">Home</a> > <p>Profile</p> > <p>View All Posts</p>
            </div>
            <div class="posts_header">
                <h1>User Activities</h1>
            </div>
            <div class="posts_divcontainer border-gradient-side-dark">
                <?php
                $select_allposts = "SELECT id, content, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM updates ORDER BY id DESC LIMIT 100";
                $select_allposts_result = $conn->query($select_allposts);
                if ($select_allposts_result->num_rows > 0) {
                    while ($row = $select_allposts_result->fetch_assoc()) {
                        $time = $row['time'];
                        $formatted_time = date("g:i A", strtotime($time));
                        echo "<div class='posts_divcontainer_subdiv'>
                                    <div class='posts_divcontainer_subdiv2'>
                                        <p class='posts_divcontainer_p'>" . $row["content"] . "</p>
                                    </div>
                                    <div class='posts_divcontainer_subdiv3'>
                                        <p class='posts_divcontainer_subdiv_p'><span> Publish Date: </span>" . $row["formatted_date"] . "</p> 
                                        <p class='posts_divcontainer_subdiv_p'><span> Publish Time: </span>" . $formatted_time . "</p> 
                                    </div>
                                    <div class='posts_delete_edit'>
                                        <a class='users_edit' href='../edit/post.php?id2=" . $row["id"] . "&title=" . $row["title"] . "'>
                                            <i class='fa fa-pencil' aria-hidden='true'></i>
                                        </a>
                                        <a class='users_delete'>
                                            <i class='fa fa-trash' aria-hidden='true'></i>
                                        </a>
                                    </div>
                                </div>";
                    };
                };

                ?>
            </div>
        </div>
    </section>
</body>

</html>