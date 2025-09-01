<?php

/** @var \mysqli $conn */
global $conn;
session_start();
$id = $_SESSION['id'];
$userType = $_SESSION['user'];
$_SESSION['status_type'] = "";
$_SESSION['status'] = "";
require("../connect.php");
include('crudoperations.php');
require('../init.php');
$admin_base_url = "../admin/";
$editor_base_url = "../editor/";
function errorPath(){
    global $admin_base_url;
    global $editor_base_url;
    if ($_SESSION['user'] === 'Admin') {
        return $admin_base_url;
    } else return $editor_base_url;
}
function errorPath2()
{
    global $admin_base_url;
    global $editor_base_url;
    if ($_SESSION['user'] === 'admin') {
        return $admin_base_url;
    } else if ($_SESSION['user'] === 'editor') {
        return $editor_base_url;
    }
}
function addWebsiteMessages($cookie_message, $description)
{
    global $conn;
    global $admin_base_url;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $stmt = $conn->prepare("INSERT INTO website_messages ( cookie_consent, website_vision, Date, time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $cookie_message, $description, $date, $time);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " updated cookie consent message and website description";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "Cookie consent message and Website description updated successfully";
        header('location: ' . $admin_base_url . 'edit/frontend_features.php');
        exit();
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: ' . $admin_base_url . 'edit/frontend_features.php');
        exit();
    }
}
function addResourceFile($tableName, $convertedPath, $resource_niche, $resource_title, $resource_url, $userType)
{
    global $conn;
    global $admin_base_url;
    global $editor_base_url;
    $date = date('y-m-d');
    $time = date('H:i:s');
    if ($userType === 'Admin') {
        if (!empty($convertedPath) && empty($resource_url)) {
            $stmt = $conn->prepare("INSERT INTO $tableName (name, resource_path, date_added, time_added, niche, title) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $tableName, $convertedPath, $date, $time, $resource_niche, $resource_title);
            if ($stmt->execute()) {
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Resource File added successfully";
                $content = "Admin " . $_SESSION['firstname'] . " added a new Resource file in $tableName";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                header('location: ' . $admin_base_url . 'view_all/resources.php?resource_name=' . $tableName);
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $admin_base_url . 'edit/frontend_features.php');
                exit();
            }
        } else if (empty($convertedPath) && !empty($resource_url)) {
            $stmt = $conn->prepare("INSERT INTO $tableName (name, resource_path, date_added, time_added, niche, title) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $tableName, $resource_url, $date, $time, $resource_niche, $resource_title);
            if ($stmt->execute()) {
                $stmt = $conn->prepare("INSERT INTO resources (resource_name, Date, Time) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $tableName, $date, $time);
                if ($stmt->execute()) {
                    $_SESSION['status_type'] = "Success";
                    $_SESSION['status'] = "Resource File added successfully";
                    $content = "Admin " . $_SESSION['firstname'] . " added a new Resource file in $tableName";
                    $forUser = 0;
                    logUpdate($conn, $forUser, $content);
                    header('location: ' . $admin_base_url . 'view_all/resources.php?resource_name=' . $tableName);
                    exit();
                }
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $admin_base_url . 'edit/frontend_features.php');
                exit();
            }
        } else if (!empty($convertedPath) && !empty($resource_url)) {
            $stmt = $conn->prepare("INSERT INTO $tableName (name, resource_path, date_added, time_added, niche, title) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $tableName, $resource_url, $date, $time, $resource_niche, $resource_title);
            if ($stmt->execute()) {
                $stmt = $conn->prepare("INSERT INTO resources (resource_name, Date, Time) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $tableName, $date, $time);
                if ($stmt->execute()) {
                    $_SESSION['status_type'] = "Success";
                    $_SESSION['status'] = "Resource File added successfully";
                    $content = "Admin " . $_SESSION['firstname'] . " added a new Resource file in $tableName";
                    $forUser = 0;
                    logUpdate($conn, $forUser, $content);
                    header('location: ' . $admin_base_url . 'view_all/resources.php?resource_name=' . $tableName);
                    exit();
                }
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $admin_base_url . 'edit/frontend_features.php');
                exit();
            }
        }
    } else {
        if (!empty($convertedPath) && empty($resource_url)) {
            $stmt = $conn->prepare("INSERT INTO $tableName (name, resource_path, date_added, time_added, niche, title) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $tableName, $convertedPath, $date, $time, $resource_niche, $resource_title);
            if ($stmt->execute()) {
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Resource File added successfully";
                $content = "Editor " . $_SESSION['firstname'] . " added a new Resource file in $tableName";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                header('location: ' . $editor_base_url . 'view_all/resources.php?resource_name=' . $tableName);
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $editor_base_url . 'edit/frontend_features.php');
                exit();
            }
        } else if (empty($convertedPath) && !empty($resource_url)) {
            $stmt = $conn->prepare("INSERT INTO $tableName (name, resource_path, date_added, time_added, niche, title) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $tableName, $resource_url, $date, $time, $resource_niche, $resource_title);
            if ($stmt->execute()) {
                $stmt = $conn->prepare("INSERT INTO resources (resource_name, Date, Time) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $tableName, $date, $time);
                if ($stmt->execute()) {
                    $_SESSION['status_type'] = "Success";
                    $_SESSION['status'] = "Resource File added successfully";
                    $content = "Editor " . $_SESSION['firstname'] . " added a new Resource file in $tableName";
                    $forUser = 0;
                    logUpdate($conn, $forUser, $content);
                    header('location: ' . $editor_base_url . 'view_all/resources.php?resource_name=' . $tableName);
                    exit();
                }
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $editor_base_url . 'edit/frontend_features.php');
                exit();
            }
        } else if (!empty($convertedPath) && !empty($resource_url)) {
            $stmt = $conn->prepare("INSERT INTO $tableName (name, resource_path, date_added, time_added, niche, title) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $tableName, $resource_url, $date, $time, $resource_niche, $resource_title);
            if ($stmt->execute()) {
                $stmt = $conn->prepare("INSERT INTO resources (resource_name, Date, Time) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $tableName, $date, $time);
                if ($stmt->execute()) {
                    $_SESSION['status_type'] = "Success";
                    $_SESSION['status'] = "Resource File added successfully";
                    $content = "Editor " . $_SESSION['firstname'] . " added a new Resource file in $tableName";
                    $forUser = 0;
                    logUpdate($conn, $forUser, $content);
                    header('location: ' . $editor_base_url . 'view_all/resources.php?resource_name=' . $tableName);
                    exit();
                }
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $editor_base_url . 'edit/frontend_features.php');
                exit();
            }
        }
    }
}
function editResourceFile($tableName, $convertedPath, $resource_niche, $resource_title, $resource_name, $resource_type_id, $userType)
{
    global $conn;
    global $admin_base_url;
    global $editor_base_url;
    if ($userType === 'Admin') {
        $stmt = $conn->prepare("UPDATE $tableName SET name = ?, resource_path = ?, niche = ?, title = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $resource_name, $convertedPath, $resource_niche, $resource_title, $resource_type_id);
        if ($stmt->execute()) {
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Resource File edited successfully";
            $content = "Admin " . $_SESSION['firstname'] . " edited a Resource file in $tableName";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            header('location: ' . $admin_base_url . 'view_all/resources.php?resource_name=' . $tableName);
            exit();
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: ' . $admin_base_url . 'edit/frontend_features.php');
            exit();
        }
    }else{
        $stmt = $conn->prepare("UPDATE $tableName SET name = ?, resource_path = ?, niche = ?, title = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $resource_name, $convertedPath, $resource_niche, $resource_title, $resource_type_id);
        if ($stmt->execute()) {
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Resource File edited successfully";
            $content = "Editor " . $_SESSION['firstname'] . " edited a Resource file in $tableName";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            header('location: ' . $editor_base_url . 'view_all/resources.php?resource_name=' . $tableName);
            exit();
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: ' . $editor_base_url . 'edit/frontend_features.php');
            exit();
        }
    }
}
function addPage($page_name)
{
    global $conn;
    global $admin_base_url;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $meta_name = "viewport";
    $meta_content = "width=device-width,initial-scale=1.0";
    $formattedPageName = strtolower(str_replace(' ', '-', $page_name));
    $formattedPageName2 = strtolower(str_replace(' ', '_', $page_name));
    $filename = lowercaseNoSpace($page_name) . '.php';
    $uc_page_name = ucfirst($page_name);
    $fileContent = <<<PHP
        <?php
            session_start();
            require("../connect.php");
            require('../init.php');
            require("../helpers/components.php");
            \$page_name = "$formattedPageName";
            \$details = getFaviconAndLogo();
            \$details2 = cookieMessageAndVision();
            \$logo = \$details['logo'];
            \$favicon = \$details['favicon'];
            \$website_description = \$details2['website_vision'];
        ?>
        <!DOCTYPE html>
            <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <?php
                        if (isset(\$meta_titles[\$page_name])) {
                            \$meta_data = \$meta_titles[\$page_name];
                            for (\$i = 1; \$i <= 5; \$i++) {
                                \$meta_name = \$meta_data["meta_name{\$i}"];
                                \$meta_content = \$meta_data["meta_content{\$i}"];
                                if (!empty(\$meta_name) && !empty(\$meta_content)) {
                                    echo "<meta name='\$meta_name' content='\$meta_content' />";
                                }
                            }
                        }
                    ?>
                    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
                    <link rel="preconnect" href="https://fonts.googleapis.com">
                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
                    <link rel="stylesheet" href="../css/main.css" />
                    <link rel="icon" href="../<?php echo \$favicon; ?>" type="image/x-icon">
                    <script src="../javascript/main.js" defer></script>
                    <title>$uc_page_name</title>
                </head>
                <body>
                    <div class="body_container">
                        <div class="body_right">
                            <div class="sidebar_divs_container">
                                <div class="webinfo">
                                    <h1>Uniquecontentwriter</h1>
                                    <img src="<?php echo \$logo; ?>" alt="Blog's Coverphoto" />
                                    <p><?php echo \$website_description; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="body_left border-gradient-leftside--lightdark">
                            <div class="page_links">
                                <a href="../">Home</a> > <p>$uc_page_name</p>
                            </div>
                            <h3 class="bodyleft_main">$uc_page_name</h3>
                            <div class="sidebar_divs_container thickdiv">
                                <?php
                                    \$selectpage = "SELECT content FROM $formattedPageName2 ORDER BY id DESC LIMIT 1";
                                    \$selectpage_result = \$conn->query(\$selectpage);
                                    if (\$selectpage_result->num_rows > 0) {
                                        while (\$row = \$selectpage_result->fetch_assoc()) {
                                            \$content = \$row['content'];
                                            echo "<p>\$content</p>";
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                        require("../includes/header2b.php");
                        \$page_title = $uc_page_name;
                        \$table_name = $formattedPageName2;
                        renderPageFrontend(\$logo, \$website_description, \$page_title, \$table_name);
                        include("../includes/footer2.php");
                    ?>
                    <script>
                        const sidebar = document.getElementById('sidebar');
                        const menubtn = document.getElementById('searchicon');
                        const closeMenuBtn = document.querySelector('.sidebarbtn');
                        function onClickOutside(element) {
                            document.addEventListener('click', e => {
                                if (!element.contains(e.target)) {
                                    element.classList.add('hidden');
                                } else return;
                            });
                        };
                        function removeHiddenClass(e) {
                            e.stopPropagation();
                            sidebar.classList.remove('hidden');
                        };
                        onClickOutside(sidebar);
                        menubtn.addEventListener('click', removeHiddenClass);
                        closeMenuBtn.addEventListener('click', (e) => {
                            e.stopPropagation();
                            sidebar.classList.toggle('hidden');
                        });
                    </script>
                </body>
            </html>
    PHP;
    $fileContent2 = <<<PHP
        <?php
            session_start();
            require("../connect.php");
            require("../init.php");
            require("../../init.php");
            require_once('../../helpers/components.php');
            \$details = getFaviconAndLogo();
            \$logo = \$details['logo'];
            \$favicon = \$details['favicon'];
            \$translationFile = "../../translation_files/lang/{\$language}.php";
            if (file_exists(\$translationFile)) {
                include \$translationFile;
            } else {
                \$translations = [];
            }
            function updatePages(\$content, \$tablename)
            {
                global \$conn;
                \$date = date('y-m-d');
                \$time = date('H:i:s');
                \$string = str_replace('_', ' ', \$tablename);
                \$stmt = "INSERT INTO \$tablename (content, date, time) VALUES (?, ?, ?)";
                if (\$query = \$conn->prepare(\$stmt)) {
                    \$query->bind_param("sss", \$content, \$date, \$time);
                    if (\$query->execute()) {
                        \$content = "Admin " . \$_SESSION['firstname'] . " updated this website's '" . \$string . "'";
                        \$forUser = 0;
                        logUpdate(\$conn, \$forUser, \$content);
                        \$_SESSION['status_type'] = "Success";
                        \$_SESSION['status'] = "" . \$string . " Updated Successfully";
                        header('location: admin_homepage.php');
                    } else {
                        \$_SESSION['status_type'] = "Error";
                        \$_SESSION['status'] = "Error, Please retry";
                        header('location: admin_homepage.php');
                    }
                } else {
                    \$error = \$conn->errno . ' ' . \$conn->error;
                    echo \$error;
                    header('location: admin_homepage.php');
                }
            }
            if (isset(\$_POST['edit_aboutwebsite_btn'])) {
                \$content = \$_POST['$formattedPageName'];
                \$tablename = "$formattedPageName2";
                updatePages(\$content, \$tablename);
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
                <link rel="stylesheet" href="../../css/admin.css" />
                <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <link rel="icon" href="../../<?php echo \$favicon; ?>" type="image/x-icon">
                <title>$uc_page_name</title>
            </head>
            <body>
                <?php
                    \$table_name = $formattedPageName2;
                    \$textarea_name = $formattedPageName;
                    \$textareaId = 'myTextarea';
                    \$submitbtn_name = 'edit_aboutwebsite_btn';
                    \$usertype = \$_SESSION['user'] ?? 'Admin'; // Default to Admin if not set
                    renderPageViewAndEditForm(\$base_url, \$usertype, \$translations, \$table_name, \$textarea_name, \$textareaId, \$submitbtn_name, \$logo);
                ?>
                <script type="text/javascript" src="https://cdn.tiny.cloud/1/mshrla4r3p3tt6dmx5hu0qocnq1fowwxrzdjjuzh49djvu2p/tinymce/6/tinymce.min.js"></script>
                <script src="../javascript/admin.js"></script>
                <script>
                    var messageType = "<?= \$_SESSION['status_type'] ?? ' ' ?>";
                    var messageText = "<?= \$_SESSION['status'] ?? ' ' ?>";
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
                    <?php unset(\$_SESSION['status_type']); ?>
                    <?php unset(\$_SESSION['status']); ?>
                </script>
                <script>
                    const editAboutBtn = document.getElementById("Edit_about1");
                    const editTextEditor = document.getElementById("hidden_aboutdiv1");
                    editAction(editAboutBtn, editTextEditor);
                    tinymce.init({
                        selector: "#myTextarea",
                        resize: true,
                        setup: function(editor) {
                            editor.on("init", function() {
                                editor.editorContainer.style.width = "90%";
                                editor.editorContainer.style.height = "50vh";
                            });
                        },
                        plugins: [
                            "advlist",
                            "autolink",
                            "link",
                            "image",
                            "lists",
                            "charmap",
                            "preview",
                            "anchor",
                            "pagebreak",
                            "searchreplace",
                            "wordcount",
                            "visualblocks",
                            "visualchars",
                            "code",
                            "fullscreen",
                            "insertdatetime",
                            "media",
                            "table",
                            "emoticons",
                            "help",
                        ],
                        toolbar: "undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | " +
                            "bullist numlist outdent indent | link image | print preview media fullscreen | " +
                            "forecolor backcolor emoticons | help",
                        menu: {
                            favs: {
                                title: "My Favorites",
                                items: "code visualaid | searchreplace | emoticons",
                            },
                        },
                        menubar: "favs file edit view insert format tools table help",
                        content_css: "css/content.css",
                    });
                    window.addEventListener("resize", function() {
                        if (tinymce.activeEditor) {
                            let newWidth = window.innerWidth * 0.8;
                            let newHeight = window.innerHeight * 0.7;
                            tinymce.activeEditor.editorContainer.style.width = newWidth + "px";
                            tinymce.activeEditor.editorContainer.style.height = newHeight + "px";
                        }
                    });
                </script>
                <script src="sweetalert2.all.min.js"></script>
            </body>
        </html>
    PHP;
    $fileContent3 = <<<PHP
       <?php
            session_start();
            require("../connect.php");
            require("../init.php");
            require('../../init.php');
            require_once('../../helpers/components.php');
            \$details = getFaviconAndLogo();
            \$logo = \$details['logo'];
            \$favicon = \$details['favicon'];
            \$translationFile = "../../translation_files/lang/{\$language}.php";
            if (file_exists(\$translationFile)) {
                include \$translationFile;
            } else {
                \$translations = [];
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
                    <link rel="stylesheet" href="../../css/editor.css" />
                    <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                    <link rel="icon" href="../../<?php echo \$favicon; ?>" type="image/x-icon">
                    <title>$uc_page_name</title>
                </head>
                <body>
                    <?php
                        \$table_name = $formattedPageName2;
                        \$textarea_name = $formattedPageName;
                        \$textareaId = null;
                        \$submitbtn_name = null;
                        \$usertype = \$_SESSION['user'] ?? 'Editor'; // Default to Admin if not set
                        renderPageViewAndEditForm(\$editor_base_url, \$usertype, \$translations, \$table_name, \$textarea_name, \$textareaId, \$submitbtn_name, \$logo);
                    ?>
                    <script src="../../javascript/editor.js"></script>
                </body>
            </html>
    PHP;
    $filePath = '../pages/' . $filename;
    $filePath2 = '../admin/pages/' . $filename;
    $filePath3 = '../editor/pages/' . $filename;
    $sql = "CREATE TABLE IF NOT EXISTS $formattedPageName2 (id INT AUTO_INCREMENT PRIMARY KEY, content TEXT NOT NULL, date DATE NOT NULL, time TIME NOT NULL)";
    if ($conn->query($sql) === TRUE) {
        $sqlPages = "INSERT INTO pages (page_name, Date, time) VALUES (?,?,?)";
        if ($query = $conn->prepare($sqlPages)) {
            $query->bind_param("sss", $formattedPageName, $date, $time);
            if ($query->execute()) {
                $sqlMetaTitles = "INSERT INTO meta_titles (page_name, meta_name1, meta_content1) VALUES (?, ?, ?)";
                if ($query = $conn->prepare($sqlMetaTitles)) {
                    $query->bind_param("sss", $formattedPageName, $meta_name, $meta_content);
                    if ($query->execute()) {
                        if (file_put_contents($filePath, $fileContent)) {
                            if (file_put_contents($filePath2, $fileContent2)) {
                                if (file_put_contents($filePath3, $fileContent3)) {
                                    $createTranslationInstance = updateTranslations($uc_page_name);
                                    if (!empty($createTranslationInstance)) {
                                        $_SESSION['status_type'] = $createTranslationInstance[0]['status_type'];
                                        $_SESSION['status'] = $createTranslationInstance[0]['status'];
                                    }
                                    $content = "Admin " . $_SESSION['firstname'] . " created a new page type";
                                    $forUser = 0;
                                    logUpdate($conn, $forUser, $content);
                                    header('location: ' . $admin_base_url . 'admin_homepage.php');
                                    exit();
                                } else {
                                    $_SESSION['status_type'] = "Error";
                                    $_SESSION['status'] = "Error, Could not create page in editor folder";
                                    header('location: ' . $admin_base_url . 'admin_homepage.php');
                                    exit();
                                }
                            } else {
                                $_SESSION['status_type'] = "Error";
                                $_SESSION['status'] = "Error, Could not create page in admin folder";
                                header('location: ' . $admin_base_url . 'admin_homepage.php');
                                exit();
                            }
                        } else {
                            $_SESSION['status_type'] = "Error";
                            $_SESSION['status'] = "Error, Could not create file at root pages folder";
                            header('location: ' . $admin_base_url . 'admin_homepage.php');
                            exit();
                        }
                    }else {
                        $_SESSION['status_type'] = "Error";
                        $_SESSION['status'] = "Error, Could not create Page meta titles";
                        header('location: ' . $admin_base_url . 'admin_homepage.php');
                        exit();
                    }
                }else {
                    $_SESSION['status_type'] = "Error";
                    $_SESSION['status'] = "Error, Please retry";
                    header('location: ' . $admin_base_url . 'admin_homepage.php');
                    exit();
                }
            }else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            }
        }else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: ' . $admin_base_url . 'admin_homepage.php');
            exit();
        }
    }else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, page already exists";
        header('location: ' . $admin_base_url . 'admin_homepage.php');
        exit();
    }
}
function updatePages($content, $tablename)
{
    global $conn;
    global $admin_base_url;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $string = str_replace('_', ' ', $tablename);
    $stmt = "INSERT INTO $tablename (content, date, time) VALUES (?, ?, ?)";
    if ($query = $conn->prepare($stmt)) {
        $query->bind_param("sss", $content, $date, $time);
        if ($query->execute()) {
            $content = "Admin " . $_SESSION['firstname'] . " updated this website's '" . $string . "'";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "" . $string . " Updated Successfully";
            header('location: ' . $admin_base_url . 'admin_homepage.php');
            exit();
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: ' . $admin_base_url . 'admin_homepage.php');
            exit();
        }
    } else {
        $error = $conn->errno . ' ' . $conn->error;
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = $error;
        header('location: ' . $admin_base_url . 'admin_homepage.php');
        exit();
    }
}
function updateEditorProfile($firstname, $lastname, $email, $username, $bio, $address1, $address2, $city, $state, $country, $countrycode, $mobile, $imagePath, $id)
{
    global $conn;
    global $admin_base_url;
    if ($imagePath !== null) {
        $stmt = $conn->prepare("UPDATE editor SET firstname = ?, lastname = ?, username = ?, email = ?, image = ?, bio = ?, mobile = ?, country = ?, 	city = ?, state = ?, address1 = ?, address2 = ?, country_code = ? WHERE id = ?");
        $stmt->bind_param("sssssssssssssi", $firstname, $lastname, $username, $email, $imagePath, $bio, $mobile, $country, $city, $state, $address1, $address2, $countrycode, $id);
        if ($stmt->execute()) {
            $content = "Admin " . $_SESSION['firstname'] . " updated $username's profile";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Profile Updated Successfully";
            header('location: ' . $admin_base_url . 'admin_homepage.php');
            exit();
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: ' . $admin_base_url . 'admin_homepage.php');
            exit();
        }
    } else {
        $stmt = $conn->prepare("UPDATE editor SET firstname = ?, lastname = ?, username = ?, email = ?, bio = ?, mobile = ?, country = ?, 	city = ?, state = ?, address1 = ?, address2 = ?, country_code = ? WHERE id = ?");
        $stmt->bind_param("ssssssssssssi", $firstname, $lastname, $username, $email, $bio, $mobile, $country, $city, $state, $address1, $address2, $countrycode, $id);
        if ($stmt->execute()) {
            $content = "Admin " . $_SESSION['firstname'] . " updated $username's profile";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Profile Updated Successfully";
            header('location: ' . $admin_base_url . 'admin_homepage.php');
            exit();
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: ' . $admin_base_url . 'admin_homepage.php');
            exit();
        }
    }
}
function addEditor($firstname, $lastname, $email, $img, $password, $id)
{
    global $conn;
    global $admin_base_url;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $idtype = "Editor";
    $encrypted_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO editor (id, email, image, password, firstname, lastname, date_joined, time_joined, idtype) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssss", $id, $email, $img, $encrypted_password, $firstname, $lastname, $date, $time, $idtype);
    if ($stmt->execute()) {
        $content = "Admin " . $_SESSION['firstname'] . " created a new user (Editor)";
        $forUser = 0;
        logUpdate($conn, $forUser, $content);
        $_SESSION['status_type'] = "Success";
        $_SESSION['status'] = "User Created Successfully";
        header('location: ' . $admin_base_url . 'create_new/editor.php');
        exit();
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        header('location: ' . $admin_base_url . 'create_new/editor.php');
        exit();
    }
}
function addResources($tableName, $convertedPath, $resource_type, $resource_niche, $resource_title, $resource_url, $userType)
{
    global $conn;
    global $admin_base_url;
    global $editor_base_url;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $uc_page_name = ucwords($tableName);
    $filename = lowercaseNoSpace($tableName) . '.php';
    $filePath = '../pages/' . $filename;
    if($userType === 'Admin'){
        $fileContent = <<<PHP
            <?php
                session_start();
                require('../connect.php');
                require('../init.php');
                \$page_name = "$tableName";
                \$_SESSION['status_type'] = "";
                \$_SESSION['status'] = "";
                \$details = getFaviconAndLogo();
                \$logo = \$details['logo'];
                \$favicon = \$details['favicon'];
                function containsFilesPath(\$string)
                {
                    return strpos(\$string, 'files/') !== false;
                }
                if (isset(\$_POST['submit_btn'])) {
                    \$email = \$_POST["email"];
                    \$sendEmail = sendEmail(\$email);
                    \$_SESSION['status_type'] = \$sendEmail['status_type'];
                    \$_SESSION['status'] = \$sendEmail['status'];
                }
                if (isset(\$_POST['subscribe_btn2'])) {
                    \$email = \$_POST["email"];
                    \$sendEmail = sendEmail(\$email);
                    \$_SESSION['status_type'] = \$sendEmail['status_type'];
                    \$_SESSION['status'] = \$sendEmail['status'];
                }
                if (isset(\$_GET['query'])) {
                    \$query = trim(\$_GET['query']);
                    if (\$query !== "") {
                        \$stmt = \$conn->prepare("SELECT * FROM $tableName WHERE title LIKE ?");
                        \$searchTerm = "%" . \$query . "%";
                        \$stmt->bind_param("s", \$searchTerm);
                        if (\$stmt->execute()) {
                            \$result = \$stmt->get_result();
                            if (\$result->num_rows > 0) {
                            while (\$row = \$result->fetch_assoc()) {
                                \$title = htmlspecialchars(\$row['title']);
                                \$max_length = 50;
                                \$niche = htmlspecialchars(\$row['niche']);
                                \$formattedDate = date("F j, Y", strtotime(\$row['date_added']));
                                \$resourcePath = htmlspecialchars(\$row['resource_path']);
                                if (strlen(\$title) > \$max_length) {
                                    \$title = substr(\$title, 0, \$max_length) . '...';
                                }
                                if (containsFilesPath(\$resourcePath)) {
                                    \$resourcePath = '../' . \$resourcePath;
                                }
                                echo " <a class='more_posts_subdiv'>";
                                echo "<img src='../images/resurces_img.png' alt='Whitepaper Image'/>";
                                echo "  <div class='more_posts_subdiv_subdiv'>
                                            <h1>\$title</h1>
                                            <span>\$formattedDate</span>
                                        </div>";
                                echo "  <div class='view_whitepaper'>
                                            <div class='posts_btn' onclick=\"window.location.href='\$resourcePath'\" target='_blank'>
                                                <i class='fa fa-eye' aria-hidden='true'></i>
                                            </div>
                                        </div>
                                    ";
                                echo "<p class='posts_div_niche'>\$niche</p>";
                                echo "</a>";
                            }
                        } else {
                            echo "<h1 class='bodyleft_header3'>No results found for ' \$query '</h1>";
                        }
                    }
                }
                exit;
                }
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <?php
                    if (isset(\$meta_titles[\$page_name])) {
                        \$meta_data = \$meta_titles[\$page_name];
                        for (\$i = 1; \$i <= 5; \$i++) {
                            \$meta_name = \$meta_data["meta_name{\$i}"];
                            \$meta_content = \$meta_data["meta_content{\$i}"];
                            if (!empty(\$meta_name) && !empty(\$meta_content)) {
                                echo "<meta name='\$meta_name' content='\$meta_content' />";
                            }
                        }
                    }
                ?>
                <meta http-equiv="X-UA-Compatible" content="ie=edge" />
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
                <link rel="stylesheet" href="../css/main.css" />
                <script src="../javascript/main.js" defer></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <link rel="icon" href="../<?php echo \$favicon; ?>" type="image/x-icon">
                <title>$uc_page_name</title>
            </head>
            <body id="container">
                <?php require("../includes/header2.php"); ?>
                <div class="body_container">
                    <div class="body_left">
                        <div class="page_links">
                            <a href="../">Home</a> > <p>Resources ($uc_page_name)</p>
                        </div>
                        <h1 class='bodyleft_header3'>Search $uc_page_name</h1>
                        <form class="header_searchbar2 search_input" id="search_form" action="$filename" method="get">
                            <input type="text" name="query" id="search-bar" placeholder="Search.." />
                            <button class="fa fa-search" type="submit" onclick="submitSearch()"></button>
                        </form>
                        <div id="search-results">
                            <div id="results-container" class="more_posts"></div>
                        </div>
                        <div class='more_posts'>
                            <?php
                                \$sql = "SELECT name, resource_path, niche, title, date_added FROM $tableName ORDER BY id DESC";
                                \$result = \$conn->query(\$sql);
                                if (\$result->num_rows > 0) {
                                    while (\$row = \$result->fetch_assoc()) {
                                        \$title = \$row["title"];
                                        \$max_length = 50;
                                        \$niche = \$row["niche"];
                                        \$date = \$row["date_added"];
                                        \$path = \$row["resource_path"];
                                        \$dateTime = new DateTime(\$date);
                                        \$day = \$dateTime->format('j');
                                        \$month = \$dateTime->format('M');
                                        \$year = \$dateTime->format('Y');
                                        \$ordinalSuffix = getOrdinalSuffix(\$day);
                                        \$formattedDate = \$month . ' ' . \$day . \$ordinalSuffix . ', ' . \$year;
                                        if (strlen(\$title) > \$max_length) {
                                            \$title = substr(\$title, 0, \$max_length) . '...';
                                        }
                                        if (containsFilesPath(\$path)) {
                                            \$path = '../' . \$path;
                                        }
                                        echo "  <a class='more_posts_subdiv'>
                                                    <img src='../images/resurces_img.png' alt='Resource Image' />
                                                    <div class='more_posts_subdiv_subdiv'>
                                                        <h1>\$title</h1>
                                                        <span>\$formattedDate</span>
                                                    </div>
                                                    <div class='view_whitepaper'>
                                                        <div class='posts_btn' onclick=\"window.location.href='\$path'\" target='_blank'>
                                                            <i class='fa fa-eye' aria-hidden='true'></i>
                                                        </div>
                                                    </div>
                                                    <p class='posts_div_niche'>\$niche</p>
                                        </a>";
                                    }
                                } else {
                                    echo "<p>No $uc_page_name Uploaded Yet.</p>";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="body_right border-gradient-leftside--lightdark">
                        <div class="subscribe_container">
                            <form class="sec2__susbribe-box other_width" method="POST" action="" id="susbribe-box">
                                <div class="icon">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                </div>
                                <h1 class="sec2__susbribe-box-header">Subscribe to Updates</h1>
                                <p class="sec2__susbribe-box-p1">Get the latest Updates and Info from Uniquetechcontentwriter on $uc_page_name, Artificial Intelligence and lots more.</p>
                                <input class="sec2__susbribe-box_input" type="text" placeholder="Your Email Address..." name="email" required />
                                <input class="sec2__susbribe-box_btn" type="submit" value="Submit" name="submit_btn" />
                            </form>
                            <div id="thank-you-message"></div>
                        </div>
                        <h3 class="bodyleft_header3 border-gradient-bottom--lightdark">Editor's Picks</h3>
                        <?php include("../helpers/editorspicks.php"); ?>
                    </div>
                </div>
                <?php include("../includes/footer2.php"); ?>
                <script src="sweetalert2.all.min.js"></script>
                <script>
                    const closeMenuBtn = document.querySelector('.sidebarbtn');
                    const sidebar = document.getElementById('sidebar');
                    const menubtn = document.querySelector('.mainheader__header-nav-2');
                    var messageType = "<?= \$_SESSION['status_type'] ?? ' ' ?>";
                    var messageText = "<?= \$_SESSION['status'] ?? ' ' ?>";
                    function removeHiddenClass(e) {
                        e.stopPropagation();
                        sidebar.classList.remove('hidden');
                    };
                    function onClickOutside(element) {
                        document.addEventListener('click', e => {
                            if (!element.contains(e.target)) {
                                element.classList.add('hidden');
                            } else return;
                        });
                    };
                    onClickOutside(sidebar);
                    menubtn.addEventListener('click', removeHiddenClass);
                    closeMenuBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        sidebar.classList.toggle('hidden');
                    });
                    function submitSearch() {
                        var query = document.getElementById("search-bar").value;
                        if (query.trim() !== "") {
                            fetch("$filename?query=" + encodeURIComponent(query))
                                .then(response => response.text())
                                .then(data => {
                                    document.getElementById("results-container").innerHTML = data;
                                })
                                .catch(error => console.error("Error fetching results:", error));
                        } else {
                            document.getElementById("search-results").style.display = "none";
                        }
                    }
                </script>
                <script>
                    if (messageType == 'Error' && messageText != " ") {
                        Swal.fire({
                            title: 'Error!',
                            text: messageText,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        })
                    } else if (messageType == 'Info' && messageText != " ") {
                        Swal.fire({
                            title: 'Info!',
                            text: messageText,
                            showConfirmButton: true,
                            confirmButtonText: 'Ok',
                            icon: 'info'
                        })
                    } else if (messageType == 'Success' && messageText != " ") {
                        Swal.fire({
                            title: 'Success',
                            text: messageText,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        })
                    }
                    <?php unset(\$_SESSION['status_type']); ?>
                    <?php unset(\$_SESSION['status']); ?>
                </script>
            </body>
            </html>
        PHP;
        if (file_put_contents($filePath, $fileContent)) {
            if (!empty($convertedPath) && empty($resource_url)) {
                $stmt = $conn->prepare("INSERT INTO $tableName (name, resource_path, date_added, time_added, niche, title) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $tableName, $convertedPath, $date, $time, $resource_niche, $resource_title);
                if ($stmt->execute()) {
                    $stmt = $conn->prepare("INSERT INTO resources (resource_name, Date, Time) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $resource_type, $date, $time);
                    if ($stmt->execute()) {
                        $_SESSION['status_type'] = "Success";
                        $_SESSION['status'] = "Resource type added successfully";
                        $content = "Admin " . $_SESSION['firstname'] . " added a new Resource type";
                        $forUser = 0;
                        logUpdate($conn, $forUser, $content);
                        header('location: ' . $admin_base_url . 'edit/frontend_features.php');
                        exit;
                    }
                } else {
                    $_SESSION['status_type'] = "Error";
                    $_SESSION['status'] = "Error, Please retry";
                    header('location: ' . $admin_base_url . 'edit/frontend_features.php');
                    exit;
                }
            } else if (empty($convertedPath) && !empty($resource_url)) {
                $stmt = $conn->prepare("INSERT INTO $tableName (name, resource_path, date_added, time_added, niche, title) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $tableName, $resource_url, $date, $time, $resource_niche, $resource_title);
                if ($stmt->execute()) {
                    $stmt = $conn->prepare("INSERT INTO resources (resource_name, Date, Time) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $resource_type, $date, $time);
                    if ($stmt->execute()) {
                        $_SESSION['status_type'] = "Success";
                        $_SESSION['status'] = "Resource type added successfully";
                        $content = "Admin " . $_SESSION['firstname'] . " added a new Resource type";
                        $forUser = 0;
                        logUpdate($conn, $forUser, $content);
                        header('location: ' . $admin_base_url . 'edit/frontend_features.php');
                        exit;
                    }
                } else {
                    $_SESSION['status_type'] = "Error";
                    $_SESSION['status'] = "Error, Please retry";
                    header('location: ' . $admin_base_url . 'edit/frontend_features.php');
                    exit;
                }
            } else if (!empty($convertedPath) && !empty($resource_url)) {
                $stmt = $conn->prepare("INSERT INTO $tableName (name, resource_path, date_added, time_added, niche, title) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $tableName, $resource_url, $date, $time, $resource_niche, $resource_title);
                if ($stmt->execute()) {
                    $stmt = $conn->prepare("INSERT INTO resources (resource_name, Date, Time) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $resource_type, $date, $time);
                    if ($stmt->execute()) {
                        $_SESSION['status_type'] = "Success";
                        $_SESSION['status'] = "Resource type added successfully";
                        $content = "Admin " . $_SESSION['firstname'] . " added a new Resource type";
                        $forUser = 0;
                        logUpdate($conn, $forUser, $content);
                        header('location: ' . $admin_base_url . 'edit/frontend_features.php');
                        exit;
                    }
                } else {
                    $_SESSION['status_type'] = "Error";
                    $_SESSION['status'] = "Error, Please retry";
                    header('location: ' . $admin_base_url . 'edit/frontend_features.php');
                    exit;
                }
            }
        }
    }else if ($userType === 'Editor'){
        $fileContent = <<<PHP
            <?php
                session_start();
                require('../connect.php');
                require('../init.php');
                \$page_name = "$tableName";
                \$_SESSION['status_type'] = "";
                \$_SESSION['status'] = "";
                \$details = getFaviconAndLogo();
                \$logo = \$details['logo'];
                \$favicon = \$details['favicon'];
                function containsFilesPath(\$string)
                {
                    return strpos(\$string, 'files/') !== false;
                }
                if (isset(\$_POST['submit_btn'])) {
                    \$email = \$_POST["email"];
                    \$sendEmail = sendEmail(\$email);
                    \$_SESSION['status_type'] = \$sendEmail['status_type'];
                    \$_SESSION['status'] = \$sendEmail['status'];
                }
                if (isset(\$_POST['subscribe_btn2'])) {
                    \$email = \$_POST["email"];
                    \$sendEmail = sendEmail(\$email);
                    \$_SESSION['status_type'] = \$sendEmail['status_type'];
                    \$_SESSION['status'] = \$sendEmail['status'];
                }
                if (isset(\$_GET['query'])) {
                    \$query = trim(\$_GET['query']);
                    if (\$query !== "") {
                        \$stmt = \$conn->prepare("SELECT * FROM $tableName WHERE title LIKE ?");
                        \$searchTerm = "%" . \$query . "%";
                        \$stmt->bind_param("s", \$searchTerm);
                        if (\$stmt->execute()) {
                            \$result = \$stmt->get_result();
                            if (\$result->num_rows > 0) {
                                while (\$row = \$result->fetch_assoc()) {
                                    \$title = htmlspecialchars(\$row['title']);
                                    \$max_length = 50;
                                    \$niche = htmlspecialchars(\$row['niche']);
                                    \$formattedDate = date("F j, Y", strtotime(\$row['date_added']));
                                    \$resourcePath = htmlspecialchars(\$row['resource_path']);
                                    if (strlen(\$title) > \$max_length) {
                                        \$title = substr(\$title, 0, \$max_length) . '...';
                                    }
                                    if (containsFilesPath(\$resourcePath)) {
                                        \$resourcePath = '../' . \$resourcePath;
                                    }
                                    echo " <a class='more_posts_subdiv'>";
                                    echo "<img src='../images/resurces_img.png' alt='Whitepaper Image'/>";
                                    echo "  <div class='more_posts_subdiv_subdiv'>
                                                <h1>\$title</h1>
                                                <span>\$formattedDate</span>
                                    </div>";
                                    echo "  <div class='view_whitepaper'>
                                            <div class='posts_btn' onclick=\"window.location.href='\$resourcePath'\" target='_blank'>
                                                <i class='fa fa-eye' aria-hidden='true'></i>
                                            </div>
                                        </div>
                                    ";
                                    echo "<p class='posts_div_niche'>\$niche</p>";
                                    echo "</a>";
                                }
                            } else {
                                echo "<h1 class='bodyleft_header3'>No results found for ' \$query '</h1>";
                            }
                        }
                    }
                    exit;
                }
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <?php
                    if (isset(\$meta_titles[\$page_name])) {
                        \$meta_data = \$meta_titles[\$page_name];
                        for (\$i = 1; \$i <= 5; \$i++) {
                            \$meta_name = \$meta_data["meta_name{\$i}"];
                            \$meta_content = \$meta_data["meta_content{\$i}"];
                            if (!empty(\$meta_name) && !empty(\$meta_content)) {
                                echo "<meta name='\$meta_name' content='\$meta_content' />";
                            }
                        }
                    }
                ?>
                <meta http-equiv="X-UA-Compatible" content="ie=edge" />
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
                <link rel="stylesheet" href="../css/main.css" />
                <script src="../javascript/main.js" defer></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <link rel="icon" href="../<?php echo \$favicon; ?>" type="image/x-icon">
                <title>$uc_page_name</title>
            </head>
            <body id="container">
                <?php require("../includes/header2.php"); ?>
                <div class="body_container">
                    <div class="body_left">
                        <div class="page_links">
                            <a href="../">Home</a> > <p>Resources ($uc_page_name)</p>
                        </div>
                        <h1 class='bodyleft_header3'>Search $uc_page_name</h1>
                        <form class="header_searchbar2 search_input" id="search_form" action="$filename" method="get">
                            <input type="text" name="query" id="search-bar" placeholder="Search.." />
                            <button class="fa fa-search" type="submit" onclick="submitSearch()"></button>
                        </form>
                        <div id="search-results">
                            <div id="results-container" class="more_posts"></div>
                        </div>
                        <div class='more_posts'>
                            <?php
                                \$sql = "SELECT name, resource_path, niche, title, date_added FROM $tableName ORDER BY id DESC";
                                \$result = \$conn->query(\$sql);
                                if (\$result->num_rows > 0) {
                                    while (\$row = \$result->fetch_assoc()) {
                                        \$title = \$row["title"];
                                        \$max_length = 50;
                                        \$niche = \$row["niche"];
                                        \$date = \$row["date_added"];
                                        \$path = \$row["resource_path"];
                                        \$dateTime = new DateTime(\$date);
                                        \$day = \$dateTime->format('j');
                                        \$month = \$dateTime->format('M');
                                        \$year = \$dateTime->format('Y');
                                        \$ordinalSuffix = getOrdinalSuffix(\$day);
                                        \$formattedDate = \$month . ' ' . \$day . \$ordinalSuffix . ', ' . \$year;
                                        if (strlen(\$title) > \$max_length) {
                                           \$title = substr(\$title, 0, \$max_length) . '...';
                                        }
                                        if (containsFilesPath(\$path)) {
                                            \$path = '../' . \$path;
                                        }
                                        echo "  <a class='more_posts_subdiv'>
                                                    <img src='../images/resurces_img.png' alt='Resource Image' />
                                                    <div class='more_posts_subdiv_subdiv'>
                                                        <h1>\$title</h1>
                                                        <span>\$formattedDate</span>
                                                    </div>
                                                    <div class='view_whitepaper'>
                                                        <div class='posts_btn' onclick=\"window.location.href='\$path'\" target='_blank'>
                                                            <i class='fa fa-eye' aria-hidden='true'></i>
                                                        </div>
                                                    </div>
                                                    <p class='posts_div_niche'>\$niche</p>
                                        </a>";
                                    }
                                } else {
                                    echo "<p>No $uc_page_name Uploaded Yet.</p>";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="body_right border-gradient-leftside--lightdark">
                        <div class="subscribe_container">
                            <form class="sec2__susbribe-box other_width" method="POST" action="" id="susbribe-box">
                                <div class="icon">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                </div>
                                <h1 class="sec2__susbribe-box-header">Subscribe to Updates</h1>
                                <p class="sec2__susbribe-box-p1">Get the latest Updates and Info from Uniquetechcontentwriter on $uc_page_name, Artificial Intelligence and lots more.</p>
                                <input class="sec2__susbribe-box_input" type="text" placeholder="Your Email Address..." name="email" required />
                                <input class="sec2__susbribe-box_btn" type="submit" value="Submit" name="submit_btn" />
                            </form>
                            <div id="thank-you-message"></div>
                        </div>
                        <h3 class="bodyleft_header3 border-gradient-bottom--lightdark">Editor's Picks</h3>
                        <?php include("../helpers/editorspicks.php"); ?>
                    </div>
                </div>
                <?php include("../includes/footer2.php"); ?>
                <script src="sweetalert2.all.min.js"></script>
                <script>
                    const closeMenuBtn = document.querySelector('.sidebarbtn');
                    const sidebar = document.getElementById('sidebar');
                    const menubtn = document.querySelector('.mainheader__header-nav-2');
                    var messageType = "<?= \$_SESSION['status_type'] ?? ' ' ?>";
                    var messageText = "<?= \$_SESSION['status'] ?? ' ' ?>";
                    function removeHiddenClass(e) {
                        e.stopPropagation();
                        sidebar.classList.remove('hidden');
                    };
                    function onClickOutside(element) {
                        document.addEventListener('click', e => {
                            if (!element.contains(e.target)) {
                                element.classList.add('hidden');
                            } else return;
                        });
                    };
                    onClickOutside(sidebar);
                    menubtn.addEventListener('click', removeHiddenClass);
                    closeMenuBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        sidebar.classList.toggle('hidden');
                    });
                    function submitSearch() {
                        var query = document.getElementById("search-bar").value;
                        if (query.trim() !== "") {
                            fetch("$filename?query=" + encodeURIComponent(query))
                                .then(response => response.text())
                                .then(data => {
                                    document.getElementById("results-container").innerHTML = data;
                                })
                                .catch(error => console.error("Error fetching results:", error));
                        } else {
                            document.getElementById("search-results").style.display = "none";
                        }
                    }
                </script>
                <script>
                    if (messageType == 'Error' && messageText != " ") {
                        Swal.fire({
                            title: 'Error!',
                            text: messageText,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        })
                    } else if (messageType == 'Info' && messageText != " ") {
                        Swal.fire({
                            title: 'Info!',
                            text: messageText,
                            showConfirmButton: true,
                            confirmButtonText: 'Ok',
                            icon: 'info'
                        })
                    } else if (messageType == 'Success' && messageText != " ") {
                        Swal.fire({
                            title: 'Success',
                            text: messageText,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        })
                    }
                    <?php unset(\$_SESSION['status_type']); ?>
                    <?php unset(\$_SESSION['status']); ?>
                </script>
            </body>
            </html>
        PHP;
        if (file_put_contents($filePath, $fileContent)) {
            if (!empty($convertedPath) && empty($resource_url)) {
                $stmt = $conn->prepare("INSERT INTO $tableName (name, resource_path, date_added, time_added, niche, title) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $tableName, $convertedPath, $date, $time, $resource_niche, $resource_title);
                if ($stmt->execute()) {
                    $stmt = $conn->prepare("INSERT INTO resources (resource_name, Date, Time) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $resource_type, $date, $time);
                    if ($stmt->execute()) {
                        $_SESSION['status_type'] = "Success";
                        $_SESSION['status'] = "Resource type added successfully";
                        $content = "Editor " . $_SESSION['firstname'] . " added a new Resource type";
                        $forUser = 0;
                        logUpdate($conn, $forUser, $content);
                        header('location: ' . $editor_base_url . 'edit/frontend_features.php');
                        exit;
                    }
                } else {
                    $_SESSION['status_type'] = "Error";
                    $_SESSION['status'] = "Error, Please retry";
                    header('location: ' . $editor_base_url . 'edit/frontend_features.php');
                    exit;
                }
            } else if (empty($convertedPath) && !empty($resource_url)) {
                $stmt = $conn->prepare("INSERT INTO $tableName (name, resource_path, date_added, time_added, niche, title) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $tableName, $resource_url, $date, $time, $resource_niche, $resource_title);
                if ($stmt->execute()) {
                    $stmt = $conn->prepare("INSERT INTO resources (resource_name, Date, Time) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $resource_type, $date, $time);
                    if ($stmt->execute()) {
                        $_SESSION['status_type'] = "Success";
                        $_SESSION['status'] = "Resource type added successfully";
                        $content = "Editor " . $_SESSION['firstname'] . " added a new Resource type";
                        $forUser = 0;
                        logUpdate($conn, $forUser, $content);
                        header('location: ' . $editor_base_url . 'edit/frontend_features.php');
                        exit;
                    }
                } else {
                    $_SESSION['status_type'] = "Error";
                    $_SESSION['status'] = "Error, Please retry";
                    header('location: ' . $editor_base_url . 'edit/frontend_features.php');
                    exit;
                }
            } else if (!empty($convertedPath) && !empty($resource_url)) {
                $stmt = $conn->prepare("INSERT INTO $tableName (name, resource_path, date_added, time_added, niche, title) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $tableName, $resource_url, $date, $time, $resource_niche, $resource_title);
                if ($stmt->execute()) {
                    $stmt = $conn->prepare("INSERT INTO resources (resource_name, Date, Time) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $resource_type, $date, $time);
                    if ($stmt->execute()) {
                        $_SESSION['status_type'] = "Success";
                        $_SESSION['status'] = "Resource type added successfully";
                        $content = "Editor " . $_SESSION['firstname'] . " added a new Resource type";
                        $forUser = 0;
                        logUpdate($conn, $forUser, $content);
                        header('location: ' . $editor_base_url . 'edit/frontend_features.php');
                        exit;
                    }
                } else {
                    $_SESSION['status_type'] = "Error";
                    $_SESSION['status'] = "Error, Please retry";
                    header('location: edit/frontend_features.php');
                }
            }
        }
    }
}
function savePost1($title, $subtitle, $convertedPath, $content, $niche, $link, $schedule, $id, $author_firstname, $author_lastname, $author_bio, $post_type, $userType)
{
    global $conn;
    global $admin_base_url;
    global $editor_base_url;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $is_favourite = 'False';
    if ($post_type === "paid_posts") {
        $idtype = "id1";
    } elseif ($post_type === "posts") {
        $idtype = "id2";
    } elseif ($post_type === "news") {
        $idtype = "id3";
    } elseif ($post_type === "commentaries") {
        $idtype = "id4";
    } else {
        $idtype = "id5";
    }
    if ($convertedPath !== null) {
        if ($userType === 'Editor') {
            $sql = "INSERT INTO $post_type (editor_id, title, niche, image_path, Date, time, schedule, subtitle, link, content, authors_firstname, about_author, authors_lastname, idtype, is_favourite) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            if ($query = $conn->prepare($sql)) {
                $query->bind_param("issssssssssssss", $id, $title, $niche, $convertedPath, $date, $time, $schedule, $subtitle, $link, $content, $author_firstname, $author_bio, $author_lastname, $idtype, $is_favourite);
                if ($query->execute()) {
                    $post_id = $conn->insert_id;
                    $post_link = "http://localhost/Sample-dynamic-website/pages/view_post.php?" . $idtype . "=" . $post_id . "";
                    $content = "Editor " . $_SESSION['firstname'] . " added a new post (" . $post_type . ")";
                    $forUser = 1;
                    logUpdate($conn, $forUser, $content);
                    $_SESSION['status_type'] = "Success";
                    $_SESSION['status'] = "Post Created Successfully";
                    sendNewpostNotification($title, $post_link, $convertedPath, $subtitle);
                    header('location: ' . $editor_base_url . 'editor_homepage.php');
                    exit();
                } else {
                    $_SESSION['status_type'] = "Error";
                    $_SESSION['status'] = "Error, Please retry";
                    header('location: ' . $editor_base_url . 'editor_homepage.php');
                    exit();
                }
            } else {
                $error = $conn->errno . ' ' . $conn->error;
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = $error;
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            }
        }else{
            $sql = "INSERT INTO $post_type (admin_id, title, niche, image_path, Date, time, schedule, subtitle, link, content, authors_firstname, about_author, authors_lastname, idtype, is_favourite) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            if ($query = $conn->prepare($sql)) {
                $query->bind_param("issssssssssssss", $id, $title, $niche, $convertedPath, $date, $time, $schedule, $subtitle, $link, $content, $author_firstname, $author_bio, $author_lastname, $idtype, $is_favourite);
                if ($query->execute()) {
                    $post_id = $conn->insert_id;
                    $post_link = "http://localhost/Sample-dynamic-website/pages/view_post.php?" . $idtype . "=" . $post_id . "";
                    $content = "Admin " . $_SESSION['firstname'] . " added a new post (" . $post_type . ")";
                    $forUser = 1;
                    logUpdate($conn, $forUser, $content);
                    $_SESSION['status_type'] = "Success";
                    $_SESSION['status'] = "Post Created Successfully";
                    sendNewpostNotification($title, $post_link, $convertedPath, $subtitle);
                    header('location: ' . $admin_base_url . 'admin_homepage.php');
                    exit();
                } else {
                    $_SESSION['status_type'] = "Error";
                    $_SESSION['status'] = "Error, Please retry";
                    header('location: ' . $admin_base_url . 'admin_homepage.php');
                    exit();
                }   
            } else {
                $error = $conn->errno . ' ' . $conn->error;
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = $error;
                header('location: create_new/posts.php');
            }
           }
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Error, Please retry";
        $base_path = errorPath();
        header('location: ' . $base_path . 'create_new/posts.php');
        exit();
    }
}
function createCategory($category_name, $category_image, $userType)
{
    global $conn;
    global $admin_base_url;
    global $editor_base_url;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $meta_name = "viewport";
    $meta_content = "width=device-width,initial-scale=1.0";
    $formattedTopicName = strtolower(str_replace(' ', '-', $category_name));
    $filename1 = removeHyphenNoSpace($category_name);
    $filename = removeHyphenNoSpace($category_name) . '.php';
    $uc_category_name = noHyphenUppercase($category_name);
    $fileContent = <<<PHP
        <?php
            session_start();
            require('../connect.php');
            require('../init.php');
            require('../helpers/components.php');
           \$_SESSION['status_type'] = "";
           \$_SESSION['status'] = "";
           \$page_name = "$formattedTopicName";
           \$details = getFaviconAndLogo();
           \$logo = \$details['logo'];
           \$favicon = \$details['favicon'];
           if (isset(\$_POST['submit_btn'])) {
                \$email = \$_POST["email"];
                \$sendEmail = sendEmail(\$email);
                \$_SESSION['status_type'] = \$sendEmail['status_type'];
                \$_SESSION['status'] = \$sendEmail['status'];
            }
            if (isset(\$_POST['subscribe_btn2'])) {
                \$email = \$_POST["email"];
                \$sendEmail = sendEmail(\$email);
                \$_SESSION['status_type'] = \$sendEmail['status_type'];
                \$_SESSION['status'] = \$sendEmail['status'];
            }    
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <?php if (isset(\$meta_titles[\$page_name])) {
                \$meta_data = \$meta_titles[\$page_name];
                for (\$i = 1; \$i <= 5; \$i++) {
                    \$meta_name = \$meta_data["meta_name\$i"];
                    \$meta_content = \$meta_data["meta_content\$i"];
                    if (!empty(\$meta_name) && !empty(\$meta_content)) {
                        echo "<meta name='\$meta_name' content='\$meta_content' />";
                    }
                }
            }?>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="../css/main.css" />
            <meta charset="UTF-8">
            <title>$uc_category_name</title>
        </head>
        <body id="container">
            <?php
                \$ucPageTitle = $uc_category_name;
                \$lcPageTitle = $filename1;
                renderFrontendPage(\$ucPageTitle, \$lcPageTitle);
            ?>
            <script src="sweetalert2.all.min.js"></script>
            <script>
                const closeMenuBtn = document.querySelector('.sidebarbtn');
                const sidebar = document.getElementById('sidebar');
                const menubtn = document.querySelector('.mainheader__header-nav-2');
                var messageType = "<?= \$_SESSION['status_type'] ?? '' ?>";
                var messageText = "<?= \$_SESSION['status'] ?? '' ?>";
                function removeHiddenClass(e) {
                    e.stopPropagation();
                    sidebar.classList.remove('hidden');
                };
                function onClickOutside(element) {
                    document.addEventListener('click', e => {
                        if (!element.contains(e.target)) {
                            element.classList.add('hidden');
                        } else return;
                    });
                };
                onClickOutside(sidebar);
                menubtn.addEventListener('click', removeHiddenClass);
                closeMenuBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    sidebar.classList.toggle('hidden');
                });
                function submitSearch() {
                    var query = document.getElementById("search-bar").value;
                    if (query.trim() !== "") {
                        fetch("$filename?query=" + encodeURIComponent(query))
                            .then(response => response.text())
                            .then(data => {
                            document.getElementById("results-container").innerHTML = data;
                        })
                        .catch(error => console.error("Error fetching results:", error));
                    } else {
                        document.getElementById("search-results").style.display = "none";
                    }
                }
            </script>
            <script>
                if (messageType == 'Error' && messageText != " ") {
                    Swal.fire({
                        title: 'Error!',
                        text: messageText,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                } else if (messageType == 'Info' && messageText != " ") {
                    Swal.fire({
                        title: 'Info!',
                        text: messageText,
                        showConfirmButton: true,
                        confirmButtonText: 'Ok',
                        icon: 'info'
                    })
                } else if (messageType == 'Success' && messageText != " ") {
                    Swal.fire({
                        title: 'Success',
                        text: messageText,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    })
                }
                <?php unset(\$_SESSION['status_type']); ?>
                <?php unset(\$_SESSION['status']); ?>
            </script>
        </body>
        </html>
    PHP;
    if ($category_image !== null) {
        if($userType === 'Editor'){
            $sqlTopics = "INSERT INTO topics (name, image_path, Date, time) VALUES (?,?,?,?)";
            $filePath = '../pages/' . $filename;
            if ($query = $conn->prepare($sqlTopics)) {
                $query->bind_param("ssss", $formattedTopicName, $category_image, $date, $time);
                if ($query->execute()) {
                    $sqlMetaTitles = "INSERT INTO meta_titles (page_name, meta_name1, meta_content1) VALUES (?, ?, ?)";
                    if ($query = $conn->prepare($sqlMetaTitles)) {
                        $query->bind_param("sss", $formattedTopicName, $meta_name, $meta_content);
                        if ($query->execute()) {
                            if (file_put_contents($filePath, $fileContent)) {
                                $content = "Editor " . $_SESSION['firstname'] . " added a new category";
                                $forUser = 0;
                                logUpdate($conn, $forUser, $content);
                                $_SESSION['status_type'] = "Success";
                                $_SESSION['status'] = "Category Created Successfully";
                                header('location: ' . $editor_base_url . 'create_new/category.php');
                                exit();
                            } else {
                                $_SESSION['status_type'] = "Error";
                                $_SESSION['status'] = "Error, Please retry";
                                header('location: ' . $editor_base_url . 'create_new/category.php');
                                exit();
                            }
                        }
                    }
                }
            }else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $editor_base_url . 'create_new/category.php');
            }
        }else{
            $sqlTopics = "INSERT INTO topics (name, image_path, Date, time) VALUES (?,?,?,?)";
            $filePath = '../pages/' . $filename;
            if ($query = $conn->prepare($sqlTopics)) {
                $query->bind_param("ssss", $formattedTopicName, $category_image, $date, $time);
                if ($query->execute()) {
                    $sqlMetaTitles = "INSERT INTO meta_titles (page_name, meta_name1, meta_content1) VALUES (?, ?, ?)";
                    if ($query = $conn->prepare($sqlMetaTitles)) {
                        $query->bind_param("sss", $formattedTopicName, $meta_name, $meta_content);
                        if ($query->execute()) {
                            if (file_put_contents($filePath, $fileContent)) {
                                $content = "Admin " . $_SESSION['firstname'] . " added a new category";
                                $forUser = 0;
                                logUpdate($conn, $forUser, $content);
                                $_SESSION['status_type'] = "Success";
                                $_SESSION['status'] = "Category Created Successfully";
                                header('location: ' . $admin_base_url . 'create_new/category.php');
                                exit();
                            } else {
                                $_SESSION['status_type'] = "Error";
                                $_SESSION['status'] = "Could not create category file, please retry";
                                header('location: ' . $admin_base_url . 'create_new/category.php');
                                exit();
                            }
                        }else {
                            $_SESSION['status_type'] = "Error";
                            $_SESSION['status'] = "Error, Please retry";
                            header('location: ' . $admin_base_url . 'create_new/category.php');
                            exit();
                        }
                    }else{
                        $_SESSION['status_type'] = "Error";
                        $_SESSION['status'] = "Error, Please retry";
                        header('location: ' . $admin_base_url . 'create_new/category.php');
                        exit();
                    }
                }else{
                    $_SESSION['status_type'] = "Error";
                    $_SESSION['status'] = "Error, Please retry";
                    header('location: ' . $admin_base_url . 'create_new/category.php');
                    exit();
                }
            }else{
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $admin_base_url . 'create_new/category.php');
                exit();
            }
        }
    } else {
        if($userType === 'Editor'){
            $sqlTopics = "INSERT INTO topics (name, Date, time) VALUES (?,?,?)";
            $filePath = '../pages/' . $filename;
            if ($query = $conn->prepare($sqlTopics)) {
                $query->bind_param("sss", $formattedTopicName, $date, $time);
                if ($query->execute()) {
                    $sqlMetaTitles = "INSERT INTO meta_titles (page_name, meta_name1, meta_content1) VALUES (?, ?, ?)";
                    if ($query = $conn->prepare($sqlMetaTitles)) {
                        $query->bind_param("sss", $formattedTopicName, $meta_name, $meta_content);
                        if ($query->execute()) {
                            if (file_put_contents($filePath, $fileContent)) {
                                $content = "Editor " . $_SESSION['firstname'] . " added a new category";
                                $forUser = 0;
                                logUpdate($conn, $forUser, $content);
                                $_SESSION['status_type'] = "Success";
                                $_SESSION['status'] = "Category Created Successfully";
                                header('location: ' . $editor_base_url . 'create_new/category.php');
                                exit();
                            } else {
                                $_SESSION['status_type'] = "Error";
                                $_SESSION['status'] = "Could not create category file, please retry";
                                header('location: ' . $editor_base_url . 'create_new/category.php');
                                exit();
                            }
                        }else {
                            $_SESSION['status_type'] = "Error";
                            $_SESSION['status'] = "Error, Please retry";
                            header('location: ' . $editor_base_url . 'create_new/category.php');
                            exit();
                        }
                    }else {
                        $_SESSION['status_type'] = "Error";
                        $_SESSION['status'] = "Error, Please retry";
                        header('location: ' . $editor_base_url . 'create_new/category.php');
                        exit();
                    }
                }else {
                    $_SESSION['status_type'] = "Error";
                    $_SESSION['status'] = "Error, Please retry";
                    header('location: ' . $editor_base_url . 'create_new/category.php');
                    exit();                    
                }
            }
        }else{
            $sqlTopics = "INSERT INTO topics (name, Date, time) VALUES (?,?,?)";
            $filePath = '../pages/' . $filename;
            if ($query = $conn->prepare($sqlTopics)) {
                $query->bind_param("sss", $formattedTopicName, $date, $time);
                if ($query->execute()) {
                    $sqlMetaTitles = "INSERT INTO meta_titles (page_name, meta_name1, meta_content1) VALUES (?, ?, ?)";
                    if ($query = $conn->prepare($sqlMetaTitles)) {
                        $query->bind_param("sss", $formattedTopicName, $meta_name, $meta_content);
                        if ($query->execute()) {
                            if (file_put_contents($filePath, $fileContent)) {
                                $content = "Admin " . $_SESSION['firstname'] . " added a new category";
                                $forUser = 0;
                                logUpdate($conn, $forUser, $content);
                                $_SESSION['status_type'] = "Success";
                                $_SESSION['status'] = "Category Created Successfully";
                                header('location: ' . $admin_base_url . 'create_new/category.php');
                                exit();
                           } else {
                                $_SESSION['status_type'] = "Error";
                                $_SESSION['status'] = "Could not create category file, please retry";
                                header('location: ' . $admin_base_url . 'create_new/category.php');
                                exit();
                            }
                        }else {
                            $_SESSION['status_type'] = "Error";
                            $_SESSION['status'] = "Error, Please retry";
                            header('location: ' . $admin_base_url . 'create_new/category.php');
                            exit();
                        }
                    }else {
                        $_SESSION['status_type'] = "Error";
                        $_SESSION['status'] = "Error, Please retry";
                        header('location: ' . $admin_base_url . 'create_new/category.php');
                        exit();
                    }
                }else {
                    $_SESSION['status_type'] = "Error";
                    $_SESSION['status'] = "Error, Please retry";
                    header('location: ' . $admin_base_url . 'create_new/category.php');
                    exit();
                }
            }else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $admin_base_url . 'create_new/category.php');
                exit();
            }
        }
    }
}
function savePost2($title, $subtitle, $convertedPath, $content, $niche, $link, $schedule, $id, $author_firstname, $author_lastname, $author_bio, $post_type, $userType)
{
    global $conn;
    global $admin_base_url;
    global $editor_base_url;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $idtype = "";
    if ($post_type === "paid_posts") {
        $idtype = "id1";
    } elseif ($post_type === "posts") {
        $idtype = "id2";
    } elseif ($post_type === "news") {
        $idtype = "id3";
    } elseif ($post_type === "commentaries") {
        $idtype = "id4";
    } else {
        $idtype = "id5";
    }
    $is_favourite = 'False';
    if($userType === 'Editor'){
        $sql = "INSERT INTO $post_type (editor_id, title, niche, post_image_url, Date, time, schedule, subtitle, link, content, authors_firstname, about_author, authors_lastname, idtype, is_favourite) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if ($query = $conn->prepare($sql)) {
            $query->bind_param("issssssssssssss", $id, $title, $niche, $convertedPath, $date, $time, $schedule, $subtitle, $link, $content, $author_firstname, $author_bio, $author_lastname, $idtype, $is_favourite);
            if ($query->execute()) {
                $post_id = $conn->insert_id;
                $post_link = "http://localhost/Sample-dynamic-website/pages/view_post.php?" . $idtype . "=" . $post_id . "";
                $content = "Editor " . $_SESSION['firstname'] . " added a new post (" . $post_type . ")";
                $forUser = 1;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Post Created Successfully";
                sendNewpostNotification($title, $post_link, $convertedPath, $subtitle);
                header('location: ' . $editor_base_url . 'create_new/posts.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $editor_base_url . 'create_new/posts.php');
                exit();
            }
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: ' . $editor_base_url . 'create_new/posts.php');
            exit();
        }
    }else{
        $sql = "INSERT INTO $post_type (admin_id, title, niche, post_image_url, Date, time, schedule, subtitle, link, content, authors_firstname, about_author, authors_lastname, idtype, is_favourite) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if ($query = $conn->prepare($sql)) {
            $query->bind_param("issssssssssssss", $id, $title, $niche, $convertedPath, $date, $time, $schedule, $subtitle, $link, $content, $author_firstname, $author_bio, $author_lastname, $idtype, $is_favourite);
            if ($query->execute()) {
                $post_id = $conn->insert_id;
                $post_link = "http://localhost/Sample-dynamic-website/pages/view_post.php?" . $idtype . "=" . $post_id . "";
                $content = "Admin " . $_SESSION['firstname'] . " added a new post (" . $post_type . ")";
                $forUser = 1;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Post Created Successfully";
                sendNewpostNotification($title, $post_link, $convertedPath, $subtitle);
                header('location: ' . $admin_base_url . 'create_new/posts.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $admin_base_url . 'create_new/posts.php');
                exit();
            }
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: ' . $admin_base_url . 'create_new/posts.php');
            exit();
        }
    }
}
function saveDraft($title, $subtitle, $imagePath, $content, $niche, $link, $id, $userType)
{
    global $conn;
    global $admin_base_url;
    global $editor_base_url;
    $date = date('y-m-d');
    $time = date('H:i:s');
    if ($imagePath !== null) {
        if($userType === 'Editor'){
            $stmt = $conn->prepare("INSERT INTO unpublished_articles (editor_id, title, subtitle, image, link, Date, time, niche, content) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssssss", $id, $title, $subtitle, $imagePath, $link, $date, $time, $niche, $content);
            if ($stmt->execute()) {
                $content = "Editor " . $_SESSION['firstname'] . " added a draft";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Draft Created Successfully";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            }
        }else{
            $stmt = $conn->prepare("INSERT INTO unpublished_articles (admin_id, title, subtitle, image, link, Date, time, niche, content) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssssss", $id, $title, $subtitle, $imagePath, $link, $date, $time, $niche, $content);
            if ($stmt->execute()) {
                $content = "Admin " . $_SESSION['firstname'] . " added a draft";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Draft Created Successfully";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            }
        }
    } else {
        if($userType === 'Editor'){
            $stmt = $conn->prepare("INSERT INTO unpublished_articles (editor_id, title, subtitle, link, Date, time, niche, content) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssss", $id, $title, $subtitle, $link, $date, $time, $niche, $content);
            if ($stmt->execute()) {
                $content = "Editor " . $_SESSION['firstname'] . " added a draft";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Draft Created Successfully";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            }
        }else{
            $stmt = $conn->prepare("INSERT INTO unpublished_articles (admin_id, title, subtitle, link, Date, time, niche, content) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssss", $id, $title, $subtitle, $link, $date, $time, $niche, $content);
            if ($stmt->execute()) {
                $content = "Admin " . $_SESSION['firstname'] . " added a draft";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Draft Created Successfully";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            }
        }
    }
}
function updatePost($title, $subtitle, $imagePath, $content, $niche, $link, $id, $author_firstname, $author_lastname, $author_bio, $tablename, $post_id, $userType)
{
    global $conn;
    global $admin_base_url;
    global $editor_base_url;
    $date = date('y-m-d');
    $time = date('H:i:s');
    if ($imagePath !== null) {
        if($userType === 'Editor'){
            $stmt = $conn->prepare("UPDATE $tablename SET title = ?, subtitle = ?, image_path = ?, content = ?, niche = ?, link = ?, Date = ?, time = ?, authors_firstname = ?, about_author = ?, authors_lastname = ? WHERE id = ?");
            $stmt->bind_param("sssssssssssi", $title, $subtitle, $imagePath, $content, $niche, $link, $date, $time, $author_firstname, $author_bio, $author_lastname, $post_id);
            if ($stmt->execute()) {
                $content = "Editor " . $_SESSION['firstname'] . " updated a post";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Post Updated Successfully";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            }
        }else{
            $stmt = $conn->prepare("UPDATE $tablename SET title = ?, subtitle = ?, image_path = ?, content = ?, niche = ?, link = ?, Date = ?, time = ?, authors_firstname = ?, about_author = ?, authors_lastname = ? WHERE id = ?");
            $stmt->bind_param("sssssssssssi", $title, $subtitle, $imagePath, $content, $niche, $link, $date, $time, $author_firstname, $author_bio, $author_lastname, $post_id);
            if ($stmt->execute()) {
                $content = "Admin " . $_SESSION['firstname'] . " updated a post";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Post Updated Successfully";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            }
        }
    } else {
        if($userType === 'Editor'){
            $stmt = $conn->prepare("UPDATE $tablename SET title = ?, subtitle = ?, content = ?, niche = ?, link = ?, Date = ?, time = ?, authors_firstname = ?, about_author = ?, authors_lastname = ? WHERE id = ?");
            $stmt->bind_param("ssssssssssi", $title, $subtitle, $content, $niche, $link, $date, $time, $author_firstname, $author_bio, $author_lastname, $post_id);
            if ($stmt->execute()) {
                $content = "Editor " . $_SESSION['firstname'] . " updated a post";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Post Updated Successfully";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            }
        }else{
            $stmt = $conn->prepare("UPDATE $tablename SET title = ?, subtitle = ?, content = ?, niche = ?, link = ?, Date = ?, time = ?, authors_firstname = ?, about_author = ?, authors_lastname = ? WHERE id = ?");
            $stmt->bind_param("ssssssssssi", $title, $subtitle, $content, $niche, $link, $date, $time, $author_firstname, $author_bio, $author_lastname, $post_id);
            if ($stmt->execute()) {
                $content = "Admin " . $_SESSION['firstname'] . " updated a post";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Post Updated Successfully";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            }
        }
    }
}
function updateProfile($firstname, $lastname, $email, $username, $bio, $address1, $address2, $city, $state, $country, $countrycode, $mobile, $imagePath, $id, $userType)
{
    global $conn;
    global $admin_base_url;
    global $editor_base_url;
    if ($imagePath !== null) {
        if($userType === 'Editor'){
            $stmt = $conn->prepare("UPDATE editor SET firstname = ?, lastname = ?, username = ?, email = ?, image = ?, bio = ?, mobile = ?, country = ?, 	city = ?, state = ?, address1 = ?, address2 = ?, country_code = ? WHERE id = ?");
            $stmt->bind_param("sssssssssssssi", $firstname, $lastname, $username, $email, $imagePath, $bio, $mobile, $country, $city, $state, $address1, $address2, $countrycode, $id);
            if ($stmt->execute()) {
                $content = "Editor " . $_SESSION['firstname'] . " updated his/her profile";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Profile Updated Successfully";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            }
        }else{
            $stmt = $conn->prepare("UPDATE admin_login_info SET firstname = ?, lastname = ?, username = ?, email = ?, image = ?, bio = ?, mobile = ?, country = ?, 	city = ?, state = ?, address1 = ?, address2 = ?, country_code = ? WHERE id = ?");
            $stmt->bind_param("sssssssssssssi", $firstname, $lastname, $username, $email, $imagePath, $bio, $mobile, $country, $city, $state, $address1, $address2, $countrycode, $id);
            if ($stmt->execute()) {
                $content = "Admin " . $_SESSION['firstname'] . " updated his/her profile";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Profile Updated Successfully";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            }
        }
    } else {
        if($userType === 'Editor'){
            $stmt = $conn->prepare("UPDATE editor SET firstname = ?, lastname = ?, username = ?, email = ?, bio = ?, mobile = ?, country = ?, 	city = ?, state = ?, address1 = ?, address2 = ?, country_code = ? WHERE id = ?");
            $stmt->bind_param("ssssssssssssi", $firstname, $lastname, $username, $email, $bio, $mobile, $country, $city, $state, $address1, $address2, $countrycode, $id);
            if ($stmt->execute()) {
                $content = "Editor " . $_SESSION['firstname'] . " updated his/her profile";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Profile Updated Successfully";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            }
        }else{
            $stmt = $conn->prepare("UPDATE admin_login_info SET firstname = ?, lastname = ?, username = ?, email = ?, bio = ?, mobile = ?, country = ?, 	city = ?, state = ?, address1 = ?, address2 = ?, country_code = ? WHERE id = ?");
            $stmt->bind_param("ssssssssssssi", $firstname, $lastname, $username, $email, $bio, $mobile, $country, $city, $state, $address1, $address2, $countrycode, $id);
            if ($stmt->execute()) {
                $content = "Admin " . $_SESSION['firstname'] . " updated his/her profile";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Profile Updated Successfully";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            }
        }
    }
}
function updateUserProfile($firstname, $lastname, $email, $role, $url, $bio, $imagePath, $id, $userType)
{
    global $conn;
    global $admin_base_url;
    global $editor_base_url;
    if ($imagePath !== null) {
        if($userType === 'Editor'){
            $stmt = $conn->prepare("UPDATE otherwebsite_users SET firstname = ?, lastname = ?, email = ?, role = ?, image = ?, bio = ?, linkedin_url = ? WHERE id = ?");
            $stmt->bind_param("sssssssi", $firstname, $lastname, $email, $role, $imagePath, $bio, $url, $id);
            if ($stmt->execute()) {
                $content = "Editor " . $_SESSION['firstname'] . " updated $firstname's profile";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Profile Updated Successfully";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            }
        }else{
            $stmt = $conn->prepare("UPDATE otherwebsite_users SET firstname = ?, lastname = ?, email = ?, role = ?, image = ?, bio = ?, linkedin_url = ? WHERE id = ?");
            $stmt->bind_param("sssssssi", $firstname, $lastname, $email, $role, $imagePath, $bio, $url, $id);
            if ($stmt->execute()) {
                $content = "Admin " . $_SESSION['firstname'] . " updated $firstname's profile";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Profile Updated Successfully";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            }
        }
    } else {
        if($userType === 'Editor'){
            $stmt = $conn->prepare("UPDATE otherwebsite_users SET firstname = ?, lastname = ?, email = ?, role = ?, bio = ?, linkedin_url = ? WHERE id = ?");
            $stmt->bind_param("ssssssi", $firstname, $lastname, $email, $role, $bio, $url, $id);
            if ($stmt->execute()) {
                $content = "Editor " . $_SESSION['firstname'] . " updated $firstname's profile";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Profile Updated Successfully";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            }
        }else{
            $stmt = $conn->prepare("UPDATE otherwebsite_users SET firstname = ?, lastname = ?, email = ?, role = ?, bio = ?, linkedin_url = ? WHERE id = ?");
            $stmt->bind_param("ssssssi", $firstname, $lastname, $email, $role, $bio, $url, $id);
            if ($stmt->execute()) {
                $content = "Admin " . $_SESSION['firstname'] . " updated $firstname's profile";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Profile Updated Successfully";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            }
        }
    }
}
function updateWriterProfile($firstname, $lastname, $email, $bio, $imagePath, $id, $userType)
{
    global $conn;
    global $admin_base_url;
    global $editor_base_url;
    if ($imagePath !== null) {
        if($userType === 'Editor'){
            $stmt = $conn->prepare("UPDATE writer SET firstname = ?, lastname = ?, email = ?, image = ?, bio = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $firstname, $lastname, $email, $imagePath, $bio, $id);
            if ($stmt->execute()) {
                $content = "Editor " . $_SESSION['firstname'] . " updated $firstname's profile";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Profile Updated Successfully";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            }
        }else{
            $stmt = $conn->prepare("UPDATE writer SET firstname = ?, lastname = ?, email = ?, image = ?, bio = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $firstname, $lastname, $email, $imagePath, $bio, $id);
            if ($stmt->execute()) {
                $content = "Admin " . $_SESSION['firstname'] . " updated $firstname's profile";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Profile Updated Successfully";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            }
        }
    } else {
        if($userType === 'Editor'){
            $stmt = $conn->prepare("UPDATE writer SET firstname = ?, lastname = ?, email = ?, bio = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $firstname, $lastname, $email, $bio, $id);
            if ($stmt->execute()) {
                $content = "Editor " . $_SESSION['firstname'] . " updated $firstname's profile";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Profile Updated Successfully";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $editor_base_url . 'editor_homepage.php');
                exit();
            }
        }else{
            $stmt = $conn->prepare("UPDATE writer SET firstname = ?, lastname = ?, email = ?, bio = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $firstname, $lastname, $email, $bio, $id);
            if ($stmt->execute()) {
                $content = "Admin " . $_SESSION['firstname'] . " updated $firstname's profile";
                $forUser = 0;
                logUpdate($conn, $forUser, $content);
                $_SESSION['status_type'] = "Success";
                $_SESSION['status'] = "Profile Updated Successfully";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            } else {
                $_SESSION['status_type'] = "Error";
                $_SESSION['status'] = "Error, Please retry";
                header('location: ' . $admin_base_url . 'admin_homepage.php');
                exit();
            }
        }
    }
}
function addWriter($firstname, $lastname, $email, $imagePath, $id, $userType)
{
    global $conn;
    global $admin_base_url;
    global $editor_base_url;
    $date = date('y-m-d');
    $time = date('H:i:s');
    $idtype = "Writer";
    if($userType === 'Editor'){
        $stmt = $conn->prepare("INSERT INTO writer (id, firstname, lastname, email, image, date_joined, time_joined, idtype) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssss", $id, $firstname, $lastname, $email, $imagePath, $date, $time, $idtype);
        if ($stmt->execute()) {
            $content = "Editor " . $_SESSION['firstname'] . " created a new user (Writer)";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "User Created Successfully";
            header('location: ' . $editor_base_url . 'create_new/writer.php');
            exit(); 
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: ' . $editor_base_url . 'create_new/writer.php');
            exit();
        }
    }else{
        $stmt = $conn->prepare("INSERT INTO writer (id, firstname, lastname, email, image, date_joined, time_joined, idtype) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssss", $id, $firstname, $lastname, $email, $imagePath, $date, $time, $idtype);
        if ($stmt->execute()) {
            $content = "Admin " . $_SESSION['firstname'] . " created a new user (Writer)";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "User Created Successfully";
            header('location: ' . $admin_base_url . 'create_new/writer.php');
            exit(); 
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: ' . $admin_base_url . 'create_new/writer.php');
            exit();
        }
    }
}
function addUser($firstname, $lastname, $email,  $role, $linkedin_url, $imagePath, $userType)
{
    global $conn;
    global $admin_base_url;
    global $editor_base_url;
    $date = date('y-m-d');
    $time = date('H:i:s');
    if($userType === 'Editor'){
        $stmt = $conn->prepare("INSERT INTO otherwebsite_users ( firstname, lastname, email, role, image, linkedin_url, date_joined, time_joined) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $firstname, $lastname, $email, $role, $imagePath, $linkedin_url, $date, $time);
        if ($stmt->execute()) {
            $content = "Editor " . $_SESSION['firstname'] . " created a new user";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "User Created Successfully";
            header('location: ' . $editor_base_url . 'create_new/user.php');
            exit();
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: ' . $editor_base_url . 'create_new/user.php');
            exit();
        }
    }else{
        $stmt = $conn->prepare("INSERT INTO otherwebsite_users ( firstname, lastname, email, role, image, linkedin_url, date_joined, time_joined) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $firstname, $lastname, $email, $role, $imagePath, $linkedin_url, $date, $time);
        if ($stmt->execute()) {
            $content = "Admin " . $_SESSION['firstname'] . " created a new user";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "User Created Successfully";
            header('location: ' . $admin_base_url . 'create_new/user.php');
            exit();
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: ' . $admin_base_url . 'create_new/user.php');
            exit();
        }
    }
}
function forgotPasswordAction($usertype, $email)
{
    global $conn, $admin_base_url, $editor_base_url;
    if ($usertype === 'admin') {
        $stmt = $conn->prepare("SELECT firstname, email FROM admin_login_info WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $check_email = $stmt->get_result();
        if ($check_email->num_rows > 0) {
            $row = $check_email->fetch_assoc();
            $firstname = $row['firstname'];
            $token = rand(10000, 99999);
            $stmt = $conn->prepare("UPDATE admin_login_info SET token = ?, token_created_at = NOW() WHERE email = ?");
            $stmt->bind_param('ss', $token, $email);
            if ($stmt->execute()) {
                $sendOtp = sendOTP($email, $firstname, $token);
                $_SESSION['status_type'] = $sendOtp['status_type'];
                $_SESSION['status'] = $sendOtp['status'];
                $_SESSION['firstname'] = $firstname;
                header('Location: ' . $admin_base_url . '/login/verifyotp.php?email=' . urlencode($email));
                exit();
            }
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Sorry, couldn't find user with specified email.";
            header('Location: ' . $admin_base_url . '/login/forgotpassword.php');
        }
    } else if ($usertype === 'editor') {
        // Use a prepared statement for the SELECT query
        $stmt = $conn->prepare("SELECT firstname, email FROM editor WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $check_email = $stmt->get_result();

        if ($check_email->num_rows > 0) {
            $row = $check_email->fetch_assoc();
            $firstname = $row['firstname'];
            $token = rand(10000, 99999);
            $stmt = $conn->prepare("UPDATE editor SET token = ?, token_created_at = NOW() WHERE email = ?");
            $stmt->bind_param('ss', $token, $email);
            if ($stmt->execute()) {
                $sendOtp = sendOTP($email, $firstname, $token);
                $_SESSION['status_type'] = $sendOtp['status_type'];
                $_SESSION['status'] = $sendOtp['status'];
                $_SESSION['firstname'] = $firstname;
                header('Location: ' . $editor_base_url . '/login/verifyotp.php?email=' . urlencode($email));
                exit();
            }
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Sorry, couldn't find user with specified email.";
            header('Location: ' . $editor_base_url . '/login/forgotpassword.php');
        }
    }
}
function validateOTP($usertype, $email, $otp)
{
    global $conn, $admin_base_url, $editor_base_url, $msg;
    if ($usertype === 'admin') {
        if (strlen($otp) !== 5 || !ctype_digit($otp)) {
            $msg = "Invalid OTP format.";
            header('Location: ' . $admin_base_url . '/login/verifyotp.php?email=' . urlencode($email));
        } else {
            $stmt = $conn->prepare("SELECT firstname FROM admin_login_info WHERE email = ? AND token = ? AND token_created_at > NOW() - INTERVAL 1 MINUTE");
            $stmt->bind_param("ss", $email, $otp);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result === false) {
                $msg = "User not found";
                header('Location: ' . $admin_base_url . '/login/verifyotp.php?email=' . urlencode($email));
            } elseif ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $_SESSION['otp_verified'] = true;
                $_SESSION['verified_email'] = $email;
                $clearStmt = $conn->prepare("UPDATE admin_login_info SET token = NULL, token_created_at = NULL WHERE email = ?");
                $clearStmt->bind_param("s", $email);
                $clearStmt->execute();
                $clearStmt->close();
                header("Location: " . $admin_base_url . "login/changepassword.php");
                exit();
            } else {
                $token = rand(10000, 99999);
                $regenerateStmt = $conn->prepare("UPDATE admin_login_info SET token = ?, token_created_at = NOW() WHERE email = ?");
                $regenerateStmt->bind_param('ss', $token, $email);
                if ($regenerateStmt->execute()) {
                    $nameStmt = $conn->prepare("SELECT firstname FROM admin_login_info WHERE email = ?");
                    $nameStmt->bind_param("s", $email);
                    $nameStmt->execute();
                    $nameResult = $nameStmt->get_result();
                    if ($nameResult && $nameResult->num_rows > 0) {
                        $user = $nameResult->fetch_assoc();
                        $firstname = $user['firstname'];
                        $sendOtp = sendOTP($email, $firstname, $token);
                        $msg = "OTP expired or invalid. A new OTP has been sent to your email.";
                        header('Location: ' . $admin_base_url . '/login/verifyotp.php?email=' . urlencode($email));
                    } else {
                        $msg = "Unable to retrieve user info for OTP regeneration.";
                    }
                    $nameStmt->close();
                } else {
                    $msg = "Failed to regenerate OTP. Please try again.";
                    header('Location: ' . $admin_base_url . '/login/verifyotp.php?email=' . urlencode($email));
                }
                $regenerateStmt->close();
            }
            $stmt->close();
        }
    } else if ($usertype === 'editor') {
        if (strlen($otp) !== 5 || !ctype_digit($otp)) {
            $msg = "Invalid OTP format.";
            header('Location: ' . $editor_base_url . '/login/verifyotp.php?email=' . urlencode($email));
        } else {
            $stmt = $conn->prepare("SELECT firstname FROM editor WHERE email = ? AND token = ? AND token_created_at > NOW() - INTERVAL 1 MINUTE");
            $stmt->bind_param("ss", $email, $otp);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result === false) {
                $msg = "User not found";
                header('Location: ' . $editor_base_url . '/login/verifyotp.php?email=' . urlencode($email));
            } elseif ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $_SESSION['otp_verified'] = true;
                $_SESSION['verified_email'] = $email;
                $clearStmt = $conn->prepare("UPDATE editor SET token = NULL, token_created_at = NULL WHERE email = ?");
                $clearStmt->bind_param("s", $email);
                $clearStmt->execute();
                $clearStmt->close();
                header("Location: " . $editor_base_url . "login/changepassword.php");
                exit();
            } else {
                $token = rand(10000, 99999);
                $regenerateStmt = $conn->prepare("UPDATE editor SET token = ?, token_created_at = NOW() WHERE email = ?");
                $regenerateStmt->bind_param('ss', $token, $email);
                if ($regenerateStmt->execute()) {
                    $nameStmt = $conn->prepare("SELECT firstname FROM editor WHERE email = ?");
                    $nameStmt->bind_param("s", $email);
                    $nameStmt->execute();
                    $nameResult = $nameStmt->get_result();
                    if ($nameResult && $nameResult->num_rows > 0) {
                        $user = $nameResult->fetch_assoc();
                        $firstname = $user['firstname'];
                        $sendOtp = sendOTP($email, $firstname, $token);
                        $msg = "OTP expired or invalid. A new OTP has been sent to your email.";
                        header('Location: ' . $editor_base_url . '/login/verifyotp.php?email=' . urlencode($email));
                    } else {
                        $msg = "Unable to retrieve user info for OTP regeneration.";
                        header('Location: ' . $editor_base_url . '/login/verifyotp.php?email=' . urlencode($email));
                    }
                    $nameStmt->close();
                } else {
                    $msg = "Failed to regenerate OTP. Please try again.";
                    header('Location: ' . $editor_base_url . '/login/verifyotp.php?email=' . urlencode($email));
                }
                $regenerateStmt->close();
            }
            $stmt->close();
        }
    }
    return $msg;
}
function resetPasswordSignIn($usertype, $password1, $email)
{
    global $conn, $ipAddress, $deviceType, $logFilePath, $action, $firstname, $admin_base_url, $editor_base_url;;
    $hashed = password_hash($password1, PASSWORD_DEFAULT);
    if ($usertype === 'admin') {
        $stmt = $conn->prepare("UPDATE admin_login_info SET password = ? WHERE email = ?");
        $stmt->bind_param('ss',  $hashed, $email);
        if ($stmt->execute()) {
            $action = 'successfully changed his/her password';
            logUserAction($ipAddress, $deviceType, $logFilePath, $action, $firstname);
            $content = "Admin " . $firstname . " changed his/her password";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Password Updated Successfully";
            header('Location: ' . $admin_base_url . '/login/index.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('Location: ' . $admin_base_url . '/login/changepassword.php');
        }
    } else if ($usertype === 'editor') {
        $stmt = $conn->prepare("UPDATE editor SET password = ? WHERE email = ?");
        $stmt->bind_param('ss',  $hashed, $email);
        if ($stmt->execute()) {
            $action = 'successfully changed his/her password';
            logUserAction($ipAddress, $deviceType, $logFilePath, $action, $firstname);
            $content = "Editor " . $firstname . " changed his/her password";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Password Updated Successfully";
            header('Location: ' . $editor_base_url . '/login/index.php');
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('Location: ' . $editor_base_url . '/login/changepassword.php');
        }
    }
}
if (isset($_POST['create_post'])) {
    $title = $_POST['Post_Title'];
    $subtitle = $_POST['Post_Sub_Title'];
    $content = $_POST['Post_content'];
    $niche = $_POST['Post_Niche'];
    $post_type = $_POST['Post_status'];
    $link = $_POST['Post_featured'];
    $schedule = $_POST['schedule'];
    $author_firstname = $_POST['author_firstname'];
    $author_lastname = $_POST['author_lastname'];
    $author_bio = $_POST['about_author'];
    $image2 = $_POST['Post_Image2'];
    $image1 = $_FILES['Post_Image1']['name'];
    $tmpPath = $_FILES['Post_Image1']['tmp_name'];
    $target = "../images/" . basename($image1);
    $base_path = errorPath();
    if (empty($image1) && !empty($image2)) {
        $imagePath = $image2;
        savePost2($title, $subtitle, $imagePath, $content, $niche, $link, $schedule, $id, $author_firstname, $author_lastname, $author_bio, $post_type, $userType);
    } elseif (!empty($image1) && empty($image2)) {
        if ($_FILES['Post_Image1']['error'] === UPLOAD_ERR_OK && is_uploaded_file($tmpPath)) {
            $convertedPath = uploadToCloudinary($tmpPath);
            savePost1($title, $subtitle, $convertedPath, $content, $niche, $link, $schedule, $id, $author_firstname, $author_lastname, $author_bio, $post_type, $userType);
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Uploaded file is missing or invalid.";
            header('location: ' . $base_path . 'create_new/posts.php');
            exit();
        }
    } elseif (!empty($image1) && !empty($image2)) {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Please select either a file or a URL, not both.";
        header('location: ' . $base_path . 'create_new/posts.php');
        exit();
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Please provide an image file or URL.";
        header('location: ' . $base_path . 'create_new/posts.php');
        exit();
    }
}

if (isset($_POST['edit_profile'])) {
    $firstname = $_POST['profile_firstname'];
    $lastname = $_POST['profile_lastname'];
    $username = $_POST['profile_username'];
    $bio = $_POST['profile_bio'];
    $email = $_POST['profile_email'];
    $address1 = $_POST['profile-address1'];
    $address2 = $_POST['profile-address2'];
    $city = $_POST['profile-city'];
    $state = $_POST['profile-state'];
    $country = $_POST['profile-country'];
    $countrycode = $_POST['profile-countrycode'];
    $mobile = $_POST['profile-mobile'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    $imagePath = '';
    if (empty($image)) {
        $imagePath = null;
    }
    $filePath = $_FILES["Img"]["tmp_name"];
    $imagePath = uploadToCloudinary($filePath);
    updateProfile($firstname, $lastname, $email, $username, $bio, $address1, $address2, $city, $state, $country, $countrycode, $mobile, $imagePath, $id, $userType);
}
if (isset($_POST['edit_profile_writer'])) {
    $id = $_POST['profile-id'];
    $firstname = $_POST['profile_firstname'];
    $lastname = $_POST['profile_lastname'];
    $bio = $_POST['profile_bio'];
    $email = $_POST['profile_email'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    $convertedPath = '';
    if (!empty($image)) {
        $filePath = $_FILES["Img"]["tmp_name"];
        $convertedPath = uploadToCloudinary($filePath);
    }else {
        $convertedPath = null;
    }
    updateWriterProfile($firstname, $lastname, $email, $bio, $convertedPath, $id, $userType);
}
if (isset($_POST['edit_profile_otheruser'])) {
    $id = $_POST['profile-id'];
    $firstname = $_POST['profile_firstname'];
    $lastname = $_POST['profile_lastname'];
    $bio = $_POST['profile_bio'];
    $role = $_POST['profile_role'];
    $email = $_POST['profile_email'];
    $url = $_POST['profile_url'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    $convertedPath = '';
    if (empty($image)) {
        $convertedPath = null;
    }
    $filePath = $_FILES["Img"]["tmp_name"];
    $convertedPath = uploadToCloudinary($filePath);
    updateUserProfile($firstname, $lastname, $email, $role, $url, $bio, $convertedPath, $id, $userType);
}
if (isset($_POST['create_draft'])) {
    $title = $_POST['Post_Title'];
    $subtitle = $_POST['Post_Sub_Title'];
    $content = $_POST['Post_content'];
    $niche = $_POST['Post_Niche'];
    $link = $_POST['Post_featured'];
    $image = $_FILES['Post_Image']['name'];
    $target = "../images/" . basename($image);
    $convertedPath = '';
    if (empty($title) && empty($subtitle) && empty($link) && empty($image) && empty($content) && empty($niche)) {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Cannot submit form, please fill in all the required fields.";
        $base_path = errorPath();
        header('location: ' . $base_path . 'create_new/workspace.php');
        exit();
    }
    if (empty($image)) {
        $convertedPath = null;
    }
    $filePath = $_FILES["Post_Image"]["tmp_name"];
    $convertedPath = uploadToCloudinary($filePath);
    saveDraft($title, $subtitle, $convertedPath, $content, $niche, $link, $id, $userType);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_post'])) {
    $title = $_POST['Post_Title'];
    $niche = $_POST['Post_Niche'];
    $content = $_POST['Post_content'];
    $link = $_POST['Post_featured'];
    $tablename = $_POST['table_type'];
    $post_id = $_POST['post_id'];
    $subtitle = $_POST['Post_Sub_Title'];
    $author_firstname = $_POST['author_firstname'];
    $author_lastname = $_POST['author_lastname'];
    $author_bio = $_POST['about_author'];
    $image = $_FILES['Post_Image']['name'];
    $target = "../images/" . basename($image);
    $convertedPath = '';
    if (empty($image)) {
        $convertedPath = null;
    }
    $filePath = $_FILES["Post_Image"]["tmp_name"];
    $convertedPath = uploadToCloudinary($filePath);
    updatePost($title, $subtitle, $convertedPath, $content, $niche, $link, $id, $author_firstname, $author_lastname, $author_bio, $tablename, $post_id, $userType);
}
if (isset($_POST['create_page'])) {
    $topic_name = $_POST['topicName'];
    $image = $_FILES['topicImg']['name'];
    $target = "../images/" . basename($image);
    $convertedPath = '';
    if (empty($topic_name) && empty($image)) {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Cannot submit form, please fill in all the required fields.";
        $base_path = errorPath();
        header('location: ' . $base_path . 'edit/frontend_features.php');
        exit();
    }
    if (empty($image)) {
        $convertedPath = null;
    }
    $filePath = $_FILES["topicImg"]["tmp_name"];
    $convertedPath = uploadToCloudinary($filePath);
    createCategory($topic_name, $convertedPath, $userType);
}
if (isset($_POST['create_writer'])) {
    $firstname = $_POST['writer_firstname'];
    $lastname = $_POST['writer_lastname'];
    $email = $_POST['writer_email'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    $convertedPath = '';
    if (empty($firstname) && empty($lastname) && empty($email) && empty($image)) {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Cannot submit form, please fill in all the required fields.";
        $base_path = errorPath();
        header('location: ' . $base_path . 'create_new/writer.php');
        exit();
    }
    if (!empty($image)) {
        $filePath = $_FILES["Img"]["tmp_name"];
        $convertedPath = uploadToCloudinary($filePath);
    } else {
        $convertedPath = 'https://res.cloudinary.com/dbdw3zftx/image/upload/v1754775818/uploads/Avatar.png'; // If no image is uploaded, set path to null
    }
    addWriter($firstname, $lastname, $email, $convertedPath, $id, $userType);
}
if (isset($_POST['create_user'])) {
    $firstname = $_POST['user_firstname'];
    $lastname = $_POST['user_lastname'];
    $email = $_POST['user_email'];
    $role = $_POST['user_role'];
    $linkedin_url = $_POST['user_linkedin_url'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    $convertedPath = '';
    if (empty($firstname) && empty($lastname) && empty($email) && empty($role) && empty($linkedin_url) && empty($image)) {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Cannot submit form, please fill in all the required fields.";
        $base_path = errorPath();
        header('location: ' . $base_path . 'create_new/user.php');
        exit();
    }
    if (empty($image)) {
        $convertedPath = 'https://res.cloudinary.com/dbdw3zftx/image/upload/v1754775818/uploads/Avatar.png';
    }
    $filePath = $_FILES["Img"]["tmp_name"];
    $convertedPath = uploadToCloudinary($filePath);
    addUser($firstname, $lastname, $email,  $role, $linkedin_url, $convertedPath, $userType);
}
if (isset($_POST['add_resource'])) {
    $resource_type = $_POST['resource_type'];
    $resource_niche = $_POST['resource_niche'];
    $resource_title = $_POST['resource_title'];
    $resource_url = $_POST['resource_url'];
    $resource_image = $_FILES['resource_image']['name'];
    $resource_tmp_name = $_FILES['resource_image']['tmp_name'];
    $resource_folder = "../files/" . $resource_image;
    $tableName = pluralizeTableName($resource_type);
    if (empty($resource_type) && empty($resource_niche) && empty($resource_title) && empty($resource_url) && empty($resource_image)) {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Cannot submit form, please fill in all the required fields.";
        $base_path = errorPath();
        header('location: ' . $base_path . 'edit/frontend_features.php');
        exit();
    }
    $result = $conn->query("SHOW TABLES LIKE '$tableName'");
    if ($result->num_rows == 0) {
        $sql = "CREATE TABLE IF NOT EXISTS $tableName (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50) NULL, resource_path VARCHAR(100) NULL, date_added DATE NOT NULL, time_added TIME NOT NULL, niche VARCHAR(50) NULL, title VARCHAR(100) NULL)";
        if ($conn->query($sql) === TRUE) {
            if (empty($resource_image)) {
                $convertedPath = null;
            }
            $convertedPath = uploadToCloudinary($resource_tmp_name);
            $resource_type = convertToUnreadable($resource_type);
            addResources($tableName, $convertedPath, $resource_type, $resource_niche, $resource_title, $resource_url, $userType);
        }
    } else {
        $base_path = errorPath();
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Resource Type Already Exists";
        header('location: ' . $base_path . 'edit/frontend_features.php');
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && $_SESSION['user'] === 'Editor') {
    $recordId = intval($_GET["id"]);
    $date = date('y-m-d');
    $time = date('H:i:s');
    function updateProfilePic($imagePath1)
    {
        global $conn;
        global $recordId;
        global $editor_base_url;
        $stmt = $conn->prepare("UPDATE editor SET image = ? WHERE id = ?");
        $stmt->bind_param("si", $imagePath1, $recordId);
        if ($stmt->execute()) {
            $content = "Editor " . $_SESSION['firstname'] . " updated his/her Profile Picture";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Sucess";
            $_SESSION['status'] = "Profile Picture Updated Successfully";
            header('location: ' . $editor_base_url . 'editor_homepage.php');
            exit();
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: ' . $editor_base_url . 'editor_homepage.php');
            exit();
        }
    }
    if (isset($_FILES["profile_pic"])) {
        $filePath1 = $_FILES["profile_pic"]["tmp_name"];
        $convertedPath = uploadToCloudinary($filePath1);
        updateProfilePic($convertedPath);
    }
}
if (isset($_POST['edit_profile_editor'])) {
    file_put_contents("log.txt", "POST request received\n", FILE_APPEND);
    $id = $_POST['profile-id'];
    $firstname = $_POST['profile_firstname'];
    $lastname = $_POST['profile_lastname'];
    $username = $_POST['profile_username'];
    $bio = $_POST['profile_bio'];
    $email = $_POST['profile_email'];
    $address1 = $_POST['profile-address1'];
    $address2 = $_POST['profile-address2'];
    $city = $_POST['profile-city'];
    $state = $_POST['profile-state'];
    $country = $_POST['profile-country'];
    $countrycode = $_POST['profile-countrycode'];
    $mobile = $_POST['profile-mobile'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    $convertedPath = '';
    if (!empty($image)) {
        $filePath = $_FILES["Img"]["tmp_name"];
        $convertedPath = uploadToCloudinary($filePath);
    }
    updateEditorProfile($firstname, $lastname, $email, $username, $bio, $address1, $address2, $city, $state, $country, $countrycode, $mobile, $convertedPath, $id);
}
if (isset($_POST['create_editor'])) {
    $firstname = $_POST['editor_firstname'];
    $lastname = $_POST['editor_lastname'];
    $email = $_POST['editor_email'];
    $password = $_POST['editor_password'];
    $confirm_pasword = $_POST['editor_password-confirm'];
    $image = $_FILES['Img']['name'];
    $target = "../images/" . basename($image);
    $convertedPath = '';
    if (empty($firstname) && empty($lastname) && empty($email) && empty($password) && empty($confirm_pasword) && empty($image)) {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Cannot submit form, please fill in all the required fields.";
        $base_path = errorPath();
        header('location: ' . $base_path . 'create_new/editor.php');
        exit();
    }
    if ($password === $confirm_pasword) {
        if (!empty($image)) {
            $filePath = $_FILES["Img"]["tmp_name"];
            $convertedPath = uploadToCloudinary($filePath);
        } else {
            $convertedPath = 'https://res.cloudinary.com/dbdw3zftx/image/upload/v1754775818/uploads/Avatar.png';
        }
        addEditor($firstname, $lastname, $email, $convertedPath, $password, $id);
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Passwords do not match";
        header('location: ' . $admin_base_url . 'create_new/editor.php');
        exit();
    }
}
if (isset($_POST['edit_privacypolicy_btn'])) {
    $content = $_POST['privacy_policy'];
    $tablename = "privacy_policy";
    updatePages($content, $tablename);
}
if (isset($_POST['edit_aboutwebsite_btn'])) {
    $content = $_POST['about_website'];
    $tablename = "about_us";
    updatePages($content, $tablename);
}
if (isset($_POST['advertedit_btn'])) {
    $content = $_POST['advertise_content'];
    $tablename = "advertise_with_us";
    updatePages($content, $tablename);
}
if (isset($_POST['websiteterms_editbtn'])) {
    $content = $_POST['website_terms'];
    $tablename = "terms_of_service";
    updatePages($content, $tablename);
}
if (isset($_POST['workwithus_editbtn'])) {
    $content = $_POST['work_withus'];
    $tablename = "work_with_us";
    updatePages($content, $tablename);
}
if (isset($_POST['contactus_editbtn'])) {
    $content = $_POST['contactus_content'];
    $tablename = "contact_us";
    updatePages($content, $tablename);
}
if (isset($_POST['change_frontend_messages'])) {
    $cookie_consent = $_POST['cookie_consent'];
    $description = $_POST['description'];
    if (!empty($cookie_consent) && !empty($description)) {
        AddWebsiteMessages($cookie_consent, $description);
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "No Changes Made";
        header('location: ' . $admin_base_url . 'edit/frontend_features.php');
        exit();
    }
}
if (isset($_POST['add_page'])) {
    $page_name = $_POST['page_name'];
    if (empty($page_name)) {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Cannot submit form, please fill in all the required fields.";
        $base_path = errorPath();
        header('location: ' . $base_path . 'edit/frontend_features.php');
        exit();
    }
    addPage($page_name);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && $_SESSION['user'] === 'Admin') {
    $recordId = intval($_GET["id"]);
    $date = date('y-m-d');
    $time = date('H:i:s');
    file_put_contents("log.txt", "POST request received\n", FILE_APPEND);
    function updateFavicon($imagePath2)
    {
        global $conn;
        global $recordId;
        global $date;
        global $time;
        global $admin_base_url;
        $stmt = $conn->prepare("UPDATE website_logo SET favicon_imagepath = ?, Date = ?, time = ?  WHERE id = ?");
        $stmt->bind_param("sssi", $imagePath2, $date, $time, $recordId);
        if ($stmt->execute()) {
            $content = "Admin " . $_SESSION['firstname'] . " updated this Website's Favicon";
            $forUser = 0;
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Favicon Updated Successfully";
            logUpdate($conn, $forUser, $content);
            header('location: ' . $admin_base_url . 'edit/frontend_features.php');
            exit();
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: ' . $admin_base_url . 'edit/frontend_features.php');
            exit();
        }
    }
    function updateLogo($imagePath1)
    {
        global $conn;
        global $recordId;
        global $date;
        global $time;
        global $admin_base_url;
        $stmt = $conn->prepare("UPDATE website_logo SET logo_imagepath = ?, Date = ?, time = ?  WHERE id = ?");
        $stmt->bind_param("sssi", $imagePath1, $date, $time, $recordId);
        if ($stmt->execute()) {
            $content = "Admin " . $_SESSION['firstname'] . " updated this Website's Logo";
            $forUser = 0;
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Logo Updated Successfully";
            logUpdate($conn, $forUser, $content);
            header('location: ' . $admin_base_url . 'edit/frontend_features.php');
            exit();
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: ' . $admin_base_url . 'edit/frontend_features.php');
            exit();
        }
    }
    function updateProfilePic($imagePath1)
    {
        global $conn;
        global $recordId;
        global $admin_base_url;
        $stmt = $conn->prepare("UPDATE admin_login_info SET image = ? WHERE id = ?");
        $stmt->bind_param("si", $imagePath1, $recordId);
        if ($stmt->execute()) {
            $content = "Admin " . $_SESSION['firstname'] . " updated his/her Profile Picture";
            $forUser = 0;
            logUpdate($conn, $forUser, $content);
            $_SESSION['status_type'] = "Success";
            $_SESSION['status'] = "Profile Picture Updated Successfully";
            header('location: ' . $admin_base_url . 'admin_homepage.php');
            exit();
        } else {
            $_SESSION['status_type'] = "Error";
            $_SESSION['status'] = "Error, Please retry";
            header('location: ' . $admin_base_url . 'admin_homepage.php');
            exit();
        }
    }
    if (isset($_FILES["website_logo"])) {
        $website_logo = $_FILES["website_logo"]["name"];
        $logo_tmp_name = $_FILES["website_logo"]["tmp_name"];
        $resource_folder1 = "../images/" . $website_logo;
        $convertedPath = uploadToCloudinary($logo_tmp_name);
        updateLogo($convertedPath);
    }
    if (isset($_FILES["website_favicon"])) {
        $website_favicon = $_FILES["website_favicon"]["name"];
        $favicon_tmp_name = $_FILES["website_favicon"]["tmp_name"];
        $resource_folder2 = "../images/" . $website_favicon;

        $convertedPath = uploadToCloudinary($favicon_tmp_name);
        updateFavicon($convertedPath);
    }
    if (isset($_FILES["profile_pic"])) {
        $profile_pic = $_FILES["profile_pic"]["name"];
        $profile_tmp_name = $_FILES["profile_pic"]["tmp_name"];
        $resource_folder1 = "../images/" . $profile_pic;

        $convertedPath = uploadToCloudinary($profile_tmp_name);
        updateProfilePic($convertedPath);
    }
}
if (isset($_POST['send_message_subscriber'])) {
    $id = $_POST['user_id'];
    $message = $_POST['message'];
    $title = $_POST['subject'];
    $sendEmail = sendMessageToSubscriber($id, $title, $message);
    $_SESSION['status_type'] = $sendEmail['status_type'];
    $_SESSION['status'] = $sendEmail['status'];
    header('location: ' . $admin_base_url . 'admin_homepage.php');
    exit();
}
if (isset($_POST['send_message_user'])) {
    $id = $_POST['user_id'];
    $message = $_POST['message'];
    $title = $_POST['subject'];
    $sendEmail = sendMessageToUser($id, $title, $message);
    $_SESSION['status_type'] = $sendEmail['status_type'];
    $_SESSION['status'] = $sendEmail['status'];
    header('location: ' . $admin_base_url . 'admin_homepage.php');
    exit();
}
if (isset($_POST['send_message_writer'])) {
    $id = $_POST['user_id'];
    $message = $_POST['message'];
    $title = $_POST['subject'];
    $sendEmail = sendMessageToWriter($id, $title, $message);
    $_SESSION['status_type'] = $sendEmail['status_type'];
    $_SESSION['status'] = $sendEmail['status'];
    header('location: ' . $admin_base_url . 'admin_homepage.php');
    exit();
}
if (isset($_POST['create_new_resource_file'])) {
    $resource_type = $_POST['resource_type'];
    $resource_url = $_POST['resource_url'];
    $resource_niche = $_POST['resource_niche'];
    $resource_title = $_POST['resource_title'];
    $resource_type = lowercaseNoSpace($resource_type);
    $resource_path = $_FILES['File']['name'];
    $target = "../files/" . basename($resource_path);
    $convertedPath = '';
    if (empty($resource_type) && empty($resource_url) && empty($resource_title) && empty($resource_niche) && empty($resource_path)) {
        $_SESSION['status_type'] = "Error";
        $isEmpty = True;
        $_SESSION['status'] = "Cannot submit form, please fill in all the required fields.";
        $base_path = errorPath();
        header('location: ' . $base_path . 'edit/frontend_features.php');
        exit();
    }
    if (!empty($resource_path)) {
        $filePath = $_FILES["File"]["tmp_name"];
        $convertedPath = convertPath2($filePath);
    } else {
        $convertedPath = null;
    }
    addResourceFile($resource_type, $convertedPath, $resource_niche, $resource_title, $resource_url, $userType);
}
if (isset($_POST['edit_resource_file'])) {
    $resource_type = $_POST['resource_type'];
    $resource_path = $_POST['resource_path'];
    $resource_type_id = $_POST['resource_type_id'];
    $resource_niche = $_POST['resource_niche'];
    $resource_name = $_POST['resource_name'];
    $resource_title = $_POST['resource_title'];
    $resource_type = lowercaseNoSpace($resource_type);
    $resource_path2 = $_FILES['File']['name'];
    $target = "../files/" . basename($resource_path2);
    $convertedPath = '';
    if (!empty($resource_path2)) {
        $filePath = $_FILES["File"]["tmp_name"];
        $convertedPath = convertPath2($filePath);
    } else {
        $convertedPath = $resource_path;
    }
    editResourceFile($resource_type, $convertedPath, $resource_niche, $resource_title, $resource_name, $resource_type_id, $userType);
}
if (isset($_POST['fgtpswd'])) {
    $email = $_POST['email'];
    $usertype = $_POST['usertype'];
    forgotPasswordAction($usertype, $email);
}
if (isset($_POST['validate_otp'])) {
    $email = $_POST['validate_otp_email'] ?? '';
    $usertype = $_POST['usertype'] ?? '';
    $otp = ($_POST['otp1'] ?? '') . ($_POST['otp2'] ?? '') . ($_POST['otp3'] ?? '') . ($_POST['otp4'] ?? '') . ($_POST['otp5'] ?? '');
    validateOTP($usertype, $email, $otp);
}
if (isset($_POST['change_password'])) {
    $password1 = $_POST['pwd'];
    $password2 = $_POST['cfpwd'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $usertype = $_POST['usertype'];
    if ($password1 === $password2) {
        resetPasswordSignIn($usertype, $password1, $email);
    } else {
        $_SESSION['status_type'] = "Error";
        $_SESSION['status'] = "Passwords do not match";
        if ($usertype === 'admin') {
            header('location: ' . $admin_base_url . '/login/changepassword.php');
        } else if ($usertype === 'editor') {
            header('location: ' . $editor_base_url . '/login/changepassword.php');
        }
    }
}