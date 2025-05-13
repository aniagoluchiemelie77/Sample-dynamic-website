<?php
$selectcommentaries = "SELECT id, content, admin_id, editor_id, authors_firstname, authors_lastname, authors_image, about_author, title, niche, image_path, post_image_url, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date, DATE_FORMAT(schedule, '%M %d, %Y') as formatted_date2 FROM commentaries ORDER BY id DESC LIMIT 8";
    $selectcommentaries_result = $conn->query($selectcommentaries);
    if ($selectcommentaries_result->num_rows > 0) {
        if (!function_exists('calculateReadingTime')) {
            function calculateReadingTime($content) {
                $wordCount = str_word_count(strip_tags($content));
                $minutes = floor($wordCount / 200);
                return $minutes  . ' mins read ';
            }
        }
        echo"<div class='sidebar_divs_container'>
                    <div class='section2__div1__header headers'>
                        <h2>Latest Commentaries</h2>
                    </div>";
        while($row = $selectcommentaries_result->fetch_assoc()) {
        $max_length = 40;
            $max_length2 = 60;
            $id = $row["id"];
            $title = $row["title"];
            $niche = $row["niche"];
            $image = $row["image_path"];
        $foreign_imagePath = $row["post_image_url"];
            $date = $row["formatted_date"];
        $date2 = $row["formatted_date2"];
            $editor_id = $row["editor_id"];
            $admin_id = $row["admin_id"];
            $authors_firstname = $row["authors_firstname"];
            $authors_lastname = $row["authors_lastname"];
            $about_author = $row["about_author"];
            $readingTime = calculateReadingTime($row['content']);
        $publishDate = !empty($date2) ? $date2 : $date;
            if (strlen($title) > $max_length) {
                $title = substr($title, 0, $max_length) . '...';
            }
            if (strlen($about_author) > $max_length2) {
                $about_author = substr($about_author, 0, $max_length2) . '...';
            }
            echo "<a class='commentary_divs' href='pages/view_post.php?id4=$id'>
                        <div class='commentary_divs_imagediv'>";
            if (!empty($image)) {
                echo "<img src='$image' alt='article image'>";
        } elseif (!empty($foreign_imagePath)) {
            echo "<img src='$foreign_imagePath' alt='article image'>";
            }
            echo   "<div class='commentary_divs_imagediv_subdiv'>
                        <h2>$authors_lastname $authors_firstname</h2>
                        <p>$about_author</p>
                    </div>
                </div>
                <div class='commentary_divs_body'>
                    <h2>$niche</h2>
                    <h3>$title</h3>
                    <div class='commentary_divs_body_subdiv'>
                        <p>$publishDate</p>
                        <p><i class='fa fa-clock' aria-hidden='true'></i>$readingTime</p>
                    </div>
                </div>
            </a>
            ";
        }
    //echo"<a href='pages/commentaries.php' class='mainheader__signupbtn'>See More Commentaries</a>
    // </div>";
}
?>