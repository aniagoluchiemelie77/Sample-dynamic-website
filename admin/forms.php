<?php
session_start();
$_SESSION['id'] = $admin_id; 
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
require ("connect.php");
include ('crudoperations.php');
function savePost($title, $subtitle, $imagePath, $content, $niche, $link, $schedule, $admin_id, $author_firstname, $author_lastname, $author_bio, $post_type) {
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $sql = "INSERT INTO $post_type (admin_id, title, niche, image_path, Date, time, schedule, subtitle, link, content, authors_firstname, about_author, authors_lastname) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if($query = $conn->prepare($sql)) { 
        $query->bind_param("sssssssisssss", $admin_id, $title, $niche, $imagePath, $date, $time, $schedule, $subtitle, $link, $content, $author_firstname, $author_bio, $author_lastname);
        if ($query->execute()) {
            $content = "Admin ".$_SESSION['firstname']." added a new post (".$post_type.")";
            $forUser = 1;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Post Created Successfully";
            header('location: create_new/posts.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: create_new/posts.php');
        }
    } else {
        $error = $conn->errno . ' ' . $conn->error;
        echo $error; 
    }
}
function saveDraft($title, $subtitle, $imagePath, $content, $niche, $link, $admin_id) {
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("INSERT INTO unpublished_articles (admin_id, title, subtitle, image, link, Date, time, niche, content) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssss", $admin_id, $title, $subtitle, $imagePath, $link, $date, $time, $niche, $content);
    if ($stmt->execute()) {
        $content = "Admin ".$_SESSION['firstname']." added a draft";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Draft Created Successfully";
        header('location: create_new/workspace.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: create_new/workspace.php');
    }
    $stmt->close();
}
function updatePost($title, $subtitle, $imagePath, $content, $niche, $link, $admin_id, $author_firstname, $author_lastname, $author_bio, $tablename) {
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("UPDATE $tablename SET title = ?, subtitle = ?, image_path = ?, content = ?, niche = ?, link = ?, admin_id = ?, Date = ?, time = ?, authors_firstname = ?, about_author = ?, authors_lastname = ?");
    $stmt->bind_param("ssssssssssss", $title, $subtitle, $imagePath, $content, $niche, $link, $admin_id, $date, $time, $author_firstname, $author_bio, $author_lastname);
    if ($stmt->execute()) {
        $content = "Admin ".$_SESSION['firstname']." updated a $tablename post";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Post Created Successfully";
        header('location: create_new/posts.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: create_new/posts.php');
    }
    $stmt->close();
}
function updatePages($content, $tablename) {
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $string = str_replace('_', ' ', $tablename); 
    $stmt = "INSERT INTO $tablename (content, date, time) VALUES (?, ?, ?)";
    if($query = $conn->prepare($stmt)) { 
        $query->bind_param("sss", $content, $date, $time);
        if ($query->execute()) {
            $content = "Admin ".$_SESSION['firstname']." updated this website's '(".$string.")'";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "".$string." Updated Successfully";
            header('location: admin_homepage.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: admin_homepage.php');
        }
    } else {
        $error = $conn->errno . ' ' . $conn->error;
        echo $error; 
        header('location: admin_homepage.php');
    }
}
function updateProfile($firstname, $lastname, $email, $username, $bio, $address1, $address2, $city, $state, $country, $countrycode, $mobile, $imagePath) {
    global $conn;
    $stmt = $conn->prepare("UPDATE admin_login_info SET firstname = ?, lastname = ?, username = ?, email = ?, image = ?, bio = ?, mobile = ?, country = ?, 	city = ?, state = ?, address1 = ?, address2 = ?, country_code = ?");
    $stmt->bind_param("sssssssssssss", $firstname, $lastname, $username, $email, $imagePath, $bio, $mobile, $country, $city, $state, $address1, $address2, $countrycode);
    if ($stmt->execute()) {
        $content = "Admin ".$_SESSION['firstname']." updated his profile";
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
function updateEditorProfile($firstname, $password, $lastname, $email, $username, $bio, $address1, $address2, $city, $state, $country, $countrycode, $mobile, $imagePath, $id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE editor SET firstname = ?, password = ?, lastname = ?, username = ?, email = ?, image = ?, bio = ?, mobile = ?, country = ?, 	city = ?, state = ?, address1 = ?, address2 = ?, country_code = ? WHERE id = ?");
    $stmt->bind_param("ssssssssssssssi", $firstname, $password, $lastname, $username, $email, $imagePath, $bio, $mobile, $country, $city, $state, $address1, $address2, $countrycode, $id);
    if ($stmt->execute()) {
        $content = "Admin ".$_SESSION['firstname']." updated $username's profile";
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
function updateUserProfile($firstname, $lastname, $email, $role, $url, $bio, $imagePath, $id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE otherwebsite_users SET firstname = ?, lastname = ?, email = ?, role = ?, image = ?, bio = ?, linkedin_url = ? WHERE id = ?");
    $stmt->bind_param("sssssssi", $firstname, $lastname, $email, $role, $imagePath, $bio, $url, $id);
    if ($stmt->execute()) {
        $content = "Admin ".$_SESSION['firstname']." updated $firstname's profile";
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
function updateWriterProfile($firstname, $lastname, $email, $bio, $imagePath, $id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE writer SET firstname = ?, lastname = ?, email = ?, image = ?, bio = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $firstname, $lastname, $email, $imagePath, $bio, $id);
    if ($stmt->execute()) {
        $content = "Admin ".$_SESSION['firstname']." updated $firstname's profile";
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
function addEditor($firstname, $lastname, $email, $img, $password, $admin_id) {
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("INSERT INTO editor (admin_id, email, image, password, firstname, lastname, date_joined, time_joined) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $admin_id, $email, $img, $password, $firstname, $lastname, $date, $time);
    if ($stmt->execute()) {
        $content = "Admin ".$_SESSION['firstname']." created a new user (Editor)";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "User Created Successfully";
        header('location: create_new/editor.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: create_new/editor.php');
    }
    $stmt->close();
}
function addWriter($firstname, $lastname, $email, $imagePath, $admin_id) {
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("INSERT INTO writer (admin_id, firstname, lastname, email, image, date_joined, time_joined) VALUES (?, ?, ?, ?, ?, ?, ? )");
    $stmt->bind_param("issssss", $admin_id, $firstname, $lastname, $email, $imagePath, $date, $time);
    if ($stmt->execute()) {
        $content = "Admin ".$_SESSION['firstname']." created a new user (Writer)";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "User Created Successfully";
        header('location: create_new/writer.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: create_new/writer.php');
    }
    $stmt->close();
}
function addUser($firstname, $lastname, $email,  $role, $linkedin_url, $imagePath) {
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("INSERT INTO otherwebsite_users ( firstname, lastname, email, role, image, linkedin_url, date_joined, time_joined) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $firstname, $lastname, $email, $role, $imagePath, $linkedin_url, $date, $time);
    if ($stmt->execute()) {
        $content = "Admin ".$_SESSION['firstname']." created a new user";
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
    $image = $_FILES['Post_Image']['name'];
    $target = "../images/" . basename($image);
    if (move_uploaded_file($_FILES['Post_Image']['tmp_name'], $target)) {
        $imagePath = $target;
        if( !empty($author_firstname) || !empty($author_lastname) || !empty($author_bio)){
            $admin_id = 0;
        }
        savePost($title, $subtitle, $imagePath, $content, $niche, $link, $schedule, $admin_id, $author_firstname, $author_lastname, $author_bio, $post_type);
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
    if($password === $confirm_pasword){
        if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
            $imagePath = $target;
            updateProfile($firstname, $lastname, $email, $username, $bio, $address1, $address2, $city, $state, $country, $countrycode, $mobile, $imagePath);
        }
    }
} 
if (isset($_POST['edit_profile_editor'])) {
    $id = $_POST['profile-id'];
    $firstname = $_POST['profile_firstname'];
    $password = $_POST['profile_password'];
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
    if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
        $imagePath = $target;
        updateEditorProfile($firstname, $password, $lastname, $email, $username, $bio, $address1, $address2, $city, $state, $country, $countrycode, $mobile, $imagePath, $id);
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
        updateWriterProfile($firstname, $lastname, $email, $bio, $imagePath, $id);
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
        updateUserProfile($firstname, $lastname, $email, $role, $url, $bio, $imagePath, $id);
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
        saveDraft($title, $subtitle, $imagePath, $content, $niche, $link, $admin_id);
    }
}
if (isset($_POST['update_post'])) {
    $title = $_POST['Post_Title'];
    $niche = $_POST['Post_Niche'];
    $content = $_POST['Post_content'];
    $link = $_POST['Post_featured'];
    $tablename = $_POST['table_type'];
    $subtitle = $_POST['Post_Sub_Title'];
    $author_firstname = $_POST['author_firstname'];
    $author_lastname = $_POST['author_lastname'];
    $author_bio = $_POST['about_author'];
    $image = $_FILES['Post_Image']['name'];
    $target = "../images/" . basename($image);
    if (move_uploaded_file($_FILES['Post_Image']['tmp_name'], $target)) {
        $imagePath = $target;
        if( !empty($author_firstname) || !empty($author_lastname) || !empty($author_bio)){
            $admin_id = " ";
        }
        updatePost($title, $subtitle, $imagePath, $content, $niche, $link, $admin_id, $author_firstname, $author_lastname, $author_bio, $tablename);
    }
}
if (isset($_POST['create_editor'])) {
    $firstname = $_POST['editor_firstname'];
    $lastname = $_POST['editor_lastname'];
    $email = $_POST['editor_email'];
    $password = $_POST['editor_password'];
    $confirm_pasword = $_POST['editor_password-confirm'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    if($password === $confirm_pasword){
        if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
            $imagePath = $target;
            addEditor($firstname, $lastname, $email, $imagePath, $password, $admin_id);
        }
    }
    else{
        echo "Passwords do not match";
        header('location: create_new/editor.php');
    }
} 
if (isset($_POST['create_writer'])) {
    $firstname = $_POST['writer_firstname'];
    $lastname = $_POST['writer_lastname'];
    $email = $_POST['writer_email'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    if($password === $confirm_pasword){
        if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
            $imagePath = $target;
            addWriter($firstname, $lastname, $email, $imagePath, $admin_id);
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
    if($password === $confirm_pasword){
        if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
            $imagePath = $target;
            addUser($firstname, $lastname, $email,  $role, $linkedin_url, $imagePath);
        }
    }

} 
if (isset($_POST['edit_privacypolicy_btn'])) {
    $content = $_POST['privacy_policy'];
    $tablename = "privacy_policy";
    updatePages($content, $tablename);
} 
if (isset($_POST['edit_aboutwebsite_btn'])) {
    $content = $_POST['about_website'];
    $tablename = "about_website";
    updatePages($content, $tablename);
} 
if (isset($_POST['advertedit_btn'])) {
    $content = $_POST['advertise_content'];
    $tablename = "advert_info";
    updatePages($content, $tablename);
} 
?>