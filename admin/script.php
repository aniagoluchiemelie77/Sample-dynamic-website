<?php

/** @var \mysqli $conn */
global $conn;
session_start();
include("connect.php");
require("../helpers/crudoperations.php");
$_SESSION['status_type'] = " ";
$_SESSION['status'] = " ";
$post_id1 = $_POST['post_id1'] ?? '';
$isfavourite1 = $_POST['isfavourite1'] ?? '';
$post_id2 = $_POST['post_id2'] ?? '';
$isfavourite2 = $_POST['isfavourite2'] ?? '';
$post_id3 = $_POST['post_id3'] ?? '';
$isfavourite3 = $_POST['isfavourite3'] ?? '';
$post_id4 = $_POST['post_id4'] ?? '';
$isfavourite4 = $_POST['isfavourite4'] ?? '';
$post_id5 = $_POST['post_id5'] ?? '';
$isfavourite5 = $_POST['isfavourite5'] ?? '';
$actionType = '';
if ($post_id1 && $isfavourite1 !== '') {
    if ($isfavourite1 === 'True') {
        $actionType = 'bookmarked a post from Paid Posts';
    } else {
        $actionType = 'unmarked a post from Paid Posts';
    }
    $sql = "UPDATE paid_posts SET is_favourite = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $isfavourite1, $post_id1);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " $actionType";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        header('location: view_all/paidposts.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error! Please retry";
        header('location: view_all/paidposts.php');
    }
}
if ($post_id2 && $isfavourite2 !== '') {
    if ($isfavourite2 === 'True') {
        $actionType = 'bookmarked a post from Posts';
    } else {
        $actionType = 'unmarked a post from Posts';
    }
    $sql = "UPDATE posts SET is_favourite = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $isfavourite2, $post_id2);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " $actionType";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        header('location: view_all/posts.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error! Please retry";
        header('location: view_all/posts.php');
    }
}
if ($post_id3 && $isfavourite3 !== '') {
    if ($isfavourite3 === 'True') {
        $actionType = 'bookmarked a post from Press Releases';
    } else {
        $actionType = 'unmarked a post from Press Releases';
    }
    $sql = "UPDATE press_releases SET is_favourite = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $isfavourite3, $post_id3);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " $actionType";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        header('location: view_all/pressreleases.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error! Please retry";
        header('location: view_all/pressreleases.php');
    }
}
if ($post_id4 && $isfavourite4 !== '') {
    if ($isfavourite4 === 'True') {
        $actionType = 'bookmarked a News post';
    } else {
        $actionType = 'unmarked a News post';
    }
    $sql = "UPDATE news SET is_favourite = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $isfavourite4, $post_id4);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " $actionType";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        header('location: view_all/news.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error! Please retry";
        header('location: view_all/news.php');
    }
}
if ($post_id5 && $isfavourite5 !== '') {
    if ($isfavourite5 === 'True') {
        $actionType = 'bookmarked a post from Commentaries';
    } else {
        $actionType = 'unmarked a post from Commentaries';
    }
    $sql = "UPDATE commentaries SET is_favourite = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $isfavourite5, $post_id5);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " $actionType";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        header('location: view_all/commentaries.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error! Please retry";
        header('location: view_all/commentaries.php');
    }
}
?>