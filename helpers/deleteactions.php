<?php
/** @var \mysqli $conn */
global $conn;
session_start();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$usertype = isset($_GET['usertype']) ? $_GET['usertype'] : null;
$usertype2 = isset($_GET['usertype2']) ? $_GET['usertype2'] : null;
$topicName = isset($_GET['topicName']) ? $_GET['topicName'] : null;
$resourceFileType = isset($_GET['ResourceFileType']) ? $_GET['ResourceFileType'] : null;
$pageName = isset($_GET['pageName']) ? $_GET['pageName'] : null;
$action = isset($_GET['action']) ? $_GET['action'] : null;
$resourceName = isset($_GET['resourceName']) ? $_GET['resourceName'] : null;
$userFirstname = isset($_GET['userFirstname']) ? $_GET['userFirstname'] : null;
$type = isset($_GET['type']) ? $_GET['type'] : null;
include('connect.php');
include('../helpers/crudoperations.php');
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
$admin_base_url = "../admin/";
$editor_base_url = "../editor/";
function returnPath()
{
    global $admin_base_url, $editor_base_url, $usertype, $usertype2;
    if ($usertype === 'Admin' || $usertype2 === "Admin") {
        return $admin_base_url;
    } else if ($usertype === "Editor" || $usertype2 === "Editor") {
        return $editor_base_url;
    }
}
if (isset($_GET['userFirstname']) && isset($_GET['usertype'])) {
    if (isset($_GET['id1'])) {
        $postId = $_GET['id1'];
        $table_name = 'paid_posts';
        deletePostAction($table_name, $postId, $usertype, $userFirstname);
    }
    if (isset($_GET['id2'])) {
        $postId = $_GET['id2'];
        $table_name = 'posts';
        deletePostAction($table_name, $postId, $usertype, $userFirstname);
    }
    if (isset($_GET['id3'])) {
        $postId = $_GET['id3'];
        $table_name = 'unpublished_articles';
        deletePostAction($table_name, $postId, $usertype, $userFirstname);
    }
    if (isset($_GET['id4'])) {
        $postId = $_GET['id4'];
        $table_name = 'news';
        deletePostAction($table_name, $postId, $usertype, $userFirstname);
    }
    if (isset($_GET['id5'])) {
        $postId = $_GET['id5'];
        $table_name = 'commentaries';
        deletePostAction($table_name, $postId, $usertype, $userFirstname);
    }
    if (isset($_GET['id6'])) {
        $postId = $_GET['id6'];
        $table_name = 'press_releases';
        deletePostAction($table_name, $postId, $usertype, $userFirstname);
    }
}
if (isset($_GET['id']) && $action === 'deleteUser' && isset($_GET['usertype2']) && isset($_GET['userFirstname'])) {
    if ($usertype === "Editor") {
        $table_name = 'editor';
        deleteUserAction($table_name, $id, $usertype2, $userFirstname, $usertype);
    } else if ($usertype === "Writer") {
        $table_name = 'writer';
        deleteUserAction($table_name, $id, $usertype2, $userFirstname, $usertype);
    } else if ($usertype === "Otheruser") {
        $table_name = 'otherwebsite_users';
        deleteUserAction($table_name, $id, $usertype2, $userFirstname, $usertype);
    } else if ($usertype === "Subscriber") {
        $table_name = 'otherwebsite_users';
        deleteUserAction($table_name, $id, $usertype2, $userFirstname, $usertype);
    } else if ($usertype === "NewsletterSubscriber") {
        $table_name = 'newsletter_subscribers';
        deleteUserAction($table_name, $id, $usertype2, $userFirstname, $usertype);
    }
}
if ($type == "Category") {
    if ($usertype === 'Admin') {
        $page_name = removeHyphenNoSpace($topicName);
        $two_folders_above_file = "../pages/$page_name.php";
        $sql = "DELETE FROM topics WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            $returnPath = returnPath();
            header('location: ' . $returnPath . 'pages/categories.php');
        }
        $sql = "DELETE FROM meta_titles WHERE page_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $topicName);
        if ($stmt->execute()) {
            $deleteAction2 = deleteFile($two_folders_above_file, $type);
            $_SESSION['status_type'] = $deleteAction2['status_type'];
            $_SESSION['status'] = $deleteAction2['status'];
            $content = "Admin " . $userFirstname . "  deleted a Category type";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $returnPath = returnPath();
            header('location: ' . $returnPath . 'pages/categories.php');
        }
    } else if ($usertype === 'Editor') {
        $page_name = removeHyphenNoSpace($topicName);
        $two_folders_above_file = "../pages/$page_name.php";
        $sql = "DELETE FROM topics WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            $returnPath = returnPath();
            header('location: ' . $returnPath . 'pages/categories.php');
        }
        $sql = "DELETE FROM meta_titles WHERE page_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $topicName);
        if ($stmt->execute()) {
            $deleteAction2 = deleteFile($two_folders_above_file, $type);
            $_SESSION['status_type'] = $deleteAction2['status_type'];
            $_SESSION['status'] = $deleteAction2['status'];
            $content = "Editor " . $userFirstname . "  deleted a Category type";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $returnPath = returnPath();
            header('location: ' . $returnPath . 'pages/categories.php');
        }
    }
}
if ($type == "Resource") {
    if ($usertype === 'Admin') {
        $resource_name = removeUnderscoreNoSpace($resourceName);
        $table_name = removeUnderscoreNoSpace($resourceName);
        $two_folders_above_file = "../pages/$resource_name.php";
        $sql = "DROP TABLE IF EXISTS `$table_name`";
        if ($conn->query($sql) === TRUE) {
            $sql = "DELETE FROM resources WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ../admin/edit/frontend_features.php');
            }
            $sql = "DELETE FROM meta_titles WHERE page_name like ?";
            $searchTerm = "%" . $resource_name . "%";
            $stmt->bind_param("s", $searchTerm);
            if (!$stmt->execute()) {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ../admin/edit/frontend_features.php');
            }
            $deleteAction2 = deleteFile($two_folders_above_file, $type);
            $_SESSION['status_type'] = $deleteAction2['status_type'];
            $_SESSION['status'] = $deleteAction2['status'];
            $content = "Admin " . $userFirstname . "  deleted a Resource type";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            header('location: ../admin/edit/frontend_features.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Deleting table failed!";
            header('location: ../admin/edit/frontend_features.php');
        }
    } else if ($usertype === 'Editor') {
        $resource_name = removeUnderscoreNoSpace($resourceName);
        $table_name = removeUnderscoreNoSpace($resourceName);
        $two_folders_above_file = "../pages/$resource_name.php";
        $sql = "DROP TABLE IF EXISTS `$table_name`";
        if ($conn->query($sql) === TRUE) {
            $sql = "DELETE FROM resources WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ../editor/edit/frontend_features.php');
            }
            $sql = "DELETE FROM meta_titles WHERE page_name like ?";
            $searchTerm = "%" . $resource_name . "%";
            $stmt->bind_param("s", $searchTerm);
            if (!$stmt->execute()) {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ../editor/edit/frontend_features.php');
            }
            $deleteAction2 = deleteFile($two_folders_above_file, $type);
            $_SESSION['status_type'] = $deleteAction2['status_type'];
            $_SESSION['status'] = $deleteAction2['status'];
            $content = "Editor " . $userFirstname . "  deleted a Resource type";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            header('location: ../editor/edit/frontend_features.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Deleting table failed!";
            header('location: ../editor/edit/frontend_features.php');
        }
    }
}
if ($action == "deleteResource") {
    if ($usertype === 'Admin') {
        $sql = "DELETE FROM $resourceFileType WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            $returnPath = returnPath();
            header('location: ' . $returnPath . ' edit/frontend_features.php');
        }
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Resource File from " . $resourceFileType . " Deleted Successfully";
        $content = "Admin " . $userFirstname . "  deleted a Resource file";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $returnPath = returnPath();
        header('location: ' . $returnPath . ' edit/frontend_features.php');
    } else if ($usertype === 'Editor') {
        $sql = "DELETE FROM $resourceFileType WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            $returnPath = returnPath();
            header('location: ' . $returnPath . ' edit/frontend_features.php');
        }
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Resource File from " . $resourceFileType . " Deleted Successfully";
        $content = "Editor " . $userFirstname . "  deleted a Resource file";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $returnPath = returnPath();
        header('location: ' . $returnPath . ' edit/frontend_features.php');
    }
}
if ($type == "Page" && $usertype === 'Admin') {
    $page_name = removeHyphenNoSpace($pageName);
    $table_name = addUnderscore($pageName);
    $current_folder_file = "../admin/pages/$page_name.php";
    $current_folder_file2 = "../editor/pages/$page_name.php";
    $two_folders_above_file = "../pages/$page_name.php";
    $sql = "DROP TABLE IF EXISTS `$table_name`";
    if ($conn->query($sql) === TRUE) {
        $sql = "DELETE FROM pages WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: ../admin/edit/frontend_features.php');
        }
        $deleteAction1 = deleteFile($current_folder_file, $type);
        $deleteAction2 = deleteFile($two_folders_above_file, $type);
        $deleteAction3 = deleteFile($current_folder_file2, $type);
        $status_type1 = $deleteAction1['status_type'];
        $status_type2 = $deleteAction2['status_type'];
        $status_type3 = $deleteAction3['status_type'];
        if ($status_type1 === 'Success' && $status_type2 === 'Success' && $status_type3 === 'Success') {
            $sql = "DELETE FROM meta_titles WHERE page_name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $pageName);
            if (!$stmt->execute()) {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ../admin/edit/frontend_features.php');
            }
            $content = "Admin " . $userFirstname . " deleted a Page ($pageName)";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Page ($pageName) deleted successfully";
            header('location: ../admin/edit/frontend_features.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Could not delete Page";
            header('location: ../admin/edit/frontend_features.php');
        }
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Deleting table failed!";
        header('location: edit/frontend_features.php');
    }
}
