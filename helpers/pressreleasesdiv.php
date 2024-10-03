<div class="section3__div1 border-gradient-bottom--lightdark">
    <h1>Press Releases</h1>
    <a href="pages/pressreleases.php" class="section2__div2__link mainheader__signupbtn">View All</a>
</div>
<div class="section3__div2">
    <?php
        $selectpressreleases_sql = "SELECT id, title, niche, image_path, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM press_releases ORDER BY id DESC LIMIT 5";
        $selectpressreleases_result = $conn->query($selectpressreleases_sql);
        if ($selectpressreleases_result->num_rows > 0) {
            if (!function_exists('calculateReadingTime')) {
                function calculateReadingTime($content) {
                    $wordCount = str_word_count(strip_tags($content));
                    $minutes = floor($wordCount / 200);
                    return $minutes  . ' mins read ';
                }
            }
            while($row = $selectpressreleases_result->fetch_assoc()) {
                $max_length = 60;
                $id = $row["id"];
                $title = $row["title"];
                $niche = $row["niche"];
                $image = $row["image_path"];
                $date = $row["formatted_date"];
                if (strlen($title) > $max_length) {
                    $title = substr($title, 0, $max_length) . '...';
                }
                $readingTime = calculateReadingTime($row['content']);
                echo "<a class='section3__div2__article1' href='pages/view_post.php?id5=$id'>
                        <img src='$image' alt='article image'>
                        <div class='section3__subdiv'>
                            <h1 class='section3__subdiv-h1'>$niche</h1>
                            <h2 class='section3__subdiv-h2'>$title</h2>
                            <div class='section3__subdiv_subdiv'>
                                <p>$date</p>
                                <p>$readingTime</p>
                            </div>
                        </div>
                    </a>";
            }
        }
    ?>
</div>