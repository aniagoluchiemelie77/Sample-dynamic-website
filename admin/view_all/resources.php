<?php
session_start();
include("../connect.php");
require('../../init.php');
$resource_name = isset($_GET['resource_name']) ? $_GET['resource_name'] : null;
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
$posttype = $resource_name;
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
    <script src='../admin.js' async></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title>Edit Resources (<?php echo $resource_name; ?>)</title>
</head>

<body>
    <?php require("../extras/header2.php"); ?>
    <section class="sectioneer">
        <div class="posts_div1 postsdiv sectioneer_divcontainer">
            <div class="page_links">
                <a href="../admin_homepage.php"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['posts']; ?></p> > <p><?php echo $translations['view_posts2']; ?></p>
            </div>
            <div class="posts_header">
                <h1> <?php echo $resource_name; ?></h1>
            </div>
            <div class="posts_divcontainer border-gradient-side-dark">
                <div id="search-results">
                    <?php
                    if (isset($_GET['query'])) {
                        $query = trim($_GET['query']);
                        if ($query !== "") {
                            $stmt = $conn->prepare("SELECT * FROM $resource_name WHERE title LIKE ? OR niche LIKE ? OR name LIKE ? ORDER BY id DESC LIMIT 5");
                            $searchTerm = "%" . $query . "%";
                            $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
                            if ($stmt->execute()) {
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    echo "<h3 class='posts_divcontainer_header'>You Searched For: $query <h3>";
                                    while ($row = $result->fetch_assoc()) {
                                       $formatted_date = date("M d, Y", strtotime($row['date_added']));
                        $time = $row['time_added'];
                        $formatted_time = date("g:i A", strtotime($time));
                        $formId = "favouriteForm_" . $row["id"];
                        echo "<div class='posts_divcontainer_subdiv post' data-post-id='" . $row["id"] . "'>
                                    <h3 class='posts_divcontainer_header'>" . $row["title"] . "</h3>
                                    <h2 class='posts_divcontainer_header2'>" . $row["niche"] . "</h2>
                                    <h2 class='posts_divcontainer_header2'>" . $row["resource_path"] . "</h2>
                                    <div class='posts_divcontainer_subdiv3'>
                                        <p class='posts_divcontainer_subdiv_p'><span> $translations[published_date]: </span>$formatted_date</p> 
                                        <p class='posts_divcontainer_subdiv_p'><span> $translations[published_time]: </span>$formatted_time</p> 
                                    </div>
                                    <div class='posts_delete_edit'>
                                        <a class='users_edit' href='../edit/resource.php?id=" . $row["id"] . "&resource_name=$resource_name'>
                                            <i class='fa fa-pencil' aria-hidden='true'></i>
                                        </a>
                                        <a class='users_delete' onclick='confirmDeleteResource(" . $row['id'] . ", \"" . htmlspecialchars(removeUnderscore2($row['resource_name']), ENT_QUOTES) . "\")'>
                                            <i class='fa fa-trash' aria-hidden='true'></i>
                                        </a>
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
                $selectall_resources = "SELECT * FROM $resource_name ORDER BY id DESC LIMIT 100";
                $selectall_resources_result = $conn->query($selectall_resources);
                if ($selectall_resources_result->num_rows > 0) {
                    while ($row = $selectall_resources_result->fetch_assoc()) {
                        $formatted_date = date("M d, Y", strtotime($row['date_added']));
                        $time = $row['time_added'];
                        $formatted_time = date("g:i A", strtotime($time));
                        $formId = "favouriteForm_" . $row["id"];
                        echo "<div class='posts_divcontainer_subdiv post' data-post-id='" . $row["id"] . "'>
                                    <h3 class='posts_divcontainer_header'>" . $row["title"] . "</h3>
                                    <h2 class='posts_divcontainer_header2'>Niche: " . $row["niche"] . "</h2>
                                    <h2 class='posts_divcontainer_header2'>Resource Path: " . $row["resource_path"] . "</h2>
                                    <div class='posts_divcontainer_subdiv3'>
                                        <p class='posts_divcontainer_subdiv_p'><span> $translations[published_date]: </span>$formatted_date</p> 
                                        <p class='posts_divcontainer_subdiv_p'><span> $translations[published_time]: </span>$formatted_time</p> 
                                    </div>
                                    <div class='posts_delete_edit'>
                                        <a class='users_edit' href='../edit/resource.php?id=" . $row["id"] . "&resource_name=$resource_name'>
                                            <i class='fa fa-pencil' aria-hidden='true'></i>
                                        </a>
                                        <a class='users_delete' onclick='confirmDeleteResource(" . $row['id'] . ", \"" . htmlspecialchars(removeUnderscore2($row['resource_path']), ENT_QUOTES) . "\")'>
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
    <script>
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
        const ToastMessage = Swal.mixin({
            toast: true,
            position: 'top-end',
            timer: 4000,
            timerProgressBar: true,
            showConfirmButton: false,
            iconColor: '#fff',
            customClass: {
                popup: 'rounded-xl shadow-xl text-white bg-zinc-800 border border-gray-600'
            },
            showClass: {
                popup: 'animate__animated animate__fadeInRight'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutRight'
            }
        });
        if (typeof messageType !== "undefined" && messageText.trim() !== "") {
            const iconColors = {
                'Error': '#e74c3c',
                'Success': '#2ecc71',
                'Info': '#3498db'
            };
            ToastMessage.fire({
                icon: messageType.toLowerCase(),
                title: messageText,
                iconColor: iconColors[messageType] || '#3498db'
            });
        }
        <?php unset($_SESSION['status_type']); ?>
        <?php unset($_SESSION['status']); ?>
    </script>
</body>

</html>