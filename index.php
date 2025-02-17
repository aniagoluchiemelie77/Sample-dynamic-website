<?php
    session_start();
    require('connect.php');
    function getDeviceType() {
        $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if (strpos($user_agent, 'mobile') !== false) {
            return 'Mobile';
        } elseif (strpos($user_agent, 'tablet') !== false) {
            return 'Tablet';
        } else {
            return 'Desktop';
        }
    }
    function getVisitorIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
    $device_type = getDeviceType();
    $ip_address = getVisitorIP();
    $visit_type = "";
    $api_url = "http://www.geoplugin.net/json.gp?ip=" . $ip_address;
    $response = file_get_contents($api_url);
    $data = json_decode($response);
    $country = $data->geoplugin_countryName;
    date_default_timezone_set('UTC');
    $date = date('Y-m-d');
    $time = date("H:iA");
    $visitor_check = "SELECT * FROM web_visitors WHERE ip_address = '$ip_address'";
    $result_check = $conn->query($visitor_check);
    if ($result_check->num_rows > 0) {
        $visit_type = 'returning';
        if ($visit_type == 'returning') {
            $sql_update = "UPDATE web_visitors SET visit_type = '$visit_type', visit_time = '$time' WHERE ip_address = '$ip_address'";
            $update_check = $conn->query($sql_update);
        }
    } else {
        $visit_type = 'new';
        $insertIP = "INSERT INTO web_visitors (ip_address, country, user_devicetype, visit_time, visit_type) VALUES ('$ip_address', '$country', '$device_type', '$time', '$visit_type')";
        $result1 = $conn->query($insertIP);
    }
    $userEmail = " ";
   // if(isset($_POST['submit_btn'])){
    //if(filter_var($userEmail, FILTER_VALIDATE_EMAIL)){
       // $sql = "INSERT INTO subscribers (email, date, time) VALUES ('$userEmail', '$date', '$time')";
       // $result = $conn->query($sql);
       // if($mail->preSend() and $result === TRUE){
            //$response['success'] = true;
           // $response['message'] = "Thank You For Subscribing With Us.";
           // $msg = "Thank You For Subscribing With Us.";
       // }else{
            //$response['success'] = false;
           // $response['message'] = "Error: " . $sql . "<br>" . $conn->error;
       // }
    //}else{
        //$response['success'] = false;
        //$response['message'] = "Error: " . $sql . "<br>" . $conn->error;
        //$msg = "Invalid Email";
    //}
    //echo json_encode($response);
    //} -->
    if (isset($_POST['accept_cookies'])) {
        setcookie('tracker', 'accepted', time() + (86400 * 30), "/"); // 30 days
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <meta name="description" content="Article website" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
        <meta name="author" content="Aniagolu chiemelie"/>
        <link rel="stylesheet" href="index.css"/>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	    <title>Home</title>
    </head>
    <body id="container" class="<?php echo (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'light-mode') ? 'light-mode' : ''; ?>">
        <?php require ('includes/header.php'); ?>
        <?php if (!isset($_COOKIE['tracker'])): ?>
            <div class="cookie_container">
                <p class="cookie_container_p">This website uses cookies and similar technologies to operate the site, analyze data, improve user experience. By using this site, you agree to our use of cookies to enhance your experience. Check our <a href="pages/privacypolicy.php">Privacy Policy</a> for more details.</p>
                <form class="cookie_container_subdiv" method="post">
                    <button class="cookie_container_subdiv-btns" type="submit" name="accept_cookies">Accept</button>
                </form>
            </div>
        <?php endif; ?>
        <div class="header__menu-sidebar hidden" id="sidebar">
            <div class="header__menu-sidebar-div1a sidebar-input">
                <a class="sidebarbtn">
                    <i class="fa fa-times popup_close1" aria-hidden="true"></i>
                </a>
            </div>
            <div class="header__menu-sidebar-div1 border-gradient-top-dark">
                <div class="sidebar__logobox">
                    <img src="images\chibs.jpg" alt="companylogo">
                </div> 
                <div class="header__menu-sidebar-div1-subdiv2">
                    <h1 class="sidebar__col-header">More</h1>
                    <a href="pages\aboutus.php" class="sidebar__links">About Us</a>
                    <a href="#" class="sidebar__links">Pitch to Us</a>
                    <a href="pages/advertisewithus.php">Advertise with Us</a>
                    <a href="pages/sharenewstips.php">Share News tip</a>
                    <a href="pages/ourterms.php">Terms of Service</a>
                    <a href="pages/workwithus.php">Work With Us</a>
                </div>
                <div class="header__menu-sidebar-div1-subdiv3">
                    <h1 class="sidebar__col-header">Sources</h1>
                    <a href="pages/pressreleases.php" class="sidebar__links">Press Releases</a>
                    <a href="pages/commentaries.php" class="sidebar__links">Commentaries</a>
                    <a href="pages/news.php" class="sidebar__links">News</a>
                    <a href="#" class="sidebar__links">White Papers</a>
                    <a href="#" class="sidebar__links">Videoscripts</a>
                    <a href="#" class="sidebar__links">Ebooks</a>
                </div>
            </div>
            <div class="header__menu-sidebar-div2 border-gradient-top-dark">
                <p class="paragraph">&copy; Aniagolu Chiemelie 2024. All rights reserved</p>
                <div class="header__menu-sidebar-div2-subdiv1">
                    <h1 class="sidebar__col-header">Follow Us</h1>
                    <div class="header__menu-sidebar-div2-subdiv1-subdiv">
                        <a class="sidebar__links" href="#">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                        <a class="sidebar__links" href="#">
                            <i class="fab fa-linkedin" aria-hidden="true"></i>
                        </a>
                        <a class="sidebar__links" href="#">
                            <i class="fab fa-facebook" aria-hidden="true"></i> 
                        </a>
                        <a class="sidebar__links" href="#">
                            <i class="fa fa-rss" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <section class="section1">
            <?php 
                $selectpaidposts = "SELECT id, title, niche, image_path, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM paid_posts ORDER BY date DESC LIMIT 4";
                $paidpostselection_result = $conn->query($selectpaidposts); 
                if ($paidpostselection_result->num_rows > 0) {
                    $counter = 0;
                    while($row = $paidpostselection_result->fetch_assoc()) {
                        $counter++;
                        $class = $counter == 1 ? "section1__div1 larger__div" : "section1__div2 smallerdivs";
                        $class2 = $counter == 1 ? "larger__div__subdiv" : "smaller__div__subdiv";
                        echo "<div class='$class'>
                                <a href='pages/view_post.php?id1=".$row['id']."'>
                                    <img src='".$row['image_path']."' alt='article image'/>
                                    <div class='$class2'>
                                        <h1>". $row['niche'] ."</h1>
                                        <h2>". $row['title'] ."</h2>
                                        <p>" . $row["formatted_date"] . "</p>
                                    </div>
                                </a>
                        </div>";
                    }
                }
            ?>
        </section>
        <section class="section2">
            <div class="section2__div1">
                <div class="search_div suggestions-container" id="suggestions"></div>
                <div id="results" class="section2__div1__div1 normal-divs" style="display:none;"></div>
                <div class="section2__div1__header headers">
                    <h1>Latest Articles</h1>
                </div>
                <?php
                    $selectposts_sql = "SELECT id, admin_id, editor_id, authors_firstname, authors_lastname, about_author, title, niche, content, image_path, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM posts ORDER BY id DESC LIMIT 30";
                    $selectposts_result = $conn->query($selectposts_sql);
                    $author_firstname = "";
                    $author_lastname = "";
                    $author_image = "";
                    $author_bio = "";
                    $id_type = '';
                    $role = "";
                    if ($selectposts_result->num_rows > 0) {
                        $i = 0;
                        if (!function_exists('calculateReadingTime')) {
                            function calculateReadingTime($content) {
                                $wordCount = str_word_count(strip_tags($content));
                                $minutes = floor($wordCount / 200);
                                return $minutes  . ' mins read ';
                            }
                        }
                        while($row = $selectposts_result->fetch_assoc()) {
                            $id = $row["id"];
                            $i++;
                            $title = $row["title"];
                            $niche = $row["niche"];
                            $image = $row["image_path"];
                            $date = $row["formatted_date"];
                            $content = $row["content"];
                            $readingTime = calculateReadingTime($row['content']);
                            if (!empty($row['admin_id'])) {
                                $admin_id = $row['admin_id'];
                                $sql_admin = "SELECT id, firstname, lastname, image, bio FROM admin_login_info WHERE id = $admin_id";
                                $result_admin = $conn->query($sql_admin);
                                if ($result_admin->num_rows > 0) {
                                    $admin = $result_admin->fetch_assoc();
                                    $author_firstname = $admin['firstname'];
                                    $author_lastname = $admin['lastname'];
                                    $author_image = $admin['image'];
                                    $id_type = "Admin";
                                    $author_bio = $admin['bio'];
                                    $role = "Editor-in-chief Uniquetechcontentwriter.com";
                                }
                            }elseif (!empty($row['editor_id'])) {
                                $editor_id = $row['editor_id'];
                                $sql_editor = "SELECT id, firstname, lastname, image, bio FROM editor WHERE id = $editor_id";
                                $result_editor = $conn->query($sql_editor);
                                if ($result_editor->num_rows > 0) {
                                    $editor = $result_editor->fetch_assoc();
                                    $author_firstname = $editor['firstname'];
                                    $author_image = $editor['image'];
                                    $author_lastname = $editor['lastname'];
                                    $author_bio = $editor['bio'];
                                    $id_type = "Editor";
                                    $role = 'Editor At Uniquetechcontentwriter.com';
                                }
                            }else {
                                $author_firstname = $row['authors_firstname'];
                                $author_lastname = $row['authors_lastname'];
                                $author_bio = $row['about_author'];
                                $role = 'Contributing Writer';
                                $id_writer = 4;
                                $id_type = "Writer";
                            }

                            echo "<div class='section2__div1__div1 normal-divs'>
                                    <a class='normal-divs__subdiv' href='pages/view_post.php? id2=".$row["id"]."'>
                                        <img src='$image' alt='article image'>
                                        <div class='normal-divs__subdiv__div'>
                                            <h1 class='normal-divs__header'>$niche</h1>
                                            <h2 class='normal-divs__title'>$title</h2>
                                            <div>
                                                <p class='normal-divs__releasedate firstp'>$date</p>
                                                <p class='normal-divs__releasedate'><i class='fa fa-clock' aria-hidden='true'></i> $readingTime</p>
                                            </div>
                                        </div>
                                    </a>
                                    <div class='normal-divs__subdiv2'>
                                        <img src='$author_image' alt='article image'>
                                        <p class='normal-divs__subdiv2__p'>By <span>$author_firstname $author_lastname, </span><span>$role</span></p>
                                    </div>
                            </div>";
                        }
                    }
                ?>
                <a class="section2__div1__link">
                Load more
                <svg width="2.5rem" height="2.5rem" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="24" height="24" fill="#FAFAFA"/>
                    <path d="M9.5 7L14.5 12L9.5 17" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                </a>
            </div>
            <div class="body_right border-gradient-leftside--lightdark">
                <?php include('helpers/emailsubscribeform.php');?>
                <?php include('helpers/newsdiv.php');?>
                <?php include('helpers/commentariesdiv.php');?>
                <?php include('helpers/searchcategories.php');?>
                <?php include('helpers/whitepapersdiv.php');?>
                <?php include('helpers/ebooksdiv.php');?>
                <?php include('helpers/videoscripts.php');?>
            </div>
        </section>
        <section class="section3">
            <?php include("helpers/pressreleasesdiv.php");?>
        </section>
        <?php include("includes/footer.php");?>
        <script src="index.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            function submitPost() {
                const subscribeBox = document.getElementById('susbribe-box');
                const formData = new FormData(subscribeBox);
                fetch('index.php', {
                    method: 'POST',
                    body: formData
                    })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }
                    })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error occurred while subscription.'
                    });
                });
            }
        </script>
        <script>
            function submitSearch() {
                var query = document.getElementById('search').value;
                if (query) {
                    fetch('forms.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'query=' + encodeURIComponent(query)
                    })
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('results').style.display = 'block';
                        document.getElementById('resultsContent').innerHTML = data;
                    })
                    .catch(error => {
                        Swal.fire('Error', 'Something went wrong!', 'error');
                    });
                } else {
                    Swal.fire('Error', 'Please enter a search term', 'error');
                }
            }
            document.getElementById('search-bar').addEventListener('input', function() {
                var query = this.value;
                if (query.length > 0) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'search.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (this.status == 200) {
                            var suggestions = JSON.parse(this.responseText);
                            var suggestionsDiv = document.getElementById('suggestions');
                            var resultsDiv = document.getElementById('results');
                            resultsDiv.style.display = 'block';
                            suggestions.forEach(function(suggestion) {
                                if (suggestion.type === 'post') {
                                    resultsDiv.innerHTML = `<h2 class="headers">You searched for: ${query}</h2>
                                                        <a class='normal-divs__subdiv' href='pages/view_post.php?${suggestion.idtype}=${suggestion.id}'>
                                                            <img src='${suggestion.image}' alt='article image'>
                                                            <div class='normal-divs__subdiv__div'>
                                                                <h1 class='normal-divs__header'>${suggestion.niche}</h1>
                                                                <h2 class='normal-divs__title'>${suggestion.title}</h2>
                                                                <div>
                                                                    <p class='normal-divs__releasedate firstp'>$date</p>
                                                                    <p class='normal-divs__releasedate'><i class='fa fa-clock' aria-hidden='true'></i> $readingTime</p>
                                                                </div>
                                                            <div>
                                                        </a>
                                                        <div class='normal-divs__subdiv2'>
                                                            <img src='$author_image' alt='article image'>
                                                            <p class='normal-divs__subdiv2__p'>By <span>$author_firstname $author_lastname, </span><span>$role</span></p>
                                                        </div>`;
                                } else if (suggestion.type === 'author') {
                                    resultsDiv.innerHTML = `<h2 class ="headers">You searched for: ${query}</h2>;
                                        <a href='authors/author.php?id=${suggestion.id}&idtype=${suggestion.idtype}' class='aboutauthor_div'>
                                            <div class='aboutauthor_div_subdiv1'>
                                                <img src='${suggestion.image}' alt ='Author's Image'/>
                                            </div>
                                            <div class='aboutauthor_div_subdiv2'>
                                                <p class='normal-divs__title'>${suggestion.firstname}, ${suggestion.lastname}</p>
                                                <p>${suggestion.bio}</p>
                                                <p>Email: ${suggestion.email}</p>
                                            </div>
                                        </a>`;
                                }
                            });
                            resultsDiv.scrollIntoView({ behavior: 'smooth' });
                        }
                    };
                    xhr.send('query=' + query);
                } else {
                    document.getElementById('suggestions').innerHTML = '';
                }
            });
            document.getElementById('suggestions').addEventListener('click', function(e) {
                if (e.target && e.target.nodeName === "DIV") {
                    document.getElementById('search-bar').value = e.target.textContent;
                    this.innerHTML = '';
                }
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
            const currentTheme = localStorage.getItem('theme');
            if (currentTheme === 'light-mode') {
                document.body.classList.add('light-mode');
            }
            });
        </script>
    </body>
</html>