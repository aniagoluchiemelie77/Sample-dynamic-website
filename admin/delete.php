<?php
    session_start();
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $usertype = isset($_GET['usertype']) ? $_GET['usertype'] : null;
    include ('connect.php');
    include ('crudoperations.php');
    $_SESSION['status_type'] = "";
    $_SESSION['status'] = "";
    if (isset($_GET['id1'])) {
        $postId = $_GET['id1'];
        $sql = "DELETE FROM paid_posts WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        if ($stmt->execute()) {
            $content = "You deleted a paid post";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Post Deleted Successfully";
            header('location: admin_homepage.php');
        } 
        else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: admin_homepage.php');
        }
        $stmt->close();
    }
    if (isset($_GET['id2'])) {
        $postId = $_GET['id2'];
        $sql = "DELETE FROM posts WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        if ($stmt->execute()) {
            $content = "You deleted a post";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Post Deleted Successfully";
            header('location: admin_homepage.php');
        } 
        else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: admin_homepage.php');
        }
        $stmt->close();
    }
    if (isset($_GET['id3'])) {
        $postId = $_GET['id3'];
        $sql = "DELETE FROM unpublished_articles WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        if ($stmt->execute()) {
            $content = "You deleted a Draft";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Post Deleted Successfully";
            header('location: admin_homepage.php');
        } 
        else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: admin_homepage.php');
        }
        $stmt->close();
    }
    if (isset($_GET['id4'])) {
        $postId = $_GET['id4'];
        $sql = "DELETE FROM news WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        if ($stmt->execute()) {
            $content = "You deleted a news post";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Post Deleted Successfully";
            header('location: admin_homepage.php');
        } 
        else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: admin_homepage.php');
        }
        $stmt->close();
    }
    if (isset($_GET['id5'])) {
        $postId = $_GET['id5'];
        $sql = "DELETE FROM commentaries WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        if ($stmt->execute()) {
            $content = "You deleted a commentary post";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Post Deleted Successfully";
            header('location: admin_homepage.php');
        } 
        else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: admin_homepage.php');
        }
        $stmt->close();
    }
    if (isset($_GET['id6'])) {
        $postId = $_GET['id6'];
        $sql = "DELETE FROM press_releases WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        if ($stmt->execute()) {
            $content = "You deleted a press release post";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Post Deleted Successfully";
            header('location: admin_homepage.php');
        } 
        else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: admin_homepage.php');
        }
        $stmt->close();
    }
    if ($usertype == "Editor") {
        $sql = "DELETE FROM editor WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $content = "Admin ".$_SESSION['firstname']."  deleted an Editor";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "User Deleted Successfully";
            header('location: admin_homepage.php');
        } 
        else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: admin_homepage.php');
        }
        $stmt->close();
    }
    if ($usertype == "Writer") {
        $sql = "DELETE FROM writer WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $content = "Admin ".$_SESSION['firstname']."  deleted a Writer";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "User Deleted Successfully";
            header('location: admin_homepage.php');
        } 
        else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: admin_homepage.php');
        }
        $stmt->close();
    }
    if ($usertype == "Otheruser") {
        $sql = "DELETE FROM otherwebsite_users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $content = "Admin ".$_SESSION['firstname']."  deleted a User";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "User Deleted Successfully";
            header('location: admin_homepage.php');
        } 
        else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: admin_homepage.php');
        }
        $stmt->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
</html>