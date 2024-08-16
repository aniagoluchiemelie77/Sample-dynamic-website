<?php
require ("connect.php");
if (isset($_POST['Sign_In'])) {
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    $sql = "SELECT * FROM editor WHERE editor_email='$email' and editor_password = '$password'";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        header("location: editor_homepage.php");
        exit();
    }else{
        echo ` Incorrect Username or Password.`;
        header("location: index.php");
    }
}
?>