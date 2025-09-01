<?php

                            /** @var \mysqli $conn */
                            global $conn;
session_start();
require('../connect.php');
require('../init.php');
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
$page_name = "commentaries";
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
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
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/main.css" />
    <script src='../javascript/main.js' defer></script>
    <link rel="icon" href="../<?php echo $favicon; ?>" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Commentaries</title>
</head>

<body id="container">
    <?php require("../includes/header2.php"); ?>
    <div class="body_container">
        <div class="body_left">
            <div class="page_links">
                <a href="../">Home</a> > <p>Commentaries</p>
            </div>
            <h1 class='bodyleft_header3'>Search Commentaries</h1>
            <form class="header_searchbar2 search_input" id="search_form" action="commentaries.php" method="get">
                <input type="text" name="query" id="search-bar" placeholder="Search.." />
                <button class="fa fa-search" type="submit" onclick="submitSearch()"></button>
            </form>
            <div id="search-results">
                <div id="results-container" class="more_posts">
                    <?php
                    if (isset($_GET['query'])) {
                        $query = trim($_GET['query']);
                        $results = [];
                        if ($query !== "") {
                            $sql = "SELECT id, title, niche, content, image_path, Date FROM commentaries WHERE (title LIKE ? OR subtitle LIKE ? OR content LIKE ?) ORDER BY id DESC LIMIT 3";
                            $stmt = $conn->prepare($sql);
                            $searchTerm = "%" . $query . "%";
                            $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
                            $stmt->execute();
                            $stmt->bind_result($id, $title, $niche, $content, $image, $date);
                            while ($stmt->fetch()) {
                                $results[] = [
                                    'id' => $id,
                                    'title' => $title,
                                    'niche' => $niche,
                                    'content' => $content,
                                    'image_path' => $image,
                                    'Date' => $date,
                                    'table' => 'commentaries',
                                    'posttype' => 4
                                ];
                            }
                            if (empty($results)) {
                                echo "<h1>No results found for '<strong>" . htmlspecialchars($query) . "</strong>'.</h1>";
                            } else {
                                foreach ($results as $result) {
                                    $max_length = 50;
                                    $id = $result['id'];
                                    $image = $result['image_path'];
                                    $title = $result["title"];
                                    $date = $result["Date"];
                                    $niche = $result['niche'];
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
                                    echo "<a class='more_posts_subdiv' href='view_post.php?id5=$id'>
                                            <img src='$image' alt = 'Post's Image'/>
                                            <div class='more_posts_subdiv_subdiv'>
                                                <h1>$title</h1>
                                                <span>$formattedDate</span>
                                                <span>$readingTime</span>
                                            </div>
                                            <p class='posts_div_niche'>$niche</p>
                                        </a>";
                                }
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>Latest Commentaries</h1>
            <div class='more_posts'>;
                <?php
                $selectnewsposts_sql = "SELECT id, title, niche, content, image_path, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM commentaries ORDER BY id DESC LIMIT 12";
                $selectnewsposts_result = $conn->query($selectnewsposts_sql);
                if ($selectnewsposts_result->num_rows > 0) {
                    $i = 0;
                    while ($row = $selectnewsposts_result->fetch_assoc()) {
                        $id = $row["id"];
                        $i++;
                        $title = $row["title"];
                        $niche = $row["niche"];
                        $image = $row["image_path"];
                        $date = $row["formatted_date"];
                        $content = $row["content"];
                        $readingTime = calculateReadingTime($row['content']);
                        echo "<a class='more_posts_subdiv' href='view_post.php?id5=$id'>
                                    <img src='$image' alt = 'Post's Image'/>
                                    <div class='more_posts_subdiv_subdiv'>
                                        <h1>$title</h1>
                                        <span>$date</span>
                                        <span>$readingTime</span>
                                    </div>
                                    <p class='posts_div_niche'>$niche</p>
                                </a>";
                    }
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
    <script>
        const sidebar = document.getElementById('sidebar');
        const menubtn = document.getElementById('searchicon');
        const closeMenuBtn = document.querySelector('.sidebarbtn');
        var messageType = "<?= $_SESSION['status_type'] ?? ' ' ?>";
        var messageText = "<?= $_SESSION['status'] ?? ' ' ?>";

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

        function submitSearch() {
            var query = document.getElementById("search-bar").value;
            if (query.trim() !== "") {
                fetch("commentaries.php?query=" + encodeURIComponent(query))
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById("results-container").innerHTML = data;
                    })
                    .catch(error => console.error("Error fetching results:", error));
            } else {
                document.getElementById("search-results").style.display = "none";
            }
        }
    </script>
</body>

</html>