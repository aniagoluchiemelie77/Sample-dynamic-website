<?php
session_start();
include("../connect.php");
require("../init.php");
require('../../init.php');
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$translationFile = "../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = []; // Initialize as empty array to avoid undefined variable errors
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../admin.js" defer></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['news']; ?></title>
</head>

<body>
    <?php require("../extras/header2.php"); ?>
    <section class="sectioneer">
        <div class="posts_div1 postsdiv sectioneer_divcontainer">
            <div class="page_links">
                <a href="../admin_homepage.php"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['posts']; ?></p> > <p> <?php echo $translations['news']; ?></p>
            </div>
            <div class="posts_header">
                <h1><?php echo $translations['news']; ?></h1>
            </div>
            <div class="posts_divcontainer border-gradient-side-dark">
                <?php
                $select_allnews = "SELECT id, admin_id, editor_id, title, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date, authors_firstname, authors_lastname FROM news ORDER BY id DESC LIMIT 100";
                $select_allnews_result = $conn->query($select_allnews);
                if ($select_allnews_result->num_rows > 0) {
                    $author_firstname = "";
                    $author_lastname = "";
                    $role = "";
                    while ($row = $select_allnews_result->fetch_assoc()) {
                        if (!empty($row['admin_id'])) {
                            $admin_id = $row['admin_id'];
                            $sql_admin = "SELECT id, firstname, lastname FROM admin_login_info WHERE id = $admin_id";
                            $result_admin = $conn->query($sql_admin);
                            if ($result_admin->num_rows > 0) {
                                $admin = $result_admin->fetch_assoc();
                                $author_firstname = $admin['firstname'];
                                $author_lastname = $admin['lastname'];
                                $role = "Admin";
                            }
                        } elseif (!empty($row['editor_id'])) {
                            $editor_id = $row['editor_id'];
                            $sql_editor = "SELECT id, firstname, lastname FROM editor WHERE id = $editor_id";
                            $result_editor = $conn->query($sql_editor);
                            if ($result_editor->num_rows > 0) {
                                $editor = $result_editor->fetch_assoc();
                                $author_firstname = $editor['firstname'];
                                $author_lastname = $editor['lastname'];
                                $role = "Editor";
                            }
                        } else {
                            $author_firstname = $row['author_firstname'];
                            $author_lastname = $row['author_lastname'];
                            $role = "Contributing Writer";
                        }
                        $time = $row['time'];
                        $formatted_time = date("g:i A", strtotime($time));
                        echo "<div class='posts_divcontainer_subdiv'>
                                    <h3 class='posts_divcontainer_header'>" . $row["title"] . "</h3>
                                    <div class='posts_divcontainer_subdiv2'>
                                        <p class='posts_divcontainer_p'><span> $translations[published_posts_i]: </span>$author_firstname $author_lastname ( $role )</p>
                                    </div>
                                    <div class='posts_divcontainer_subdiv3'>
                                        <p class='posts_divcontainer_subdiv_p'><span>$translations[published_date]: </span>" . $row["formatted_date"] . "</p> 
                                        <p class='posts_divcontainer_subdiv_p'><span> $translations[published_time]: </span>" . $formatted_time . "</p> 
                                    </div>
                                    <div class='posts_delete_edit'>
                                        <a class='users_edit' href='../edit/post.php?id4=" . $row["id"] . "&title=" . $row["title"] . "'>
                                            <i class='fa fa-pencil' aria-hidden='true'></i>
                                        </a>
                                        <a class='users_delete' onclick='confirmDeleteN2(" . $row['id'] . ")'>
                                            <i class='fa fa-trash' aria-hidden='true'></i>
                                        </a>
                                    </div>
                                </div>";
                    };
                };

                ?>
            </div>
        </div>
    </section>
</body>

</html>