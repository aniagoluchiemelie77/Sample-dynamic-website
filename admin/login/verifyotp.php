<?php
    session_start();
    require("../connect.php");
    include("../crudoperations.php");
    if (isset($_REQUEST['resend_otp'])){
        $msg = "";
        $email = $_REQUEST['email'];
        createOtp($conn, $email);
    }else{
        $msg = "Sorry, couldn't find a user with specified email address.";
    }
    if (isset($_POST['validate_otp'])) {
        $email = "chiboyaniagolu@gmail.com";
        $otp = $_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'] . $_POST['otp5'];
        $query = "SELECT * FROM admin_login_info WHERE email='$email' AND token='$otp'";
        $result = mysqli_query($conn, $query);
        if ($result === false) {
            echo "Error: " . mysqli_error($conn);
        }elseif (mysqli_num_rows($result) > 0) {
            header("Location: resetpassword.php");
            exit();
        }
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
        <div class="container flexcenter" id="signIn">
            <form method="post" class="form otp_form" id="validate_otp" action="verifyotp.php">  
                <h1>Enter 5 Digit OTP</h1>
                <!--<p class="error_div"><?php if(!empty($msg)){ echo $msg;}?></p>-->
                <div class="input-field">
                    <input type="hidden" name ="email"/>
                    <input type="number"  class="otp-input" maxlength="1" name="otp1"/>
                    <input type="number" class="otp-input" maxlength="1" name="otp2"/>
                    <input type="number" class="otp-input" maxlength="1" name="otp3"/>
                    <input type="number" class="otp-input" maxlength="1" name="otp4"/>
                    <input type="number" class="otp-input" maxlength="1" name="otp5"/>
                </div>
                <p id="countdown" class="timer"></p>
                <button id="btn" class="verifyButton" name="validate_otp">Verify</button>     
            </form>
        </div>
    </section>
    <?php require("../extras/footer.php");?>
    <script>
        const timerElement = document.querySelector('.timer');
        const verifyButton = document.querySelector('.verifyButton');
        const inputs = document.querySelectorAll('.otp-input');

        window.onload = function() {
            startCountdown();
            setupInputs();
        };
        function startCountdown() {
            var timeLeft = 60;
            var interval = setInterval(function() {
                if (timeLeft <= 0) {
                    clearInterval(interval);
                    var anchor = document.createElement('a');
                    anchor.name = 'resend_otp';
                    anchor.innerHTML = 'Resend OTP?';
                    timerElement.innerHTML = "";
                    timerElement.appendChild(anchor);
                    disableInputs();
                } else {
                    timerElement.innerHTML = 'Time remaining: ' + timeLeft + 's';
                }
                timeLeft -= 1;
            }, 1000); // Update every second
        }
        function setupInputs() {
            inputs.forEach(function(input, index) {
                input.addEventListener('input', function() {
                    if (input.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                    checkInputs();
                });
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace') {
                        if (input.value.length === 0 && index > 0) {
                            inputs[index - 1].focus();
                            inputs[index - 1].value = '';
                        } else if (input.value.length === 1) {
                            input.value = '';
                        }
                    }
                });
            });
        }
        function checkInputs() {
            var allFilled = true;
            inputs.forEach(function(input) {
                if (input.value.length !== 1) {
                    allFilled = false;
                }
                if (input.value.length > 1) {
                    input.value = "";
                    return;
                } 
            });
            verifyButton.style.display = allFilled ? 'block' : 'none';
        }
        function disableInputs() {
            inputs.forEach(function(input) {
                input.disabled = true;
                input.value = " ";
            });
            verifyButton.disabled = true;
        }
    </script>
</body>
</html>