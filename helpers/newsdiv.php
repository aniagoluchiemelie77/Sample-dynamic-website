
    <?php
    $selectnews = "SELECT id, title, niche, image_path, post_image_url, content, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM news ORDER BY id DESC LIMIT 6";
    $selectnews_result = $conn->query($selectnews);
    if ($selectnews_result->num_rows > 0) {
        if (!function_exists('calculateReadingTime')) {
            function calculateReadingTime($content)
            {
                $wordCount = str_word_count(strip_tags($content));
                $minutes = floor($wordCount / 200);
                return $minutes  . ' mins read ';
            }
        }
        echo "<div class='sidebar_divs_container'>
                    <div class='section2__div1__header headers'>
                        <h1>Latest News</h1>
                    </div>
                ";
        while ($row = $selectnews_result->fetch_assoc()) {
            $max_length = 40;
            $id = $row["id"];
            $title = $row["title"];
            $niche = $row["niche"];
            $image = $row["image_path"];
            $foreign_imagePath = $row["post_image_url"];
            $date = $row["formatted_date"];
            if (strlen($title) > $max_length) {
                $title = substr($title, 0, $max_length) . '...';
            }
            $readingTime = calculateReadingTime($row['content']);
            echo "<a class='posts_div' href='pages/view_post.php?id3=$id'>";
            if (!empty($image)) {
                echo "<img src='$image' alt='article image'>";
            } elseif (!empty($foreign_imagePath)) {
                echo "<img src='$foreign_imagePath' alt='article image'>";
            }
            echo    "<p class='posts_div_niche'>$niche</p>
                        <h1>$title</h1>
                        <p class='posts_div_otherp'>By, <span>Chiemelie Aniagolu, Contributing Writer.</span></p>
                        <div class='posts_div_subdiv'>
                            <p>$date</p>
                            <p>$readingTime</p>
                        </div>
                    </a>
                ";
        }
        //echo "<a href='pages/news.php' class='mainheader__signupbtn'>See More News</a>
        //</div>";
    }
    ?>