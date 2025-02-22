<?php
    $tables = ['paid_posts', 'posts', 'commentaries', 'news', 'press_releases'];
    $results = [];
    foreach ($tables as $table) {
        $sql = "SELECT id, title, niche, content, image_path, Date FROM $table WHERE is_favourite = 1 ORDER BY id DESC LIMIT 8";
        $stmt = $conn->prepare($sql);
        $stmt->bind_result($id, $title, $niche, $content, $image, $date);
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
                'title' => $title,
                'niche' => $niche,
                'content' => $content,
                'image_path' => $image,
                'Date' => $date,
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
        $month = $dateTime->format('M');
        $year = $dateTime->format('Y');
        $ordinalSuffix = getOrdinalSuffix($day);
        $formattedDate = $month . ' ' . $day . $ordinalSuffix . ', ' . $year;
        $readingTime = calculateReadingTime($content);
        echo    "<a class='posts_div' href='../pages/view_post.php?id".$result['posttype']."=$id'>
                    <img src='../".$result['image_path']."' alt='Post's Image'/>
                    <p class='posts_div_niche'>". $result['niche']."</p>
                    <h1>$title</h1>
                    <p class='posts_div_otherp'>By, <span>Chiemelie Aniagolu, Contributing Writer.</span></p>
                    <div class='posts_div_subdiv'>
                        <p>$formattedDate</p>
                        <p>$readingTime</p>
                    </div>
                </a>
        ";
    }
?>