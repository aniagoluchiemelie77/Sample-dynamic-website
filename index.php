<?php
session_start();
require('connect.php');
require('init.php');
$details = getFaviconAndLogo();
$page_name = "home";
$logo = $details['logo'];
$favicon = $details['favicon'];
$website_messages = cookieMessageAndVision();
$cookie_message = $website_messages['cookie_message'];
$website_vision = $website_messages['website_vision'];
$device_type = getDeviceType();
$ip_address = getVisitorIP();
$visit_type = "";
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
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
if (isset($_POST['accept_cookies'])) {
    setcookie('tracker', 'accepted', time() + (86400 * 30), "/"); // 30 days
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
if (isset($_POST['submit_btn'])) {
    $email = $_POST["email"];
    $sendEmail = sendEmail($email);
    $_SESSION['status_type'] = $sendEmail['status_type'];
    $_SESSION['status'] = $sendEmail['status'];
}
if (isset($_POST['subscribe_btn2'])) {
    $email = $_POST["email"];
    $sendEmail = sendEmail($email);
    $_SESSION['status_type'] = $sendEmail['status_type'];
    $_SESSION['status'] = $sendEmail['status'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php
    if (isset($meta_titles[$page_name])) {
        $meta_data = $meta_titles[$page_name];
        for ($i = 1; $i <= 5; $i++) {
            $meta_name = $meta_data["meta_name$i"];
            $meta_content = $meta_data["meta_content$i"];
            if (!empty($meta_name) && !empty($meta_content)) {
                echo "<meta name='$meta_name' content='$meta_content' />";
            }
        }
    }
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css" />
    <link rel="icon" href="<?php echo $favicon; ?>" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="index.js" async></script>
    <title>Home</title>
</head>

<body id="container">
    <?php require('includes/header.php'); ?>
    <?php if (!isset($_COOKIE['tracker'])): ?>
        <div class="cookie_container">
            <p class="cookie_container_p"><?php echo $cookie_message; ?></p>
            <form class="cookie_container_subdiv" method="post">
                <button class="cookie_container_subdiv-btns" type="submit" name="accept_cookies">Accept</button>
            </form>
        </div>
    <?php endif; ?>
    <section class="section1">
        <?php
        $selectpaidposts = "SELECT id, title, niche, image_path, post_image_url, Date, schedule FROM paid_posts ORDER BY Date DESC LIMIT 4";
        $paidpostselection_result = $conn->query($selectpaidposts);
        if ($paidpostselection_result->num_rows > 0) {
            $counter = 0;
            while ($row = $paidpostselection_result->fetch_assoc()) {
                $counter++;
                $max_length = 50;
                $image = $row["image_path"];
                $title = $row['title'];
                $foreign_imagePath = $row["post_image_url"];
                if (strlen($title) > $max_length) {
                    $title = substr($title, 0, $max_length) . '...';
                }
                $scheduleDate = formatDateSafely($row['schedule']);
                $postDate = formatDateSafely($row['Date']);
                $now = date('Y-m-d H:i:s');
                if ($scheduleDate && $row['schedule'] <= $now) {
                    $publishDate = $scheduleDate;
                } else {
                    $publishDate = $postDate;
                }

                if ($counter == 1) {
                    echo "<div class='section1__div1 larger__div'>
                    <a href='pages/view_post.php?id1=" . $row['id'] . "'>";
                    if (!empty($image)) {
                        echo "<img src='$image' alt='article image'>";
                    } elseif (!empty($foreign_imagePath)) {
                        echo "<img src='$foreign_imagePath' alt='article image'>";
                    }
                    echo "<div class='larger__div__subdiv'>
                    <h1>" . $row['niche'] . "</h1>
                    <h2>$title</h2>
                    <p>$publishDate</p>
                  </div>
                </a>
              </div>";
                } else {
                    if ($counter == 2) {
                        echo "<div class='section1__div2 smallerdivs'>";
                    }
                    echo "<a href='pages/view_post.php?id1=" . $row['id'] . "'>";
                    if (!empty($image)) {
                        echo "<img src='$image' alt='article image'>";
                    }
                    echo "<div class='smaller__div__subdiv'>
                    <h1>" . $row['niche'] . "</h1>
                    <h2>$title</h2>
                    <p>$publishDate</p>
                  </div>
                </a>";
                }
            }
            if ($counter > 1) {
                echo "</div>";
            }
        }
        ?>

    </section>
    <section class="section2">
        <div class="section2__div1">
            <div class="search_div suggestions-container" id="suggestions"></div>
            <div id="results" style="display:none;"></div>
            <div class="section2__div1__header headers">
                <h1>Latest Articles</h1>
            </div>
            <?php
            $selectposts_sql = "SELECT id, admin_id, editor_id, authors_firstname, post_image_url, authors_lastname, about_author, title, niche, content, image_path, Date, schedule FROM posts ORDER BY id DESC LIMIT 30";
            $selectposts_result = $conn->query($selectposts_sql);
            $author_firstname = "";
            $author_lastname = "";
            $author_image = "";
            $author_bio = "";
            $id_type = '';
            $role = "";
            if ($selectposts_result->num_rows > 0) {
                $i = 0;
                while ($row = $selectposts_result->fetch_assoc()) {
                    $id = $row["id"];
                    $i++;
                    $title = $row["title"];
                    $niche = $row["niche"];
                    $image = $row["image_path"];
                    $foreign_imagePath = $row["post_image_url"];
                    $content = $row["content"];
                    $scheduleDate = formatDateSafely($row['schedule']);
                    $postDate = formatDateSafely($row['Date']);
                    $now = date('Y-m-d H:i:s');
                    if (!empty($schedule) && $schedule <= $now) {
                        $publishDate = formatDateSafely($schedule);
                    } else {
                        $publishDate = formatDateSafely($date);
                    }
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
                            $role = "Editor-in-chief";
                        }
                    } elseif (!empty($row['editor_id'])) {
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
                            $role = 'Editor at uniquetechcontentwriter.com';
                        }
                    } else {
                        $author_firstname = $row['authors_firstname'];
                        $author_lastname = $row['authors_lastname'];
                        $author_bio = $row['about_author'];
                        $role = 'Contributing Writer';
                        $id_writer = 4;
                        $id_type = "Writer";
                    }

                    echo "<div class='section2__div1__div1 normal-divs' id='posts-container'>
                                    <a class='normal-divs__subdiv' href='pages/view_post.php? id2=" . $row["id"] . "'>
                                    ";
                    if (!empty($image)) {
                        echo "<img src='$image' alt='article image'>";
                    } elseif (!empty($foreign_imagePath)) {
                        echo "<img src='$foreign_imagePath' alt='article image'>";
                    }
                    echo "
                                        <div class='normal-divs__subdiv__div'>
                                            <h1 class='normal-divs__header'>$niche</h1>
                                            <h2 class='normal-divs__title'>$title</h2>
                                            <div>
                                                <p class='normal-divs__releasedate firstp'>$publishDate</p>
                                                <p class='normal-divs__releasedate'><i class='fa fa-clock' aria-hidden='true'></i> $readingTime</p>
                                            </div>
                                        </div>
                                    </a>
                                    <div class='normal-divs__subdiv2'>
                                        <img src='$author_image' alt='article image'>
                                        <p class='normal-divs__subdiv2__p'>By <span>$author_firstname $author_lastname, </span><span class='phonewidth_block'>$role</span></p>
                                    </div>
                            </div>";
                }
            }
            ?>
            <!--<button class="section2__div1__link mainheader__signupbtn" id="change-variable">Load more</button>-->
        </div>
        <div class="body_right border-gradient-leftside--lightdark">
            <?php include('helpers/emailsubscribeform.php'); ?>
            <?php include('helpers/newsdiv.php'); ?>
            <?php include('helpers/commentariesdiv.php'); ?>
        </div>
    </section>
    <section class="section3">
        <?php include("helpers/pressreleasesdiv.php"); ?>
    </section>
    <?php include("includes/footer.php"); ?>
    <script>
        const sidebar = document.getElementById('sidebar');
        const menubtn = document.querySelector('.mainheader__header-nav-1');
        const searchIcon = document.getElementById('searchicon');
        const searchForm = document.getElementById("search_form");
        const closeMenuBtn = document.querySelector('.sidebarbtn');
        var messageType = "<?= $_SESSION['status_type'] ?? ' ' ?>";
        var messageText = "<?= $_SESSION['status'] ?? ' ' ?>";

        function removeHiddenClass(e) {
            e.stopPropagation();
            sidebar.classList.remove('hidden');
        };

        function onClickOutside(element) {
            document.addEventListener('click', e => {
                if (!element.contains(e.target)) {
                    element.classList.add('hidden');
                } else return;
            });
        };
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
                                                        <a href='pages/view_post.php?${suggestion.idtype}=${suggestion.id}'>
                                                            <img src='${suggestion.image_path}' alt='article image' class="results__image">
                                                            <div class='searchresults'>
                                                                <h1>${suggestion.niche}</h1>
                                                                <h2>${suggestion.title}</h1>
                                                                <span>${suggestion.subtitle}</span>
                                                            <div>
                                                        </a>`;
                            } else if (suggestion.type === 'author') {
                                resultsDiv.innerHTML = `<h2 class ="headers">You searched for: ${query}</h2>
                                        <a href='authors/author.php?id=${suggestion.id}&idtype=${suggestion.idtype}'>
                                            <div>
                                                <img src='${suggestion.image}' alt ='Author's Image'/>
                                            </div>
                                            <div>
                                                <p class='top_header'>${suggestion.firstname} ${suggestion.lastname}</p>
                                                <p class='top_header2'>${suggestion.bio}</p>
                                                <p class='top_header3'><i class="fa fa-envelope" aria-hidden="true"></i> ${suggestion.email}</p>
                                            </div>
                                        </a>`;
                            }
                        });
                        resultsDiv.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                };
                xhr.send('query=' + query);
            } else {
                document.getElementById('suggestions').innerHTML = '';
            }
        });
        onClickOutside(sidebar);
        menubtn.addEventListener('click', removeHiddenClass);
        searchIcon.addEventListener('click', (e) => {
            e.stopPropagation();
            searchForm.classList.remove('hidden');
            searchForm.style.display = 'flex';
            searchIcon.classList.add('hidden')
        });
        closeMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('hidden');
        });
    </script>
    <script src="sweetalert2.all.min.js"></script>
    <script>
        var messageType = "<?= $_SESSION['status_type'] ?? ' ' ?>";
        var messageText = "<?= $_SESSION['status'] ?? ' ' ?>";
        if (messageType == 'Error' && messageText != " ") {
            Swal.fire({
                title: 'Error!',
                text: messageText,
                icon: 'error',
                confirmButtonText: 'Ok'
            })
        } else if (messageType == 'Success' && messageText != " ") {
            Swal.fire({
                title: 'Success',
                text: messageText,
                icon: 'success',
                confirmButtonText: 'Ok'
            })
        }
        <?php unset($_SESSION['status_type']); ?>
        <?php unset($_SESSION['status']); ?>
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>