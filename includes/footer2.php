<section class="footer">
    <div class="footer__div1">
        <div class="footer__div1__logobox"></div>
        <form class="footer__subscribebox" id="subscribe_box2" action=" ">
            <div class="sec2__susbribe-box-darker">
                <input class="sec2__susbribe-box-input-light" type="email" name="email" placeholder="Your email address..." />
                <button class="sec2__susbribe-box-btn-light" type="submit" name="subscribe_btn2">Subscribe</button>
            </div>
        </form>
    </div>
    <div class="footer__div1">
        <div class="footer__div1__logobox"></div>
    </div>
    <div class="footer__newpagelinks">
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
                echo    "<a class='footer__link lightp' href='$cleanString.php'>$readableString</a>";
            }
        }
        ?>
    </div>
    <div class="footer__div3">
        <p class="footer__div3-p lightp"> &copy; Chiboy Aniagolu 2024. All rights reserved.</p>
        <div class="footer__div3__subdiv">
            <h1 class="footer__header lightp">Follow Us</h1>
            <div class="footer__div3__smedialinks">
                <a class="footer__smedia-links follow_btns" href="#">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
                <a class="footer__smedia-links follow_btns" href="#">
                    <i class="fab fa-linkedin" aria-hidden="true"></i>
                </a>
                <a class="footer__smedia-links follow_btns" href="#">
                    <i class="fab fa-facebook" aria-hidden="true"></i>
                </a>
                <a class="footer__smedia-links follow_btns" href="#">
                    <i class="fa fa-rss" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</section>