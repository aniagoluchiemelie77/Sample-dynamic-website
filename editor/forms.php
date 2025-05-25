<?php
session_start();
$editor_id = $_SESSION['id'];
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
require("connect.php");
include('crudoperations.php');

function convertPath($path)
{
    return basename($path);
}
function savePost1($title, $subtitle, $convertedPath, $content, $niche, $link, $schedule, $editor_id, $author_firstname, $author_lastname, $author_bio, $post_type)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    if ($post_type === "posts") {
        $idtype = "id2";
    } elseif ($post_type === "news") {
        $idtype = "id3";
    } elseif ($post_type === "commentaries") {
        $idtype = "id4";
    } else {
        $idtype = "id5";
    }
    $is_favourite = 0;
    $sql = "INSERT INTO $post_type (editor_id, title, niche, image_path, Date, time, schedule, subtitle, link, content, authors_firstname, about_author, authors_lastname, idtype, is_favourite) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($query = $conn->prepare($sql)) {
        $query->bind_param("issssssisssssss", $editor_id, $title, $niche, $convertedPath, $date, $time, $schedule, $subtitle, $link, $content, $author_firstname, $author_bio, $author_lastname, $idtype, $is_favourite);
        if ($query->execute()) {
            $post_id = $conn->insert_id;
            $post_link = "http://localhost/Sample-dynamic-website/pages/view_post.php?" . $idtype . "=" . $post_id . "";
            $content = "Editor " . $_SESSION['firstname'] . " added a new post (" . $post_type . ")";
            $forUser = 1;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Post Created Successfully";
            sendNewpostNotification($title, $post_link);
            header('location: editor_homepage.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: editor_homepage.php');
        }
    } else {
        $error = $conn->errno . ' ' . $conn->error;
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = $error;
        header('location: create_new/posts.php');
    }
}
function savePost2($title, $subtitle, $convertedPath, $content, $niche, $link, $schedule, $editor_id, $author_firstname, $author_lastname, $author_bio, $post_type)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $idtype = "";
    if ($post_type === "posts") {
        $idtype = "id2";
    } elseif ($post_type === "news") {
        $idtype = "id3";
    } elseif ($post_type === "commentaries") {
        $idtype = "id4";
    } else {
        $idtype = "id5";
    }
    $is_favourite = 0;
    $sql = "INSERT INTO $post_type (editor_id, title, niche, post_image_url, Date, time, schedule, subtitle, link, content, authors_firstname, about_author, authors_lastname, idtype, is_favourite) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($query = $conn->prepare($sql)) {
        $query->bind_param("issssssisssssss", $editor_id, $title, $niche, $convertedPath, $date, $time, $schedule, $subtitle, $link, $content, $author_firstname, $author_bio, $author_lastname, $idtype, $is_favourite);
        if ($query->execute()) {
            $post_id = $conn->insert_id;
            $post_link = "http://localhost/Sample-dynamic-website/pages/view_post.php?" . $idtype . "=" . $post_id . "";
            $content = "Editor " . $_SESSION['firstname'] . " added a new post (" . $post_type . ")";
            $forUser = 1;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Post Created Successfully";
            sendNewpostNotification($title, $post_link);
            header('location: editor_homepage.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: editor_homepage.php');
        }
    } else {
        $error = $conn->errno . ' ' . $conn->error;
        echo $error;
    }
}
function saveDraft($title, $subtitle, $imagePath, $content, $niche, $link, $editor_id)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("INSERT INTO unpublished_articles (editor_id, title, subtitle, image, link, Date, time, niche, content) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssss", $editor_id, $title, $subtitle, $imagePath, $link, $date, $time, $niche, $content);
    if ($stmt->execute()) {
        $content = "Editor " . $_SESSION['firstname'] . " added a draft";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Draft Created Successfully";
        header('location: editor_homepage.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: editor_homepage.php');
    }
    $stmt->close();
}
function updatePost($title, $subtitle, $imagePath, $content, $niche, $link, $author_firstname, $author_lastname, $author_bio, $tablename, $post_id)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("UPDATE $tablename SET title = ?, subtitle = ?, image_path = ?, content = ?, niche = ?, link = ?, Date = ?, time = ?, authors_firstname = ?, about_author = ?, authors_lastname = ? WHERE id = ?");
    $stmt->bind_param("sssssssssssi", $title, $subtitle, $imagePath, $content, $niche, $link, $date, $time, $author_firstname, $author_bio, $author_lastname, $post_id);
    if ($stmt->execute()) {
        $content = "Editor " . $_SESSION['firstname'] . " updated a post";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Post Updated Successfully";
        header('location: editor_homepage.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: editor_homepage.php');
    }
    $stmt->close();
}
function updatePages($content, $tablename)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $string = str_replace('_', ' ', $tablename);
    $stmt = "INSERT INTO $tablename (content, date, time) VALUES (?, ?, ?)";
    if ($query = $conn->prepare($stmt)) {
        $query->bind_param("sss", $content, $date, $time);
        if ($query->execute()) {
            $content = "editor " . $_SESSION['firstname'] . " updated this website's '" . $string . "'";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "" . $string . " Updated Successfully";
            header('location: editor_homepage.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: editor_homepage.php');
        }
    } else {
        $error = $conn->errno . ' ' . $conn->error;
        echo $error;
        header('location: editor_homepage.php');
    }
}
function updateProfile($firstname, $lastname, $email, $username, $bio, $address1, $address2, $city, $state, $country, $countrycode, $mobile, $imagePath)
{
    global $conn;
    $id = $_SESSION['id'];
    $stmt = $conn->prepare("UPDATE editor SET firstname = ?, lastname = ?, username = ?, email = ?, image = ?, bio = ?, mobile = ?, country = ?, 	city = ?, state = ?, address1 = ?, address2 = ?, country_code = ? WHERE id = ?");
    $stmt->bind_param("sssssssssssssi", $firstname, $lastname, $username, $email, $imagePath, $bio, $mobile, $country, $city, $state, $address1, $address2, $countrycode, $id);
    if ($stmt->execute()) {
        $content = "Editor " . $_SESSION['firstname'] . " updated his/her profile";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Profile Updated Successfully";
        header('location: edit/profile.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: edit/profile.php');
    }
    $stmt->close();
}
function updateUserProfile($firstname, $lastname, $email, $role, $url, $bio, $imagePath, $id)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE otherwebsite_users SET firstname = ?, lastname = ?, email = ?, role = ?, image = ?, bio = ?, linkedin_url = ? WHERE id = ?");
    $stmt->bind_param("sssssssi", $firstname, $lastname, $email, $role, $imagePath, $bio, $url, $id);
    if ($stmt->execute()) {
        $content = "Editor " . $_SESSION['firstname'] . " updated $firstname's profile";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Profile Updated Successfully";
        header('location: edit/user.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: edit/user.php');
    }
    $stmt->close();
}
function updateWriterProfile($firstname, $lastname, $email, $bio, $imagePath, $id)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE writer SET firstname = ?, lastname = ?, email = ?, image = ?, bio = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $firstname, $lastname, $email, $imagePath, $bio, $id);
    if ($stmt->execute()) {
        $content = "Editor " . $_SESSION['firstname'] . " updated $firstname's profile";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Profile Updated Successfully";
        header('location: edit/user.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: edit/user.php');
    }
    $stmt->close();
}
function addWriter($firstname, $lastname, $email, $imagePath, $editor_id)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $idtype = "Writer";
    $stmt = $conn->prepare("INSERT INTO writer (editor_id, firstname, lastname, email, image, date_joined, time_joined, idtype) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $editor_id, $firstname, $lastname, $email, $imagePath, $date, $time, $idtype);
    if ($stmt->execute()) {
        $content = "Editor " . $_SESSION['firstname'] . " added a new Writer ($firstname)";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Writer Created Successfully";
        header('location: create_new/writer.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: create_new/writer.php');
    }
    $stmt->close();
}
function addUser($firstname, $lastname, $email,  $role, $linkedin_url, $imagePath)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("INSERT INTO otherwebsite_users ( firstname, lastname, email, role, image, linkedin_url, date_joined, time_joined) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $firstname, $lastname, $email, $role, $imagePath, $linkedin_url, $date, $time);
    if ($stmt->execute()) {
        $content = "Editor " . $_SESSION['firstname'] . " created a new user ($firstname) as $role";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "User Created Successfully";
        header('location: create_new/user.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: create_new/user.php');
    }
    $stmt->close();
}
if (isset($_POST['create_post'])) {
    $title = $_POST['Post_Title'];
    $subtitle = $_POST['Post_Sub_Title'];
    $content = $_POST['Post_content'];
    $niche = $_POST['Post_Niche'];
    $post_type = $_POST['Post_status'];
    $link = $_POST['Post_featured'];
    $schedule = $_POST['schedule'];
    $author_firstname = $_POST['author_firstname'];
    $author_lastname = $_POST['author_lastname'];
    $author_bio = $_POST['about_author'];
    $image2 = $_POST['Post_Image2'];
    $image1 = $_FILES['Post_Image1']['name'];
    $target = "../images/" . basename($image1);
    if (empty($image1) && !empty($image2)) {
        $imagePath = $image2;
        savePost2($title, $subtitle, $imagePath, $content, $niche, $link, $schedule, $editor_id, $author_firstname, $author_lastname, $author_bio, $post_type);
    } elseif (!empty($image1) && empty($image2)) {
        if (move_uploaded_file($_FILES['Post_Image1']['tmp_name'], $target)) {
            $imagePath = $target;
            $convertedPath = convertPath($imagePath);
            savePost1($title, $subtitle, $imagePath, $content, $niche, $link, $schedule, $editor_id, $author_firstname, $author_lastname, $author_bio, $post_type);
        }
    } else if (!empty($image1) && !empty($image2)) {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Please ensure the post's image is selected or it's url provided and not both.";
        header('location: create_new/posts.php');
    }
}
if (isset($_POST['edit_profile'])) {
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
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    if ($password === $confirm_pasword) {
        if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
            $imagePath = $target;
            updateProfile($firstname, $lastname, $email, $username, $bio, $address1, $address2, $city, $state, $country, $countrycode, $mobile, $imagePath);
        }
    }
}
if (isset($_POST['edit_profile_writer'])) {
    $id = $_POST['profile-id'];
    $firstname = $_POST['profile_firstname'];
    $lastname = $_POST['profile_lastname'];
    $bio = $_POST['profile_bio'];
    $email = $_POST['profile_email'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
        $imagePath = $target;
        $convertedPath = convertPath($imagePath);
        updateWriterProfile($firstname, $lastname, $email, $bio, $convertedPath, $id);
    }
}
if (isset($_POST['edit_profile_otheruser'])) {
    $id = $_POST['profile-id'];
    $firstname = $_POST['profile_firstname'];
    $lastname = $_POST['profile_lastname'];
    $bio = $_POST['profile_bio'];
    $role = $_POST['profile_role'];
    $email = $_POST['profile_email'];
    $url = $_POST['profile_url'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
        $imagePath = $target;
        $convertedPath = convertPath($imagePath);
        updateUserProfile($firstname, $lastname, $email, $role, $url, $bio, $convertedPath, $id);
    }
}
if (isset($_POST['create_draft'])) {
    $title = $_POST['Post_Title'];
    $subtitle = $_POST['Post_Sub_Title'];
    $content = $_POST['Post_content'];
    $niche = $_POST['Post_Niche'];
    $link = $_POST['Post_featured'];
    $image = $_FILES['Post_Image']['name'];
    $target = "../images/" . basename($image);
    if (move_uploaded_file($_FILES['Post_Image']['tmp_name'], $target)) {
        $imagePath = $target;
        $convertedPath = convertPath($imagePath);
        saveDraft($title, $subtitle, $convertedPath, $content, $niche, $link, $editor_id);
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_post'])) {
    $title = $_POST['Post_Title'];
    $niche = $_POST['Post_Niche'];
    $content = $_POST['Post_content'];
    $link = $_POST['Post_featured'];
    $tablename = $_POST['table_type'];
    $post_id = $_POST['post_id'];
    $subtitle = $_POST['Post_Sub_Title'];
    $author_firstname = $_POST['author_firstname'];
    $author_lastname = $_POST['author_lastname'];
    $author_bio = $_POST['about_author'];
    $image = $_FILES['Post_Image']['name'];
    $target = "../images/" . basename($image);
    if (move_uploaded_file($_FILES['Post_Image']['tmp_name'], $target)) {
        $imagePath = $target;
        $convertedPath = convertPath($imagePath);
        updatePost($title, $subtitle, $convertedPath, $content, $niche, $link, $author_firstname, $author_lastname, $author_bio, $tablename, $post_id);
    }
}
if (isset($_POST['create_writer'])) {
    $firstname = $_POST['writer_firstname'];
    $lastname = $_POST['writer_lastname'];
    $email = $_POST['writer_email'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    if ($password === $confirm_pasword) {
        if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
            $imagePath = $target;
            $convertedPath = convertPath($imagePath);
            addWriter($firstname, $lastname, $email, $convertedPath, $editor_id);
        }
    }
}
if (isset($_POST['create_user'])) {
    $firstname = $_POST['user_firstname'];
    $lastname = $_POST['user_lastname'];
    $email = $_POST['user_email'];
    $role = $_POST['user_role'];
    $linkedin_url = $_POST['user_linkedin_url'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    if ($password === $confirm_pasword) {
        if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
            $imagePath = $target;
            $convertedPath = convertPath($imagePath);
            addUser($firstname, $lastname, $email,  $role, $linkedin_url, $convertedPath);
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $recordId = intval($_GET["id"]);
    $date = date('y-m-d');
    $time = date('H:i:s');
    file_put_contents("log.txt", "POST request received\n", FILE_APPEND);
    function updateProfilePic($imagePath1)
    {
        global $conn;
        global $recordId;
        $stmt = $conn->prepare("UPDATE editor SET image = ? WHERE id = ?");
        $stmt->bind_param("si", $imagePath1, $recordId);
        if ($stmt->execute()) {
            $content = "Editor " . $_SESSION['firstname'] . " updated his/her Profile Picture";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            header('location: editor_homepage.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: editor_homepage.php');
        }
        $stmt->close();
    }
    if (isset($_FILES["profile_pic"])) {
        $profile_pic = $_FILES["profile_pic"]["name"];
        $profile_tmp_name = $_FILES["profile_pic"]["tmp_name"];
        $resource_folder1 = "../images/" . $profile_pic;

        if (move_uploaded_file($profile_tmp_name, $resource_folder1)) {
            $convertedPath = convertPath($resource_folder1);
            file_put_contents("log.txt", "Profile Image file moved successfully! Date: " . $date . ", Time: " . $time . ", Path: " . $convertedPath . " \n", FILE_APPEND);
            updateProfilePic($convertedPath);
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error Moving Uploaded Files";
            header('location: editor_homepage.php');
        }
    }
}
