<?php

/** @var \mysqli $conn */
global $conn;
    $selectwhitepapers = "SELECT id, name FROM whitepapers ORDER BY id LIMIT 6";
    $selectwhitepapers_result = $conn->query($selectwhitepapers);
    if ($selectwhitepapers_result->num_rows > 0) {
        while($row = $selectwhitepapers_result->fetch_assoc()) {
            $whitepaper_names = $row['name'];
            $id = $row['id'];
            echo "<div class='setion2_bodyright_subdiv'>
                    <h1>White Papers</h1>
                    <div class='setion2_bodyright_subdiv_subdiv'>
                        <a href='collection/whitepaper.php?id='$id''>$whitepaper_names</a>
                    </div>
                    <a class='mainheader__signupbtn'>See more</a>
            </div>";
        }
    }
?>