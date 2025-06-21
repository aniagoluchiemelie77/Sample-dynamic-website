    <?php
    session_start();
    require('../connect.php');
    require('../init.php');
    $page_name = "webfiles";
    $_SESSION['status_type'] = "";
    $_SESSION['status'] = "";
    $details = getFaviconAndLogo();
    $logo = $details['logo'];
    $favicon = $details['favicon'];
    function containsFilesPath($string)
    {
        return strpos($string, 'files/') !== false;
    }
    if (isset($_POST['submit_btn'])) {
        $email = $_POST["email"];
        $sendEmail = sendEmail($email);
        $_SESSION['status_type'] = $sendEmail['status_type'];
        $_SESSION['status'] = $sendEmail['status'];
    }
    if (isset($_POST['subscribe_btn2'])) {
        $email = $_POST["email"];
        $sendEmail = sendEmail($email);
        $_SESSION['status_type'] = $sendEmail['status_type'];
        $_SESSION['status'] = $sendEmail['status'];
    }
    if (isset($_GET['query'])) {
        $query = trim($_GET['query']);
        if ($query !== "") {
            $stmt = $conn->prepare("SELECT * FROM webfiles WHERE title LIKE ?");
            $searchTerm = "%" . $query . "%";
            $stmt->bind_param("s", $searchTerm);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $title = htmlspecialchars($row['title']);
                        $max_length = 50;
                        $niche = htmlspecialchars($row['niche']);
                        $formattedDate = date("F j, Y", strtotime($row['date_added']));
                        $resourcePath = htmlspecialchars($row['resource_path']);
                        if (containsFilesPath($resourcePath)) {
                            $resourcePath = '../' . $resourcePath;
                        }
                        if (strlen($title) > $max_length) {
                            $title = substr($title, 0, $max_length) . '...';
                        }
                        echo " <a class='more_posts_subdiv'>";
                        echo "<img src='../images/resurces_img.png' alt='Whitepaper Image'/>";
                        echo " <div class='more_posts_subdiv_subdiv'>
                                <h1>$title</h1>
                                <span>$formattedDate</span>
                            </div>";
                        echo "  <div class='view_whitepaper'>
                                <div class='posts_btn' onclick=\"window.location.href='$resourcePath'\" target='_blank'>
                                    <i class='fa fa-eye' aria-hidden='true'></i>
                                </div>
                            </div>";
                        echo "<p class='posts_div_niche'>$niche</p>";
                        echo "</a>";
                    }
                } else {
                    echo "<h1 class='bodyleft_header3'>No results found for ' $query '</h1>";
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
        if (isset($meta_titles[$page_name])) {
            $meta_data = $meta_titles[$page_name];
            for ($i = 1; $i <= 5; $i++) {
                $meta_name = $meta_data["meta_name{$i}"];
                $meta_content = $meta_data["meta_content{$i}"];
                if (!empty($meta_name) && !empty($meta_content)) {
                    echo "<meta name='$meta_name' content='$meta_content' />";
                }
            }
        }
        ?>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../index.css" />
        <script src="../index.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="icon" href="../<?php echo $favicon; ?>" type="image/x-icon">
        <title>Webfiles</title>
    </head>

    <body id="container">
        <?php require("../includes/header2.php"); ?>
        <div class="body_container">
            <div class="body_left">
                <div class="page_links">
                    <a href="../">Home</a> > <p>Resources (Webfiles)</p>
                </div>
                <h1 class='bodyleft_header3'>Search Webfiles</h1>
                <form class="header_searchbar2 search_input" id="search_form" action='webfiles.php' method="get">
                    <input type="text" name="query" id="search-bar" placeholder="Search.." />
                    <button class="fa fa-search" type="submit" onclick="submitSearch()"></button>
                </form>
                <div id="search-results">
                    <div id="results-container" class="more_posts"></div>
                </div>
                <div class='more_posts'>
                    <?php
                    $sql = "SELECT name, resource_path, niche, title, date_added FROM webfiles ORDER BY id DESC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $title = $row["title"];
                            $max_length = 50;
                            $niche = $row["niche"];
                            $path = $row["resource_path"];
                            $date = $row["date_added"];
                            $dateTime = new DateTime($date);
                            $day = $dateTime->format('j');
                            $month = $dateTime->format('M');
                            $year = $dateTime->format('Y');
                            $ordinalSuffix = getOrdinalSuffix($day);
                            $formattedDate = $month . ' ' . $day . $ordinalSuffix . ', ' . $year;
                            if (containsFilesPath($path)) {
                                $path = '../' . $path;
                            }
                            if (strlen($title) > $max_length) {
                                $title = substr($title, 0, $max_length) . '...';
                            }
                            echo "  <a class='more_posts_subdiv'>
                                            <img src='../images/resurces_img.png' alt='Resource Image' />
                                            <div class='more_posts_subdiv_subdiv'>
                                                <h1>$title</h1>
                                                <span>$formattedDate</span>
                                            </div>
                                            <div class='view_whitepaper'>
                                                <div class='posts_btn' onclick=\"window.location.href='$path'\" target='_blank'>
                                                    <i class='fa fa-eye' aria-hidden='true'></i>
                                                </div>
                                            </div>
                                            <p class='posts_div_niche'>$niche</p>
                                </a>";
                        }
                    } else {
                        echo "<p>No Webfiles Uploaded Yet.</p>";
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
                        <p class="sec2__susbribe-box-p1">Get the latest Updates and Info from Uniquetechcontentwriter on Cybersecurity, Artificial Intelligence and lots more.</p>
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
        <script>
            const closeMenuBtn = document.querySelector('.sidebarbtn');
            const sidebar = document.getElementById('sidebar');
            const menubtn = document.querySelector('.mainheader__header-nav-2');
            var messageType = "<?= $_SESSION['status_type'] ?? ' ' ?>";
            var messageText = "<?= $_SESSION['status'] ?? ' ' ?>";

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
                    fetch("webfiles.php?query=" + encodeURIComponent(query))
                        .then(response => response.text())
                        .then(data => {
                            console.log(data);
                            document.getElementById("results-container").innerHTML = data;
                        })
                        .catch(error => console.error("Error fetching results:", error));
                } else {
                    document.getElementById("search-results").style.display = "none"; // Hide if empty search
                }
            }
        </script>
        <script>
            const Toast = Swal.mixin({
                customClass: {
                    popup: 'rounded-xl shadow-lg',
                    title: 'text-lg font-semibold',
                    confirmButton: 'bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700'
                },
                buttonsStyling: false,
                backdrop: `rgba(0,0,0,0.4)`,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });

            if (messageType && messageText.trim() !== "") {
                let iconColors = {
                    'Error': '#e74c3c',
                    'Success': '#2ecc71',
                    'Info': '#3498db'
                };

                Toast.fire({
                    icon: messageType.toLowerCase(),
                    title: messageText,
                    iconColor: iconColors[messageType] || '#3498db',
                    confirmButtonText: 'Got it'
                });
            }

            <?php unset($_SESSION['status_type']); ?>
            <?php unset($_SESSION['status']); ?>
        </script>
    </body>

    </html>