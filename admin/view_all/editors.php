<?php

/** @var \mysqli $conn */
global $conn;
session_start();
$language = $language ?? 'en';
$translations = $translations ?? [];
$base_url = $base_url ?? '';
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
$posttype = 'Editors';
$userFirstname = $_SESSION['firstname'];
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
    <link rel="stylesheet" href="../../css/admin.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../javascript/admin.js" defer></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['view_editors']; ?></title>
</head>

<body>
    <?php require("../extras/header2.php"); ?>
    <section class="sectioneer">
        <div class="posts_div1 postsdiv sectioneer_divcontainer">
            <div class="page_links">
                <a href="<?php echo $base_url . 'admin_homepage.php'; ?>"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['users']; ?></p> > <p><?php echo $translations['view_editors']; ?></p>
            </div>
            <div class="posts_header">
                <h1><?php echo $translations['editors']; ?></h1>
            </div>
            <div class="posts_divcontainer border-gradient-side-dark">
                <div id="search-results">
                    <?php
                    if (isset($_GET['query'])) {
                        $query = trim($_GET['query']);
                        if ($query !== "") {
                            $stmt = $conn->prepare("SELECT * FROM editor WHERE firstname LIKE ? OR lastname LIKE ? OR username LIKE ? OR email LIKE ? OR bio LIKE ? ORDER BY id DESC LIMIT 5");
                            $searchTerm = "%" . $query . "%";
                            $stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
                            if ($stmt->execute()) {
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    echo "<h3 class='posts_divcontainer_header'>You Searched For: $query <h3>";
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<div class='posts_divcontainer_subdiv editor_div'>
                                            <img src='" . $row["image"] . "' alt='Editor Image'/>
                                            <div class='editor_div-body'>
                                                <h3 class='posts_divcontainer_header'>" . $row["firstname"] . " " . $row["lastname"] . " ( " . $row["username"] . " )</h3>
                                                <div class='posts_divcontainer_subdiv2'>
                                                    <p class='posts_divcontainer_p'><span> $translations[email]: </span>" . $row["email"] . "</p>
                                                    <p class='posts_divcontainer_p'><span> $translations[nationality]: </span>" . $row["country"] . "</p>
                                                </div>
                                                <form action='../demote_editor.php' method='POST' class='posts_delete_edit'>
                                                    <input type='hidden' name='editor_id' value='" . $row["id"] . "'>
                                                    <button type='submit' class='promote_button users_delete btn'>$translations[demote_message]</button>
                                                </form>
                                                <div class='posts_delete_edit'>
                                                    <a class='users_edit' href='../edit/user.php?id=" . $row["id"] . "&usertype=Editor'>
                                                        <i class='fa fa-pencil' aria-hidden='true'></i>
                                                    </a>
                                                    <a class='users_delete' onclick='confirmDeleteEditor(" . $row["id"] . ", \"" . addslashes($userFirstname) . "\")'>
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
                $select_allposts = "SELECT id, username, email, image, firstname, lastname, country FROM editor ORDER BY id DESC LIMIT 100";
                $select_allposts_result = $conn->query($select_allposts);
                if ($select_allposts_result->num_rows > 0) {
                    while ($row = $select_allposts_result->fetch_assoc()) {
                        echo "<div class='posts_divcontainer_subdiv editor_div'>
                                    <img src='" . $row["image"] . "' alt='Editor Image'/>
                                    <div class='editor_div-body'>
                                        <h3 class='posts_divcontainer_header'>" . $row["firstname"] . " " . $row["lastname"] . " ( " . $row["username"] . " )</h3>
                                        <div class='posts_divcontainer_subdiv2'>
                                            <p class='posts_divcontainer_p'><span> $translations[email]: </span>" . $row["email"] . "</p>
                                            <p class='posts_divcontainer_p'><span> $translations[nationality]: </span>" . $row["country"] . "</p>
                                        </div>
                                        <form action='../demote_editor.php' method='POST' class='posts_delete_edit'>
                                            <input type='hidden' name='editor_id' value='" . $row["id"] . "'>
                                            <button type='submit' class='promote_button users_delete btn'>$translations[demote_message]</button>
                                        </form>
                                        <div class='posts_delete_edit'>
                                            <a class='users_edit' href='../edit/user.php?id=" . $row["id"] . "&usertype=Editor'>
                                                <i class='fa fa-pencil' aria-hidden='true'></i>
                                            </a>
                                            <a class='users_delete' onclick='confirmDeleteEditor(" . $row["id"] . ", \"" . addslashes($userFirstname) . "\")'>
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