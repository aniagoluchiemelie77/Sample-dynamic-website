<?php
    session_start();
    $_SESSION['id'] = $editor_id; 
    $_SESSION['status_type'] = "";
    $_SESSION['status'] = "";
    require ("connect.php");
    include ('crudoperations.php');
    function convertPath($path) {
        return basename($path);
    }
    function savePost($title, $subtitle, $convertedPath, $content, $niche, $link, $schedule, $editor_id, $author_firstname, $author_lastname, $author_bio, $post_type) {
        global $conn;
        $date = date('y-m-d');
        $time = date('H:i:s');
        $idtype = "";
        if ($post_type === "posts") {
            $idtype = "id2";
        }elseif ($post_type === "news") {
            $idtype = "id3";
        }elseif ($post_type === "commentaries") {
            $idtype = "id4";
        }else{
            $idtype = "id5";
        }
        $is_favourite = 0;
        $sql = "INSERT INTO $post_type (editor_id, title, niche, image_path, Date, time, schedule, subtitle, link, content, authors_firstname, about_author, authors_lastname, idtype, is_favourite) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if($query = $conn->prepare($sql)) { 
            $query->bind_param("sssssssisssss", $editor_id, $title, $niche, $convertedPath, $date, $time, $schedule, $subtitle, $link, $content, $author_firstname, $author_bio, $author_lastname, $idtype, $is_favourite);
            if ($query->execute()) {
                $content = "Editor ".$_SESSION['firstname']." added a new post (".$post_type.")";
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
    function saveDraft($title, $subtitle, $imagePath, $content, $niche, $link, $editor_id) {
        global $conn;
        $date = date('y-m-d');
        $time = date('H:i:s');
        $stmt = $conn->prepare("INSERT INTO unpublished_articles (editor_id, title, subtitle, image, link, Date, time, niche, content) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssss", $editor_id, $title, $subtitle, $imagePath, $link, $date, $time, $niche, $content);
        if ($stmt->execute()) {
            $content = "Editor ".$_SESSION['firstname']." created a draft";
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
    function updatePost($title, $subtitle, $imagePath, $content, $niche, $link, $editor_id, $author_firstname, $author_lastname, $author_bio, $tablename) {
        global $conn;
        $date = date('y-m-d');
        $time = date('H:i:s');
        $stmt = $conn->prepare("UPDATE $tablename SET title = ?, subtitle = ?, image_path = ?, content = ?, niche = ?, link = ?, editor_id = ?, Date = ?, time = ?, authors_firstname = ?, about_author = ?, authors_lastname = ?");
        $stmt->bind_param("ssssssssssss", $title, $subtitle, $imagePath, $content, $niche, $link, $editor_id, $date, $time, $author_firstname, $author_bio, $author_lastname);
        if ($stmt->execute()) {
            $content = "Editor ".$_SESSION['firstname']." updated a $tablename post";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Post Updated Successfully";
            header('location: edit/posts.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: edit/posts.php');
        }
        $stmt->close();
    }
    function updateProfile($firstname, $lastname, $email, $username, $bio, $address1, $address2, $city, $state, $country, $countrycode, $mobile, $imagePath) {
        global $conn;
        $stmt = $conn->prepare("UPDATE editor SET firstname = ?, lastname = ?, username = ?, email = ?, image = ?, bio = ?, mobile = ?, country = ?, 	city = ?, state = ?, address1 = ?, address2 = ?, country_code = ?");
        $stmt->bind_param("sssssssssssss", $firstname, $lastname, $username, $email, $imagePath, $bio, $mobile, $country, $city, $state, $address1, $address2, $countrycode);
        if ($stmt->execute()) {
            $content = "Editor ".$_SESSION['firstname']." updated his/her profile";
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
    function updateUserProfile($firstname, $lastname, $email, $role, $url, $bio, $imagePath, $id) {
        global $conn;
        $stmt = $conn->prepare("UPDATE otherwebsite_users SET firstname = ?, lastname = ?, email = ?, role = ?, image = ?, bio = ?, linkedin_url = ? WHERE id = ?");
        $stmt->bind_param("sssssssi", $firstname, $lastname, $email, $role, $imagePath, $bio, $url, $id);
        if ($stmt->execute()) {
            $content = "Editor ".$_SESSION['firstname']." updated $firstname's profile";
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
            $content = "Editor ".$_SESSION['firstname']." updated $firstname's profile";
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
    function addWriter($firstname, $lastname, $email, $imagePath, $editor_id) {
        global $conn;
        $date = date('y-m-d');
        $time = date('H:i:s');
        $idtype = "Writer";
        $stmt = $conn->prepare("INSERT INTO writer (editor_id, firstname, lastname, email, image, date_joined, time_joined, idtype) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssss", $editor_id, $firstname, $lastname, $email, $imagePath, $date, $time, $idtype);
        if ($stmt->execute()) {
            $content = "Editor ".$_SESSION['firstname']." created a new user (Writer)";
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
            $content = "Editor ".$_SESSION['firstname']." created a new user";
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
            $convertedPath = convertPath($imagePath);
            if( !empty($author_firstname) || !empty($author_lastname) || !empty($author_bio)){
                $editor_id = 0;
            }
            savePost($title, $subtitle, $convertedPath, $content, $niche, $link, $schedule, $editor_id, $author_firstname, $author_lastname, $author_bio, $post_type);
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
                $convertedPath = convertPath($imagePath);
                updateProfile($firstname, $lastname, $email, $username, $bio, $address1, $address2, $city, $state, $country, $countrycode, $mobile, $convertedPath);
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
            $convertedPath = convertPath($imagePath);
            if( !empty($author_firstname) || !empty($author_lastname) || !empty($author_bio)){
                $editor_id = " ";
            }
            updatePost($title, $subtitle, $convertedPath, $content, $niche, $link, $editor_id, $author_firstname, $author_lastname, $author_bio, $tablename);
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
        if($password === $confirm_pasword){
            if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
                $imagePath = $target;
                $convertedPath = convertPath($imagePath);
                addUser($firstname, $lastname, $email,  $role, $linkedin_url, $convertedPath);
            }
        }
    } 
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profilePicture'])) {
        $targetDir = "../images/";
        $targetFile = $targetDir . basename($_FILES['profilePicture']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES['profilePicture']['tmp_name']);
        if ($check !== false) {
            if (!file_exists($targetFile)) {
                if ($_FILES['profilePicture']['size'] <= 9000000) {
                    if (in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                        if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $targetFile)) {
                            $convertedPath = convertPath($targetFile);
                            $stmt = $conn->prepare("UPDATE editor SET image = ? ");
                            $stmt->bind_param("s", $convertedPath);
                            if ($stmt->execute()) {
                                $content = "Editor ".$_SESSION['firstname']." changed his/her profile picture";
                                $forUser = 0;
                                logUpdate($conn, $forUser, $content);
                                $_SESSION['status_type'] = "Success";
                                $_SESSION['status'] = "Profile Picture Updated Successfully";
                                header('location: editor_homepage.php');
                            } else {
                                $_SESSION['status_type'] = "Error";
                                $_SESSION['status'] = "Error, Please retry";
                                header('location: editor_homepage.php');
                            }
                        } else {
                            $_SESSION['status_type'] = "Error";
                            $_SESSION['status'] = "Error, Please retry";
                            header('location: editor_homepage.php');
                        }
                    } else {
                        $_SESSION['status_type'] = "Error";
                        $_SESSION['status'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        header('location: editor_homepage.php'); 
                    }
                } else {
                    $_SESSION['status_type'] = "Error";
                    $_SESSION['status'] = "Sorry, your image file is too large.";
                    header('location: editor_homepage.php');
                }
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Sorry, Image already exists.";
                header('location: editor_homepage.php');
            }
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Submitted File is not an image.";
            header('location: editor_homepage.php');
        }
    }else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "No file uploaded.";
        header('location: editor_homepage.php');
    }
?>