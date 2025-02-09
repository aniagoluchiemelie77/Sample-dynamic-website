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
    $servername = "localhost";
    $user = "root";
    $pass = "";
    $db = "new_posts";
    $conn = new mysqli($servername, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
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
    function createOtp($conn, $email) {
        global $msg;
        $check_email = mysqli_query($conn, "SELECT email FROM admin_login_info WHERE email = '$email'");
        $res = mysqli_num_rows($check_email);
        if ($res > 0){
            $token = rand(10000, 99999);
            $stmt = $conn->prepare("UPDATE admin_login_info SET token = ? WHERE email = ?");
            $stmt->bind_param('ss', $token, $email);
            if($stmt->execute()){
                $smtp_host = 'smtp.gmail.com';
                $smtp_port = 587;
                $smtp_username = 'aniagoluchiemelie77@gmail.com';
                $smtp_password = 'ChibzAniagolu2003*';
                $subject = 'Password Reset OTP';
                $to = $email;
                $message = "Your OTP for password reset is: $token";
                $headers = "From: $smtp_username\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                $smtp_conn = fsockopen($smtp_host, $smtp_port, $errno, $errstr, 10);
                if (!$smtp_conn) {
                    $msg = "Failed to connect to SMTP server: $errstr ($errno)";
                    exit;
                }
                $smtp_commands = [
                    "EHLO localhost",
                    "STARTTLS",
                    "EHLO localhost",
                    "AUTH LOGIN",
                    base64_encode($smtp_username),
                    base64_encode($smtp_password),
                    "MAIL FROM: <$smtp_username>",
                    "RCPT TO: <$email>",
                    "DATA",
                    "Subject: $subject\r\n$headers\r\n$message\r\n.",
                    "QUIT"
                ];
                foreach ($smtp_commands as $command) {
                    fputs($smtp_conn, $command . "\r\n");
                    $response = fgets($smtp_conn, 512);
                    if (strpos($response, '220') === false && strpos($response, '235') === false && strpos($response, '250') === false && strpos($response, '354') === false) {
                        $msg = "Failed to send email: $response";
                        fclose($smtp_conn);
                        exit;
                    }
                }
                fclose($smtp_conn);
                $msg = "OTP sent to your email";
                $_SESSION['email'] = $email;
                header("Location: verifyotp.php");
            }
        }
    }
?>