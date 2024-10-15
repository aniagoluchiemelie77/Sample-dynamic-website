<?php
session_start();
require ('../connect.php');
$id = isset($_GET['id']) ? $_GET['id'] : null;
$idtype = isset($_GET['idtype']) ? $_GET['idtype'] : null;
$author_fname = isset($_GET['author_fname']) ? $_GET['author_fname'] : null;

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
	<title>Author</title>
</head>
<body>
    <?php require("../includes/header2.php");?>

    <center>
        <?php
            $author_firstname = "";
            $author_lastname = "";
            $author_image = "";
            $role = "";
            $author_bio = "";
            if($idtype == "Admin"){
                $getauthor_sql = "SELECT id, firstname, lastname, image, bio FROM admin_login_info WHERE id = $id";
                $getauthor_result = $conn->query($getauthor_sql);
                if ($getauthor_result->num_rows > 0) {
                    $author = $getauthor_result->fetch_assoc();
                    $author_firstname = $author['firstname'];
                    $author_lastname = $author['lastname'];
                    $author_bio = $author['bio'];
                    $author_image = $author['image'];
                    $role = "Editor-in-chief Uniquetechcontentwriter";
                    echo "<section class='authordiv_container'>
                            <img src='../$author_image' alt ='Author's Image'/>
                            <div class = 'authordiv_container_subdiv'>
                                <h1><span>$author_firstname $author_lastname, </span><span>$role</span></h1>
                                <p>$author_bio</p>
                            </div>
                        </section>
                        <div class='body_container'>
                            <div class='body_left'>    
                                <h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>More Posts By <span> $author_firstname  $author_lastname </span></h1>
                                <div class='more_posts'>";
                } 
                $tables = ['paid_posts', 'posts', 'commentaries', 'news', 'press_releases'];
                $results = [];
                foreach ($tables as $table) {
                    $sql = "SELECT id, title, niche, content, image_path, Date FROM $table WHERE admin_id = ? ORDER BY id DESC LIMIT 12";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $id);
                    $stmt->bind_result($id, $title, $niche, $content, $image, $date);
                    $stmt->execute();
                    while ($stmt->fetch()) {
                        $posttype = 0;
                        if ($table == 'paid_posts') {
                            $posttype = 1;
                        } 
                        elseif ($table == 'posts') {
                            $posttype = 2;
                        } 
                        elseif ($table == 'commentaries') {
                            $posttype = 4;
                        } 
                        elseif ($table == 'news') {
                            $posttype = 3;
                        }
                        elseif ($table == 'press_releases') {
                            $posttype = 5;
                        }
                        $results[] = [
                            'id' => $id,
                            'title' => $title,
                            'niche' => $niche,
                            'content' => $content,
                            'image_path' => $image,
                            'Date' => $date,
                            'table' => $table,
                            'posttype' => $posttype
                        ];
                    }
                }
                foreach ($results as $result) {
                    if (!function_exists('getOrdinalSuffix')) {
                        function getOrdinalSuffix($day) {
                            if (!in_array(($day % 100), [11, 12, 13])) {
                                switch ($day % 10) {
                                    case 1: return 'st';
                                    case 2: return 'nd';
                                    case 3: return 'rd';
                                }
                            }
                            return 'th';
                        }
                    }
                    if (!function_exists('calculateReadingTime')) {
                        function calculateReadingTime($content) {
                            $wordCount = str_word_count(strip_tags($content));
                            $minutes = floor($wordCount / 200);
                            return $minutes  . ' mins read ';
                        }
                    }
                    $max_length = 60;
                    $id = $result['id'];
                    $title = $result["title"];
                    $date = $result["Date"];
                    if (strlen($title) > $max_length) {
                        $title = substr($title, 0, $max_length) . '...';
                    }
                    $dateTime = new DateTime($date);
                    $day = $dateTime->format('j');
                    $month = $dateTime->format('M');
                    $year = $dateTime->format('Y');
                    $ordinalSuffix = getOrdinalSuffix($day);
                    $formattedDate = $month . ' ' . $day . $ordinalSuffix . ', ' . $year;
                    $readingTime = calculateReadingTime($result['content']);
                    echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id".$result['posttype']."=$id'>
                            <img src='../".$result['image_path']."' alt = 'Post's Image'/>
                            <div class='more_posts_subdiv_subdiv'>
                                <h1>$title</h1>
                                <span>$formattedDate</span>
                                <span>$readingTime</span>
                            </div>
                            <p class='posts_div_niche'>". $result['niche']."</p>
                        </a>
                    ";
                }
                
                echo"</div></div>";
            }
            if($idtype == "Editor"){
                $getauthor_sql = "SELECT id, firstname, lastname, image, bio FROM editor WHERE id = $id";
                $getauthor_result = $conn->query($getauthor_sql);
                if ($getauthor_result->num_rows > 0) {
                    $author = $getauthor_result->fetch_assoc();
                    $author_firstname = $author['firstname'];
                    $author_lastname = $author['lastname'];
                    $author_bio = $author['bio'];
                    $author_image = $author['image'];
                    $role = "Editor at Uniquetechcontentwriter";
                    echo "<section class='authordiv_container'>
                            <img src='../$author_image' alt ='Author's Image'/>
                            <div class = 'authordiv_container_subdiv'>
                                <h1><span>$author_firstname $author_lastname, </span><span>$role</span></h1>
                                <p>$author_bio</p>
                            </div>
                            </section>
                           <div class='body_container'>
                                <div class='body_left'>    
                                    <h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>More Posts By <span> $author_firstname  $author_lastname </span></h1>
                                    <div class='more_posts'>";
                } 
                $tables = ['paid_posts', 'posts', 'commentaries', 'news', 'press_releases'];
                $results = [];
                foreach ($tables as $table) {
                    $sql = "SELECT id, title, niche, content, image_path, Date FROM $table WHERE admin_id = ? ORDER BY id DESC LIMIT 12";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $id);
                    $stmt->bind_result($id, $title, $niche, $content, $image, $date);
                    $stmt->execute();
                    while ($stmt->fetch()) {
                        $posttype = 0;
                        if ($table == 'paid_posts') {
                            $posttype = 1;
                        } 
                        elseif ($table == 'posts') {
                            $posttype = 2;
                        } 
                        elseif ($table == 'commentaries') {
                            $posttype = 4;
                        } 
                        elseif ($table == 'news') {
                            $posttype = 3;
                        }
                        elseif ($table == 'press_releases') {
                            $posttype = 5;
                        }
                        $results[] = [
                            'id' => $id,
                            'title' => $title,
                            'niche' => $niche,
                            'content' => $content,
                            'image_path' => $image,
                            'Date' => $date,
                            'table' => $table,
                            'posttype' => $posttype
                        ];
                    }
                }
                foreach ($results as $result) {
                    if (!function_exists('getOrdinalSuffix')) {
                        function getOrdinalSuffix($day) {
                            if (!in_array(($day % 100), [11, 12, 13])) {
                                switch ($day % 10) {
                                    case 1: return 'st';
                                    case 2: return 'nd';
                                    case 3: return 'rd';
                                }
                            }
                            return 'th';
                        }
                    }
                    if (!function_exists('calculateReadingTime')) {
                        function calculateReadingTime($content) {
                            $wordCount = str_word_count(strip_tags($content));
                            $minutes = floor($wordCount / 200);
                            return $minutes  . ' mins read ';
                        }
                    }
                    $max_length = 60;
                    $id = $result['id'];
                    $title = $result["title"];
                    $date = $result["Date"];
                    if (strlen($title) > $max_length) {
                        $title = substr($title, 0, $max_length) . '...';
                    }
                    $dateTime = new DateTime($date);
                    $day = $dateTime->format('j');
                    $month = $dateTime->format('M');
                    $year = $dateTime->format('Y');
                    $ordinalSuffix = getOrdinalSuffix($day);
                    $formattedDate = $month . ' ' . $day . $ordinalSuffix . ', ' . $year;
                    $readingTime = calculateReadingTime($result['content']);
                    echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id".$result['posttype']."=$id'>
                            <img src='../".$result['image_path']."' alt = 'Post's Image'/>
                            <div class='more_posts_subdiv_subdiv'>
                                <h1>$title</h1>
                                <span>$formattedDate</span>
                                <span>$readingTime</span>
                            </div>
                            <p class='posts_div_niche'>". $result['niche']."</p>
                        </a>
                    ";
                }
                
                echo"</div></div>";
            }
            if($idtype == "Writer"){
                $getauthor_sql = "SELECT id, firstname, lastname, image, bio FROM writer WHERE firstname = $author_fname";
                $getauthor_result = $conn->query($getauthor_sql);
                if ($getauthor_result->num_rows > 0) {
                    $author = $getauthor_result->fetch_assoc();
                    $author_firstname = $author['firstname'];
                    $author_lastname = $author['lastname'];
                    $author_bio = $author['bio'];
                    $author_image = $author['image'];
                    $role = "Contributing Writer";
                    echo "<section class='authordiv_container'>
                            <img src='../$author_image' alt ='Author's Image'/>
                            <div class = 'authordiv_container_subdiv'>
                                <h1><span>$author_firstname $author_lastname, </span><span>$role</span></h1>
                                <p>$author_bio</p>
                            </div>
                        </section>
                        <div class='body_container'>
                            <div class='body_left'>    
                                <h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>More Posts By <span> $author_firstname  $author_lastname </span></h1>
                                <div class='more_posts'>";
                } 
                $tables = ['paid_posts', 'posts', 'commentaries', 'news', 'press_releases'];
                $results = [];
                foreach ($tables as $table) {
                    $sql = "SELECT id, title, niche, content, image_path, Date FROM $table WHERE admin_id = ? ORDER BY id DESC LIMIT 12";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $id);
                    $stmt->bind_result($id, $title, $niche, $content, $image, $date);
                    $stmt->execute();
                    while ($stmt->fetch()) {
                        $posttype = 0;
                        if ($table == 'paid_posts') {
                            $posttype = 1;
                        } 
                        elseif ($table == 'posts') {
                            $posttype = 2;
                        } 
                        elseif ($table == 'commentaries') {
                            $posttype = 4;
                        } 
                        elseif ($table == 'news') {
                            $posttype = 3;
                        }
                        elseif ($table == 'press_releases') {
                            $posttype = 5;
                        }
                        $results[] = [
                            'id' => $id,
                            'title' => $title,
                            'niche' => $niche,
                            'content' => $content,
                            'image_path' => $image,
                            'Date' => $date,
                            'table' => $table,
                            'posttype' => $posttype
                        ];
                    }
                }
                foreach ($results as $result) {
                    if (!function_exists('getOrdinalSuffix')) {
                        function getOrdinalSuffix($day) {
                            if (!in_array(($day % 100), [11, 12, 13])) {
                                switch ($day % 10) {
                                    case 1: return 'st';
                                    case 2: return 'nd';
                                    case 3: return 'rd';
                                }
                            }
                            return 'th';
                        }
                    }
                    if (!function_exists('calculateReadingTime')) {
                        function calculateReadingTime($content) {
                            $wordCount = str_word_count(strip_tags($content));
                            $minutes = floor($wordCount / 200);
                            return $minutes  . ' mins read ';
                        }
                    }
                    $max_length = 60;
                    $id = $result['id'];
                    $title = $result["title"];
                    $date = $result["Date"];
                    if (strlen($title) > $max_length) {
                        $title = substr($title, 0, $max_length) . '...';
                    }
                    $dateTime = new DateTime($date);
                    $day = $dateTime->format('j');
                    $month = $dateTime->format('M');
                    $year = $dateTime->format('Y');
                    $ordinalSuffix = getOrdinalSuffix($day);
                    $formattedDate = $month . ' ' . $day . $ordinalSuffix . ', ' . $year;
                    $readingTime = calculateReadingTime($result['content']);
                    echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id".$result['posttype']."=$id'>
                            <img src='../".$result['image_path']."' alt = 'Post's Image'/>
                            <div class='more_posts_subdiv_subdiv'>
                                <h1>$title</h1>
                                <span>$formattedDate</span>
                                <span>$readingTime</span>
                            </div>
                            <p class='posts_div_niche'>". $result['niche']."</p>
                        </a>
                    ";
                }
                
                echo"</div></div>";
            }
        ?>
        <div class="body_right border-gradient-leftside--lightdark">
            <h3 class="bodyleft_header3 border-gradient-bottom--lightdark">Editor's Picks</h3>
            <a class="posts_div" href="#">
                <img src="../images/chibs.jpg" alt="Post's Image"/>
                <p class="posts_div_niche">Cybersecurity</p>
                <h1>Unfixed Microsoft Entra ID Authentification Bypass Threatens Hybrid IDs.</h1>
                <p class="posts_div_otherp">By, <span>Chiemelie Aniagolu, Contributing Writer.</span></p>
                <div class="posts_div_subdiv">
                    <p>Aug 15th, 2024</p>
                    <p>10mins Read.</p>
                </div>
            </a>
            <a class="posts_div" href="#">
                <img src="../images/chibs.jpg" alt="Post's Image"/>
                <p class="posts_div_niche">Cybersecurity</p>
                <h1>Unfixed Microsoft Entra ID Authentification Bypass Threatens Hybrid IDs.</h1>
                <p class="posts_div_otherp">By, <span>Chiemelie Aniagolu, Contributing Writer.</span></p>
                <div class="posts_div_subdiv">
                    <p>Aug 15th, 2024</p>
                    <p>10mins Read.</p>
                </div>
            </a>
            <a class="posts_div" href="#">
                <img src="../images/chibs.jpg" alt="Post's Image"/>
                <p class="posts_div_niche">Cybersecurity</p>
                <h1>Unfixed Microsoft Entra ID Authentification Bypass Threatens Hybrid IDs.</h1>
                <p class="posts_div_otherp">By, <span>Chiemelie Aniagolu, Contributing Writer.</span></p>
                <div class="posts_div_subdiv">
                    <p>Aug 15th, 2024</p>
                    <p>10mins Read.</p>
                </div>
            </a>
            <?php
                $userEmail = " ";
                if(isset($_POST['submit_btn'])){
                    $userEmail = $_POST['email'];
                    if(filter_var($userEmail, FILTER_VALIDATE_EMAIL)){
                        $subject = "Thank You For Subscribing With Us";
                        $message = "Thank you for subscribing to our email updates, We will keep you updated with the latest updates and information";
                        $sender = "from:bahdmannatural@gmail.com";
                        if(mail($userEmail, $subject, $message, $sender)){ 
                            $msg = "Thanks For Subscribing With Us";
            ?><?php
                            $userEmail = " ";
                        }
                        else{
                            $msg = "Oops, Email Subscription Failed";
            ?><?php
                        }
                    }else{
                        $msg = "Invalid Email";
                    }
                }
            ?>
            <form class="sec2__susbribe-box other_width" method="post" action="author.php">
                <div class="icon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                <h1 class="sec2__susbribe-box-header">Subscribe to Updates</h1>
                <p class="sec2__susbribe-box-p1">Get the latest Updates and Info from Uniquetechcontentwriter on Cybersecurity, Artificial Intelligence and lots more.</p>
                <p class="error_div"><?php if(!empty($msg)){ echo $msg;}?></p>
                <input class="sec2__susbribe-box_input" type="text" placeholder="Your Email Address..." name="email" required/>
                <input class="sec2__susbribe-box_btn" type="submit" value="Submit" name="submit_btn"/>
            </form>
        </div>
        </div>
    </center>
    <?php require("../includes/footer.php");?>
    <script src="index.js"></script>
</body>
</html>