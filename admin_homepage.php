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
                <div class="settings border-gradient-side sidebarbtn">
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