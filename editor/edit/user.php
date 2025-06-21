<?php
session_start();
include("../connect.php");
require('../../init.php');
require("../init.php");
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$usertype = isset($_GET['usertype']) ? $_GET['usertype'] : null;
$translationFile = "../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = [];
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['edit_user']; ?></title>
</head>

<body>
    <?php
    require("../extras/header3.php");
    if ($usertype == "Writer") {
        $getuser_sql = "SELECT * FROM writer WHERE id = $id";
        $getuser_result = $conn->query($getuser_sql);
        if ($getuser_result->num_rows > 0) {
            $user = $getuser_result->fetch_assoc();
            $firstname = $user['firstname'];
            $lastname = $user['lastname'];
            $image = $user['image'];
            $bio = $user['bio'];
            $email = $user['email'];
            echo "<div class='editprofile_container'>
                        <form class='create_editor_container' action='../forms.php' method='post' enctype='multipart/form-data'>
                            <div class='createeditor_inputgroup'>
                                <h1 class='bigheader'>$translations[edit_user] (Writer) </h1>
                            </div>
                            <div class='newpost_container_div6 newpost_subdiv'>
                                <div class='newpost_container_div6_subdiv1'>
                                    <img src='$image' alt='Post Image'/>
                                </div>
                                <div class='newpost_container_div6_subdiv2'>
                                    <label class='form__label' for='Img'>$translations[edit_user_image]: </label>
                                    <div class='newpost_subdiv2'>
                                        <input class='form__input' name='Img' type='file'/>
                                    </div>
                                </div>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_firstname'>$translations[firstname]:</label>
                                <input class='createeditor_input' type='text' name='profile_firstname' value='$firstname'/>
                            </div>
                            <input class='createeditor_input' type='hidden' name='profile-id' value='$id'/>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_lastname'>$translations[lastname]:</label>
                                <input class='createeditor_input' type='text' name='profile_lastname' value='$lastname'/>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_email'>$translations[email]:</label>
                                <input class='createeditor_input' type='email' name='profile_email' value='$email'/>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin nooutline' for='profile_bio'>$translations[bio]:</label>
                                <textarea name='profile_bio' class='textarea' id='myTextarea5'>$bio</textarea>
                            </div>
                            <input class='createeditor_input-submit' value='$translations[save]' name='edit_profile_writer' type='submit'/>
                        </form>
                    </div>";
        }
    } else if ($usertype == "Other_user") {
        $getuser_sql = "SELECT * FROM otherwebsite_users WHERE id = $id";
        $getuser_result = $conn->query($getuser_sql);
        if ($getuser_result->num_rows > 0) {
            $user = $getuser_result->fetch_assoc();
            $firstname = $user['firstname'];
            $lastname = $user['lastname'];
            $image = $user['image'];
            $bio = $user['bio'];
            $role = $user['role'];
            $email = $user['email'];
            $linkedin_url = $user['linkedin_url'];
            echo "<div class='editprofile_container'>
                        <form class='create_editor_container' action='../forms.php' method='post' enctype='multipart/form-data'>
                            <div class='createeditor_inputgroup'>
                                <h1 class='bigheader'>$translations[edit_user] </h1>
                            </div>
                            <div class='newpost_container_div6 newpost_subdiv'>
                                <div class='newpost_container_div6_subdiv1'>
                                    <img src='$image' alt='Post Image'/>
                                </div>
                                <div class='newpost_container_div6_subdiv2'>
                                    <label class='form__label' for='Img'>$translations[edit_user_image]: </label>
                                    <div class='newpost_subdiv2'>
                                        <input class='form__input' name='Img' type='file'/>
                                    </div>
                                </div>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_firstname'>$translations[firstname]:</label>
                                <input class='createeditor_input' type='text' name='profile_firstname' value='$firstname'/>
                            </div>
                            <input class='createeditor_input' type='hidden' name='profile-id' value='$id'/>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_lastname'>$translations[lastname]:</label>
                                <input class='createeditor_input' type='text' name='profile_lastname' value='$lastname'/>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_email'>$translations[email]:</label>
                                <input class='createeditor_input' type='email' name='profile_email' value='$email'/>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin nooutline' for='profile_bio'>$translations[bio]:</label>
                                <textarea name='profile_bio' class='textarea' id='myTextarea5'>$bio</textarea>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_role'>$translations[role]:</label>
                                <input class='createeditor_input' type='text' name='profile_role' value='$role'/>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_url'>$translations[users_linkedin_url]:</label>
                                <input class='createeditor_input' type='text' name='profile_url' value='$linkedin_url'/>
                            </div>
                            <input class='createeditor_input-submit' value='$translations[save]' name='edit_profile_otheruser' type='submit'/>
                        </form>
                    </div>";
        }
    }
    ?>
    <script src="https://cdn.tiny.cloud/1/4x49ifq5jl99k0b9aot23a5ynnqfcr8jdlee7v6905rgmzql/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="../editor.js"></script>
    <script>
        const Toast = Swal.mixin({
            customClass: {
                popup: 'rounded-xl shadow-lg',
                title: 'text-lg font-semibold',
                confirmButton: 'bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700'
            },
            buttonsStyling: false,
            backdrop: `rgba(0,0,0,0.4)`,
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });

        if (messageType && messageText.trim() !== "") {
            let iconColors = {
                'Error': '#e74c3c',
                'Success': '#2ecc71',
                'Info': '#3498db'
            };

            Toast.fire({
                icon: messageType.toLowerCase(),
                title: messageText,
                iconColor: iconColors[messageType] || '#3498db',
                confirmButtonText: 'Got it'
            });
        }

        <?php unset($_SESSION['status_type']); ?>
        <?php unset($_SESSION['status']); ?>
    </script>
</body>

</html>