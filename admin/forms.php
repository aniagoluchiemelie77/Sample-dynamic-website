<?php
require ("connect.php");
if (isset($_POST['create_post'])) {
    $title = $_POST['Post_Title'];
    $niche = $_POST['Post_Niche'];
    $content = $_POST['Post_content'];
    $selects = $_POST['Post_Status'];
    $uid = uniqid();
    $featured = $_POST['Post_featured'];
    $sub_title = $_POST['Post_Sub_Title'];
    $image = $uid . $_FILES['Post_Image']['name'];
    $image_size = $uid . $_FILES['Post_Image']['size'];
    $image_type = $uid . $_FILES['Post_Image']['type'];
    $date = date('Y-m-d H:i:s');
    $error = " ";
    if($title == " " OR  $niche == " " OR $content == " "){
        $error .= "Fill in the necessary inputs";
        echo "$error";
    }else{
        if($image_type == "image/jpeg" OR $image_type == "image/jpg" OR $image_type = "image/png" OR $image_type = "image/webp"){
                    if($image_size <= 900000){
                        move_uploaded_file($_FILES['Post_Image']['tmp_name'],'images/' . $uid . $_FILES['Post_Image']['name']);
                            if($selects == "paid_post"){
                                $insertQuery = "INSERT INTO paid_posts (Title, Niche, Content, Subtitle, link, image, Post_date)
                                VALUES ('$title', '$niche', '$content', '$sub_title', '$featured', '$image', '$date')";
                                $result = $conn->query($insertQuery);
                                if($result === TRUE){
                                    echo `<div class="logout_alert container_center" id="delete">
                                            <h1 class="logout_alert_header">Post Uploaded Successfully.</h1>
                                          </div>`;
                                    header('Location: admin_homepage.php');
                                }else{
                                    echo "Unsuccessful, Please Retry";
                                }
                            }else if($selects == "none"){
                                $insertQuery2 = "INSERT INTO posts (Posts_Niche, subtitle, link, Posts_Image, Posts_Content, Posts_Date, Posts_Title)
                                VALUES (\'$niche\', \'$sub_title\', \'$featured\', \'$image\', \'$content\', \'$date\', \'$title\')";
                               $result = $conn->query($insertQuery2);
                                if($result === TRUE){
                                    echo "Successful";
                                }else{
                                    echo "Unsuccessful, Please Retry";
                                }
                            }
                    }else{
                        echo "Image File too large";
                    }
            }else{
            echo "Invalid Image File Type";
        } 
    }
}

require ("connect.php");
if (isset($_POST['profileedit_Submit'])) {
    $firstname = $_POST['profile_firstname'];
    $lastname = $_POST['profile_lastname'];
    $username = $_POST['profile_username'];
    $bio = $_POST['profile_bio'];
    $email = $_POST['profile_email'];
    $address1 = $_POST['profile-address1'];
    $address2 = $_POST['profile-address2'];
    $city = $_POST['profile-city'];
    $state = $_POST['profile-state'];
    $country = $_POST['profile-country'];
    $countrycode = $_POST['profile-countrycode'];
    $mobile = $_POST['profile-mobile'];
    $insertQuery2 = "UPDATE admin_login_info SET firstName ='$firstname', lastName='$lastname', username='$username', email='$email', admin_bio='$bio', admin_moblie='$mobile', admin_country='$country', admin_city='$city', admin_state='$state', address1='$address1', address2='$address2', country_code='$countrycode' WHERE id='2'";
    $result = $conn->query($insertQuery2);
        if($result === TRUE){
            echo `<div class="logout_alert container_center" id="delete">
                    <h1 class="logout_alert_header">Profile Edit Successful.</h1>
                 </div>`;
            header('Location: admin_homepage.php');
        }else{
            echo "Unsuccessful, Please Retry";
        }
} 

require ("connect.php");
if (isset($_POST['workspace_submit'])) {
    $content = $_POST['workspace_content'];
    $workspace_name = $_POST['workspace_name'];
    $date = date('Y-m-d H:i:s'); 
    $insertQuery3 = "INSERT INTO workspaces (content, workspace_name, workspace_date) VALUES ('$content', '$workspace_name', '$date')";
    $result = $conn->query($insertQuery3);
        if($result === TRUE){
            echo "Successful";
            header('location: create_new/workspace.php');
            }else{
            echo "Unsuccessful, Please Retry";
        };
} 

require ("connect.php");
require ("edit/post.php");
if (isset($_POST['edit_post'])) {
    $title = $_POST['Post_Title'];
    $niche = $_POST['Post_Niche'];
    $content = $_POST['Post_content'];
    $featured = $_POST['Post_featured'];
    $sub_title = $_POST['Post_Sub_Title'];
    $image_type = $_FILES['Post_Image']['type'];
    $image_size = $_FILES['Post_Image']['size'];
    $image_dir = '/uploads';
    $date = date('Y-m-d H:i:s');
    if($image_type == "image/jpeg" OR $image_type == "image/jpg" OR $image_type = "image/png" OR $image_type = "image/webp"){
        if($image_size <= 300000){
            $tmp_name = $_FILES["Post_Image"]["tmp_name"][$key];
            $image_name = basename($_FILES["Post_Image"]["name"][$key]);
            move_uploaded_file($tmp_name, "$image_dir/$image_name");
            $insertQuery2 = "UPDATE posts SET Posts_Niche ='$niche', subtitle='$sub_title', link='$featured', Posts_Image='$image_name', Posts_Content='$content', Posts_Date='$date', Posts_Title ='$title' WHERE Post_Id ='$edit_id'";
            $result = $conn->query($insertQuery2);
            if($result === TRUE){
                echo"<script>alert('Post Updated Successfully.')</script>";
                header('Location: admin_homepage.php');
            }else{
                echo "Unsuccessful, Please Retry";
            }
        }else{
            echo "Image File too large";
        }
    }else{
        echo "Invalid Image File Type";
    } 
}

require ("connect.php");
if (isset($_POST['createeditor_Submit'])) {
    $firstname = $_POST['editor_firstname'];
    $username = $_POST['editor_username'];
    $lastname = $_POST['editor_lastname'];
    $email = $_POST['editor_email'];
    $password = $_POST['editor_password'];
    $confirm_pasword = $_POST['editor_password-confirm'];
    $date = date("Y-m-d");
    $time = date("H:i:s");
    if($password === $confirm_pasword){
        $insertQuery4 = "INSERT INTO editor (editor_username,editor_email, editor_password, editor_firstname, editor_lastname, date_joined, time_joined) VALUES ('$username', '$email', '$password', '$firstname', '$lastname', '$date', '$time')";
        $result = $conn->query($insertQuery4);
            if($result === TRUE){
                header('Location: admin_homepage.php');
                echo"<script>alert('New Editor Successfully.')</script>";
            }else{
                echo "Unsuccessful, Please Retry";
            }
    }
} 
 
require ("connect.php");
if (isset($_POST['Createwriter_Submit'])) {
    $firstname = $_POST['writer_firstname'];
    $username = $_POST['writer_username'];
    $lastname = $_POST['writer_lastname'];
    $email = $_POST['writer_email'];
    $password = $_POST['writer_password'];
    $confirm_pasword = $_POST['writer_password-confirm'];
    $date = date("Y-m-d");
    $time = date("H:i:s");
    if($password === $confirm_pasword){
        $insertQuery5 = "INSERT INTO editor (writer_username,writer_password, writer_email, writer_firstname, writer_lastname, date_joined, time_joined) VALUES ('$username', '$password', '$email', '$firstname', '$lastname', '$date', '$time')";
        $result = $conn->query($insertQuery5);
            if($result === TRUE){
                header('Location: admin_homepage.php');
                echo"<script>alert('New Editor Successfully.')</script>";
            }else{
                echo "Unsuccessful, Please Retry";
            }
    }
} 
?>