<?php

/** @var \mysqli $conn */
global $conn;
    session_start();
    include("connect.php");
    $_SESSION['id'] = $admin_id; 
    $_SESSION['status_type'] = "";
    $_SESSION['status'] = "";
include('../helpers/crudoperations.php');
    function promoteWriterToEditor($writer_id, $admin_id) {
        global $conn;
        $select_writer = "SELECT * FROM writer WHERE id = ?";
        $stmt = $conn->prepare($select_writer);
        $stmt->bind_param("i", $writer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $writer = $result->fetch_assoc();
        if ($writer) {
            $insert_editor = "INSERT INTO editor (admin_id, firstname, lastname, email, image, bio, date_joined, time_joined) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_editor);
            $stmt->bind_param("isssssss", $admin_id, $writer['firstname'], $writer['lastname'], $writer['email'], $writer['image'], $writer['bio'], $writer['date_joined'], $writer['time_joined']);
            $stmt->execute();
            $delete_writer = "DELETE FROM writer WHERE id = ?";
            $stmt = $conn->prepare($delete_writer);
            $stmt->bind_param("i", $writer_id);
            if( $stmt->execute() ){
                $content = "Admin ".$_SESSION['firstname']." promoted a writer";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Writer Promoted Successfully";
                header('location: view_all/writers.php');
            }else{
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: view_all/writers.php');
            }
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Writer not found";
            header('location: view_all/writers.php');
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $writer_id = intval($_POST['writer_id']);
        promoteWriterToEditor($writer_id, $admin_id);
    }    
?>