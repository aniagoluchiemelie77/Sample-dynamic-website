<?php
    $tables = ['paid_posts', 'posts', 'commentaries', 'news', 'press_releases'];
    $results = [];
    foreach ($tables as $table) {
    $sql = "SELECT id, admin_id, editor_id, title, niche, content, image_path, Date, authors_firstname, authors_lastname FROM $table WHERE is_favourite = 1 ORDER BY id DESC LIMIT 2";
        $stmt = $conn->prepare($sql);
        $stmt->bind_result($id, $admin_id, $editor_id, $title, $niche, $content, $image, $date, $authors_firstname, $authors_lastname);
        $stmt->execute();
        while ($stmt->fetch()) {
            $posttype = 0;
            if ($table == 'paid_posts') {
                $posttype = 1;
            } 
            elseif ($table == 'posts') {
                $posttype = 2;
            } 
            elseif ($table == 'commentaries') {
                $posttype = 4;
            } 
            elseif ($table == 'news') {
                $posttype = 3;
            }
            elseif ($table == 'press_releases') {
                $posttype = 5;
            }
            $results[] = [
                'id' => $id,
                'admin_id' => $admin_id,
                'editor_id' => $editor_id,
                'title' => $title,
                'niche' => $niche,
                'content' => $content,
                'image_path' => $image,
                'Date' => $date,
                'authors_firstname' => $authors_firstname,
                'authors_lastname' => $authors_lastname,
                'table' => $table,
                'posttype' => $posttype
            ];
        }
    }
    foreach ($results as $result) {
        if (!function_exists('getOrdinalSuffix')) {
            function getOrdinalSuffix($day) {
                if (!in_array(($day % 100), [11, 12, 13])) {
                    switch ($day % 10) {
                        case 1: return 'st';
                        case 2: return 'nd';
                        case 3: return 'rd';
                    }
                }
                return 'th';
            }
        }
        $author_firstname = "";
        $author_lastname = "";
        $role = "";
        if (!empty($result["admin_id"])) {
            $admins_id = $result['admin_id'];
            $sql_admin = "SELECT id, firstname, lastname FROM admin_login_info WHERE id = $admins_id";
            $result_admin = $conn->query($sql_admin);
            if ($result_admin->num_rows > 0) {
                $admin = $result_admin->fetch_assoc();
                $author_firstname = $admin['firstname'];
                $author_lastname = $admin['lastname'];
                $role = "Editor-in-chief";
            }
        }
        elseif (!empty($result["editor_id"])) {
            $editors_id = $result['editor_id'];
            $sql_editor = "SELECT id, firstname, lastname FROM editor WHERE id = $editors_id";
            $result_editor = $conn->query($sql_editor);
            if ($result_editor->num_rows > 0) {
                $editor = $result_editor->fetch_assoc();
                $author_firstname = $editor['firstname'];
                $author_lastname = $editor['lastname'];
                $role = 'Editor';
            }
        }
        else {
            $author_firstname = $result['authors_firstname'];
            $author_lastname = $result['authors_lastname'];
            $role = 'Contributing Writer';
        }
        $max_length = 60;
        $id = $result['id'];
        $title = $result["title"];
        $date = $result["Date"];
        $content = $result["content"];
        if (strlen($title) > $max_length) {
            $title = substr($title, 0, $max_length) . '...';
        }
        $dateTime = new DateTime($date);
        $day = $dateTime->format('j');
    $image = $result['image_path'];
        $month = $dateTime->format('M');
        $year = $dateTime->format('Y');
        $ordinalSuffix = getOrdinalSuffix($day);
        $formattedDate = $month . ' ' . $day . $ordinalSuffix . ', ' . $year;
        $readingTime = calculateReadingTime($content);
        echo    "<a class='posts_div' href='../pages/view_post.php?id".$result['posttype']."=$id'>";
    if (!empty($image)) {
        echo "<img src='../$image' alt='article image'>";
        }
        echo   "<p class='posts_div_niche'>". $result['niche']."</p>
                <h1>$title</h1>
                <p class='posts_div_otherp'>By, <span>$author_firstname $author_lastname, $role.</span></p>
                <div class='posts_div_subdiv'>
                    <p>$formattedDate</p>
                    <p>$readingTime</p>
                </div>
            </a>";
    }
?>