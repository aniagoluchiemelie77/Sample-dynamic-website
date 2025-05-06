<?php
session_start();
include("../connect.php");
include("../crudoperations.php");
require('../../init.php');
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
$userId = $_SESSION['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_meta_title'])) {
    $page_name = $_POST['page_name'];
    $meta_title = $_POST['meta_title'];
    $meta_content = $_POST['meta_content'];
    $stmt = $conn->prepare("SELECT id FROM meta_titles WHERE page_name = ?");
    $stmt->bind_param("s", $page_name);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE meta_titles SET meta_title = ? meta_content = ? WHERE page_name = ?");
        $stmt->bind_param("sss", $meta_title, $meta_content, $page_name);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Meta title changed successfully.";
    } else {
        $stmt = $conn->prepare("INSERT INTO meta_titles (page_name, meta_title, meta_content) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $page_name, $meta_title, $meta_content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Meta title created successfully.";
    }
    $stmt->execute();
}
$result = $conn->query("SELECT * FROM meta_titles");
$metaTitles = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../admin.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title>Meta Titles Management</title>
</head>

<body>
    <?php require("../extras/header2.php"); ?>
    <section class="newpost_body">
        <form method="POST" action="changelang.php" enctype="multipart/form-data" id="postForm" class="newpost_container">
            <div class="page_links">
                <a href="../admin_homepage.php">Home</a> > <p>Pages</p> > <p>Meta Titles Management</p>
            </div>
            <div class="newpost_container_divnew newpost_subdiv">
                <h1>Manage Meta Titles</h1>
                <div class='newpost_subdiv_subdiv2'>
                    <label class="form__label" for="page_name">Page Name:</i></label>
                    <input type="text" name="page_name" id="page_name" required>
                </div>
                <div class='newpost_subdiv_subdiv2'>
                    <label class="form__label" for="meta_title">Meta Title:</i></label>
                    <input type="text" name="meta_title" id="page_name" required>
                </div>
                <div class='newpost_subdiv_subdiv2'>
                    <label class="form__label" for="meta_content">Meta Content:</i></label>
                    <input type="text" name="meta_content" id="page_name" required>
                </div>
                <input type="submit" class="btn" name="change_meta_title">
            </div>
            <div class="newpost_container_divnew newpost_subdiv">
                <h1>Existing Meta Titles</h1>
                <ul>
                    <?php foreach ($metaTitles as $meta) : ?>
                        <li><strong><?= htmlspecialchars($meta['page_name']) ?>:</strong> <?= htmlspecialchars($meta['meta_title']) ?></li>
                    <?php endforeach; ?>
                </ul>
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