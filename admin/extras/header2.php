<?php
global $logo, $posttype;
?>
<header class="header">
    <div class="header_img">
        <a class="notification" href="../admin_homepage.php">
            <i class="fa fa-home" aria-hidden="true"></i>
        </a>
    </div>
    <form class="header_searchbar" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> " method="get">
        <input type="text" name="query" id="search-bar" placeholder="Search <?php echo $posttype; ?>..." />
        <button class="fa fa-search" id="tutorial_name" type="submit" onclick="submitSearch()"></button>
    </form>
    <div class="header_logobox">
        <img src="<?php echo $logo; ?>" alt="Website Logo">
    </div>
</header>