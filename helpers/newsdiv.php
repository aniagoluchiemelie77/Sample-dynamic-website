<div class="sidebar_divs_container">
    <div class="section2__div1__header headers">
        <h1>Latest News</h1>
    </div>
    <?php 
        $selectnews = "SELECT id, title, niche, image_path, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM news ORDER BY id DESC LIMIT 6";
        $selectnews_result = $conn->query($selectnews);
        if ($selectnews_result->num_rows > 0) {
            while($row = $selectnews_result->fetch_assoc()) {
                $max_length = 150;
                $id = $row["id"];
                $title = $row["title"];
                $niche = $row["niche"];
                $image = $row["image_path"];
                $date = $row["formatted_date"];
                if (strlen($title) > $max_length) {
                    $title = substr($title, 0, $max_length) . '...';
                }
                echo "<a class='posts_div' href='pages/view_post.php?id3='$id''>
                        <img src='$image' alt='Post Image'/>
                        <p class='posts_div_niche'>$niche</p>
                        <h1>$title</h1>
                        <p class='posts_div_otherp'>By, <span>Chiemelie Aniagolu, Contributing Writer.</span></p>
                        <div class='posts_div_subdiv'>
                            <p>$date</p>
                            <p>10mins Read.</p>
                        </div>
                </a>";
            }
        }
    ?>
    <a href="pages/news.php" class="mainheader__signupbtn">See More News</a>
</div>