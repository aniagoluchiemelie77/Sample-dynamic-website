<header class="header">
    <center>
        <div class="mainheader">
            <div class="mainheader__header-nav">
                <a class="mainheader__header-nav-1">
                    <i class="fa-solid fa-list"></i>
                </a>
                <a class="mainheader__header-nav-2" id="searchicon">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </a>
            </div>
            <div class="mainheader__logobox">
                <img src="<?php echo $logo; ?>" alt="Website logo">
            </div>
            <a class="mainheader__signupbtn" href="pages/newslettersubscribe.php">Newsletter Signup</a>
        </div>
        <form class="header_searchbar hidden" id="search_form">
            <input type="text" name="query" id="search-bar" placeholder="Search.." />
            <button class="fa fa-search" aria-hidden="true" type="button" onclick="submitSearch()"></button>
        </form>
        <div class="header__dropdownlinks">
            <?php
            $selectallcategory = "SELECT name FROM topics ORDER BY id";
            $selectallcategory_result = $conn->query($selectallcategory);
            if ($selectallcategory_result->num_rows > 0) {
                $i = 0;
                if (!function_exists('convertToReadable')) {
                    function convertToReadable($slug)
                    {
                        $string = str_replace('-', ' ', $slug);
                        $string = ucwords($string);
                        return $string;
                    }
                }
                if (!function_exists('removeHyphen')) {
                    function removeHyphen($string)
                    {
                        $string = str_replace(['-', ' '], '', $string);
                        return $string;
                    }
                }
                while ($row = $selectallcategory_result->fetch_assoc()) {
                    $i++;
                    $category_names = $row['name'];
                    $cleanString = removeHyphen($category_names);
                    $readableString = convertToReadable($category_names);
                    if ($i <= 5) {
                        echo "<a class='header__dropdownlinks-1 headerlinks lightp' href='pages/$cleanString.php'>$readableString</a>";
                    } else {
                        echo "<div class='header__dropdownlinks-6  lightp'>
                                    <button class='dropbtn'>More</button>
                                    <div class='header__dropdownlinks-content'>
                                        <a class='header__dropdownlinks-link1 lightp' href='pages/$cleanString.php'>$readableString</a>
                                    </div>
                                </div>
                            ";
                    }
                }
            }
            ?>
        </div>
    </center>
    <div class="header__menu-sidebar hidden" id="sidebar">
        <div class="header__menu-sidebar-div1a sidebar-input">
            <a class="sidebarbtn">
                <i class="fa fa-times popup_close1" aria-hidden="true"></i>
            </a>
        </div>
        <div class="header__menu-sidebar-div1 border-gradient-top-dark">
            <div class="sidebar__logobox">
                <img src="#" alt="companylogo">
            </div>
            <div class="header__menu-sidebar-div1-subdiv2">
                <h1 class="sidebar__col-header">More</h1>
                <a href="pages\aboutus.php" class="sidebar__links">About Us</a>
                <a href="#" class="sidebar__links">Pitch to Us</a>
                <a href="pages/advertisewithus.php">Advertise with Us</a>
                <a href="pages/sharenewstips.php">Share News tip</a>
                <a href="pages/ourterms.php">Terms of Service</a>
                <a href="pages/workwithus.php">Work With Us</a>
            </div>
            <div class="header__menu-sidebar-div1-subdiv3">
                <h1 class="sidebar__col-header">Sources</h1>
                <a href="pages/pressreleases.php" class="sidebar__links">Press Releases</a>
                <a href="pages/commentaries.php" class="sidebar__links">Commentaries</a>
                <a href="pages/news.php" class="sidebar__links">News</a>
                <h1 class="sidebar__col-header top_space">Resources</h1>
                <a href="#" class="sidebar__links">White Papers</a>
                <a href="#" class="sidebar__links">Videoscripts</a>
                <a href="#" class="sidebar__links">Ebooks</a>
            </div>
        </div>
        <div class="header__menu-sidebar-div2 border-gradient-top-dark">
            <p class="paragraph">&copy; Aniagolu Chiemelie 2024. All rights reserved</p>
            <div class="header__menu-sidebar-div2-subdiv1">
                <h1 class="sidebar__col-header">Follow Us</h1>
                <div class="header__menu-sidebar-div2-subdiv1-subdiv">
                    <a class="sidebar__links follow_btns" href="#">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <a class="sidebar__links follow_btns" href="#">
                        <i class="fab fa-linkedin" aria-hidden="true"></i>
                    </a>
                    <a class="sidebar__links follow_btns" href="#">
                        <i class="fab fa-facebook" aria-hidden="true"></i>
                    </a>
                    <a class="sidebar__links follow_btns" href="#">
                        <i class="fa fa-rss" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>