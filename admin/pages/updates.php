<?php
session_start();
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
$user = $_SESSION['firstname'];
$read_updates = "UPDATE updates SET status = 'read' WHERE status = 'unread'";
$conn->query($read_updates);
$posttype = 'Updates';
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
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['user_activities']; ?></title>
</head>

<body>
    <?php require("../extras/header2.php"); ?>
    <section class="sectioneer">
        <div class="posts_div1 postsdiv sectioneer_divcontainer">
            <div class="page_links">
                <a href="<?php echo $base_url . 'admin_homepage.php'; ?>"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['profile']; ?></p> > <p><?php echo $translations['user_activities']; ?></p>
            </div>
            <div class="posts_header">
                <h1><?php echo $translations['user_activities']; ?></h1>
            </div>
            <div class="posts_divcontainer border-gradient-side-dark">
                <div id="search-results">
                    <?php
                    if (isset($_GET['query'])) {
                        $query = trim($_GET['query']);
                        if ($query !== "") {
                            $stmt = $conn->prepare("SELECT * FROM updates WHERE content LIKE ? ORDER BY id DESC LIMIT 5");
                            $searchTerm = "%" . $query . "%";
                            $stmt->bind_param("s", $searchTerm);
                            if ($stmt->execute()) {
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    echo "<h3 class='posts_divcontainer_header'>You Searched For: $query <h3>";
                                    while ($row = $result->fetch_assoc()) {
                                        $time = $row['time'];
                                        $date = $row['Date'];
                                        $row['formatted_date'] = date("F j, Y", strtotime($date));
                                        $formatted_time = date("g:i A", strtotime($time));
                                        $message = personalizeMessageAdmin($row['content'], $user);
                                        echo "<div class='posts_divcontainer_subdiv'>
                                            <h3 class='posts_divcontainer_header'>$message</h3>
                                            <div class='posts_divcontainer_subdiv3'>
                                                <p class='posts_divcontainer_subdiv_p'><span> $translations[date]: </span>" . $row["formatted_date"] . "</p> 
                                                <p class='posts_divcontainer_subdiv_p'><span> $translations[time]: </span>" . $formatted_time . "</p> 
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
                $select_commentaries = "SELECT id, content, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM updates ORDER BY id DESC LIMIT 100";
                $select_commentaries_result = $conn->query($select_commentaries);
                if ($select_commentaries_result->num_rows > 0) {
                    while ($row = $select_commentaries_result->fetch_assoc()) {
                        $time = $row['time'];
                        $formatted_time = date("g:i A", strtotime($time));
                        $message = personalizeMessageAdmin($row['content'], $user);
                        echo "<div class='posts_divcontainer_subdiv'>
                                    <h3 class='posts_divcontainer_header'>$message</h3>
                                    <div class='posts_divcontainer_subdiv3'>
                                        <p class='posts_divcontainer_subdiv_p'><span> $translations[date]: </span>" . $row["formatted_date"] . "</p> 
                                        <p class='posts_divcontainer_subdiv_p'><span> $translations[time]: </span>" . $formatted_time . "</p> 
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
                fetch("updates.php?query=" + encodeURIComponent(query))
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
</body>

</html>