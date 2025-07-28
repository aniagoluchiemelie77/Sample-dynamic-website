<?php
session_start();
require("../connect.php");
require("../init.php");
require('../../init.php');
$resource_type = isset($_GET['resource_type']) ? $_GET['resource_type'] : null;
$details = getFaviconAndLogo();
$logo = $details['logo'];
$favicon = $details['favicon'];
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
    <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
    <title><?php echo $translations['create_new_resource_file']; ?></title>
</head>

<body>
    <?php require("../extras/header3.php"); ?>
    <section class="about_section">
        <div class="page_links">
            <a href="<?php echo $base_url . 'editor_homepage.php'; ?>"><?php echo $translations['home']; ?></a> > <a href="../edit/frontend_features.php"> <?php echo $translations['front_end_features']; ?> </a> > <p> <?php echo $translations['create_new_resource_file']; ?></p>
        </div>
        <form class="formcontainer" id="topicForm" method="post" action="../../helpers/forms.php" enctype="multipart/form-data">
            <div class="head_paragraph">
                <h3><?php echo $translations['create_new_resource_file']; ?></h3>
            </div>
            <div class="formcontainer_subdiv">
                <input type="hidden" name="resource_type" id="topicName" value='<?php echo $resource_type; ?>' />
                <div class="newpost_container_div6 newpost_subdiv">
                    <label class="form__label" for="File"><?php echo $translations['upload_resource']; ?>:</label>
                    <div class="newpost_subdiv2">
                        <input class="form__input" name="File" type="file" />
                        <p class="newpost_subdiv2-p leftp"><span>*</span><?php echo $translations['message_title_i']; ?></p>
                    </div>
                </div>
                <div class="input_group">
                    <label for="resource_url"><?php echo $translations['resource_url']; ?>:</label>
                    <input type="text" name="resource_url" id="topicName" />
                </div>
                <div class="input_group">
                    <label for="resource_niche"><?php echo $translations['resource_niche']; ?>:</label>
                    <input type="text" name="resource_niche" id="topicName" />
                </div>
                <div class="input_group">
                    <label for="resource_title"><?php echo $translations['resource_title']; ?>:</label>
                    <input type="text" name="resource_title" id="topicName" />
                </div>
            </div>
            <input class="formcontainer_submit" value="<?php echo $translations['save']; ?>" type="submit" name="create_new_resource_file" />
        </form>
    </section>
    <script src="sweetalert2.all.min.js"></script>
    <script src="../editor.js"></script>
    <script>
        function preventSubmitIfEmpty(formSelector, inputSelector) {
            document.addEventListener("DOMContentLoaded", () => {
                const form = document.querySelector(formSelector);
                if (!form) return;

                const inputs = form.querySelectorAll(inputSelector);
                const originalValues = Array.from(inputs).map((input) =>
                    input.value.trim()
                );

                form.addEventListener("submit", (e) => {
                    let hasChanged = false;
                    inputs.forEach((input, index) => {
                        if (input.type === "file") {
                            if (input.files.length > 0) {
                                hasChanged = true;
                            }
                        } else if (input.value.trim() !== originalValues[index]) {
                            hasChanged = true;
                        }
                    });

                    if (!hasChanged) {
                        e.preventDefault();
                        Swal.fire({
                            title: "Empty Form",
                            text: "Cannot submit an empty form.",
                            icon: "info",
                            confirmButtonText: "Ok",
                        });
                    }
                });
            });
        }
        preventSubmitIfEmpty('.formcontainer', 'input, textarea');
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