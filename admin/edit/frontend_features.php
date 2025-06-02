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
                        <p class="newpost_subdiv2-p leftp"><span>*</span><?php echo $translations['require']; ?></p>
                    </div>
                </div>
                <div class="newpost_container_div6_subdiv">
                    <label class="form__label" for="resource_url"><?php echo $translations['resource_url']; ?>:</label>
                    <div class="newpost_container_div5_subdiv2">
                        <input class="form__input" name="resource_url" type="text" placeholder="<?php echo $translations['resource_url_p']; ?>..." />
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
    <div class="logout_alert" id="logout_alert2">
        <form class="newpost_container" method="post" action="../forms.php" id="postForm" enctype="multipart/form-data">
            <a class="logout_alert_cancel" onclick="cancelExit2()">
                <i class="fa fa-times popup_close1" aria-hidden="true"></i>
            </a>
            <div class="newpost_container_div1 newpost_subdiv">
                <h1 class="sectioneer_form_header"><?php echo $translations['add_page']; ?></h1>
            </div>
            <div class="newpost_container_div3 newpost_subdiv">
                <label class="form__label" for="page_name"><?php echo $translations['page_name']; ?></label>
                <div class="newpost_container_div3_subdiv2">
                    <input class="form__input" name="page_name" type="text" />
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
        <form class="frontend_div sectioneer_form" action="../forms.php" method="POST" enctype="multipart/form-data">
            <?php
            $selectwebsite_logo = "SELECT id, logo_imagepath, favicon_imagepath FROM website_logo ORDER BY id DESC LIMIT 1";
            $selectwebsite_logo_result = $conn->query($selectwebsite_logo);
            if ($selectwebsite_logo_result->num_rows > 0) {
                while ($row = $selectwebsite_logo_result->fetch_assoc()) {
                    $logo_image = $row['logo_imagepath'];
                    $favicon_image = $row['favicon_imagepath'];
                    $id = $row['id'];
                    $_SESSION['logo_id'] = $row['id'];
                    echo '<div class="sectioneer_form_container" id="consent-data" data-id="' . $id . '">
                                <div class="sectioneer_form_container_subdiv2">
                                    <h1 class="sectioneer_form_header">Edit Website Logo</h1>
                                    <div class="sectioneer_form_container_subdiv2_subdiv">
                                        <img src="../../' . $logo_image . '" alt="Website Logo">
                                        <a class="add_div" name="website_logo" onclick="selectImage(\'website_logo\', ' . $id . ')">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                            <p>Edit Logo</p>
                                        </a>
                                    </div>
                                </div>
                                <div class="sectioneer_form_container_subdiv2">
                                    <h1 class="sectioneer_form_header">Edit Favicon</h1>
                                        <div class="sectioneer_form_container_subdiv2_subdiv">
                                            <img src="../../' . $favicon_image . '" alt="Favicon Image">
                                            <a class="add_div" name="website_favicon" onclick="selectImage(\'website_favicon\', ' . $id . ')">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                <p>Edit Favicon</p>
                                            </a>
                                        </div>
                                </div>
                                </div>';
                }
            }
            ?>
            <input class="btn" type="submit" value="<?php echo $translations['save']; ?>" name="change_logo" />
        </form>
        <form class="frontend_div sectioneer_form" action="../forms.php" method="POST" enctype="multipart/form-data">
            <div class="sectioneer_form_container">
                <?php
                $website_messages_sql = "SELECT id, cookie_consent, website_vision FROM website_messages ORDER BY id DESC LIMIT 1";
                $website_messages_result = $conn->query($website_messages_sql);
                if ($website_messages_result->num_rows > 0) {
                    while ($row = $website_messages_result->fetch_assoc()) {
                        $cookie_message = $row['cookie_consent'];
                        $website_vision_message = $row['website_vision'];
                        $id = $row['id'];
                        $_SESSION['message_id'] = $row['id'];
                        echo "  <div class='sectioneer_form_container_subdiv2'>
                                    <h1 class='sectioneer_form_header'>$translations[edit_cookie]</h1>
                                    <textarea name='cookie_consent' id='myTextarea6c'>$cookie_message</textarea>
                                </div>
                                <div class='sectioneer_form_container_subdiv2' id='consent-data' data-id='$id'>
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
                    $readableString = convertToReadable2($resource_name);
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
                            <a class='' onclick='confirmDeletePage($resource_id, $page_name)'>
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
        async function selectImage(inputType, recordId) {
            const {
                value: file
            } = await Swal.fire({
                title: "Select image",
                input: "file",
                inputAttributes: {
                    accept: "image/*",
                    "aria-label": "Upload your image"
                }
            });

            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    Swal.fire({
                        title: "Your uploaded Image",
                        imageUrl: e.target.result,
                        imageAlt: "The uploaded Image",
                        confirmButtonText: "Upload"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            uploadImage(file, inputType, recordId);
                        }
                    });
                };
                reader.readAsDataURL(file);
            }
        }

        function uploadImage(file, inputType, recordId) {
            let formData = new FormData();
            formData.append(inputType, file);
            formData.append("id", recordId);

            fetch("../forms.php?id=" + encodeURIComponent(recordId), {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    console.log("Server Response:", data);
                    Swal.fire("Success!", "Image uploaded successfully!", "success");
                })
                .catch(error => {
                    Swal.fire("Error!", "Image upload failed!", "error");
                });
        }
    </script>

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