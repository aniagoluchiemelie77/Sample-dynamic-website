<?php
session_start();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$usertype = isset($_GET['usertype']) ? $_GET['usertype'] : null;
$topicName = isset($_GET['topicName']) ? $_GET['topicName'] : null;
$pageName = isset($_GET['pageName']) ? $_GET['pageName'] : null;
$type = isset($_GET['type']) ? $_GET['type'] : null;
include('connect.php');
include('crudoperations.php');
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
function deleteFile($file_path)
{
    if (file_exists($file_path)) {
        if (unlink($file_path)) {
            $status = "Page Deleted Successfully";
            $status_type = "Success";
            return ["status" => $status, "status_type" => $status_type];
        } else {
            $status = "Error Deleting Files!";
            $status_type = "Error";
            return ["status" => $status, "status_type" => $status_type];
        }
    } else {
        $status = "File does not exist: " . basename($file_path);
        $status_type = "Error";
        return ["status" => $status, "status_type" => $status_type];
    }
}
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
    } else {
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
    } else {
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
    } else {
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
    } else {
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
    } else {
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
    } else {
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
        $content = "Admin " . $_SESSION['firstname'] . "  deleted an Editor";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "User Deleted Successfully";
        header('location: admin_homepage.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: admin_homepage.php');
    }
    $stmt->close();
}
if ($type == "Category") {
    $page_name = removeHyphenNoSpace($topicName);
    $two_folders_above_file = "../pages/$page_name.php";
    $sql = "DELETE FROM topics WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $sql = "DELETE FROM meta_titles WHERE page_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $topicName);
        if ($stmt->execute()) {
            $deleteAction2 = deleteFile($two_folders_above_file);
            $_SESSION['status_type'] = $deleteAction2['status_type'];
            $_SESSION['status'] = $deleteAction2['status'];
            $content = "Admin " . $_SESSION['firstname'] . "  deleted a Category type";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            header('location: pages/categories.php');
        }
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: pages/categories.php');
    }
    $stmt->close();
}
if ($type == "Resource") {
    $sql = "DELETE FROM resources WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . "  deleted a Resource type";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Resource Deleted Successfully";
        header('location: edit/frontend_features.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: edit/frontend_features.php');
    }
    $stmt->close();
}
if ($type == "Page") {
    $page_name = removeHyphenNoSpace($pageName);
    $current_folder_file = "pages/$page_name.php";
    $two_folders_above_file = "../pages/$page_name.php";
    $sql = "DELETE FROM pages WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $deleteAction1 = deleteFile($current_folder_file);
        $_SESSION['status_type'] = $deleteAction1['status_type'];
        $_SESSION['status'] = $deleteAction1['status'];
        $sql = "DELETE FROM meta_titles WHERE page_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $pageName);
        if ($stmt->execute()) {
            $deleteAction2 = deleteFile($two_folders_above_file);
            $_SESSION['status_type'] = $deleteAction2['status_type'];
            $_SESSION['status'] = $deleteAction2['status'];
            $content = "Admin " . $_SESSION['firstname'] . "  deleted a Page type";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            header('location: edit/frontend_features.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: edit/frontend_features.php');
        }
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: edit/frontend_features.php');
    }
    $stmt->close();
}
if ($usertype == "Writer") {
    $sql = "DELETE FROM writer WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . "  deleted a Writer";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Writer Deleted Successfully";
        header('location: admin_homepage.php');
    } else {
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
        $content = "Admin " . $_SESSION['firstname'] . "  deleted a User";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "User Deleted Successfully";
        header('location: admin_homepage.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: admin_homepage.php');
    }
    $stmt->close();
}
if ($usertype == "Subscriber") {
    $sql = "DELETE FROM subscribers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . "  deleted an Email Subscriber";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Email Subscriber Deleted Successfully";
        header('location: pages/subscribers.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: pages/subscribers.php');
    }
    $stmt->close();
}
if ($usertype == "NewsletterSubscriber") {
    $sql = "DELETE FROM newsletter_subscribers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . "  deleted a Newsletter Subscriber";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Newsletter Subscriber Deleted Successfully";
        header('location: pages/newslettersignups.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: pages/newslettersignups.php');
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="admin.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

</html>