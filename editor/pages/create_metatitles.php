<?php
session_start();
include("../connect.php");
require("../init.php");
require('../../init.php');
function convertToReadable($slug)
{
    $string = str_replace('-', ' ', $slug);
    $string = ucwords($string);
    return $string;
}
function convertToUnreadable($slug)
{
    $string = strtolower($slug);
    $string = str_replace(' ', '-', $string);
    return $string;
}
function removeHyphen($string)
{
    $string = str_replace(['-', ' '], '', $string);
    return $string;
}
$details = getFaviconAndLogo();
$translationFile = "../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = []; // Initialize as empty array to avoid undefined variable errors
}
$logo = $details['logo'];
$favicon = $details['favicon'];
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
$userId = $_SESSION['id'];
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
    <link rel="stylesheet" href="../editor.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['meta_titles_management']; ?></title>
</head>

<body>
    <?php require("../extras/header3.php"); ?>

    <section class="newpost_body">
        <form method="POST" action=" " enctype="multipart/form-data" id="postForm" class="newpost_container">
            <div class="page_links">
                <a href="../editor_homepage.php"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['settings']; ?></p> > <p><?php echo $translations['meta_titles_management']; ?></p>
            </div>
            <div class="newpost_container_divnew newpost_subdiv">
                <h1 class="sectioneer_form_header"><?php echo $translations['meta_titles_management_title']; ?></h1>
            </div>
            <div class="frontend_div sectioneer_div">
                <?php
                $getpage_sql = " SELECT id, page_name FROM meta_titles ORDER BY id";
                $getpage_result = $conn->query($getpage_sql);
                if ($getpage_result->num_rows > 0) {
                    echo "<div class='sectioneer_div_subdiv'>";
                    while ($row = $getpage_result->fetch_assoc()) {
                        $page_name = $row['page_name'];
                        $page_id = $row['id'];
                        $readableString = convertToReadable($page_name);
                        echo "<div>
                                        <p>$readableString</p>
                                        <a class='viewMeta' data-id='$page_id'>
                                            <i class='fa fa-eye' aria-hidden='true'></i>
                                        </a>
                                    </div>";
                    }
                    echo "</div>";
                }
                ?>
            </div>
        </form>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/4x49ifq5jl99k0b9aot23a5ynnqfcr8jdlee7v6905rgmzql/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="../editor.js"></script>
    <script src="sweetalert2.all.min.js"></script>
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
    <script>
        $(document).ready(function() {
            $(".viewMeta").click(function() {
                var pageId = $(this).data("id");
                $.ajax({
                    url: "fetch_meta.php",
                    type: "POST",
                    data: {
                        page_id: pageId
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            let queryString = `../edit/editmetatitles.php?page_name=${encodeURIComponent(data.page_name)}`;

                            for (let i = 1; i <= 5; i++) {
                                queryString += `&meta_name${i}=${encodeURIComponent(data["meta_name" + i])}`;
                                queryString += `&meta_content${i}=${encodeURIComponent(data["meta_content" + i])}`;
                            }
                            window.location.href = queryString;
                        } else {
                            alert("No metadata found.");
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>