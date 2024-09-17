<?php
session_start();
$author_id = "";
$_SESSION['id'] = $author_id;
require "connect.php";
if (isset($_POST['create_post'])) {
    $title = mysqli_real_escape_string($conn, $_POST['Post_Title']);
    $niche = mysqli_real_escape_string($conn, $_POST['Post_Niche']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['Post_Sub_Title']);
    $link = mysqli_real_escape_string($conn, $_POST['Post_featured']);
    $content = mysqli_real_escape_string($conn, $_POST['Post_content']);
    $schedule = $_POST['schedule'];
    $date = date('y-m-d');
    $time = date('H:i:s');
    $image = $_FILES['Post_Image']['name'];
    $target = "images/" . basename($image);
    if (move_uploaded_file($_FILES['Post_Image']['tmp_name'], $target)) {
        $imagePath = $target;
        $response = array();
        if (!empty($schedule)) {
            $sql = "INSERT INTO posts (editor_id, niche, subtitle, link, image, content, title, schedule) VALUES ('$author_id', '$niche', '$subtitle', '$link', '$imagePath', '$content', '$title', '$schedule')";
            if ($conn->query($sql) === TRUE) {
                $response['success'] = true;
                $response['message'] = "Post added successfully!";
            } else {
                $response['success'] = false;
                $response['message'] = "Error: " . $sql . "<br>" . $conn->error;
            }
        }else{
            $sql = "INSERT INTO posts (editor_id, niche, subtitle, link, image, content, title, Date, time) VALUES ('$author_id', '$niche', '$subtitle', '$link', '$imagePath', '$content', '$title', '$date', '$time')";
            if ($conn->query($sql) === TRUE) {
                $response['success'] = true;
                $response['message'] = "Post added successfully!";
            } else {
                $response['success'] = false;
                $response['message'] = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }else{
        $response['success'] = false;
        $response['message'] = "Failed to upload image.";
        exit();
    }
    $conn->close();
    echo json_encode($response);
}
?>