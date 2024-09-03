<?php
require ("connect.php");
if (isset($_REQUEST['Sign_In'])) {
    $email = $_REQUEST['Email'];
    $password = $_REQUEST['Password'];
    if(isset($_REQUEST['remember'])){
        setcookie("emailid", $_REQUEST['Email'], time() + 60 * 60);
        setcookie("passwordid", $_REQUEST['Password'], time() + 60 * 60);
    }
    $select_query = mysqli_query($conn, "SELECT * FROM editor WHERE email='$email' OR password = '$password'");
    $result = mysqli_num_rows($select_query);
    if($result>0){
        session_start();
        $data = mysqli_fetch_array($select_query);
        $email = $data['email'];
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $username = $data['username'];
        $image = $data['image'];
        $bio = $data['bio'];
        $mobile = $data['mobile'];
        $country = $data['country'];
        $city = $data['city'];
        $state = $data['state'];
        $address = $data['address1'];
        $country_code = $data['country_code'];
        //declaring session variables
        $_SESSION['email'] = $email;
        $_SESSION['firstname'] = $firstname;
        $_SESSION['lastname'] = $lastname;
        $_SESSION['username'] = $username;
        $_SESSION['image'] = $image;
        $_SESSION['bio'] = $bio;
        $_SESSION['mobile'] = $mobile;
        $_SESSION['country'] = $country;
        $_SESSION['city'] = $city;
        $_SESSION['state'] = $state;
        $_SESSION['address'] = $address;
        $_SESSION['country_code'] = $country_code;
        header("location: editor_homepage.php");
        exit();
    }else{
        $msg = "Invalid Email or Password";
    }
}

if(isset($_COOKIE['emailid']) && isset($_COOKIE['passwordid'])){
    $emailid = $_COOKIE['emailid'];
    $passwordid = $_COOKIE['passwordid'];
}else{
    $emailid = $passwordid = " ";
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
    <link rel="stylesheet" href="editor.css"/>
	<title>Editor Login</title>
</head>
<body>
    <section class="section1">
        <div class="container" id="signIn">
            <h1 class="form__title">Sign In</h1>
            <form method="post" class="form">
                <div class="error_div">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <p><?php if(!empty($msg)){ echo $msg;}?></p>
                </div>
                <div class="input_group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="Email" id="form_input" placeholder="Email" value="<?php echo $emailid;?>" required/>
                    <label for="Email">Email</label>
                </div>
                <div class="input_group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="Password" id="form_input" placeholder="Password" value="<?php echo $passwordid;?>" required/>
                    <label for="Password">Password</label>
                </div>
                <div class="checkbox_group">
                    <input type="checkbox" name="remember" id="remember_me" />
                    <p>Remember me</p>
                </div>
                <p class="recover"><a href="#">Forgot password?</a></p>
                <input type="submit" value="Sign In" class="btn_main" name="Sign_In"/>
            </form>
        </div>
    </section>
    <footer class="footer">
        <div class="footer__div3">
            <p class="footer__div3-p lightp"> 	&copy; uniquetechcontentwriter 2024.</p>
            <div class="footer__div3__subdiv">
                <h1 class="footer__header lightp">Follow Us</h1>
                <div class="footer__div3__smedialinks">
                    <a class="footer__smedia-links" href="#">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="footer__smedia-links border-gradient-side" href="#">
                       
                    </a>
                    <a class="footer__smedia-links border-gradient-side" href="#">
                    </a>
                    <a class="footer__smedia-links border-gradient-side" href="#">
                    </a>
                </div>
            </div>
            <p class="footer__div3-p lightp">Powered By: <span>Leventis Tech Services.</span></p>
        </div>
    </footer>
    <script src="index.js"></script>
</body>
</html>
