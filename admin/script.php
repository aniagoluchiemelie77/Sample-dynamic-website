<?php
    session_start();
    include("connect.php");
    require("crudoperations.php");
    $post_id = $_POST['post_id'] ?? '';
    $post_id1 = $_POST['post_id1'] ?? '';
    $isfavourite = $_POST['isfavourite'] ?? '';
    $isfavourite1 = $_POST['isfavourite1'] ?? '';
    if ($post_id && ($isfavourite !== '')) {
        $sql = "UPDATE posts SET 	is_favourite = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $isfavourite, $post_id);
        if ($stmt->execute()) {
            $content = "Admin ".$_SESSION['firstname']." bookmarked a post";
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
    if ($post_id1 && ($isfavourite1 !== '')) {
        $sql = "UPDATE paid_posts SET	is_favourite = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $isfavourite1, $post_id1);
        if ($stmt->execute()) {
            $content = "Admin ".$_SESSION['firstname']." bookmarked a post";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Post Bookmarked Successfully";
            header('location: view_all/paidposts.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error! Please retry";
            header('location: view_all/paidposts.php');
        }
} else {
    echo "Invalid input.";
}

?>