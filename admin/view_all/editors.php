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
    <link rel="stylesheet" href="../admin.css"/>
	<title>View Editors</title>
</head>
<body>
    <?php require("../extras/header2.php");?>
    <section class="sectioneer">
        <div class="posts_div1 postsdiv sectioneer_divcontainer">
            <div class="page_links">
                <a href="../admin_homepage.php">Home</a> > <p>Users</p> > <p>View Editors</p>
            </div>
            <div class="posts_header">
                <h1>Editors</h1>
            </div>
            <div class="posts_divcontainer border-gradient-side-dark">
                <?php
                    $select_allposts = "SELECT id, username, email, image, firstname, lastname, country FROM editor ORDER BY id DESC LIMIT 100";
                    $select_allposts_result = $conn->query($select_allposts);
                    if ($select_allposts_result->num_rows > 0) {
                        while($row = $select_allposts_result->fetch_assoc()) {
                            echo"<div class='posts_divcontainer_subdiv editor_div'>
                                    <img src='../../". $row["image"]."' alt='Editor Image'/>
                                    <div class='editor_div-body'>
                                        <h3 class='posts_divcontainer_header'>". $row["firstname"]." ". $row["lastname"]." ( ". $row["username"]." )</h3>
                                        <div class='posts_divcontainer_subdiv2'>
                                            <p class='posts_divcontainer_p'><span> Email: </span>". $row["email"]."</p>
                                            <p class='posts_divcontainer_p'><span> Nationality: </span>". $row["country"]."</p>
                                        </div>
                                        <div class='posts_delete_edit'>
                                            <a class='users_edit' href='../edit/user.php?id=".$row["id"]."&usertype=Editor'>
                                                <i class='fa fa-pencil' aria-hidden='true'></i>
                                            </a>
                                            <a class='users_delete' onclick='confirmDeleteEditor(".$row["id"].")'>
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
    <script>
        function confirmDeleteEditor(Id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#F93404',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../delete.php?id=' + Id + '&usertype=Editor';
                }
            })
        }
    </script>
</body>
</html>