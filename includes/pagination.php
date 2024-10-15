<?php
    $result = $conn->query("SELECT COUNT(*) AS total FROM posts");
    $row = $result->fetch_assoc();
    $total_posts = $row['total'];
    $posts_per_page = 30;
    $total_pages = ceil($total_posts / $posts_per_page);
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $current_page = (int) $_GET['page'];
    }
    else {
        $current_page = 1;
    }
    if ($current_page > $total_pages) {
        $current_page = $total_pages;
    }
    if ($current_page < 1) {
        $current_page = 1;
    }
    $offset = ($current_page - 1) * $posts_per_page;
    $sql = "SELECT id, admin_id, editor_id, authors_firstname, authors_lastname, about_author, title, niche, content, image_path, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM posts ORDER BY id DESC LIMIT $offset, $posts_per_page";
    $result = $conn->query($sql);
    $author_firstname = "";
    $author_lastname = "";
    $author_image = "";
    $author_bio = "";
    $id_type = '';
    $role = "";
    if ($result->num_rows > 0) {
        $i = 0;
        if (!function_exists('calculateReadingTime')) {
            function calculateReadingTime($content) {
                $wordCount = str_word_count(strip_tags($content));
                $minutes = floor($wordCount / 200);
                return $minutes  . ' mins read ';
            }
        }
        while($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $i++;
            $title = $row["title"];
            $niche = $row["niche"];
            $image = $row["image_path"];
            $date = $row["formatted_date"];
            $content = $row["content"];
            $readingTime = calculateReadingTime($row['content']);
            if (!empty($row['admin_id'])) {
                $admin_id = $row['admin_id'];
                $sql_admin = "SELECT id, firstname, lastname, image, bio FROM admin_login_info WHERE id = $admin_id";
                $result_admin = $conn->query($sql_admin);
                if ($result_admin->num_rows > 0) {
                    $admin = $result_admin->fetch_assoc();
                    $author_firstname = $admin['firstname'];
                    $author_lastname = $admin['lastname'];
                    $author_image = $admin['image'];
                    $id_type = "Admin";
                    $author_bio = $admin['bio'];
                    $role = "Editor-in-chief Uniquetechcontentwriter.com";
                }
            }
            elseif (!empty($row['editor_id'])) {
                $editor_id = $row['editor_id'];
                $sql_editor = "SELECT id, firstname, lastname, image, bio FROM editor WHERE id = $editor_id";
                $result_editor = $conn->query($sql_editor);
                if ($result_editor->num_rows > 0) {
                    $editor = $result_editor->fetch_assoc();
                    $author_firstname = $editor['firstname'];
                    $author_image = $editor['image'];
                    $author_lastname = $editor['lastname'];
                    $author_bio = $editor['bio'];
                    $id_type = "Editor";
                    $role = 'Editor At Uniquetechcontentwriter.com';
                }
            }
            else {
                $author_firstname = $row['author_firstname'];
                $author_lastname = $row['author_lastname'];
                $author_bio = $row['author_bio'];
                $role = 'Contributing Writer';
                $id_writer = 4;
                $id_type = "Writer";
            }
            echo "<div class='section2__div1__div1 normal-divs'>
                        <a class='normal-divs__subdiv' href='view_post.php? id2=".$row["id"]."'>
                            <img src='../$image' alt='article image'>
                            <div class='normal-divs__subdiv__div'>
                                <h1 class='normal-divs__header'>$niche</h1>
                                <h2 class='normal-divs__title'>$title</h2>
                                <div>
                                    <p class='normal-divs__releasedate firstp'>$date</p>
                                    <p class='normal-divs__releasedate'><i class='fa fa-clock' aria-hidden='true'></i> $readingTime</p>
                                </div>
                            </div>
                        </a>
                        <div class='normal-divs__subdiv2'>
                            <img src='../$author_image' alt='article image'>
                            <p class='normal-divs__subdiv2__p'>By <span>$author_firstname $author_lastname, </span><span>$role</span></p>
                        </div>
                    </div>";
        }
    }
    for ($page = 1; $page <= $total_pages; $page++) {
        echo '<center><div class="pagination_div"><a href="cybersecurity.php?page=' . $page . '">' . $page . '</a></div> </center>';
    }
?>