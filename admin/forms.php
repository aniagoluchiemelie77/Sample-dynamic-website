<?php
session_start();
$admin_id = $_SESSION['id'];
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
require("connect.php");
include('crudoperations.php');
require('../init.php');
function noHyphenLowercase($string)
{
    $string = str_replace('-', '', $string);
    $string = strtolower($string);
    return $string;
}
function addWebsiteMessages($cookie_message, $description)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("INSERT INTO website_messages ( cookie_consent, website_vision, Date, time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $cookie_message, $description, $date, $time);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " updated cookie consent message and website description";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Cookie consent message and Website description updated successfully";
        header('location: edit/frontend_features.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: edit/frontend_features.php');
    }
    $stmt->close();
}
function addResources($resource_type)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("INSERT INTO resources ( resource_name, Date, time) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $resource_type, $date, $time);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " added a new Resource type";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Resource type Created Successfully";
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
    }
    $stmt->close();
}
function addPage($page_name)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $meta_name = "viewport";
    $meta_content = "width=device-width,initial-scale=1.0";
    $formattedPageName = strtolower(str_replace(' ', '-', $page_name));
    $formattedPageName2 = strtolower(str_replace(' ', '_', $page_name));
    $filename = removeHyphenNoSpace($page_name) . '.php';
    $uc_page_name = noHyphenUppercase($page_name);
    $fileContent = <<<PHP
        <?php
            session_start();
            require("../connect.php");
            require('../init.php');
            \$page_name = "$formattedPageName";
            \$details = getFaviconAndLogo();
            \$details2 = cookieMessageAndVision();
            \$logo = \$details['logo'];
            \$favicon = \$details['favicon'];
            \$website_description = \$details2['website_vision'];
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
                    <link rel="icon" href="../<?php echo \$favicon; ?>" type="image/x-icon">
                    <script src="../index.js" defer></script>
                    <title>$uc_page_name</title>
                </head>
                <body>
                    <?php require("../includes/header2b.php"); ?>
                    <div class="body_container">
                        <div class="body_right">
                            <div class="sidebar_divs_container">
                                <div class="webinfo">
                                    <h1>Uniquecontentwriter</h1>
                                    <img src="../<?php echo \$logo; ?>" alt="Blog's Coverphoto" />
                                    <p><?php echo \$website_description; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="body_left border-gradient-leftside--lightdark">
                            <div class="page_links">
                                <a href="../">Home</a> > <p>$uc_page_name</p>
                            </div>
                            <h3 class="bodyleft_main">$uc_page_name</h3>
                            <div class="sidebar_divs_container thickdiv">
                                <?php
                                    \$selectpage = "SELECT content FROM $formattedPageName2 ORDER BY id DESC LIMIT 1";
                                    \$selectpage_result = \$conn->query(\$selectpage);
                                    if (\$selectpage_result->num_rows > 0) {
                                        while (\$row = \$selectpage_result->fetch_assoc()) {
                                            \$content = \$row['content'];
                                            echo "<p>\$content</p>";
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php include("../includes/footer2.php"); ?>
                    <script>
                        const sidebar = document.getElementById('sidebar');
                        const menubtn = document.getElementById('searchicon');
                        const closeMenuBtn = document.querySelector('.sidebarbtn');
                        function onClickOutside(element) {
                            document.addEventListener('click', e => {
                                if (!element.contains(e.target)) {
                                    element.classList.add('hidden');
                                } else return;
                            });
                        };
                        function removeHiddenClass(e) {
                            e.stopPropagation();
                            sidebar.classList.remove('hidden');
                        };
                        onClickOutside(sidebar);
                        menubtn.addEventListener('click', removeHiddenClass);
                        closeMenuBtn.addEventListener('click', (e) => {
                            e.stopPropagation();
                            sidebar.classList.toggle('hidden');
                        });
                    </script>
                </body>
            </html>
    PHP;
    $fileContent2 = <<<PHP
        <?php
            session_start();
            require("../connect.php");
            require("../init.php");
            require("../../init.php");
            \$details = getFaviconAndLogo();
            \$logo = \$details['logo'];
            \$favicon = \$details['favicon'];
            \$translationFile = "../translation_files/lang/{\$language}.php";
            if (file_exists(\$translationFile)) {
                include \$translationFile;
            } else {
                \$translations = [];
            }
            function updatePages(\$content, \$tablename)
            {
                global \$conn;
                \$date = date('y-m-d');
                \$time = date('H:i:s');
                \$string = str_replace('-', ' ', \$tablename);
                \$stmt = "INSERT INTO \$tablename (content, date, time) VALUES (?, ?, ?)";
                if (\$query = \$conn->prepare(\$stmt)) {
                    \$query->bind_param("sss", \$content, \$date, \$time);
                    if (\$query->execute()) {
                        \$content = "Admin " . \$_SESSION['firstname'] . " updated this website's '" . \$string . "'";
                        \$forUser = 0;
                        logUpdate(\$conn, \$forUser, \$content);
                        \$_SESSION['status_type'] = "Success";
                        \$_SESSION['status'] = "" . \$string . " Updated Successfully";
                        header('location: admin_homepage.php');
                    } else {
                        \$_SESSION['status_type'] = "Error";
                        \$_SESSION['status'] = "Error, Please retry";
                        header('location: admin_homepage.php');
                    }
                } else {
                    \$error = \$conn->errno . ' ' . \$conn->error;
                    echo \$error;
                    header('location: admin_homepage.php');
                }
            }
            if (isset(\$_POST['edit_aboutwebsite_btn'])) {
                \$content = \$_POST['$formattedPageName'];
                \$tablename = "$formattedPageName";
                updatePages(\$content, \$tablename);
            }
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1" />
                <meta http-equiv="X-UA-Compatible" content="ie=edge" />
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                <link rel="stylesheet" href="../admin.css" />
                <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <link rel="icon" href="../../<?php echo \$favicon; ?>" type="image/x-icon">
                <title>$uc_page_name</title>
            </head>
            <body>
                <?php require("../extras/header2.php"); ?>
                <section class="about_section">
                    <div class="page_links">
                        <a href="../admin_homepage.php"><?php echo \$translations['home']; ?></a> > <p><?php echo \$translations['pages']; ?></p> > <p>$uc_page_name</p>
                    </div>
                    <div class="about_header">
                        <h1>$uc_page_name</h1>
                    </div>
                    <div class="about_contents">
                        <?php
                            \$selectpage = "SELECT content FROM $formattedPageName ORDER BY id DESC LIMIT 1";
                            \$selectpage_result = \$conn->query(\$selectpage);
                            if (\$selectpage_result->num_rows > 0) {
                                while (\$row = \$selectpage_result->fetch_assoc()) {
                                    \$content = \$row['content'];
                                    echo "<span>\$content</span>";
                                }
                            }
                        ?>
                    </div>
                    <button class="about_section_btn" id="Edit_about1"><?php echo \$translations['edit']; ?>
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </button>
                    <form class="about_editdiv" action=" " method="post" id="hidden_aboutdiv1">
                        <textarea class="about_editdiv-input" name="$formattedPageName" id="myTextarea6"></textarea>
                        <input type="submit" value="<?php echo \$translations['save']; ?>" name="edit_aboutwebsite_btn" />
                    </form>
                </section>
                <script type="text/javascript" src="https://cdn.tiny.cloud/1/mshrla4r3p3tt6dmx5hu0qocnq1fowwxrzdjjuzh49djvu2p/tinymce/6/tinymce.min.js"></script>
                <script src="../admin.js"></script>
                <script>
                    var messageType = "<?= \$_SESSION['status_type'] ?? ' ' ?>";
                    var messageText = "<?= \$_SESSION['status'] ?? ' ' ?>";
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
                    <?php unset(\$_SESSION['status_type']); ?>
                    <?php unset(\$_SESSION['status']); ?>
                </script>
                <script>
                    const editAboutBtn = document.getElementById("Edit_about1");
                    const editTextEditor = document.getElementById("hidden_aboutdiv1");
                    editAction(editAboutBtn, editTextEditor);
                </script>
                <script src="sweetalert2.all.min.js"></script>
            </body>
        </html>
    PHP;
    $filePath = '../../pages/' . $filename;
    $filePath2 = '../pages/' . $filename;
    $sql = "CREATE TABLE IF NOT EXISTS $formattedPageName2 (id INT AUTO_INCREMENT PRIMARY KEY, content TEXT NOT NULL, date DATE NOT NULL, time TIME NOT NULL)";
    if ($conn->query($sql) === TRUE) {
        $sqlPages = "INSERT INTO pages (page_name, Date, time) VALUES (?,?,?)";
        if ($query = $conn->prepare($sqlPages)) {
            $query->bind_param("sss", $formattedPageName, $date, $time);
            if ($query->execute()) {
                $sqlMetaTitles = "INSERT INTO meta_titles (page_name, meta_name1, meta_content1) VALUES (?, ?, ?)";
                if ($query = $conn->prepare($sqlMetaTitles)) {
                    $query->bind_param("sss", $formattedPageName, $meta_name, $meta_content);
                    if ($query->execute()) {
                        if (file_put_contents($filePath, $fileContent)) {
                            if (file_put_contents($filePath2, $fileContent2)) {
                                $content = "Admin " . $_SESSION['firstname'] . " created a new page type";
                                $forUser = 0;
                                logUpdate($conn, $forUser, $content);
                                $_SESSION['status_type'] = "Success";
                                $_SESSION['status'] = "Page type Created Successfully";
                            } else {
                                $_SESSION['status_type'] = "Error";
                                $_SESSION['status'] = "Error, Please retry";
                            }
                        } else {
                        }
                    }
                }
            }
        }
    }
}
function savePost1($title, $subtitle, $convertedPath, $content, $niche, $link, $schedule, $admin_id, $author_firstname, $author_lastname, $author_bio, $post_type)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $idtype = "";
    if ($post_type === "paid_posts") {
        $idtype = "id1";
    } elseif ($post_type === "posts") {
        $idtype = "id2";
    } elseif ($post_type === "news") {
        $idtype = "id3";
    } elseif ($post_type === "commentaries") {
        $idtype = "id4";
    } else {
        $idtype = "id5";
    }
    $is_favourite = 0;
    $sql = "INSERT INTO $post_type (admin_id, title, niche, image_path, Date, time, schedule, subtitle, link, content, authors_firstname, about_author, authors_lastname, idtype, is_favourite) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($query = $conn->prepare($sql)) {
        $query->bind_param("issssssisssss", $admin_id, $title, $niche, $convertedPath, $date, $time, $schedule, $subtitle, $link, $content, $author_firstname, $author_bio, $author_lastname, $idtype, $is_favourite);
        if ($query->execute()) {
            $post_id = $conn->insert_id;
            $post_link = "http://localhost/Sample-dynamic-website/pages/view_post.php?" . $idtype . "=" . $post_id . "";
            $content = "Admin " . $_SESSION['firstname'] . " added a new post (" . $post_type . ")";
            $forUser = 1;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Post Created Successfully";
            sendNewpostNotification($title, $post_link);
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
    $sqlTopics = "INSERT INTO topics (name, image_path, Date, time) VALUES (?,?,?,?)";
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
                    \$meta_name = \$meta_data['meta_name{\$i}'];
                    \$meta_content = \$meta_data['meta_content{\$i}'];
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
                    <div class='more_posts'>;
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
    $filePath = '../pages/' . $filename;
    if ($query = $conn->prepare($sqlTopics)) {
        $query->bind_param("ssss", $formattedTopicName, $category_image, $date, $time);
        if ($query->execute()) {
            $sqlMetaTitles = "INSERT INTO meta_titles (page_name, meta_name1, meta_content1) VALUES (?, ?, ?)";
            if ($query = $conn->prepare($sqlMetaTitles)) {
                $query->bind_param("sss", $formattedTopicName, $meta_name, $meta_content);
                if ($query->execute()) {
                    if (file_put_contents($filePath, $fileContent)) {
                        $content = "Admin " . $_SESSION['firstname'] . " added a new category";
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
function savePost2($title, $subtitle, $convertedPath, $content, $niche, $link, $schedule, $admin_id, $author_firstname, $author_lastname, $author_bio, $post_type)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $idtype = "";
    if ($post_type === "paid_posts") {
        $idtype = "id1";
    } elseif ($post_type === "posts") {
        $idtype = "id2";
    } elseif ($post_type === "news") {
        $idtype = "id3";
    } elseif ($post_type === "commentaries") {
        $idtype = "id4";
    } else {
        $idtype = "id5";
    }
    $is_favourite = 0;
    $sql = "INSERT INTO $post_type (admin_id, title, niche, post_image_url, Date, time, schedule, subtitle, link, content, authors_firstname, about_author, authors_lastname, idtype, is_favourite) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($query = $conn->prepare($sql)) {
        $query->bind_param("issssssisssssss", $admin_id, $title, $niche, $convertedPath, $date, $time, $schedule, $subtitle, $link, $content, $author_firstname, $author_bio, $author_lastname, $idtype, $is_favourite);
        if ($query->execute()) {
            $post_id = $conn->insert_id;
            $post_link = "http://localhost/Sample-dynamic-website/pages/view_post.php?" . $idtype . "=" . $post_id . "";
            $content = "Admin " . $_SESSION['firstname'] . " added a new post (" . $post_type . ")";
            $forUser = 1;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Post Created Successfully";
            sendNewpostNotification($title, $post_link);
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
function saveDraft($title, $subtitle, $imagePath, $content, $niche, $link, $admin_id)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("INSERT INTO unpublished_articles (admin_id, title, subtitle, image, link, Date, time, niche, content) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssss", $admin_id, $title, $subtitle, $imagePath, $link, $date, $time, $niche, $content);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " added a draft";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Draft Created Successfully";
        header('location: create_new/workspace.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: create_new/workspace.php');
    }
    $stmt->close();
}
//Review the below function
function updatePost($title, $subtitle, $imagePath, $content, $niche, $link, $admin_id, $author_firstname, $author_lastname, $author_bio, $tablename, $post_id)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("UPDATE $tablename SET title = ?, subtitle = ?, image_path = ?, content = ?, niche = ?, link = ?, admin_id = ?, Date = ?, time = ?, authors_firstname = ?, about_author = ?, authors_lastname = ? WHERE id = ?");
    $stmt->bind_param("ssssssssssssi", $title, $subtitle, $imagePath, $content, $niche, $link, $admin_id, $date, $time, $author_firstname, $author_bio, $author_lastname, $post_id);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " updated a post";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Post Updated Successfully";
        header('location: edit/post.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: edit/post.php');
    }
    $stmt->close();
}
function updatePages($content, $tablename)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $string = str_replace('_', ' ', $tablename);
    $stmt = "INSERT INTO $tablename (content, date, time) VALUES (?, ?, ?)";
    if ($query = $conn->prepare($stmt)) {
        $query->bind_param("sss", $content, $date, $time);
        if ($query->execute()) {
            $content = "Admin " . $_SESSION['firstname'] . " updated this website's '" . $string . "'";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "" . $string . " Updated Successfully";
            header('location: admin_homepage.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: admin_homepage.php');
        }
    } else {
        $error = $conn->errno . ' ' . $conn->error;
        echo $error;
        header('location: admin_homepage.php');
    }
}
function updateProfile($firstname, $lastname, $email, $username, $bio, $address1, $address2, $city, $state, $country, $countrycode, $mobile, $imagePath)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE admin_login_info SET firstname = ?, lastname = ?, username = ?, email = ?, image = ?, bio = ?, mobile = ?, country = ?, 	city = ?, state = ?, address1 = ?, address2 = ?, country_code = ?");
    $stmt->bind_param("sssssssssssss", $firstname, $lastname, $username, $email, $imagePath, $bio, $mobile, $country, $city, $state, $address1, $address2, $countrycode);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " updated his profile";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Profile Updated Successfully";
        header('location: edit/profile.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: edit/profile.php');
    }
    $stmt->close();
}
function updateEditorProfile($firstname, $password, $lastname, $email, $username, $bio, $address1, $address2, $city, $state, $country, $countrycode, $mobile, $imagePath, $id)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE editor SET firstname = ?, password = ?, lastname = ?, username = ?, email = ?, image = ?, bio = ?, mobile = ?, country = ?, 	city = ?, state = ?, address1 = ?, address2 = ?, country_code = ? WHERE id = ?");
    $stmt->bind_param("ssssssssssssssi", $firstname, $password, $lastname, $username, $email, $imagePath, $bio, $mobile, $country, $city, $state, $address1, $address2, $countrycode, $id);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " updated $username's profile";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Profile Updated Successfully";
        header('location: edit/user.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: edit/user.php');
    }
    $stmt->close();
}
function updateUserProfile($firstname, $lastname, $email, $role, $url, $bio, $imagePath, $id)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE otherwebsite_users SET firstname = ?, lastname = ?, email = ?, role = ?, image = ?, bio = ?, linkedin_url = ? WHERE id = ?");
    $stmt->bind_param("sssssssi", $firstname, $lastname, $email, $role, $imagePath, $bio, $url, $id);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " updated $firstname's profile";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Profile Updated Successfully";
        header('location: edit/user.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: edit/user.php');
    }
    $stmt->close();
}
function updateWriterProfile($firstname, $lastname, $email, $bio, $imagePath, $id)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE writer SET firstname = ?, lastname = ?, email = ?, image = ?, bio = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $firstname, $lastname, $email, $imagePath, $bio, $id);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " updated $firstname's profile";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Profile Updated Successfully";
        header('location: edit/user.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: edit/user.php');
    }
    $stmt->close();
}
function addEditor($firstname, $lastname, $email, $img, $password, $admin_id)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $idtype = "Editor";
    $encrypted_password = encryptPassword($password);
    $stmt = $conn->prepare("INSERT INTO editor (admin_id, email, image, password, firstname, lastname, date_joined, time_joined, idtype) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssss", $admin_id, $email, $img, $encrypted_password, $firstname, $lastname, $date, $time, $idtype);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " created a new user (Editor)";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "User Created Successfully";
        header('location: create_new/editor.php');
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: create_new/editor.php');
    }
    $stmt->close();
}
function addWriter($firstname, $lastname, $email, $imagePath, $admin_id)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $idtype = "Writer";
    $stmt = $conn->prepare("INSERT INTO writer (admin_id, firstname, lastname, email, image, date_joined, time_joined, idtype) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $admin_id, $firstname, $lastname, $email, $imagePath, $date, $time, $idtype);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " created a new user (Writer)";
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
        $content = "Admin " . $_SESSION['firstname'] . " created a new user";
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
        savePost2($title, $subtitle, $imagePath, $content, $niche, $link, $schedule, $admin_id, $author_firstname, $author_lastname, $author_bio, $post_type);
    } elseif (!empty($image1) && empty($image2)) {
        if (move_uploaded_file($_FILES['Post_Image1']['tmp_name'], $target)) {
            $imagePath = $target;
            $convertedPath = convertPath($imagePath);
            savePost1($title, $subtitle, $imagePath, $content, $niche, $link, $schedule, $admin_id, $author_firstname, $author_lastname, $author_bio, $post_type);
        }
    } else if (!empty($image1) && !empty($image2)) {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Please ensure the post's image is selected or it's url provided and not both.";
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
    if ($password === $confirm_pasword) {
        if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
            $imagePath = $target;
            updateProfile($firstname, $lastname, $email, $username, $bio, $address1, $address2, $city, $state, $country, $countrycode, $mobile, $imagePath);
        }
    }
}
if (isset($_POST['edit_profile_editor'])) {
    $id = $_POST['profile-id'];
    $firstname = $_POST['profile_firstname'];
    $password = $_POST['profile_password'];
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
    if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
        $imagePath = $target;
        $convertedPath = convertPath($imagePath);
        updateEditorProfile($firstname, $password, $lastname, $email, $username, $bio, $address1, $address2, $city, $state, $country, $countrycode, $mobile, $convertedPath, $id);
    }
}
if (isset($_POST['edit_profile_writer'])) {
    $id = $_POST['profile-id'];
    $firstname = $_POST['profile_firstname'];
    $lastname = $_POST['profile_lastname'];
    $bio = $_POST['profile_bio'];
    $email = $_POST['profile_email'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
        $imagePath = $target;
        $convertedPath = convertPath($imagePath);
        updateWriterProfile($firstname, $lastname, $email, $bio, $convertedPath, $id);
    }
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
    if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
        $imagePath = $target;
        $convertedPath = convertPath($imagePath);
        updateUserProfile($firstname, $lastname, $email, $role, $url, $bio, $convertedPath, $id);
    }
}
if (isset($_POST['create_draft'])) {
    $title = $_POST['Post_Title'];
    $subtitle = $_POST['Post_Sub_Title'];
    $content = $_POST['Post_content'];
    $niche = $_POST['Post_Niche'];
    $link = $_POST['Post_featured'];
    $image = $_FILES['Post_Image']['name'];
    $target = "../images/" . basename($image);
    if (move_uploaded_file($_FILES['Post_Image']['tmp_name'], $target)) {
        $imagePath = $target;
        $convertedPath = convertPath($imagePath);
        saveDraft($title, $subtitle, $convertedPath, $content, $niche, $link, $admin_id);
    }
}
if (isset($_POST['update_post'])) {
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
    if (move_uploaded_file($_FILES['Post_Image']['tmp_name'], $target)) {
        $imagePath = $target;
        $convertedPath = convertPath($imagePath);
        updatePost($title, $subtitle, $convertedPath, $content, $niche, $link, $admin_id, $author_firstname, $author_lastname, $author_bio, $tablename, $post_id);
    }
}
if (isset($_POST['create_page'])) {
    $topic_name = $_POST['topicName'];
    $image = $_FILES['topicImg']['name'];
    $target = "../images/" . basename($image);
    if (move_uploaded_file($_FILES['topicImg']['tmp_name'], $target)) {
        $imagePath = $target;
        $convertedPath = convertPath($imagePath);
        createCategory($topic_name, $convertedPath);
    }
}
if (isset($_POST['create_editor'])) {
    $firstname = $_POST['editor_firstname'];
    $lastname = $_POST['editor_lastname'];
    $email = $_POST['editor_email'];
    $password = $_POST['editor_password'];
    $confirm_pasword = $_POST['editor_password-confirm'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    if ($password === $confirm_pasword) {
        if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
            $imagePath = $target;
            $convertedPath = convertPath($imagePath);
            addEditor($firstname, $lastname, $email, $convertedPath, $password, $admin_id);
        }
    } else {
        echo "Passwords do not match";
        header('location: create_new/editor.php');
    }
}
if (isset($_POST['create_writer'])) {
    $firstname = $_POST['writer_firstname'];
    $lastname = $_POST['writer_lastname'];
    $email = $_POST['writer_email'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    if ($password === $confirm_pasword) {
        if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
            $imagePath = $target;
            $convertedPath = convertPath($imagePath);
            addWriter($firstname, $lastname, $email, $convertedPath, $admin_id);
        }
    }
}
if (isset($_POST['create_user'])) {
    $firstname = $_POST['user_firstname'];
    $lastname = $_POST['user_lastname'];
    $email = $_POST['user_email'];
    $role = $_POST['user_role'];
    $linkedin_url = $_POST['user_linkedin_url'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    if ($password === $confirm_pasword) {
        if (move_uploaded_file($_FILES['Img']['tmp_name'], $target)) {
            $imagePath = $target;
            $convertedPath = convertPath($imagePath);
            addUser($firstname, $lastname, $email,  $role, $linkedin_url, $convertedPath);
        }
    }
}
if (isset($_POST['edit_privacypolicy_btn'])) {
    $content = $_POST['privacy_policy'];
    $tablename = "privacy_policy";
    updatePages($content, $tablename);
}
if (isset($_POST['edit_aboutwebsite_btn'])) {
    $content = $_POST['about_website'];
    $tablename = "about_us";
    updatePages($content, $tablename);
}
if (isset($_POST['advertedit_btn'])) {
    $content = $_POST['advertise_content'];
    $tablename = "advertise_with_us";
    updatePages($content, $tablename);
}
if (isset($_POST['websiteterms_editbtn'])) {
    $content = $_POST['website_terms'];
    $tablename = "terms_of_service";
    updatePages($content, $tablename);
}
if (isset($_POST['workwithus_editbtn'])) {
    $content = $_POST['work_withus'];
    $tablename = "work_with_us";
    updatePages($content, $tablename);
}
if (isset($_POST['contactus_editbtn'])) {
    $content = $_POST['contactus_content'];
    $tablename = "contact_us";
    updatePages($content, $tablename);
}
if (isset($_POST['change_frontend_messages'])) {
    $cookie_consent = $_POST['cookie_consent'];
    $description = $_POST['description'];
    if (!empty($cookie_consent) && !empty($description)) {
        AddWebsiteMessages($cookie_consent, $description);
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "No Changes Made";
        header('location: edit/frontend_features.php');
    }
}
if (isset($_POST['add_resource'])) {
    $resource_type = $_POST['resource_type'];
    $resource_url = $_POST['resource_url'];
    $resource_image = $_FILES['resource_image']['name'];
    $resource_tmp_name = $_FILES['resource_image']['tmp_name'];
    $resource_folder = "../../images/" . $resource_image;
    if (move_uploaded_file($resource_tmp_name, $resource_folder)) {
        $imagePath = $resource_folder;
        $convertedPath = convertPath($imagePath);
        $resource_type = convertToUnreadable($resource_type);
        addResources($resource_type);
    } else {
        echo "No image uploaded.";
    }
}
if (isset($_POST['add_page'])) {
    $page_name = $_POST['page_name'];
    $page_name = convertToUnreadable($page_name);
    addPage($page_name);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $recordId = intval($_GET["id"]);
    $date = date('y-m-d');
    $time = date('H:i:s');
    file_put_contents("log.txt", "POST request received\n", FILE_APPEND);
    function updateFavicon($imagePath2)
    {
        global $conn;
        global $recordId;
        global $date;
        global $time;
        $stmt = $conn->prepare("UPDATE website_logo SET favicon_imagepath = ?, Date = ?, time = ?  WHERE id = ?");
        $stmt->bind_param("sssi", $imagePath2, $date, $time, $recordId);
        if ($stmt->execute()) {
            $content = "Admin " . $_SESSION['firstname'] . " updated this Website's Favicon";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            header('location: edit/frontend_features.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: edit/frontend_features.php');
        }
        $stmt->close();
    }
    function updateLogo($imagePath1)
    {
        global $conn;
        global $recordId;
        global $date;
        global $time;
        $stmt = $conn->prepare("UPDATE website_logo SET logo_imagepath = ?, Date = ?, time = ?  WHERE id = ?");
        $stmt->bind_param("sssi", $imagePath1, $date, $time, $recordId);
        if ($stmt->execute()) {
            $content = "Admin " . $_SESSION['firstname'] . " updated this Website's Logo";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            header('location: edit/frontend_features.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: edit/frontend_features.php');
        }
        $stmt->close();
    }
    function updateProfilePic($imagePath1)
    {
        global $conn;
        global $recordId;
        $stmt = $conn->prepare("UPDATE admin_login_info SET image = ? WHERE id = ?");
        $stmt->bind_param("si", $imagePath1, $recordId);
        if ($stmt->execute()) {
            $content = "Admin " . $_SESSION['firstname'] . " updated his/her Profile Picture";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            header('location: admin_homepage.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: admin_homepage.php');
        }
        $stmt->close();
    }
    if (isset($_FILES["website_logo"])) {
        $website_logo = $_FILES["website_logo"]["name"];
        $logo_tmp_name = $_FILES["website_logo"]["tmp_name"];
        $resource_folder1 = "../images/" . $website_logo;

        if (move_uploaded_file($logo_tmp_name, $resource_folder1)) {
            file_put_contents("log.txt", "Logo file moved successfully! Date: " . $date . ", Time: " . $time . "\n", FILE_APPEND);
            $convertedPath = convertPath($resource_folder1);
            updateLogo($convertedPath);
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error Moving Uploaded Files";
            header('location: edit/frontend_features.php');
        }
    }
    if (isset($_FILES["website_favicon"])) {
        $website_favicon = $_FILES["website_favicon"]["name"];
        $favicon_tmp_name = $_FILES["website_favicon"]["tmp_name"];
        $resource_folder2 = "../images/" . $website_favicon;

        if (move_uploaded_file($favicon_tmp_name, $resource_folder2)) {
            file_put_contents("log.txt", "Favicon file moved successfully! Date: " . $date . ", Time: " . $time . "\n", FILE_APPEND);
            $convertedPath = convertPath($resource_folder2);
            updateFavicon($convertedPath);
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error Moving Uploaded Files";
            header('location: edit/frontend_features.php');
        }
    }
    if (isset($_FILES["profile_pic"])) {
        $profile_pic = $_FILES["profile_pic"]["name"];
        $profile_tmp_name = $_FILES["profile_pic"]["tmp_name"];
        $resource_folder1 = "../images/" . $profile_pic;

        if (move_uploaded_file($profile_tmp_name, $resource_folder1)) {
            $convertedPath = convertPath($resource_folder1);
            file_put_contents("log.txt", "Profile Image file moved successfully! Date: " . $date . ", Time: " . $time . ", Path: " . $convertedPath . " \n", FILE_APPEND);
            updateProfilePic($convertedPath);
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error Moving Uploaded Files";
            header('location: edit/frontend_features.php');
        }
    }
}
