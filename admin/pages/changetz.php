<?php
session_start();
include("../connect.php");
include("../crudoperations.php");
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
if (isset($_POST['change_tz'])) {
    $timezone = $_POST['timezone'];
    if (in_array($timezone, timezone_identifiers_list())) {
        date_default_timezone_set($timezone);
        $_SESSION['timezone'] = $timezone; // Save in session for consistency
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Invalid time zone!";
    }
} else {
    $timezone = $_SESSION['timezone'] ?? 'UTC'; // Default to UTC
    date_default_timezone_set($timezone);
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
    <title>Change Timezone</title>
</head>

<body>
    <?php require("../extras/header2.php"); ?>
    <section class="newpost_body">
        <form method="POST" action="changetz.php" enctype="multipart/form-data" id="postForm" class="newpost_container">
            <div class="page_links">
                <a href="../admin_homepage.php">Home</a> > <p>Pages</p> > <p>Change Timezone</p>
            </div>
            <div class="newpost_container_divnew newpost_subdiv">
                <div class='newpost_subdiv_subdiv2'>
                    <label class="form__label" for="timezone">Select Time Zone:</i></label>
                    <select name="timezone" id="timezone">
                        <?php foreach (timezone_identifiers_list() as $tz) : ?>
                            <option value="<?= $tz ?>" <?php if ($timezone === $tz) echo 'selected'; ?>><?= $tz ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="submit" class="btn" name="change_tz">
            </div>
        </form>
    </section>
    <script src="sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="https://cdn.tiny.cloud/1/mshrla4r3p3tt6dmx5hu0qocnq1fowwxrzdjjuzh49djvu2p/tinymce/6/tinymce.min.js"></script>
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

</html>