<?php
session_start();
require ("../connect.php");
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
    <link rel="stylesheet" href="../admin.css"/>
    <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdn.anychart.com/releases/8.0.1/js/anychart-core.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.0.1/js/anychart-pie.min.js"></script>
	<title>Categories</title>
</head>
<body>
    <?php require("../extras/header.php");?>
    <section class="about_section">
        <div class="about_header">
            <h1>Categories</h1>
        </div>
        <div class="about_section_topicsdiv">
            <div class="about_section_topicsdiv_subdiv">
                <img src="../../images/image1.jpeg" alt="Topic's Image"/>
                <div class="about_section_topicsdiv_subdiv_subdiv">
                    <h1><span>Cybersecurity</span></h1>
                    <p>Posts about Topic: <span>30</span>
                    <p>Date created: <span>June 24th 2024</span></p>
                    <a class="topics_actions">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <div class="about_section_topicsdiv_subdiv">
                <img src="../images/AI_image.jpeg" alt="Topic's Image"/>
                <div class="about_section_topicsdiv_subdiv_subdiv">
                    <h1><span>Artificial Intelligence</span></h1>
                    <p>Posts about Topic: <span>30</span>
                    <p>Date created: <span>June 24th 2024</span></p>
                    <a class="topics_actions">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <div class="about_section_topicsdiv_subdiv">
                <img src="../images/dataanalytics.jpeg" alt="Topic's Image"/>
                <div class="about_section_topicsdiv_subdiv_subdiv">
                    <h1><span>Data Analytics</span></h1>
                    <p>Posts about Topic: <span>30</span>
                    <p>Date created: <span>June 24th 2024</span></p>
                    <a class="topics_actions">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <div class="about_section_topicsdiv_subdiv">
                <img src="../images/cloudcomputing2.jpeg" alt="Topic's Image"/>
                <div class="about_section_topicsdiv_subdiv_subdiv">
                    <h1><span>Cloud Computing</span></h1>
                    <p>Posts about Topic: <span>30</span>
                    <p>Date created: <span>June 24th 2024</span></p>
                    <a class="topics_actions">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <a class="about_section_topicsdiv_subdiv-action">
                <div class="actions_subdiv">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </div>
                <p class="actions_p2">Add Category</p>
            </a>
        </div>
    </section>
    <script src="../admin.js"></script>
</body>
</html>