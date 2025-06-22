<?php
session_start();
require("../connect.php");
require("../init.php");
require('../../init.php');
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$_SESSION['logo_id'] = '';
$_SESSION['message_id'] = "";
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../editor.css" />
    <link id="themeStylesheet" rel="stylesheet" href="../editor.css" />
    <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="../editor.js" defer></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title><?php echo $translations['customise_frontend']; ?></title>
</head>

<body>
    <div class="logout_alert" id="logout_alert">
        <form class="newpost_container" method="POST" action="../forms.php" id="postForm" enctype="multipart/form-data">
            <a class="logout_alert_cancel" onclick="cancelExit()">
                <i class="fa fa-times popup_close1" aria-hidden="true"></i>
            </a>
            <div class="newpost_container_div1 newpost_subdiv">
                <h1 class="sectioneer_form_header"><?php echo $translations['add_resource']; ?></h1>
            </div>
            <div class="newpost_container_div3 newpost_subdiv">
                <label class="form__label" for="resource_type"><?php echo $translations['resource_type']; ?></label>
                <div class="newpost_container_div3_subdiv2">
                    <input class="form__input" name="resource_type" type="text" />
                </div>
            </div>
            <div class="newpost_container_div6">
                <div class="newpost_container_div6_subdiv">
                    <label class="form__label" for="resource_image"><?php echo $translations['upload_resource']; ?></label>
                    <div class="newpost_subdiv2">
                        <input class="form__input" name="resource_image" type="file" />
                        <p class="newpost_subdiv2-p leftp"><span>*</span><?php echo $translations['message_title_i']; ?></p>
                    </div>
                </div>
                <div class="newpost_container_div6_subdiv">
                    <label class="form__label" for="resource_url"><?php echo $translations['resource_url']; ?>:</label>
                    <div class="newpost_container_div5_subdiv2">
                        <input class="form__input" name="resource_url" type="text" placeholder="<?php echo $translations['require']; ?>" />
                    </div>
                </div>
                <div class="newpost_container_div6_subdiv">
                    <label class="form__label" for="resource_url"><?php echo $translations['resource_niche']; ?>:</label>
                    <div class="newpost_container_div5_subdiv2">
                        <input class="form__input" name="resource_niche" type="text" placeholder="<?php echo $translations['resource_niche_p']; ?>..." />
                    </div>
                </div>
                <div class="newpost_container_div6_subdiv">
                    <label class="form__label" for="resource_url"><?php echo $translations['resource_title']; ?>:</label>
                    <div class="newpost_container_div5_subdiv2">
                        <input class="form__input" name="resource_title" type="text" placeholder="<?php echo $translations['resource_title_p']; ?>..." />
                    </div>
                </div>
            </div>
            <div class="newpost_container_div9 newpost_subdiv">
                <input class="form__submit_input" type="submit" value="<?php echo $translations['save']; ?>" name="add_resource" />
            </div>
        </form>
    </div>
    <?php require("../extras/header3.php"); ?>
    <section class="sectioneer">
        <div class="page_links">
            <a href="../editor_homepage.php"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['settings']; ?></p> > <p><?php echo $translations['edit_frontend_title']; ?></p>
        </div>
        <div class="frontend_div sectioneer_div">
            <h1 class="sectioneer_form_header"><?php echo $translations['resources']; ?></h1>
            <?php
            $getresource_sql = " SELECT id, resource_name FROM resources ORDER BY id";
            $getresource_result = $conn->query($getresource_sql);
            if ($getresource_result->num_rows > 0) {
                echo "<div class='sectioneer_div_subdiv'>";
                while ($row = $getresource_result->fetch_assoc()) {
                    $resource_name = $row['resource_name'];
                    $resource_id = $row['id'];
                    $readableString = convertToReadable2($resource_name);
                    $resource_name2 = removeUnderscore2($resource_name);
                    echo "<div>
                                        <p>$readableString</p>
                                        <a class='' onclick='confirmDeleteResource($resource_id, \"" . htmlspecialchars($resource_name2, ENT_QUOTES) . "\")'>
                                            <i class='fa fa-trash' aria-hidden='true'></i>
                                        </a>
                                    </div>";
                }
                echo "  <a class='add_div' onclick='displayExit()'>
                                    <i class='fa fa-plus' aria-hidden='true'></i>
                                    <p>$translations[add_resource]</p>
                                </a>
                            </div>";
            }
            ?>
        </div>
    </section>
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
    <script src="https://cdn.tiny.cloud/1/4x49ifq5jl99k0b9aot23a5ynnqfcr8jdlee7v6905rgmzql/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
</body>

</html>