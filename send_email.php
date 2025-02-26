<?php 
    require 'vendor/autoload.php';
    use Mailgun\Mailgun;
	echo getenv('API_KEY');
    $mg = Mailgun::create(getenv('1654a412-c74c01db') ?: '1654a412-c74c01db');
    $result = $mg->messages()->send(
	    'sandbox0946a9b2a201481181d7d3cf49da8cac.mailgun.org',
	    [
		    'from' => 'Mailgun Sandbox <postmaster@sandbox0946a9b2a201481181d7d3cf49da8cac.mailgun.org>',
		    'to' => 'Aniagolu chiemelie <aniagoluchiemelie77@gmail.com>',
		    'subject' => 'Hello Aniagolu chiemelie',
		    'text' => 'Congratulations Aniagolu chiemelie, you just sent an email with Mailgun! You are truly awesome!'
	    ]
    );
    print_r($result->getMessage());
?>