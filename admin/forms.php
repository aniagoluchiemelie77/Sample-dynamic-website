<?php
include "connect.php";
if (isset($_POST['Sign_Up'])) {
    $firstName = $_POST['First_Name'];
    $LastName = $_POST['Last_Name'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    $password_main = md5($password);
    $username = $_POST['Username'];
    $check_email = 'SELECT * FROM admin_login_info WHERE email ="$email"';
    $result = $conn -> query($check_email);
    if($result -> num_rows > 0){
        echo "Email already exists";
    }else{
        $insertQuery = 'INSERT INTO admin_login_info (admin_firstname, admin_lastname, admin_email, admin_password, admin_username) values ("$firstName", "$LastName", "$email", "$password_main", "$username")';
        if($conn -> query($insertQuery) == TRUE) {
            header("location: admin.php");
        }else{
            echo "Error".$conn -> error;
        }
    }
}
?>