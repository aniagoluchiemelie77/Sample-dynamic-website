<?php
    session_start();
    include("connect.php");
    require("crudoperations.php");
    $post_id = $_POST['post_id'] ?? '';
    $isfavourite = $_POST['isfavourite'] ?? '';
    if ($post_id && ($isfavourite !== '')) {
        $sql = "UPDATE posts SET 	is_favourite = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $isfavourite, $post_id);
        if ($stmt->execute()) {
            $content = "Editor ".$_SESSION['firstname']." bookmarked a post";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Post Bookmarked Successfully";
            header('location: view_all/posts.php');
        } else {
            echo "Error updating record: " . $stmt->error;
        }
    } else {
        echo "Invalid input.";
    }
?>