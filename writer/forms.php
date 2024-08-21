<?php
require "connect.php";
require "includes.php";
if (isset($_POST['Sign_In'])) {
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    $sql = "SELECT * FROM writer WHERE writer_email='$email' and writer_password = '$password'";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        header("location: writer_homepage.php");
        exit();
    }else{
        $logs = "Unsuccessful Login Attempt by User";
        logger($logs);
        header("location: index.php");
    }
}
?>