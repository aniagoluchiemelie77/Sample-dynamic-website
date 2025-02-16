<?php
session_start();
include("../connect.php")
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
	<title>Edit Profile</title>
</head>
<body>
    <?php require("../extras/header2.php");?>
    <div class="editprofile_container">
        <form class="create_editor_container" action="../forms.php" method="post" enctype="multipart/form-data">
            <div class="createeditor_inputgroup">
                <h1 class="bigheader">Edit Profile</h1>
            </div>
            <div class='newpost_container_div6 newpost_subdiv'>
                <div class='newpost_container_div6_subdiv1'>
                    <img src='../../<?php echo $_SESSION['image']; ?>' alt='Post Image'/>
                </div>
                <div class='newpost_container_div6_subdiv2'>
                    <label class='form__label' for='Img'>Edit Image: </label>
                    <div class='newpost_subdiv2'>
                        <input class='form__input' name='Img' type='file' required/>
                    </div>
                </div>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile_firstname">Firstname:</label>
                <input class="createeditor_input" type="text" name="profile_firstname" value='<?php echo $_SESSION['firstname'];?>'required/>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile_lastname">Lastname:</label>
                <input class="createeditor_input" type="text" name="profile_lastname" value='<?php echo $_SESSION['lastname']; ?>'required/>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile_username">Username:</label>
                <input class="createeditor_input" type="text" name="profile_username" value='<?php echo $_SESSION['username']; ?>' required/>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile_email">Email:</label>
                <input class="createeditor_input" type="email" name="profile_email" value='<?php echo $_SESSION['email'];?>'required/>
            </div>
            <div class="createeditor_inputgroup flexcolumn">
                <label class="createeditor_label rightmargin nooutline" for="profile_bio">Bio:</label>
                <textarea name="profile_bio" class="textarea" id="myTextarea4"><?php echo $_SESSION['bio']; ?></textarea>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile-address1">Address 1:</label>
                <input class="createeditor_input" type="text" name="profile-address1" value='<?php echo $_SESSION['address'];?>' required/>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile-address2">Address 2:</label>
                <input class="createeditor_input" type="text" name="profile-address2" value='<?php echo $_SESSION['addresstwo'];?>'required/>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile-city">City:</label>
                <input class="createeditor_input" type="text" name="profile-city" value='<?php echo  $_SESSION['city'];?>' required/>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile-state">State:</label>
                <input class="createeditor_input" type="text" name="profile-state" value='<?php echo $_SESSION['state'];?>'required/>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile-country">Country:</label>
                <input class="createeditor_input" type="text" name="profile-country" value='<?php echo $_SESSION['country']; ?>'required/>
            </div>
            <div class="createeditor_inputgroup">
                <div class="createeditor_inputgroup">
                    <label class="createeditor_label rightmargin" for="profile-countrycode">Country Code:</label>
                    <input class="createeditor_input" type="text" name="profile-countrycode" value='<?php echo $_SESSION['country_code']; ?>'required/>
                </div>
                <div class="createeditor_inputgroup">
                    <label class="createeditor_label rightmargin" for="profile-mobile">Phone Number:</label>
                    <input class="createeditor_input" type="number" name="profile-mobile" value='<?php echo $_SESSION['mobile']; ?>'required/>
                </div>
            </div>
            <input class="createeditor_input-submit" value="Update" name="edit_profile" type="submit"/>
        </form>
    </div>
    <script type="text/javascript" src="https://cdn.tiny.cloud/1/mshrla4r3p3tt6dmx5hu0qocnq1fowwxrzdjjuzh49djvu2p/tinymce/6/tinymce.min.js"></script>
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