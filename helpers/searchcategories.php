<div class="setion2_bodyright_topicsdiv">
    <form action="index.php" method="post">
        <input class="topics_search" name='topics_search' type='text' id="search_input" placeholder="Search Topics.." required/>
        <button type="submit" class="fa fa-search" name='topics_search_submit'></button>
    </form>
    <h1>Categories</h1>
    <?php 
        $selectcategory = "SELECT name FROM topics ORDER BY id";
        $selectcategory_result = $conn->query($selectcategory);
        if ($selectcategory_result->num_rows > 0) {
            if (!function_exists('convertToReadable')) {
                function convertToReadable($slug) {
                    $string = str_replace('-', ' ', $slug);
                    $string = ucwords($string);
                    return $string;
                }
            }
            if (!function_exists('removeHyphen')) {
                function removeHyphen($string) {
                    $string = str_replace(['-', ' '], '', $string);
                    return $string;
                }
            }
            while($row = $selectcategory_result->fetch_assoc()) {
                $category_names = $row['name'];
                $cleanString = removeHyphen($category_names);
                $readableString = convertToReadable($category_names);
                echo "<div class='setion2_bodyright_topicsdiv_subdiv' id='category_div'>
                        <a href='pages/$cleanString.php'>$readableString</a>
                </div>";
            }
        }
    ?>
</div>
<?php
//reverse of the above functionality
// Function to convert a string to a URL-friendly format
/*function convertToSlug($string) {
    // Convert the string to lowercase
    $string = strtolower($string);
    // Replace spaces with hyphens
    $string = str_replace(' ', '-', $string);
    return $string;
}*/

// Example usage
//$niche = "Data Analysis";
//$slug = convertToSlug($niche);

//echo $slug;  Outputs: data-analysis
?>