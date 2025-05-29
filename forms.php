<?php
require('connect.php');
require('init.php');
$query = isset($_POST['query']) ? $_POST['query'] : '';
$offset = intval($_POST['offset']);
$email = isset($_GET['email']) ? $_GET['email'] : null;
$limit = intval($_POST['limit']);
$query = $conn->real_escape_string($query);
$tables = ['paid_posts', 'posts', 'news', 'commentaries', 'press_releases'];
$results = [];
foreach ($tables as $table) {
    $sql = "SELECT * FROM $table WHERE title LIKE '%$query%' OR content LIKE '%$query%' OR subtitle LIKE '%$query%' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $results[] = [
                'id' => $row['id'],
                'niche' => $row['niche'],
                'image' => $row['image_path'],
                'title' => $row['title'],
                'content' => $row['content'],
                'table' => $table
            ];
        }
    }
}
if (!empty($results)) {
    foreach ($results as $result) {
        echo "<h2> You searched for: " . $result['title'] . " " . $result['subtitle'] . "</h2>";
        echo "<div class='section2__div1__div1 normal-divs'>
                <a class='normal-divs__subdiv' href='pages/view_post.php? id2=" . $row["id"] . "'>
                    <img src='" . $result['image_path'] . "' alt='article image'>
                    <div class='normal-divs__subdiv__div'>
                        <h1 class='normal-divs__header'>" . $result['niche'] . "</h1>
                        <h2 class='normal-divs__title'>" . $result['title'] . "</h2>
                        <div>
                            <p class='normal-divs__releasedate firstp'>$date</p>
                            <p class='normal-divs__releasedate'><i class='fa fa-clock' aria-hidden='true'></i> $readingTime</p>
                        </div>
                    </div>
                </a>
                <div class='normal-divs__subdiv2'>
                    <img src='$author_image' alt='article image'>
                    <p class='normal-divs__subdiv2__p'>By <span>Aniagolu Chiemelie </span><span>$role</span></p>
                </div>
            </div>";
    }
} else {
    echo "No results found.";
};
if ($email) {
    $unsubscribe = unsubscribe($email);
    $_SESSION['status_type'] = $unsubscribe['status_type'];
    $_SESSION['status'] = $unsubscribe['status'];
}
?>