<?php
    include ('connect.php');
    if (isset($_GET['id1'])) {
        $postId = $_GET['id1'];
        $sql = "DELETE FROM paid_posts WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Your post has been deleted.'
                    }).then(function() {
                        window.location.href = 'admin_homepage.php';
                    });
                </script>";
        } 
        else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    }).then(function() {
                        window.location.href = 'admin_homepage.php';
                    });
                    </script>";
        }
        $stmt->close();
    }
    if (isset($_GET['id2'])) {
        $postId = $_GET['id2'];
        $sql = "DELETE FROM posts WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Your post has been deleted.'
                    }).then(function() {
                        window.location.href = 'admin_homepage.php';
                    });
                </script>";
        } 
        else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    }).then(function() {
                        window.location.href = 'admin_homepage.php';
                    });
                    </script>";
        }
        $stmt->close();
    }
    if (isset($_GET['id3'])) {
        $postId = $_GET['id3'];
        $sql = "DELETE FROM unpublished_articles WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Your post has been deleted.'
                    }).then(function() {
                        window.location.href = 'admin_homepage.php';
                    });
                </script>";
        } 
        else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    }).then(function() {
                        window.location.href = 'admin_homepage.php';
                    });
                    </script>";
        }
        $stmt->close();
    }
    if (isset($_GET['id4'])) {
        $postId = $_GET['id4'];
        $sql = "DELETE FROM news WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Your post has been deleted.'
                    }).then(function() {
                        window.location.href = 'admin_homepage.php';
                    });
                </script>";
        } 
        else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    }).then(function() {
                        window.location.href = 'admin_homepage.php';
                    });
                    </script>";
        }
        $stmt->close();
    }
    if (isset($_GET['id5'])) {
        $postId = $_GET['id5'];
        $sql = "DELETE FROM commentaries WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Your post has been deleted.'
                    }).then(function() {
                        window.location.href = 'admin_homepage.php';
                    });
                </script>";
        } 
        else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    }).then(function() {
                        window.location.href = 'admin_homepage.php';
                    });
                    </script>";
        }
        $stmt->close();
    }
    if (isset($_GET['id6'])) {
        $postId = $_GET['id6'];
        $sql = "DELETE FROM press_releases WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Your post has been deleted.'
                    }).then(function() {
                        window.location.href = 'admin_homepage.php';
                    });
                </script>";
        } 
        else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    }).then(function() {
                        window.location.href = 'admin_homepage.php';
                    });
                    </script>";
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