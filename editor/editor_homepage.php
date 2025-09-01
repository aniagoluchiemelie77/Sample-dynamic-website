<?php

        /** @var \mysqli $conn */
        global $conn;
session_start();
require("connect.php");
include("init.php");
require('../init.php');
$tempSession = $_SESSION;
session_regenerate_id(true);
$_SESSION = $tempSession;
if (!isset($_SESSION['email'])) {
    header("Location: login/index.php");
};
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
function formatDate($dateString)
{
    $timestamp = strtotime($dateString);
    $day = date('j', $timestamp);
    $month = date('F', $timestamp);
    $year = date('Y', $timestamp);
    $daySuffix = date('jS', $timestamp);
    return "$month $daySuffix $year";
}
$date = formatDate($_SESSION['date_joined']);
$translationFile = "../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = []; // Initialize as empty array to avoid undefined variable errors
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/editor.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../<?php echo $favicon; ?>" type="image/x-icon">
    <script src="../javascript/editor.js" defer></script>
    <title><?php echo $translations['editor_homepage']; ?></title>
</head>

<body>
    <div class="logout_alert" id="logout_alert">
        <h1 class="logout_alert_header"><?php echo $translations['logout_alert']; ?>?</h1>
        <div class="logout_alert_subdiv">
            <a class="btn" href="extras/logout.php"><?php echo $translations['logout_alert_affirm']; ?></a>
            <a class="btn cancellogout" id="dismiss-popup-btn" onclick="cancelExit()"><?php echo $translations['logout_alert_decline']; ?></a>
        </div>
    </div>
    <?php require("extras/header.php"); ?>
    <section class="body">
        <div class="sidebar ">
            <button class="sidebarbtn active" id="tab">
                <i class="fa fa-tachometer" aria-hidden="true"></i>
                <p class="paragraph">
                    <?php echo $translations['dashboard']; ?>
                </p>
            </button>
            <button class="sidebarbtn" id="tab">
                <i class="fa fa-user" aria-hidden="true"></i>
                <p class="paragraph">
                    <?php echo $translations['profile']; ?>
                </p>
            </button>
            <button class="sidebarbtn" id="tab">
                <i class="fa fa-user" aria-hidden="true"></i>
                <p class="paragraph">
                    <?php echo $translations['users']; ?>
                </p>
            </button>
            <button class="sidebarbtn" id="tab">
                <i class="fa fa-newspaper" aria-hidden="true"></i>
                <p class="paragraph">
                    <?php echo $translations['posts']; ?>
                </p>
            </button>
            <button class="sidebarbtn" id="tab">
                <i class="fa fa-sticky-note" aria-hidden="true"></i>
                <p class="paragraph">
                    <?php echo $translations['pages']; ?>
                </p>
            </button>
            <button class="sidebarbtn" id="tab">
                <i class="fa fa-cog" aria-hidden="true"></i>
                <p class="paragraph">
                    <?php echo $translations['settings']; ?>
                </p>
            </button>
            <button class="sidebarbtn" id="tab">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <p class="paragraph">
                    <?php echo $translations['contact_developer']; ?>
                </p>
            </button>
            <button class="sidebarbtn2" onclick="displayExit()">
                <i class="fa-solid fa-door-open"></i>
                <p class="paragraph">
                    <?php echo $translations['logout']; ?>
                </p>
            </button>
        </div>
        <div class="aside_sidebar">
            <div class="website_info_div tab_content active2" id="tab1">
                <h1 class="aside_sidebar_header"><?php echo getTimeBasedGreeting($_SESSION['username']); ?></h1>
                <div class="webinfo_container">
                    <?php
                    $sql1 = "SELECT COUNT(*) as total1 FROM paid_posts";
                    $result1 = $conn->query($sql1);
                    $sql2 = "SELECT COUNT(*) as total2 FROM posts";
                    $result2 = $conn->query($sql2);
                    if ($result1->num_rows > 0 && $result2->num_rows > 0) {
                        $row1 = $result1->fetch_assoc();
                        $row2 = $result2->fetch_assoc();
                        $totalRows = $row1["total1"] + $row2["total2"];
                    ?>
                        <div class="website_info">
                            <div class="website_info_subdiv">
                                <i class="fa fa-check-square" aria-hidden="true"></i>
                                <p class="website_info_p1"><?php echo $totalRows; ?></p>
                            </div>
                            <p class="website_info_p2"><?php echo $translations['published']; ?></p>
                        </div>
                    <?php
                    };
                    $subscribers = "SELECT COUNT(*) as total FROM subscribers";
                    $result = $conn->query($subscribers);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                    ?>
                        <div class="website_info">
                            <div class="website_info_subdiv">
                                <i class="fa fa-check-square" aria-hidden="true"></i>
                                <p class="website_info_p1"><?php echo $row["total"]; ?></p>
                            </div>
                            <p class="website_info_p2"><?php echo $translations['subscribers']; ?></p>
                        </div>
                    <?php
                    };
                    $newslettersignup_count = "SELECT COUNT(*) as total FROM newsletter_subscribers";
                    $newslettersignupcount_result = $conn->query($newslettersignup_count);
                    if ($newslettersignupcount_result->num_rows > 0) {
                        $row = $newslettersignupcount_result->fetch_assoc();
                    ?>
                        <div class="website_info">
                            <div class="website_info_subdiv">
                                <i class="fa fa-check-square" aria-hidden="true"></i>
                                <p class="website_info_p1"><?php echo $row["total"]; ?></p>
                            </div>
                            <p class="website_info_p2"><?php echo $translations['signups']; ?></p>
                        </div>
                    <?php }; ?>
                    <a class="website_info" href="create_new/posts.php" target="_blank">
                        <div class="website_info_subdiv">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </div>
                        <p class="website_info_p2"><?php echo $translations['new_post']; ?></p>
                    </a>
                    <a class="website_info" href="../index.php" target="_blank">
                        <div class="website_info_subdiv">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </div>
                        <p class="website_info_p2"><?php echo $translations['view_website']; ?></p>
                    </a>
                    <a class="website_info" href="create_new/workspace.php">
                        <div class="website_info_subdiv">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </div>
                        <p class="website_info_p2"><?php echo $translations['add_draft']; ?></p>
                    </a>
                </div>
                <div class="addtionalinfo">
                    <div class="addtionalinfo_header">
                        <h1><?php echo $translations['recent_posts']; ?></h1>
                        <a class="btn" href="view_all/posts.php"><?php echo $translations['view_all']; ?></a>
                    </div>
                    <div class="addtionalinfo_body border-gradient-side-dark">
                        <?php
                        $selectposts = "SELECT id, title, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM posts ORDER BY id DESC LIMIT 8";
                        $selectposts_result = $conn->query($selectposts);
                        if ($selectposts_result->num_rows > 0) {
                            $sn = 0;
                            echo "<table>
                                        <tr>
                                            <th>S/n</th>
                                            <th>$translations[title]</th>
                                            <th>$translations[date]</th>
                                            <th>$translations[actions]</th>
                                        </tr>";
                            while ($row = $selectposts_result->fetch_assoc()) {
                                $sn++;
                                $max_length = 60;
                                $title = $row["title"];
                                if (strlen($title) > $max_length) {
                                    $title = substr($title, 0, $max_length) . '...';
                                }
                                echo "<tr class='border-gradient-side-dark'>
                                            <td>" . $sn . "</td>
                                            <td>$title</td>
                                            <td>" . $row["formatted_date"] . "</td>
                                            <td><a class='edit' href='edit/post.php?id2=" . $row["id"] . "' target='_blank'>$translations[edit]</a> / <a class='delete' onclick='confirmDeleteP(" . $row['id'] . ")'>$translations[delete]</a></td>
                                        </tr>";
                            };
                            echo "</table>";
                        };
                        ?>
                    </div>
                </div>
                <div class="addtionalinfo">
                    <div class="addtionalinfo_header">
                        <h1><?php echo $translations['recent_drafts']; ?></h1>
                        <a class="btn" href="view_all/unpublished_articles.php"><?php echo $translations['view_all']; ?></a>
                    </div>
                    <div class="addtionalinfo_body border-gradient-side-dark">
                        <?php
                        $selectdrafts = "SELECT id, title, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM unpublished_articles ORDER BY id DESC LIMIT 8";
                        $selectdrafts_result = $conn->query($selectdrafts);
                        if ($selectdrafts_result->num_rows > 0) {
                            $sn = 0;
                            echo "<table>
                                        <tr>
                                            <th>S/n</th>
                                            <th>$translations[title]</th>
                                            <th>$translations[date]</th>
                                            <th>$translations[actions]</th>
                                        </tr>";
                            while ($row = $selectdrafts_result->fetch_assoc()) {
                                $sn++;
                                $max_length = 60;
                                $title = $row["title"];
                                if (strlen($title) > $max_length) {
                                    $title = substr($title, 0, $max_length) . '...';
                                }
                                echo "<tr class='border-gradient-side-dark'>
                                            <td>" . $sn . "</td>
                                            <td>$title</td>
                                            <td>" . $row["formatted_date"] . "</td>
                                            <td><a class='edit' href='edit/post.php?id3=" . $row["id"] . "' target='_blank'>$translations[edit]</a> / <a class='delete' onclick='confirmDeleteD(" . $row['id'] . ")'>$translations[delete]</a></td>
                                        </tr>";
                            };
                            echo "</table>";
                        };
                        ?>
                    </div>
                </div>
                <div class="addtionalinfo">
                    <div class="addtionalinfo_header">
                        <h1><?php echo $translations['recent_pressrel']; ?></h1>
                        <a class="btn" href="view_all\pressreleases.php"><?php echo $translations['view_all']; ?></a>
                    </div>
                    <div class="addtionalinfo_body border-gradient-side-dark">
                        <?php
                        $selectpressreleases = "SELECT id, title, authors_lastname, authors_firstname, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM press_releases ORDER BY id DESC LIMIT 8";
                        $selectpressreleases_result = $conn->query($selectpressreleases);
                        if ($selectpressreleases_result->num_rows > 0) {
                            $sn = 0;
                            echo "<table>
                                        <tr>
                                            <th>S/n</th>
                                            <th>$translations[title]</th>
                                            <th>$translations[date]</th>
                                            <th>$translations[actions]</th>
                                        </tr>";
                            while ($row = $selectpressreleases_result->fetch_assoc()) {
                                $max_length = 60;
                                $title = $row["title"];
                                if (strlen($title) > $max_length) {
                                    $title = substr($title, 0, $max_length) . '...';
                                }
                                $sn++;
                                echo "<tr class='border-gradient-side-dark'>
                                            <td>" . $sn . "</td>
                                            <td>$title</td>
                                            <td>" . $row["formatted_date"] . "</td>
                                            <td><a class='edit' href='edit/post.php?id6=" . $row["id"] . "' target='_blank'>$translations[edit]</a> / <a class='delete' onclick='confirmDeletePR(" . $row['id'] . ")'>$translations[delete]</a></td>
                                        </tr>";
                            };
                            echo "</table>";
                        };
                        ?>
                    </div>
                </div>
                <div class="addtionalinfo">
                    <div class="addtionalinfo_header">
                        <h1><?php echo $translations['recent_news']; ?></h1>
                        <a class="btn" href="view_all\news.php"><?php echo $translations['view_all']; ?></a>
                    </div>
                    <div class="addtionalinfo_body border-gradient-side-dark">
                        <?php
                        $selectnews = "SELECT id, title, authors_lastname, authors_firstname, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM news ORDER BY id DESC LIMIT 8";
                        $selectnews_result = $conn->query($selectnews);
                        if ($selectnews_result->num_rows > 0) {
                            $sn = 0;
                            echo "<table>
                                        <tr>
                                            <th>S/n</th>
                                            <th>$translations[title]</th>
                                            <th>$translations[date]</th>
                                            <th>$translations[actions]</th>
                                        </tr>";
                            while ($row = $selectnews_result->fetch_assoc()) {
                                $max_length = 60;
                                $title = $row["title"];
                                if (strlen($title) > $max_length) {
                                    $title = substr($title, 0, $max_length) . '...';
                                }
                                $sn++;
                                echo "<tr class='border-gradient-side-dark'>
                                            <td>" . $sn . "</td>
                                            <td>$title</td>
                                            <td>" . $row["formatted_date"] . "</td>
                                            <td><a class='edit' href='edit/post.php?id4=" . $row["id"] . "' target='_blank'>$translations[edit]</a> / <a class='delete' onclick='confirmDeleteN(" . $row['id'] . ")'>$translations[delete]</a></td>
                                        </tr>";
                            };
                            echo "</table>";
                        };
                        ?>
                    </div>
                </div>
                <div class="addtionalinfo">
                    <div class="addtionalinfo_header">
                        <h1><?php echo $translations['recent_commentaries']; ?></h1>
                        <a class="btn" href="view_all\commentaries.php"><?php echo $translations['view_all']; ?></a>
                    </div>
                    <div class="addtionalinfo_body border-gradient-side-dark">
                        <?php
                        $selectcommentaries = "SELECT id, title, authors_lastname, authors_firstname, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM commentaries ORDER BY id DESC LIMIT 8";
                        $selectcommentaries_result = $conn->query($selectcommentaries);
                        if ($selectcommentaries_result->num_rows > 0) {
                            $sn = 0;
                            echo "<table>
                                        <tr>
                                            <th>S/n</th>
                                            <th>$translations[title]</th>
                                            <th>$translations[date]</th>
                                            <th>$translations[actions]</th>
                                        </tr>";
                            while ($row = $selectcommentaries_result->fetch_assoc()) {
                                $max_length = 60;
                                $title = $row["title"];
                                if (strlen($title) > $max_length) {
                                    $title = substr($title, 0, $max_length) . '...';
                                }
                                $sn++;
                                echo "<tr class='border-gradient-side-dark'>
                                            <td>" . $sn . "</td>
                                            <td>$title</td>
                                            <td>" . $row["formatted_date"] . "</td>
                                            <td><a class='edit' href='edit/post.php?id5=" . $row["id"] . "' target='_blank'>$translations[edit]</a> / <a class='delete' onclick='confirmDeleteC(" . $row['id'] . ")'>$translations[delete]</a></td>
                                        </tr>";
                            };
                            echo "</table>";
                        };
                        ?>
                    </div>
                </div>
                <div class="addtionalinfo">
                    <div class="addtionalinfo_header">
                        <h1><?php echo $translations['resources']; ?></h1>
                    </div>
                    <div class="addtionalinfo_body border-gradient-side-dark rowflexdisplay">
                        <?php
                        $result = mysqli_query($conn, "SELECT resource_name FROM resources");
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $originalName = $row['resource_name'];
                                $tableName = strtolower(str_replace(' ', '', $originalName));
                                $ucTablename = ucfirst($tableName);
                                $countQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM `$tableName`");
                                if ($countQuery) {
                                    $countResult = mysqli_fetch_assoc($countQuery);
                                    $rowCount = $countResult['total'];
                                    $iconClass = getIconForTable($tableName);
                                    echo "  <a class='collections_links' href='view_all/resources.php?resource_name=$tableName'>
                                                <i class='fa-solid $iconClass'></i>
                                                <p>$ucTablename(<span> $rowCount</span>)</p>
                                            </a>
                                        ";
                                }
                            }
                        }
                        ?>
                        <a class="collections_links" href="edit/frontend_features.php">
                            <i class="fa fa-plus-square" aria-hidden="true"></i>
                            <p><?php echo $translations['add_resource']; ?></p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="profile tab_content" id="tab2">
                <figure class="profile_imgbox" id="consent-data" data-id="<?php echo $_SESSION['id']; ?>">
                    <img src="<?php echo $_SESSION['image']; ?>" alt="Authors Profile Picture" class="profile_imgbox_img" />
                    <a class="profile_imgbox_edit" id="profileuploads" onclick="selectImage('profile_pic', '<?php echo $_SESSION['id']; ?>')" name="profile_pic">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                </figure>
                <div class="profile_body">
                    <p class="profile_firstp">
                        <span>
                            <?php echo $_SESSION['firstname']; ?>
                        </span>
                        <span>
                            <?php echo $_SESSION['lastname']; ?>
                        </span>
                        ( <span>
                            <?php echo $_SESSION['username']; ?>
                        </span>
                        )
                    </p>
                    <p>
                        <?php echo $_SESSION['bio']; ?>
                    </p>
                    <div class="profile_body_subdiv_subdiv">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <p>
                            <span>
                                <?php echo $_SESSION['address']; ?>,
                            </span>
                            <span>
                                <?php echo $_SESSION['city']; ?>,
                            </span>
                            <span>
                                <?php echo $_SESSION['state']; ?>,
                            </span>
                            <span>
                                <?php echo $_SESSION['country']; ?>.
                            </span>
                        </p>
                    </div>
                    <div class="profile_body_subdiv_subdiv">
                        <div>
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <p>
                                <span>
                                    <?php echo $_SESSION['email']; ?>
                                </span>
                            </p>
                        </div>
                        <div>
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <p>
                                <span>
                                    <?php echo $_SESSION['mobile']; ?>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="profile_body_subdiv_subdiv profilesubdiv">
                        <div>
                            <i class="fa fa-newspaper" aria-hidden="true"></i>
                            <?php
                            $id = $_SESSION['id'];
                            $total_posts = 0;
                            $tables = ['paid_posts', 'posts', 'news', 'press_releases', 'commentaries'];
                            foreach ($tables as $table) {
                                $sql = "SELECT COUNT(*) AS count FROM $table WHERE admin_id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("s", $id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                                $total_posts += $row['count'];
                                $stmt->close();
                            }
                            ?>
                            <p><?php echo $translations['posts_published']; ?>: <span><?php echo $total_posts; ?></span></p>
                        </div>
                    </div>
                    <div class="profile_body_subdiv_subdiv profilesubdiv">
                        <div>
                            <i class="fa fa-hourglass-start" aria-hidden="true"></i>
                            <p><?php echo $translations['date_joined']; ?>: <span><?php echo $date; ?></span></p>
                        </div>
                    </div>
                    <div class="profile_body_subdiv_subdiv profilesubdiv">
                        <a class="btn" href="edit/profile.php"><?php echo $translations['edit_profile']; ?></a>
                    </div>
                </div>
                <div class="profile_body-activities">
                    <div class="profile_body-activities_subdiv">
                        <h1><?php echo $translations['recent_activities']; ?></h1>
                        <a class="btn" href="pages/updates.php"><?php echo $translations['view_all']; ?></a>
                    </div>
                    <?php
                    $getuseractivities_sql = " SELECT content, Date, time FROM updates ORDER BY id DESC LIMIT 7";
                    $getuseractivities_result = $conn->query($getuseractivities_sql);
                    if ($getuseractivities_result->num_rows > 0) {
                        if (!function_exists('getOrdinalSuffix')) {
                            function getOrdinalSuffix($day)
                            {
                                if (!in_array(($day % 100), [11, 12, 13])) {
                                    switch ($day % 10) {
                                        case 1:
                                            return 'st';
                                        case 2:
                                            return 'nd';
                                        case 3:
                                            return 'rd';
                                    }
                                }
                                return 'th';
                            }
                        }
                        while ($row = $getuseractivities_result->fetch_assoc()) {
                            $time = $row['time'];
                            $date = $row['Date'];
                            $content = $row['content'];
                            $max_length = 64;
                            if (strlen($content) > $max_length) {
                                $content = substr($content, 0, $max_length) . '...';
                            }
                            $dateTime = new DateTime($date);
                            $day = $dateTime->format('j');
                            $month = $dateTime->format('M');
                            $year = $dateTime->format('Y');
                            $ordinalSuffix = getOrdinalSuffix($day);
                            $formattedDate = $month . ' ' . $day . $ordinalSuffix . ', ' . $year;
                            $formatted_time = date("g:i A", strtotime($time));
                            echo "<div class='profile_body-activities_subdiv border-gradient-side-dark'>
                                        <p>$content</p>
                                        <div class='datetime_div'>
                                            <p class='paragraph'>$formattedDate</p>
                                            <p>$formatted_time</p>
                                        </div>
                                    </div>
                                ";
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="users tab_content" id="tab3">
                <div class="users_admin_div userdiv">
                    <div class="user_header">
                        <h2><?php echo $translations['admin']; ?></h2>
                    </div>
                    <div class="users_div_subdiv border-gradient-side-dark">
                        <?php
                        $selectadmins = "SELECT id, email, image, firstname, lastname FROM admin_login_info ORDER BY id DESC LIMIT 3";
                        $selectadmins_result = $conn->query($selectadmins);
                        if ($selectadmins_result->num_rows > 0) {
                            $sn = 0;
                            while ($row = $selectadmins_result->fetch_assoc()) {
                                $id = $row['id'];
                                $image = $row['image'];
                                $firstname = $row['firstname'];
                                $lastname = $row['lastname'];
                                $email = $row['email'];
                                $total_posts = 0;
                                $tables = ['posts', 'news', 'press_releases', 'commentaries'];
                                foreach ($tables as $table) {
                                    $sql = "SELECT COUNT(*) AS count FROM $table WHERE admin_id = ?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("s", $id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $row = $result->fetch_assoc();
                                    $total_posts += $row['count'];
                                    $stmt->close();
                                }
                                $sn++;
                                echo "<div class='users_div_subdiv_subdiv divimages' style='background-image:url($image)'>
                                            <div class='divimages_side--back'>
                                                <p class='users_div_subdiv_p'><span>$translations[firstname]: </span>$firstname</p>
                                                <p class='users_div_subdiv_p'><span>$translations[lastname]: </span>$lastname</p> 
                                                <p class='users_div_subdiv_p'><span>$translations[role]: </span>Admin</p>
                                                <p class='users_div_subdiv_p'><span>$translations[email]: </span>$email</p>
                                                <p class='users_div_subdiv_p'><span>$translations[contributions]: </span>$total_posts</p>
                                            </div>
                                    </div>";
                            };
                        };
                        ?>
                    </div>
                </div>
                <div class="users_editor_div userdiv">
                    <div class="user_header">
                        <h2><?php echo $translations['editors']; ?></h2>
                        <a class="btn" href="view_all/editors.php"><?php echo $translations['view_all']; ?></a>
                    </div>
                    <div class="users_div_subdiv border-gradient-side-dark">
                        <?php
                        $idEditor = $_SESSION['id'];
                        $selecttwoothereditors = "SELECT id, email, image, firstname, lastname FROM editor ORDER BY id DESC LIMIT 3";
                        $selecttwoothereditors_result = $conn->query($selecttwoothereditors);
                        if ($selecttwoothereditors_result->num_rows > 0) {
                            $sn = 0;
                            while ($row = $selecttwoothereditors_result->fetch_assoc()) {
                                $id = $row['id'];
                                $image = $row['image'];
                                $firstname = $row['firstname'];
                                $lastname = $row['lastname'];
                                $email = $row['email'];
                                $total_posts = 0;
                                $tables = ['posts', 'news', 'press_releases', 'commentaries'];
                                foreach ($tables as $table) {
                                    $sql = "SELECT COUNT(*) AS count FROM $table WHERE editor_id = ?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("s", $id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $row = $result->fetch_assoc();
                                    $total_posts += $row['count'];
                                    $stmt->close();
                                }
                                $sn++;
                                echo "<div class='users_div_subdiv_subdiv divimages' style='background-image:url($image)'>
                                            <div class='divimages_side--back'>
                                                <p class='users_div_subdiv_p'><span>$translations[firstname]: </span>$firstname</p>
                                                <p class='users_div_subdiv_p'><span>$translations[lastname]: </span>$lastname</p> 
                                                <p class='users_div_subdiv_p'><span>$translations[role]: </span>Editor</p>
                                                <p class='users_div_subdiv_p'><span>$translations[email]: </span>$email</p>
                                                <p class='users_div_subdiv_p'><span>$translations[contributions]: </span>$total_posts</p>
                                            </div>
                                    </div>";
                            };
                        };
                        ?>
                    </div>
                </div>
                <div class="users_writer_div userdiv">
                    <div class="user_header">
                        <h2><?php echo $translations['writers']; ?></h2>
                        <a class="btn" href="view_all/writers.php"><?php echo $translations['view_all']; ?></a>
                    </div>
                    <div class="users_div_subdiv border-gradient-side-dark">
                        <?php
                        $selectwriters = "SELECT id, firstname, lastname, email, image  FROM writer ORDER BY id DESC LIMIT 3";
                        $selectwriters_result = $conn->query($selectwriters);
                        if ($selectwriters_result->num_rows > 0) {
                            $sn = 0;
                            while ($row = $selectwriters_result->fetch_assoc()) {
                                $id = $row['id'];
                                $image = $row['image'];
                                $firstname = $row['firstname'];
                                $lastname = $row['lastname'];
                                $email = $row['email'];
                                $total_posts = 0;
                                $tables = ['posts', 'news', 'press_releases', 'commentaries'];
                                foreach ($tables as $table) {
                                    $sql = "SELECT COUNT(*) AS count FROM $table WHERE authors_firstname = ?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("s", $firstname);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $row = $result->fetch_assoc();
                                    $total_posts += $row['count'];
                                    $stmt->close();
                                }
                                $sn++;
                                echo "<div class='users_div_subdiv_subdiv divimages' style='background-image:url($image)'>
                                            <div class='divimages_side--back'>
                                                <p class='users_div_subdiv_p'><span>$translations[firstname]: </span>$firstname</p>
                                                <p class='users_div_subdiv_p'><span>$translations[lastname]: </span>$lastname</p> 
                                                <p class='users_div_subdiv_p'><span>$translations[role]: </span>Writer</p>
                                                <p class='users_div_subdiv_p'><span>$translations[email]: </span>$email</p>
                                                <p class='users_div_subdiv_p'><span>$translations[contributions]: </span>$total_posts</p>
                                                <center>
                                                    <div class='users_delete_edit'>
                                                        <a class='users_edit' href='edit/user.php?id=$id&usertype=Writer'><i class='fa fa-eye' aria-hidden='true'></i></a>
                                                        <a class='users_delete' onclick='confirmDeleteWriter($id)'><i class='fa fa-trash' aria-hidden='true'></i></a>
                                                    </div>
                                                </center>
                                            </div>
                                    </div>";
                            };
                        };
                        ?>
                        <div class="users_div_subdiv_subdiv">
                            <a class="users_create" href="create_new/writer.php">
                                <center><i class="fa fa-plus" aria-hidden="true"></i></center>
                                <h3><?php echo $translations['new_writer']; ?></h3>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="users_writer_div userdiv">
                    <div class="user_header">
                        <h2><?php echo $translations['other_website_users']; ?></h2>
                        <a class="btn" href="view_all/otherusers.php"><?php echo $translations['view_all']; ?></a>
                    </div>
                    <div class="users_div_subdiv border-gradient-side-dark">
                        <?php
                        $selectotherusers = "SELECT * FROM otherwebsite_users ORDER BY id DESC LIMIT 3";
                        $selectotherusers_result = $conn->query($selectotherusers);
                        if ($selectotherusers_result->num_rows > 0) {
                            $sn = 0;
                            while ($row = $selectotherusers_result->fetch_assoc()) {
                                $sn++;
                                $image = $row['image'];
                                echo "<div class='users_div_subdiv_subdiv divimages' style='background-image:url($image)'>
                                            <div class='divimages_side--back'>
                                                <p class='users_div_subdiv_p'><span>$translations[firstname]: </span>" . $row['firstname'] . "</p>
                                                <p class='users_div_subdiv_p'><span>$translations[lastname]: </span>" . $row['lastname'] . "</p> 
                                                <p class='users_div_subdiv_p'><span>$translations[role]: </span>" . $row['role'] . "</p>
                                                <p class='users_div_subdiv_p'><span>$translations[email]: </span>" . $row['email'] . "</p>
                                                <center>
                                                    <div class='users_delete_edit'>
                                                        <a class='users_edit'href='edit/user.php?id=" . $row['id'] . "&usertype=Other_user'><i class='fa fa-eye' aria-hidden='true'></i></a>
                                                        <a class='users_delete' onclick='confirmDeleteOtheruser(" . $row['id'] . ")'><i class='fa fa-trash' aria-hidden='true'></i></a>
                                                    </div>
                                                </center>
                                            </div>
                                    </div>";
                            };
                        };
                        ?>
                        <div class="users_div_subdiv_subdiv">
                            <a class="users_create" href="create_new/user.php">
                                <center><i class="fa fa-plus" aria-hidden="true"></i></center>
                                <h3> <?php echo $translations['new_user']; ?></h3>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="posts tab_content" id="tab4">
                <div class="posts_div1 postsdiv">
                    <div class="posts_header">
                        <h1> <?php echo $translations['recent_posts']; ?></h1>
                        <a class="btn" href="view_all/posts.php"><?php echo $translations['view_all']; ?></a>
                    </div>
                    <div class="posts_divcontainer border-gradient-side-dark">
                        <?php
                        $selectposts2 = "SELECT id, title, time, schedule, admin_id, editor_id, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date, authors_firstname, authors_lastname FROM posts ORDER BY id DESC LIMIT 8";
                        $selectposts2_result = $conn->query($selectposts2);
                        if ($selectposts2_result->num_rows > 0) {
                            $author_firstname = "";
                            $author_lastname = "";
                            $sn = 0;
                            while ($row = $selectposts2_result->fetch_assoc()) {
                                if (!empty($row['admin_id'])) {
                                    $admin_id = $row['admin_id'];
                                    $sql_admin = "SELECT id, firstname, lastname FROM admin_login_info WHERE id = $admin_id";
                                    $result_admin = $conn->query($sql_admin);
                                    if ($result_admin->num_rows > 0) {
                                        $admin = $result_admin->fetch_assoc();
                                        $author_firstname = $admin['firstname'];
                                        $author_lastname = $admin['lastname'];
                                    }
                                } elseif (!empty($row['editor_id'])) {
                                    $editor_id = $row['editor_id'];
                                    $sql_editor = "SELECT id, firstname, lastname FROM editor WHERE id = $editor_id";
                                    $result_editor = $conn->query($sql_editor);
                                    if ($result_editor->num_rows > 0) {
                                        $editor = $result_editor->fetch_assoc();
                                        $author_firstname = $editor['firstname'];
                                        $author_lastname = $editor['lastname'];
                                    }
                                } else {
                                    $author_firstname = $row['author_firstname'];
                                    $author_lastname = $row['author_lastname'];
                                }
                                $time = $row['time'];
                                $formatted_time = date("g:i A", strtotime($time));
                                $sn++;
                                echo "<div class='posts_divcontainer_subdiv'>
                                            <div class='posts_divcontainer_subdiv_body'>
                                                <h3 class='posts_divcontainer_header'>" . $row['title'] . "</h3>
                                            </div>
                                            <div class='posts_divcontainer_subdiv2'>
                                                <p class='posts_divcontainer_p'>
                                                    <span> Written By:</span> $author_firstname $author_lastname
                                                </p>
                                            </div>
                                            <div class='posts_divcontainer_subdiv3'>
                                                <p class='posts_divcontainer_subdiv_p'>
                                                    <span> $translations[published_date]: </span>" . $row['formatted_date'] . "
                                                </p> 
                                                <p class='posts_divcontainer_subdiv_p'>
                                                    <span>$translations[published_time]:</span> " . $formatted_time . "
                                                </p> 
                                            </div>
                                            <div class='posts_delete_edit'>
                                                    <a class='users_edit' href='edit/post.php?id2=" . $row['id'] . "' target='_blank'>
                                                        <i class='fa fa-pencil' aria-hidden='true'></i>
                                                    </a>
                                                    <a class='users_delete' onclick='confirmDeleteP(" . $row['id'] . ")'>
                                                        <i class='fa fa-trash' aria-hidden='true'></i>
                                                    </a>
                                            </div>
                                    </div>";
                            };
                        };
                        ?>
                    </div>
                </div>
                <div class="posts_div2 postsdiv">
                    <div class="posts_header">
                        <h1><?php echo $translations['recent_drafts']; ?></h1>
                        <a class="btn" href="view_all/unpublished_articles.php"><?php echo $translations['view_all']; ?></a>
                    </div>
                    <div class="posts_divcontainer border-gradient-side-dark">
                        <?php
                        $selectdrafts2 = "SELECT id, title, time, admin_id, editor_id, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM unpublished_articles ORDER BY id DESC LIMIT 8";
                        $selectdrafts2_result = $conn->query($selectdrafts2);
                        if ($selectdrafts2_result->num_rows > 0) {
                            $sn = 0;
                            while ($row = $selectdrafts2_result->fetch_assoc()) {
                                $time = $row['time'];
                                $formatted_time = date("g:i A", strtotime($time));
                                $sn++;
                                echo "<div class='posts_divcontainer_subdiv'>
                                            <div class='posts_divcontainer_subdiv_body'>
                                                <h3 class='posts_divcontainer_header'>" . $row['title'] . "</h3>
                                            </div>
                                            <div class='posts_divcontainer_subdiv2'>
                                                <p class='posts_divcontainer_p'>
                                                    <span> Written By:</span> Aniagolu
                                                </p>
                                            </div>
                                            <div class='posts_divcontainer_subdiv3'>
                                                <p class='posts_divcontainer_subdiv_p'>
                                                    <span> $translations[published_date]: </span>" . $row['formatted_date'] . "
                                                </p> 
                                                <p class='posts_divcontainer_subdiv_p'>
                                                    <span> $translations[published_time]:</span> " . $formatted_time . "
                                                </p> 
                                            </div>
                                            <div class='posts_delete_edit'>
                                                <a class='users_edit' href='edit/post.php?id3=" . $row['id'] . "' target='_blank'>
                                                   <i class='fa fa-star' aria-hidden='true'></i>
                                                </a>
                                                <a class='users_edit' href='edit/post.php?id3=" . $row['id'] . "' target='_blank'>
                                                    <i class='fa fa-pencil' aria-hidden='true'></i>
                                                </a>
                                                <a class='users_delete' onclick='confirmDeleteD(" . $row['id'] . ")'>
                                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                                </a>
                                            </div>
                                    </div>";
                            };
                        };
                        ?>
                    </div>
                </div>
            </div>
            <div class="pages tab_content" id="tab5">
                <div class='pages_container'>
                    <h1><?php echo $translations['pages']; ?></h1>
                    <div class="pages_container_subdiv">
                        <a class='pages_container_subdiv-links' href="pages/categories.php">
                            <p><?php echo $translations['categories']; ?></p>
                        </a>
                    </div>
                    <?php
                    $getpages_sql = " SELECT id, page_name FROM pages ORDER BY id";
                    $getpages_result = $conn->query($getpages_sql);
                    if ($getpages_result->num_rows > 0) {
                        while ($row = $getpages_result->fetch_assoc()) {
                            $page_name = $row['page_name'];
                            $page_name1 = convertToUnreadable2($page_name);
                            $page_name2 = removeHyphen2($page_name);
                            $page_name2 = lowercaseNoSpace($page_name2);
                            $page_id = $row['id'];
                            echo "
                                <div class='pages_container_subdiv '>
                                    <a class='pages_container_subdiv-links' href='pages/$page_name2.php'>
                                        <p>$translations[$page_name1]</p>
                                    </a>
                                </div>";
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="settings tab_content" id="tab6">
                <div class='pages_container'>
                    <h1><?php echo $translations['settings']; ?></h1>
                    <div class="pages_container_subdiv">
                        <a class='pages_container_subdiv-links' href="pages\customisewebpage.php">
                            <i class="fa-solid fa-palette"></i>
                            <p><?php echo $translations['customise_website']; ?></p>
                        </a>
                    </div>
                    <div class="pages_container_subdiv ">
                        <a class='pages_container_subdiv-links' href="pages\changepassword.php">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                            <p><?php echo $translations['change_password']; ?></p>
                        </a>
                    </div>
                    <div class="pages_container_subdiv ">
                        <a class='pages_container_subdiv-links' href="pages\changelang.php">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                            <p><?php echo $translations['change_language']; ?></p>
                        </a>
                    </div>
                    <div class="pages_container_subdiv ">
                        <a class='pages_container_subdiv-links' href="pages\changepassword.php">
                            <i class="fa fa-clock" aria-hidden="true"></i>
                            <p><?php echo $translations['update_timezone_settings']; ?></p>
                        </a>
                    </div>
                    <div class="pages_container_subdiv ">
                        <a class='pages_container_subdiv-links' href="pages\create_metatitles.php">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <p><?php echo $translations['manage_meta']; ?></p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="developer_contact tab_content" id="tab7">
                <div class="developer_contact_container">
                    <div class="developer_contact_header">
                        <h1><?php echo $translations['contact_developer']; ?></h1>
                    </div>
                    <div class="developer_contact_container_body">
                        <div class="developer_contact_subdiv">
                            <h3><?php echo $translations['contact_developer_h3']; ?>:</h3>
                            <span>Leventis Tech Services</span>
                        </div>
                        <div class="developer_contact_subdiv">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            <p>River Rd Ugbomoro, Uvwie LGA, Delta State, Nigeria.</p>
                        </div>
                        <div class="developer_contact_subdiv">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <p>chiboyaniagolu3@gmail.com</p>
                        </div>
                        <div class="developer_contact_subdiv">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <p>+234 9122312493</p>
                        </div>
                        <div class="developer_contact_followlinks">
                            <h2><?php echo $translations['contact_developer_h2']; ?></h2>
                            <div>
                                <a href="https://wa.me/2349054223480"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>
                                <a href="https://www.linkedin.com/in/chiemelie-aniagolu-7799b32b0/" target="_blank"><i class="fab fa-linkedin" aria-hidden="true"></i></i></a>
                                <a><i class="fab fa-facebook" aria-hidden="true"></i></a>
                                <a href="https://x.com/vik_chiboy?t=Hf3kF-Fgx-LQFI5BhnTX3A&s=09"><i class="fa-brands fa-x-twitter"></i></a>
                            </div>
                        </div>
                        <div class="developer_contact_subdiv">
                            <a class="btn">
                                <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo $translations['contact_developer_issue']; ?>
                            </a>
                            <a class="btn" href="mailto:chiboyaniagolu3@gmail.com"><?php echo $translations['contact_us']; ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementsByClassName("sidebarbtn")[0].click();
        });
    </script>
    <script>
        async function selectImage(inputType, recordId) {
            const {
                value: file
            } = await Swal.fire({
                title: "Select image",
                input: "file",
                inputAttributes: {
                    accept: "image/*",
                    "aria-label": "Upload your image"
                }
            });

            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    Swal.fire({
                        title: "Your uploaded Image",
                        imageUrl: e.target.result,
                        imageAlt: "The uploaded Image",
                        confirmButtonText: "Upload"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            uploadImage(file, inputType, recordId);
                        }
                    });
                };
                reader.readAsDataURL(file);
            }
        }

        function uploadImage(file, inputType, recordId) {
            let formData = new FormData();
            formData.append(inputType, file);
            formData.append("id", recordId);

            fetch("../helpers/forms.php?id=" + encodeURIComponent(recordId), {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log("Server Response:", data);
                    Swal.fire("Success!", "Profile Picture Updated Successfully!", "success");
                })
                .catch(error => {
                    Swal.fire("Error!", "Image upload failed!", "error");
                });
        }

        function checkNotifications() {
            fetch('pages/check_notifications.php')
                .then(response => response.text())
                .then(count => {
                    const notificationCount = document.getElementById('notificationCount');
                    if (parseInt(count) > 0) {
                        notificationCount.style.display = 'inline-block';
                        notificationCount.textContent = count;
                        notificationCount.classList.add('notification-badge');
                    } else {
                        notificationCount.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error fetching notifications:', error));
        }
        setInterval(checkNotifications, 7000);
        window.onload = checkNotifications;
    </script>
    <script src="sweetalert2.all.min.js"></script>
    <script>
        var messageType = "<?= $_SESSION['status_type'] ?? ' ' ?>";
        var messageText = "<?= $_SESSION['status'] ?? ' ' ?>";
        if (messageType == 'Error' && messageText != " ") {
            Swal.fire({
                title: 'Error!',
                text: messageText,
                icon: 'error',
                confirmButtonText: 'Ok'
            })
        } else if (messageType == 'Success' && messageText != " ") {
            Swal.fire({
                title: 'Success',
                text: messageText,
                icon: 'success',
                confirmButtonText: 'Ok'
            })
        }
        <?php unset($_SESSION['status_type']); ?>
        <?php unset($_SESSION['status']); ?>
    </script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>

</html>