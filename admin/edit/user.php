<?php
session_start();
include("../connect.php");
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$usertype = isset($_GET['usertype']) ? $_GET['usertype'] : null;
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<title>Edit User</title>
</head>
<body>
    <?php 
        require("../extras/header2.php");
        if ($usertype == "Editor") {
            $getuser_sql = "SELECT * FROM editor WHERE id = $id";
            $getuser_result = $conn->query($getuser_sql);
            if ($getuser_result->num_rows > 0) {
                $user = $getuser_result->fetch_assoc();
                $firstname = $user['firstname'];
                $username = $user['username'];
                $lastname = $user['lastname'];
                $image = $user['image'];
                $password = $user['password'];
                $bio = $user['bio'];
                $email = $user['email'];
                $country = $user['country'];
                $mobile = $user['mobile'];
                $state = $user['state'];
                $city = $user['city'];
                $address1 = $user['address1'];
                $address2 = $user['address2'];
                $country_code = $user['country_code'];
                echo"<div class='editprofile_container'>
                        <form class='create_editor_container' action='../forms.php' method='post' enctype='multipart/form-data'>
                            <div class='createeditor_inputgroup'>
                                <h1 class='bigheader'>Edit User (Editor) </h1>
                            </div>
                            <div class='newpost_container_div6 newpost_subdiv'>
                                <div class='newpost_container_div6_subdiv1'>
                                    <img src='../../$image' alt='Post Image'/>
                                </div>
                                <div class='newpost_container_div6_subdiv2'>
                                    <label class='form__label' for='Img'>Edit Image: </label>
                                    <div class='newpost_subdiv2'>
                                        <input class='form__input' name='Img' type='file' required/>
                                    </div>
                                </div>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_password'>Password:</label>
                                <input class='createeditor_input' type='password' name='profile_password' value='$password' required/>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_firstname'>Firstname:</label>
                                <input class='createeditor_input' type='text' name='profile_firstname' value='$firstname' required/>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_lastname'>Lastname:</label>
                                <input class='createeditor_input' type='text' name='profile_lastname' value='$lastname' required/>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_username'>Username:</label>
                                <input class='createeditor_input' type='text' name='profile_username' value='$username' required/>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_email'>Email:</label>
                                <input class='createeditor_input' type='email' name='profile_email' value='$email' required/>
                            </div>
                            <div class='createeditor_inputgroup flexcolumn'>
                                <label class='createeditor_label rightmargin nooutline' for='profile_bio'>Bio:</label>
                                <textarea name='profile_bio' class='textarea' id='myTextarea5'>$bio</textarea>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile-address1'>Address 1:</label>
                                <input class='createeditor_input' type='text' name='profile-address1' value='$address1' required/>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile-address2'>Address 2:</label>
                                <input class='createeditor_input' type='text' name='profile-address2' value='$address2' required/>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile-city'>City:</label>
                                <input class='createeditor_input' type='text' name='profile-city' value='$city' required/>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile-state'>State:</label>
                                <input class='createeditor_input' type='text' name='profile-state' value='$state' required/>
                            </div>
                            <input class='createeditor_input' type='hidden' name='profile-id' value='$id' required/>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile-country'>Country:</label>
                                <input class='createeditor_input' type='text' name='profile-country' value='$country' required/>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile-countrycode'>Country Code:</label>
                                <input class='createeditor_input' type='text' name='profile-countrycode' value='$country_code' required/>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile-mobile'>Phone Number:</label>
                                <input class='createeditor_input' type='number' name='profile-mobile' value='$mobile' required/>
                            </div>
                            <input class='createeditor_input-submit' value='Update' name='edit_profile_editor' type='submit'/>
                        </form>
                    </div>";
            }
        }
        else if ($usertype == "Writer"){
            $getuser_sql = "SELECT * FROM writer WHERE id = $id";
            $getuser_result = $conn->query($getuser_sql);
            if ($getuser_result->num_rows > 0) {
                $user = $getuser_result->fetch_assoc();
                $firstname = $user['firstname'];
                $lastname = $user['lastname'];
                $image = $user['image'];
                $bio = $user['bio'];
                $email = $user['email'];
                echo"<div class='editprofile_container'>
                        <form class='create_editor_container' action='../forms.php' method='post' enctype='multipart/form-data'>
                            <div class='createeditor_inputgroup'>
                                <h1 class='bigheader'>Edit User (Writer) </h1>
                            </div>
                            <div class='newpost_container_div6 newpost_subdiv'>
                                <div class='newpost_container_div6_subdiv1'>
                                    <img src='../../$image' alt='Post Image'/>
                                </div>
                                <div class='newpost_container_div6_subdiv2'>
                                    <label class='form__label' for='Img'>Edit Image: </label>
                                    <div class='newpost_subdiv2'>
                                        <input class='form__input' name='Img' type='file' required/>
                                    </div>
                                </div>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_firstname'>Firstname:</label>
                                <input class='createeditor_input' type='text' name='profile_firstname' value='$firstname' required/>
                            </div>
                            <input class='createeditor_input' type='hidden' name='profile-id' value='$id' required/>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_lastname'>Lastname:</label>
                                <input class='createeditor_input' type='text' name='profile_lastname' value='$lastname' required/>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_email'>Email:</label>
                                <input class='createeditor_input' type='email' name='profile_email' value='$email' required/>
                            </div>
                            <div class='createeditor_inputgroup flexcolumn'>
                                <label class='createeditor_label rightmargin nooutline' for='profile_bio'>Bio:</label>
                                <textarea name='profile_bio' class='textarea' id='myTextarea5'>$bio</textarea>
                            </div>
                            <input class='createeditor_input-submit' value='Update' name='edit_profile_writer' type='submit'/>
                        </form>
                    </div>";
            }
        }
        else if ($usertype == "Other_user"){
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
                echo"<div class='editprofile_container'>
                        <form class='create_editor_container' action='../forms.php' method='post' enctype='multipart/form-data'>
                            <div class='createeditor_inputgroup'>
                                <h1 class='bigheader'>Edit User </h1>
                            </div>
                            <div class='newpost_container_div6 newpost_subdiv'>
                                <div class='newpost_container_div6_subdiv1'>
                                    <img src='../../$image' alt='Post Image'/>
                                </div>
                                <div class='newpost_container_div6_subdiv2'>
                                    <label class='form__label' for='Img'>Edit Image: </label>
                                    <div class='newpost_subdiv2'>
                                        <input class='form__input' name='Img' type='file' required/>
                                    </div>
                                </div>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_firstname'>Firstname:</label>
                                <input class='createeditor_input' type='text' name='profile_firstname' value='$firstname' required/>
                            </div>
                            <input class='createeditor_input' type='hidden' name='profile-id' value='$id' required/>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_lastname'>Lastname:</label>
                                <input class='createeditor_input' type='text' name='profile_lastname' value='$lastname' required/>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_email'>Email:</label>
                                <input class='createeditor_input' type='email' name='profile_email' value='$email' required/>
                            </div>
                            <div class='createeditor_inputgroup flexcolumn'>
                                <label class='createeditor_label rightmargin nooutline' for='profile_bio'>Bio:</label>
                                <textarea name='profile_bio' class='textarea' id='myTextarea5'>$bio</textarea>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_role'>Role:</label>
                                <input class='createeditor_input' type='text' name='profile_role' value='$role' required/>
                            </div>
                            <div class='createeditor_inputgroup'>
                                <label class='createeditor_label rightmargin' for='profile_url'>Linkedin Url:</label>
                                <input class='createeditor_input' type='text' name='profile_url' value='$linkedin_url' required/>
                            </div>
                            <input class='createeditor_input-submit' value='Update' name='edit_profile_otheruser' type='submit'/>
                        </form>
                    </div>";
            }
        }
    ?>
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