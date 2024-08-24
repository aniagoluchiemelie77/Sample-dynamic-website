<?php
session_start();
//$id = $_GET["ID"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="Article website" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu chiemelie"/>
    <link rel="stylesheet" href="../index.css"/>
	<title>View post</title>
</head>
<body>
    <header class="header">
        <center>
            <div class="mainheader">
            <div class="mainheader__header-nav">
                <a class="mainheader__header-nav-1" href="../">
                    <i class="fa fa-home" aria-hidden="true"></i>
                </a>
                <a class="mainheader__header-nav-2" id="searchicon">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </a>
            </div>
            <div class="mainheader__logobox">
                <img src="#" alt="companylogo">
            </div>
            <a class="mainheader__signupbtn">Newsletter Signup</a>
            </div>
        </center>
        <center>
            <form class="header_searchbar hidden" action="forms.php" method="get" id="search_form">
                <input type="text" name="search" placeholder="Search.." />
                <button class="fa fa-search" id="tutorial_name" aria-hidden="true" name="search_btn" type="submit" formenctype="text/plain"></button>
            </form>
        </center>
        <center>
    </header>
    <div class="ads_bar"></div>
    <div class="body_container">
        <div class="body_left">
            <div class="body_left_relatedniches">
                <a>Artificial Intelligence</a>
                <a>Cloud Computing</a>
                <a>Data Analytics</a>
                <a>Cybersecurity</a>
            </div>
            <h1>Patch Now: Second SolarWinds Critical Bug in Web Help Desk</h1>
            <h2>The disclosure of CVE-2024-28987 means that, in two weeks, there have been two critical bugs and corresponding patches for SolarWinds' less-often-discussed IT help desk software.</h2>
            <div class="authors_div">
                <div>
                    <img src="#" alt="Author's Image"/>
                    <p><span>Aniagolu Chiemelie,</span> Contributing Writer. <span>August 23, 2024.</span></p>
                </div>
                <div>
                    <i class="fa fa-clock" aria-hidden="true"></i>
                    <p>2 mins read.</p>
                </div>
            </div>
            <img src="../images/image1.jpeg" alt="Post Image"/>
            <span>Source: Getty Images</span>
            <div class="socialmedia_links">
                <button class="fab fa-facebook" aria-hidden="true"></button>
                <button class="fab fa-linkedin" aria-hidden="true"></button>
                <button class="fab fa-reddit-alien" aria-hidden="true"></button>
                <button class="fa fa-print" aria-hidden="true"></button>
                <button class="fa fa-envelope" aria-hidden="true"></button>
            </div>
            <p>For the second week in a row, SolarWinds has released a patch for a critical vulnerability in its IT help and ticketing software, Web Help Desk (WHD).

According to its latest hotfix notice, the issue — tracked as CVE-2024-28987 — concerns hardcoded credentials that could allow a remote, unauthenticated attacker to break into WHD and modify data.

"Security is hard and a continuous process," says Horizon3.ai vulnerability researcher Zach Hanley, who first discovered and reported the bug. "This application had just received a security look from being exploited in the wild, and a few years [before] had a different hardcoded credential vulnerability. Regular security reviews on the same application can still be valuable for companies."

Two Critical Bugs & Two Urgent Fixes
On Aug. 13, SolarWinds released a hotfix for CVE-2024-28986, a Java deserialization issue that could have allowed an attacker to run commands on a targeted machine. It was given a "critical" 9.8 out of 10 score on the CVSS scale.

Following what the company described as "thorough testing," it was unable to prove that the issue could be exploited by an unauthenticated attacker. But just two days after news of it broke, CISA added CVE-2024-28986 to its catalog of known exploited vulnerabilities, indicating that active exploitation by threat actors was already underway.

This week, the company followed up this initial bad news with more of the same, this time concerning a second vulnerability in the same program. In this case, there was no ambiguity that an unauthenticated attacker could leverage hardcoded credentials in WHD to access internal functionalities and data, which goes some way to justifying its "critical" 9.1 CVSS score.

Contrary to other reporting, CVE-2024-28987 was not first introduced in the patch for CVE-2024-28986. "This issue has existed for some time in the product, likely for several years," Hanley reports. SolarWinds declined to provide Dark Reading with further comment.

SolarWinds' newest patch incorporates fixes for both issues. Customers are advised to update immediately.

                To hammer the point home, Hanley says, "Imagine if an attacker had access to all the details in help desk tickets — what sensitive information may they be able to extract? Credentials, business operations details, etc."

            </p>
            <div class="socialmedia_links">
                <button class="fab fa-facebook" aria-hidden="true"></button>
                <button class="fab fa-linkedin" aria-hidden="true"></button>
                <button class="fab fa-reddit-alien" aria-hidden="true"></button>
                <button class="fa fa-print" aria-hidden="true"></button>
                <button class="fa fa-envelope" aria-hidden="true"></button>
            </div>
            <h3>About the Author</h3>
            <a>
               <img src="#" alt ="Author;s Image"/>
               <div>
                <p><span>Aniagolu Chiemelie, </span>Contributing Writer</p>
                <p>Nate Nelson is a freelance writer based in New York City. Formerly a reporter at Threatpost, he contributes to a number of cybersecurity blogs and podcasts. He writes "Malicious Life" -- an</p>
               </div>
            </a>
            <div>
                <p>Keep up with the latest cybersecurity threats, newly discovered vulnerabilities, data breach information, and emerging trends. Delivered daily or weekly right to your email inbox.
                </p>
                <a>Subscribe</a>
            </div>
            <h1>You may also like</h1>
            <div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="body_right">
            <div class="ads_sidebar"></div>
        </div>
    </div>
    <section class="footer">
        <div class="footer__div1">
            <div class="footer__div1__logobox"></div>
            <form class="footer__subscribebox">
                <div class="sec2__susbribe-box-darker">
                    <input class="sec2__susbribe-box-input-light" type="email" placeholder="Your email address..."/>
                    <button class="sec2__susbribe-box-btn-light" type="submit">Subscribe</button>
                </div>
            </form>
        </div>
        <div class="footer__newpagelinks">
            <a class="footer__link lightp" href="OtherHtmlPages\Workwithus.html">Work with Us</a>
            <a class="footer__link lightp" href="OtherHtmlPages\aboutus.html">About Us</a>
            <a class="footer__link lightp" href="OtherHtmlPages\Advertise.html">Advertise</a>
            <a class="footer__link lightp" href="OtherHtmlPages\Sharenewstip.html">Share News tip</a>
            <a class="footer__link lightp" href="OtherHtmlPages\Contacts.html">Contact Us</a>
            <a class="footer__link lightp" href="OtherHtmlPages\Privacypolicy.html">Privacy Policy</a>
            <a class="footer__link lightp" href="OtherHtmlPages\Termsofservice.html">Terms of Services</a>
        </div>
        <div class="footer__div3">
            <p class="footer__div3-p lightp"> 	&copy; Chiboy Aniagolu 2024. All rights reserved.</p>
            <div class="footer__div3__subdiv">
                <h1 class="footer__header lightp">Follow Us</h1>
                <div class="footer__div3__smedialinks">
                    <a class="footer__smedia-links" href="#">
                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" height="2.3rem" width="2.3rem" fill="#FAFAFA"
                            width="204.000000pt" height="192.000000pt" viewBox="0 0 204.000000 192.000000"
                            preserveAspectRatio="xMidYMid meet">
                            <g transform="translate(0.000000,192.000000) scale(0.100000,-0.100000)"
                                fill="#FAFAFA" stroke="none">
                                <path d="M280 1733 c0 -5 128 -179 285 -388 157 -209 284 -383 282 -387 -1 -4
                                    -105 -118 -232 -254 -126 -136 -256 -276 -288 -311 l-59 -63 65 0 65 0 234
                                    251 c128 139 243 263 255 278 l21 26 24 -29 c12 -17 30 -40 38 -53 8 -12 92
                                    -124 185 -247 l170 -226 224 0 c177 0 221 3 214 13 -27 33 -467 622 -531 709
                                    l-73 99 58 63 c75 80 420 452 455 491 l28 30 -62 3 c-59 3 -64 2 -93 -30 -65
                                    -72 -283 -306 -337 -363 -31 -33 -68 -73 -82 -90 -14 -16 -27 -27 -29 -25 -2
                                    3 -88 119 -192 258 l-189 252 -218 0 c-120 0 -218 -3 -218 -7z m675 -468 c154
                                    -206 296 -397 315 -424 19 -27 95 -128 168 -224 72 -97 132 -181 132 -187 0
                                    -7 -32 -10 -97 -8 l-98 3 -447 595 c-246 327 -450 601 -452 608 -4 9 19 12 97
                                    12 l102 -1 280 -374z"/>
                            </g>
                        </svg>
                    </a>
                    <a class="footer__smedia-links border-gradient-side" href="#">
                        <svg fill="#FAFAFA" height="2.3rem" width="2.3rem" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
	                        viewBox="-337 273 123.5 256" xml:space="preserve">
                            <path d="M-260.9,327.8c0-10.3,9.2-14,19.5-14c10.3,0,21.3,3.2,21.3,3.2l6.6-39.2c0,0-14-4.8-47.4-4.8c-20.5,0-32.4,7.8-41.1,19.3
	                            c-8.2,10.9-8.5,28.4-8.5,39.7v25.7H-337V396h26.5v133h49.6V396h39.3l2.9-38.3h-42.2V327.8z"/>
                        </svg>
                    </a>
                    <a class="footer__smedia-links border-gradient-side" href="#">
                        <svg fill="#FAFAFA" version="1.1"  height="2.3rem" width="2.3rem" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                            viewBox="-271 283.9 256 235.1" xml:space="preserve">
                            <g>
                                <rect x="-264.4" y="359.3" width="49.9" height="159.7"/>
                                <path d="M-240.5,283.9c-18.4,0-30.5,11.9-30.5,27.7c0,15.5,11.7,27.7,29.8,27.7h0.4c18.8,0,30.5-12.3,30.4-27.7
                                    C-210.8,295.8-222.1,283.9-240.5,283.9z"/>
                                <path d="M-78.2,357.8c-28.6,0-46.5,15.6-49.8,26.6v-25.1h-56.1c0.7,13.3,0,159.7,0,159.7h56.1v-86.3c0-4.9-0.2-9.7,1.2-13.1
                                    c3.8-9.6,12.1-19.6,27-19.6c19.5,0,28.3,14.8,28.3,36.4V519h56.6v-88.8C-14.9,380.8-42.7,357.8-78.2,357.8z"/>
                            </g>
                        </svg> 
                    </a>
                    <a class="footer__smedia-links border-gradient-side" href="#">
                        <svg fill="#FAFAFA" height="2.3rem" width="2.3rem" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
	                        viewBox="-271 273 256 256" xml:space="preserve">
                            <g>
	                            <path d="M-271,360v48.9c31.9,0,62.1,12.6,84.7,35.2c22.6,22.6,35.1,52.8,35.1,84.8v0.1h49.1c0-46.6-19-88.7-49.6-119.4
		                            C-182.2,379-224.4,360.1-271,360z"/>
	                            <path d="M-237,460.9c-9.4,0-17.8,3.8-24,10s-10,14.6-10,24c0,9.3,3.8,17.7,10,23.9c6.2,6.1,14.6,9.9,24,9.9s17.8-3.7,24-9.9
		                            s10-14.6,10-23.9c0-9.4-3.8-17.8-10-24C-219.2,464.7-227.6,460.9-237,460.9z"/>
	                            <path d="M-90.1,348.1c-46.3-46.4-110.2-75.1-180.8-75.1v48.9C-156.8,322-64.1,414.9-64,529h49C-15,458.4-43.7,394.5-90.1,348.1z"/>
                            </g>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <script src="../index.js"></script>
</body>
</html>