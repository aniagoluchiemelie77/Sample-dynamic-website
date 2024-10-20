<?php
session_start();
$admin_id = $_SESSION['id']; 
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
require ("connect.php");
include ('crudoperations.php');
function savePost($title, $subtitle, $imagePath, $content, $niche, $link, $schedule, $admin_id, $author_firstname, $author_lastname, $author_bio, $tablename) {
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    if($tablename === "paid_post"){
        $max_rows = 4;
        $row_count = "SELECT COUNT(*) as total FROM paid_posts";
        $rowcount_result = $conn->query($row_count);
        $row = $rowcount_result->fetch_assoc();
        $total_rows = $row['total']; 
        if ($total_rows >= $max_rows) {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error!, Cannot add more posts. The maximum limit of $max_rows posts has been reached.";
            header('location: {$_SERVER["HTTP_REFERER"]}');
        } 
    }else{
        $stmt = $conn->prepare("INSERT INTO $tablename (title, subtitle, image_path, content, niche, link, schedule, admin_id, Date, time, authors_firstname, about_author, authors_lastname) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssssss", $title, $subtitle, $imagePath, $content, $niche, $link, $schedule, $admin_id, $date, $time, $author_firstname, $author_bio, $author_lastname);
        if ($stmt->execute()) {
            $content = "You created a $tablename post";
            $forUser = 'T';
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Post Published Successfully!";
            header('location: {$_SERVER["HTTP_REFERER"]}');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error!, Please Retry";
            header('location: {$_SERVER["HTTP_REFERER"]}');
    }
    $stmt->close();
    }
}
if (isset($_POST['create_post'])) {
    $title = $_POST['Post_Title'];
    $subtitle = $_POST['Post_Sub_Title'];
    $content = $_POST['Post_content'];
    $niche = $_POST['Post_Niche'];
    $link = $_POST['Post_featured'];
    $schedule = $_POST['schedule'];
    $author_firstname = $_POST['author_firstname'];
    $author_lastname = $_POST['author_lastname'];
    $author_bio = $_POST['about_author'];
    $tablename = $_POST['Post_Status'];
    $image = $_FILES['Post_Image']['name'];
    $target = "../images/" . basename($image);
    if (move_uploaded_file($_FILES['Post_Image']['tmp_name'], $target)) {
        $imagePath = $target;
        if( !empty($author_firstname) || !empty($author_lastname) || !empty($author_bio)){
            $admin_id = " ";
            savePost($title, $subtitle, $imagePath, $content, $niche, $link, $schedule, $admin_id, $author_firstname, $author_lastname, $author_bio, $tablename);
        }
    }
}
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topicNameRaw = $_POST['topicName'];
    $desc = $_POST['topicDesc'];
    $topicName = strtolower(str_replace(' ', '-', $topicNameRaw));
    $date = date('Y-m-d');
    $time = date('H:i:s');
    $image = $_FILES['topicImg']['name'];
    $target = "../images/" . basename($image);
    if(!empty($image)){
        if (move_uploaded_file($_FILES['topicImg']['tmp_name'], $target)) {
            $imagePath = $target;
        }
    }else{
        $imagePrompt = "Illustration of " . $topicNameRaw . " without any people";
        $image = generateImage($imagePrompt);
        if (move_uploaded_file($image, $target)) {
            $imagePath = $target;
        }
    }
    $sql = "INSERT INTO topics (name, description, image_path, Date, time) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $topicName, $desc, $imagePath, $date, $time);
    if ($stmt->execute()) {
        $content = "You created a new topic";
        $forUser = 'F';
        logUpdate($conn, $forUser, $content);
        $fileName = '../pages/' . str_replace('-', '', $topicName) . '.php';
        $fileContent = $topic_pagetemplate;
        file_put_contents($fileName, $fileContent);
    } else {
        echo "Failed to add topic.";
    }
    $stmt->close();
}
function generateImage($prompt) {
    // This is where you would call your image generation API and return the image URL or path
    // For example, using a hypothetical function `generate_image()`
    return generate_image($prompt);
}
?>