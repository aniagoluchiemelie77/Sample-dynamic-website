<?php
include "connect.php";
if (isset($_POST['Sign_Up'])) {
    $firstName = $_POST['First_Name'];
    $lastName = $_POST['Last_Name'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    $username = $_POST['Username'];
    $check_email = 'SELECT * FROM admin_login_info WHERE email="$email" AND username="$username"';
    $result = $conn->query($check_email);
    if($result->num_rows>0){
        echo "User already exists";
    }else{
        $insertQuery = 'INSERT INTO admin_login_info(firstname, lastname, username, password, email) values ("$firstName", "$lastName","$username","$password", "$email")';
        if($conn->query($insertQuery) == TRUE) {
            echo"User Registered";
            header("location: index.php");
        }else{
            echo "Error".$conn -> error;
        }
    }
}
if (isset($_POST['Sign_In'])) {
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    $sql = "SELECT * FROM admin_login_info WHERE email='$email' /*and password='$password'*/";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        header("location: admin_homepage.php");
        exit();
    }else{
            echo "Not Found, Incorrect Email";
    }
}

?>