<div class="setion2_bodyright_topicsdiv">
    <form action="index.php" method="post">
        <input class="topics_search" name='topics_search' type='text' placeholder="Search Topics.." required/>
        <button type="submit" class="fa fa-search" name='topics_search_submit'></button>
    </form>
    <h1>Categories</h1>
    <?php 
        $selectcategory = "SELECT name FROM topics ORDER BY id";
        $selectcategory_result = $conn->query($selectcategory);
        if ($selectcategory_result->num_rows > 0) {
            while($row = $selectcategory_result->fetch_assoc()) {
                $category_names = $row['name'];
                $title_case_name = ucwords(str_replace('_', ' ', $category_names));
                echo "<div class='setion2_bodyright_topicsdiv_subdiv'>
                        <a href='pages/$category_names.php'>$title_case_name</a>
                </div>";
            }
        }
    ?>
</div>