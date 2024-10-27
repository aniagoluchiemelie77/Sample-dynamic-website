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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<title>Create User</title>
</head>
<body>
    <?php require("../extras/header2.php");?>
    <section class="about_section">
        <div class="page_links">
            <a href="../admin_homepage.php">Home</a> > <p>Users</p> > <p> Create User</p>
        </div>
        <form class="formcontainer" id="topicForm" method="post" action="../forms.php" enctype="multipart/form-data">
            <div class="head_paragraph">
                <h3>Create User</h3>
            </div>
            <div class="formcontainer_subdiv">
                <div class="input_group">
                    <label for ="user_firstname">User's Firstname:</label>
                    <input type="text" name="user_firstname" id="topicName" required/>
                </div>
                <div class="input_group">
                    <label for ="user_lastname">User's Lastname:</label>
                    <input type="text" name="user_lastname" id="topicName" required/>
                </div>
                <div class="input_group">
                    <label for ="user_email">User's Email:</label>
                    <input type="email" name="user_email" id="topicName" required/>
                </div>
                <div class="input_group">
                    <label for ="user_role">User's Role:</label>
                    <input type="email" name="user_role" id="topicName" required/>
                </div>
                <div class="newpost_container_div5 newpost_subdiv">
                    <label class="form__label" for="user_linkedin_url">Linkedin Url:</label>
                    <div class="newpost_container_div5_subdiv2">
                        <input class="form__input" name="user_linkedin_url" type="text"/>
                        <p class="newpost_subdiv2-p leftp"><span>*</span>Enter Linkedin Url (optional)</p>
                    </div>
                </div>
                <div class="newpost_container_div6 newpost_subdiv">
                    <label class="form__label" for="Img">User's Image:</label>
                    <div class="newpost_subdiv2">
                        <input class="form__input" name="Img" type="file" required/>
                    </div>
                </div>
            </div>
            <input class="formcontainer_submit" value="Create" type="submit" name="create_user"/>
        </form>
    </section> 
    <script src="../admin.js"></script>
    <script src="sweetalert2.all.min.js"></script>
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