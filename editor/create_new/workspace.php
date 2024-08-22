<?php
session_start();
include "../connect.php";
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
	<title>Draft</title>
</head>
<body>
    <header class="header">
        <div class="header_logobox">
            <img src="#" alt="Website Logo">
        </div>
        <form class="header_searchbar" action="" method="get">
            <input type="text" name="search" placeholder="Search.." />
            <button class="fa fa-search" id="tutorial_name" aria-hidden="true" name="search_btn" type="submit" formenctype="text/plain"></button>
        </form>
        <div class="header_img">
            <a class="notification" href="#">
                <span></span>
                <i class="fa fa-bell" aria-hidden="true"></i>
            </a>
            <img src="images\image1.jpeg" alt="Author's Image"/>
        </div>
    </header>
    <section class="body">
        <div class="sidebar">
            <div class="sidebar_workspace_container workspacediv">
                <?php 
                $query5 = mysqli_query($conn, "SELECT * FROM workspaces ORDER BY 'id' DESC LIMIT 3");
                while($row = mysqli_fetch_array($query5)){
                    $workspacename = $row['workspace_name'];
                    $content = Substr($row['content'],0, 10);
                }?>
                <div id="workspaces" class="sidebar_workspace_container_subdiv">
                    <div class="sidebar_workspace1 active3" name="stored_workspaces">
                    </div>
                    <label for="stored_workspaces"></label>
                </div>
                <div class="border-gradient-top-light sidebar_workspace_container_subdiv2">
                    <div class="sidebar_workspace" id="workspace_creator">
                        <p class="darkp">New Workspace</p>
                    </div>
                </div>
            </div>
            <p class="sidebar_footer">
                &copy; uniquetechcontentwriter 2024
            </p>
        </div>
        <div class="aside_sidebar">
            <form class="workspace_container" action="../forms.php" method="post">
                <textarea name="workspace_content" id="workspace_area"></textarea>
                <input type="text" name="workspace_name" placeholder="Save As.." class="workspace_input1"/>
                <input type="submit" name="workspace_submit" value="Save" class="workspace_input2"/>
            </form>
        </div>        
    </section>
    <script src="../admin.js"></script>
</body>
</html>