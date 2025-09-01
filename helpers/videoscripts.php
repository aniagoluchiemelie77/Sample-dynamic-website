
<?php
/** @var \mysqli $conn */
global $conn;
    $selectvideoscripts = "SELECT id, name FROM videoscripts ORDER BY id LIMIT 6";
    $selectvideoscripts_result = $conn->query($selectvideoscripts);
    if ($selectvideoscripts_result->num_rows > 0) {
        while($row = $selectvideoscripts_result->fetch_assoc()) {
            $videoscripts_names = $row['name'];
            $id = $row['id'];
            echo "<div class='setion2_bodyright_subdiv'>
                    <h1>Video Scripts</h1>
                    <div class='setion2_bodyright_subdiv_subdiv'>
                        <a href='collection/whitepaper.php?id='$id''>$videoscripts_names</a>
                    </div>
                    <a class='mainheader__signupbtn'>See more</a>
            </div>";
        }
    }
?>