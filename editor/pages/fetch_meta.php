<?php

include '../connect.php'; // Ensure this includes your database connection

if (isset($_POST['page_id'])) {
    global $conn;
    $page_id = $_POST['page_id'];

    $query = "SELECT * FROM meta_titles WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $page_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode([
            "success" => true,
            "page_name" => $row["page_name"],
            "meta_name1" => $row["meta_name1"],
            "meta_name2" => $row["meta_name2"],
            "meta_name3" => $row["meta_name3"],
            "meta_name4" => $row["meta_name4"],
            "meta_name5" => $row["meta_name5"],
            "meta_content1" => $row["meta_content1"],
            "meta_content2" => $row["meta_content2"],
            "meta_content3" => $row["meta_content3"],
            "meta_content4" => $row["meta_content4"],
            "meta_content5" => $row["meta_content5"]
        ]);
    } else {
        echo json_encode(["success" => false]);
    }
}
