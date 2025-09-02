<?php
global $conn;
session_start();
require('../connect.php');
$sql = "SELECT COUNT(*) AS new_notifications FROM updates WHERE status = 'unread'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row["new_notifications"];
} else {
    echo 0;
}
?>