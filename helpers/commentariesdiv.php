                <div class="sidebar_divs_container">
                    <div class="section2__div1__header headers">
                        <h2>Latest Commentaries</h2>
                    </div>
                    <?php 
                        $selectcommentaries = "SELECT id, content, admin_id, editor_id, authors_firstname, authors_lastname, authors_image, about_author, title, niche, image_path, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM commentaries ORDER BY id DESC LIMIT 8";
                        $selectcommentaries_result = $conn->query($selectcommentaries);
                        if ($selectcommentaries_result->num_rows > 0) {
                            if (!function_exists('calculateReadingTime')) {
                                function calculateReadingTime($content) {
                                    $wordCount = str_word_count(strip_tags($content));
                                    $minutes = floor($wordCount / 200);
                                    return $minutes  . ' mins read ';
                                }
                            }
                            while($row = $selectcommentaries_result->fetch_assoc()) {
                                $max_length = 60;
                                $max_length2 = 60;
                                $id = $row["id"];
                                $title = $row["title"];
                                $niche = $row["niche"];
                                $image = $row["image_path"];
                                $date = $row["formatted_date"];
                                $editor_id = $row["editor_id"];
                                $admin_id = $row["admin_id"];
                                $authors_firstname = $row["authors_firstname"];
                                $authors_lastname = $row["authors_lastname"];
                                $authors_lastname = $row["authors_lastname"];
                                $about_author = $row["about_author"];
                                $readingTime = calculateReadingTime($row['content']);
                                if (strlen($title) > $max_length) {
                                    $title = substr($title, 0, $max_length) . '...';
                                }
                                if (strlen($about_author) > $max_length2) {
                                    $about_author = substr($about_author, 0, $max_length2) . '...';
                                }
                                echo "<a class='commentary_divs' href='pages/view_post.php?id4=$id'>
                                        <div class='commentary_divs_imagediv'>
                                            <img src='images/chibs.jpg' alt='Commentary Image'/>
                                            <div class='commentary_divs_imagediv_subdiv'>
                                                <h2>Aniagolu Chiemelie</h2>
                                                <p>Chief Technologist for Security Research and Innovation, HP Inc. Security Labs.</p>
                                            </div>
                                        </div>
                                        <div class='commentary_divs_body'>
                                            <h2>$niche</h2>
                                            <h3>$title</h3>
                                            <div class='commentary_divs_body_subdiv'>
                                                <p>$date</p>
                                                <p><i class='fa fa-clock' aria-hidden='true'></i>$readingTime</p>
                                            </div>
                                        </div>
                                </a>";
                            }
                        }
                    ?>
                    <a href="pages/news.php" class="mainheader__signupbtn">See More Commentaries</a>
                </div>