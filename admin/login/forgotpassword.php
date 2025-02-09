<?php
    require("../connect.php");
    include("../crudoperations.php");
    $msg = "";
    if (isset($_REQUEST['fgtpswd'])){
        $email = $_REQUEST['email'];
        createOtp($conn, $email);
    }else{
        $msg = "Sorry, couldn't find a user with specified email address.";
    }
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
	<title>Forgot Password</title>
</head>
<body>
    <section class="section1 flexcenter">
        <div class="container" id="signIn">
            <form method="post" class="form" id="validate_form" action="forgotpassword.php">
                <h1>Enter Your Email</h1>
                <p class="error_div"><?php if(!empty($msg)){ echo $msg;}?></p>
                <div class="input_group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="form_input" placeholder="Enter your email.." data-parsley-type="email" data-parsley-trigger="keyup" required/>
                    <label for="email">Email</label>
                </div>
                <input type="submit" value="Send OTP" class="btn_main" name="fgtpswd"/>
            </form>
        </div>
    </section>
    <?php require("../extras/footer.php");?>
    <script src="../index.js"></script>
</body>
</html>
