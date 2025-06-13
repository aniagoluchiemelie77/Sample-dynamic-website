<?php
require('init.php');
require('connect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $email = $_POST["email"];
    $filePath = $_FILES["image"]["tmp_name"];
    $imageUrl = uploadToCloudinary($filePath);

    if ($imageUrl) {
        // Send email with uploaded image link
        $subject = "Your Uploaded Image";
        $message = "Here is your uploaded image link: $imageUrl";
        $headers = "From: no-reply@yourdomain.com\r\n";

        if (mail($email, $subject, $message, $headers)) {
            echo "Upload successful! Check your email for the image link.";
        } else {
            echo "Upload successful, but email failed.";
        }
    } else {
        echo "Upload failed!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image to Cloudinary</title>
</head>
<body>

    <h2>Upload an Image</h2>
    <form action="test.php" method="post" enctype="multipart/form-data">
        <label for="email">Your Email:</label>
        <input type="email" name="email" required><br><br>

        <label for="image">Select Image:</label>
        <input type="file" name="image" accept="image/*" required><br><br>

        <button type="submit">Upload</button>
    </form>

</body>
</html>
