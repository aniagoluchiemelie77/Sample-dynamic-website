<?php
session_start();
require("../connect.php");
require('../../init.php');
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
require("../init.php");
$translationFile = "../translation_files/lang/{$language}.php";
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
    $stmt->close();
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
    <link rel="stylesheet" href="../admin.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tiny.cloud/1/4x49ifq5jl99k0b9aot23a5ynnqfcr8jdlee7v6905rgmzql/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['send_message']; ?></title>
</head>

<body>
    <?php
    require("../extras/header3.php");
    if ($id > 0) {
        if ($user_type == "Editor") {
            $get_subscriber = "SELECT id, image, firstname FROM editor WHERE id = $id";
            $get_subscriber_result = $conn->query($get_subscriber);
            if ($get_subscriber_result->num_rows > 0) {
                $row = $get_subscriber_result->fetch_assoc();
                echo "<div class='newpost_body2'>
                            <div class='nav_quicklinks'>
                                <a href = '../admin_homepage.php'>$translations[home]</a> > <p>$translations[send_message_i] <span>" . $row['firstname'] . "</span> </p>
                            </div>
                            <div class='message_div-container'>
                                <div class='message_div-container_subdiv'>
                                    <img src='../../" . $row['image'] . "' alt='Editors Image'/>
                                    <div class='message_div-container_subdiv-imagebody'>
                                        <form id='updateForm' action='message.php' method='POST'>
                                            <div class='input_group'>
                                                <input name='subject' placeholder='$translations[message_title]..'/>
                                                <p><span>* </span>$translations[message_title_i]</p>
                                            </div>
                                            <div class='input_group'>
                                                <label for='content'>$translations[compose]:</label>
                                                <textarea name='message' id='myTextareaq'></textarea>
                                            </div>
                                            <input value='editor' style='display:none' name='user_type' type='text'/>
                                            <input value='" . $row['id'] . "' style='display:none' name='user_id' type='text'/>
                                            <input type='submit' name='send_message' value='$translations[send_message]' class='btn send_messagebtn'/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>";
            }
        } else if ($user_type == "Subscriber") {
            $get_subscriber = "SELECT * FROM subscribers WHERE id = $id";
            $geteditor_result = $conn->query($get_subscriber);
            if ($geteditor_result->num_rows > 0) {
                $row = $geteditor_result->fetch_assoc();
                echo "<div class='newpost_body2'>
                            <div class='nav_quicklinks'>
                                <a href = '../admin_homepage.php'>$translations[home]</a> > <p>$translations[send_message_i] <span>" . $row['email'] . "</span> </p>
                            </div>
                            <div class='message_div-container'>
                                <div class='message_div-container_subdiv'>
                                    <img src='../../images/lookmoni.jpg' alt='Editors Image'/>
                                    <div class='message_div-container_subdiv-imagebody'>
                                        <form id='updateForm' action='../forms.php' method='POST'>
                                            <div class='input_group'>
                                                <input name='subject' placeholder='$translations[message_title]..' class='input_group_input'/>
                                                <p><span>* </span>$translations[message_title_i]</p>
                                            </div>
                                            <div class='input_group'>
                                                <label for='content'>$translations[compose]:</label>
                                                <textarea name='message' id='myTextareaq'></textarea>
                                            </div>
                                            <input value='" . $row['id'] . "' style='display:none' name='user_id' type='text'/>
                                            <input type='submit' name='send_message_subscriber' value='$translations[send_message]' class='btn send_messagebtn'/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>";
            }
        } else if ($user_type == "Website User") {
            $get_subscriber = "SELECT * FROM otherwebsite_users WHERE id = $id";
            $geteditor_result = $conn->query($get_subscriber);
            if ($geteditor_result->num_rows > 0) {
                $row = $geteditor_result->fetch_assoc();
                echo "<div class='newpost_body2'>
                            <div class='nav_quicklinks'>
                                <a href = '../admin_homepage.php'>$translations[home]</a> > <p>$translations[send_message_i] <span>" . $row['email'] . "</span> </p>
                            </div>
                            <div class='message_div-container'>
                                <div class='message_div-container_subdiv'>
                                    <img src='../../images/lookmoni.jpg' alt='Editors Image'/>
                                    <div class='message_div-container_subdiv-imagebody'>
                                        <form id='updateForm' action='../forms.php' method='POST'>
                                            <div class='input_group'>
                                                <input name='subject' placeholder='$translations[message_title]..' class='input_group_input'/>
                                                <p><span>* </span>$translations[message_title_i]</p>
                                            </div>
                                            <div class='input_group'>
                                                <label for='content'>$translations[compose]:</label>
                                                <textarea name='message' id='myTextareaq'></textarea>
                                            </div>
                                            <input value='" . $row['id'] . "' style='display:none' name='user_id' type='text'/>
                                            <input type='submit' name='send_message_user' value='$translations[send_message]' class='btn send_messagebtn'/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>";
            }
        } else if ($user_type == "Writer") {
            $get_subscriber = "SELECT * FROM writer WHERE id = $id";
            $geteditor_result = $conn->query($get_subscriber);
            if ($geteditor_result->num_rows > 0) {
                $row = $geteditor_result->fetch_assoc();
                echo "<div class='newpost_body2'>
                            <div class='nav_quicklinks'>
                                <a href = '../admin_homepage.php'>$translations[home]</a> > <p>$translations[send_message_i] <span>" . $row['email'] . "</span> </p>
                            </div>
                            <div class='message_div-container'>
                                <div class='message_div-container_subdiv'>
                                    <img src='../../images/lookmoni.jpg' alt='Editors Image'/>
                                    <div class='message_div-container_subdiv-imagebody'>
                                        <form id='updateForm' action='../forms.php' method='POST'>
                                            <div class='input_group'>
                                                <input name='subject' placeholder='$translations[message_title]..' class='input_group_input'/>
                                                <p><span>* </span>$translations[message_title_i]</p>
                                            </div>
                                            <div class='input_group'>
                                                <label for='content'>$translations[compose]:</label>
                                                <textarea name='message' id='myTextareaq'></textarea>
                                            </div>
                                            <input value='" . $row['id'] . "' style='display:none' name='user_id' type='text'/>
                                            <input type='submit' name='send_message_writer' value='$translations[send_message]' class='btn send_messagebtn'/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>";
            }
        }
    }
    ?>
    <script src="../admin.js"></script>
    <script type="text/javascript">
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
    </script>
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
</body>

</html>
<?php
?>