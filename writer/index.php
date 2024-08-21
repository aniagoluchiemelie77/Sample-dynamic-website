<?php
?>;
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="Tech News and Articles website" />
    <meta name="keywords" content="Tech News, Content Writers, Content Strategy" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu Diamaka"/>
    <link rel="stylesheet" href="writer.css"/>
	<title>Writer Login</title>
</head>
<body>
    <section class="section1">
        <div class="container" id="signIn">
            <h1 class="form__title">Sign In</h1>
            <form action="forms.php" method="post" class="form">
                <div class="input_group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="Email" id="form_input" placeholder="Email" required/>
                    <label for="Email">Email</label>
                </div>
                <div class="input_group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="Password" id="form_input" placeholder="Password" required/>
                    <label for="Password">Password</label>
                </div>
                <p class="recover"><a href="#">Recover password?</a></p>
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
