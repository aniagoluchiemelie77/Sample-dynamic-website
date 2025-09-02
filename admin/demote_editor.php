<?php

/** @var \mysqli $conn */
global $conn;
    session_start();
    include("connect.php");
    $_SESSION['id'] = $admin_id; 
    $_SESSION['status_type'] = "";
    $_SESSION['status'] = "";
    include ('../helpers/crudoperations.php');
    function demoteEditorToWriter($editor_id, $admin_id) {
        global $conn;
        $select_editor = "SELECT * FROM editor WHERE id = ?";
        $stmt = $conn->prepare($select_editor);
        $stmt->bind_param("i", $editor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $editor = $result->fetch_assoc();
        if ($editor) {
            $insert_editor = "INSERT INTO writer (admin_id, firstname, lastname, email, image, bio, date_joined, time_joined) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_editor);
            $stmt->bind_param("isssssss", $admin_id, $editor['firstname'], $editor['lastname'], $editor['email'], $editor['image'], $editor['bio'], $editor['date_joined'], $editor['time_joined']);
            $stmt->execute();
            $delete_editor = "DELETE FROM editor WHERE id = ?";
            $stmt = $conn->prepare($delete_editor);
            $stmt->bind_param("i", $writer_id);
            if( $stmt->execute() ){
                $content = "Admin ".$_SESSION['firstname']." demoted an editor";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Editor Demoted Successfully";
                header('location: view_all/editors.php');
            }else{
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: view_all/editors.php');
            }
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Editor not found";
            header('location: view_all/editors.php');
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $editor_id = intval($_POST['editor_id']);
        demoteEditorToWriter($editor_id, $admin_id);
    }    
?>