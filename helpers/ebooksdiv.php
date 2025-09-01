
<?php
/** @var \mysqli $conn */
global $conn;
    $selectebooks = "SELECT id, name FROM ebooks ORDER BY id LIMIT 6";
    $selectebooks_result = $conn->query($selectebooks);
    if ($selectebooks_result->num_rows > 0) {
        while($row = $selectebooks_result->fetch_assoc()) {
            $ebook_names = $row['name'];
            $id = $row['id'];
            echo "<div class='setion2_bodyright_subdiv'>
                    <h1>Ebooks</h1>
                    <div class='setion2_bodyright_subdiv_subdiv'>
                        <a href='collection/whitepaper.php?id='$id''>$ebook_names</a>
                    </div>
                    <a class='mainheader__signupbtn'>See more</a>
            </div>";
        }
    }
?>