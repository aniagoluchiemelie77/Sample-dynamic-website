<?php
session_start();
require("../connect.php");
require("../init.php");
function convertToReadable($slug)
{
    $string = str_replace('_', ' ', $slug);
    $string = ucwords($string);
    return $string;
}
function convertToUnreadable($slug)
{
    $string = strtolower($slug);
    $string = str_replace(' ', '_', $string);
    return $string;
}
function removeHyphen($string)
{
    $string = str_replace(['-', ' '], '', $string);
    return $string;
}
$translationFile = "../translation_files/lang/{$language}.php";
if (file_exists($translationFile)) {
    include $translationFile;
} else {
    $translations = [];
}
function convertPath($path)
{
    return basename($path);
}
function addResources($resource_type)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("INSERT INTO resources ( resource_name, Date, time) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $resource_type, $date, $time);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " added a new Resource type";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Resource type Created Successfully";
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
    }
    $stmt->close();
}
function addPage($page_name)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("INSERT INTO pages ( page_name, Date, time) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $page_name, $date, $time);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " created a new page type";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Page type Created Successfully";
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
    }
    $stmt->close();
}
if (isset($_POST['add_resource'])) {
    $resource_type = $_POST['resource_type'];
    $resource_url = $_POST['resource_url'];
    $resource_image = $_FILES['resource_image']['name'];
    $target = "../images/" . basename($resource_image);
    if (move_uploaded_file($_FILES['resource_image']['tmp_name'], $target)) {
        $imagePath = $target;
        $convertedPath = convertPath($imagePath);
        $resource_type = convertToUnreadable($resource_type);
        addResources($resource_type);
    }
}
if (isset($_POST['add_page'])) {
    $page_name = $_POST['page_name'];
    $page_name = convertToUnreadable($page_name);
    addPage($page_name);
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <meta name="author" content="Aniagolu Diamaka" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../index.css" />
    <link id="themeStylesheet" rel="stylesheet" href="../admin.css" />
    <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="../admin.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title><?php echo $translations['customise_frontend']; ?></title>
</head>

<body>
    <div class="logout_alert" id="logout_alert">
        <form class="newpost_container" method="post" action="" id="postForm">
            <a class="logout_alert_cancel" onclick="cancelExit()">
                <i class="fa fa-times popup_close1" aria-hidden="true"></i>
            </a>
            <div class="newpost_container_div1 newpost_subdiv">
                <h1 class="sectioneer_form_header">Add Resource</h1>
            </div>
            <div class="newpost_container_div3 newpost_subdiv">
                <label class="form__label" for="resource_type">Resource Type</label>
                <div class="newpost_container_div3_subdiv2">
                    <input class="form__input" name="resource_type" type="text" required />
                </div>
            </div>
            <div class="newpost_container_div6">
                <div class="newpost_container_div6_subdiv">
                    <label class="form__label" for="resource_image">Upload Resource</label>
                    <div class="newpost_subdiv2">
                        <input class="form__input" name="resource_image" type="file" />
                        <p class="newpost_subdiv2-p leftp"><span>*</span>Optional</p>
                    </div>
                </div>
                <div class="newpost_container_div6_subdiv">
                    <label class="form__label" for="resource_url">Resource URL:</label>
                    <div class="newpost_container_div5_subdiv2">
                        <input class="form__input" name="resource_url" type="text" placeholder="Enter Resource URL..." />
                    </div>
                </div>
            </div>
            <div class="newpost_container_div9 newpost_subdiv">
                <input class="form__submit_input" type="submit" value="Save" name="add_resource" />
            </div>
        </form>
    </div>
    <div class="logout_alert" id="logout_alert2">
        <form class="newpost_container" method="post" action="" id="postForm">
            <a class="logout_alert_cancel" onclick="cancelExit2()">
                <i class="fa fa-times popup_close1" aria-hidden="true"></i>
            </a>
            <div class="newpost_container_div1 newpost_subdiv">
                <h1 class="sectioneer_form_header">Add Page</h1>
            </div>
            <div class="newpost_container_div3 newpost_subdiv">
                <label class="form__label" for="page_name">Page Name</label>
                <div class="newpost_container_div3_subdiv2">
                    <input class="form__input" name="page_name" type="text" required />
                </div>
            </div>
            <div class="newpost_container_div9 newpost_subdiv">
                <input class="form__submit_input" type="submit" value="Save" name="add_page" />
            </div>
        </form>
    </div>
    <?php require("../extras/header2.php"); ?>
    <section class="sectioneer">
        <form class="frontend_div sectioneer_form" action="" method="POST">
            <div class="sectioneer_form_container">
                <div class="sectioneer_form_container_subdiv2">
                    <h1 class="sectioneer_form_header">Edit Website Logo</h1>
                    <div class="sectioneer_form_container_subdiv2_subdiv">
                        <img src="#" class="" alt="Website's Logo">
                        <a class="add_div" onclick="document.getElementById('fileInput').click();">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            <p>Edit Logo</p>
                        </a>
                        <input type="file" id="fileInput" name="website_logo" style="display: none;">
                    </div>
                </div>
                <div class="sectioneer_form_container_subdiv2">
                    <h1 class="sectioneer_form_header">Edit Favicon</h1>
                    <div class='sectioneer_form_container_subdiv2_subdiv'>
                        <img src="#">
                        <a class="add_div" onclick="document.getElementById('fileInput2').click();">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            <p>Edit Favicon</p>
                        </a>
                        <input type="file" id="fileInput2" name="website_favicon" style="display: none;">
                    </div>
                </div>
            </div>
            <input class="btn" type="submit" value="<?php echo $translations['save']; ?>" name="change_logo" />
        </form>
        <form class="frontend_div sectioneer_form" action="" method="POST">
            <div class="sectioneer_form_container">
                <div class="sectioneer_form_container_subdiv2">
                    <h1 class="sectioneer_form_header">Edit cookie consent message</h1>
                    <textarea name='cookie_consent' id=''></textarea>
                </div>
                <div class="sectioneer_form_container_subdiv2">
                    <h1 class="sectioneer_form_header">Edit Website Description</h1>
                    <textarea name='description' id=''></textarea>
                </div>
            </div>
            <input class="btn" type="submit" value="<?php echo $translations['save']; ?>" name="change_frontend_messages" />
        </form>
        <div class="frontend_div sectioneer_div">
            <h1 class="sectioneer_form_header">Resources</h1>
            <?php
            $getresource_sql = " SELECT id, resource_name FROM resources ORDER BY id";
            $getresource_result = $conn->query($getresource_sql);
            if ($getresource_result->num_rows > 0) {
                echo "<div class='sectioneer_div_subdiv'>";
                while ($row = $getresource_result->fetch_assoc()) {
                    $resource_name = $row['resource_name'];
                    $resource_id = $row['id'];
                    $readableString = convertToReadable($resource_name);
                    echo "<div>
                                        <p>$readableString</p>
                                        <a class='' onclick='confirmDeleteResource($resource_id)'>
                                            <i class='fa fa-trash' aria-hidden='true'></i>
                                        </a>
                                    </div>";
                }
                echo "  <a class='add_div' onclick='displayExit()'>
                                    <i class='fa fa-plus' aria-hidden='true'></i>
                                    <p>Add Resource</p>
                                </a>
                            </div>";
            }
            ?>
        </div>
        <div class="frontend_div sectioneer_div">
            <h1 class="sectioneer_form_header">Pages</h1>
            <?php
            $getpages_sql = " SELECT id, page_name FROM pages ORDER BY id";
            $getpages_result = $conn->query($getpages_sql);
            if ($getpages_result->num_rows > 0) {
                echo "<div class='sectioneer_div_subdiv'>";
                while ($row = $getpages_result->fetch_assoc()) {
                    $page_name = $row['page_name'];
                    $page_id = $row['id'];
                    $readableString = convertToReadable($page_name);
                    echo "<div>
                            <p>$readableString</p>
                            <a class='' onclick='confirmDeletePage($resource_id)'>
                                <i class='fa fa-trash' aria-hidden='true'></i>
                            </a>
                        </div>";
                }
                echo "  <a class='add_div' onclick='displayExit2()'>
                            <i class='fa fa-plus' aria-hidden='true'></i>
                            <p>Add Page</p>
                        </a>
                    </div>";
            }
            ?>
        </div>
    </section>
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