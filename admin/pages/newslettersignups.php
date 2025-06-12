<?php
session_start();
include("../connect.php");
require("../init.php");
require('../../init.php');
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$translationFile = "../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="Tech News and Articles website" />
    <meta name="keywords" content="Tech News, Content Writers, Content Strategy" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu Diamaka" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../admin.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <script src="../admin.js" defer></script>
    <title><?php echo $translations['newsletter_signups']; ?></title>
</head>

<body>
    <?php require("../extras/header3.php"); ?>
    <section class="middle_centering">
        <div class="posts width80">
            <div class="page_links">
                <a href="../admin_homepage.php"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['newsletter_signups']; ?></p>
            </div>
            <div class="posts_div2 postsdiv2">
                <div class="posts_header">
                    <h1><?php echo $translations['newsletter_signups']; ?></h1>
                </div>
                <div class="posts_divcontainer border-gradient-side-dark">
                    <?php
                    $select_newslettersubscribers = "SELECT id, firstname, lastname, company_name, job_title, email, time, DATE_FORMAT(Date, '%M %d, %Y') as formatted_date FROM newsletter_subscribers ORDER BY id DESC LIMIT 100";
                    $select_newslettersubscribers_result = $conn->query($select_newslettersubscribers);
                    if ($select_newslettersubscribers_result->num_rows > 0) {
                        $sn = 0;
                        while ($row = $select_newslettersubscribers_result->fetch_assoc()) {
                            $time = $row['time'];
                            $formatted_time = date("g:i A", strtotime($time));
                            $sn++;
                            echo "<div class='posts_divcontainer_subdiv'>
                                            <div class='posts_divcontainer_subdiv_body2'>
                                                <div class='subscribers_subdiv'>
                                                    <i class='fa fa-user-circle' aria-hidden='true'></i>
                                                    <div class='posts_delete_edit'>
                                                        <p><span>$translations[firstname]: </span> " . $row['firstname'] . "</p>
                                                        <p><span>$translations[lastname]: </span> " . $row['lastname'] . "</p>
                                                        <p><span>$translations[email]: </span> " . $row['email'] . "</p>
                                                        <p><span>$translations[company_name]: </span> " . $row['company_name'] . "</p>
                                                        <p><span>$translations[job_title]: </span> " . $row['job_title'] . "</p>
                                                        <p><span>$translations[date]: </span> " . $row['formatted_date'] . "</p>
                                                        <p><span>$translations[time]: </span> " . $formatted_time . "</p>
                                                    </div>
                                                </div>
                                                <a class='users_delete' onclick='confirmDeleteNewslSubscriber(" . $row['id'] . ")'>
                                                    <i class='fa fa-trash' aria-hidden='true'></i>
                                                </a>
                                            </div>
                                    </div>";
                        };
                    };
                    ?>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.tiny.cloud/1/4x49ifq5jl99k0b9aot23a5ynnqfcr8jdlee7v6905rgmzql/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="../admin.js"></script>
    <script>
        var messageType = "<?= $_SESSION['status_type'] ?? ' ' ?>";
        var messageText = "<?= $_SESSION['status'] ?? ' ' ?>";
        if (messageType == 'Error' && messageText != " ") {
            Swal.fire({
                title: 'Error!',
                text: messageText,
                icon: 'error',
                confirmButtonText: 'Ok'
            })
        } else if (messageType == 'Success' && messageText != " ") {
            Swal.fire({
                title: 'Success',
                text: messageText,
                icon: 'success',
                confirmButtonText: 'Ok'
            })
        }
        <?php unset($_SESSION['status_type']); ?>
        <?php unset($_SESSION['status']); ?>
    </script>
</body>