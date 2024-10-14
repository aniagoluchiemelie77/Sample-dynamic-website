<?php
session_start();
session_regenerate_id();
if(!isset($_SESSION['email'])) {
    header("Location: login/index.php");
};
require ("connect.php");
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
    <link rel="stylesheet" href="admin.css"/>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.0.1/js/anychart-core.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.0.1/js/anychart-pie.min.js"></script>
	<title>Admin Homepage</title>
</head>
<body>
    <div class="logout_alert hidden" id="logout_alert">
        <h1 class="logout_alert_header">Are You Sure You Want To Logout?</h1>
        <div>
            <a class="btn" href="extras/logout.php">Yes</a>
            <a class="btn cancellogout" id="dismiss-popup-btn">No</a>
        </div>
    </div>
    <div class="logout_alert container_center hidden" id="create_editor">
        <form class="create_editor_container popupform1" action="forms.php" method="post">
            <i class="fa fa-times popup_close1" aria-hidden="true"></i>
            <div class="createeditor_inputgroup">
                <h1>Create New Editor</h1>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label" for="editor_username">Username:</label>
                <input class="createeditor_input reginput" type="text" name="editor_username" required/>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label" for="editor_firstname">Firstname:</label>
                <input class="createeditor_input reginput" type="text" name="editor_firstname" required/>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label" for="editor_lastname">Lastname:</label>
                <input class="createeditor_input reginput" type="text" name="editor_lastname" required/>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label" for="editor_email">Email:</label>
                <input class="createeditor_input reginput" type="email" name="editor_email" required/>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label" for="editor_password">Suggest Password:</label>
                <input class="createeditor_input reginput" type="password" name="editor_password" required/>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label" for="editor_password-confirm">Confirm Password:</label>
                <input class="createeditor_input reginput" type="password" name="editor_password-confirm" required/>
            </div>
            <input class="createeditor_input-submit btn" value="Go" name="createeditor_Submit" type="submit"/>
        </form>
    </div>
    <div class="logout_alert container_center hidden" id="add_writer">
        <form class="create_editor_container popupform1" action="forms.php" method="post">
            <i class="fa fa-times popup_close1" aria-hidden="true"></i>
            <div class="createeditor_inputgroup">
                <h1>Add Writer</h1>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label" for="writer_firstname">Firstname:</label>
                <input class="createeditor_input reginput" type="text" name="writer_firstname" required/>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label" for="writer_lastname">Lastname:</label>
                <input class="createeditor_input reginput" type="text" name="writer_lastname" required/>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label" for="writer_email">Email:</label>
                <input class="createeditor_input reginput" type="email" name="writer_email" required/>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label" for="writer_bio">Short Bio:</label>
                <textarea class="writer_bio" name="writer_bio"></textarea>
            </div>
            <input class="createeditor_input-submit btn" value="Go" name="addwriter" type="submit"/>
        </form>
    </div>
    <div class="logout_alert container_center hidden" id="create_category">
        <form class="create_editor_container popupform1" action="forms.php" method="post">
            <i class="fa fa-times popup_close1" aria-hidden="true"></i>
            <div class="createeditor_inputgroup">
                <h1>Add Category</h1>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label" for="category_name">Category name</label>
                <input class="createeditor_input reginput" type="text" name="category_name" required/>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label" for="writer_bio">Description</label>
                <textarea class="writer_bio" name="writer_bio"></textarea>
            </div>
            <div class="createeditor_inputgroup">
                <label class="createeditor_label" for="writer_bio">Add Image</label>
                <div class="newpost_subdiv2">
                    <input class="form__input" name="Post_Image" type="file" required/>
                    <p class="newpost_subdiv2-p leftp">( <span>*</span>Image should be less than 300KB )</p>
                </div>
            </div>
            <input class="createeditor_input-submit btn" value="Go" name="addcategory" type="submit"/>
        </form>
    </div>
    <?php require("extras/header.php");?>
    <section class="body">
        <div class="sidebar">
            <div class="links_group" id="links">
                <div class="active sidebarbtn" id="tab">
                    <i class="fa fa-tachometer" aria-hidden="true"></i>
                    <p class="paragraph">
                        Dashboard
                    </p>
                </div>
                <div class="border-gradient-side sidebarbtn" id="tab">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <p class="paragraph">
                        Profile
                    </p>
                </div>
                <div class="border-gradient-side sidebarbtn" id="tab">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <p class="paragraph">
                        Users
                    </p>
                </div>
                <div class="border-gradient-side sidebarbtn" id="tab">
                    <i class="fa fa-newspaper" aria-hidden="true"></i>
                    <p class="paragraph">
                        Posts
                    </p>
                </div>
                <div class="border-gradient-side sidebarbtn" id="tab">
                    <i class="fa fa-sticky-note" aria-hidden="true"></i>
                    <p class="paragraph">
                        Pages
                    </p>
                </div>
                <div class="border-gradient-side sidebarbtn" id="tab">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    <p class="paragraph">
                        Settings
                    </p>
                </div>
                <div class="border-gradient-side sidebarbtn" id="tab">
                    <i class="fa fa-phone" aria-hidden="true"></i>
                    <p class="paragraph">
                        Contact Developer
                    </p>
                </div>
                <button class="logout border-gradient-side" id="open-popup-btn">
                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                    Logout
                </buton>
            </div>
            <p class="sidebar_footer">
                &copy; uniquetechcontentwriter 2024
            </p>
        </div>
        <div class="aside_sidebar">
            <div class="website_info_div tab_content active2" id="tab1">
                <h1 class="aside_sidebar_header">Welcome Back, <?php echo $_SESSION['username']?> </h1>
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
                            <p class="website_info_p1"><?php echo $totalRows;?></p>
                        </div>
                        <p class="website_info_p2">Published</p>
                    </div>
                    <?php 
                        };
                        $subscribers = "SELECT COUNT(*) as total FROM subscribers";
                        $result = $conn->query($subscribers);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                    ?>
                    <a class="website_info" href="pages/subscribers.php">
                        <div class="website_info_subdiv">
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                            <p class="website_info_p1"><?php echo $row["total"];?></p>
                        </div>
                        <p class="website_info_p2">Subscribers</p>
                    </a>
                    <?php 
                        };
                        $newslettersignup_count = "SELECT COUNT(*) as total FROM newsletter_subscribers";
                        $newslettersignupcount_result = $conn->query($newslettersignup_count);
                        if ($newslettersignupcount_result->num_rows > 0) {
                            $row = $newslettersignupcount_result->fetch_assoc();
                    ?>
                    <a class="website_info" href="pages/newslettersignups.php">
                        <div class="website_info_subdiv">
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                            <p class="website_info_p1"><?php echo $row["total"];?></p>
                        </div>
                        <p class="website_info_p2">Signups</p>
                    </a>
                    <?php };?>
                    <a class="website_info" href="create_new/posts.php" target="_blank">
                        <div class="website_info_subdiv">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </div>
                        <p class="website_info_p2">New Post</p>
                    </a>
                    <a class="website_info" href="../index.php" target="_blank">
                        <div class="website_info_subdiv">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                        </div>
                        <p class="website_info_p2">View Website</p>
                    </a>
                    <a class="website_info" href="create_new/workspace.php">
                        <div class="website_info_subdiv">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </div>
                        <p class="website_info_p2">Add Draft</p>
                    </a>
                    <a class="website_info" id="messagediv" href="messages.php">
                        <div class="website_info_subdiv">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </div>
                        <p class="website_info_p2">Add Message</p>
                    </a>
                </div>
                <div class="addtionalinfo">
                    <div class="addtionalinfo_header">
                        <h1>Recent Posts</h1>
                        <a class="btn" href="view_all/posts.php">View All</a>
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
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>";
                                while($row = $selectposts_result->fetch_assoc()) {
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
                                            <td><a class='edit' href='edit/post.php?id2=".$row["id"]."' target='_blank'>Edit</a> / <a class='delete' onclick='deletePost('".$row['id']."', 'posts')>Delete</a></td>
                                        </tr>";                           
                        
                                }; echo "</table>";
                            };
                        ?>
                    </div>
                </div>
                <div class="addtionalinfo">
                    <div class="addtionalinfo_header">
                        <h1>Recent Drafts</h1>
                        <a class="btn" href="view_all/unpublished_articles.php">View All</a>
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
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>";
                                while($row = $selectdrafts_result->fetch_assoc()) {
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
                                            <td><a class='edit' href='edit/post.php?id3=".$row["id"]."' target='_blank'>Edit</a> / <a class='delete' onclick='deletePost('".$row['id']."', 'unpublished_articles')>Delete</a></td>
                                        </tr>";                           
                        
                                }; echo "</table>";
                            };
                        ?>
                    </div>
                </div>
                <div class="addtionalinfo">
                    <div class="addtionalinfo_header">
                        <h1>Recent Press Releases</h1>
                        <a class="btn" href="view_all\pressreleases.php">View All</a>
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
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>";
                                while($row = $selectpressreleases_result->fetch_assoc()) {
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
                                            <td><a class='edit' href='edit/post.php?id6=".$row["id"]."' target='_blank'>Edit</a> / <a class='delete' onclick='deletePost('".$row['id']."', 'press_releases')>Delete</a></td>
                                        </tr>";                           
                        
                                }; echo "</table>";
                            };
                        ?>
                    </div>
                </div>
                <div class="addtionalinfo">
                    <div class="addtionalinfo_header">
                        <h1>Recent News Posts</h1>
                        <a class="btn" href="view_all\news.php">View All</a>
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
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>";
                                while($row = $selectnews_result_result->fetch_assoc()) {
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
                                            <td><a class='edit' href='edit/post.php?id4=".$row["id"]."' target='_blank'>Edit</a> / <a class='delete' onclick='deletePost('".$row['id']."', 'unpublished_articles')>Delete</a></td>
                                        </tr>";                           
                        
                                }; echo "</table>";
                            };
                        ?>
                    </div>
                </div>
                <div class="addtionalinfo">
                    <div class="addtionalinfo_header">
                        <h1>Recent Commentaries</h1>
                        <a class="btn" href="view_all\commentaries.php">View All</a>
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
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>";
                                while($row = $selectcommentaries_result->fetch_assoc()) {
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
                                            <td><a class='edit' href='edit/post.php?id5=".$row["id"]."' target='_blank'>Edit</a> / <a class='delete' onclick='deletePost('".$row['id']."', 'commentaries')>Delete</a></td>
                                        </tr>";                           
                        
                                }; echo "</table>";
                            };
                        ?>
                    </div>
                </div>
                <div class="addtionalinfo">
                    <div class="addtionalinfo_header">
                        <h1>Collections</h1>
                    </div>
                    <div class="addtionalinfo_body border-gradient-side-dark rowflexdisplay">
                        <?php
                            $count_ebooks = "SELECT COUNT(*) as total FROM ebooks";
                            $count_ebooks_result = $conn->query($count_ebooks);
                            if ($count_ebooks_result->num_rows > 0) {
                                $row1 = $count_ebooks_result->fetch_assoc();
                        ?>
                        <a class="collections_links" href="collections\ebooks.php">
                            <i class="fa-solid fa-book"></i> 
                            <p>Ebooks (<span><?php echo $row1["total"];?></span>)</p>
                        </a>
                        <?php 
                            };
                            $count_whitepapers = "SELECT COUNT(*) as total FROM whitepapers";
                            $count_whitepapers_result = $conn->query($count_whitepapers);
                            if ($count_whitepapers_result->num_rows > 0) {
                                $row1 = $count_whitepapers_result->fetch_assoc();
                        ?>
                        <a class="collections_links" href="collections\whitepapers.php">
                            <i class="fa-sharp fa-regular fa-copy"></i> 
                            <p>White Papers (<span><?php echo $row1["total"];?></span>)</p>
                        </a>
                        <?php 
                            };
                            $count_videoscripts = "SELECT COUNT(*) as total FROM whitepapers";
                            $count_videoscripts_result = $conn->query($count_videoscripts);
                            if ($count_videoscripts_result->num_rows > 0) {
                                $row1 = $count_videoscripts_result->fetch_assoc();
                        ?>
                        <a class="collections_links" href="collections\videoscripts.php">
                            <i class="fa fa-file-video" aria-hidden="true"></i>               
                            <p>Video Scripts (<span><?php echo $row1["total"];?></span>)</p>
                        </a>
                        <?php };?>
                        <a class="collections_links" href="create_new\collections.php">
                            <i class="fa fa-plus-square" aria-hidden="true"></i>         
                            <p>Add Collection</p>
                        </a>
                    </div>
                </div>
                <div class="addtionalinfo">
                    <div class="addtionalinfo_header">
                        <h1>Top Visits</h1>
                        <a class="btn" href="view_all\visits.php" target="_blank">View All</a>
                    </div>
                    <div class="addtionalinfo_body border-gradient-side-dark visits">
                        <?php
                            $countrycount = "SELECT country, COUNT(*) as visit_count FROM web_visitors GROUP BY country ORDER BY visit_count DESC LIMIT 6";
                            $result = $conn->query($countrycount);
                            if ($result->num_rows > 0) {
                                $i = 0;
                                echo "<table>
                                        <tr>
                                            <th>S/n</th>
                                            <th>Country Name</th>
                                            <th>Total Visits</th>
                                        </tr>";
                                while($row = $result->fetch_assoc()) {    
                                    $i ++;
                                    echo "<tr class='border-gradient-side-dark'>
                                            <td>" . $i . "</td>
                                            <td>" . $row["country"] . "</td>
                                            <td>" . $row["visit_count"] . "</td>
                                        </tr>";    
                        ?>
                        <?php }  echo "</table>";};?>
                    </div>
                </div>
                <div class="addtionalinfo">
                    <div class="addtionalinfo_header">
                        <h1>Website Statistics</h1>
                    </div>
                    <div class="addtionalinfo_body border-gradient-side-dark stats">
                        <div class="visits_subdiv visitsubdivs border-gradient-side2-dark">
                            <div id="pie_container" style="width:90%; height:80%"></div>
                        </div>   
                        <div class="visits_subdiv2 visitsubdivs">
                            <h1 class="visits_subdiv2_header padding_b">Page Views</h1>
                            <div class="visits_subdiv2_subdiv">
                                <p>60%</p>
                            </div>
                            <p class="visits_subdiv2_p"> 
                                <span>Aug 12th</span> -
                                <span> Sept 12</span>
                            </p>
                        </div>
                        <div class="visits_subdiv3 visitsubdivs border-gradient-side-dark">
                            <div id="pie_chartcontainer2" style="width: 100%; height: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile tab_content hidden" id="tab2">
                <figure class="profile_imgbox">
                    <img src="../images/Diamakaimg1.png" alt="Authors Profile Picture" class="profile_imgbox_img"/>
                    <a class="profile_imgbox_edit" id="profileuploads">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                    <form id="edit_profile_container" action="forms.php" method="post">
                        <input type="file" id="file_upload_id" style="display:none" capture="camera" accept="images/*" multiple>
                    </form>
                </figure>
                <div class="profile_body">
                    <p class="profile_firstp">
                        <span>
                            <?php echo $_SESSION['firstname'];?> 
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
                                    <?php echo $_SESSION['mobile'];?>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="profile_body_subdiv_subdiv profilesubdiv">
                        <div>
                            <i class="fa fa-newspaper" aria-hidden="true"></i>
                            <p>Posts Published: <span>25</span></p>
                        </div>
                    </div>
                    <div class="profile_body_subdiv_subdiv profilesubdiv">
                        <div>
                            <i class="fa fa-hourglass-start" aria-hidden="true"></i>
                            <p>Date Joined: <span>25th July 2024</span></p>
                        </div>
                    </div>
                    <div class="profile_body_subdiv_subdiv profilesubdiv">
                        <a class="btn" href="edit/profile.php">Edit Profile</a>
                    </div>
                </div>
                <div class="profile_body-activities">
                    <div class="profile_body-activities_subdiv">
                        <h1>Recent Activities</h1>
                        <a class="btn">View All</a>
                    </div>
                    <div class="profile_body-activities_subdiv border-gradient-side-dark">
                        <p>Created new admin</p>
                        <p>10th July 2024</p>
                    </div>
                    <div class="profile_body-activities_subdiv border-gradient-side-dark">
                        <p>Created new admin</p>
                        <p>10th July 2024</p>
                    </div>
                    <div class="profile_body-activities_subdiv border-gradient-side-dark">
                        <p>Created new admin</p>
                        <p>10th July 2024</p>
                    </div>
                    <div class="profile_body-activities_subdiv border-gradient-side-dark">
                        <p>Created new admin</p>
                        <p>10th July 2024</p>
                    </div>
                    <div class="profile_body-activities_subdiv border-gradient-side-dark">
                        <p>Created new admin</p>
                        <p>10th July 2024</p>
                    </div>
                </div>
            </div>
            <div class="users tab_content hidden" id="tab3">
                <div class="users_admin_div userdiv">
                    <div class="user_header">
                        <h2>Admin</h2>
                    </div>
                    <div class="users_div_subdiv border-gradient-side-dark">
                        <div class="users_div_subdiv_subdiv divimages" style="background-image:url('<?php echo '../' . $_SESSION['image']; ?>')">
                            <div class="divimages_side--back">
                                <p class="users_div_subdiv_p">
                                    <span>Username:</span>
                                    <?php echo $_SESSION['username']; ?>
                                </p>
                                <p class="users_div_subdiv_p">
                                    <span>Firstname:</span>
                                        <?php echo $_SESSION['firstname']; ?>
                                </p> 
                                <p class="users_div_subdiv_p">
                                    <span>Role:</span>
                                     Admin
                                </p>
                                <p class="users_div_subdiv_p">
                                    <span>Email:</span>
                                    <?php
                                        if(isset($_SESSION['email'])){
                                            $email = $_SESSION['email'];
                                            $query = mysqli_query($conn, "SELECT admin_login_info.* FROM `admin_login_info` WHERE admin_login_info.email = '$email'");
                                            while($row = mysqli_fetch_array($query)){
                                                echo $row['email'];
                                            }
                                        }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="users_editor_div userdiv">
                    <div class="user_header">
                        <h2>Editors</h2>
                        <a class="btn" href="view_all/editors.php">View All</a>
                    </div>
                    <div class="users_div_subdiv border-gradient-side-dark">
                        <?php
                            $selectthreeeditors = "SELECT * FROM editor ORDER BY id DESC LIMIT 3";
                            $selectthreeeditors_result = $conn->query($selectthreeeditors);
                            if ($selectthreeeditors_result->num_rows > 0) {
                                $sn = 0;
                                while($row = $selectthreeeditors_result->fetch_assoc()) {
                                    $sn++; 
                                    $image = $row['image'];
                                    echo "<div class='users_div_subdiv_subdiv divimages' style='background-image:url(../$image)'>
                                            <div class='divimages_side--back'>
                                                <p class='users_div_subdiv_p'><span>Username: </span>".$row['username']."</p>
                                                <p class='users_div_subdiv_p'><span>Firstname: </span>".$row['firstname']."</p> 
                                                <p class='users_div_subdiv_p'><span>Role: </span>Editor</p>
                                                <p class='users_div_subdiv_p'><span>Email: </span>".$row['email']."</p>
                                                <center>
                                                    <div class='users_delete_edit'>
                                                        <a class='users_edit'><i class='fa fa-eye' aria-hidden='true'></i></a>
                                                        <a class='users_delete'><i class='fa fa-trash' aria-hidden='true'></i></a>
                                                    </div>
                                                </center>
                                            </div>
                                    </div>";                         
                                };
                            };
                        ?>
                        <div class="users_div_subdiv_subdiv">
                            <a class="users_create" id="create_user-origin">
                                <center><i class="fa fa-plus" aria-hidden="true"></i></center>
                                <h3> New Editor</h3>
                            </a>    
                        </div>
                    </div>
                </div>
                <div class="users_writer_div userdiv">
                    <div class="user_header">
                        <h2>Writers</h2>
                        <a class="btn" href="view_all/writers.php">View All</a>
                    </div>
                    <div class="users_div_subdiv border-gradient-side-dark">
                        <?php
                            $selectwriters = "SELECT * FROM writer ORDER BY id DESC LIMIT 3";
                            $selectwriters_result = $conn->query($selectwriters);
                            if ($selectwriters_result->num_rows > 0) {
                                $sn = 0;
                                while($row = $selectwriters_result->fetch_assoc()) {
                                    $sn++; 
                                    $image = $row['image'];
                                    echo "<div class='users_div_subdiv_subdiv divimages' style='background-image:url(../$image)'>
                                            <div class='divimages_side--back'>
                                                <p class='users_div_subdiv_p'><span>Firstname: </span>".$row['firstname']."</p>
                                                <p class='users_div_subdiv_p'><span>Lastname: </span>".$row['lastname']."</p> 
                                                <p class='users_div_subdiv_p'><span>Role: </span>Writer</p>
                                                <p class='users_div_subdiv_p'><span>Email: </span>".$row['email']."</p>
                                                <p class='users_div_subdiv_p'><span>Contributions: </span>Plenty</p>
                                                <center>
                                                    <div class='users_delete_edit'>
                                                        <a class='users_edit'><i class='fa fa-eye' aria-hidden='true'></i></a>
                                                        <a class='users_delete'><i class='fa fa-trash' aria-hidden='true'></i></a>
                                                    </div>
                                                </center>
                                            </div>
                                    </div>";                         
                                };
                            };
                        ?>
                        <div class="users_div_subdiv_subdiv">
                            <a class="users_create" id="create_writer_origin">
                                <center><i class="fa fa-plus" aria-hidden="true"></i></center>
                                <h3> New Writer</h3>
                            </a>    
                        </div>
                    </div>
                </div>
                <div class="users_writer_div userdiv">
                    <div class="user_header">
                        <h2>Others Website Users</h2>
                        <a class="btn" href="view_all/otherusers.php">View All</a>
                    </div>
                    <div class="users_div_subdiv border-gradient-side-dark">
                        <?php
                            $selectotherusers = "SELECT * FROM otherwebsite_users ORDER BY id DESC LIMIT 3";
                            $selectotherusers_result = $conn->query($selectotherusers);
                            if ($selectotherusers_result->num_rows > 0) {
                                $sn = 0;
                                while($row = $selectotherusers_result->fetch_assoc()) {
                                    $sn++; 
                                    $image = $row['image'];
                                    echo "<div class='users_div_subdiv_subdiv divimages' style='background-image:url(../$image)'>
                                            <div class='divimages_side--back'>
                                                <p class='users_div_subdiv_p'><span>Firstname: </span>".$row['firstname']."</p>
                                                <p class='users_div_subdiv_p'><span>Lastname: </span>".$row['lastname']."</p> 
                                                <p class='users_div_subdiv_p'><span>Role: </span>".$row['role']."</p>
                                                <p class='users_div_subdiv_p'><span>Email: </span>".$row['email']."</p>
                                                <p class='users_div_subdiv_p'><span>Contributions: </span>Plenty</p>
                                                <center>
                                                    <div class='users_delete_edit'>
                                                        <a class='users_edit'><i class='fa fa-eye' aria-hidden='true'></i></a>
                                                        <a class='users_delete'><i class='fa fa-trash' aria-hidden='true'></i></a>
                                                    </div>
                                                </center>
                                            </div>
                                    </div>";                         
                                };
                            };
                        ?>
                        <div class="users_div_subdiv_subdiv">
                            <a class="users_create" id="create_writer_origin">
                                <center><i class="fa fa-plus" aria-hidden="true"></i></center>
                                <h3> New User</h3>
                            </a>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="posts tab_content hidden" id="tab4">
                <div class="posts_div2 postsdiv">
                    <div class="posts_header">
                        <h1> Paid Posts</h1>
                    </div>
                    <div class="posts_divcontainer border-gradient-side-dark">
                        <?php
                            $selectposts3 = "SELECT id, title, image, time, schedule, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM paid_posts ORDER BY id DESC";
                            $selectposts3_result = $conn->query($selectposts3);
                            if ($selectposts3_result->num_rows > 0) {
                                $sn = 0;
                                while($row = $selectposts3_result->fetch_assoc()) {
                                    $time = $row['time'];
                                    $formatted_time = date("g:i A", strtotime($time));
                                    $sn++; 
                                    echo "<div class='posts_divcontainer_subdiv'>
                                            <div class='posts_divcontainer_subdiv_body'>
                                                <h3 class='posts_divcontainer_header'>".$row['title']."</h3>
                                            </div>
                                            <div class='posts_divcontainer_subdiv3'>
                                                <p class='posts_divcontainer_subdiv_p'>
                                                    <span> Publish Date: </span>".$row['formatted_date']."
                                                </p> 
                                                <p class='posts_divcontainer_subdiv_p'>
                                                    <span> Publish Time:</span> ".$formatted_time."
                                                </p> 
                                            </div>
                                             <div class='posts_delete_edit'>
                                                    <a class='users_edit' href='edit/post.php?id1=".$row['id']."' target='_blank'>
                                                        <i class='fa fa-pencil' aria-hidden='true'></i>
                                                    </a>
                                                    <a class='users_delete'>
                                                        <i class='fa fa-trash' aria-hidden='true'></i>
                                                    </a>
                                            </div>
                                    </div>";                           
                                };
                            };
                        ?>
                    </div>
                </div>
                <div class="posts_div1 postsdiv">
                    <div class="posts_header">
                        <h1> Recently Published Posts</h1>
                        <a class="btn" href="view_all/posts.php" target="_blank">View All</a>
                    </div>
                    <div class="posts_divcontainer border-gradient-side-dark">
                        <?php
                            $selectposts2 = "SELECT id, title, time, schedule, 	admin_id, editor_id, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM posts ORDER BY id DESC LIMIT 8";
                            $selectposts2_result = $conn->query($selectposts2);
                            if ($selectposts2_result->num_rows > 0) {
                                $sn = 0;
                                while($row = $selectposts2_result->fetch_assoc()) {
                                    $time = $row['time'];
                                    $formatted_time = date("g:i A", strtotime($time));
                                    $sn++; 
                                    echo "<div class='posts_divcontainer_subdiv'>
                                            <div class='posts_divcontainer_subdiv_body'>
                                                <h3 class='posts_divcontainer_header'>".$row['title']."</h3>
                                            </div>
                                            <div class='posts_divcontainer_subdiv2'>
                                                <p class='posts_divcontainer_p'>
                                                    <span> Written By:</span> Aniagolu
                                                </p>
                                            </div>
                                            <div class='posts_divcontainer_subdiv3'>
                                                <p class='posts_divcontainer_subdiv_p'>
                                                    <span> Publish Date: </span>".$row['formatted_date']."
                                                </p> 
                                                <p class='posts_divcontainer_subdiv_p'>
                                                    <span> Publish Time:</span> ".$formatted_time."
                                                </p> 
                                            </div>
                                            <div class='posts_delete_edit'>
                                                    <a class='users_edit' href='edit/post.php?id2=".$row['id']."' target='_blank'>
                                                        <i class='fa fa-pencil' aria-hidden='true'></i>
                                                    </a>
                                                    <a class='users_delete'>
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
                        <h1> Unpublished Articles</h1>
                        <a class="btn" href="view_all/unpublished_articles.php">View All</a>
                    </div>
                    <div class="posts_divcontainer border-gradient-side-dark">
                        <?php
                            $selectdrafts2 = "SELECT id, title, time, admin_id, editor_id, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM unpublished_articles ORDER BY id DESC LIMIT 8";
                            $selectdrafts2_result = $conn->query($selectdrafts2);
                            if ($selectdrafts2_result->num_rows > 0) {
                                $sn = 0;
                                while($row = $selectdrafts2_result->fetch_assoc()) {
                                    $time = $row['time'];
                                    $formatted_time = date("g:i A", strtotime($time));
                                    $sn++; 
                                    echo "<div class='posts_divcontainer_subdiv'>
                                            <div class='posts_divcontainer_subdiv_body'>
                                                <h3 class='posts_divcontainer_header'>".$row['title']."</h3>
                                            </div>
                                            <div class='posts_divcontainer_subdiv2'>
                                                <p class='posts_divcontainer_p'>
                                                    <span> Written By:</span> Aniagolu
                                                </p>
                                            </div>
                                            <div class='posts_divcontainer_subdiv3'>
                                                <p class='posts_divcontainer_subdiv_p'>
                                                    <span> Publish Date: </span>".$row['formatted_date']."
                                                </p> 
                                                <p class='posts_divcontainer_subdiv_p'>
                                                    <span> Publish Time:</span> ".$formatted_time."
                                                </p> 
                                            </div>
                                            <div class='posts_delete_edit'>
                                                <a class='users_edit' href='edit/post.php?id3=".$row['id']."' target='_blank'>
                                                   <i class='fa fa-star' aria-hidden='true'></i>
                                                </a>
                                                <a class='users_edit' href='edit/post.php?id3=".$row['id']."' target='_blank'>
                                                    <i class='fa fa-pencil' aria-hidden='true'></i>
                                                </a>
                                                <a class='users_delete'>
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
            <div class="pages tab_content hidden" id="tab5">
                <div class='pages_container'>
                    <h1>Pages</h1>
                    <div class="pages_container_subdiv">
                        <a class='pages_container_subdiv-links' href="pages/categories.php">
                            <p>Categories</p>
                        </a>
                    </div>
                    <div class="pages_container_subdiv ">
                        <a class='pages_container_subdiv-links' href="pages/aboutwebsite.php">
                            <p>About Website</p>
                        </a>
                    </div>
                    <div class="pages_container_subdiv">
                        <a class='pages_container_subdiv-links' href="pages/advertisewithus.php">
                            <p>Advertise With Us</p>
                        </a>
                    </div>
                    <div class="pages_container_subdiv">
                        <a class='pages_container_subdiv-links' href="pages/contactus.php">
                            <p>Contact Us</p>
                        </a>
                    </div>
                    <div class="pages_container_subdiv">
                        <a class='pages_container_subdiv-links' href="pages/privacypolicy.php">
                            <p>Privacy Policy</p>
                        </a>
                    </div>
                    <div class="pages_container_subdiv">
                        <a class='pages_container_subdiv-links' href="pages/termsofservice.php">
                            <p>Terms of Services</p>
                        </a>
                    </div>
                    <div class="pages_container_subdiv">
                        <a class='pages_container_subdiv-links' href="pages/workwithus.php">
                            <p>Work with Us</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="settings tab_content hidden" id="tab6">
                <div class='pages_container'>
                    <h1>Settings</h1>
                    <div class="pages_container_subdiv">
                        <a class='pages_container_subdiv-links' href="pages\customisewebpage.php">
                            <i class="fa-solid fa-palette"></i>
                            <p>Customize Website</p>
                        </a>
                    </div>
                    <div class="pages_container_subdiv ">
                        <a class='pages_container_subdiv-links' href="pages\changepassword.php">
                            <i class="fa fa-lock" aria-hidden="true"></i> 
                            <p>Change Password</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="developer_contact tab_content hidden" id="tab7">
                <div class="developer_contact_container">
                    <div class="developer_contact_header">
                        <h1>Contact Website Developer</h1>
                    </div>
                    <div class="developer_contact_container_body">
                        <div class="developer_contact_subdiv">
                            <h3>Developed And Managed By:</h3>
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
                            <h2>Connect With Us On Social Media</h2>
                            <div>
                                <a href="https://wa.me/2349054223480"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>
                                <a href="https://www.linkedin.com/in/chiemelie-aniagolu-7799b32b0/" target="_blank"><i class="fab fa-linkedin" aria-hidden="true"></i></i></a>
                                <a><i class="fab fa-facebook" aria-hidden="true"></i></a>
                                <a href="https://x.com/vik_chiboy?t=Hf3kF-Fgx-LQFI5BhnTX3A&s=09"><i class="fa-brands fa-x-twitter"></i></a>
                            </div>
                        </div>
                        <div class="developer_contact_subdiv">
                            <a class="btn">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>Report an Issue
                            </a> 
                            <a class="btn" href="mailto:chiboyaniagolu3@gmail.com">Contact Us</a>
                        </div> 
                    </div>  
                </div>    
            </div>
        </div>  
        <script>
            <?php
                $condition_value1 = 'Tablet';
                $condition_value2 = 'Desktop';
                $condition_value3 = 'Mobile'; // Replace with your condition value
                $devicecount1 = "SELECT COUNT(*) as count_tablet FROM web_visitors WHERE user_devicetype = '$condition_value1'";
                $devicecount2 = "SELECT COUNT(*) as count_dextop FROM web_visitors WHERE user_devicetype = '$condition_value2'";
                $devicecount3 = "SELECT COUNT(*) as count_mobile FROM web_visitors WHERE user_devicetype = '$condition_value3'";
                $result_mobile = $conn->query($devicecount3);
                $result_desktop = $conn->query($devicecount2);
                $result_tablet = $conn->query($devicecount1);
                if ($result_mobile->num_rows > 0 && $result_desktop->num_rows > 0 && $result_tablet->num_rows > 0) {
                    $row_mobile = $result_mobile->fetch_assoc();
                    $row_desktop = $result_desktop->fetch_assoc();
                    $row_tablet = $result_tablet->fetch_assoc();
            ?>
            anychart.onDocumentReady(function(){
                var data = [
                    {x: "Dextop", value: <?php echo $row_desktop["count_desktop"];?>, exploded: true},
                    {x: "Tablet", value: <?php echo $row_tablet["count_tablet"];?>},
                    {x: "Mobile", value: <?php echo $row_mobile["count_mobile"];?>}
                ];
                var chart = anychart.pie();
                chart.title("Visitors Devices Statistics");
                chart.data(data);
                chart.container("pie_container")
                chart.draw();
                chart.legend().itemsLayout("vertical");
                chart.legend().position("right");
                chart.sort("desc");  
            });
            <?php }; 
                $condition_value1 = 'new';
                $condition_value2 = 'returning';
                $usertype_query1 = "SELECT COUNT(*) as count_new FROM web_visitors WHERE visit_type = '$condition_value1'";
                $usertype_query2 = "SELECT COUNT(*) as count_returning FROM web_visitors WHERE visit_type = '$condition_value2'";
                $result_usertype_query1 = $conn->query($usertype_query1);
                $result_usertype_query2 = $conn->query($usertype_query2);
                if ($result_usertype_query1->num_rows > 0 && $result_usertype_query2->num_rows > 0) {
                    $row_returning = $result_usertype_query2->fetch_assoc();
                    $row_new = $result_usertype_query1->fetch_assoc();
                    $row_tablet = $result_tablet->fetch_assoc();
            ?>
            anychart.onDocumentReady(function(){
                var data2 = [
                    {x: "New visitors", value: <?php echo $row_new["count_new"];?>, exploded: true},
                    {x: "Returning visitors", value: <?php echo $row_returning["count_returning"];?>},
                ];
                var chart2 = anychart.pie();
                chart2.title("Visitors Statistics");
                chart2.data(data2);
                chart2.container("pie_chartcontainer2")
                chart2.draw();
                chart2.legend().itemsLayout("vertical");
                chart2.legend().position("right");
                chart2.sort("desc");  
            });
            <?php }; $conn->close(); ?>
        </script>  
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript" src="otherJSFiles/custom.js"></script>
    </section>
    <script src="admin.js"></script> 
</body>
</html>