<header class="header">
    <center>
        <div class="mainheader">
            <div class="mainheader__header-nav">
                <a class="mainheader__header-nav-1" href="../">
                    <i class="fa fa-home" aria-hidden="true"></i>
                </a>
                <a class="mainheader__header-nav-2" id="searchicon">
                    <i class="fa-solid fa-list"></i>
                </a>
            </div>
            <div class="mainheader__logobox">
                <img src="../<?php echo $logo; ?>" alt="companylogo">
            </div>
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
                <img src="<?php echo $logo; ?>" alt="companylogo">
            </div>
            <div class="header__menu-sidebar-div1-subdiv2">
                <h1 class="sidebar__col-header">More</h1>
                <?php
                $selectallpages = "SELECT page_name FROM pages ORDER BY id";
                $selectallpages_result = $conn->query($selectallpages);
                if ($selectallpages_result->num_rows > 0) {
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
                    while ($row = $selectallpages_result->fetch_assoc()) {
                        $i++;
                        $category_names = $row['page_name'];
                        $cleanString = removeHyphen($category_names);
                        $readableString = convertToReadable($category_names);
                        echo    "<a class='sidebar__links' href='$cleanString.php'>$readableString</a>";
                    }
                }
                ?>
                <a href="#" class="sidebar__links">Pitch to Us</a>
            </div>
            <div class="header__menu-sidebar-div1-subdiv3">
                <h1 class="sidebar__col-header">Sources</h1>
                <a href="pressreleases.php" class="sidebar__links">Press Releases</a>
                <a href="commentaries.php" class="sidebar__links">Commentaries</a>
                <a href="news.php" class="sidebar__links">News</a>
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