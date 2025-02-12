<?php
    session_start();
    require('connect.php');
    if (isset($_POST['query'])) {
        $search = $conn->real_escape_string($_POST['query']);
        $tables = ['paid_posts', 'commentaries', 'news', 'posts', 'press_releases'];
        $authorTables = ['editor', 'writer', 'admin_login_info'];
        $suggestions = array();
        foreach ($tables as $table) {
            $sql = "SELECT * FROM $table WHERE title LIKE '%".$search."%' OR subtitle LIKE '%".$search."%' OR content LIKE '%".$search."%'";
            $result = $conn->query($sql);
            if ($result === false) {
                echo "Error: " . $conn->error;
            } else {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $suggestions[] = array_merge($row, ['type' => 'post']);
                    }
                }
            }
        }
        foreach ($authorTables as $table) {
            $sql = "SELECT * FROM $table WHERE lastname LIKE '%".$search."%' OR firstname LIKE '%".$search."%'";
            $result = $conn->query($sql);
            if ($result === false) {
                echo "Error: " . $conn->error;
            } else {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $suggestions[] = array_merge($row, ['type' => 'author']);
                    }
                }
            }
        }
        echo json_encode($suggestions);
    }else{
        echo "Error: Query parameter not set.";
    }
?>