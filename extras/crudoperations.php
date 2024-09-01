<?php
require("../connect.php");
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
    global $conn;
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
    global $conn;
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
    global $conn;
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
    global $conn;
    $sql = "DELETE FROM $tablename WHERE id = $id ";
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
?>