<?php
require('init.php');
function doSth(){
    $directory = "images/"; // Path to the folder
    $files = scandir($directory); // Get all file names

    foreach ($files as $file) {
        $filePath = $directory . $file;
    
        // Skip non-image files
        if (!preg_match('/\.(jpg|jpeg|png|webp)$/i', $file)) {
            continue;
        }
    
        // Upload the image
        $imageUrl = uploadToCloudinary($filePath);
        echo $file . " uploaded: " . ($imageUrl ?? "Upload failed") . "<br>";
    }
}
?>
