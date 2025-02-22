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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu Diamaka"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../editor.css"/>
	<title>User Activities</title>
</head>
<body>
    <?php require("../extras/header2.php");?>
    <section class="sectioneer">
        <div class="posts_div1 postsdiv sectioneer_divcontainer">
            <div class="page_links">
                <a href="../editor_homepage.php">Home</a> > <p>Profile</p> > <p>User Activities</p>
            </div>
            <div class="posts_header">
                <h1>User Activities</h1>
            </div>
            <div class="posts_divcontainer border-gradient-side-dark">
                <?php
                    $select_commentaries= "SELECT id, content, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM updates ORDER BY id DESC LIMIT 100";
                    $select_commentaries_result = $conn->query($select_commentaries);
                    if ($select_commentaries_result->num_rows > 0) {
                        while($row = $select_commentaries_result->fetch_assoc()) {
                            $time = $row['time'];
                            $formatted_time = date("g:i A", strtotime($time));
                            echo "<div class='posts_divcontainer_subdiv'>
                                    <h3 class='posts_divcontainer_header'>". $row["content"]."</h3>
                                    <div class='posts_divcontainer_subdiv3'>
                                        <p class='posts_divcontainer_subdiv_p'><span> Publish Date: </span>". $row["formatted_date"]."</p> 
                                        <p class='posts_divcontainer_subdiv_p'><span> Publish Time: </span>".$formatted_time."</p> 
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