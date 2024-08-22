<?php
session_start();
session_regenerate_id();
if(!isset($_SESSION['email'])) {
    header("Location: index.php");
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
    <link rel="stylesheet" href="editor.css"/>
    <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdn.anychart.com/releases/8.0.1/js/anychart-core.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.0.1/js/anychart-pie.min.js"></script>
	<title>Editor's Homepage</title>
</head>
<body>
    <div class="logout_alert hidden">
        <h1 class="logout_alert_header">Are You Sure You Want To Logout?</h1>
        <div>
            <a class="btn" href="extras/logout.php">Yes</a>
            <a class="btn cancellogout">No</a>
        </div>
    </div>
    <div class="logout_alert container_center hidden" id="create_writer">
        <form class="create_editor_container" action="forms.php" method="post">
        <i class="fa fa-times" aria-hidden="true"></i>
        <div class="createeditor_inputgroup">
            <h1>Create New Writer</h1>
        </div>
        <div class="createeditor_inputgroup">
            <label class="createeditor_label" for="writer_firstname">Firstname:</label>
            <input class="createeditor_input" type="text" name="writer_firstname" required/>
        </div>
        <div class="createeditor_inputgroup">
            <label class="createeditor_label" for="writer_lastname">Lastname:</label>
            <input class="createeditor_input" type="text" name="writer_lastname" required/>
        </div>
        <div class="createeditor_inputgroup">
            <label class="createeditor_label" for="writer_email">Email:</label>
            <input class="createeditor_input" type="email" name="writer_email" required/>
        </div>
        <div class="createeditor_inputgroup">
            <label class="createeditor_label" for="writer_password">Suggest Password:</label>
            <input class="createeditor_input" type="password" name="writer_password" required/>
        </div>
        <div class="createeditor_inputgroup">
            <label class="createeditor_label" for="writer_password-confirm">Confirm Password:</label>
            <input class="createeditor_input" type="text" name="writer_password-confirm" required/>
        </div>
        <input class="createeditor_input-submit btn" value="Submit" name="Createwriter_Submit" type="submit"/>
        </form>
    </div>
    <div class="logout_alert2 container_center hidden" id="write_message">
        <form class="create_editor_container2" action="forms.php" method="post">
            <i class="fa fa-times" aria-hidden="true"></i>
            <div class="message_popup_btns" id='messagebtns'>
                <a class="message_popup_btns-a active">To Editors</a>
                <a class="message_popup_btns-a notactive_btn">To Writers</a>
            </div>
            <div class="message_popup_contents" id="messagebody">
                <div class="message_popup_contents_div1">
                    <div>
                        <label for="message_textarea">Compose Message</label>
                        <textarea name="message_textarea"></textarea>
                    </div>
                    <input class="addmessage" value="Submit" name="addmessage_Submit" type="submit"/>
                </div>
                <div class="message_popup_contents_div2 hidden">
                    <div>
                        <label for="message_textarea">Compose Message</label>
                        <textarea name="message_textarea"></textarea>
                    </div>
                    <input class="addmessage" value="Submit" name="addmessage_Submit" type="submit"/>
                </div>
            </div>
        </form>
    </div>
    <div class="logout_alert container_center hidden" id="create_writer">
        <form class="create_editor_container" action="forms.php" method="post">
        <i class="fa fa-times" aria-hidden="true"></i>
        <div class="createeditor_inputgroup">
            <h1>Create New Writer</h1>
        </div>
        <div class="createeditor_inputgroup">
            <label class="createeditor_label" for="writer_firstname">Firstname:</label>
            <input class="createeditor_input" type="text" name="writer_firstname" required/>
        </div>
        <div class="createeditor_inputgroup">
            <label class="createeditor_label" for="writer_lastname">Lastname:</label>
            <input class="createeditor_input" type="text" name="writer_lastname" required/>
        </div>
        <div class="createeditor_inputgroup">
            <label class="createeditor_label" for="writer_email">Email:</label>
            <input class="createeditor_input" type="email" name="writer_email" required/>
        </div>
        <div class="createeditor_inputgroup">
            <label class="createeditor_label" for="writer_password">Suggest Password:</label>
            <input class="createeditor_input" type="password" name="writer_password" required/>
        </div>
        <div class="createeditor_inputgroup">
            <label class="createeditor_label" for="writer_password-confirm">Confirm Password:</label>
            <input class="createeditor_input" type="text" name="writer_password-confirm" required/>
        </div>
        <input class="createeditor_input-submit btn" value="Submit" name="Createwriter_Submit" type="submit"/>
        </form>
    </div>
    <!--<div class="logout_alert container_center hidden" id="delete">
        <h1 class="logout_alert_header">Post Successfully Deleted.</h1>
    </div>-->
    <header class="header">
        <div class="header_logobox">
            <img src="#" alt="Website Logo">
        </div>
        <form class="header_searchbar" action="script.php" method="get">
            <input type="text" name="search" placeholder="Search.." />
            <button class="fa fa-search" id="tutorial_name" aria-hidden="true" name="search_btn" type="submit" formenctype="text/plain"></button>
        </form>
        <div class="header_img">
            <a class="notification" href="#">
                <span></span>
                <i class="fa fa-bell" aria-hidden="true"></i>
            </a>
            <img src="images\image1.jpeg" alt="Author's Image"/>
        </div>
    </header>
    <section class="body">
        <div class="sidebar">
            <div class="links_group">
                <div class="dashboard active sidebarbtn">
                    <i class="fa fa-tachometer" aria-hidden="true"></i>
                    <p class="paragraph">
                        Dashboard
                    </p>
                </div>
                <div class="sidebar_profile border-gradient-side sidebarbtn">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <p class="paragraph">
                        Profile
                    </p>
                </div>
                <div class="sidebar_users border-gradient-side sidebarbtn">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <p class="paragraph">
                        Users
                    </p>
                </div>
                <div class="sidebar_posts border-gradient-side sidebarbtn">
                    <i class="fa fa-newspaper" aria-hidden="true"></i>
                    <p class="paragraph">
                        Posts
                    </p>
                </div>
                <div class="sidebar_settings border-gradient-side sidebarbtn">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    <p class="paragraph">
                        Settings
                    </p>
                </div>
                <div class="Contact Developer border-gradient-side sidebarbtn">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <p class="paragraph">
                        Report Issue
                    </p>
                </div>
                <div class="logout border-gradient-side">
                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                    <p class="paragraph">
                        Logout
                    </p>
                </div>
            </div>
            <p class="sidebar_footer">
                &copy; uniquetechcontentwriter 2024
            </p>
        </div>
        <div class="aside_sidebar">
            <div class="website_info_div tabcontent active2">
                <div class = "message_box">
                    <i class="fa fa-bullhorn" aria-hidden="true"></i>
                    <p>Please all editors should ensure to update profile before end of this Month.</p>
                </div>
                <h1 class="aside_sidebar_header">Welcome, 
                    <?php
                        if(isset($_SESSION['email'])){
                            $email = $_SESSION['email'];
                            $query = mysqli_query($conn, "SELECT admin_login_info.* FROM `admin_login_info` WHERE admin_login_info.email = '$email'");
                            while($row = mysqli_fetch_array($query)){
                                echo $row['username'];
                            }
                        }
                    ?> 
                </h1>
                <div class="webinfo_container">
                    <div class="website_info">
                        <div class="website_info_subdiv">
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                            <p class="website_info_p1">15k</p>
                        </div>
                        <p class="website_info_p2">Published</p>
                    </div>
                    <a class="website_info" href="create_new/posts.php" target="_blank">
                        <div class="website_info_subdiv">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </div>
                        <p class="website_info_p2">New Post</p>
                    </a>
                    <a class="website_info" href="create_new/workspace.php">
                        <div class="website_info_subdiv">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </div>
                        <p class="website_info_p2">Add Draft</p>
                    </a>
                </div>
                <div class="addtionalinfo">
                    <div class="addtionalinfo_header">
                        <h1>Recent Posts</h1>
                        <a class="btn" href="view_all/posts.php">View All</a>
                    </div>
                    <div class="addtionalinfo_body border-gradient-side-dark">
                        <table>
                            <tr>
                              <th>Article</th>
                              <th>Views</th>
                              <th>Comments</th>
                              <th>Date</th>
                              <th>Update</th>
                            </tr>
                            <tr class="border-gradient-side-dark">
                              <td>Futterkiste</td>
                              <td>20</td>
                              <td>3</td>
                              <td>July 10th 2024</td>
                              <td>
                                <a class="edit" href="#" target="_blank">View</a>
                              </td>
                            </tr>
                            <tr>
                                <td>Futterkiste</td>
                                <td>50</td>
                                <td>6</td>
                                <td>July 10th 2024</td>
                                <td>
                                    <a class="edit" href="#" target="_blank">View</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Futterkiste</td>
                                <td>100</td>
                                <td>10</td>
                                <td>July 10th 2024</td>
                                <td>
                                    <a class="edit" href="#" target="_blank">View</a>
                                </td>
                              </tr>
                              <tr>
                                <td>Futterkiste</td>
                                <td>36</td>
                                <td>12</td>
                                <td>July 10th 2024</td>
                                <td>
                                    <a class="edit" href="#" target="_blank">View</a>
                                </td>
                              </tr>
                              <tr>
                                <td>Futterkiste</td>
                                <td>55</td>
                                <td>32</td>
                                <td>July 10th 2024</td>
                                <td>
                                    <a class="edit" href="#" target="_blank">View</a>
                                </td>
                              </tr>
                              <tr>
                                <td>Futterkiste</td>
                                <td>43</td>
                                <td>40</td>
                                <td>July 10th 2024</td>
                                <td>
                                    <a class="edit" href="#" target="_blank">View</a>
                                </td>
                              </tr>
                          </table>
                    </div>
                </div>
                <div class="addtionalinfo">
                    <div class="addtionalinfo_header">
                        <h1>Recent Articles</h1>
                        <a class="btn" href="view_all/unpublished_articles.php">View All</a>
                    </div>
                    <div class="addtionalinfo_body border-gradient-side-dark">
                        <table>
                            <tr>
                              <th>Article</th>
                              <th>Author</th>
                              <th>Date</th>
                              <th>Actions</th>
                            </tr>
                            <tr class="border-gradient-side-dark">
                              <td>Futterkiste</td>
                              <td>Maria Anders</td>
                              <td>July 10th 2024</td>
                              <td>
                                <a class="edit" href="edit/post.php?edit=<?php echo $id;?>" target="_blank">Edit</a> /
                                <a class="delete" href="#">Delete</a>
                            </td>
                            </tr>
                            <tr>
                              <td>Futterkiste</td>
                              <td>Francisco Chang</td>
                              <td>July 10th 2024</td>
                              <td>
                                <a class="edit" href="edit/post.php" target="_blank">Edit</a> /
                                <a class="delete" href="#">Delete</a>
                            </td>
                            </tr>
                            <tr>
                                <td>Futterkiste</td>
                                <td>Francisco Chang</td>
                                <td>July 10th 2024</td>
                                <td>
                                  <a class="edit" href="edit/post.php" target="_blank">Edit</a> /
                                  <a class="delete" href="#">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Futterkiste</td>
                                <td>Francisco Chang</td>
                                <td>July 10th 2024</td>
                                <td>
                                  <a class="edit" href="edit/post.php" target="_blank">Edit</a> /
                                  <a class="delete" href="#">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Futterkiste</td>
                                <td>Francisco Chang</td>
                                <td>July 10th 2024</td>
                                <td>
                                  <a class="edit" href="edit/post.php" target="_blank">Edit</a> /
                                  <a class="delete" href="#">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Futterkiste</td>
                                <td>Francisco Chang</td>
                                <td>July 10th 2024</td>
                                <td>
                                  <a class="edit" href="edit/post.php" target="_blank">Edit</a> /
                                  <a class="delete" href="#">Delete</a>
                                </td>
                            </tr>
                          </table>
                    </div>
                </div>
            </div>
            <div class="profile tabcontent hidden">
                <figure class="profile_imgbox">
                    <img src="images\image1.jpeg" alt="Authors Profile Picture" class="profile_imgbox_img"/>
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
                            <?php
                                if(isset($_SESSION['email'])){
                                    $email = $_SESSION['email'];
                                    $query = mysqli_query($conn, "SELECT admin_login_info.* FROM `admin_login_info` WHERE admin_login_info.email = '$email'");
                                    while($row = mysqli_fetch_array($query)){
                                        echo $row['firstName'];
                                    }
                                }
                            ?> 
                        </span>
                        <span>
                            <?php
                                if(isset($_SESSION['email'])){
                                    $email = $_SESSION['email'];
                                    $query = mysqli_query($conn, "SELECT admin_login_info.* FROM `admin_login_info` WHERE admin_login_info.email = '$email'");
                                    while($row = mysqli_fetch_array($query)){
                                        echo $row['lastName'];
                                    }
                                }
                            ?>
                        </span> 
                      ( <span>
                            <?php
                                if(isset($_SESSION['email'])){
                                    $email = $_SESSION['email'];
                                    $query = mysqli_query($conn, "SELECT admin_login_info.* FROM `admin_login_info` WHERE admin_login_info.email = '$email'");
                                    while($row = mysqli_fetch_array($query)){
                                        echo $row['username'];
                                    }
                                }
                            ?>
                        </span>
                        ) 
                    </p>
                    <p>
                        <?php
                            if(isset($_SESSION['email'])){
                                $email = $_SESSION['email'];
                                $query = mysqli_query($conn, "SELECT admin_login_info.* FROM `admin_login_info` WHERE admin_login_info.email = '$email'");
                                while($row = mysqli_fetch_array($query)){
                                    echo $row['admin_bio'];
                                }
                            }
                        ?>
                    </p>
                    <div class="profile_body_subdiv_subdiv">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <p>
                            <span>
                                <?php
                                    if(isset($_SESSION['email'])){
                                        $email = $_SESSION['email'];
                                        $query = mysqli_query($conn, "SELECT admin_login_info.* FROM `admin_login_info` WHERE admin_login_info.email = '$email'");
                                        while($row = mysqli_fetch_array($query)){
                                            echo $row['address1'];
                                        }
                                    }
                                ?>,
                            </span>
                            <span>
                                <?php
                                    if(isset($_SESSION['email'])){
                                        $email = $_SESSION['email'];
                                        $query = mysqli_query($conn, "SELECT admin_login_info.* FROM `admin_login_info` WHERE admin_login_info.email = '$email'");
                                        while($row = mysqli_fetch_array($query)){
                                            echo $row['admin_city'];
                                        }
                                    }
                               ?>, 
                            </span>
                            <span>
                                <?php
                                    if(isset($_SESSION['email'])){
                                        $email = $_SESSION['email'];
                                        $query = mysqli_query($conn, "SELECT admin_login_info.* FROM `admin_login_info` WHERE admin_login_info.email = '$email'");
                                        while($row = mysqli_fetch_array($query)){
                                            echo $row['admin_state'];
                                        }
                                    }
                                ?>, 
                            </span>
                            <span> 
                                <?php
                                    if(isset($_SESSION['email'])){
                                        $email = $_SESSION['email'];
                                        $query = mysqli_query($conn, "SELECT admin_login_info.* FROM `admin_login_info` WHERE admin_login_info.email = '$email'");
                                        while($row = mysqli_fetch_array($query)){
                                            echo $row['admin_country'];
                                        }
                                    }
                                ?>.
                            </span>
                        </p>
                    </div>
                    <div class="profile_body_subdiv_subdiv">
                        <div>
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <p>
                                <span>
                                    <?php
                                        if(isset($_SESSION['email'])){
                                            $email = $_SESSION['email'];
                                            $query = mysqli_query($conn, "SELECT admin_login_info.* FROM `admin_login_info` WHERE admin_login_info.email = '$email'");
                                            while($row = mysqli_fetch_array($query)){
                                                echo $row['email'];
                                            }
                                        }
                                    ?>
                                </span>
                            </p>
                        </div>
                        <div>
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <p>
                                <span>
                                    <?php
                                        if(isset($_SESSION['email'])){
                                            $email = $_SESSION['email'];
                                            $query = mysqli_query($conn, "SELECT admin_login_info.* FROM `admin_login_info` WHERE admin_login_info.email = '$email'");
                                            while($row = mysqli_fetch_array($query)){
                                                echo $row['admin_moblie'];
                                            }
                                        }
                                    ?>
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
                        <a class="btn" target="_blank" href="edit/profile.php">Edit Profile</a>
                    </div>
                </div>
                <div class="profile_body-activities">
                    <div class="profile_body-activities_subdiv">
                        <h1>Activities</h1>
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
            <div class="users tabcontent hidden">
                <div class="users_admin_div userdiv">
                    <div class="user_header">
                        <h2>Admin</h2>
                    </div>
                    <div class="users_div_subdiv border-gradient-side-dark">
                        <div class="users_div_subdiv_subdiv divimages">
                            <div class="divimages_side--back">
                                <p class="users_div_subdiv_p">
                                    <span>Username:</span>
                                    <?php
                                        if(isset($_SESSION['email'])){
                                            $email = $_SESSION['email'];
                                            $query = mysqli_query($conn, "SELECT admin_login_info.* FROM `admin_login_info` WHERE admin_login_info.email = '$email'");
                                            while($row = mysqli_fetch_array($query)){
                                                echo $row['username'];
                                            }
                                        }
                                    ?>
                                </p>
                                <p class="users_div_subdiv_p">
                                    <span>Firstname:</span>
                                        <?php
                                            if(isset($_SESSION['email'])){
                                                $email = $_SESSION['email'];
                                                $query = mysqli_query($conn, "SELECT admin_login_info.* FROM `admin_login_info` WHERE admin_login_info.email = '$email'");
                                                while($row = mysqli_fetch_array($query)){
                                                    echo $row['firstName'];
                                                }
                                            }
                                        ?>
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
                            <!--<div class="user_imgbox">
                                <img src="images/newDiamakaimg1.png" alt="admin's image"/>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="users_editor_div userdiv">
                    <div class="user_header">
                        <h2>Editors</h2>
                        <a class="btn" href="view_all/editors.php" target="_blank">View All</a>
                    </div>
                    <div class="users_div_subdiv border-gradient-side-dark">
                        <div class="users_div_subdiv_subdiv divimages">
                            <div class="divimages_side--back">
                                <p class="users_div_subdiv_p">
                                    <span>Username:</span>
                                    <?php
                                        if(isset($_SESSION['email'])){
                                            $email = $_SESSION['email'];
                                            $query = mysqli_query($conn, "SELECT admin_login_info.* FROM `admin_login_info` WHERE admin_login_info.email = '$email'");
                                            while($row = mysqli_fetch_array($query)){
                                                echo $row['username'];
                                            }
                                        }
                                    ?>
                                </p>
                                <p class="users_div_subdiv_p">
                                    <span>Firstname:</span>
                                    <?php
                                        if(isset($_SESSION['email'])){
                                            $email = $_SESSION['email'];
                                            $query = mysqli_query($conn, "SELECT admin_login_info.* FROM `admin_login_info` WHERE admin_login_info.email = '$email'");
                                            while($row = mysqli_fetch_array($query)){
                                                echo $row['firstName'];
                                            }
                                        }
                                    ?>
                                </p> 
                                <p class="users_div_subdiv_p">
                                    <span>Role:</span>
                                    Editor
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
                                <center>
                                    <div class="users_delete_edit">
                                        <a class="users_edit" href="edit/editor.php" target="_blank">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </center>
                            </div>
                        </div>
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
                        <a class="btn" href="view_all/writers.php" target="_blank">View All</a>
                    </div>
                    <div class="users_div_subdiv border-gradient-side-dark">
                        <div class="users_div_subdiv_subdiv divimages">
                            <div class="divimages_side--back">
                            <p class="users_div_subdiv_p">
                                <span>Username:</span>
                                <?php
                               if(isset($_SESSION['email'])){
                                  $email = $_SESSION['email'];
                                  $query = mysqli_query($conn, "SELECT admin_login_info.* FROM `admin_login_info` WHERE admin_login_info.email = '$email'");
                                  while($row = mysqli_fetch_array($query)){
                                    echo $row['username'];
                                   }
                                }
                                ?>
                            </p>
                            <p class="users_div_subdiv_p">
                                <span>Firstname:</span>
                                <?php
                               if(isset($_SESSION['email'])){
                                  $email = $_SESSION['email'];
                                  $query = mysqli_query($conn, "SELECT admin_login_info.* FROM `admin_login_info` WHERE admin_login_info.email = '$email'");
                                  while($row = mysqli_fetch_array($query)){
                                    echo $row['firstName'];
                                   }
                                }
                                ?>
                            </p> 
                            <p class="users_div_subdiv_p">
                                <span>Role:</span>
                                Writer
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
                            <center>
                                <div class="users_delete_edit">
                                    <a class="users_edit" href="edit/writer.php" target="_blank">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                    <a class="users_delete">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </center>
                            </div>
                        </div>
                        <div class="users_div_subdiv_subdiv">
                            <a class="users_create" id="create_writer_origin">
                                <center><i class="fa fa-plus" aria-hidden="true"></i></center>
                                <h3> New Writer</h3>
                            </a>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="posts tabcontent hidden">
                <div class="posts_div1 postsdiv">
                    <div class="posts_header">
                        <h1> Recently Published Posts</h1>
                        <a class="btn" href="view_all/posts.php" target="_blank">View All</a>
                    </div>
                    <div class="posts_divcontainer border-gradient-side-dark">
                        <div class="posts_divcontainer_subdiv">
                            <div class="posts_divcontainer_subdiv_body">
                                <h3 class="posts_divcontainer_header">
                                    Post Title
                                </h3>
                                <div class="posts_delete_edit">
                                    <a class="users_edit" href="edit/post.php">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="posts_divcontainer_subdiv2">
                                    <p class="posts_divcontainer_p">
                                        <span> Written By:</span> Aniagolu
                                    </p>
                                    <p class="posts_divcontainer_p">
                                        <span> Edited By:</span> Chiemelie
                                    </p>
                            </div>
                            <div class="posts_divcontainer_subdiv3">
                                <p class="posts_divcontainer_subdiv_p">
                                    <span> Publish Date:</span> 10th July 2024.
                                </p> 
                                <p class="posts_divcontainer_subdiv_p">
                                    <span> Publish Time:</span> 10:00 pm.
                                </p> 
                            </div>
                            <div class="posts_divcontainer_subdiv4">
                                <a class="posts_divcontainer_subdiv_a" href="#" target="_blank">
                                    <span class="fa fa-thumbs-up" aria-hidden="true"></span> 10k.
                                </a> 
                                <a class="posts_divcontainer_subdiv_a" href="#" target="_blank">
                                    <span class="fa fa-thumbs-down" aria-hidden="true"></span> 10.
                                </a> 
                                <a class="posts_divcontainer_subdiv_a" href="#" target="_blank">
                                    <span class="fa fa-comment" aria-hidden="true"></span> 200
                                </a> 
                            </div>
                        </div>
                        <div class="posts_divcontainer_subdiv border-gradient-side-dark">
                            <div class="posts_divcontainer_subdiv_body">
                                <h3 class="posts_divcontainer_header">
                                    Post Title
                                </h3>
                                <div class="posts_delete_edit">
                                    <a class="users_edit" href="edit/post.php" target="_blank">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="posts_divcontainer_subdiv2">
                                    <p class="posts_divcontainer_p">
                                        <span> Written By:</span> Aniagolu
                                    </p>
                                    <p class="posts_divcontainer_p">
                                        <span> Edited By:</span> Chiemelie
                                    </p>
                            </div>
                            <div class="posts_divcontainer_subdiv3">
                                <p class="posts_divcontainer_subdiv_p">
                                    <span> Publish Date:</span> 10th July 2024.
                                </p> 
                                <p class="posts_divcontainer_subdiv_p">
                                    <span> Publish Time:</span> 10:00 pm.
                                </p> 
                            </div>
                            <div class="posts_divcontainer_subdiv4">
                                <a class="posts_divcontainer_subdiv_a" href="#" target="_blank">
                                    <span class="fa fa-thumbs-up" aria-hidden="true"></span> 10k.
                                </a> 
                                <a class="posts_divcontainer_subdiv_a" href="#" target="_blank">
                                    <span class="fa fa-thumbs-down" aria-hidden="true"></span> 10.
                                </a> 
                                <a class="posts_divcontainer_subdiv_a" href="#" target="_blank">
                                    <span class="fa fa-comment" aria-hidden="true"></span> 200
                                </a> 
                            </div>
                        </div>
                        <div class="posts_divcontainer_subdiv border-gradient-side-dark">
                            <div class="posts_divcontainer_subdiv_body">
                                <h3 class="posts_divcontainer_header">
                                    Post Title
                                </h3>
                                <div class="posts_delete_edit">
                                    <a class="users_edit" href="edit/post.php" target="_blank">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="posts_divcontainer_subdiv2">
                                    <p class="posts_divcontainer_p">
                                        <span> Written By:</span> Aniagolu
                                    </p>
                                    <p class="posts_divcontainer_p">
                                        <span> Edited By:</span> Chiemelie
                                    </p>
                            </div>
                            <div class="posts_divcontainer_subdiv3">
                                <p class="posts_divcontainer_subdiv_p">
                                    <span> Publish Date:</span> 10th July 2024.
                                </p> 
                                <p class="posts_divcontainer_subdiv_p">
                                    <span> Publish Time:</span> 10:00 pm.
                                </p> 
                            </div>
                            <div class="posts_divcontainer_subdiv4">
                                <a class="posts_divcontainer_subdiv_a" href="#" target="_blank">
                                    <span class="fa fa-thumbs-up" aria-hidden="true"></span> 10k.
                                </a> 
                                <a class="posts_divcontainer_subdiv_a" href="#" target="_blank">
                                    <span class="fa fa-thumbs-down" aria-hidden="true"></span> 10.
                                </a> 
                                <a class="posts_divcontainer_subdiv_a" href="#" target="_blank">
                                    <span class="fa fa-comment" aria-hidden="true"></span> 200
                                </a> 
                            </div>
                        </div>
                        <div class="posts_divcontainer_subdiv border-gradient-side-dark">
                            <div class="posts_divcontainer_subdiv_body">
                                <h3 class="posts_divcontainer_header">
                                    Post Title
                                </h3>
                                <div class="posts_delete_edit">
                                    <a class="users_edit" href="edit/post.php" target="_blank">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="posts_divcontainer_subdiv2">
                                    <p class="posts_divcontainer_p">
                                        <span> Written By:</span> Aniagolu
                                    </p>
                                    <p class="posts_divcontainer_p">
                                        <span> Edited By:</span> Chiemelie
                                    </p>
                            </div>
                            <div class="posts_divcontainer_subdiv3">
                                <p class="posts_divcontainer_subdiv_p">
                                    <span> Publish Date:</span> 10th July 2024.
                                </p> 
                                <p class="posts_divcontainer_subdiv_p">
                                    <span> Publish Time:</span> 10:00 pm.
                                </p> 
                            </div>
                            <div class="posts_divcontainer_subdiv4">
                                <a class="posts_divcontainer_subdiv_a" href="#" target="_blank">
                                    <span class="fa fa-thumbs-up" aria-hidden="true"></span> 10k.
                                </a> 
                                <a class="posts_divcontainer_subdiv_a" href="#" target="_blank">
                                    <span class="fa fa-thumbs-down" aria-hidden="true"></span> 10.
                                </a> 
                                <a class="posts_divcontainer_subdiv_a" href="#" target="_blank">
                                    <span class="fa fa-comment" aria-hidden="true"></span> 200
                                </a> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="posts_div2 postsdiv">
                    <div class="posts_header">
                        <h1> Unpublished Articles</h1>
                        <a class="btn" href="view_all/unpublished_articles.php" target="_blank">View All</a>
                    </div>
                    <div class="posts_divcontainer border-gradient-side-dark">
                        <div class="posts_divcontainer_subdiv">
                            <div class="posts_divcontainer_subdiv_body">
                                <h3 class="posts_divcontainer_header">
                                    Post Title
                                </h3>
                                <div class="posts_delete_edit">
                                    <a class="users_edit" href="edit/post.php" target="_blank">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    <a class="users_delete">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="posts_divcontainer_subdiv2">
                                    <p class="posts_divcontainer_p">
                                        <span> Written By:</span> Aniagolu
                                    </p>
                            </div>
                            <div class="posts_divcontainer_subdiv3">
                                <p class="posts_divcontainer_subdiv_p">
                                    <span> Written On:</span> 10th July 2024.
                                </p> 
                                <p class="posts_divcontainer_subdiv_p">
                                    <span> Time:</span> 10:00 pm.
                                </p> 
                            </div>
                        </div>
                        <div class="posts_divcontainer_subdiv border-gradient-side-dark">
                            <div class="posts_divcontainer_subdiv_body">
                                <h3 class="posts_divcontainer_header">
                                    Post Title
                                </h3>
                                <div class="posts_delete_edit">
                                    <a class="users_edit" href="edit/post.php" target="_blank">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    <a class="users_delete">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="posts_divcontainer_subdiv2">
                                    <p class="posts_divcontainer_p">
                                        <span> Written By:</span> Aniagolu
                                    </p>
                            </div>
                            <div class="posts_divcontainer_subdiv3">
                                <p class="posts_divcontainer_subdiv_p">
                                    <span> Written On:</span> 10th July 2024.
                                </p> 
                                <p class="posts_divcontainer_subdiv_p">
                                    <span> Time:</span> 10:00 pm.
                                </p> 
                            </div>
                        </div>
                        <div class="posts_divcontainer_subdiv border-gradient-side-dark">
                            <div class="posts_divcontainer_subdiv_body">
                                <h3 class="posts_divcontainer_header">
                                    Post Title
                                </h3>
                                <div class="posts_delete_edit">
                                    <a class="users_edit" href="edit/post.php" target="_blank">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    <a class="users_delete">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="posts_divcontainer_subdiv2">
                                    <p class="posts_divcontainer_p">
                                        <span> Written By:</span> Aniagolu
                                    </p>
                            </div>
                            <div class="posts_divcontainer_subdiv3">
                                <p class="posts_divcontainer_subdiv_p">
                                    <span> Written On:</span> 10th July 2024.
                                </p> 
                                <p class="posts_divcontainer_subdiv_p">
                                    <span>Time:</span> 10:00 pm.
                                </p> 
                            </div>
                        </div>
                        <div class="posts_divcontainer_subdiv border-gradient-side-dark">
                            <div class="posts_divcontainer_subdiv_body">
                                    <h3 class="posts_divcontainer_header">
                                        Post Title
                                    </h3>
                                <div class="posts_delete_edit">
                                    <a class="users_edit" href="edit/post.php" target="_blank">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    <a class="users_delete">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="posts_divcontainer_subdiv2">
                                    <p class="posts_divcontainer_p">
                                        <span> Written By:</span> Aniagolu
                                    </p>
                            </div>
                            <div class="posts_divcontainer_subdiv3">
                                <p class="posts_divcontainer_subdiv_p">
                                    <span> Written On:</span> 10th July 2024.
                                </p> 
                                <p class="posts_divcontainer_subdiv_p">
                                    <span> Time:</span> 10:00 pm.
                                </p> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="settings tabcontent hidden">
                <h1>Settings</h1>
            </div>
            <div class="developer_contact tabcontent hidden">
                <p class="developer_contact_p"><b>Developed and Managed by:</b> Leventis Tech Services</p>
                <div class="developer_contact_subdiv">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <p>River Rd Ugbomoro, Uvwie LGA, Delta State, Nigeria.</p>
                </div>
                <div class="developer_contact_subdiv">
                    <div>
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <p>chiboyaniagolu3@gmail.com</p>
                    </div>
                    <div>
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <p>09122312493</p>
                    </div>
                </div>
                <div class="developer_contact_subdiv">
                        <h2>Follow Us</h2>
                        <div>
                            <i class="fa fa-whatsapp" aria-hidden="true"></i>
                            <i class="fa fa-linkedin" aria-hidden="true"></i>
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                        </div>
                </div>
                <div>
                    <a class="btn" href="mailto:chiboyaniagolu3@gmail.com">
                       <i class="fa fa-info-circle" aria-hidden="true"></i>Report an Issue
                    </a> 
                    <a class="btn" href="mailto:chiboyaniagolu3@gmail.com">Contact Us</a>
                </div>       
            </div>
        </div>  
        <script src="../admin/admin.js"></script>   
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="otherJSFiles/custom.js"></script>   
    </section>
</body>
</html>