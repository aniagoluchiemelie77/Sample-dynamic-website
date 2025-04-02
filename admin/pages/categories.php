<?php
session_start();
require ("../connect.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="Tech News and Articles website" />
    <meta name="keywords" content="Tech News, Content Writers, Content Strategy" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu Diamaka"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../admin.css"/>
    <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<title>Categories</title>
</head>
<body>
    <?php require("../extras/header2.php");?>
    <section class="about_section">
        <div class="about_header">
            <h1>Categories</h1>
        </div>
        <div class="about_section_topicsdiv">
            <div class="page_links">
                <a href="../admin_homepage.php">Home</a> > <p>Pages</p> > <p>Categories</p>
            </div>
            <?php
                $getcategories_sql = " SELECT name, image_path, Date, time FROM topics ORDER BY id";
                $getcategories_result = $conn->query($getcategories_sql);
                if ($getcategories_result->num_rows > 0) {
                    if (!function_exists('convertToReadable')) {
                        function convertToReadable($slug) {
                            $string = str_replace('-', ' ', $slug);
                            $string = ucwords($string);
                            return $string;
                        }
                    }
                    if (!function_exists('removeHyphen')) {
                        function removeHyphen($string) {
                            $string = str_replace(['-', ' '], '', $string);
                            return $string;
                        }
                    }
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
                    while($row = $getcategories_result->fetch_assoc()){
                        $time = $row['time'];
                        $date = $row['Date'];
                        $name = $row['name'];
                        $img = $row['image_path'];
                        $dateTime = new DateTime($date);
                        $day = $dateTime->format('j');
                        $month = $dateTime->format('M');
                        $year = $dateTime->format('Y');
                        $ordinalSuffix = getOrdinalSuffix($day);
                        $formattedDate = $month . ' ' . $day . $ordinalSuffix . ', ' . $year;
                        $formatted_time = date("g:i A", strtotime($time));
                        $cleanString = removeHyphen($name);
                        $readableString = convertToReadable($name);
                        $total_posts = 0;
                        $tables = ['paid_posts', 'posts', 'news', 'press_releases', 'commentaries'];
                        foreach ($tables as $table) {
                            $niche = $readableString;
                            $sql = "SELECT COUNT(*) AS count FROM $table WHERE niche = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("s", $niche);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            $total_posts += $row['count'];
                            $stmt->close();
                        }
                    echo "<div class='about_section_topicsdiv_subdiv'>";
                    if (!empty($img)) {
                        echo "<img src='../../$img' alt='article image'>";
                    }
                    echo "
                                <div class='about_section_topicsdiv_subdiv_subdiv'>
                                    <h1><span>$readableString</h1>
                                    <p>Total Number of Posts for this Category: <span>$total_posts</span></p>
                                    <p>Date created: <span>$formattedDate</span></p>
                                    <p>Time: <span>$formatted_time</span></p>
                                    <a class='topics_actions'>
                                        <i class='fa fa-trash' aria-hidden='true'></i>
                                    </a>
                                </div>
                            </div>
                            ";
                        }
                    }
                ?>
            <a class="about_section_topicsdiv_subdiv-action" id="add_category" href="../create_new/category.php">
                <div class="actions_subdiv">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </div>
                <p class="actions_p2">Add Category</p>
            </a>
        </div>
    </section>
    <script src="../admin.js"></script>
</body>
</html>