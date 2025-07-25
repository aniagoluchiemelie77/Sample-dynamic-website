<?php
session_start();
$page_name = isset($_GET['page_name']) ? $_GET['page_name'] : "Unknown Page";
include("../connect.php");
require("../init.php");
require('../../init.php');
function removeHyphen($string)
{
    $string = str_replace(['-', ' '], ' ', $string);
    $string = ucwords($string);
    return $string;
}
function updateMetatitle($meta1, $meta2, $meta3, $meta4, $meta5, $content1, $content2, $content3, $content4, $content5, $page_name)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE meta_titles SET meta_name1 = ?, meta_name2 = ?, meta_name3 = ?, meta_name4 = ?, meta_name5 = ?, meta_content1 = ?, meta_content2 = ?, meta_content3 = ?, meta_content4 = ?, meta_content5 = ? WHERE page_name = ?");
    $stmt->bind_param("sssssssssss", $meta1, $meta2, $meta3, $meta4, $meta5, $content1, $content2, $content3, $content4, $content5, $page_name);
    if ($stmt->execute()) {
        $page_name = removeHyphen($page_name);
        $content = "Admin " . $_SESSION['firstname'] . " updated Meta titles and contents for $page_name";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Meta Titles and Content Updated Successfully";
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
    }
    $stmt->close();
}
if (isset($_POST['edit_metatitle'])) {
    $meta_name1 = $_POST['meta_name1'];
    $meta_name2 = $_POST['meta_name2'];
    $meta_name3 = $_POST['meta_name3'];
    $meta_name4 = $_POST['meta_name4'];
    $meta_name5 = $_POST['meta_name5'];
    $meta_content1 = $_POST['meta_content1'];
    $meta_content2 = $_POST['meta_content2'];
    $meta_content3 = $_POST['meta_content3'];
    $meta_content4 = $_POST['meta_content4'];
    $meta_content5 = $_POST['meta_content5'];
    updateMetatitle($meta_name1, $meta_name2, $meta_name3, $meta_name4, $meta_name5, $meta_content1, $meta_content2, $meta_content3, $meta_content4, $meta_content5, $page_name);
}
$orginalPageName = $page_name; // Store the original page name for later use
$page_name = removeHyphen($page_name);
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$translationFile = "../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = []; // Initialize as empty array to avoid undefined variable errors
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../admin.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['edit_metatitles']; ?></title>
</head>

<body>
    <?php require("../extras/header2.php"); ?>
    <div class="editprofile_container">
        <form class="newpost_container modal-content" method="POST" action=" " id="postForm" enctype="multipart/form-data">
            <?php echo "<h2 class='sectioneer_form_header'>$translations[edit_metatitles_p] $page_name</h2>"; ?>
            <?php
            for ($i = 1; $i <= 5; $i++) {
                $meta_name = isset($_GET["meta_name$i"]) ? $_GET["meta_name$i"] : "";
                $meta_content = isset($_GET["meta_content$i"]) ? $_GET["meta_content$i"] : "";

                echo "<div class='newpost_container_div3 newpost_subdiv'>
                            <label class='form__label'>Meta Name ($i)</label>
                            <div class='newpost_container_div3_subdiv2'>
                                <input class='form__input' type='text' name='meta_name$i' value='$meta_name'/>
                            </div>
                          </div>";
                echo "<div class='newpost_container_div3 newpost_subdiv'>
                            <label class='form__label'>Meta Content ($i)</label>
                            <div class='newpost_container_div3_subdiv2'>
                                <input class='form__input' type='text' name='meta_content$i' value='$meta_content'/>
                            </div>
                          </div>";
            }
            ?>
            <div class="newpost_container_div9 newpost_subdiv">
                <input class="form__submit_input" type="submit" value="<?php echo $translations['save']; ?>" name="edit_metatitle" />
            </div>
        </form>
    </div>
    <script src="../admin.js"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script>
        preventSubmitIfUnchanged('.newpost_container', 'input[type="text"]');
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