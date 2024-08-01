<?php
require "connect.php";
if (isset($_POST['Sign_In'])) {
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    $sql = "SELECT * FROM admin_login_info WHERE email='$email' /*and password='$password'*/";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        header("location: admin_homepage.php");
        exit();
    }else{
            echo "Not Found, Incorrect Email";
    }
}

if (isset($_POST['create_post'])) {
    $title = $_POST['Post_Title'];
    $niche = $_POST['Post_Niche'];
    $content = $_POST['Post_content'];
    $selects = $_POST['Post_Status'];
    $featured = $_POST['Post_featured'];
    $sub_title = $_POST['Post_Sub_Title'];
    $image_name = $_FILES['Post_Image']['name'];
    $image_type = $_FILES['Post_Image']['type'];
    $image_size = $_FILES['Post_Image']['size'];
    $image_tmp = $_FILES['Post_Image']['tmp_name'];
    $date = date('y.m.d');
    $error = " ";
    if($title == " " OR  $niche == " " OR $content == " "){
        $error .= "Fill in the necessary inputs";
        echo "$error";
    }else{
        if($image_type == "image/jpeg" OR $image_type == "image/jpg" OR $image_type = "image/png" OR $image_type = "image/webp"){
            if($image_size <= 300000){
                move_uploaded_file( $image_tmp, `image/$image_name`);
                if($selects == "paid_post"){
                    $insertQuery = "INSERT INTO paid_posts (Title, Niche, Content, Subtitle, link, image, Post_date)
                    VALUES ('$title', '$niche', '$content', '$sub_title', '$featured', '$image_name', '$date')";
                     $result = $conn->query($insertQuery);
                    if($result === TRUE){
                        echo "Successful";
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
?>