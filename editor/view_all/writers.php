<?php

/** @var \mysqli $conn */
global $conn;
session_start();
$language = $language ?? 'en';
$translations = $translations ?? [];
$editor_base_url = $editor_base_url ?? '';
include("../connect.php");
require("../init.php");
require('../../init.php');
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$translationFile = "../../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = [];
}
$posttype = 'Writers';
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../javascript/editor.js" async></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <link rel="stylesheet" href="../../css/editor.css" />
    <title><?php echo $translations['view_writers']; ?></title>
</head>

<body>
    <?php require("../extras/header2.php"); ?>
    <section class="sectioneer">
        <div class="posts_div1 postsdiv sectioneer_divcontainer">
            <div class="page_links">
                <a href="../editor_homepage.php"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['users']; ?></p> > <p><?php echo $translations['view_writers']; ?></p>
            </div>
            <div class="posts_header">
                <h1><?php echo $translations['writers']; ?></h1>
            </div>
            <div class="posts_divcontainer border-gradient-side-dark">
                <div id="search-results">
                    <?php
                    if (isset($_GET['query'])) {
                        $query = trim($_GET['query']);
                        if ($query !== "") {
                            $stmt = $conn->prepare("SELECT * FROM writer WHERE firstname LIKE ? OR lastname LIKE ? OR email LIKE ? OR bio LIKE ? ORDER BY id DESC LIMIT 5");
                            $searchTerm = "%" . $query . "%";
                            $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
                            if ($stmt->execute()) {
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    echo "<h3 class='posts_divcontainer_header'>You Searched For: $query <h3>";
                                    while ($row = $result->fetch_assoc()) {
                                        $date = $row['date_joined'];
                                        $time = $row['time_joined'];
                                        $formatted_time = date("g:i A", strtotime($time));
                                        $row['formatted_date'] = date("F j, Y", strtotime($date));
                                        echo "<div class='posts_divcontainer_subdiv editor_div'>
                                                <img src='" . $row["image"] . "' alt='Editor Image'/>
                                                <div class='editor_div-body'>
                                                    <h3 class='posts_divcontainer_header'>" . $row["firstname"] . " " . $row["lastname"] . "</h3>
                                                    <div class='posts_divcontainer_subdiv2'>
                                                        <p class='posts_divcontainer_p'><span>$translations[email]: </span>" . $row["email"] . "</p>
                                                        <p class='posts_divcontainer_p'><span> $translations[date_joined]: </span>" . $row["formatted_date"] . "</p>
                                                        <p class='posts_divcontainer_p'><span> $translations[time]: </span>$formatted_time</p>
                                                    </div>
                                                    <div class='posts_delete_edit'>
                                                        <a class='users_edit' href='../edit/user.php?id=" . $row['id'] . "&usertype=Writer'>
                                                            <i class='fa fa-pencil' aria-hidden='true'></i>
                                                        </a>
                                                        <a class='users_delete' onclick='confirmDeleteWriter(" . $row['id'] . ")'>
                                                            <i class='fa fa-trash' aria-hidden='true'></i>
                                                         </a>
                                                    </div>
                                                </div>
                                            </div>";
                                    }
                                } else {
                                    echo "<h1 class='posts_divcontainer_header'>No results found for ' $query '</h1>";
                                }
                            }
                        }
                        exit;
                    }
                    ?>
                </div>
                <?php
                $select_allposts = "SELECT id, email, image, firstname, lastname, time_joined, DATE_FORMAT(date_joined, '%M %d, %Y') as formatted_date FROM writer ORDER BY id DESC LIMIT 100";
                $select_allposts_result = $conn->query($select_allposts);
                if ($select_allposts_result->num_rows > 0) {
                    while ($row = $select_allposts_result->fetch_assoc()) {
                        $time = $row['time_joined'];
                        $formatted_time = date("g:i A", strtotime($time));
                        echo "<div class='posts_divcontainer_subdiv editor_div'>
                                    <img src='" . $row["image"] . "' alt='Editor Image'/>
                                    <div class='editor_div-body'>
                                        <h3 class='posts_divcontainer_header'>" . $row["firstname"] . " " . $row["lastname"] . "</h3>
                                        <div class='posts_divcontainer_subdiv2'>
                                            <p class='posts_divcontainer_p'><span>$translations[email]: </span>" . $row["email"] . "</p>
                                            <p class='posts_divcontainer_p'><span> $translations[date_joined]: </span>" . $row["formatted_date"] . "</p>
                                            <p class='posts_divcontainer_p'><span> $translations[time]: </span>$formatted_time</p>
                                        </div>
                                        <div class='posts_delete_edit'>
                                            <a class='users_edit' href='../edit/user.php?id=" . $row['id'] . "&usertype=Writer'>
                                                <i class='fa fa-pencil' aria-hidden='true'></i>
                                            </a>
                                            <a class='users_delete' onclick='confirmDeleteWriter(" . $row['id'] . ")'>
                                                <i class='fa fa-trash' aria-hidden='true'></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>";
                    };
                };

                ?>
            </div>
    </section>
    <script src="sweetalert2.all.min.js"></script>
    <script>
        function submitSearch() {
            var query = document.getElementById("search-bar").value;
            if (query.trim() !== "") {
                fetch("writers.php?query=" + encodeURIComponent(query))
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById("search-results").innerHTML = data;
                        document.getElementById("search-results").style.display = "block";
                    })
                    .catch(error => console.error("Error fetching results:", error));
            } else {
                document.getElementById("search-results").style.display = "none";
            }
        }
    </script>
    <script src="sweetalert2.all.min.js"></script>
    <script>
        var messageType = "<?= $_SESSION['status_type'] ?>";
        var messageText = "<?= $_SESSION['status'] ?>";
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
</body>

</html>