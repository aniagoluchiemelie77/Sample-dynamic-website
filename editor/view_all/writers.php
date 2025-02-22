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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../editor.js" defer></script>
    <link rel="stylesheet" href="../editor.css"/>
	<title>View Writers</title>
</head>
<body>
    <?php require("../extras/header2.php");?>
    <section class="sectioneer">
        <div class="posts_div1 postsdiv sectioneer_divcontainer">
            <div class="page_links">
                <a href="../editor_homepage.php">Home</a> > <p>Users</p> > <p>View Writers</p>
            </div>
            <div class="posts_header">
                <h1>Writers</h1>
            </div>
            <div class="posts_divcontainer border-gradient-side-dark">
                <?php
                    $select_allposts = "SELECT id, email, image, firstname, lastname, time_joined, DATE_FORMAT(date_joined, '%M %d, %Y') as formatted_date FROM writer ORDER BY id DESC LIMIT 100";
                    $select_allposts_result = $conn->query($select_allposts);
                    if ($select_allposts_result->num_rows > 0) {
                        while($row = $select_allposts_result->fetch_assoc()) {
                            $time = $row['time_joined'];
                            $formatted_time = date("g:i A", strtotime($time));
                            echo"<div class='posts_divcontainer_subdiv editor_div'>
                                    <img src='../../". $row["image"]."' alt='Editor Image'/>
                                    <div class='editor_div-body'>
                                        <h3 class='posts_divcontainer_header'>". $row["firstname"]." ". $row["lastname"]."</h3>
                                        <div class='posts_divcontainer_subdiv2'>
                                            <p class='posts_divcontainer_p'><span> Email: </span>". $row["email"]."</p>
                                            <p class='posts_divcontainer_p'><span> Date Joined: </span>". $row["formatted_date"]."</p>
                                            <p class='posts_divcontainer_p'><span> Time: </span>$formatted_time</p>
                                        </div>
                                        <form action='../promote_writer.php' method='POST' class='posts_delete_edit'>
                                            <input type='hidden' name='writer_id' value='".$row["id"]."'>
                                            <button type='submit' class='promote_button users_delete btn'>Promote to Editor</button>
                                        </form>
                                        <div class='posts_delete_edit'>
                                            <a class='users_edit' href='../edit/user.php?id=".$row['id']."&usertype=Writer'>
                                                <i class='fa fa-pencil' aria-hidden='true'></i>
                                            </a>
                                            <a class='users_delete' onclick='confirmDeleteWriter(".$row['id'].")'>
                                                <i class='fa fa-trash' aria-hidden='true'></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>";                           
                        };
                    };

                ?>
            </div>
    </section>
    <script src="sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="https://cdn.tiny.cloud/1/mshrla4r3p3tt6dmx5hu0qocnq1fowwxrzdjjuzh49djvu2p/tinymce/6/tinymce.min.js"></script>
    <script>
        var messageType = "<?= $_SESSION['status_type']?? ' '?>";
        var messageText = "<?= $_SESSION['status']?? ' '?>";
        if (messageType == 'Error' && messageText != " "){
            Swal.fire({
                title: 'Error!',
                text: messageText,
                icon: 'error',
                confirmButtonText: 'Ok'
            })  
        }else if (messageType == 'Success' && messageText != " "){
            Swal.fire({
                title: 'Success',
                text: messageText,
                icon: 'success',
                confirmButtonText: 'Ok'
            })  
        }
        <?php unset($_SESSION['status_type']);?>
        <?php unset($_SESSION['status']);?>
    </script>
</body>
</html>