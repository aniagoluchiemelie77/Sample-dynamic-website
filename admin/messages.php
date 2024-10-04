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
    <link rel="stylesheet" href="admin.css"/>
	<title>Add Message</title>
</head>
<body>
    <?php require("extras/header.php");?>
    <div class="users">
        <div class="users_editor_div userdiv">
            <div class="user_header">
                <h2>Editors</h2>
            </div>
            <div class="users_div_subdiv border-gradient-side-dark">
            <?php
                $selectalleditors = "SELECT id, image, firstname, lastname FROM editor ORDER BY id DESC";
                $selectalleditors_result = $conn->query($selectalleditors);
                if ($selectalleditors_result->num_rows > 0) {
                    $sn = 0;
                    while($row = $selectalleditors_result->fetch_assoc()) {
                        $sn++; 
                        echo "<div class='users_div_subdiv_subdiv divimages' style=background-image:url('../".$row['image']."')>
                                    <div class='divimages_side--back'>
                                        <p class='users_div_subdiv_p'><span>".$row['firstname']."</span></p>
                                        <p class='users_div_subdiv_p'><span>".$row['lastname']."</span></p> 
                                        <center>
                                            <div class='users_delete_edit'>
                                                <a class='users_edit' href='create_new/message.php?id=".$row['id']."&usertype=Editor'>Message</a>
                                            </div>
                                        </center>
                                    </div>
                        </div>";                         
                    };
                };
            ?>
            </div>
        </div>
        <div class="users_writer_div userdiv">
            <div class="user_header">
                <h2>Writers</h2>
            </div>
            <div class="users_div_subdiv border-gradient-side-dark">
                <?php
                    $selectallwriters = "SELECT id, image, firstname, lastname FROM writer ORDER BY id DESC ";
                    $selectallwriters_result = $conn->query($selectallwriters);
                    if ($selectallwriters_result->num_rows > 0) {
                        $sn = 0;
                        while($row = $selectallwriters_result->fetch_assoc()) {
                            $sn++; 
                            echo "<div class='users_div_subdiv_subdiv divimages'style=background-image:url('../".$row['image'].">
                                    <div class='divimages_side--back'>
                                        <p class='users_div_subdiv_p'><span>".$row['firstname']."</span></p>
                                        <p class='users_div_subdiv_p'><span>".$row['lastname']."</span></p> 
                                        <center>
                                            <div class='users_delete_edit'>
                                                <a class='users_edit' href='create_new/message.php?id=".$row['id']."&usertype=Writer'>Message</a>
                                            </div>
                                        </center>
                                    </div>
                            </div>";                         
                        };
                    };
                ?>
            </div>
        </div>
        <div class="users_writer_div userdiv">
            <div class="user_header">
                <h2>Others Users</h2>
            </div>
            <div class="users_div_subdiv border-gradient-side-dark">
                <?php
                    $selectallotherusers = "SELECT id, image, firstname, lastname FROM otherwebsite_users ORDER BY id DESC";
                            $selectallotherusers_result = $conn->query($selectallotherusers);
                            if ($selectallotherusers_result->num_rows > 0) {
                                $sn = 0;
                                while($row = $selectallotherusers_result->fetch_assoc()) {
                                    $sn++; 
                                    echo "<div class='users_div_subdiv_subdiv divimages' style=background-image:url('../".$row['image'].">
                                            <div class='divimages_side--back'>
                                                <p class='users_div_subdiv_p'><span>".$row['firstname']."</span></p>
                                                <p class='users_div_subdiv_p'><span>".$row['lastname']."</span></p> 
                                                <center>
                                                    <div class='users_delete_edit'>
                                                        <a class='users_edit' href='create_new/message.php?id=".$row['id']."&usertype=OtherUser'>Message</a>
                                                    </div>
                                                </center>
                                            </div>
                                    </div>";                         
                                };
                            };
                        ?>
                    </div>
                </div>
            </div>
    <script type="text/javascript" src="https://cdn.tiny.cloud/1/mshrla4r3p3tt6dmx5hu0qocnq1fowwxrzdjjuzh49djvu2p/tinymce/6/tinymce.min.js"></script>
    <script src="admin.js"></script>
</body>
</html>