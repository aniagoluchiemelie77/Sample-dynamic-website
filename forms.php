<?php 
   require ('connect.php');
   $search_input = '';
   if(isset($_POST['query'])){
        $query = $_POST['query'];
        $search_input = $query;
        $tables = ['posts', 'paid_posts', 'news', 'press_releases', 'commentaries'];
        $results = [];
        foreach ($tables as $table) {
            $sql = "SELECT * FROM $table WHERE title LIKE '%$query%' OR niche LIKE '%$query%' OR subtitle LIKE '%$query%' OR content LIKE '%$query%'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $results[] = $row;
                }
            }
        }
        if (!empty($results)) {
            foreach ($results as $row) {
                echo "<div class='headers'>
                        <h1>You Searched for: $search_input</h1>
                    </div>
                    <div class='section2__div1__div1 normal-divs'>
                        <a class='normal-divs__subdiv' href='pages/view_post.php? id2=".$row["id"]."'>
                            <img src='$image' alt='article image'>
                            <div class='normal-divs__subdiv__div'>
                                <h1 class='normal-divs__header'>$niche</h1>
                                <h2 class='normal-divs__title'>$title</h2>
                                <div>
                                    <p class='normal-divs__releasedate firstp'>$date</p>
                                    <p class='normal-divs__releasedate'><i class='fa fa-clock' aria-hidden='true'></i> 5 mins read</p>
                                </div>
                            </div>
                        </a>
                        <div class='normal-divs__subdiv2'>
                            <img src='images\image1.jpeg' alt='article image'>
                            <p class='normal-divs__subdiv2__p'>By <span>Elizabeth Montalbano, </span><span>Contributing Writer</span></p>
                        </div>
                    </div>
                </div>";
            }
        } else {
            echo "<div class='headers'>
                    <h1>Search Input Not Found</h1>
                </div>";
            }
    }
?>