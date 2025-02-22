<?php
    require("../connect.php");
    function logUpdate($conn, $forUser, $action) {
        date_default_timezone_set('UTC');
        $date = date('Y-m-d');
        $time = date("H:iA"); 
        $sql = "INSERT INTO updates (content, for_user, Date, time) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $action, $forUser, $date, $time);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }
    function createcategory($filename, $content, $description) {
        $file = fopen('../../pages/'.$filename, 'w');
        if ($file) {
            fwrite($file, $content);
            fclose($file);
        } else {
            die("Unable to create file.");
        }
        global $conn;    
        $stmt = $conn->prepare("INSERT INTO topics (name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $filename, $description);
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
        $conn->close();
    }
?>