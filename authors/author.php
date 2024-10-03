<?php
session_start();
require ('../connect.php');
$id = isset($_GET['id']) ? $_GET['id'] : null;
$idtype = isset($_GET['idtype']) ? $_GET['idtype'] : null;

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
                function checkAuthorPosts($id, $conn) {
                    $tables = ['paid_posts', 'posts', 'commentaries', 'news', 'press_releases'];
                    $authorPosts = [];
                    foreach ($tables as $table) {
                        $sql = "SELECT * FROM $table WHERE admin_id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            $authorPosts[$table] = $result->fetch_all(MYSQLI_ASSOC);
                        }
                    }
                    return $authorPosts;
                }
                $authorPosts = checkAuthorPosts($id, $conn);
                if (!empty($authorPosts)) {
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
                    foreach ($authorPosts as $table => $posts) {
                        $posttype = ""; 
                        if ($table = "paid_posts"){
                            $posttype = 1;        
                        }
                        else if ($table = "posts"){
                            $posttype = 2;
                        }
                        else if ($table = "commentaries"){
                            $posttype = 4;
                        }
                        else if ($table= "news"){
                            $posttype = 3;
                        }
                        else if ($table = "press_releases"){
                            $posttype = 5;
                        }
                        foreach ($posts as $post) {
                            $title = $post["title"];
                            $max_length = 60;
                            $date = $post["Date"];
                            if (strlen($title) > $max_length) {
                                $title = substr($title, 0, $max_length) . '...';
                            }
                            $dateTime = new DateTime($date);
                            $day = $dateTime->format('j');
                            $month = $dateTime->format('M');
                            $year = $dateTime->format('Y');
                            $ordinalSuffix = getOrdinalSuffix($day);
                            $formattedDate = $month . ' ' . $day . $ordinalSuffix . ', ' . $year;
                            echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id$posttype=".$post['id']."'>";
                            echo"<img src='../".$post['image_path']."' alt = 'Post's Image'/>
                            <div class='more_posts_subdiv_subdiv'>
                                <h1>$title</h1>
                                <span>$formattedDate</span>
                            </div>
                            <p class='posts_div_niche'>". $post['niche']."</p>
                        </a>";
                        }  
                    }
                } else {
                    echo "No posts found for author $firstname $lastname.";
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
                        </section>";
                }
                function checkAuthorPosts($id, $conn) {
                    $tables = ['paid_posts', 'posts', 'commentaries', 'news', 'press_releases'];
                    $authorPosts = [];
                    foreach ($tables as $table) {
                        $sql = "SELECT * FROM $table WHERE admin_id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                
                        if ($result->num_rows > 0) {
                            $authorPosts[$table] = $result->fetch_all(MYSQLI_ASSOC);
                        }
                    }
                    return $authorPosts;
                }
                $authorPosts = checkAuthorPosts($id, $conn);
                if (!empty($authorPosts)) {
                    foreach ($authorPosts as $table => $posts) {
                        $posttype = "";
                        if ($table = "posts"){
                            $posttype = "post";
                            echo "<div class='body_container'>
                                    <div class='body_left'>    
                                        <h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>Latest from <span> $author_firstname  $author_lastname, </span><span> $role</span></h1>
                                        <div class='more_posts'>
                            ";
                            foreach ($posts as $post) {
                                echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id2=$id'>
                                    <img src='../". $post['image_path']."' alt = 'Post's Image'/>
                                    <div class='more_posts_subdiv_subdiv'>
                                        <h1>". $post['title']."</h1>
                                        <span>". $post['Date']."</span>
                                    </div>
                                    <p class='posts_div_niche'>". $post['niche']."</p>
                                </a>
                                </div></div></div>";
                            }
                        }
                        if ($table = "commentaries"){
                            $posttype = "commentary";
                            echo "<div class='body_container'>
                                    <div class='body_left'>    
                                        <h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>Latest from <span> $author_firstname  $author_lastname, </span><span> $role</span></h1>
                                        <div class='more_posts'>
                            ";
                            foreach ($posts as $post) {
                                echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id4=$id'>
                                    <img src='../". $post['image_path']."' alt = 'Post's Image'/>
                                    <div class='more_posts_subdiv_subdiv'>
                                        <h1>". $post['title']."</h1>
                                        <span>". $post['Date']."</span>
                                    </div>
                                    <p class='posts_div_niche'>". $post['niche']."</p>
                                </a>
                                </div></div></div>";
                            }
                        }
                        if ($table = "news"){
                            $posttype = "news";
                            echo "
                            <div class='body_container'>
                                    <div class='body_left'>    
                                        <h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>Latest from <span> $author_firstname  $author_lastname, </span><span> $role</span></h1>
                                        <div class='more_posts'>
                            ";
                            foreach ($posts as $post) {
                                echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id3=$id'>
                                    <img src='../". $post['image_path']."' alt = 'Post's Image'/>
                                    <div class='more_posts_subdiv_subdiv'>
                                        <h1>". $post['title']."</h1>
                                        <span>". $post['Date']."</span>
                                    </div>
                                    <p class='posts_div_niche'>". $post['niche']."</p>
                                </a>
                                </div></div></div>";
                            }
                        }
                        if ($table = "press_releases"){
                            $posttype = "press release";
                            echo "<div class='body_container'>
                                    <div class='body_left'>    
                                        <h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>Latest from <span> $author_firstname  $author_lastname, </span><span> $role</span></h1>
                                        <div class='more_posts'>
                            ";
                            foreach ($posts as $post) {
                                echo "<a class='more_posts_subdiv' href='../pages/view_post.php?id5=$id'>
                                    <img src='../". $post['image_path']."' alt = 'Post's Image'/>
                                    <div class='more_posts_subdiv_subdiv'>
                                        <h1>". $post['title']."</h1>
                                        <span>". $post['Date']."</span>
                                    </div>
                                    <p class='posts_div_niche'>". $post['niche']."</p>
                                </a>
                                </div></div></div>";
                            }
                        }
                    }
                } else {
                    echo "No posts found for author $firstname $lastname.";
                }
                
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
                    }else{
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