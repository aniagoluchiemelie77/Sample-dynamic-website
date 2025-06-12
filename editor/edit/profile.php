<?php
session_start();
include("../connect.php");
require("../init.php");
require('../../init.php');
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$translationFile = "../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = []; // Initialize as empty array to avoid undefined variable errors
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../editor.css" />
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['edit_profile']; ?></title>
</head>

<body>
    <?php require("../extras/header3.php"); ?>
    <div class="editprofile_container">
        <form class="create_editor_container" action="../forms.php" method="post" enctype="multipart/form-data">
            <div class="createeditor_inputgroup">
                <h1 class="bigheader"><?php echo $translations['edit_profile']; ?></h1>
            </div>
            <div class='newpost_container_div6 newpost_subdiv'>
                <div class='newpost_container_div6_subdiv1'>
                    <img src='../../<?php echo $_SESSION['image']; ?>' alt='Post Image' />
                </div>
                <div class='newpost_container_div6_subdiv2'>
                    <label class='form__label' for='Img'><?php echo $translations['edit_image']; ?>: </label>
                    <div class='newpost_subdiv2'>
                        <input class='form__input' name='Img' type='file' />
                    </div>
                </div>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile_firstname"><?php echo $translations['firstname']; ?>:</label>
                <input class="createeditor_input" type="text" name="profile_firstname" value='<?php echo $_SESSION['firstname']; ?>' />
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile_lastname"><?php echo $translations['lastname']; ?>:</label>
                <input class="createeditor_input" type="text" name="profile_lastname" value='<?php echo $_SESSION['lastname']; ?>' />
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile_username"><?php echo $translations['username']; ?>:</label>
                <input class="createeditor_input" type="text" name="profile_username" value='<?php echo $_SESSION['username']; ?>' />
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile_email"><?php echo $translations['email']; ?>:</label>
                <input class="createeditor_input" type="email" name="profile_email" value='<?php echo $_SESSION['email']; ?>' />
            </div>
            <div class="createeditor_inputgroup flexcolumn">
                <label class="createeditor_label rightmargin nooutline" for="profile_bio"><?php echo $translations['bio']; ?>:</label>
                <textarea name="profile_bio" class="textarea" id="myTextarea4"><?php echo $_SESSION['bio']; ?></textarea>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile-address1"><?php echo $translations['address1']; ?>:</label>
                <input class="createeditor_input" type="text" name="profile-address1" value='<?php echo $_SESSION['address']; ?>' />
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile-address2"><?php echo $translations['address2']; ?>:</label>
                <input class="createeditor_input" type="text" name="profile-address2" value='<?php echo $_SESSION['addresstwo']; ?>' />
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile-city"><?php echo $translations['city']; ?>:</label>
                <input class="createeditor_input" type="text" name="profile-city" value='<?php echo  $_SESSION['city']; ?>' />
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile-state"><?php echo $translations['state']; ?>:</label>
                <input class="createeditor_input" type="text" name="profile-state" value='<?php echo $_SESSION['state']; ?>' />
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label rightmargin" for="profile-country"><?php echo $translations['country']; ?>:</label>
                <input class="createeditor_input" type="text" name="profile-country" value='<?php echo $_SESSION['country']; ?>' />
            </div>
            <div class="createeditor_inputgroup">
                <div class="createeditor_inputgroup">
                    <label class="createeditor_label rightmargin" for="profile-countrycode"><?php echo $translations['country_code']; ?>:</label>
                    <input class="createeditor_input" type="text" name="profile-countrycode" value='<?php echo $_SESSION['country_code']; ?>' />
                </div>
                <div class="createeditor_inputgroup">
                    <label class="createeditor_label rightmargin" for="profile-mobile"><?php echo $translations['mobile']; ?>:</label>
                    <input class="createeditor_input" type="number" name="profile-mobile" value='<?php echo $_SESSION['mobile']; ?>' />
                </div>
            </div>
            <input class="createeditor_input-submit" value="<?php echo $translations['update']; ?>" name="edit_profile" type="submit" />
        </form>
    </div>
    <script src="https://cdn.tiny.cloud/1/4x49ifq5jl99k0b9aot23a5ynnqfcr8jdlee7v6905rgmzql/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="../editor.js"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script>
        var messageType = "<?= $_SESSION['status_type'] ?? ' ' ?>";
        var messageText = "<?= $_SESSION['status'] ?? ' ' ?>";
        if (messageType == 'Error' && messageText != " ") {
            Swal.fire({
                title: 'Error!',
                text: messageText,
                icon: 'error',
                confirmButtonText: 'Ok'
            })
        } else if (messageType == 'Success' && messageText != " ") {
            Swal.fire({
                title: 'Success',
                text: messageText,
                icon: 'success',
                confirmButtonText: 'Ok'
            })
        }
        <?php unset($_SESSION['status_type']); ?>
        <?php unset($_SESSION['status']); ?>
    </script>
</body>

</html>