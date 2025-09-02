<?php
/** @var \mysqli $conn */
global $conn;
$language = $language ?? 'en';
$translations = $translations ?? [];
$base_url = $base_url ?? '';
session_start();
require("../connect.php");
require('../../init.php');
require("../../helpers/components.php");
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
require("../init.php");
$translationFile = "../../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = [];
}
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_type = isset($_GET['usertype']) ? $_GET['usertype'] : null;
$firstname = isset($_GET['firstname']) ? $_GET['firstname'] : null;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_message'])) {
    $user_id = $_POST['user_id'];
    $user_type = $_POST['user_type'];
    $message = $_POST['message'];
    $title = $_POST['subject'];
    $date = date('y-m-d');
    date_default_timezone_set('Africa/Lagos');
    $time = date('H:i:s');
    $stmt = $conn->prepare("INSERT INTO messages (user_id, user_type, title, message, Date, time, user_firstname) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $user_id, $user_type, $title, $message, $date, $time, $firstname);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " sent $user_type($firstname) a message";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Message delivered Successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../css/admin.css" />
    <script src="../../javascript/admin.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tiny.cloud/1/4x49ifq5jl99k0b9aot23a5ynnqfcr8jdlee7v6905rgmzql/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['send_message']; ?></title>
</head>

<body>
    <?php
    require("../extras/header3.php");
    $submitName = 'send_message';
    $action = 'message.php';
    if ($id > 0) {
        if ($user_type == "Editor") {
            $query = "SELECT id, image, firstname FROM editor WHERE id = $id";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $userType = 'Editor';
                $id = $row['id'];
                $image = $row['image'];
                $firstname = $row['firstname'];
                renderMessageForm($userType, $id, $image, $firstname, $action, $submitName);
            }
        } else if ($user_type == "Subscriber") {
            $get_subscriber = "SELECT * FROM subscribers WHERE id = $id";
            $geteditor_result = $conn->query($get_subscriber);
            if ($geteditor_result->num_rows > 0) {
                $row = $geteditor_result->fetch_assoc();
                $userType = 'Subscriber';
                $id = $row['id'];
                $image = null;
                $email = $row['email'];
                renderMessageForm($userType, $id, $image, $email, $action, $submitName);
            }
        } else if ($user_type == "Website User") {
            $get_subscriber = "SELECT * FROM otherwebsite_users WHERE id = $id";
            $geteditor_result = $conn->query($get_subscriber);
            if ($geteditor_result->num_rows > 0) {
                $row = $geteditor_result->fetch_assoc();
                $userType = 'Website User';
                $id = $row['id'];
                $image = $row['image'];
                $email = $row['email'];
                renderMessageForm($userType, $id, $image, $email, $action, $submitName);
            }
        } else if ($user_type == "Writer") {
            $get_subscriber = "SELECT * FROM writer WHERE id = $id";
            $geteditor_result = $conn->query($get_subscriber);
            if ($geteditor_result->num_rows > 0) {
                $row = $geteditor_result->fetch_assoc();
                $userType = 'Writer';
                $id = $row['id'];
                $image = $row['image'];
                $email = $row['email'];
                renderMessageForm($userType, $id, $image, $email, $action, $submitName);
            }
        }
    }
    ?>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            preventSubmitIfEmpty('.formC', 'input, textarea');
            restoreFromLocalStorage();
            document.getElementById('formSubmitBtn').addEventListener('click', function() {
                clearLocalStorage();
            });
        });
        tinymce.init({
            selector: '#myTextareaq',
            setup: function(editor) {
                editor.on('init', function() {
                    editor.editorContainer.style.width = "100%";
                });
            },
            resize: true,
            plugins: [
                'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
                'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
                'media', 'table', 'emoticons', 'help'
            ],
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
                'forecolor backcolor emoticons | help',
            menu: {
                favs: {
                    title: 'My Favorites',
                    items: 'code visualaid | searchreplace | emoticons'
                }
            },
            menubar: 'favs file edit view insert format tools table help',
            content_css: 'css/content.css'
        });
        let resizeTimeout;
        window.addEventListener("resize", function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                if (tinymce.activeEditor) {
                    let newWidth = window.innerWidth * 0.8;
                    let newHeight = window.innerHeight * 0.7;
                    tinymce.activeEditor.editorContainer.style.width = newWidth + "px";
                    tinymce.activeEditor.editorContainer.style.height = newHeight + "px";
                }
            }, 200);
        });
    </script>
    <script src="sweetalert2.all.min.js"></script>
    <script>
        var messageType = "<?= $_SESSION['status_type'] ?>";
        var messageText = "<?= $_SESSION['status'] ?>";
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