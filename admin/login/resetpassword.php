<?php
require("../connect.php");
if (isset($_REQUEST['reset_pswd'])){
    $email = $_REQUEST['email'];
    $password = md5($_REQUEST['pwd']);
    $confirm_password = md5($_REQUEST['cpwd']);
    if ($password == $confirm_password){
        $stmt = $conn->prepare("UPDATE admin_login_info SET password = ?, token = NULL WHERE email = ?");
        $stmt->bind_param('ss', $password, $email);
        $stmt->execute();
        if($stmt->execute()){
            $msg = "Password Reset Successful! <a href='index.php'>Click Here</a> to continue login process";
        }else{
            $msg = "Error While Updating Password";
        }
    }else{
        $msg = "Passwords do not match";
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $stmt = $conn->prepare("SELECT email FROM admin_login_info WHERE token = ?");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0){
        $email = $result->fetch_assoc()['email']; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="Tech News and Articles website" />
    <meta name="keywords" content="Tech News, Content Writers, Content Strategy" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu Diamaka"/>
    <link rel="stylesheet" href="../admin.css"/>
	<title>Reset Password</title>
</head>
<body>
    <section class="section1 flexcenter">
        <div class="container" id="signIn">
            <form method="post" class="form" action="resetpassword.php">
                <h1>Reset Password</h1>
                <p class="error_div"><?php if(!empty($msg)){ echo $msg;}?></p>
                <div class="input_group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="pwd" id="form_input" placeholder="Password"  required/>
                    <label for="pwd">Password</label>
                </div>
                <div class="input_group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="cpwd" id="form_input" placeholder="Password" required/>
                    <label for="cpwd">Confirm Password</label>
                </div>
                <input type="hidden" name="email" value="<?php echo $email;?>"/>
                <input type="submit" value="Reset Password" class="btn_main" name="reset_pswd"/>
            </form>
        </div>
    </section>
    <?php require("../extras/footer.php");?>
    <script src="../index.js"></script>
</body>
</html>
<?php }}?>