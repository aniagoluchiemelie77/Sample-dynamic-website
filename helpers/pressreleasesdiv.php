
    <?php
    $selectpressreleases_sql = "SELECT id, title, niche, image_path, post_image_url, content, Date, schedule FROM press_releases ORDER BY id DESC LIMIT 5";
        $selectpressreleases_result = $conn->query($selectpressreleases_sql);
        if ($selectpressreleases_result->num_rows > 0) {
            if (!function_exists('calculateReadingTime')) {
                function calculateReadingTime($content) {
                    $wordCount = str_word_count(strip_tags($content));
                    $minutes = floor($wordCount / 200);
                    return $minutes  . ' mins read ';
                }
            }
            echo "<div class='section3__div1 border-gradient-bottom--lightdark'>
                        <h1>Press Releases</h1>
                        <a href='pages/pressreleases.php' class='section2__div2__link mainheader__signupbtn'>View All</a>
                    </div>
                    <div class='section3__div2'>
            ";

            while($row = $selectpressreleases_result->fetch_assoc()) {
            $max_length = 40;
                $id = $row["id"];
                $title = $row["title"];
                $niche = $row["niche"];
                $image = $row["image_path"];
            $foreign_imagePath = $row["post_image_url"];
            $scheduleDate = formatDateSafely($row['schedule']);
            $postDate = formatDateSafely($row['Date']);
            $now = date('Y-m-d H:i:s');
            if ($scheduleDate && $row['schedule'] <= $now) {
                $publishDate = $scheduleDate;
            } else {
                $publishDate = $postDate;
            }
                if (strlen($title) > $max_length) {
                    $title = substr($title, 0, $max_length) . '...';
                }
                $readingTime = calculateReadingTime($row['content']);
                echo "<a class='section3__div2__article1' href='pages/view_post.php?id5=$id'>";
            echo "<img src='images/Pressreleasesimg.png' alt='article image'>";
                echo   "<div class='section3__subdiv'>
                            <h1 class='section3__subdiv-h1'>$niche</h1>
                            <h2 class='section3__subdiv-h2'>$title</h2>
                            <div class='section3__subdiv_subdiv'>
                                <p>$publishDate</p>
                                <p>$readingTime</p>
                            </div>
                        </div>
                    </a>
                ";
            }
            echo"</div></div>";
        }
    ?>