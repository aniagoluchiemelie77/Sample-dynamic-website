<?php
session_start();
include("../connect.php");
require('../../init.php');
require("../init.php");
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$resource_name = isset($_GET['resource_name']) ? $_GET['resource_name'] : null;
$resource_name_uc = ucwords($resource_name);
$translationFile = "../../translation_files/lang/{$language}.php";
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['edit_resource_file']; ?></title>
</head>

<body>
    <?php
    require("../extras/header3.php");
    $get_resource_file = "SELECT * FROM $resource_name WHERE id = $id";
    $get_resource_result = $conn->query($get_resource_file);
    if ($get_resource_result->num_rows > 0) {
        $resource_file = $get_resource_result->fetch_assoc();
        $name = $resource_file['name'];
        $resource_path = $resource_file['resource_path'];
        $date_added = $resource_file['date_added'];
        $date_added = formatDate($date_added);
        $time_added = $resource_file['time_added'];
        $time_added = formatTime($time_added);
        $niche = $resource_file['niche'];
        $title  = $resource_file['title'];
        echo "<div class='editprofile_container'>
                    <form class='create_editor_container' action='../../helpers/forms.php' method='post' enctype='multipart/form-data'>
                        <div class='createeditor_inputgroup'>
                            <h1 class='bigheader'>$translations[edit_resource_file] ($resource_name_uc) </h1>
                        </div>
                        <div class='newpost_container_div6 newpost_subdiv'>
                            <div class='newpost_container_div6_subdiv2'>
                                <label class='form__label' for='File'>$translations[edit_resource_path]: </label>
                                <div class='newpost_subdiv2'>
                                    <input class='form__input' name='File' type='file'/>
                                </div>
                            </div>
                        </div>
                        <input name='resource_type' type='hidden' value='$resource_name'/>
                        <input name='resource_type_id' type='hidden' value='$id'/>
                        <div class='createeditor_inputgroup'>
                            <label class='createeditor_label rightmargin' for='resource_path'>$translations[resource_path]:</label>
                            <input class='createeditor_input' type='text' name='resource_path' value='$resource_path'/>
                        </div>
                        <div class='createeditor_inputgroup'>
                            <label class='createeditor_label rightmargin' for='resource_title'>$translations[title]:</label>
                            <input class='createeditor_input' type='text' name='resource_title' value='$title'/>
                        </div>
                        <div class='createeditor_inputgroup'>
                            <label class='createeditor_label rightmargin' for='resource_niche'>$translations[niche]:</label>
                            <input class='createeditor_input' type='text' name='resource_niche' value='$niche'/>
                        </div>
                        <div class='createeditor_inputgroup'>
                            <label class='createeditor_label rightmargin' for='resource_name'>$translations[resource_name]:</label>
                            <input class='createeditor_input' type='text' name='resource_name' value='$name'/>
                        </div>
                        <div class='createeditor_inputgroup'>
                            <p>
                                <span>$translations[date_added]:</span>
                                $date_added
                            </p>
                            <p>
                                <span>$translations[time_added]:</span>
                                $time_added
                            </p>
                        </div>
                        <input class='createeditor_input-submit' value='$translations[save]' name='edit_resource_file' type='submit'/>
                    </form>
                </div>";
    }
    ?>
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
        document.addEventListener('DOMContentLoaded', function() {
            preventSubmitIfUnchanged('.create_editor_container', 'input[type="text"], input[type="file"]');
        });
    </script>

</body>

</html>