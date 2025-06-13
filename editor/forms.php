<?php
session_start();
$editor_id = $_SESSION['id'];
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
require("connect.php");
include('crudoperations.php');
require('../init.php');

function addResources($tableName, $convertedPath, $resource_type, $resource_niche, $resource_title, $resource_url)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $uc_page_name = ucwords($tableName);
    $filename = lowercaseNoSpace($tableName) . '.php';
    $filePath = '../pages/' . $filename;
    $fileContent = <<<PHP
        <?php
            session_start();
            require('../connect.php');
            require('../init.php');
            \$page_name = "$tableName";
            \$_SESSION['status_type'] = "";
            \$_SESSION['status'] = "";
            \$details = getFaviconAndLogo();
            \$logo = \$details['logo'];
            \$favicon = \$details['favicon'];
            function containsFilesPath(\$string)
            {
                return strpos(\$string, 'files/') !== false;
            }
            if (isset(\$_POST['submit_btn'])) {
                \$email = \$_POST["email"];
                \$sendEmail = sendEmail(\$email);
                \$_SESSION['status_type'] = \$sendEmail['status_type'];
                \$_SESSION['status'] = \$sendEmail['status'];
            }
            if (isset(\$_POST['subscribe_btn2'])) {
                \$email = \$_POST["email"];
                \$sendEmail = sendEmail(\$email);
                \$_SESSION['status_type'] = \$sendEmail['status_type'];
                \$_SESSION['status'] = \$sendEmail['status'];
            }
            if (isset(\$_GET['query'])) {
                \$query = trim(\$_GET['query']);
                if (\$query !== "") {
                    \$stmt = \$conn->prepare("SELECT * FROM $tableName WHERE title LIKE ?");
                    \$searchTerm = "%" . \$query . "%";
                    \$stmt->bind_param("s", \$searchTerm);
                    if (\$stmt->execute()) {
                        \$result = \$stmt->get_result();
                        if (\$result->num_rows > 0) {
                        while (\$row = \$result->fetch_assoc()) {
                            \$title = htmlspecialchars(\$row['title']);
                            \$max_length = 50;
                            \$niche = htmlspecialchars(\$row['niche']);
                            \$formattedDate = date("F j, Y", strtotime(\$row['date_added']));
                            \$resourcePath = htmlspecialchars(\$row['resource_path']);
                            if (strlen(\$title) > \$max_length) {
                                \$title = substr(\$title, 0, \$max_length) . '...';
                            }
                            if (containsFilesPath(\$resourcePath)) {
                                \$resourcePath = '../' . \$resourcePath;
                            }
                            echo " <a class='more_posts_subdiv'>";
                            echo "<img src='../images/resurces_img.png' alt='Whitepaper Image'/>";
                            echo "  <div class='more_posts_subdiv_subdiv'>
                                        <h1>\$title</h1>
                                        <span>\$formattedDate</span>
                                    </div>";
                            echo "  <div class='view_whitepaper'>
                                        <div class='posts_btn' onclick=\"window.location.href='\$resourcePath'\" target='_blank'>
                                            <i class='fa fa-eye' aria-hidden='true'></i>
                                        </div>
                                    </div>
                                ";
                            echo "<p class='posts_div_niche'>\$niche</p>";
                            echo "</a>";
                        }
                    } else {
                        echo "<h1 class='bodyleft_header3'>No results found for ' \$query '</h1>";
                    }
                }
            }
            exit;
            }
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <?php
                if (isset(\$meta_titles[\$page_name])) {
                    \$meta_data = \$meta_titles[\$page_name];
                    for (\$i = 1; \$i <= 5; \$i++) {
                        \$meta_name = \$meta_data["meta_name{\$i}"];
                        \$meta_content = \$meta_data["meta_content{\$i}"];
                        if (!empty(\$meta_name) && !empty(\$meta_content)) {
                            echo "<meta name='\$meta_name' content='\$meta_content' />";
                        }
                    }
                }
            ?>
            <meta http-equiv="X-UA-Compatible" content="ie=edge" />
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="../index.css" />
            <script src="../index.js" defer></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <link rel="icon" href="../<?php echo \$favicon; ?>" type="image/x-icon">
            <title>$uc_page_name</title>
        </head>
        <body id="container">
            <?php require("../includes/header2.php"); ?>
            <div class="body_container">
                <div class="body_left">
                    <div class="page_links">
                        <a href="../">Home</a> > <p>Resources ($uc_page_name)</p>
                    </div>
                    <h1 class='bodyleft_header3'>Search $uc_page_name</h1>
                    <form class="header_searchbar2 search_input" id="search_form">
                        <input type="text" name="query" id="search-bar" placeholder="Search.." />
                        <button class="fa fa-search" type="button" onclick="submitSearch()"></button>
                    </form>
                    <div id="search-results" style="display: none;">
                        <div id="results-container" class="more_posts"></div>
                    </div>
                    <div class='more_posts'>
                        <?php
                            \$sql = "SELECT name, resource_path, niche, title, date_added FROM $tableName ORDER BY id DESC";
                            \$result = \$conn->query(\$sql);
                            if (\$result->num_rows > 0) {
                                while (\$row = \$result->fetch_assoc()) {
                                    \$title = \$row["title"];
                                    \$max_length = 50;
                                    \$niche = \$row["niche"];
                                    \$date = \$row["date_added"];
                                    \$path = \$row["resource_path"];
                                    \$dateTime = new DateTime(\$date);
                                    \$day = \$dateTime->format('j');
                                    \$month = \$dateTime->format('M');
                                    \$year = \$dateTime->format('Y');
                                    \$ordinalSuffix = getOrdinalSuffix(\$day);
                                    \$formattedDate = \$month . ' ' . \$day . \$ordinalSuffix . ', ' . \$year;
                                    if (strlen(\$title) > \$max_length) {
                                        \$title = substr(\$title, 0, \$max_length) . '...';
                                    }
                                    if (containsFilesPath(\$path)) {
                                        \$path = '../' . \$path;
                                    }
                                    echo "  <a class='more_posts_subdiv'>
                                                <img src='../images/resurces_img.png' alt='Resource Image' />
                                                <div class='more_posts_subdiv_subdiv'>
                                                    <h1>\$title</h1>
                                                    <span>\$formattedDate</span>
                                                </div>
                                                <div class='view_whitepaper'>
                                                    <div class='posts_btn' onclick=\"window.location.href='\$path'\" target='_blank'>
                                                        <i class='fa fa-eye' aria-hidden='true'></i>
                                                    </div>
                                                </div>
                                                <p class='posts_div_niche'>\$niche</p>
                                    </a>";
                                }
                            } else {
                                echo "<p>No $uc_page_name Uploaded Yet.</p>";
                            }
                        ?>
                    </div>
                </div>
                <div class="body_right border-gradient-leftside--lightdark">
                    <div class="subscribe_container">
                        <form class="sec2__susbribe-box other_width" method="POST" action="" id="susbribe-box">
                            <div class="icon">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </div>
                            <h1 class="sec2__susbribe-box-header">Subscribe to Updates</h1>
                            <p class="sec2__susbribe-box-p1">Get the latest Updates and Info from Uniquetechcontentwriter on Cybersecurity, Artificial Intelligence and lots more.</p>
                            <input class="sec2__susbribe-box_input" type="text" placeholder="Your Email Address..." name="email" required />
                            <input class="sec2__susbribe-box_btn" type="submit" value="Submit" name="submit_btn" />
                        </form>
                        <div id="thank-you-message"></div>
                    </div>
                    <h3 class="bodyleft_header3 border-gradient-bottom--lightdark">Editor's Picks</h3>
                    <?php include("../helpers/editorspicks.php"); ?>
                </div>
            </div>
            <?php include("../includes/footer2.php"); ?>
            <script src="sweetalert2.all.min.js"></script>
            <script>
                const closeMenuBtn = document.querySelector('.sidebarbtn');
                const sidebar = document.getElementById('sidebar');
                const menubtn = document.querySelector('.mainheader__header-nav-2');
                var messageType = "<?= \$_SESSION['status_type'] ?? ' ' ?>";
                var messageText = "<?= \$_SESSION['status'] ?? ' ' ?>";
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
                onClickOutside(sidebar);
                menubtn.addEventListener('click', removeHiddenClass);
                closeMenuBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    sidebar.classList.toggle('hidden');
                });
                function submitSearch() {
                    var query = document.getElementById("search-bar").value;
                    if (query.trim() !== "") {
                        fetch("$filename?query=" + encodeURIComponent(query))
                            .then(response => response.text())
                            .then(data => {
                                document.getElementById("results-container").innerHTML = data;
                                document.getElementById("search-results").style.display = "block";
                            })
                            .catch(error => console.error("Error fetching results:", error));
                    } else {
                        document.getElementById("search-results").style.display = "none"; // Hide if empty search
                    }
                }
            </script>
            <script>
                if (messageType == 'Error' && messageText != " ") {
                    Swal.fire({
                        title: 'Error!',
                        text: messageText,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                } else if (messageType == 'Info' && messageText != " ") {
                    Swal.fire({
                        title: 'Info!',
                        text: messageText,
                        showConfirmButton: true,
                        confirmButtonText: 'Ok',
                        icon: 'info'
                    })
                } else if (messageType == 'Success' && messageText != " ") {
                    Swal.fire({
                        title: 'Success',
                        text: messageText,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    })
                }
                <?php unset(\$_SESSION['status_type']); ?>
                <?php unset(\$_SESSION['status']); ?>
            </script>
        </body>
        </html>
    PHP;
    if (file_put_contents($filePath, $fileContent)) {
        if (!empty($convertedPath) && empty($resource_url)) {
            $stmt = $conn->prepare("INSERT INTO $tableName (name, resource_path, date_added, time_added, niche, title) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $tableName, $convertedPath, $date, $time, $resource_niche, $resource_title);
            if ($stmt->execute()) {
                $stmt = $conn->prepare("INSERT INTO resources (resource_name, Date, Time) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $resource_type, $date, $time);
                if ($stmt->execute()) {
                    $_SESSION['status_type'] = "Success";
                    $_SESSION['status'] = "Resource type added successfully";
                    $content = "Editor " . $_SESSION['firstname'] . " added a new Resource type";
                    $forUser = 0;
                    logUpdate($conn, $forUser, $content);
                    header('location: edit/frontend_features.php');
                }
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: edit/frontend_features.php');
            }
        } else if (empty($convertedPath) && !empty($resource_url)) {
            $stmt = $conn->prepare("INSERT INTO $tableName (name, resource_path, date_added, time_added, niche, title) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $tableName, $resource_url, $date, $time, $resource_niche, $resource_title);
            if ($stmt->execute()) {
                $stmt = $conn->prepare("INSERT INTO resources (resource_name, Date, Time) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $resource_type, $date, $time);
                if ($stmt->execute()) {
                    $_SESSION['status_type'] = "Success";
                    $_SESSION['status'] = "Resource type added successfully";
                    $content = "Editor " . $_SESSION['firstname'] . " added a new Resource type";
                    $forUser = 0;
                    logUpdate($conn, $forUser, $content);
                    header('location: edit/frontend_features.php');
                }
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: edit/frontend_features.php');
            }
        } else if (!empty($convertedPath) && !empty($resource_url)) {
            $stmt = $conn->prepare("INSERT INTO $tableName (name, resource_path, date_added, time_added, niche, title) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $tableName, $resource_url, $date, $time, $resource_niche, $resource_title);
            if ($stmt->execute()) {
                $stmt = $conn->prepare("INSERT INTO resources (resource_name, Date, Time) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $resource_type, $date, $time);
                if ($stmt->execute()) {
                    $_SESSION['status_type'] = "Success";
                    $_SESSION['status'] = "Resource type added successfully";
                    $content = "Editor " . $_SESSION['firstname'] . " added a new Resource type";
                    $forUser = 0;
                    logUpdate($conn, $forUser, $content);
                    header('location: edit/frontend_features.php');
                }
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: edit/frontend_features.php');
            }
        }
    }
}
function savePost1($title, $subtitle, $convertedPath, $content, $niche, $link, $schedule, $editor_id, $author_firstname, $author_lastname, $author_bio, $post_type)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    if ($post_type === "posts") {
        $idtype = "id2";
    } elseif ($post_type === "news") {
        $idtype = "id3";
    } elseif ($post_type === "commentaries") {
        $idtype = "id4";
    } else {
        $idtype = "id5";
    }
    $is_favourite = 0;
    if ($convertedPath !== null) {
        $sql = "INSERT INTO $post_type (editor_id, title, niche, image_path, Date, time, schedule, subtitle, link, content, authors_firstname, about_author, authors_lastname, idtype, is_favourite) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if ($query = $conn->prepare($sql)) {
            $query->bind_param("issssssisssssss", $editor_id, $title, $niche, $convertedPath, $date, $time, $schedule, $subtitle, $link, $content, $author_firstname, $author_bio, $author_lastname, $idtype, $is_favourite);
            if ($query->execute()) {
                $post_id = $conn->insert_id;
                $post_link = "http://localhost/Sample-dynamic-website/pages/view_post.php?" . $idtype . "=" . $post_id . "";
                $content = "Editor " . $_SESSION['firstname'] . " added a new post (" . $post_type . ")";
                $forUser = 1;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Post Created Successfully";
                sendNewpostNotification($title, $post_link, $convertedPath, $subtitle);
                header('location: editor_homepage.php');
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: editor_homepage.php');
            }
        } else {
            $error = $conn->errno . ' ' . $conn->error;
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = $error;
            header('location: create_new/posts.php');
        }
    } else {
    }
}
function createCategory($category_name, $category_image)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $meta_name = "viewport";
    $meta_content = "width=device-width,initial-scale=1.0";
    $formattedTopicName = strtolower(str_replace(' ', '-', $category_name));
    $filename = removeHyphenNoSpace($category_name) . '.php';
    $uc_category_name = noHyphenUppercase($category_name);
    $fileContent = <<<PHP
        <?php
            session_start();
            require('../connect.php');
            require('../init.php');
           \$_SESSION['status_type'] = "";
           \$_SESSION['status'] = "";
           \$page_name = "$formattedTopicName";
           \$details = getFaviconAndLogo();
           \$logo = \$details['logo'];
           \$favicon = \$details['favicon'];
           if (isset(\$_POST['submit_btn'])) {
                \$email = \$_POST["email"];
                \$sendEmail = sendEmail(\$email);
                \$_SESSION['status_type'] = \$sendEmail['status_type'];
                \$_SESSION['status'] = \$sendEmail['status'];
            }
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <?php if (isset(\$meta_titles[\$page_name])) {
                \$meta_data = \$meta_titles[\$page_name];
                for (\$i = 1; \$i <= 5; \$i++) {
                    \$meta_name = \$meta_data["meta_name\$i"];
                    \$meta_content = \$meta_data["meta_content\$i"];
                    if (!empty(\$meta_name) && !empty(\$meta_content)) {
                        echo "<meta name='\$meta_name' content='\$meta_content' />";
                    }
                }
            }?>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="../index.css" />
            <meta charset="UTF-8">
            <title>$uc_category_name</title>
        </head>
        <body id="container">
            <?php require("../includes/header2.php"); ?>
            <div class="body_container">
                <div class="body_left">
                    <div class="page_links">
                        <a href="../">Home</a> > <p>$uc_category_name</p>
                    </div>
                    <h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>Latest On $uc_category_name</h1>
                    <div class='more_posts'>
                        <?php
                            \$tables = ['paid_posts', 'posts', 'commentaries', 'news', 'press_releases'];
                            \$results = [];
                            foreach (\$tables as \$table) {
                                \$sql = "SELECT id, title, niche, content, image_path, Date FROM \$table WHERE niche LIKE ? ORDER BY id DESC LIMIT 2";
                                \$stmt = \$conn->prepare(\$sql);
                                \$nicheq = '$uc_category_name';
                                \$searchTerm = "%" . \$nicheq . "%";
                                \$stmt->bind_param("s", \$searchTerm);
                                \$stmt->execute();
                                \$stmt->bind_result(\$id, \$title, \$niche, \$content, \$image, \$date);
                                while (\$stmt->fetch()) {
                                    \$posttype = 0;
                                    if (\$table == 'paid_posts') {
                                        \$posttype = 1;
                                    } elseif (\$table == 'posts') {
                                        \$posttype = 2;
                                    } elseif (\$table == 'commentaries') {
                                        \$posttype = 4;
                                    } elseif (\$table == 'news') {
                                        \$posttype = 3;
                                    } elseif (\$table == 'press_releases') {
                                        \$posttype = 5;
                                    }
                                    \$results[] = [
                                        'id' => \$id,
                                        'title' => \$title,
                                        'niche' => \$niche,
                                        'content' => \$content,
                                        'image_path' => \$image,
                                        'Date' => \$date,
                                        'table' => \$table,
                                        'posttype' => \$posttype
                                    ];
                                }
                            }
                            foreach (\$results as \$result) {
                            \$max_length = 60;
                            \$id = \$result['id'];
                            \$title = \$result['title'];
                            \$date = \$result['Date'];
                            \$image = \$result['image_path'];
                            if (strlen(\$title) > \$max_length) {
                                \$title = substr(\$title, 0, \$max_length) . '...';
                            }
                            \$dateTime = new DateTime(\$date);
                            \$day = \$dateTime->format('j');
                            \$month = \$dateTime->format('M');
                            \$year = \$dateTime->format('Y');
                            \$ordinalSuffix = getOrdinalSuffix(\$day);
                            \$formattedDate = \$month . ' ' . \$day . \$ordinalSuffix . ', ' . \$year;
                            \$readingTime = calculateReadingTime(\$result['content']);
                            echo "<a class='more_posts_subdiv' href='view_post.php?id" . \$result['posttype'] . "=\$id'>";
                            if (!empty(\$image)) {
                                echo "<img src='../\$image' alt = 'Post's Image'/>";
                            }
                            echo"<div class='more_posts_subdiv_subdiv'>
                                    <h1>\$title</h1>
                                    <span>\$formattedDate</span>
                                    <span>\$readingTime</span>
                                </div>
                                <p class='posts_div_niche'>" . \$result['niche'] . "</p>
                            </a>";}
                        ?>
                    </div>
                </div>
                <div class="body_right border-gradient-leftside--lightdark">
                    <div class="subscribe_container">
                        <form class="sec2__susbribe-box other_width" method="POST" action="" id="susbribe-box">
                            <div class="icon">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </div>
                            <h1 class="sec2__susbribe-box-header">Subscribe to Updates</h1>
                            <p class="sec2__susbribe-box-p1">Get the latest Updates and Info from Uniquetechcontentwriter on Cybersecurity, Artificial Intelligence and lots more.</p>
                            <input class="sec2__susbribe-box_input" type="text" placeholder="Your Email Address..." name="email" required />
                            <input class="sec2__susbribe-box_btn" type="submit" value="Submit" name="submit_btn" />
                        </form>
                    </div>
                    <h3 class="bodyleft_header3 border-gradient-bottom--lightdark">Editor's Picks</h3>
                    <?php include("../helpers/editorspicks.php"); ?>
                </div>
            </div>
            <section class="section2">
                <div class="section2__div1">
                    <div class="search_div" id="result"></div>
                    <div class="section2__div1__header headers">
                        <h1>For You</h1>
                    </div>
                    <?php include('../includes/pagination.php'); ?>
                </div>
            </section>
            <?php include("../includes/footer2.php"); ?>
            <script src="sweetalert2.all.min.js"></script>
            <script>
                const closeMenuBtn = document.querySelector('.sidebarbtn');
                const sidebar = document.getElementById('sidebar');
                const menubtn = document.querySelector('.mainheader__header-nav-2');
                var messageType = "<?= \$_SESSION['status_type'] ?? '' ?>";
                var messageText = "<?= \$_SESSION['status'] ?? '' ?>";
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
                onClickOutside(sidebar);
                menubtn.addEventListener('click', removeHiddenClass);
                closeMenuBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    sidebar.classList.toggle('hidden');
                });
            </script>
            <script>
                if (messageType == 'Error' && messageText != " ") {
                    Swal.fire({
                        title: 'Error!',
                        text: messageText,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                } else if (messageType == 'Info' && messageText != " ") {
                    Swal.fire({
                        title: 'Info!',
                        text: messageText,
                        showConfirmButton: true,
                        confirmButtonText: 'Ok',
                        icon: 'info'
                    })
                } else if (messageType == 'Success' && messageText != " ") {
                    Swal.fire({
                        title: 'Success',
                        text: messageText,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    })
                }
                <?php unset(\$_SESSION['status_type']); ?>
                <?php unset(\$_SESSION['status']); ?>
            </script>
        </body>
        </html>
    PHP;
    if ($category_image !== null) {
        $sqlTopics = "INSERT INTO topics (name, image_path, Date, time) VALUES (?,?,?,?)";
        $filePath = '../pages/' . $filename;
        if ($query = $conn->prepare($sqlTopics)) {
            $query->bind_param("ssss", $formattedTopicName, $category_image, $date, $time);
            if ($query->execute()) {
                $sqlMetaTitles = "INSERT INTO meta_titles (page_name, meta_name1, meta_content1) VALUES (?, ?, ?)";
                if ($query = $conn->prepare($sqlMetaTitles)) {
                    $query->bind_param("sss", $formattedTopicName, $meta_name, $meta_content);
                    if ($query->execute()) {
                        if (file_put_contents($filePath, $fileContent)) {
                            $content = "Editor " . $_SESSION['firstname'] . " added a new category";
                            $forUser = 0;
                            logUpdate($conn, $forUser, $content);
                            $_SESSION['status_type'] = "Success";
                            $_SESSION['status'] = "Category Created Successfully";
                            header('location: create_new/category.php');
                        } else {
                            $_SESSION['status_type'] = "Error";
                            $_SESSION['status'] = "Error, Please retry";
                            header('location: create_new/category.php');
                        }
                    }
                }
            }
        }
    } else {
        $sqlTopics = "INSERT INTO topics (name, Date, time) VALUES (?,?,?)";
        $filePath = '../pages/' . $filename;
        if ($query = $conn->prepare($sqlTopics)) {
            $query->bind_param("sss", $formattedTopicName, $date, $time);
            if ($query->execute()) {
                $sqlMetaTitles = "INSERT INTO meta_titles (page_name, meta_name1, meta_content1) VALUES (?, ?, ?)";
                if ($query = $conn->prepare($sqlMetaTitles)) {
                    $query->bind_param("sss", $formattedTopicName, $meta_name, $meta_content);
                    if ($query->execute()) {
                        if (file_put_contents($filePath, $fileContent)) {
                            $content = "Editor " . $_SESSION['firstname'] . " added a new category";
                            $forUser = 0;
                            logUpdate($conn, $forUser, $content);
                            $_SESSION['status_type'] = "Success";
                            $_SESSION['status'] = "Category Created Successfully";
                            header('location: create_new/category.php');
                        } else {
                            $_SESSION['status_type'] = "Error";
                            $_SESSION['status'] = "Error, Please retry";
                            header('location: create_new/category.php');
                        }
                    }
                }
            }
        }
    }
}
function savePost2($title, $subtitle, $convertedPath, $content, $niche, $link, $schedule, $editor_id, $author_firstname, $author_lastname, $author_bio, $post_type)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $idtype = "";
    if ($post_type === "posts") {
        $idtype = "id2";
    } elseif ($post_type === "news") {
        $idtype = "id3";
    } elseif ($post_type === "commentaries") {
        $idtype = "id4";
    } else {
        $idtype = "id5";
    }
    $is_favourite = 0;
    $sql = "INSERT INTO $post_type (editor_id, title, niche, post_image_url, Date, time, schedule, subtitle, link, content, authors_firstname, about_author, authors_lastname, idtype, is_favourite) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($query = $conn->prepare($sql)) {
        $query->bind_param("issssssisssssss", $editor_id, $title, $niche, $convertedPath, $date, $time, $schedule, $subtitle, $link, $content, $author_firstname, $author_bio, $author_lastname, $idtype, $is_favourite);
        if ($query->execute()) {
            $post_id = $conn->insert_id;
            $post_link = "http://localhost/Sample-dynamic-website/pages/view_post.php?" . $idtype . "=" . $post_id . "";
            $content = "Editor " . $_SESSION['firstname'] . " added a new post (" . $post_type . ")";
            $forUser = 1;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Post Created Successfully";
            sendNewpostNotification($title, $post_link, $convertedPath, $subtitle);
            header('location: create_new/posts.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: create_new/posts.php');
        }
    } else {
        $error = $conn->errno . ' ' . $conn->error;
        echo $error;
    }
}
function saveDraft($title, $subtitle, $imagePath, $content, $niche, $link, $editor_id)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    if ($imagePath !== null) {
        $stmt = $conn->prepare("INSERT INTO unpublished_articles (editor_id, title, subtitle, image, link, Date, time, niche, content) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssss", $editor_id, $title, $subtitle, $imagePath, $link, $date, $time, $niche, $content);
        if ($stmt->execute()) {
            $content = "Editor " . $_SESSION['firstname'] . " added a draft";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Draft Created Successfully";
            header('location: editor_homepage.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: editor_homepage.php');
        }
    } else {
        $stmt = $conn->prepare("INSERT INTO unpublished_articles (editor_id, title, subtitle, link, Date, time, niche, content) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssss", $editor_id, $title, $subtitle, $link, $date, $time, $niche, $content);
        if ($stmt->execute()) {
            $content = "Editor " . $_SESSION['firstname'] . " added a draft";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Draft Created Successfully";
            header('location: editor_homepage.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: editor_homepage.php');
        }
    }
    $stmt->close();
}
function updatePost($title, $subtitle, $imagePath, $content, $niche, $link, $editor_id, $author_firstname, $author_lastname, $author_bio, $tablename, $post_id)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    if ($imagePath !== null) {
        $stmt = $conn->prepare("UPDATE $tablename SET title = ?, subtitle = ?, image_path = ?, content = ?, niche = ?, link = ?, Date = ?, time = ?, authors_firstname = ?, about_author = ?, authors_lastname = ? WHERE id = ?");
        $stmt->bind_param("sssssssssssi", $title, $subtitle, $imagePath, $content, $niche, $link, $date, $time, $author_firstname, $author_bio, $author_lastname, $post_id);
        if ($stmt->execute()) {
            $content = "Editor " . $_SESSION['firstname'] . " updated a post";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Post Updated Successfully";
            header('location: editor_homepage.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: editor_homepage.php');
        }
        $stmt->close();
    } else {
        $stmt = $conn->prepare("UPDATE $tablename SET title = ?, subtitle = ?, content = ?, niche = ?, link = ?, Date = ?, time = ?, authors_firstname = ?, about_author = ?, authors_lastname = ? WHERE id = ?");
        $stmt->bind_param("ssssssssssi", $title, $subtitle, $content, $niche, $link, $date, $time, $author_firstname, $author_bio, $author_lastname, $post_id);
        if ($stmt->execute()) {
            $content = "Editor " . $_SESSION['firstname'] . " updated a post";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Post Updated Successfully";
            header('location: editor_homepage.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: editor_homepage.php');
        }
        $stmt->close();
    }
}
function updateProfile($firstname, $lastname, $email, $username, $bio, $address1, $address2, $city, $state, $country, $countrycode, $mobile, $imagePath, $editor_id)
{
    global $conn;
    if ($imagePath !== null) {
        $stmt = $conn->prepare("UPDATE editor SET firstname = ?, lastname = ?, username = ?, email = ?, image = ?, bio = ?, mobile = ?, country = ?, 	city = ?, state = ?, address1 = ?, address2 = ?, country_code = ? WHERE id = ?");
        $stmt->bind_param("sssssssssssssi", $firstname, $lastname, $username, $email, $imagePath, $bio, $mobile, $country, $city, $state, $address1, $address2, $countrycode, $editor_id);
        if ($stmt->execute()) {
            $content = "Editor " . $_SESSION['firstname'] . " updated his/her profile";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Profile Updated Successfully";
            header('location: editor_homepage.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: editor_homepage.php');
        }
        $stmt->close();
    } else {
        $stmt = $conn->prepare("UPDATE editor SET firstname = ?, lastname = ?, username = ?, email = ?, bio = ?, mobile = ?, country = ?, 	city = ?, state = ?, address1 = ?, address2 = ?, country_code = ? WHERE id = ?");
        $stmt->bind_param("ssssssssssssi", $firstname, $lastname, $username, $email, $bio, $mobile, $country, $city, $state, $address1, $address2, $countrycode, $editor_id);
        if ($stmt->execute()) {
            $content = "Editor " . $_SESSION['firstname'] . " updated his/her profile";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Profile Updated Successfully";
            header('location: editor_homepage.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: editor_homepage.php');
        }
        $stmt->close();
    }
}
function updateUserProfile($firstname, $lastname, $email, $role, $url, $bio, $imagePath, $id)
{
    global $conn;
    if ($imagePath !== null) {
        $stmt = $conn->prepare("UPDATE otherwebsite_users SET firstname = ?, lastname = ?, email = ?, role = ?, image = ?, bio = ?, linkedin_url = ? WHERE id = ?");
        $stmt->bind_param("sssssssi", $firstname, $lastname, $email, $role, $imagePath, $bio, $url, $id);
        if ($stmt->execute()) {
            $content = "Editor " . $_SESSION['firstname'] . " updated $firstname's profile";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Profile Updated Successfully";
            header('location: editor_homepage.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: editor_homepage.php');
        }
        $stmt->close();
    } else {
        $stmt = $conn->prepare("UPDATE otherwebsite_users SET firstname = ?, lastname = ?, email = ?, role = ?, bio = ?, linkedin_url = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $firstname, $lastname, $email, $role, $bio, $url, $id);
        if ($stmt->execute()) {
            $content = "Editor " . $_SESSION['firstname'] . " updated $firstname's profile";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Profile Updated Successfully";
            header('location: editor_homepage.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: editor_homepage.php');
        }
        $stmt->close();
    }
}
function updateWriterProfile($firstname, $lastname, $email, $bio, $imagePath, $id)
{
    global $conn;
    if ($imagePath !== null) {
        $stmt = $conn->prepare("UPDATE writer SET firstname = ?, lastname = ?, email = ?, image = ?, bio = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $firstname, $lastname, $email, $imagePath, $bio, $id);
        if ($stmt->execute()) {
            $content = "Editor " . $_SESSION['firstname'] . " updated $firstname's profile";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Profile Updated Successfully";
            header('location: editor_homepage.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: editor_homepage.php');
        }
        $stmt->close();
    } else {
        $stmt = $conn->prepare("UPDATE writer SET firstname = ?, lastname = ?, email = ?, bio = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $firstname, $lastname, $email, $bio, $id);
        if ($stmt->execute()) {
            $content = "Editor " . $_SESSION['firstname'] . " updated $firstname's profile";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Profile Updated Successfully";
            header('location: editor_homepage.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: editor_homepage.php');
        }
        $stmt->close();
    }
}
function addWriter($firstname, $lastname, $email, $imagePath, $editor_id)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $idtype = "Writer";
    $stmt = $conn->prepare("INSERT INTO writer (editor_id, firstname, lastname, email, image, date_joined, time_joined, idtype) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $editor_id, $firstname, $lastname, $email, $imagePath, $date, $time, $idtype);
    if ($stmt->execute()) {
        $content = "Editor " . $_SESSION['firstname'] . " created a new user (Writer)";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "User Created Successfully";
        header('location: create_new/writer.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: create_new/writer.php');
    }
    $stmt->close();
}
function addUser($firstname, $lastname, $email,  $role, $linkedin_url, $imagePath)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("INSERT INTO otherwebsite_users ( firstname, lastname, email, role, image, linkedin_url, date_joined, time_joined) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $firstname, $lastname, $email, $role, $imagePath, $linkedin_url, $date, $time);
    if ($stmt->execute()) {
        $content = "Editor " . $_SESSION['firstname'] . " created a new user";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "User Created Successfully";
        header('location: create_new/user.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: create_new/user.php');
    }
    $stmt->close();
}
if (isset($_POST['create_post'])) {
    $title = $_POST['Post_Title'];
    $subtitle = $_POST['Post_Sub_Title'];
    $content = $_POST['Post_content'];
    $niche = $_POST['Post_Niche'];
    $post_type = $_POST['Post_status'];
    $link = $_POST['Post_featured'];
    $schedule = $_POST['schedule'];
    $author_firstname = $_POST['author_firstname'];
    $author_lastname = $_POST['author_lastname'];
    $author_bio = $_POST['about_author'];
    $image2 = $_POST['Post_Image2'];
    $image1 = $_FILES['Post_Image1']['name'];
    $target = "../images/" . basename($image1);
    if (empty($image1) && !empty($image2)) {
        $imagePath = $image2;
        savePost2($title, $subtitle, $imagePath, $content, $niche, $link, $schedule, $editor_id, $author_firstname, $author_lastname, $author_bio, $post_type);
    } elseif (!empty($image1) && empty($image2)) {
        if (move_uploaded_file($_FILES['Post_Image1']['tmp_name'], $target)) {
            $filePath = $_FILES["Post_Image1"]["tmp_name"];
            $imagePath = uploadToCloudinary($filePath);
            savePost1($title, $subtitle, $imagePath, $content, $niche, $link, $schedule, $editor_id, $author_firstname, $author_lastname, $author_bio, $post_type);
        }
    } else if (!empty($image1) && !empty($image2)) {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Please ensure the post's image is selected or it's url provided and not both.";
        header('location: create_new/posts.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Please provide the post's image or it's url.";
        header('location: create_new/posts.php');
    }
}
if (isset($_POST['edit_profile'])) {
    $firstname = $_POST['profile_firstname'];
    $lastname = $_POST['profile_lastname'];
    $username = $_POST['profile_username'];
    $bio = $_POST['profile_bio'];
    $email = $_POST['profile_email'];
    $address1 = $_POST['profile-address1'];
    $address2 = $_POST['profile-address2'];
    $city = $_POST['profile-city'];
    $state = $_POST['profile-state'];
    $country = $_POST['profile-country'];
    $countrycode = $_POST['profile-countrycode'];
    $mobile = $_POST['profile-mobile'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    $imagePath;
    if (empty($image)) {
        $imagePath = null;
    }
    if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
        $filePath = $_FILES["Img"]["tmp_name"];
        $imagePath = uploadToCloudinary($filePath);
    }
    updateProfile($firstname, $lastname, $email, $username, $bio, $address1, $address2, $city, $state, $country, $countrycode, $mobile, $imagePath, $editor_id);
}
if (isset($_POST['edit_profile_writer'])) {
    $id = $_POST['profile-id'];
    $firstname = $_POST['profile_firstname'];
    $lastname = $_POST['profile_lastname'];
    $bio = $_POST['profile_bio'];
    $email = $_POST['profile_email'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    if (empty($image)) {
        $convertedPath = null;
    }
    if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
        $filePath = $_FILES["Img"]["tmp_name"];
        $convertedPath = uploadToCloudinary($filePath);
    }
    updateWriterProfile($firstname, $lastname, $email, $bio, $convertedPath, $id);
}
if (isset($_POST['edit_profile_otheruser'])) {
    $id = $_POST['profile-id'];
    $firstname = $_POST['profile_firstname'];
    $lastname = $_POST['profile_lastname'];
    $bio = $_POST['profile_bio'];
    $role = $_POST['profile_role'];
    $email = $_POST['profile_email'];
    $url = $_POST['profile_url'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    if (empty($image)) {
        $convertedPath = null;
    }
    if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
        $filePath = $_FILES["Img"]["tmp_name"];
        $convertedPath = uploadToCloudinary($filePath);
    }
    updateUserProfile($firstname, $lastname, $email, $role, $url, $bio, $convertedPath, $id);
}
if (isset($_POST['create_draft'])) {
    $title = $_POST['Post_Title'];
    $subtitle = $_POST['Post_Sub_Title'];
    $content = $_POST['Post_content'];
    $niche = $_POST['Post_Niche'];
    $link = $_POST['Post_featured'];
    $image = $_FILES['Post_Image']['name'];
    $target = "../images/" . basename($image);
    if (empty($image)) {
        $convertedPath = null;
    }
    if (move_uploaded_file($_FILES['Post_Image']['tmp_name'], $target)) {
        $filePath = $_FILES["Post_Image"]["tmp_name"];
        $convertedPath = uploadToCloudinary($filePath);
    }
    saveDraft($title, $subtitle, $convertedPath, $content, $niche, $link, $editor_id);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_post'])) {
    $title = $_POST['Post_Title'];
    $niche = $_POST['Post_Niche'];
    $content = $_POST['Post_content'];
    $link = $_POST['Post_featured'];
    $tablename = $_POST['table_type'];
    $post_id = $_POST['post_id'];
    $subtitle = $_POST['Post_Sub_Title'];
    $author_firstname = $_POST['author_firstname'];
    $author_lastname = $_POST['author_lastname'];
    $author_bio = $_POST['about_author'];
    $image = $_FILES['Post_Image']['name'];
    $target = "../images/" . basename($image);
    if (empty($image)) {
        $convertedPath = null;
    }
    if (move_uploaded_file($_FILES['Post_Image']['tmp_name'], $target)) {
        $filePath = $_FILES["Post_Image"]["tmp_name"];
        $convertedPath = uploadToCloudinary($filePath);
    }
    updatePost($title, $subtitle, $convertedPath, $content, $niche, $link, $editor_id, $author_firstname, $author_lastname, $author_bio, $tablename, $post_id);
}
if (isset($_POST['create_page'])) {
    $topic_name = $_POST['topicName'];
    $image = $_FILES['topicImg']['name'];
    $target = "../images/" . basename($image);
    if (empty($image)) {
        $convertedPath = null;
    }
    if (move_uploaded_file($_FILES['topicImg']['tmp_name'], $target)) {
        $filePath = $_FILES["topicImg"]["tmp_name"];
        $convertedPath = uploadToCloudinary($filePath);
    }
    createCategory($topic_name, $convertedPath);
}
if (isset($_POST['create_writer'])) {
    $firstname = $_POST['writer_firstname'];
    $lastname = $_POST['writer_lastname'];
    $email = $_POST['writer_email'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    if (empty($image)) {
        $convertedPath = null;
    }
    if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
        $filePath = $_FILES["Img"]["tmp_name"];
        $convertedPath = uploadToCloudinary($filePath);
    }
    addWriter($firstname, $lastname, $email, $convertedPath, $editor_id);
}
if (isset($_POST['create_user'])) {
    $firstname = $_POST['user_firstname'];
    $lastname = $_POST['user_lastname'];
    $email = $_POST['user_email'];
    $role = $_POST['user_role'];
    $linkedin_url = $_POST['user_linkedin_url'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    if (empty($image)) {
        $convertedPath = null;
    }
    if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
        $filePath = $_FILES["Img"]["tmp_name"];
        $convertedPath = uploadToCloudinary($filePath);
    }
    addUser($firstname, $lastname, $email,  $role, $linkedin_url, $convertedPath);
}
if (isset($_POST['add_resource'])) {
    $resource_type = $_POST['resource_type'];
    $resource_niche = $_POST['resource_niche'];
    $resource_title = $_POST['resource_title'];
    $resource_url = $_POST['resource_url'];
    $resource_image = $_FILES['resource_image']['name'];
    $resource_tmp_name = $_FILES['resource_image']['tmp_name'];
    $resource_folder = "../files/" . $resource_image;
    $tableName = pluralizeTableName($resource_type);
    $result = $conn->query("SHOW TABLES LIKE '$tableName'");
    if ($result->num_rows == 0) {
        $sql = "CREATE TABLE IF NOT EXISTS $tableName (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50) NULL, resource_path VARCHAR(100) NULL, date_added DATE NOT NULL, time_added TIME NOT NULL, niche VARCHAR(50) NULL, title VARCHAR(100) NULL)";
        if ($conn->query($sql) === TRUE) {
            if (empty($resource_image)) {
                $convertedPath = null;
            }
            if (move_uploaded_file($resource_tmp_name, $resource_folder)) {
                $convertedPath = uploadToCloudinary($resource_tmp_name);
                $resource_type = convertToUnreadable($resource_type);
            }
            addResources($tableName, $convertedPath, $resource_type, $resource_niche, $resource_title, $resource_url);
        }
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Resource Type Already Exists";
        header('location: edit/frontend_features.php');
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $recordId = intval($_GET["id"]);
    $date = date('y-m-d');
    $time = date('H:i:s');
    file_put_contents("log.txt", "POST request received\n", FILE_APPEND);
    function updateProfilePic($imagePath1)
    {
        global $conn;
        global $recordId;
        $stmt = $conn->prepare("UPDATE editor SET image = ? WHERE id = ?");
        $stmt->bind_param("si", $imagePath1, $recordId);
        if ($stmt->execute()) {
            $content = "Editor " . $_SESSION['firstname'] . " updated his/her Profile Picture";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Sucess";
            $_SESSION['status'] = "Profile Picture Updated Successfully";
            header('location: editor_homepage.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: editor_homepage.php');
        }
        $stmt->close();
    }
    if (isset($_FILES["profile_pic"])) {
        $profile_pic = $_FILES["profile_pic"]["name"];
        $profile_tmp_name = $_FILES["profile_pic"]["tmp_name"];
        $resource_folder1 = "../images/" . $profile_pic;
        if (move_uploaded_file($profile_tmp_name, $resource_folder1)) {
            $filePath1 = $_FILES["profile_pic"]["tmp_name"];
            $convertedPath = uploadToCloudinary($filePath1);
            updateProfilePic($convertedPath);
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error Moving Uploaded Files";
            header('location: editor_homepage.php');
        }
    }
}
