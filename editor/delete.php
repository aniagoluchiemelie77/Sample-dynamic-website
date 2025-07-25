<?php
session_start();
include('connect.php');
include('../helpers/crudoperations.php');
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$usertype = isset($_GET['usertype']) ? $_GET['usertype'] : null;
$topicName = isset($_GET['topicName']) ? $_GET['topicName'] : null;
$pageName = isset($_GET['pageName']) ? $_GET['pageName'] : null;
$resourceName = isset($_GET['resourceName']) ? $_GET['resourceName'] : null;
$type = isset($_GET['type']) ? $_GET['type'] : null;
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
$firstname = $_SESSION['firstname'];
function deleteFile($file_path, $pagetype)
{
    if (file_exists($file_path)) {
        if (unlink($file_path)) {
            $status = "$pagetype Deleted Successfully";
            $status_type = "Success";
            return ["status" => $status, "status_type" => $status_type];
        } else {
            $status = "Error Deleting File ($pagetype)!";
            $status_type = "Error";
            return ["status" => $status, "status_type" => $status_type];
        }
    } else {
        $status = "File does not exist: " . basename($file_path);
        $status_type = "Error";
        return ["status" => $status, "status_type" => $status_type];
    }
}
if (isset($_GET['id2'])) {
    $postId = $_GET['id2'];
    $sql = "DELETE FROM posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $postId);
    if ($stmt->execute()) {
        $content = "Editor $firstname deleted a post";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Post Deleted Successfully";
        header('location: editor_homepage.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: editor_homepage.php');
    }
    $stmt->close();
}
if (isset($_GET['id3'])) {
    $postId = $_GET['id3'];
    $sql = "DELETE FROM unpublished_articles WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $postId);
    if ($stmt->execute()) {
        $content = "Editor $firstname deleted a Draft";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Post Deleted Successfully";
        header('location: editor_homepage.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: editor_homepage.php');
    }
    $stmt->close();
}
if (isset($_GET['id4'])) {
    $postId = $_GET['id4'];
    $sql = "DELETE FROM news WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $postId);
    if ($stmt->execute()) {
        $content = "Editor $firstname deleted a News Post";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Post Deleted Successfully";
        header('location: editor_homepage.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: editor_homepage.php');
    }
    $stmt->close();
}
if (isset($_GET['id5'])) {
    $postId = $_GET['id5'];
    $sql = "DELETE FROM commentaries WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $postId);
    if ($stmt->execute()) {
        $content = "Editor $firstname deleted a Commentary Post";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Post Deleted Successfully";
        header('location: editor_homepage.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: editor_homepage.php');
    }
    $stmt->close();
}
if (isset($_GET['id6'])) {
    $postId = $_GET['id6'];
    $sql = "DELETE FROM press_releases WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $postId);
    if ($stmt->execute()) {
        $content = "Editor $firstname deleted a Press release Post";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Post Deleted Successfully";
        header('location: editor_homepage.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: editor_homepage.php');
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
            $pageType = "Category";
            $deleteAction2 = deleteFile($two_folders_above_file, $pageType);
            $_SESSION['status_type'] = $deleteAction2['status_type'];
            $_SESSION['status'] = $deleteAction2['status'];
            $content = "Editor " . $_SESSION['firstname'] . "  deleted a Category type";
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
    $resource_name = removeUnderscoreNoSpace($resourceName);
    $table_name = removeUnderscoreNoSpace($resourceName);
    $two_folders_above_file = "../pages/$resource_name.php";
    $sql = "DROP TABLE IF EXISTS `$table_name`";
    if ($conn->query($sql) === TRUE) {
        $sql = "DELETE FROM resources WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $sql = "DELETE FROM meta_titles WHERE page_name like ?";
            $searchTerm = "%" . $resource_name . "%";
            $stmt->bind_param("s", $searchTerm);
            if ($stmt->execute()) {
                $pageType = "Resource";
                $deleteAction2 = deleteFile($two_folders_above_file, $pageType);
                $_SESSION['status_type'] = $deleteAction2['status_type'];
                $_SESSION['status'] = $deleteAction2['status'];
                $content = "Editor " . $_SESSION['firstname'] . "  deleted a Resource type";
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
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Deleting table failed!";
        header('location: edit/frontend_features.php');
    }
}
if ($usertype == "Writer") {
    $sql = "DELETE FROM writer WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $content = "Editor " . $_SESSION['firstname'] . "  deleted a Writer";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Writer Deleted Successfully";
        header('location: editor_homepage.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: editor_homepage.php');
    }
    $stmt->close();
}
if ($usertype == "Otheruser") {
    $sql = "DELETE FROM otherwebsite_users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $content = "Editor " . $_SESSION['firstname'] . "  deleted a User";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "User Deleted Successfully";
        header('location: editor_homepage.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: editor_homepage.php');
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="Editor.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

</html>