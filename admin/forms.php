<?php
require "connect.php";
if (isset($_POST['Sign_In'])) {
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    $sql = "SELECT * FROM admin_login_info WHERE email='$email'";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        header("location: admin_homepage.php");
        exit();
    }else{
        echo ` Incorrect Username or Password.`;
        header("location: index.php");
    }
}

require "connect.php";
if (isset($_POST['create_post'])) {
    $title = $_POST['Post_Title'];
    $niche = $_POST['Post_Niche'];
    $content = $_POST['Post_content'];
    $selects = $_POST['Post_Status'];
    $featured = $_POST['Post_featured'];
    $sub_title = $_POST['Post_Sub_Title'];
    $image_type = $_FILES['Post_Image']['type'];
    $image_size = $_FILES['Post_Image']['size'];
    $image_dir = '/uploads';
    $date = date('Y-m-d H:i:s');
    $error = " ";
    if($title == " " OR  $niche == " " OR $content == " "){
        $error .= "Fill in the necessary inputs";
        echo "$error";
    }else{
        if($image_type == "image/jpeg" OR $image_type == "image/jpg" OR $image_type = "image/png" OR $image_type = "image/webp"){
                    if($image_size <= 300000){
                        $tmp_name = $_FILES["Post_Image"]["tmp_name"][$key];
                        $image_name = basename($_FILES["Post_Image"]["name"][$key]);
                        move_uploaded_file($tmp_name, "$image_dir/$image_name");
                            if($selects == "paid_post"){
                                $insertQuery = "INSERT INTO paid_posts (Title, Niche, Content, Subtitle, link, image, Post_date)
                                VALUES ('$title', '$niche', '$content', '$sub_title', '$featured', '$image_name', '$date')";
                                $result = $conn->query($insertQuery);
                                if($result === TRUE){
                                    echo `<div class="logout_alert container_center" id="delete">
                                            <h1 class="logout_alert_header">Post Uploaded Successfully.</h1>
                                          </div>`;
                                    header('Location: admin_homepage.php');
                                }else{
                                    echo "Unsuccessful, Please Retry";
                                }
                            }else{
                                $insertQuery2 = "INSERT INTO posts (Posts_Niche, subtitle, link, Posts_Image, Posts_Content, Posts_Date, Posts_Title)
                                VALUES ('$niche', '$sub_title', '$featured', '$image_name', '$content', '$date', '$title')";
                                $result = $conn->query($insertQuery);
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

require "connect.php";
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

require "connect.php";
if (isset($_POST['workspace_submit'])) {
    $content = $_POST['workspace_content'];
    $workspace_name = $_POST['workspace_name'];
    $date = date('Y-m-d H:i:s'); 
    $insertQuery3 = "INSERT INTO workspaces (content, workspace_name, workspace_date) VALUES ('$content', '$workspace_name', '$date')";
    $result = $conn->query($insertQuery3);
        if($result === TRUE){
            echo "Successful";
            header('Location: workspace.php');
            }else{
            echo "Unsuccessful, Please Retry";
        };
} 

require "connect.php";
require "edit/post.php";
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
?>