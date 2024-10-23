<?php
require("../connect.php");
function logUpdate($conn, $forUser, $action) {
    date_default_timezone_set('UTC');
    $date = date('Y-m-d');
    $time = date("H:iA"); 
    $sql = "INSERT INTO updates (content, for_user, Date, time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $action, $forUser, $date, $time);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
    $stmt->close();
}
function executeQuery($sql, $data){
    global $conn;
    $stmt = $conn->prepare($sql);
    $values = array_values($data);
    $types = str_repeat('s', count($values));
    $stmt->bind_param($types, ...$values);
    $stmt->execute();
    return $stmt;
}
function selectAll ($tablename, $condition = []){
    global $conn;
    $sql = "SELECT * FROM $tablename";
    if(empty($condition)){
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    }else{
        $i = 0;
        foreach($condition as $key => $value){
            if($i === 0){
                $sql = $sql." WHERE $key = ?";
            }else{
                $sql = $sql." AND $key = ?";
            }
            $i ++;
        }
    }
    executeQuery($sql, $value);
}
function selectOne ($tablename, $condition){
    $servername = "localhost";
    $user = "root";
    $pass = "";
    $db = "new_posts";
    $conn = new mysqli($servername, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM $tablename";
    $i = 0;
    foreach($condition as $key => $value){
        if($i === 0){
            $sql = $sql." WHERE $key = ?";
        }else{
            $sql = $sql." AND $key = ?";
        }
        $i ++;
        }
    executeQuery($sql, $value);
}
function create ($tablename, $data){
    $servername = "localhost";
    $user = "root";
    $pass = "";
    $db = "new_posts";
    $conn = new mysqli($servername, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO $tablename SET ";
    $i = 0;
    foreach($data as $key => $value){
        if($i === 0){
            $sql = $sql." $key = ?";
        }else{
            $sql = $sql.", $key = ?";
        }
        $i ++;
        }
    executeQuery($sql, $data);
}
function update ($tablename, $id, $data){
    $servername = "localhost";
    $user = "root";
    $pass = "";
    $db = "new_posts";
    $conn = new mysqli($servername, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "UPDATE $tablename SET ";
    $i = 0;
    foreach($data as $key => $value){
        if($i === 0){
            $sql = $sql." $key = ?";
        }else{
            $sql = $sql.", $key = ?";
        }
        $i ++;
        }
        $sql = $sql." WHERE id = $id";
    executeQuery($sql, $data);
}
function delete ($tablename, $id, $condition){
    $servername = "localhost";
    $user = "root";
    $pass = "";
    $db = "new_posts";
    $conn = new mysqli($servername, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "DELETE FROM $tablename WHERE id = '$id'";
    $i = 0;
    foreach($condition as $key => $value){
        if($i === 0){
            $sql = $sql." $key = ?";
        }else{
            $sql = $sql.", AND $key = ?";
        }
        $i ++;
        }
    executeQuery($sql, $condition);
}

function createcategory($filename, $content, $description) {
    $file = fopen('../../pages/'.$filename, 'w');
    if ($file) {
        fwrite($file, $content);
        fclose($file);
    } else {
        die("Unable to create file.");
    }
    $servername = "localhost";
    $user = "root";
    $pass = "";
    $db = "new_posts";
    $conn = new mysqli($servername, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("INSERT INTO topics (name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $filename, $description);
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}

?>