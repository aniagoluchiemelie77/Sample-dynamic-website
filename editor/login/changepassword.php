<?php
session_start();
require("../connect.php");
include("../crudoperations.php");
require('../../init.php');
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
$msg = " ";
if (isset($_POST['change_password'])) {
    $password1 = $_POST['pwd'];
    $password2 = $_POST['cfpwd'];
    $email = $_SESSION['email'];
    if ($password1 === $password2) {
        $final_password = MD5($password1);
        $stmt = $conn->prepare("UPDATE editor SET password = ? WHERE email = ?");
        $stmt->bind_param('ss',  $final_password, $email);
        if ($stmt->execute()) {
            $content = "Editor " . $_SESSION['firstname'] . " changed his/her password";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Password Updated Successfully";
            header("Location: index.php");
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
        }
    } else {
        $msg = "Passwords do not match";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../editor.css" />
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Forgot Password</title>
</head>

<body>
    <section class="section1 flexcenter">
        <div class="container" id="signIn">
            <form method="post" class="form" id="validate_form" action="changepassword.php">
                <h1>Change Password</h1>
                <p class="error_div">
                    <?php
                    if (!empty($msg)) {
                        echo $msg;
                    }
                    ?>
                </p>
                <div class="input_group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="pwd" id="form_input" placeholder="Enter your password.." data-parsley-type="password" data-parsley-trigger="keyup" required />
                    <label for="pwd">Password</label>
                </div>
                <div class="input_group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="cfpwd" id="form_input" placeholder="Enter your password.." data-parsley-type="password" data-parsley-trigger="keyup" required />
                    <label for="cfpwd">Confirm Password</label>
                </div>
                <input type="submit" value="Update" class="btn_main" name="change_password" />
            </form>
        </div>
    </section>
    <?php require("../extras/footer.php"); ?>
    <script src="../editor.js"></script>
    <script>
        var messageType = "<?= $_SESSION['status_type'] ?? ' ' ?>";
        var messageText = "<?= $_SESSION['status'] ?? ' ' ?>";
        if (messageType == 'Error' && messageText != " ") {
            Swal.fire({
                title: 'Error!',
                text: messageText,
                icon: 'error',
                confirmButtonText: 'Ok'
            })
        } else if (messageType == 'Success' && messageText != " ") {
            Swal.fire({
                title: 'Success',
                text: messageText,
                icon: 'success',
                confirmButtonText: 'Ok'
            })
        }
        <?php unset($_SESSION['status_type']); ?>
        <?php unset($_SESSION['status']); ?>
    </script>
</body>

</html>