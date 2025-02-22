<?php
    session_start();
    header('location: ../login/index.php');
    session_destroy();
?>