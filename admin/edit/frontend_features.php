<?php
session_start();
require("../connect.php");
require("../crudoperations.php");
require("../init.php");
require('../../init.php');
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
$_SESSION['logo_id'] = '';
$_SESSION['message_id'] = "";
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
    $cleaned = str_replace("../../", " ", $path);
    return basename($cleaned);
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
function addLogo($imagePath1, $imagePath2)
{
    $id = $_SESSION['logo_id'];
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("INSERT INTO website_logo ( logo_imagepath, favicon_imagepath, Date, time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $imagePath1, $imagePath2, $date, $time);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " added new Website Logo and Favicon";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Website Logo and Favicon Created Successfully";
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
    }
    $stmt->close();
}
function updateFavicon($imagePath2)
{
    $id = $_SESSION['logo_id'];
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("UPDATE website_logo SET favicon_imagepath = ?, Date = ?, time = ?  WHERE id = ?");
    $stmt->bind_param("sssi", $imagePath2, $date, $time, $id);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " added new Website Favicon";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Website Favicon Created Successfully";
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
    }
    $stmt->close();
}
function updateLogo($imagePath1)
{
    $id = $_SESSION['logo_id'];
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("UPDATE website_logo SET logo_imagepath = ?, Date = ?, time = ?  WHERE id = ?");
    $stmt->bind_param("sssi", $imagePath1, $date, $time, $id);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " added new Website Logo";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Website Logo Created Successfully";
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
function AddWebsiteMessages($cookie_message, $description)
{
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("INSERT INTO website_messages ( cookie_consent, website_vision, Date, time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $cookie_message, $description, $date, $time);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " added new cookie consent message and website description";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Cookie consent message and Website description created successfully";
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
    }
    $stmt->close();
}
function updateCookie($cookie_message)
{
    $id = $_SESSION['message_id'];
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("UPDATE website_messages SET cookie_consent = ?, Date = ?, time = ?  WHERE id = ?");
    $stmt->bind_param("sssi", $cookie_message, $date, $time, $id);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " updated cookie consent message";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Cookie Consent Message Created Successfully";
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
    }
    $stmt->close();
}
function updateDescription($website_description)
{
    $id = $_SESSION['message_id'];
    global $conn;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("UPDATE website_messages SET website_vision = ?, Date = ?, time = ?  WHERE id = ?");
    $stmt->bind_param("sssi", $website_description, $date, $time, $id);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " updated website desciption";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Website Description Updated Successfully";
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
    }
    $stmt->close();
}
if (isset($_POST['change_frontend_messages'])) {
    $cookie_consent = $_POST['cookie_consent'];
    $description = $_POST['description'];
    if (!empty($cookie_consent) && empty($description)) {
        updateCookie($cookie_consent);
    } else if (empty($cookie_consent) && !empty($description)) {
        updateDescription($description);
    } else if (!empty($cookie_consent) && !empty($description)) {
        AddWebsiteMessages($cookie_consent, $description);
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "No Changes Made";
    }
}
if (isset($_POST['add_resource'])) {
    $resource_type = $_POST['resource_type'];
    $resource_url = $_POST['resource_url'];
    $resource_image = $_FILES['resource_image']['name'];
    $resource_tmp_name = $_FILES['resource_image']['tmp_name'];
    $resource_folder = "../../images/" . $resource_image;
    if (move_uploaded_file($resource_tmp_name, $resource_folder)) {
        $imagePath = $resource_folder;
        $convertedPath = convertPath($imagePath);
        $resource_type = convertToUnreadable($resource_type);
        addResources($resource_type);
    } else {
        echo "No image uploaded.";
    }
}
if (isset($_POST['change_logo'])) {
    $website_logo = $_FILES['website_logo']['name'];
    $logo_tmp_name = $_FILES['website_logo']['tmp_name'];
    $website_favicon = $_FILES['website_favicon']['name'];
    $favicon_tmp_name = $_FILES['website_favicon']['tmp_name'];
    $resource_folder1 = "../../images/" . $website_logo;
    $resource_folder2 = "../../images/" . $website_favicon;
    if (!empty($website_logo) && empty($website_favicon)) {
        if (move_uploaded_file($logo_tmp_name, $resource_folder1)) {
            $imagePath1 = $resource_folder1;
            $convertedPath1 = convertPath($imagePath1);
            UpdateLogo($convertedPath1);
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error Moving Uploaded Files";
        }
    } else if (empty($website_logo) && !empty($website_favicon)) {
        if (move_uploaded_file($favicon_tmp_name,  $resource_folder2)) {
            $imagePath2 = $resource_folder2;
            $convertedPath2 = convertPath($imagePath2);
            UpdateFavicon($convertedPath2);
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error Moving Uploaded Files";
        }
    } else if (empty($website_logo) && empty($website_favicon)) {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "No Image File Uploaded";
    } else {
        if (move_uploaded_file($logo_tmp_name, $resource_folder1) && move_uploaded_file($favicon_tmp_name,  $resource_folder2)) {
            $imagePath2 = $resource_folder2;
            $imagePath1 = $resource_folder1;
            $convertedPath1 = convertPath($imagePath1);
            $convertedPath2 = convertPath($imagePath2);
            addLogo($imagePath1, $imagePath2);
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error Moving Uploaded Files";
        }
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../index.css" />
    <link id="themeStylesheet" rel="stylesheet" href="../admin.css" />
    <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="../admin.js" defer></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title><?php echo $translations['customise_frontend']; ?></title>
</head>

<body>
    <div class="logout_alert" id="logout_alert">
        <form class="newpost_container" method="POST" action=" " id="postForm" enctype="multipart/form-data">
            <a class="logout_alert_cancel" onclick="cancelExit()">
                <i class="fa fa-times popup_close1" aria-hidden="true"></i>
            </a>
            <div class="newpost_container_div1 newpost_subdiv">
                <h1 class="sectioneer_form_header"><?php echo $translations['add_resource']; ?></h1>
            </div>
            <div class="newpost_container_div3 newpost_subdiv">
                <label class="form__label" for="resource_type"><?php echo $translations['resource_type']; ?></label>
                <div class="newpost_container_div3_subdiv2">
                    <input class="form__input" name="resource_type" type="text" required />
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
                        <input class="form__input" name="resource_url" type="text" placeholder="<?php echo $translations['resource_url_p']; ?>..." />
                    </div>
                </div>
            </div>
            <div class="newpost_container_div9 newpost_subdiv">
                <input class="form__submit_input" type="submit" value="<?php echo $translations['save']; ?>" name="add_resource" />
            </div>
        </form>
    </div>
    <div class="logout_alert" id="logout_alert2">
        <form class="newpost_container" method="post" action="" id="postForm">
            <a class="logout_alert_cancel" onclick="cancelExit2()">
                <i class="fa fa-times popup_close1" aria-hidden="true"></i>
            </a>
            <div class="newpost_container_div1 newpost_subdiv">
                <h1 class="sectioneer_form_header"><?php echo $translations['add_page']; ?></h1>
            </div>
            <div class="newpost_container_div3 newpost_subdiv">
                <label class="form__label" for="page_name"><?php echo $translations['page_name']; ?></label>
                <div class="newpost_container_div3_subdiv2">
                    <input class="form__input" name="page_name" type="text" required />
                </div>
            </div>
            <div class="newpost_container_div9 newpost_subdiv">
                <input class="form__submit_input" type="submit" value="<?php echo $translations['save']; ?>" name="add_page" />
            </div>
        </form>
    </div>
    <?php require("../extras/header2.php"); ?>
    <section class="sectioneer">
        <div class="page_links">
            <a href="../admin_homepage.php"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['settings']; ?></p> > <p><?php echo $translations['edit_frontend_title']; ?></p>
        </div>
        <form class="frontend_div sectioneer_form" action="" method="POST" enctype="multipart/form-data">
            <div class="sectioneer_form_container">
                <?php
                $selectwebsite_logo = "SELECT id, logo_imagepath, favicon_imagepath FROM website_logo ORDER BY id DESC LIMIT 1";
                $selectwebsite_logo_result = $conn->query($selectwebsite_logo);
                if ($selectwebsite_logo_result->num_rows > 0) {
                    while ($row = $selectwebsite_logo_result->fetch_assoc()) {
                        $logo_image = $row['logo_imagepath'];
                        $favicon_image = $row['favicon_imagepath'];
                        $_SESSION['logo_id'] = $row['id'];
                        echo "  <div class='sectioneer_form_container_subdiv2'>
                                            <h1 class='sectioneer_form_header'>Edit Website Logo</h1>
                                            <div class='sectioneer_form_container_subdiv2_subdiv'>
                                                <img src='../../$logo_image' alt='Website Logo'>
                                                <a class='add_div' onclick='document.getElementById('fileInput').click();'>
                                                    <i class='fa fa-plus' aria-hidden='true'></i>
                                                    <p>Edit Logo</p>
                                                </a>
                                                <input type='file' id='fileInput' name='website_logo' style='display: none;'>
                                            </div>
                                        </div>
                                        <div class='sectioneer_form_container_subdiv2'>
                                            <h1 class='sectioneer_form_header'>Edit Favicon</h1>
                                            <div class='sectioneer_form_container_subdiv2_subdiv'>
                                                <img src='../../$favicon_image' alt='Favicon Image'>
                                                <a class='add_div' onclick='document.getElementById('fileInput2').click();'>
                                                    <i class='fa fa-plus' aria-hidden='true'></i>
                                                    <p>Edit Favicon</p>
                                                </a>
                                                <input type='file' id='fileInput2' name='website_favicon' style='display: none;'>
                                            </div>
                                        </div>
                                ";
                    }
                }
                ?>
            </div>
            <input class="btn" type="submit" value="<?php echo $translations['save']; ?>" name="change_logo" />
        </form>
        <form class="frontend_div sectioneer_form" action="" method="POST" enctype="multipart/form-data">
            <div class="sectioneer_form_container">
                <?php
                $website_messages_sql = "SELECT id, cookie_consent, website_vision FROM website_messages ORDER BY id DESC LIMIT 1";
                $website_messages_result = $conn->query($website_messages_sql);
                if ($website_messages_result->num_rows > 0) {
                    while ($row = $website_messages_result->fetch_assoc()) {
                        $cookie_message = $row['cookie_consent'];
                        $website_vision_message = $row['website_vision'];
                        $_SESSION['message_id'] = $row['id'];
                        echo "  <div class='sectioneer_form_container_subdiv2'>
                                    <h1 class='sectioneer_form_header'>$translations[edit_cookie]</h1>
                                    <textarea name='cookie_consent' id='myTextarea6c'>$cookie_message</textarea>
                                </div>
                                <div class='sectioneer_form_container_subdiv2'>
                                    <h1 class='sectioneer_form_header'>$translations[edit_webdescription]</h1>
                                    <textarea name='description' id='myTextarea6b'>$website_vision_message</textarea>
                                </div>
                                ";
                    }
                }
                ?>
            </div>
            <input class="btn" type="submit" value="<?php echo $translations['save']; ?>" name="change_frontend_messages" />
        </form>
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
                                    <p>$translations[add_resource]</p>
                                </a>
                            </div>";
            }
            ?>
        </div>
        <div class="frontend_div sectioneer_div">
            <h1 class="sectioneer_form_header"><?php echo $translations['pages']; ?></h1>
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
                            <p>$translations[add_page]</p>
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
    <script type="text/javascript" src="https://cdn.tiny.cloud/1/mshrla4r3p3tt6dmx5hu0qocnq1fowwxrzdjjuzh49djvu2p/tinymce/6/tinymce.min.js"></script>
</body>

</html>