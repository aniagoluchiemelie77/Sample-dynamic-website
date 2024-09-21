<form class="sec2__susbribe-box other_width" method="POST" action="index.php" id="susbribe-box">
    <div class="icon">
        <i class="fa fa-envelope" aria-hidden="true"></i>
    </div>
    <h1 class="sec2__susbribe-box-header">Subscribe to Updates</h1>
    <p class="sec2__susbribe-box-p1">Get the latest Updates and Info from Uniquetechcontentwriter on Cybersecurity, Artificial Intelligence and lots more.</p>
    <p class="error_div" id="error_message"><?php if(!empty($msg)){ echo $msg;}?></p>
    <input class="sec2__susbribe-box_input" type="text" placeholder="Your Email Address..." name="email" required/>
    <input class="sec2__susbribe-box_btn" type="submit" value="Submit" name="submit_btn" onclick="submitPost()"/>
</form>