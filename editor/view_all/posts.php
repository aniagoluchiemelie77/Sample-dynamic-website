<?php
session_start();
include("../connect.php");
require('../../init.php');
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
require("../init.php");
$translationFile = "../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = []; // Initialize as empty array to avoid undefined variable errors
}
$posttype = 'Posts';
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
    <link rel="stylesheet" href="../editor.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src='../editor.js' async></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['view_posts']; ?></title>
</head>

<body>
    <?php require("../extras/header2.php"); ?>
    <section class="sectioneer">
        <div class="posts_div1 postsdiv sectioneer_divcontainer">
            <div class="page_links">
                <a href="../editor_homepage.php"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['posts']; ?></p> > <p><?php echo $translations['view_posts2']; ?></p>
            </div>
            <div class="posts_header">
                <h1> <?php echo $translations['published_posts']; ?></h1>
            </div>
            <div class="posts_divcontainer border-gradient-side-dark">
                <div id="search-results">
                    <?php
                    if (isset($_GET['query'])) {
                        $query = trim($_GET['query']);
                        if ($query !== "") {
                            $stmt = $conn->prepare("SELECT * FROM posts WHERE title LIKE ? OR subtitle LIKE ? OR content LIKE ? OR authors_firstname LIKE ? OR authors_lastname LIKE ? ORDER BY id DESC LIMIT 5");
                            $searchTerm = "%" . $query . "%";
                            $stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
                            if ($stmt->execute()) {
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    echo "<h3 class='posts_divcontainer_header'>You Searched For: $query <h3>";
                                    while ($row = $result->fetch_assoc()) {
                                        $author_firstname = "";
                                        $author_lastname = "";
                                        $role = "";
                                        $formatted_date = date("M d, Y", strtotime($row['Date']));
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
                                        echo "
                                        <div class='posts_divcontainer_subdiv post' data-post-id='" . $row["id"] . "'>
                                    <h3 class='posts_divcontainer_header'>" . $row["title"] . "</h3>
                                    <div class='posts_divcontainer_subdiv2'>
                                        <p class='posts_divcontainer_p'><span>$translations[published_posts_i]: </span> $author_firstname $author_lastname ( $role )</p>
                                    </div>
                                    <div class='posts_divcontainer_subdiv3'>
                                        <p class='posts_divcontainer_subdiv_p'><span> $translations[published_date]: </span> $formatted_date</p> 
                                        <p class='posts_divcontainer_subdiv_p'><span> $translations[published_time]: </span>" . $formatted_time . "</p> 
                                    </div>
                                    <div class='posts_delete_edit'>
                                        <a class='users_edit' href='../edit/post.php?id2=" . $row["id"] . "&title=" . $row["title"] . "'>
                                            <i class='fa fa-pencil' aria-hidden='true'></i>
                                        </a>
                                        <a class='users_delete' onclick='confirmDeleteP2(" . $row['id'] . ")'>
                                            <i class='fa fa-trash' aria-hidden='true'></i>
                                        </a>
                                        <form id='favouriteForm' action='../script.php' method='POST'>
                                            <input type='hidden' name='post_id' value='" . $row['id'] . "'>
                                            <input type='hidden' name='isfavourite' value='" . $row['is_favourite'] . "'>
                                            <button type='submit' class='users_delete2 star'>
                                                <i class='fa fa-star' aria-hidden='true'></i>
                                            </button>
                                        </form>
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
                $select_allposts = "SELECT id, title, admin_id, editor_id, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date, authors_firstname, authors_lastname, is_favourite FROM posts ORDER BY id DESC LIMIT 100";
                $select_allposts_result = $conn->query($select_allposts);
                if ($select_allposts_result->num_rows > 0) {
                    $author_firstname = "";
                    $author_lastname = "";
                    $role = "";
                    while ($row = $select_allposts_result->fetch_assoc()) {
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
                        echo "<div class='posts_divcontainer_subdiv post' data-post-id='" . $row["id"] . "'>
                                    <h3 class='posts_divcontainer_header'>" . $row["title"] . "</h3>
                                    <div class='posts_divcontainer_subdiv2'>
                                        <p class='posts_divcontainer_p'><span>$translations[published_posts_i]: </span> $author_firstname $author_lastname ( $role )</p>
                                    </div>
                                    <div class='posts_divcontainer_subdiv3'>
                                        <p class='posts_divcontainer_subdiv_p'><span> $translations[published_date]: </span>" . $row["formatted_date"] . "</p> 
                                        <p class='posts_divcontainer_subdiv_p'><span> $translations[published_time]: </span>" . $formatted_time . "</p> 
                                    </div>
                                    <div class='posts_delete_edit'>
                                        <a class='users_edit' href='../edit/post.php?id2=" . $row["id"] . "&title=" . $row["title"] . "'>
                                            <i class='fa fa-pencil' aria-hidden='true'></i>
                                        </a>
                                        <a class='users_delete' onclick='confirmDeleteP2(" . $row['id'] . ")'>
                                            <i class='fa fa-trash' aria-hidden='true'></i>
                                        </a>
                                        <form id='favouriteForm' action='../script.php' method='POST'>
                                            <input type='hidden' name='post_id' value='" . $row['id'] . "'>
                                            <input type='hidden' name='isfavourite' value='" . $row['is_favourite'] . "'>
                                            <button type='submit' class='users_delete2 star'>
                                                <i class='fa fa-star' aria-hidden='true'></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>";
                    };
                };

                ?>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('favouriteForm');
            const starButton = form.querySelector('.star');
            starButton.addEventListener('click', function(event) {
                const isFavouriteInput = form.querySelector('input[name="isfavourite"]');
                isFavouriteInput.value = isFavouriteInput.value === '0' ? '1' : '0';
                if (isFavouriteInput.value === '1') {
                    starButton.classList.remove('users_delete2');
                    starButton.classList.add('favourite');
                } else {
                    starButton.classList.remove('favourite');
                    starButton.classList.add('users_delete2');
                }
            });
            const isFavouriteInput = form.querySelector('input[name="isfavourite"]');
            if (isFavouriteInput.value === '1') {
                starButton.classList.add('favourite');
            } else {
                starButton.classList.add('users_delete2');
            }
        });

        function submitSearch() {
            var query = document.getElementById("search-bar").value;
            if (query.trim() !== "") {
                fetch("posts.php?query=" + encodeURIComponent(query))
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById("search-results").innerHTML = data;
                        document.getElementById("search-results").style.display = "block";

                        // Ensure other sections remain visible
                        document.querySelector(".posts_divcontainer").style.display = "block";
                    })
                    .catch(error => console.error("Error fetching results:", error));
            } else {
                document.getElementById("search-results").style.display = "none";
            }
        }
    </script>
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
</body>

</html>