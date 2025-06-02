    <?php
        session_start();
        require("../connect.php");
        require("../init.php");
        require("../../init.php");
        $details = getFaviconAndLogo();
        $logo = $details['logo'];
        $favicon = $details['favicon'];
        $translationFile = "../translation_files/lang/{$language}.php";
        if (file_exists($translationFile)) {
            include $translationFile;
        } else {
            $translations = [];
        }
        function updatePages($content, $tablename)
        {
            global $conn;
            $date = date('y-m-d');
            $time = date('H:i:s');
            $string = str_replace('-', ' ', $tablename);
            $stmt = "INSERT INTO $tablename (content, date, time) VALUES (?, ?, ?)";
            if ($query = $conn->prepare($stmt)) {
                $query->bind_param("sss", $content, $date, $time);
                if ($query->execute()) {
                    $content = "Admin " . $_SESSION['firstname'] . " updated this website's '" . $string . "'";
                    $forUser = 0;
                    logUpdate($conn, $forUser, $content);
                    $_SESSION['status_type'] = "Success";
                    $_SESSION['status'] = "" . $string . " Updated Successfully";
                    header('location: admin_homepage.php');
                } else {
                    $_SESSION['status_type'] = "Error";
                    $_SESSION['status'] = "Error, Please retry";
                    header('location: admin_homepage.php');
                }
            } else {
                $error = $conn->errno . ' ' . $conn->error;
                echo $error;
                header('location: admin_homepage.php');
            }
        }
        if (isset($_POST['edit_aboutwebsite_btn'])) {
            $content = $_POST['share-news-tips'];
            $tablename = "share_news_tips";
            updatePages($content, $tablename);
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
            <link rel="stylesheet" href="//code. jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <link rel="icon" href="../../<?php echo $favicon; ?>" type="image/x-icon">
            <title>Share News Tips</title>
        </head>
        <body>
            <?php require("../extras/header2.php"); ?>
            <section class="about_section">
                <div class="page_links">
                    <a href="../admin_homepage.php"><?php echo $translations['home']; ?></a> > <p><?php echo $translations['pages']; ?></p> > <p>Share News Tips</p>
                </div>
                <div class="about_header">
                    <h1>Share News Tips</h1>
                </div>
                <div class="about_contents">
                    <?php
                        $selectpage = "SELECT content FROM share_news_tips ORDER BY id DESC LIMIT 1";
                        $selectpage_result = $conn->query($selectpage);
                        if ($selectpage_result->num_rows > 0) {
                            while ($row = $selectpage_result->fetch_assoc()) {
                                $content = $row['content'];
                                echo "<span>$content</span>";
                            }
                        }
                    ?>
                </div>
                <button class="about_section_btn" id="Edit_about1"><?php echo $translations['edit']; ?>
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </button>
                <form class="about_editdiv" action=" " method="post" id="hidden_aboutdiv1">
                    <textarea class="about_editdiv-input" name="share-news-tips" id="myTextarea6"></textarea>
                    <input type="submit" value="<?php echo $translations['save']; ?>" name="edit_aboutwebsite_btn" />
                </form>
            </section>
            <script type="text/javascript" src="https://cdn.tiny.cloud/1/mshrla4r3p3tt6dmx5hu0qocnq1fowwxrzdjjuzh49djvu2p/tinymce/6/tinymce.min.js"></script>
            <script src="../admin.js"></script>
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
                const editAboutBtn = document.getElementById("Edit_about1");
                const editTextEditor = document.getElementById("hidden_aboutdiv1");
                editAction(editAboutBtn, editTextEditor);
            </script>
            <script src="sweetalert2.all.min.js"></script>
        </body>
    </html>