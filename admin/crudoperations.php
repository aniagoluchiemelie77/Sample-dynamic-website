<?php
require("../connect.php");
function logUpdate($conn, $forUser, $action) {
    date_default_timezone_set('UTC');
    $date = date('Y-m-d');
    $time = date("H:iA"); 
    $sql = "INSERT INTO updates (content, for_user, Date, time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $action, $forUser, $date, $time);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
    $stmt->close();
}
function executeQuery($sql, $data){
    global $conn;
    $stmt = $conn->prepare($sql);
    $values = array_values($data);
    $types = str_repeat('s', count($values));
    $stmt->bind_param($types, ...$values);
    $stmt->execute();
    return $stmt;
}
function selectAll ($tablename, $condition = []){
    global $conn;
    $sql = "SELECT * FROM $tablename";
    if(empty($condition)){
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    }else{
        $i = 0;
        foreach($condition as $key => $value){
            if($i === 0){
                $sql = $sql." WHERE $key = ?";
            }else{
                $sql = $sql." AND $key = ?";
            }
            $i ++;
        }
    }
    executeQuery($sql, $value);
}
function selectOne ($tablename, $condition){
    $servername = "localhost";
    $user = "root";
    $pass = "";
    $db = "new_posts";
    $conn = new mysqli($servername, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM $tablename";
    $i = 0;
    foreach($condition as $key => $value){
        if($i === 0){
            $sql = $sql." WHERE $key = ?";
        }else{
            $sql = $sql." AND $key = ?";
        }
        $i ++;
        }
    executeQuery($sql, $value);
}
function create ($tablename, $data){
    $servername = "localhost";
    $user = "root";
    $pass = "";
    $db = "new_posts";
    $conn = new mysqli($servername, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO $tablename SET ";
    $i = 0;
    foreach($data as $key => $value){
        if($i === 0){
            $sql = $sql." $key = ?";
        }else{
            $sql = $sql.", $key = ?";
        }
        $i ++;
        }
    executeQuery($sql, $data);
}
function update ($tablename, $id, $data){
    $servername = "localhost";
    $user = "root";
    $pass = "";
    $db = "new_posts";
    $conn = new mysqli($servername, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "UPDATE $tablename SET ";
    $i = 0;
    foreach($data as $key => $value){
        if($i === 0){
            $sql = $sql." $key = ?";
        }else{
            $sql = $sql.", $key = ?";
        }
        $i ++;
        }
        $sql = $sql." WHERE id = $id";
    executeQuery($sql, $data);
}
function delete ($tablename, $id, $condition){
    $servername = "localhost";
    $user = "root";
    $pass = "";
    $db = "new_posts";
    $conn = new mysqli($servername, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "DELETE FROM $tablename WHERE id = '$id'";
    $i = 0;
    foreach($condition as $key => $value){
        if($i === 0){
            $sql = $sql." $key = ?";
        }else{
            $sql = $sql.", AND $key = ?";
        }
        $i ++;
        }
    executeQuery($sql, $condition);
}

function createcategory($filename, $content, $description) {
    $file = fopen('../../pages/'.$filename, 'w');
    if ($file) {
        fwrite($file, $content);
        fclose($file);
    } else {
        die("Unable to create file.");
    }
    $servername = "localhost";
    $user = "root";
    $pass = "";
    $db = "new_posts";
    $conn = new mysqli($servername, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("INSERT INTO topics (name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $filename, $description);
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
$topic_pagetemplate = `<?php
                            session_start();
                            require('../connect.php');
                        ?>
                        <!DOCTYPE html>
                        <html lang="en">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
                                <meta http-equiv="X-UA-Compatible" content="ie=edge" />
                                <meta name="description" content="Article website" />
                                <link rel="preconnect" href="https://fonts.googleapis.com">
                                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                                <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
                                <meta name="author" content="Aniagolu chiemelie"/>
                                <link rel="stylesheet" href="../index.css"/>
                                <title>$topicName</title>
                            </head>
                            <body id="container">
                                <?php require("../includes/header2.php");?>
                                <div class="body_container">
                                    <div class="body_left">
                                        <div class="page_links">
                                            <a href="../">Home</a> > <p>$topicName</p>
                                        </div>
                                        <h1 class='bodyleft_header3 border-gradient-bottom--lightdark'>Latest On $topicName</h1>
                                        <div class='more_posts'>;
                                            <?php
                                                $tables = ['paid_posts', 'posts', 'commentaries', 'news', 'press_releases'];
                                                $results = [];
                                                foreach ($tables as $table) {
                                                    $sql = "SELECT id, title, niche, content, image_path, Date FROM $table WHERE niche LIKE ? ORDER BY id DESC LIMIT 12";
                                                    $stmt = $conn-> prepare ($sql);
                                                    $nicheq = $topicName;
                                                    $searchTerm = "%" . $nicheq . "%";
                                                    $stmt->bind_param("s", $searchTerm);
                                                    $stmt->execute();
                                                    $stmt->bind_result($id, $title, $niche, $content, $image, $date);
                                                    while ($stmt->fetch()) {
                                                        $posttype = 0;
                                                            if ($table == 'paid_posts') {
                                                                $posttype = 1;
                                                            } elseif ($table == 'posts') {
                                                                $posttype = 2;
                                                            } elseif ($table == 'commentaries') {
                                                                $posttype = 4;
                                                            } elseif ($table == 'news') {
                                                                $posttype = 3;
                                                            } elseif ($table == 'press_releases') {
                                                                $posttype = 5;
                                                            }
                                                            $results [] = [
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
                                                if (!function_exists('calculateReadingTime')) {
                                                    function calculateReadingTime($content) {
                                                        $wordCount = str_word_count(strip_tags($content));
                                                        $minutes = floor($wordCount / 200);
                                                        return $minutes  . ' mins read ';
                                                    }
                                                }
                                                $max_length = 60;
                                                $id = $result ['id'];
                                                $title = $result ['title'];
                                                $date = $result ['Date'];
                                                if (strlen($title) > $max_length) {
                                                    $title = substr($title, 0, $max_length) . '...';
                                                }
                                                $dateTime = new DateTime($date);
                                                $day = $dateTime->format('j');
                                                $month = $dateTime->format('M');
                                                $year = $dateTime->format('Y');
                                                $ordinalSuffix = getOrdinalSuffix($day);
                                                $formattedDate = $month . ' ' . $day . $ordinalSuffix . ', ' . $year;
                                                $readingTime = calculateReadingTime($result ['content']);
                                                echo "<a class='more_posts_subdiv' href='view_post.php?id".$result ['posttype']."=$id'>
                                                        <img src='../".$result ['image_path']."' alt = 'Post's Image'/>
                                                        <div class='more_posts_subdiv_subdiv'>
                                                            <h1>$title</h1>
                                                            <span>$formattedDate</span>
                                                            <span>$readingTime</span>
                                                        </div>
                                                        <p class='posts_div_niche'>". $result ['niche']."</p>
                                                    </a>";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="body_right border-gradient-leftside--lightdark">
                                    <?php include('../helpers/emailsubscribeform.php');?>
                                </div>
                            </div>
                            <section class="section2" id="section1">
                                <div class="section2__div1">
                                    <div class="search_div" id="result"></div>
                                    <div class="section2__div1__header headers">
                                        <h1>For You</h1>
                                    </div>
                                    <?php include('../includes/pagination.php');?>
                                </div>
                            </section>
                            <?php include ("../includes/footer2.php");?>
                            <script src="../index.js"></script>
                        </body>
                    </html>`;
?>