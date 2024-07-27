<?php
session_start();
include("connect.php")
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
	<title>Admin Homepage</title>
</head>
<body>
    <div class="logout_alert hidden">
        <h1 class="logout_alert_header">Are You Sure You Want To Logout?</h1>
        <div>
            <a class="btn">Yes</a>
            <a class="btn cancellogout">No</a>
        </div>
    </div>
    <header class="header">
        <div class="header_logobox">
            <img src="#" alt="Website Logo">
        </div>
        <form class="header_searchbar" action="" method="get">
            <input type="text" name="search" placeholder="Search.." />
            <a class="fa fa-search" aria-hidden="true">
            </a>
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
                <div class="sidebar_pages border-gradient-side sidebarbtn">
                    <i class="fa fa-sticky-note" aria-hidden="true"></i>
                    <p class="paragraph">
                        Pages
                    </p>
                </div>
                <div class="sidebar_reviews border-gradient-side sidebarbtn">
                    <i class="fa fa-comments" aria-hidden="true"></i>
                    <p class="paragraph">
                        Reviews
                    </p>
                </div>
                <div class="sidebar_settings border-gradient-side sidebarbtn">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    <p class="paragraph">
                        Settings
                    </p>
                </div>
                <div class="Contact Developer border-gradient-side sidebarbtn">
                    <i class="fa fa-phone" aria-hidden="true"></i>
                    <p class="paragraph">
                        Contact Developer
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
            <h1 class="aside_sidebar_header">Welcome, <?php
            if(isset($_SESSION['email'])){
                $email = $_SESSION['email'];
                $query = mysqli_query($conn, "SELECT admin_login_info.* FROM `admin_login_info` WHERE admin_login_info.email = '$email'");
                while($row = mysqli_fetch_array($query)){
                    echo $row['username'];
                }
            }
            ?></h1>
            <div class="website_info_div tabcontent active2">
                <div class="webinfo_container">
                    <div class="website_info">
                        <div class="website_info_subdiv">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                            <p class="website_info_p1">10.5K</p>
                        </div>
                        <p class="website_info_p2">Article Views</p>
                    </div>
                    <div class="website_info">
                        <div class="website_info_subdiv">
                            <i class="fa fa-comments" aria-hidden="true"></i>
                            <p class="website_info_p1">10.5K</p>
                        </div>
                        <p class="website_info_p2">Comments</p>
                    </div>
                    <div class="website_info">
                        <div class="website_info_subdiv">
                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                            <p class="website_info_p1">10.5K</p>
                        </div>
                        <p class="website_info_p2">Likes</p>
                    </div>
                    <div class="website_info">
                        <div class="website_info_subdiv">
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                            <p class="website_info_p1">10.5k</p>
                        </div>
                        <p class="website_info_p2">Published</p>
                    </div>
                    <a class="website_info" href="#" target="_blank">
                        <div class="website_info_subdiv">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </div>
                        <p class="website_info_p2">Create New Post</p>
                    </a>
                    <a class="website_info" href="#" target="_blank">
                        <div class="website_info_subdiv">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                        </div>
                        <p class="website_info_p2">View Website</p>
                    </a>
                </div>
                <div class="addtionalinfo">
                    <div class="addtionalinfo_header">
                        <h1>Recent Articles</h1>
                        <a class="btn" href="#">View All</a>
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
                              <td>Maria Anders</td>
                              <td>Germany</td>
                              <td>July 10th 2024</td>
                              <td>
                                <a class="edit" href="#">Edit</a> /
                                <a class="delete" href="#">Delete</a>
                            </td>
                            </tr>
                            <tr>
                              <td>Futterkiste</td>
                              <td>Francisco Chang</td>
                              <td>Mexico</td>
                              <td>July 10th 2024</td>
                              <td>
                                <a class="edit" href="#">Edit</a> /
                                <a class="delete" href="#">Delete</a>
                            </td>
                            </tr>
                            <tr>
                                <td>Futterkiste</td>
                                <td>Francisco Chang</td>
                                <td>Mexico</td>
                                <td>July 10th 2024</td>
                                <td>
                                  <a class="edit" href="#">Edit</a> /
                                  <a class="delete" href="#">Delete</a>
                              </td>
                              </tr>
                              <tr>
                                <td>Futterkiste</td>
                                <td>Francisco Chang</td>
                                <td>Mexico</td>
                                <td>July 10th 2024</td>
                                <td>
                                  <a class="edit" href="#">Edit</a> /
                                  <a class="delete" href="#">Delete</a>
                              </td>
                              </tr>
                              <tr>
                                <td>Futterkiste</td>
                                <td>Francisco Chang</td>
                                <td>Mexico</td>
                                <td>July 10th 2024</td>
                                <td>
                                  <a class="edit" href="#">Edit</a> /
                                  <a class="delete" href="#">Delete</a>
                              </td>
                              </tr>
                              <tr>
                                <td>Futterkiste</td>
                                <td>Francisco Chang</td>
                                <td>Mexico</td>
                                <td>July 10th 2024</td>
                                <td>
                                  <a class="edit" href="#">Edit</a> /
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
                    <a class="profile_imgbox_edit">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                </figure>
                <div class="profile_body">
                    <p class="Firstname"><span>Firstname:</span> Chiemelie</p>
                    <i class="fa fa-area-chart" aria-hidden="true"></i>
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                    <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
                    <i class="fa fa-facebook" aria-hidden="true"></i>
                    <i class="fa fa-linkedin" aria-hidden="true"></i>
                    <p class="Lastname"><span>Lastname:</span> Aniagolu</p>
                    <p class="Username"><span>Username:</span> Chibs01</p>
                    <p class="Email"><span>Email:</span> chiboyaniagolu3@gmail.com</p>
                    <p class="Mobile"><span>Mobile:</span> 09122312493</p>
                    <center><a class="profile_edit_btn">
                        Edit Profile
                    </a></center>
                    <form class="Edit_profile hidden" action="" method="post">
                        <div class="input_group">
                            <label for="firstname">Firstname:</label>
                            <input type="text" placeholder="Firstname" name="firstname" required/>
                        </div>
                        <div class="input_group">
                            <label for="firstname">Lastname:</label>
                            <input type="text" placeholder="Lastname" name="lastname" required/>
                        </div>
                        <div class="input_group">
                            <label for="username">Username:</label>
                            <input type="text" placeholder="Username" name="username" required/>
                        </div>
                        <div class="input_group">
                            <label for="email">Email:</label>
                            <input type="email" placeholder="Email" name="email" required/>
                        </div>
                        <div class="input_group">
                            <label for="mobile">Phone Number:</label>
                            <input type="text" placeholder="Phone Number" name="mobile" required/>
                        </div>
                        <center><input type="submit" value="Update" class="profile_edit"/></center>
                    </form>
                </div>
            </div>
            <div class="users tabcontent hidden">
                <div class="users_admin_div userdiv">
                    <div class="user_header">
                        <h2>Administrators</h2>
                        <a class="btn" href="#" target="_blank">View All</a>
                    </div>
                    <div class="users_div_subdiv border-gradient-side-dark">
                        <div class="users_div_subdiv_subdiv">
                            <div class="user_imgbox">
                                <img src="#" alt="admin's image"/>
                            </div>
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
                        <div class="users_div_subdiv_subdiv">
                            <a class="users_create" target="_blank">
                                <center><i class="fa fa-plus" aria-hidden="true"></i></center>
                                <h3>Create New Admin</h3>
                            </a>    
                        </div>
                    </div>
                </div>
                <div class="users_editor_div userdiv">
                    <div class="user_header">
                        <h2>Editors</h2>
                        <a class="btn" href="#" target="_blank">View All</a>
                    </div>
                    <div class="users_div_subdiv border-gradient-side-dark">
                        <div class="users_div_subdiv_subdiv">
                            <div class="user_imgbox">
                                <img src="#" alt="editor's image"/>
                            </div>
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
                            <center><div class="users_delete_edit">
                                <a class="users_edit">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                <a class="users_delete">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </div></center>
                        </div>
                        <div class="users_div_subdiv_subdiv">
                            <a class="users_create" target="_blank">
                                <center><i class="fa fa-plus" aria-hidden="true"></i></center>
                                <h3>Create New Editor</h3>
                            </a>    
                        </div>
                    </div>
                </div>
                <div class="users_writer_div userdiv">
                    <div class="user_header">
                        <h2>Writers</h2>
                        <a class="btn" href="#" target="_blank">View All</a>
                    </div>
                    <div class="users_div_subdiv border-gradient-side-dark">
                        <div class="users_div_subdiv_subdiv">
                            <div class="user_imgbox">
                                <img src="#" alt="writer's image"/>
                            </div>
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
                            <center><div class="users_delete_edit">
                                <a class="users_edit">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                <a class="users_delete">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </div></center>
                        </div>
                        <div class="users_div_subdiv_subdiv">
                            <a class="users_create" target="_blank">
                                <center><i class="fa fa-plus" aria-hidden="true"></i></center>
                                <h3>Create New Writer</h3>
                            </a>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="posts tabcontent hidden">
                <div class="posts_div1 postsdiv">
                    <div class="posts_header">
                        <h1> Recently Published Posts</h1>
                        <a class="btn" href="#">View All</a>
                    </div>
                    <div class="posts_divcontainer border-gradient-side-dark">
                        <div class="posts_divcontainer_subdiv">
                            <div class="posts_divcontainer_subdiv_body">
                                <h3 class="posts_divcontainer_header">
                                    Post Title
                                </h3>
                                <div class="posts_delete_edit">
                                    <a class="users_edit">
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
                                    <a class="users_edit">
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
                                    <a class="users_edit">
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
                                    <a class="users_edit">
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
                        <a class="btn" href="#">View All</a>
                    </div>
                    <div class="posts_divcontainer border-gradient-side-dark">
                        <div class="posts_divcontainer_subdiv">
                            <div class="posts_divcontainer_subdiv_body">
                                <h3 class="posts_divcontainer_header">
                                    Post Title
                                </h3>
                                <div class="posts_delete_edit">
                                    <a class="users_edit">
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
                                    <a class="users_edit">
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
                                    <a class="users_edit">
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
                                    <a class="users_edit">
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
            <div class="pages tabcontent hidden">
                <h1>Settings</h1>
            </div>
            <div class="reviews tabcontent hidden">
                <div class="reviews_div1 reviewdiv">
                    <div class="review_header">
                        <h1 class="revheader"> Recent Reviews</h1>
                        <a class="btn" href="#">View All</a>
                    </div>
                    <div class="review_divcontainer border-gradient-side-dark">
                        <div class="review_divcontainer_subdiv">
                            <div class="review_divcontainer_subdiv2">
                                <i class="fa fa-user-circle" aria-hidden="true"></i>
                                <div class="review_divcontainer_subdiv1">
                                    <p class="user_review_p">
                                        chibs01
                                    </p>
                                    <p class="user_review_p">
                                        chiemelieaniagolu3@gmail.com
                                    </p>
                                    <p class="user_review_p">
                                        105.113.64.213
                                    </p>
                                </div>
                            </div>
                            <div class="review_divcontainer_subdiv2">
                                    <p class="comment_section">
                                        I really like this post and i would look foward to reading more from this website.
                                    </p>
                            </div>
                            <div class="review_divcontainer_subdiv3-pre">
                                    <p class="review_date">
                                        <span>Posted On:</span> 10th July 2024
                                    </p>
                                    <p class="review_time">
                                        <span>Time:</span> 10:00 PM
                                    </p>
                            </div>
                            <div class="review_divcontainer_subdiv3">
                                <a class="btn" href="#" target="_blank">
                                    Reply
                                </a> 
                                <a class="btn" href="#" target="_blank">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a> 
                            </div>
                        </div>
                        <div class="review_divcontainer_subdiv border-gradient-side-dark">
                            <div class="review_divcontainer_subdiv2">
                                <i class="fa fa-user-circle" aria-hidden="true"></i>
                                <div class="review_divcontainer_subdiv1">
                                    <p class="user_review_p">
                                        chibs01
                                    </p>
                                    <p class="user_review_p">
                                        chiemelieaniagolu3@gmail.com
                                    </p>
                                    <p class="user_review_p">
                                        105.113.64.213
                                    </p>
                                </div>
                            </div>
                            <div class="review_divcontainer_subdiv2">
                                    <p class="comment_section">
                                        I really like this post and i would look foward to reading more from this website.
                                    </p>
                            </div>
                            <div class="review_divcontainer_subdiv3-pre">
                                    <p class="review_date">
                                        <span>Posted On:</span> 10th July 2024
                                    </p>
                                    <p class="review_time">
                                        <span>Time:</span> 10:00 PM
                                    </p>
                            </div>
                            <div class="review_divcontainer_subdiv3">
                                <a class="btn" href="#" target="_blank">
                                    Reply
                                </a> 
                                <a class="btn" href="#" target="_blank">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a> 
                            </div>
                        </div>
                        <div class="review_divcontainer_subdiv border-gradient-side-dark">
                            <div class="review_divcontainer_subdiv2">
                                <i class="fa fa-user-circle" aria-hidden="true"></i>
                                <div class="review_divcontainer_subdiv1">
                                    <p class="user_review_p">
                                        chibs01
                                    </p>
                                    <p class="user_review_p">
                                        chiemelieaniagolu3@gmail.com
                                    </p>
                                    <p class="user_review_p">
                                        105.113.64.213
                                    </p>
                                </div>
                            </div>
                            <div class="review_divcontainer_subdiv2">
                                    <p class="comment_section">
                                        I really like this post and i would look foward to reading more from this website.
                                    </p>
                            </div>
                            <div class="review_divcontainer_subdiv3-pre">
                                    <p class="review_date">
                                        <span>Posted On:</span> 10th July 2024
                                    </p>
                                    <p class="review_time">
                                        <span>Time:</span> 10:00 PM
                                    </p>
                            </div>
                            <div class="review_divcontainer_subdiv3">
                                <a class="btn" href="#" target="_blank">
                                    Reply
                                </a> 
                                <a class="btn" href="#" target="_blank">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a> 
                            </div>
                        </div>
                        <div class="review_divcontainer_subdiv border-gradient-side-dark">
                            <div class="review_divcontainer_subdiv2">
                                <i class="fa fa-user-circle" aria-hidden="true"></i>
                                <div class="review_divcontainer_subdiv1">
                                    <p class="user_review_p">
                                        chibs01
                                    </p>
                                    <p class="user_review_p">
                                        chiemelieaniagolu3@gmail.com
                                    </p>
                                    <p class="user_review_p">
                                        105.113.64.213
                                    </p>
                                </div>
                            </div>
                            <div class="review_divcontainer_subdiv2">
                                    <p class="comment_section">
                                        I really like this post and i would look foward to reading more from this website.
                                    </p>
                            </div>
                            <div class="review_divcontainer_subdiv3-pre">
                                    <p class="review_date">
                                        <span>Posted On:</span> 10th July 2024
                                    </p>
                                    <p class="review_time">
                                        <span>Time:</span> 10:00 PM
                                    </p>
                            </div>
                            <div class="review_divcontainer_subdiv3">
                                <a class="btn" href="#" target="_blank">
                                    Reply
                                </a> 
                                <a class="btn" href="#" target="_blank">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a> 
                            </div>
                        </div>
                        <div class="review_divcontainer_subdiv border-gradient-side-dark">
                            <div class="review_divcontainer_subdiv2">
                                <i class="fa fa-user-circle" aria-hidden="true"></i>
                                <div class="review_divcontainer_subdiv1">
                                    <p class="user_review_p">
                                        chibs01
                                    </p>
                                    <p class="user_review_p">
                                        chiemelieaniagolu3@gmail.com
                                    </p>
                                    <p class="user_review_p">
                                        105.113.64.213
                                    </p>
                                </div>
                            </div>
                            <div class="review_divcontainer_subdiv2">
                                    <p class="comment_section">
                                        I really like this post and i would look foward to reading more from this website.
                                    </p>
                            </div>
                            <div class="review_divcontainer_subdiv3-pre">
                                    <p class="review_date">
                                        <span>Posted On:</span> 10th July 2024
                                    </p>
                                    <p class="review_time">
                                        <span>Time:</span> 10:00 PM
                                    </p>
                            </div>
                            <div class="review_divcontainer_subdiv3">
                                <a class="btn" href="#" target="_blank">
                                    Reply
                                </a> 
                                <a class="btn" href="#" target="_blank">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="settings tabcontent hidden">
                <h1>Settings</h1>
            </div>
            <div class="developer_contact tabcontent hidden">
                <h1>Contact Website Developer</h1>
                <p class="developer_contact_p">Developed and Managed by: <span>Leventis Tech Services</span> </p>
                <p class="developer_contact_p">Address: <span>Leventis Tech Services</span> </p>
                <div>
                    <a class="btn" href="mailto:chiboyaniagolu3@gmail.com">Report an Issue
                    </a> 
                    <a class="btn" href="mailto:chiboyaniagolu3@gmail.com">Contact Us:</a>
                </div>       
            </div>
        </div>        
    </section>
    <script src="admin.js"></script>
</body>
</html>